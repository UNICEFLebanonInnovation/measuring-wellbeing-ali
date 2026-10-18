<?php

namespace Database\Factories;

use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Collector> */
class CollectorFactory extends Factory
{
    protected $model = Collector::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->afterCreating(fn (User $u) => $u->assignRole(User::ROLE_COLLECTOR)),
            'partner_id' => fn () => Partner::factory()->create()->user_id,
            'name' => fake()->name(),
            'prefix' => strtoupper(fake()->unique()->lexify('????')),
            'city' => fake()->city(),
            'is_subpartner' => false,
        ];
    }

    public function forPartner(Partner $partner): static
    {
        return $this->state(fn () => ['partner_id' => $partner->user_id]);
    }
}
