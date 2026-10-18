<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use App\Sdq\ApplicationService;
use App\Sdq\FormOptions;
use App\Sdq\SdqItems;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Notification;

/**
 * Fictional partners, collectors and applications for local development,
 * demos and screenshots. Never run in production.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command?->error('DemoDataSeeder must not run in production.');

            return;
        }
        Notification::fake();
        $service = ApplicationService::make();
        mt_srand(42);

        $partners = [
            ['name' => 'Terre des Hommes', 'prefix' => 'TDH', 'email' => 'partner@example.org', 'first' => 'Rania', 'last' => 'Haddad'],
            ['name' => 'Mouvement Social', 'prefix' => 'MSL', 'email' => 'ms@example.org', 'first' => 'Karim', 'last' => 'Saad'],
            ['name' => 'KAFA', 'prefix' => 'KAF', 'email' => 'kafa@example.org', 'first' => 'Nour', 'last' => 'Khalil'],
            ['name' => 'Danish Refugee Council', 'prefix' => 'DRC', 'email' => 'drc@example.org', 'first' => 'Omar', 'last' => 'Nasser'],
        ];
        $collectorNames = [['Michel', 'Khoury', 'MICH'], ['Layla', 'Fares', 'LAY'], ['Hadi', 'Mansour', 'HAD'], ['Sara', 'Aoun', 'SAR']];
        $governorates = [[1, 3], [6, 12], [9, 4], [10, 20], [11, 24]];

        $first = true;
        foreach ($partners as $i => $p) {
            if (User::where('email', $p['email'])->exists()) {
                continue;
            }
            $partner = Partner::factory()->create(['name' => $p['name'], 'prefix' => $p['prefix'], 'max_app_per_year' => 240]);
            $partner->user->forceFill(['email' => $p['email'], 'password' => 'Partner12345', 'firstname' => $p['first'], 'lastname' => $p['last']])->save();

            foreach (array_slice($collectorNames, 0, 2) as $j => $c) {
                $collector = Collector::factory()->forPartner($partner)->create(['prefix' => $c[2], 'city' => ['Beirut', 'Tripoli', 'Zahle', 'Saida'][($i + $j) % 4]]);
                $email = $first ? 'collector@example.org' : strtolower($c[0]).'.'.strtolower($p['prefix']).'@example.org';
                $first = false;
                $collector->user->forceFill(['email' => $email, 'password' => 'Collector12345', 'firstname' => $c[0], 'lastname' => $c[1]])->save();

                $count = 6 + (($i * 2 + $j) % 5);
                for ($k = 0; $k < $count; $k++) {
                    [$gov, $caza] = $governorates[($i + $j + $k) % count($governorates)];
                    $form = $k % 3 === 0 ? 'Form 12-17' : 'Form 6-11';
                    $application = $service->create($collector->user);
                    $pre = $this->questionnaire($form, $gov, $caza, $partner->name, $collector->name, mt_rand(0, 2), $k);
                    $stage = $k % 7;
                    if ($stage === 0) {
                        $service->savePreTest($application, $pre, false, $collector->user); // draft

                        continue;
                    }
                    $service->savePreTest($application, $pre, true, $collector->user);
                    if ($stage === 1) {
                        continue; // awaiting post-test
                    }
                    $post = $this->questionnaire($form, $gov, $caza, $partner->name, $collector->name, $stage === 4 ? 2 : 0, $k);
                    $post['interview_date'] = '2026-06-'.str_pad((string) (1 + $k % 27), 2, '0', STR_PAD_LEFT);
                    $post['number_of_hours_that_the_child_attended'] = (string) mt_rand(10, 24);
                    $post['total_number_of_hours_in_your_program'] = '24';
                    $post['dropout_reason'] = $stage === 5 ? FormOptions::DROPOUT_REASONS[mt_rand(1, 6)] : FormOptions::DID_NOT_DROP_OUT;
                    if ($stage === 6) {
                        $service->savePostTest($application, $post, false, $collector->user); // draft

                        continue;
                    }
                    $application = $service->savePostTest($application, $post, true, $collector->user);
                    if ($stage === 4) {
                        $service->setDecreaseReason($application, [FormOptions::DECREASE_REASONS[0]], 'The family was displaced during the cycle.', $partner->user);
                    }
                }
            }
        }
        $this->command?->info('Demo data created. Logins: admin@example.org / partner@example.org / collector@example.org');
    }

    private function questionnaire(string $form, int $gov, int $caza, string $agency, string $interviewer, int $bias, int $k): array
    {
        [$min, $max] = FormOptions::ageRange($form);
        $data = [
            'form' => $form,
            'may_i_start_now' => 'yes',
            'category' => FormOptions::CATEGORIES[$k % 3],
            'agency_name' => mb_substr($agency, 0, 50),
            'donor_name' => 'UNICEF',
            'interview_date' => '2026-03-'.str_pad((string) (1 + $k % 27), 2, '0', STR_PAD_LEFT),
            'interviewers_name' => $interviewer,
            'age' => (string) mt_rand($min, $max),
            'gender' => $k % 2 ? 'female' : 'male',
            'nationality' => ['Syrian', 'Lebanese', 'Palestinian'][$k % 3],
            'gouvarnate' => (string) $gov,
            'caza' => (string) $caza,
            'area' => (string) Area::where('caza_id', $caza)->value('id'),
            'gateway_type' => FormOptions::GATEWAY_TYPES[$k % count(FormOptions::GATEWAY_TYPES)],
        ];
        foreach (SdqItems::all() as $item) {
            $value = max(0, min(2, $bias + mt_rand(-1, 1)));
            $data[$item] = (string) $value;
        }

        return $data;
    }
}
