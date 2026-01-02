<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nim' => fake()->unique()->numerify('2024########'),
            'name' => fake()->name(),
            'password' => Hash::make('password'),
            'role' => 2,
            'is_active' => true,
        ];
    }
}


