<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderProcessingCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $sagaId;
    public array $result;

    public function __construct(string $sagaId, array $result)
    {
        $this->sagaId = $sagaId;
        $this->result = $result;
    }
}