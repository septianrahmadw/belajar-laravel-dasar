<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Utama',
                'email' => 'admin@labbooking.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Septian Rahmad W',
                'email' => 'septian@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Operator Lab',
                'email' => 'operator@labbooking.com',
                'password' => bcrypt('password'),
                'role' => 'operator',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dosen Operator',
                'email' => 'dosen@labbooking.com',
                'password' => bcrypt('password'),
                'role' => 'operator',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}