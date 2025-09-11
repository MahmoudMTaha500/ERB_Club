<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderProcessingFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $sagaId;
    public string $error;
    public array $result;

    public function __construct(string $sagaId, string $error, array $result)
    {
        $this->sagaId = $sagaId;
        $this->error = $error;
        $this->result = $result;
    }
}