<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $email = 'userbiasa@gmail.com';

        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'userbiasa',
                'email' => $email,
                'password' => Hash::make('userpassword123'),
                'role' => 'user', // Gunakan role 'user'
            ]);
        }
    }
}

