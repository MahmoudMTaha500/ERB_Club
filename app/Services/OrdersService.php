<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersService
{
    /**
     * Create a new order
     */
    public function createOrder(array $orderData): ?int
    {
        try {
            return DB::transaction(function () use ($orderData) {
                $order = Order::create([
                    'user_id' => $orderData['user_id'],
                    'product_id' => $orderData['product_id'],
                    'quantity' => $orderData['quantity'],
                    'amount' => $orderData['amount'],
                    'status' => $orderData['status'] ?? 'pending',
                    'inventory_reservation_id' => $orderData['inventory_reservation_id'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                Log::info("Order created successfully", [
                    'order_id' => $order->id,
                    'user_id' => $orderData['user_id'],
                    'product_id' => $orderData['product_id'],
                    'amount' => $orderData['amount']
                ]);

                return $order->id;
            });
        } catch (\Exception $e) {
            Log::error("Failed to create order: {$e->getMessage()}", $orderData);
            return null;
        }
    }

    /**
     * Confirm an order (mark as confirmed)
     */
    public function confirmOrder(int $orderId): bool
    {
        try {
            return DB::transaction(function () use ($orderId) {
                $order = Order::where('id', $orderId)
                    ->lockForUpdate()
                    ->first();

                if (!$order) {
                    Log::error("Order not found: {$orderId}");
                    return false;
                }

                if ($order->status === 'confirmed') {
                    Log::info("Order already confirmed: {$orderId}");
                    return true;
                }

                if (!in_array($order->status, ['pending', 'processing'])) {
                    Log::error("Cannot confirm order with status: {$order->status}", ['order_id' => $orderId]);
                    return false;
                }

                $order->update([
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                    'updated_at' => now()
                ]);

                Log::info("Order confirmed successfully", [
                    'order_id' => $orderId,
                    'user_id' => $order->user_id
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Failed to confirm order: {$e->getMessage()}", [
                'order_id' => $orderId
            ]);
            return false;
        }
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(int $orderId): bool
    {
        try {
            return DB::transaction(function () use ($orderId) {
                $order = Order::where('id', $orderId)
                    ->lockForUpdate()
                    ->first();

                if (!$order) {
                    Log::error("Order not found: {$orderId}");
                    return false;
                }

                if ($order->status === 'cancelled') {
                    Log::info("Order already cancelled: {$orderId}");
                    return true;
                }

                if ($order->status === 'confirmed') {
                    Log::error("Cannot cancel confirmed order: {$orderId}");
                    return false;
                }

                $order->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                    'updated_at' => now()
                ]);

                Log::info("Order cancelled successfully", [
                    'order_id' => $orderId,
                    'user_id' => $order->user_id
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Failed to cancel order: {$e->getMessage()}", [
                'order_id' => $orderId
            ]);
            return false;
        }
    }

    /**
     * Get order details
     */
    public function getOrder(int $orderId): ?array
    {
        $order = Order::with(['user', 'product'])->find($orderId);
        
        if (!$order) {
            return null;
        }

        return [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'product_id' => $order->product_id,
            'quantity' => $order->quantity,
            'amount' => $order->amount,
            'status' => $order->status,
            'inventory_reservation_id' => $order->inventory_reservation_id,
            'created_at' => $order->created_at,
            'confirmed_at' => $order->confirmed_at,
            'cancelled_at' => $order->cancelled_at,
            'user' => $order->user ? [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email
            ] : null,
            'product' => $order->product ? [
                'id' => $order->product->id,
                'name' => $order->product->name,
                'price' => $order->product->price
            ] : null
        ];
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(int $orderId, string $status): bool
    {
        try {
            return DB::transaction(function () use ($orderId, $status) {
                $order = Order::where('id', $orderId)
                    ->lockForUpdate()
                    ->first();

                if (!$order) {
                    Log::error("Order not found: {$orderId}");
                    return false;
                }

                $order->update([
                    'status' => $status,
                    'updated_at' => now()
                ]);

                Log::info("Order status updated", [
                    'order_id' => $orderId,
                    'new_status' => $status
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Failed to update order status: {$e->getMessage()}", [
                'order_id' => $orderId,
                'status' => $status
            ]);
            return false;
        }
    }

    /**
     * Get orders by user
     */
    public function getUserOrders(int $userId, int $limit = 50): array
    {
        $orders = Order::with(['product'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'product_id' => $order->product_id,
                'quantity' => $order->quantity,
                'amount' => $order->amount,
                'status' => $order->status,
                'created_at' => $order->created_at,
                'product' => $order->product ? [
                    'id' => $order->product->id,
                    'name' => $order->product->name,
                    'price' => $order->product->price
                ] : null
            ];
        })->toArray();
    }
}