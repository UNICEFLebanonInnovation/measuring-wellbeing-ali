<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use App\Sdq\ApplicationService;
use App\Sdq\ApplicationStatus;
use App\Sdq\Exceptions\WorkflowException;
use App\Sdq\FormOptions;
use App\Sdq\SdqItems;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApplicationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private Partner $partner;

    private User $collector;

    private ApplicationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, StatusSeeder::class]);
        Notification::fake();

        $this->partner = Partner::factory()->create(['prefix' => 'ROB', 'max_app_per_year' => 3]);
        $collector = Collector::factory()->forPartner($this->partner)->create(['prefix' => 'MICH']);
        $this->collector = $collector->user;
        $this->service = ApplicationService::make();
    }

    private function questionnaire(array $overrides = [], string $answer = '1'): array
    {
        $data = [
            'category' => FormOptions::CATEGORIES[0],
            'form' => 'Form 6-11',
            'agency_name' => 'Agency',
            'donor_name' => 'UNICEF',
            'interview_date' => '2026-03-10',
            'interviewers_name' => 'Interviewer',
            'age' => '8',
            'gender' => 'female',
            'nationality' => 'Syrian',
            'gouvarnate' => '1',
            'caza' => '3',
            'area' => '3',
            'gateway_type' => 'School',
            'may_i_start_now' => 'yes',
        ];
        foreach (SdqItems::all() as $item) {
            $data[$item] = $answer;
        }

        return array_merge($data, $overrides);
    }

    public function test_codes_are_generated_server_side_with_year_and_prefixes(): void
    {
        $first = $this->service->create($this->collector);
        $second = $this->service->create($this->collector);

        $year = now()->format('Y');
        $this->assertSame("{$year}-ROB-MICH-1", $first->code);
        $this->assertSame("{$year}-ROB-MICH-2", $second->code);
        $this->assertSame($this->partner->user_id, $first->partner_id);
        $this->assertTrue($first->hasStatus(ApplicationStatus::PreTest));
        $this->assertDatabaseHas('application_log', ['application_id' => $first->id]);
    }

    public function test_create_is_idempotent_for_the_same_client_uuid(): void
    {
        $uuid = '2d6b1b9e-9b3f-4c1e-9b0a-2f4a5d6e7f80';
        $a = $this->service->create($this->collector, $uuid);
        $b = $this->service->create($this->collector, $uuid);

        $this->assertSame($a->id, $b->id);
        $this->assertSame(1, Application::count());
    }

    public function test_partner_quota_is_enforced(): void
    {
        $this->service->create($this->collector);
        $this->service->create($this->collector);
        $this->service->create($this->collector);

        $this->expectException(WorkflowException::class);
        $this->service->create($this->collector);
    }

    public function test_full_flow_pre_test_then_post_test_ends_done_with_scores(): void
    {
        $application = $this->service->create($this->collector);

        $application = $this->service->savePreTest($application, $this->questionnaire(), true, $this->collector);
        $this->assertTrue($application->hasStatus(ApplicationStatus::PostTest));
        $this->assertSame('2026-03-10', $application->pre_test_date->toDateString());
        $this->assertSame(22.0, (float) $application->preTest->score);
        $this->assertSame(5.5, $application->preTest->emotional_scale);

        $post = $this->questionnaire([
            'interview_date' => '2026-06-20',
            'dropout_reason' => FormOptions::DID_NOT_DROP_OUT,
            'number_of_hours_that_the_child_attended' => '20',
            'total_number_of_hours_in_your_program' => '24',
        ], '0');
        $application = $this->service->savePostTest($application, $post, true, $this->collector);

        $this->assertTrue($application->hasStatus(ApplicationStatus::Done));
        $this->assertSame('2026-06-20', $application->post_test_date->toDateString());
        $this->assertSame(2.0, (float) $application->postTest->score);
        $this->assertSame('Increase', $application->change(), 'a lower difficulties score is an improvement');
    }

    public function test_draft_saves_keep_the_application_pending(): void
    {
        $application = $this->service->create($this->collector);
        $application = $this->service->savePreTest($application, $this->questionnaire(), false, $this->collector);

        $this->assertTrue($application->hasStatus(ApplicationStatus::PreTestPending));
        $this->assertNull($application->preTest->score);
        $this->assertNull($application->pre_test_date);
    }

    public function test_more_than_three_na_answers_marks_the_application_na(): void
    {
        $application = $this->service->create($this->collector);
        $data = $this->questionnaire([
            'often_loses_temper' => 'na',
            'often_lies_or_cheats' => 'na',
            'many_fears_easily_scared' => 'na',
            'kind_to_younger_children' => 'na',
        ]);
        $application = $this->service->savePreTest($application, $data, true, $this->collector);

        $this->assertTrue($application->hasStatus(ApplicationStatus::NotApplicable));
        $this->assertSame(4, $application->preTest->na_count);
    }

    public function test_no_consent_records_pre_test_no_permission(): void
    {
        $application = $this->service->create($this->collector);
        $application = $this->service->savePreTest($application, ['may_i_start_now' => 'no', 'form' => 'Form 6-11'], true, $this->collector);

        $this->assertTrue($application->hasStatus(ApplicationStatus::PreTestNoPermission));
    }

    public function test_dropout_reason_moves_the_application_to_dropout(): void
    {
        $application = $this->service->create($this->collector);
        $application = $this->service->savePreTest($application, $this->questionnaire(), true, $this->collector);
        $application = $this->service->savePostTest($application, $this->questionnaire([
            'dropout_reason' => 'Returned to Syria',
        ]), true, $this->collector);

        $this->assertTrue($application->hasStatus(ApplicationStatus::Dropout));
    }

    public function test_submitted_pre_test_cannot_be_edited_again(): void
    {
        $application = $this->service->create($this->collector);
        $application = $this->service->savePreTest($application, $this->questionnaire(), true, $this->collector);

        $this->expectException(WorkflowException::class);
        $this->service->savePreTest($application, $this->questionnaire(), true, $this->collector);
    }

    public function test_readonly_collectors_cannot_create_applications(): void
    {
        $this->collector->forceFill(['is_readonly' => true])->save();

        $this->expectException(WorkflowException::class);
        $this->service->create($this->collector->fresh());
    }

    public function test_visibility_scope_limits_partners_and_collectors_to_their_own_data(): void
    {
        $mine = $this->service->create($this->collector);
        $otherCollector = Collector::factory()->create(['prefix' => 'OTH']);
        $theirs = $this->service->create($otherCollector->user);

        $admin = User::factory()->admin()->create();
        $this->assertSame(2, Application::visibleTo($admin)->count());
        $this->assertSame([$mine->id], Application::visibleTo($this->partner->user)->pluck('id')->all());
        $this->assertSame([$mine->id], Application::visibleTo($this->collector)->pluck('id')->all());
        $this->assertSame([$theirs->id], Application::visibleTo($otherCollector->user)->pluck('id')->all());
    }
}
