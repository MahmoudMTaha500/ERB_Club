<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'reserved_stock',
        'sku',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'reserved_stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'reserved_stock' => 0,
        'status' => 'active'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function inventoryReservations(): HasMany
    {
        return $this->hasMany(InventoryReservation::class);
    }

    /**
     * Get available stock (total stock - reserved stock)
     */
    public function getAvailableStockAttribute(): int
    {
        return max(0, $this->stock - $this->reserved_stock);
    }

    /**
     * Check if product has sufficient stock
     */
    public function hasStock(int $quantity): bool
    {
        return $this->available_stock >= $quantity;
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for products with stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}