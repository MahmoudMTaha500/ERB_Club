<?php

namespace App\Http\Controllers;

use App\Events\OrderProcessingCompleted;
use App\Events\OrderProcessingFailed;
use App\Events\OrderProcessingStarted;
use App\Http\Requests\CreateOrderRequest;
use App\Services\OrderOrchestrator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;

class OrderController extends Controller
{
    private OrderOrchestrator $orderOrchestrator;

    public function __construct(OrderOrchestrator $orderOrchestrator)
    {
        $this->orderOrchestrator = $orderOrchestrator;
    }

    /**
     * Process a new order using Saga pattern
     */
    public function processOrder(CreateOrderRequest $request): JsonResponse
    {
        $orderData = $request->validated();
        $orderData['user_id'] = auth()->id();

        // Dispatch order processing started event
        Event::dispatch(new OrderProcessingStarted('', $orderData));

        // Process the order using saga orchestrator
        $result = $this->orderOrchestrator->processOrder($orderData);

        // Dispatch appropriate completion event
        if ($result['success']) {
            Event::dispatch(new OrderProcessingCompleted($result['saga_id'], $result));
            
            return response()->json([
                'success' => true,
                'message' => 'Order processed successfully',
                'data' => [
                    'saga_id' => $result['saga_id'],
                    'order_id' => $result['data']['order_id'] ?? null,
                    'payment_id' => $result['data']['payment_id'] ?? null,
                    'amount' => $result['data']['amount'] ?? null
                ]
            ], 201);
        } else {
            Event::dispatch(new OrderProcessingFailed(
                $result['saga_id'], 
                'Order processing failed', 
                $result
            ));
            
            return response()->json([
                'success' => false,
                'message' => 'Order processing failed',
                'error' => 'Transaction could not be completed. All changes have been rolled back.',
                'saga_id' => $result['saga_id']
            ], 422);
        }
    }

    /**
     * Get order status by saga ID
     */
    public function getOrderStatus(string $sagaId): JsonResponse
    {
        // In a real application, you would store saga state in database
        // and retrieve it here. For now, we'll return a placeholder response.
        
        return response()->json([
            'saga_id' => $sagaId,
            'status' => 'This would show the actual saga status from database'
        ]);
    }
}