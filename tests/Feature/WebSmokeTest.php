<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use App\Sdq\ApplicationService;
use App\Sdq\SdqItems;
use Database\Seeders\LocationSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class WebSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, StatusSeeder::class, LocationSeeder::class]);
    }

    public function test_login_page_renders(): void
    {
        $this->get('/login')->assertOk()->assertInertia(fn (Assert $page) => $page->component('Auth/Login'));
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_admin_can_log_in_and_see_the_dashboard(): void
    {
        $admin = User::factory()->admin()->create(['password' => 'secret123']);

        $this->post('/login', ['email' => $admin->email, 'password' => 'secret123'])->assertRedirect('/dashboard');
        $this->actingAs($admin)->get('/dashboard')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Dashboard/Index')->has('partners')->has('totals'));
    }

    public function test_inactive_users_cannot_log_in(): void
    {
        $user = User::factory()->admin()->inactive()->create(['password' => 'secret123']);

        $this->post('/login', ['email' => $user->email, 'password' => 'secret123'])->assertSessionHasErrors('email');
    }

    public function test_collector_creates_an_application_and_opens_the_pre_test_form(): void
    {
        $partner = Partner::factory()->create(['prefix' => 'ROB']);
        $collector = Collector::factory()->forPartner($partner)->create(['prefix' => 'MICH'])->user;

        $this->actingAs($collector)->post('/applications')->assertRedirect();
        $application = Application::first();
        $this->assertStringEndsWith('-ROB-MICH-1', $application->code);

        $this->actingAs($collector)->get("/applications/{$application->id}/pre-test")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Applications/TestForm')->where('type', 'pre_test'));
    }

    public function test_partner_cannot_see_another_partners_application(): void
    {
        $partnerA = Partner::factory()->create();
        $partnerB = Partner::factory()->create();
        $collectorB = Collector::factory()->forPartner($partnerB)->create()->user;
        $application = ApplicationService::make()->create($collectorB);

        $this->actingAs($partnerA->user)->get("/applications/{$application->id}")->assertForbidden();
        $this->actingAs($partnerB->user)->get("/applications/{$application->id}")->assertOk();
    }

    public function test_application_list_renders_with_many_applications_and_filters(): void
    {
        $partner = Partner::factory()->create(['prefix' => 'ROB']);
        $collector = Collector::factory()->forPartner($partner)->create(['prefix' => 'MICH'])->user;
        $service = ApplicationService::make();
        foreach (range(1, 3) as $i) {
            $application = $service->create($collector);
            $service->savePreTest($application, $this->questionnaire(), true, $collector);
        }

        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)->get('/applications?governorate=1&sort=code&dir=asc')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Applications/Index')
                ->has('applications.data', 3)
                ->where('applications.data.0.governorate', 'Akkar'));
        $this->actingAs($collector)->get('/applications')->assertOk();
        $this->actingAs($admin)->get('/change-decrease')->assertOk();
        $this->actingAs($admin)->get('/dashboard')->assertOk();
    }

    private function questionnaire(): array
    {
        $data = [
            'category' => 'Other', 'form' => 'Form 6-11', 'agency_name' => 'Agency', 'donor_name' => 'UNICEF',
            'interview_date' => '2026-03-10', 'interviewers_name' => 'Interviewer', 'age' => '8', 'gender' => 'female',
            'nationality' => 'Syrian', 'gouvarnate' => '1', 'caza' => '3', 'area' => '3', 'gateway_type' => 'School',
            'may_i_start_now' => 'yes',
        ];
        foreach (SdqItems::all() as $item) {
            $data[$item] = '1';
        }

        return $data;
    }

    public function test_locale_switch_persists_in_session(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)->get('/locale/ar')->assertRedirect();
        $this->actingAs($admin)->get('/dashboard')->assertInertia(fn (Assert $page) => $page->where('locale', 'ar'));
    }

    public function test_csv_export_streams_a_file_for_admins(): void
    {
        $admin = User::factory()->admin()->create();
        $response = $this->actingAs($admin)->get('/applications-export');
        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));
    }
}
