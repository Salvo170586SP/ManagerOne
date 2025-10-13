<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PMSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pm',
            'surname' => 'Test',
            'email' => 'pm@test.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'type' => 'project_manager'
        ])->assignRole('project_manager');
    }
}
