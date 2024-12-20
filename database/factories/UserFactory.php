<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => fake()->name(),
            'lastName' => fake()->name(),
            'maritalStatus' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->numberBetween(1000000000, 9999999999),
            'street' => fake()->city,
            'district' => fake()->city,
            'region' => fake()->city,
            'age' => fake()->numberBetween(18, 65),
            'basicSalary' => fake()->randomFloat(2, 300000, 1000000),
            'bankAccountHolder' => fake()->name,
            'bankAccountNumber' => fake()->numberBetween(300000, 1000000),
            'bankName' => fake()->company,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
