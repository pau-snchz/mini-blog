<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'full_name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('admin'),
                'profile_picture' => null,
                'user_type' => 'admin',
                'remember_token' => null,
            ],
            [
                'username' => 'subscriber',
                'full_name' => 'Subscriber',
                'email' => 'subscriber@email.com',
                'password' => Hash::make('pass'),
                'profile_picture' => null,
                'user_type' => 'subscriber',
                'remember_token' => null,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}