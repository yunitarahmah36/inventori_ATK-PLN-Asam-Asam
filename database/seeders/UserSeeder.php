<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'Admin',
            'email' => 'admin@pln.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Keuangan',
            'username' => 'Keuangan',
            'email' => 'keuangan@pln.com',
            'password' => Hash::make('keuangan123'),
            'role' => 'Keuangan',
        ]);

        User::create([
            'name' => 'Umum',
            'username' => 'Umum',
            'email' => 'umum@pln.com',
            'password' => Hash::make('umum123'),
            'role' => 'Umum',
        ]);
    }
}