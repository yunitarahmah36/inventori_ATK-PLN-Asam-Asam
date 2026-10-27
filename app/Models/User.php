<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public const ROLE_ADMIN = 'Admin';
    public const ROLE_KEUANGAN = 'Keuangan';
    public const ROLE_UMUM = 'Umum';
    public const ROLE_PENGELOLA_BUKU = 'Pengelola Buku';

    public const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_KEUANGAN => 'Keuangan',
        self::ROLE_UMUM => 'Umum',
        self::ROLE_PENGELOLA_BUKU => 'Pengelola Buku',
    ];

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPengelolaBuku(): bool
    {
        return $this->role === self::ROLE_PENGELOLA_BUKU;
    }

    public function isKeuangan(): bool
    {
        return $this->role === self::ROLE_KEUANGAN;
    }

    public function isUmum(): bool
    {
        return $this->role === self::ROLE_UMUM;
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'created_by');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function imports(): HasMany
    {
        return $this->hasMany(Import::class);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'created_by');
    }

    public function handledBookLoans(): HasMany
    {
        return $this->hasMany(BookLoan::class, 'handled_by');
    }
}