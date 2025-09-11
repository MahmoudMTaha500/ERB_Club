<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Services\OrderOrchestrator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DemoController extends Controller
{
    private OrderOrchestrator $orderOrchestrator;

    public function __construct(OrderOrchestrator $orderOrchestrator)
    {
        $this->orderOrchestrator = $orderOrchestrator;
    }

    /**
     * Setup demo data
     */
    public function setupDemo(): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Create demo products
            $products = [
                [
                    'name' => 'Laptop',
                    'description' => 'Gaming Laptop',
                    'price' => 1500.00,
                    'stock' => 5,
                    'sku' => 'LAPTOP-001'
                ],
                [
                    'name' => 'Mouse',
                    'description' => 'Gaming Mouse',
                    'price' => 50.00,
                    'stock' => 20,
                    'sku' => 'MOUSE-001'
                ],
                [
                    'name' => 'Keyboard',
                    'description' => 'Mechanical Keyboard',
                    'price' => 100.00,
                    'stock' => 2, // Low stock for testing
                    'sku' => 'KEYBOARD-001'
                ]
            ];

            foreach ($products as $productData) {
                Product::updateOrCreate(
                    ['sku' => $productData['sku']],
                    $productData
                );
            }

            // Create demo user
            $user = User::updateOrCreate(
                ['email' => 'demo@example.com'],
                [
                    'name' => 'Demo User',
                    'email' => 'demo@example.com',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now()
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Demo data setup completed',
                'data' => [
                    'products' => Product::all(),
                    'user' => $user
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to setup demo data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Demo successful order processing
     */
    public function demoSuccessfulOrder(): JsonResponse
    {
        $product = Product::where('sku', 'MOUSE-001')->first();
        $user = User::where('email', 'demo@example.com')->first();

        if (!$product || !$user) {
            return response()->json([
                'error' => 'Demo data not found. Please run /demo/setup first'
            ], 404);
        }

        $orderData = [
            'product_id' => $product->id,
            'quantity' => 2,
            'user_id' => $user->id,
            'amount' => $product->price * 2,
            'payment_method' => 'credit_card'
        ];

        Log::info('Demo: Starting successful order processing', $orderData);

        $result = $this->orderOrchestrator->processOrder($orderData);

        return response()->json([
            'demo' => 'Successful Order Processing',
            'result' => $result,
            'explanation' => [
                'step_1' => 'Reserved inventory successfully',
                'step_2' => 'Created order successfully',
                'step_3' => 'Processed payment successfully',
                'step_4' => 'Committed inventory reservation',
                'step_5' => 'Confirmed order',
                'outcome' => 'All steps completed successfully - atomic transaction achieved'
            ]
        ]);
    }

    /**
     * Demo failed order processing (insufficient stock)
     */
    public function demoFailedOrder(): JsonResponse
    {
        $product = Product::where('sku', 'KEYBOARD-001')->first();
        $user = User::where('email', 'demo@example.com')->first();

        if (!$product || !$user) {
            return response()->json([
                'error' => 'Demo data not found. Please run /demo/setup first'
            ], 404);
        }

        $orderData = [
            'product_id' => $product->id,
            'quantity' => 10, // More than available stock (2)
            'user_id' => $user->id,
            'amount' => $product->price * 10,
            'payment_method' => 'credit_card'
        ];

        Log::info('Demo: Starting failed order processing (insufficient stock)', $orderData);

        $result = $this->orderOrchestrator->processOrder($orderData);

        return response()->json([
            'demo' => 'Failed Order Processing - Insufficient Stock',
            'result' => $result,
            'explanation' => [
                'step_1' => 'Failed to reserve inventory (insufficient stock)',
                'compensation' => 'No compensation needed as first step failed',
                'outcome' => 'Transaction failed safely - no partial state changes'
            ]
        ]);
    }

    /**
     * Get current system status
     */
    public function getSystemStatus(): JsonResponse
    {
        $products = Product::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
                'available_stock' => $product->stock,
                'reserved_stock' => $product->reserved_stock ?? 0,
                'total_stock' => $product->stock + ($product->reserved_stock ?? 0)
            ];
        });

        return response()->json([
            'system_status' => 'Active',
            'saga_pattern' => 'Implemented',
            'products' => $products,
            'features' => [
                'atomic_transactions' => 'Implemented via Saga Pattern',
                'inventory_reservation' => 'Active',
                'payment_processing' => 'Mock Gateway (Simulated)',
                'compensation_actions' => 'Automatic Rollback',
                'event_system' => 'Configured',
                'distributed_services' => 'Simulated (3 services: Inventory, Orders, Payments)'
            ]
        ]);
    }
}