<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'owner@luxesole.com'],
            [
                'name' => 'Owner Luxesole',
                'password' => Hash::make('password'),
                'role' => 'owner'
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@luxesole.com'],
            [
                'name' => 'Kasir Luxesole',
                'password' => Hash::make('password'),
                'role' => 'kasir'
            ]
        );
    }
}
