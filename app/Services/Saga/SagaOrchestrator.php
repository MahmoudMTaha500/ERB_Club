<?php

namespace App\Services\Saga;

use App\Services\Saga\Events\SagaStepCompleted;
use App\Services\Saga\Events\SagaStepFailed;
use App\Services\Saga\Exceptions\SagaException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SagaOrchestrator
{
    private string $sagaId;
    private array $steps = [];
    private array $completedSteps = [];
    private array $compensationActions = [];
    private array $sagaData = [];
    private string $status = 'pending';

    public function __construct()
    {
        $this->sagaId = Str::uuid()->toString();
    }

    public function getSagaId(): string
    {
        return $this->sagaId;
    }

    public function addStep(string $stepName, callable $action, callable $compensation = null): self
    {
        $this->steps[] = [
            'name' => $stepName,
            'action' => $action,
            'compensation' => $compensation
        ];

        return $this;
    }

    public function setData(array $data): self
    {
        $this->sagaData = $data;
        return $this;
    }

    public function getData(): array
    {
        return $this->sagaData;
    }

    public function updateData(array $data): self
    {
        $this->sagaData = array_merge($this->sagaData, $data);
        return $this;
    }

    public function execute(): bool
    {
        Log::info("Starting Saga {$this->sagaId}");
        $this->status = 'running';

        try {
            foreach ($this->steps as $index => $step) {
                Log::info("Executing step: {$step['name']} for Saga {$this->sagaId}");
                
                // Execute the step
                $result = call_user_func($step['action'], $this->sagaData, $this);
                
                if ($result === false) {
                    throw new SagaException("Step {$step['name']} failed");
                }

                // Mark step as completed
                $this->completedSteps[] = $index;
                
                // Store compensation action if provided
                if ($step['compensation']) {
                    $this->compensationActions[$index] = $step['compensation'];
                }

                Event::dispatch(new SagaStepCompleted($this->sagaId, $step['name'], $this->sagaData));
            }

            $this->status = 'completed';
            Log::info("Saga {$this->sagaId} completed successfully");
            return true;

        } catch (\Exception $e) {
            Log::error("Saga {$this->sagaId} failed: {$e->getMessage()}");
            $this->status = 'failed';
            
            Event::dispatch(new SagaStepFailed($this->sagaId, $e->getMessage(), $this->sagaData));
            
            // Execute compensation actions
            $this->compensate();
            
            return false;
        }
    }

    private function compensate(): void
    {
        Log::info("Starting compensation for Saga {$this->sagaId}");
        
        // Execute compensation actions in reverse order
        $reversedSteps = array_reverse($this->completedSteps, true);
        
        foreach ($reversedSteps as $stepIndex) {
            if (isset($this->compensationActions[$stepIndex])) {
                $stepName = $this->steps[$stepIndex]['name'];
                Log::info("Compensating step: {$stepName} for Saga {$this->sagaId}");
                
                try {
                    call_user_func($this->compensationActions[$stepIndex], $this->sagaData, $this);
                } catch (\Exception $e) {
                    Log::error("Compensation failed for step {$stepName} in Saga {$this->sagaId}: {$e->getMessage()}");
                }
            }
        }
        
        $this->status = 'compensated';
        Log::info("Compensation completed for Saga {$this->sagaId}");
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCompletedSteps(): array
    {
        return $this->completedSteps;
    }
}