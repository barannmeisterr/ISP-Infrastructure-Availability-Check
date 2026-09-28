<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->where('email', 'admin@issaltyapi.local')->delete();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@issaltyapi.local',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}

