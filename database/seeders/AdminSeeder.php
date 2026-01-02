<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nim' => 'ADMIN001',
            'name' => 'Super Admin',
            'password' => Hash::make('admin123'),
            'role' => 1,
            'is_active' => true,
        ]);

        User::factory()->count(5)->create();
    }
}
