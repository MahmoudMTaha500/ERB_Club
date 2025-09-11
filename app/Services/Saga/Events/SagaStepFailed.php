<?php

namespace App\Services\Saga\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SagaStepFailed
{
    use Dispatchable, SerializesModels;

    public string $sagaId;
    public string $error;
    public array $sagaData;

    public function __construct(string $sagaId, string $error, array $sagaData)
    {
        $this->sagaId = $sagaId;
        $this->error = $error;
        $this->sagaData = $sagaData;
    }
}