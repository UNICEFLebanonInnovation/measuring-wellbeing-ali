<?php

namespace Tests\Feature\Reports;

use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use App\Reports\ReportFilters;
use App\Reports\ReportService;
use App\Sdq\ApplicationService;
use App\Sdq\FormOptions;
use App\Sdq\SdqItems;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    use RefreshDatabase;

    private Partner $partnerA;

    private Partner $partnerB;

    private User $collectorA;

    private User $collectorB;

    private ApplicationService $service;

    private ReportService $reports;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, StatusSeeder::class]);
        Notification::fake();

        $this->partnerA = Partner::factory()->create(['name' => 'Alpha', 'prefix' => 'ALP', 'max_app_per_year' => 0]);
        $this->partnerB = Partner::factory()->create(['name' => 'Beta', 'prefix' => 'BET', 'max_app_per_year' => 0]);
        $this->collectorA = Collector::factory()->forPartner($this->partnerA)->create(['prefix' => 'CA'])->user;
        $this->collectorB = Collector::factory()->forPartner($this->partnerB)->create(['prefix' => 'CB'])->user;
        $this->service = ApplicationService::make();
        $this->reports = new ReportService;

        // Partner A: two improved (pre 1s -> post 0s), one worsened, one dropout, one uncompleted.
        $this->complete($this->collectorA, '1', '0');
        $this->complete($this->collectorA, '1', '0');
        $this->complete($this->collectorA, '0', '1');
        $this->complete($this->collectorA, '1', '0', 'Returned to Syria');
        $this->service->savePreTest($this->service->create($this->collectorA), $this->questionnaire(), true, $this->collectorA);

        // Partner B: one unchanged, one dropout.
        $this->complete($this->collectorB, '1', '1');
        $this->complete($this->collectorB, '1', '0', 'Relocation within Lebanon');
    }

    private function questionnaire(array $overrides = [], string $answer = '1'): array
    {
        $data = [
            'category' => FormOptions::CATEGORIES[0], 'form' => 'Form 6-11', 'agency_name' => 'Agency',
            'donor_name' => 'UNICEF', 'interview_date' => '2026-03-10', 'interviewers_name' => 'Interviewer',
            'age' => '8', 'gender' => 'female', 'nationality' => 'Syrian', 'gouvarnate' => '1', 'caza' => '3',
            'area' => '3', 'gateway_type' => 'School', 'may_i_start_now' => 'yes',
        ];
        foreach (SdqItems::all() as $item) {
            $data[$item] = $answer;
        }

        return array_merge($data, $overrides);
    }

    private function complete(User $collector, string $preAnswer, string $postAnswer, string $dropout = FormOptions::DID_NOT_DROP_OUT): void
    {
        $application = $this->service->create($collector);
        $application = $this->service->savePreTest($application, $this->questionnaire([], $preAnswer), true, $collector);
        $this->service->savePostTest($application, $this->questionnaire([
            'interview_date' => '2026-06-20', 'dropout_reason' => $dropout,
            'number_of_hours_that_the_child_attended' => '20', 'total_number_of_hours_in_your_program' => '24',
        ], $postAnswer), true, $collector);
    }

    private function filters(User $user, array $extra = []): ReportFilters
    {
        return new ReportFilters($user, ...$extra);
    }

    public function test_increase_scale_counts_change_groups_per_partner(): void
    {
        $admin = User::factory()->admin()->create();
        $data = $this->reports->run('increase-scale', $this->filters($admin));

        $rows = collect($data['table']['rows'])->keyBy('partner');
        $this->assertSame(2, $rows['Alpha']['Increase']);
        $this->assertSame(1, $rows['Alpha']['Decrease']);
        $this->assertSame(0, $rows['Alpha']['Same']);
        $this->assertSame(66.7, $rows['Alpha']['percent_increase']);
        $this->assertSame(1, $rows['Beta']['Same']);
        $this->assertSame(4, $data['summary'][0]['value']); // dropouts excluded
        $this->assertSame('50%', $data['summary'][1]['value']);
    }

    public function test_scale_comparison_averages_pre_and_post_scores(): void
    {
        $admin = User::factory()->admin()->create();
        $data = $this->reports->run('scale-comparison', $this->filters($admin));

        $rows = collect($data['table']['rows'])->keyBy('scale');
        // Four Done applications: pre scales 5.5, 5.5, 0.5, 5.5 -> avg 4.25; post 0.5, 0.5, 5.5, 5.5 -> avg 3.0
        $this->assertSame(4.25, $rows['emotional']['pre']);
        $this->assertSame(3.0, $rows['emotional']['post']);
        $this->assertSame(17.0, $rows['total']['pre']);
        $this->assertSame(12.0, $rows['total']['post']);
        $this->assertSame(4, $data['summary'][0]['value']);
    }

    public function test_dropout_reasons_are_counted_overall_and_per_partner(): void
    {
        $admin = User::factory()->admin()->create();
        $data = $this->reports->run('dropout-reasons', $this->filters($admin));

        $this->assertSame(2, $data['summary'][0]['value']);
        $rows = collect($data['table']['rows'])->keyBy('reason');
        $this->assertSame(1, $rows['Returned to Syria']['total']);
        $this->assertSame(50.0, $rows['Returned to Syria']['percent']);
        $perPartner = collect($data['secondaryTable']['rows'])->keyBy('partner');
        $this->assertSame(1, $perPartner['Alpha']['Returned to Syria']);
        $this->assertSame(1, $perPartner['Beta']['Relocation within Lebanon']);
    }

    public function test_uncompleted_per_partner_lists_applications_without_post_test(): void
    {
        $admin = User::factory()->admin()->create();
        $data = $this->reports->run('uncompleted-per-partner', $this->filters($admin));

        $this->assertSame(1, $data['summary'][0]['value']);
        $this->assertSame([['partner' => 'Alpha', 'total' => 1]], $data['table']['rows']);

        // A partner sees the breakdown per collector.
        $own = $this->reports->run('uncompleted-per-partner', $this->filters($this->partnerA->user));
        $this->assertSame(1, $own['summary'][0]['value']);
        $this->assertSame($this->collectorA->name, $own['table']['rows'][0]['collector']);
    }

    public function test_partners_only_see_their_own_data(): void
    {
        $data = $this->reports->run('increase-scale', $this->filters($this->partnerB->user, ['partner' => $this->partnerA->user_id]));

        $this->assertSame(['Beta'], array_column($data['table']['rows'], 'partner'));
        $this->assertSame(1, $data['summary'][0]['value']);

        $dataset = $this->reports->run('analysis-data', $this->filters($this->partnerB->user));
        $this->assertSame(1, $dataset['paginator']->total());
        $this->assertSame('same', $dataset['paginator']->items()[0]['change']);
    }

    public function test_governorate_and_change_analysis_and_partner_analysis_run(): void
    {
        $admin = User::factory()->admin()->create();
        $gov = $this->reports->run('governorate-analysis', $this->filters($admin));
        $this->assertSame(4, $gov['table']['rows'][0]['total']);
        $this->assertSame(2, $gov['table']['rows'][0]['Increase']);
        $this->assertSame(4, $gov['table']['rows'][0]['female']);

        $change = $this->reports->run('change-analysis', $this->filters($admin));
        $increase = collect($change['table']['rows'])->firstWhere('group', 'increase');
        $this->assertSame(2, $increase['count']);
        $this->assertSame(22.0, $increase['pre_total']);
        $this->assertSame(2.0, $increase['post_total']);

        $partner = $this->reports->run('partner-analysis', $this->filters($admin, ['form' => 'Form 6-11']));
        $this->assertSame(3, collect($partner['table']['rows'])->firstWhere('partner', 'Alpha')['total']);
    }

    public function test_pages_render_and_csv_downloads(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/reports')->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Reports/Index')->has('reports', 8));

        $this->actingAs($admin)->get('/reports/increase-scale?gender=female')->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Reports/Show')->where('slug', 'increase-scale')->has('data.table.rows', 2));

        $this->actingAs($admin)->get('/reports/does-not-exist')->assertNotFound();

        $response = $this->actingAs($admin)->get('/reports/analysis-data?format=csv');
        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));

        $this->actingAs($admin)->get('/activity-log?code=ALP')->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Reports/ActivityLog')->has('logs.data'));

        // Collectors have no access to analytics.
        $this->actingAs($this->collectorA)->get('/reports')->assertForbidden();
    }
}
