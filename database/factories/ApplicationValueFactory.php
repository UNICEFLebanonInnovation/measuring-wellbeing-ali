<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ApplicationValue;
use App\Sdq\FormOptions;
use App\Sdq\SdqItems;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ApplicationValue> */
class ApplicationValueFactory extends Factory
{
    protected $model = ApplicationValue::class;

    public function definition(): array
    {
        $answers = [];
        foreach (SdqItems::all() as $item) {
            $answers[$item] = (string) fake()->numberBetween(0, 2);
        }

        return array_merge([
            'application_id' => Application::factory(),
            'type' => ApplicationValue::PRE_TEST,
            'category' => FormOptions::CATEGORIES[0],
            'form' => 'Form 6-11',
            'agency_name' => 'Test agency',
            'donor_name' => 'UNICEF',
            'interview_date' => now()->toDateString(),
            'interviewers_name' => fake()->name(),
            'age' => (string) fake()->numberBetween(6, 11),
            'gender' => fake()->randomElement(FormOptions::GENDERS),
            'nationality' => 'Syrian',
            'gouvarnate' => '1',
            'caza' => '3',
            'area' => '3',
            'gateway_type' => 'School',
            'may_i_start_now' => 'yes',
        ], $answers);
    }

    public function postTest(): static
    {
        return $this->state(fn () => [
            'type' => ApplicationValue::POST_TEST,
            'dropout_reason' => FormOptions::DID_NOT_DROP_OUT,
            'number_of_hours_that_the_child_attended' => '20',
            'total_number_of_hours_in_your_program' => '24',
        ]);
    }
}
