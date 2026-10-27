<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_code',
        'title',
        'author',
        'publisher',
        'year',
        'category',
        'total_stock',
        'available_stock',
        'shelf_location',
        'description',
        'created_by',
    ];

    protected $casts = [
        'total_stock' => 'integer',
        'available_stock' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }

    public function activeLoans(): HasMany
    {
        return $this->hasMany(BookLoan::class)->whereIn('status', ['Dipinjam', 'Terlambat']);
    }

    public function isAvailable(): bool
    {
        return $this->available_stock > 0;
    }

    public function getBorrowedStockAttribute(): int
    {
        return max(0, $this->total_stock - $this->available_stock);
    }
}
