<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InventoryService
{
    /**
     * Reserve stock for a product
     * Returns reservation ID on success, false on failure
     */
    public function reserveStock(int $productId, int $quantity): ?string
    {
        try {
            return DB::transaction(function () use ($productId, $quantity) {
                // Lock the product row to prevent concurrent modifications
                $product = Product::where('id', $productId)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    Log::error("Product not found: {$productId}");
                    return null;
                }

                if ($product->stock < $quantity) {
                    Log::error("Insufficient stock for product {$productId}. Available: {$product->stock}, Required: {$quantity}");
                    return null;
                }

                // Create reservation
                $reservationId = Str::uuid()->toString();
                
                $reservation = InventoryReservation::create([
                    'id' => $reservationId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'status' => 'reserved',
                    'expires_at' => now()->addMinutes(15), // Reservation expires in 15 minutes
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Reduce available stock (reserved stock)
                $product->decrement('stock', $quantity);
                $product->increment('reserved_stock', $quantity);

                Log::info("Stock reserved successfully", [
                    'reservation_id' => $reservationId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'remaining_stock' => $product->fresh()->stock
                ]);

                return $reservationId;
            });
        } catch (\Exception $e) {
            Log::error("Failed to reserve stock: {$e->getMessage()}", [
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
            return null;
        }
    }

    /**
     * Commit a reservation (finalize the stock reduction)
     */
    public function commitReservation(string $reservationId): bool
    {
        try {
            return DB::transaction(function () use ($reservationId) {
                $reservation = InventoryReservation::where('id', $reservationId)
                    ->lockForUpdate()
                    ->first();

                if (!$reservation) {
                    Log::error("Reservation not found: {$reservationId}");
                    return false;
                }

                if ($reservation->status !== 'reserved') {
                    Log::error("Reservation already processed: {$reservationId}, Status: {$reservation->status}");
                    return false;
                }

                // Update reservation status
                $reservation->update([
                    'status' => 'committed',
                    'updated_at' => now()
                ]);

                // Update product - remove from reserved stock (stock already reduced in reserve step)
                $product = Product::where('id', $reservation->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->decrement('reserved_stock', $reservation->quantity);
                }

                Log::info("Reservation committed successfully", [
                    'reservation_id' => $reservationId,
                    'product_id' => $reservation->product_id,
                    'quantity' => $reservation->quantity
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Failed to commit reservation: {$e->getMessage()}", [
                'reservation_id' => $reservationId
            ]);
            return false;
        }
    }

    /**
     * Release a reservation (rollback the stock reduction)
     */
    public function releaseReservation(string $reservationId): bool
    {
        try {
            return DB::transaction(function () use ($reservationId) {
                $reservation = InventoryReservation::where('id', $reservationId)
                    ->lockForUpdate()
                    ->first();

                if (!$reservation) {
                    Log::error("Reservation not found: {$reservationId}");
                    return false;
                }

                if ($reservation->status !== 'reserved') {
                    Log::warning("Reservation already processed: {$reservationId}, Status: {$reservation->status}");
                    return true; // Consider it successful if already processed
                }

                // Update reservation status
                $reservation->update([
                    'status' => 'released',
                    'updated_at' => now()
                ]);

                // Restore stock
                $product = Product::where('id', $reservation->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->increment('stock', $reservation->quantity);
                    $product->decrement('reserved_stock', $reservation->quantity);
                }

                Log::info("Reservation released successfully", [
                    'reservation_id' => $reservationId,
                    'product_id' => $reservation->product_id,
                    'quantity' => $reservation->quantity
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Failed to release reservation: {$e->getMessage()}", [
                'reservation_id' => $reservationId
            ]);
            return false;
        }
    }

    /**
     * Get current stock for a product
     */
    public function getStock(int $productId): array
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return [
                'available_stock' => 0,
                'reserved_stock' => 0,
                'total_stock' => 0
            ];
        }

        return [
            'available_stock' => $product->stock,
            'reserved_stock' => $product->reserved_stock ?? 0,
            'total_stock' => $product->stock + ($product->reserved_stock ?? 0)
        ];
    }

    /**
     * Clean up expired reservations
     */
    public function cleanupExpiredReservations(): int
    {
        $expiredReservations = InventoryReservation::where('status', 'reserved')
            ->where('expires_at', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredReservations as $reservation) {
            if ($this->releaseReservation($reservation->id)) {
                $count++;
            }
        }

        Log::info("Cleaned up {$count} expired reservations");
        return $count;
    }
}