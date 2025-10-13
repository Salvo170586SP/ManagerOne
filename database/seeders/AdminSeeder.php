<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'surname' => 'Test',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'type' => 'admin'
        ])->assignRole('admin');
    }
}
