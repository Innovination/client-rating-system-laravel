<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'remember_token' => null,
                'mobile' => '',
                'user_type' => 'admin',
                'role' => 'admin',
                'status' => 'active',
                'verification_status' => true,
                'email_verified_at' => now(),
                // 'otp'            => '',
            ],
        ];

        User::insert($users);
    }
}
