<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat atau memperbarui akun Admin resmi Whimsybooth
        User::updateOrCreate(
            ['email' => 'whimsybooth@gmail.com'],
            [
                'name' => 'Admin Whimsybooth',
                'password' => Hash::make('whimsybooth1'),
                'role' => 'admin',
            ]
        );
    }
}