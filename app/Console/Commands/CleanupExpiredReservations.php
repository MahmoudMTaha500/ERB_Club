<?php

namespace App\Console\Commands;

use App\Services\InventoryService;
use Illuminate\Console\Command;

class CleanupExpiredReservations extends Command
{
    protected $signature = 'inventory:cleanup-expired';
    protected $description = 'Clean up expired inventory reservations';

    private InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        parent::__construct();
        $this->inventoryService = $inventoryService;
    }

    public function handle(): int
    {
        $this->info('Starting cleanup of expired inventory reservations...');
        
        $cleanedCount = $this->inventoryService->cleanupExpiredReservations();
        
        $this->info("Cleaned up {$cleanedCount} expired reservations.");
        
        return Command::SUCCESS;
    }
}