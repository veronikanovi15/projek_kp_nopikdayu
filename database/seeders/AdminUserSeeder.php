<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email = 'adminnih@gmail.com';

        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'admin',
                'email' => $email,
                'password' => Hash::make('pasword12345'), // Hash password
                'role' => 'admin', // Gunakan role 'admin'
            ]);
        }
    }
}

