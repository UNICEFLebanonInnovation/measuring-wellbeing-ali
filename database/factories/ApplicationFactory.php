<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Collector;
use App\Models\Status;
use App\Sdq\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Application> */
class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'collector_id' => function () {
                $collector = Collector::factory()->create();

                return $collector->user_id;
            },
            'partner_id' => fn (array $attributes) => Collector::where('user_id', $attributes['collector_id'])->value('partner_id'),
            'code' => fn (array $attributes) => '2026-TEST-'.$attributes['collector_id'].'-'.fake()->unique()->numberBetween(1, 100000),
            'year' => 2026,
            'status' => fn () => Status::idOf(ApplicationStatus::PreTest),
        ];
    }

    public function status(ApplicationStatus $status): static
    {
        return $this->state(fn () => ['status' => Status::idOf($status)]);
    }
}
