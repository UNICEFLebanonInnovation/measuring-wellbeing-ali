<?php

namespace Tests\Feature\Api;

use App\Models\Application;
use App\Models\Area;
use App\Models\Caza;
use App\Models\Collector;
use App\Models\Gouvernate;
use App\Models\Partner;
use App\Models\User;
use App\Sdq\ApplicationStatus;
use App\Sdq\FormOptions;
use App\Sdq\SdqItems;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class V1ApiTest extends TestCase
{
    use RefreshDatabase;

    private Partner $partner;

    private User $collector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, StatusSeeder::class]);
        Notification::fake();
        $this->seedLocations();

        $this->partner = Partner::factory()->create(['prefix' => 'ROB']);
        $this->collector = Collector::factory()->forPartner($this->partner)->create(['prefix' => 'MICH'])->user;
        $this->collector->forceFill(['password' => 'secret123'])->save();
    }

    private function seedLocations(): void
    {
        Gouvernate::forceCreate(['id' => 1, 'name' => 'Akkar', 'arabic' => 'عكار']);
        Caza::forceCreate(['id' => 3, 'gouvernate_id' => 1, 'name' => 'Akkar', 'arabic' => 'عكار']);
        Area::forceCreate(['id' => 3, 'caza_id' => 3, 'gouvernate_id' => 1, 'name' => 'Aadouiye', 'arabic' => 'عدوي']);
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
            'submit' => 'submit',
        ];
        foreach (SdqItems::all() as $item) {
            $data[$item] = $answer;
        }

        return array_merge($data, $overrides);
    }

    public function test_login_returns_token_and_profile(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->collector->email, 'password' => 'secret123', 'device_name' => 'tablet-1',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.roles.0', 'collector')
            ->assertJsonPath('data.user.partner.prefix', 'ROB')
            ->assertJsonPath('data.user.collector.prefix', 'MICH');

        $token = $response->json('data.token');
        $this->assertNotEmpty($token);

        $this->withToken($token)->getJson('/api/v1/auth/me')->assertOk()->assertJsonPath('data.email', $this->collector->email);
        $this->withToken($token)->postJson('/api/v1/auth/logout')->assertOk();
        $this->assertSame(0, $this->collector->tokens()->count());
    }

    public function test_login_rejects_bad_credentials_inactive_and_admin_accounts(): void
    {
        $this->postJson('/api/v1/auth/login', ['email' => $this->collector->email, 'password' => 'nope', 'device_name' => 'x'])->assertStatus(401);

        $this->collector->forceFill(['is_active' => false])->save();
        $this->postJson('/api/v1/auth/login', ['email' => $this->collector->email, 'password' => 'secret123', 'device_name' => 'x'])->assertStatus(401);

        $admin = User::factory()->admin()->create(['password' => 'secret123']);
        $this->postJson('/api/v1/auth/login', ['email' => $admin->email, 'password' => 'secret123', 'device_name' => 'x'])->assertStatus(403);
    }

    public function test_reference_payload_contains_nested_locations_and_supports_etag(): void
    {
        Sanctum::actingAs($this->collector);

        $response = $this->getJson('/api/v1/reference')->assertOk()
            ->assertJsonPath('data.governorates.0.cazas.0.areas.0.name', 'Aadouiye')
            ->assertJsonPath('data.forms.0.name', 'Form 6-11')
            ->assertJsonStructure(['data' => ['statuses', 'options' => ['items', 'dropout_reasons'], 'version']]);

        $etag = $response->headers->get('ETag');
        $this->assertNotEmpty($etag);
        $this->withHeader('If-None-Match', $etag)->getJson('/api/v1/reference')->assertStatus(304);
    }

    public function test_create_is_idempotent_on_client_uuid(): void
    {
        Sanctum::actingAs($this->collector);
        $uuid = 'a6a0b7a2-2f7a-4d4a-9f3f-3a0c3a0b7a21';

        $first = $this->postJson('/api/v1/applications', ['client_uuid' => $uuid])->assertCreated();
        $second = $this->postJson('/api/v1/applications', ['client_uuid' => $uuid])->assertOk();

        $this->assertSame($first->json('data.id'), $second->json('data.id'));
        $this->assertStringEndsWith('-ROB-MICH-1', $first->json('data.code'));
        $this->assertSame(1, Application::count());
    }

    public function test_pre_test_submit_scores_and_advances_status(): void
    {
        Sanctum::actingAs($this->collector);
        $id = $this->postJson('/api/v1/applications', ['client_uuid' => 'b6a0b7a2-2f7a-4d4a-9f3f-3a0c3a0b7a22'])->json('data.id');

        $this->putJson("/api/v1/applications/{$id}/pre-test", $this->questionnaire())
            ->assertOk()
            ->assertJsonPath('data.status', ApplicationStatus::PostTest->value)
            ->assertJsonPath('data.pre_test.scores.total', 22);

        $this->putJson("/api/v1/applications/{$id}/pre-test", $this->questionnaire(['age' => 'x']))->assertStatus(422);

        $this->getJson('/api/v1/applications')->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_sync_batch_handles_new_duplicate_and_invalid_items(): void
    {
        Sanctum::actingAs($this->collector);
        $uuidA = 'c6a0b7a2-2f7a-4d4a-9f3f-3a0c3a0b7a23';
        $uuidB = 'd6a0b7a2-2f7a-4d4a-9f3f-3a0c3a0b7a24';

        $payload = ['applications' => [
            ['client_uuid' => $uuidA, 'pre_test' => $this->questionnaire()],
            ['client_uuid' => $uuidB, 'pre_test' => $this->questionnaire(['age' => '40'])],
        ]];

        $response = $this->postJson('/api/v1/sync', $payload)->assertOk();
        $results = collect($response->json('data.results'))->keyBy('client_uuid');

        $this->assertSame('created', $results[$uuidA]['result']);
        $this->assertSame(ApplicationStatus::PostTest->value, $results[$uuidA]['status']);
        $this->assertSame('error', $results[$uuidB]['result']);
        $this->assertArrayHasKey('age', $results[$uuidB]['errors'][0]);

        // Re-sending the same batch must not create duplicates or re-submit the pre-test.
        $again = $this->postJson('/api/v1/sync', $payload)->assertOk();
        $resultsAgain = collect($again->json('data.results'))->keyBy('client_uuid');
        $this->assertSame('skipped', $resultsAgain[$uuidA]['stages']['pre_test']['result']);
        $this->assertSame(2, Application::count());

        // Post-test through sync on the existing application.
        $post = $this->questionnaire(['dropout_reason' => FormOptions::DID_NOT_DROP_OUT, 'number_of_hours_that_the_child_attended' => '10', 'total_number_of_hours_in_your_program' => '12'], '0');
        $final = $this->postJson('/api/v1/sync', ['applications' => [['client_uuid' => $uuidA, 'post_test' => $post]]])->assertOk();
        $this->assertSame(ApplicationStatus::Done->value, $final->json('data.results.0.status'));
        $this->assertSame('updated', $final->json('data.results.0.result'));
    }

    public function test_readonly_collectors_cannot_write(): void
    {
        $this->collector->forceFill(['is_readonly' => true])->save();
        Sanctum::actingAs($this->collector->fresh());

        $this->postJson('/api/v1/applications', ['client_uuid' => 'e6a0b7a2-2f7a-4d4a-9f3f-3a0c3a0b7a25'])->assertStatus(422);
    }

    public function test_collectors_cannot_touch_other_collectors_applications(): void
    {
        $other = Collector::factory()->create(['prefix' => 'OTH'])->user;
        Sanctum::actingAs($other);
        $id = $this->postJson('/api/v1/applications', ['client_uuid' => 'f6a0b7a2-2f7a-4d4a-9f3f-3a0c3a0b7a26'])->json('data.id');

        Sanctum::actingAs($this->collector);
        $this->getJson("/api/v1/applications/{$id}")->assertStatus(403);
        $this->putJson("/api/v1/applications/{$id}/pre-test", $this->questionnaire())->assertStatus(403);
    }
}
