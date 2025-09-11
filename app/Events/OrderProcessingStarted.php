<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderProcessingStarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $sagaId;
    public array $orderData;

    public function __construct(string $sagaId, array $orderData)
    {
        $this->sagaId = $sagaId;
        $this->orderData = $orderData;
    }
}