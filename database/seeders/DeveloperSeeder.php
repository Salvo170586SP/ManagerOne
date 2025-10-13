<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeveloperSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Dev',
            'surname' => 'Test',
            'email' => 'dev@test.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'type' => 'developer'
        ])->assignRole('developer');
    }
}
