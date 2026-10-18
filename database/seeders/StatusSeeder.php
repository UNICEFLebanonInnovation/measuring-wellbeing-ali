<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\Status;
use App\Sdq\ApplicationStatus;
use App\Sdq\FormOptions;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        // The legacy ids (2..8) are preserved for the states that existed in
        // the 2020 seed; the others are matched by name only.
        $legacyIds = [
            ApplicationStatus::PreTest->value => 2,
            ApplicationStatus::PreTestPending->value => 3,
            ApplicationStatus::PreTestCompleted->value => 4,
            ApplicationStatus::PostTest->value => 5,
            ApplicationStatus::PostTestPending->value => 6,
            ApplicationStatus::PostTestCompleted->value => 7,
            ApplicationStatus::Done->value => 8,
            ApplicationStatus::Dropout->value => 9,
        ];

        foreach (ApplicationStatus::cases() as $status) {
            if (Status::where('name', $status->value)->exists()) {
                continue;
            }
            $attributes = ['name' => $status->value];
            if (isset($legacyIds[$status->value]) && ! Status::whereKey($legacyIds[$status->value])->exists()) {
                $attributes['id'] = $legacyIds[$status->value];
            }
            Status::create($attributes);
        }
        Status::flushLookup();

        foreach (FormOptions::FORMS as $form) {
            Form::firstOrCreate(['name' => $form]);
        }
    }
}
