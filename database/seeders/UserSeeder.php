<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'Admin',
                'email' => 'admin.inventoripln@gmail.com',
                'password' => 'admin#31095',
                'role' => 'Admin',
            ],
            [
                'name' => 'Keuangan',
                'username' => 'Keuangan',
                'email' => 'finance.inventori@gmail.com',
                'password' => 'keuangan#31095',
                'role' => 'Keuangan',
            ],
            [
                'name' => 'Umum',
                'username' => 'Umum',
                'email' => 'general.inventoripln@gmail.com',
                'password' => 'general#31095',
                'role' => 'Umum',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                ]
            );
        }
    }
}
