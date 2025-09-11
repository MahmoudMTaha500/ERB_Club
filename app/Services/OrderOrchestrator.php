<?php

namespace App\Services;

use App\Services\Saga\SagaOrchestrator;
use App\Services\InventoryService;
use App\Services\OrdersService;
use App\Services\PaymentsService;
use Illuminate\Support\Facades\Log;

class OrderOrchestrator
{
    private InventoryService $inventoryService;
    private OrdersService $ordersService;
    private PaymentsService $paymentsService;

    public function __construct(
        InventoryService $inventoryService,
        OrdersService $ordersService,
        PaymentsService $paymentsService
    ) {
        $this->inventoryService = $inventoryService;
        $this->ordersService = $ordersService;
        $this->paymentsService = $paymentsService;
    }

    public function processOrder(array $orderData): array
    {
        $saga = new SagaOrchestrator();
        
        // Set initial data
        $saga->setData([
            'product_id' => $orderData['product_id'],
            'quantity' => $orderData['quantity'],
            'user_id' => $orderData['user_id'],
            'amount' => $orderData['amount'],
            'payment_method' => $orderData['payment_method'],
            'inventory_reservation_id' => null,
            'order_id' => null,
            'payment_id' => null,
        ]);

        // Step 1: Reserve inventory
        $saga->addStep(
            'reserve_inventory',
            function ($data, $saga) {
                $reservationId = $this->inventoryService->reserveStock(
                    $data['product_id'],
                    $data['quantity']
                );
                
                if (!$reservationId) {
                    return false;
                }
                
                $saga->updateData(['inventory_reservation_id' => $reservationId]);
                return true;
            },
            function ($data, $saga) {
                // Compensation: Release reserved inventory
                if ($data['inventory_reservation_id']) {
                    $this->inventoryService->releaseReservation($data['inventory_reservation_id']);
                }
            }
        );

        // Step 2: Create order
        $saga->addStep(
            'create_order',
            function ($data, $saga) {
                $orderId = $this->ordersService->createOrder([
                    'user_id' => $data['user_id'],
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'amount' => $data['amount'],
                    'status' => 'pending',
                    'inventory_reservation_id' => $data['inventory_reservation_id']
                ]);
                
                if (!$orderId) {
                    return false;
                }
                
                $saga->updateData(['order_id' => $orderId]);
                return true;
            },
            function ($data, $saga) {
                // Compensation: Cancel order
                if ($data['order_id']) {
                    $this->ordersService->cancelOrder($data['order_id']);
                }
            }
        );

        // Step 3: Process payment
        $saga->addStep(
            'process_payment',
            function ($data, $saga) {
                $paymentId = $this->paymentsService->processPayment([
                    'order_id' => $data['order_id'],
                    'user_id' => $data['user_id'],
                    'amount' => $data['amount'],
                    'payment_method' => $data['payment_method']
                ]);
                
                if (!$paymentId) {
                    return false;
                }
                
                $saga->updateData(['payment_id' => $paymentId]);
                return true;
            },
            function ($data, $saga) {
                // Compensation: Refund payment
                if ($data['payment_id']) {
                    $this->paymentsService->refundPayment($data['payment_id']);
                }
            }
        );

        // Step 4: Confirm inventory commitment
        $saga->addStep(
            'commit_inventory',
            function ($data, $saga) {
                return $this->inventoryService->commitReservation($data['inventory_reservation_id']);
            }
        );

        // Step 5: Confirm order
        $saga->addStep(
            'confirm_order',
            function ($data, $saga) {
                return $this->ordersService->confirmOrder($data['order_id']);
            }
        );

        // Execute the saga
        $success = $saga->execute();
        
        $result = [
            'success' => $success,
            'saga_id' => $saga->getSagaId(),
            'status' => $saga->getStatus(),
            'data' => $saga->getData()
        ];

        if ($success) {
            Log::info("Order processed successfully", $result);
        } else {
            Log::error("Order processing failed", $result);
        }

        return $result;
    }
}