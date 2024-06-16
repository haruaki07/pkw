<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123'),
            'role' => UserRole::Admin
        ]);

        User::factory()->create([
            'name' => 'Operator',
            'email' => 'operator@mail.com',
            'password' => Hash::make('123'),
            'role' => UserRole::Operator
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => Hash::make('123'),
            'role' => UserRole::User
        ]);
    }
}
