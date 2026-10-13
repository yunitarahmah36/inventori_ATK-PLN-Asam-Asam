<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $attributes = [
        'min_stock' => 15,
    ];

    protected $fillable = [
        'material_number',
        'name',
        'entry_date',
        'quantity',
        'min_stock',
        'unit',
        'description',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'quantity'   => 'integer',
        'min_stock'  => 'integer',
        'is_active'  => 'boolean',
    ];

    /**
     * Dapatkan batas minimum stok efektif (default 15 unit jika belum diatur).
     */
    public function getEffectiveMinStockAttribute(): int
    {
        return (int) ($this->min_stock ?? 15);
    }

    /**
     * Periksa apakah stok material saat ini menipis (kurang dari atau sama dengan batas minimum).
     */
    public function isLowStock(): bool
    {
        return (int) $this->quantity <= $this->effective_min_stock;
    }

    /**
     * Label status stok: 'Stok Menipis' jika <= min_stock, 'Stok Aman' jika > min_stock.
     */
    public function getStockStatusAttribute(): string
    {
        return $this->isLowStock() ? 'Stok Menipis' : 'Stok Aman';
    }

    /**
     * Class CSS status stok: 'warning' atau 'success'.
     */
    public function getStockStatusClassAttribute(): string
    {
        return $this->isLowStock() ? 'warning' : 'success';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}