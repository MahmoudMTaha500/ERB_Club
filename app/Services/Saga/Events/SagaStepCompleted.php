<?php

namespace App\Services\Saga\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SagaStepCompleted
{
    use Dispatchable, SerializesModels;

    public string $sagaId;
    public string $stepName;
    public array $sagaData;

    public function __construct(string $sagaId, string $stepName, array $sagaData)
    {
        $this->sagaId = $sagaId;
        $this->stepName = $stepName;
        $this->sagaData = $sagaData;
    }
}