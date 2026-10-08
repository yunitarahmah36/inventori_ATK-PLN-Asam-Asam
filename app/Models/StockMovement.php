<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'user_id',
        'activity',
        'quantity_before',
        'quantity_after',
        'quantity_change',
        'description',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class)->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}