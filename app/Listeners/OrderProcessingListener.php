<?php

namespace App\Listeners;

use App\Events\OrderProcessingCompleted;
use App\Events\OrderProcessingFailed;
use App\Events\OrderProcessingStarted;
use App\Services\Saga\Events\SagaStepCompleted;
use App\Services\Saga\Events\SagaStepFailed;
use Illuminate\Support\Facades\Log;

class OrderProcessingListener
{
    /**
     * Handle order processing started event
     */
    public function handleOrderProcessingStarted(OrderProcessingStarted $event): void
    {
        Log::info("Order processing started", [
            'saga_id' => $event->sagaId,
            'user_id' => $event->orderData['user_id'] ?? null,
            'product_id' => $event->orderData['product_id'] ?? null,
            'amount' => $event->orderData['amount'] ?? null
        ]);

        // Here you could notify other services, send emails, etc.
    }

    /**
     * Handle order processing completed event
     */
    public function handleOrderProcessingCompleted(OrderProcessingCompleted $event): void
    {
        Log::info("Order processing completed successfully", [
            'saga_id' => $event->sagaId,
            'order_id' => $event->result['data']['order_id'] ?? null,
            'payment_id' => $event->result['data']['payment_id'] ?? null
        ]);

        // Here you could:
        // - Send confirmation email to customer
        // - Notify inventory system
        // - Update analytics
        // - Trigger fulfillment process
    }

    /**
     * Handle order processing failed event
     */
    public function handleOrderProcessingFailed(OrderProcessingFailed $event): void
    {
        Log::error("Order processing failed", [
            'saga_id' => $event->sagaId,
            'error' => $event->error,
            'user_id' => $event->result['data']['user_id'] ?? null,
            'product_id' => $event->result['data']['product_id'] ?? null
        ]);

        // Here you could:
        // - Send failure notification to customer
        // - Alert support team
        // - Update metrics
        // - Trigger retry mechanism if appropriate
    }

    /**
     * Handle saga step completed event
     */
    public function handleSagaStepCompleted(SagaStepCompleted $event): void
    {
        Log::info("Saga step completed", [
            'saga_id' => $event->sagaId,
            'step_name' => $event->stepName
        ]);

        // Track step completion for monitoring/analytics
    }

    /**
     * Handle saga step failed event
     */
    public function handleSagaStepFailed(SagaStepFailed $event): void
    {
        Log::error("Saga step failed", [
            'saga_id' => $event->sagaId,
            'error' => $event->error
        ]);

        // Track step failure for monitoring/analytics
    }
}