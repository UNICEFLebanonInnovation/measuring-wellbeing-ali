<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Partner> */
class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->afterCreating(fn (User $u) => $u->assignRole(User::ROLE_PARTNER)),
            'name' => fake()->company(),
            'prefix' => strtoupper(fake()->unique()->lexify('???')),
            'max_app_per_year' => 240,
        ];
    }
}
