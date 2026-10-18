<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<User> */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => 'password',
            'is_active' => true,
            'is_readonly' => false,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    public function readonly(): static
    {
        return $this->state(fn () => ['is_readonly' => true]);
    }

    public function admin(): static
    {
        return $this->afterCreating(fn (User $user) => $user->assignRole(User::ROLE_ADMIN));
    }
}
