<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookLoan extends Model
{
    use HasFactory;

    public const STATUS_DIPINJAM = 'Dipinjam';
    public const STATUS_DIKEMBALIKAN = 'Dikembalikan';
    public const STATUS_TERLAMBAT = 'Terlambat';

    protected $fillable = [
        'loan_code',
        'book_id',
        'borrower_name',
        'borrower_department',
        'borrower_phone',
        'loan_date',
        'due_date',
        'return_date',
        'quantity',
        'status',
        'notes',
        'handled_by',
    ];

    protected $casts = [
        'loan_date'   => 'date',
        'due_date'    => 'date',
        'return_date' => 'date',
        'quantity'    => 'integer',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function isReturned(): bool
    {
        return $this->status === self::STATUS_DIKEMBALIKAN || !is_null($this->return_date);
    }

    public function isOverdue(): bool
    {
        if ($this->isReturned()) {
            return false;
        }

        if ($this->due_date) {
            return Carbon::parse($this->due_date)->isPast() && !Carbon::parse($this->due_date)->isToday();
        }

        return false;
    }

    /**
     * Dapatkan status aktual (evaluasi otomatis jika melewati due date)
     */
    public function getComputedStatusAttribute(): string
    {
        if ($this->isReturned()) {
            return self::STATUS_DIKEMBALIKAN;
        }

        if ($this->isOverdue()) {
            return self::STATUS_TERLAMBAT;
        }

        return self::STATUS_DIPINJAM;
    }
}
