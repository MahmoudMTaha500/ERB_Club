<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentsService
{
    /**
     * Process a payment
     */
    public function processPayment(array $paymentData): ?string
    {
        try {
            return DB::transaction(function () use ($paymentData) {
                $paymentId = Str::uuid()->toString();

                // Simulate payment processing (in real world, this would call external payment gateway)
                $gatewayResponse = $this->simulatePaymentGateway(
                    $paymentData['amount'],
                    $paymentData['payment_method']
                );

                if (!$gatewayResponse['success']) {
                    Log::error("Payment gateway failed", [
                        'payment_data' => $paymentData,
                        'gateway_error' => $gatewayResponse['error']
                    ]);
                    return null;
                }

                $payment = Payment::create([
                    'id' => $paymentId,
                    'order_id' => $paymentData['order_id'],
                    'user_id' => $paymentData['user_id'],
                    'amount' => $paymentData['amount'],
                    'payment_method' => $paymentData['payment_method'],
                    'status' => 'processed',
                    'gateway_transaction_id' => $gatewayResponse['transaction_id'],
                    'gateway_response' => json_encode($gatewayResponse),
                    'processed_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                Log::info("Payment processed successfully", [
                    'payment_id' => $paymentId,
                    'order_id' => $paymentData['order_id'],
                    'amount' => $paymentData['amount'],
                    'gateway_transaction_id' => $gatewayResponse['transaction_id']
                ]);

                return $paymentId;
            });
        } catch (\Exception $e) {
            Log::error("Failed to process payment: {$e->getMessage()}", $paymentData);
            return null;
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment(string $paymentId): bool
    {
        try {
            return DB::transaction(function () use ($paymentId) {
                $payment = Payment::where('id', $paymentId)
                    ->lockForUpdate()
                    ->first();

                if (!$payment) {
                    Log::error("Payment not found: {$paymentId}");
                    return false;
                }

                if ($payment->status === 'refunded') {
                    Log::info("Payment already refunded: {$paymentId}");
                    return true;
                }

                if ($payment->status !== 'processed') {
                    Log::error("Cannot refund payment with status: {$payment->status}", [
                        'payment_id' => $paymentId
                    ]);
                    return false;
                }

                // Simulate refund processing
                $refundResponse = $this->simulateRefundGateway(
                    $payment->gateway_transaction_id,
                    $payment->amount
                );

                if (!$refundResponse['success']) {
                    Log::error("Refund gateway failed", [
                        'payment_id' => $paymentId,
                        'gateway_error' => $refundResponse['error']
                    ]);
                    return false;
                }

                $payment->update([
                    'status' => 'refunded',
                    'refund_transaction_id' => $refundResponse['refund_transaction_id'],
                    'refund_response' => json_encode($refundResponse),
                    'refunded_at' => now(),
                    'updated_at' => now()
                ]);

                Log::info("Payment refunded successfully", [
                    'payment_id' => $paymentId,
                    'refund_transaction_id' => $refundResponse['refund_transaction_id']
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Failed to refund payment: {$e->getMessage()}", [
                'payment_id' => $paymentId
            ]);
            return false;
        }
    }

    /**
     * Confirm a payment (mark as confirmed)
     */
    public function confirmPayment(string $paymentId): bool
    {
        try {
            return DB::transaction(function () use ($paymentId) {
                $payment = Payment::where('id', $paymentId)
                    ->lockForUpdate()
                    ->first();

                if (!$payment) {
                    Log::error("Payment not found: {$paymentId}");
                    return false;
                }

                if ($payment->status === 'confirmed') {
                    Log::info("Payment already confirmed: {$paymentId}");
                    return true;
                }

                if ($payment->status !== 'processed') {
                    Log::error("Cannot confirm payment with status: {$payment->status}", [
                        'payment_id' => $paymentId
                    ]);
                    return false;
                }

                $payment->update([
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                    'updated_at' => now()
                ]);

                Log::info("Payment confirmed successfully", [
                    'payment_id' => $paymentId,
                    'order_id' => $payment->order_id
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Failed to confirm payment: {$e->getMessage()}", [
                'payment_id' => $paymentId
            ]);
            return false;
        }
    }

    /**
     * Get payment details
     */
    public function getPayment(string $paymentId): ?array
    {
        $payment = Payment::with(['order', 'user'])->find($paymentId);
        
        if (!$payment) {
            return null;
        }

        return [
            'id' => $payment->id,
            'order_id' => $payment->order_id,
            'user_id' => $payment->user_id,
            'amount' => $payment->amount,
            'payment_method' => $payment->payment_method,
            'status' => $payment->status,
            'gateway_transaction_id' => $payment->gateway_transaction_id,
            'refund_transaction_id' => $payment->refund_transaction_id,
            'processed_at' => $payment->processed_at,
            'confirmed_at' => $payment->confirmed_at,
            'refunded_at' => $payment->refunded_at,
            'created_at' => $payment->created_at
        ];
    }

    /**
     * Simulate payment gateway processing
     * In real world, this would call external payment service like Stripe, PayPal, etc.
     */
    private function simulatePaymentGateway(float $amount, string $paymentMethod): array
    {
        // Simulate some processing time
        usleep(100000); // 100ms

        // Simulate random failures (5% failure rate)
        if (rand(1, 100) <= 5) {
            return [
                'success' => false,
                'error' => 'Payment gateway error: Insufficient funds'
            ];
        }

        // Simulate successful payment
        return [
            'success' => true,
            'transaction_id' => 'txn_' . Str::random(16),
            'gateway' => 'mock_gateway',
            'amount' => $amount,
            'currency' => 'USD',
            'processed_at' => now()->toISOString()
        ];
    }

    /**
     * Simulate refund gateway processing
     */
    private function simulateRefundGateway(string $originalTransactionId, float $amount): array
    {
        // Simulate some processing time
        usleep(100000); // 100ms

        // Simulate random failures (2% failure rate)
        if (rand(1, 100) <= 2) {
            return [
                'success' => false,
                'error' => 'Refund gateway error: Transaction cannot be refunded'
            ];
        }

        // Simulate successful refund
        return [
            'success' => true,
            'refund_transaction_id' => 'rfnd_' . Str::random(16),
            'original_transaction_id' => $originalTransactionId,
            'amount' => $amount,
            'currency' => 'USD',
            'processed_at' => now()->toISOString()
        ];
    }

    /**
     * Get payments by order
     */
    public function getPaymentsByOrder(int $orderId): array
    {
        $payments = Payment::where('order_id', $orderId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $payments->map(function ($payment) {
            return [
                'id' => $payment->id,
                'amount' => $payment->amount,
                'payment_method' => $payment->payment_method,
                'status' => $payment->status,
                'gateway_transaction_id' => $payment->gateway_transaction_id,
                'processed_at' => $payment->processed_at,
                'confirmed_at' => $payment->confirmed_at,
                'refunded_at' => $payment->refunded_at
            ];
        })->toArray();
    }
}