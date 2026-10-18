<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Caza;
use App\Models\Gouvernate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Lebanon's governorates, cazas and areas with the SAME ids as the legacy
 * database (application_value stores those ids as text, so they must not
 * change). Data extracted from the legacy dump; see database/seeders/data.
 */
class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode(file_get_contents(database_path('seeders/data/locations.json')), true, 512, JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($data) {
            foreach ($data['gouvernate'] as $row) {
                Gouvernate::query()->updateOrCreate(['id' => $row['id']], ['name' => $row['name'], 'arabic' => $row['arabic']]);
            }
            foreach ($data['caza'] as $row) {
                Caza::query()->updateOrCreate(['id' => $row['id']], [
                    'gouvernate_id' => $row['gouvernate_id'], 'name' => $row['name'], 'arabic' => $row['arabic'],
                ]);
            }
            if (Area::count() === 0) {
                $now = now();
                foreach (array_chunk($data['area'], 500) as $chunk) {
                    DB::table('area')->insert(array_map(fn ($row) => [
                        'id' => $row['id'],
                        'caza_id' => $row['caza_id'],
                        'gouvernate_id' => $row['gouvernate_id'],
                        'name' => $row['name'],
                        'arabic' => $row['arabic'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ], $chunk));
                }
            }
        });
    }
}
