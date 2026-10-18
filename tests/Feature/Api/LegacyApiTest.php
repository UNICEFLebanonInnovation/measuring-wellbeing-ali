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
use Tests\TestCase;

class LegacyApiTest extends TestCase
{
    use RefreshDatabase;

    private User $collector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, StatusSeeder::class]);
        Notification::fake();
        Gouvernate::forceCreate(['id' => 1, 'name' => 'Akkar', 'arabic' => 'عكار']);
        Caza::forceCreate(['id' => 3, 'gouvernate_id' => 1, 'name' => 'Akkar', 'arabic' => 'عكار']);
        Area::forceCreate(['id' => 3, 'caza_id' => 3, 'gouvernate_id' => 1, 'name' => 'Aadouiye', 'arabic' => 'عدوي']);

        $partner = Partner::factory()->create(['prefix' => 'AKK', 'name' => 'Akkar']);
        $this->collector = Collector::factory()->forPartner($partner)->create(['prefix' => 'C1'])->user;
        $this->collector->forceFill(['password' => '123456'])->save();
    }

    private function token(): string
    {
        return $this->postJson('/api/login', ['email' => $this->collector->email, 'password' => '123456'])->json('data.api_token');
    }

    private function questionnaire(array $overrides = [], string $answer = '1'): array
    {
        $data = [
            'form' => 'Form 12-17', 'category' => FormOptions::CATEGORIES[0], 'agency_name' => 'Akkar',
            'donor_name' => 'UNICEF', 'interview_date' => '2026-02-16', 'interviewers_name' => 'C1',
            'age' => '13', 'gender' => 'male', 'nationality' => 'Lebanese', 'gouvarnate' => '1', 'caza' => '3',
            'area' => '3', 'gateway_type' => 'School', 'may_i_start_now' => 'yes',
        ];
        foreach (SdqItems::all() as $item) {
            $data[$item] = $answer;
        }

        return array_merge($data, $overrides);
    }

    public function test_legacy_login_response_shape(): void
    {
        $response = $this->postJson('/api/login', ['email' => $this->collector->email, 'password' => '123456']);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.collector_prefix', 'C1')
            ->assertJsonPath('data.partner_prefix', 'AKK')
            ->assertJsonPath('data.partner_name', 'Akkar')
            ->assertJsonPath('data.last_increment_no', 0)
            ->assertJsonPath('data.is_readonly', '0')
            ->assertJsonPath('data.year', (string) now()->year)
            ->assertJsonPath('data.years', [now()->year])
            ->assertJsonStructure(['data' => ['id', 'firstname', 'lastname', 'email', 'phone', 'zone', 'address', 'fax', 'is_active', 'email_verified_at', 'api_token', 'created_at', 'updated_at', 'year', 'years'], 'message']);

        $this->assertSame(50, strlen($response->json('data.api_token')));
        $this->assertStringStartsWith('Welcome!', $response->json('message'));

        $this->postJson('/api/login', ['email' => $this->collector->email, 'password' => 'wrong'])
            ->assertStatus(404)->assertJsonPath('success', false)->assertJsonPath('message', 'Invalid credentials');
    }

    public function test_requests_without_a_valid_token_are_rejected(): void
    {
        $this->postJson('/api/get-application')->assertStatus(401)->assertJsonPath('error', 'Unauthorized access.');
        $this->postJson('/api/get-application', ['token' => 'nope'])->assertStatus(401)->assertJsonPath('error', 'Invalid Token passed.');
    }

    public function test_create_application_returns_server_code(): void
    {
        $token = $this->token();

        $response = $this->postJson('/api/create-application', ['token' => $token])->assertOk();
        $this->assertStringEndsWith('-AKK-C1-1', $response->json('data.code'));
        $this->assertSame(ApplicationStatus::PreTest->value, $response->json('data.status_name'));
    }

    public function test_submit_pre_test_by_device_code_creates_and_keeps_the_code(): void
    {
        $token = $this->token();
        $code = 'AKK-C1-1';

        $this->postJson('/api/submit-pre-test-application', ['token' => $token, 'code' => $code] + $this->questionnaire())
            ->assertOk()
            ->assertJsonPath('data.code', $code)
            ->assertJsonPath('data.status_name', ApplicationStatus::PostTest->value);

        $application = Application::where('code', $code)->firstOrFail();
        $this->assertSame($this->collector->id, $application->collector_id);
        $this->assertSame(22.0, (float) $application->preTest->score);

        // Second submit of the same pre-test is refused like the legacy app did.
        $this->postJson('/api/submit-pre-test-application', ['token' => $token, 'code' => $code] + $this->questionnaire())
            ->assertStatus(404)->assertJsonPath('success', false);

        // Post-test by the same code completes the application.
        $post = $this->questionnaire(['dropout_reason' => FormOptions::DID_NOT_DROP_OUT, 'number_of_hours_that_the_child_attended' => '10', 'total_number_of_hours_in_your_program' => '12'], '0');
        $this->postJson('/api/submit-post-test-application', ['token' => $token, 'code' => $code] + $post)
            ->assertOk()->assertJsonPath('data.status_name', ApplicationStatus::Done->value);

        $list = $this->postJson('/api/get-application', ['token' => $token])->assertOk();
        $this->assertSame(1, $list->json('data.application_count'));
        $this->assertSame($code, $list->json('data.application.0.code'));
        $this->assertSame('Akkar', $list->json('data.application.0.gouvername_name'));
        $this->assertNotNull($list->json('data.application.0.post_test'));

        $this->postJson('/api/view-application', ['token' => $token, 'code' => $code])->assertOk()
            ->assertJsonPath('data.application.code', $code)->assertJsonPath('data.pre_test.area_name', 'Aadouiye');
    }

    /** sdq-12.apk sends raw spinner values; they must be accepted and normalised. */
    public function test_values_exactly_as_the_android_app_sends_them_are_accepted(): void
    {
        $token = $this->token();
        $payload = $this->questionnaire([
            'gender' => 'Female',
            'may_i_start_now' => 'Yes, permission is given',
            'category' => 'Child Marriage Activity',
            'gateway_type' => 'Remotely',
            'agency_name' => 'TDH-Lausanne',
            'year' => '2025',
            'app_version' => '12',
            'do_the_child_receive_any_other_child_protection_services' => ['Case management', 'No'],
        ]);

        $this->postJson('/api/submit-pre-test-application', ['token' => $token, 'code' => 'AKK-C1-7'] + $payload)
            ->assertOk()->assertJsonPath('data.status_name', ApplicationStatus::PostTest->value);

        $application = Application::where('code', 'AKK-C1-7')->firstOrFail();
        $this->assertSame(2025, $application->year);
        $this->assertSame('female', $application->preTest->gender);
        $this->assertSame('yes', $application->preTest->may_i_start_now);
        $this->assertSame('Child Marriage Activity', $application->preTest->category);
        $this->assertSame('Case management', $application->preTest->do_the_child_receive_any_other_child_protection_services);

        // Legacy web spellings are mapped onto the same canonical values.
        $this->postJson('/api/submit-pre-test-application', ['token' => $token, 'code' => 'AKK-C1-8'] + $this->questionnaire([
            'category' => 'Child Mariage Activity', 'gateway_type' => 'Border crossing, Other', 'gender' => 'MALE',
        ]))->assertOk();
        $this->assertSame('Child Marriage Activity', Application::where('code', 'AKK-C1-8')->firstOrFail()->preTest->category);
    }

    public function test_save_pre_test_keeps_draft_and_validation_errors_use_legacy_shape(): void
    {
        $token = $this->token();

        $this->postJson('/api/save-pre-test-application', ['token' => $token, 'code' => 'AKK-C1-7'] + $this->questionnaire())
            ->assertOk()->assertJsonPath('data.status_name', ApplicationStatus::PreTestPending->value);

        $this->postJson('/api/submit-pre-test-application', ['token' => $token, 'code' => 'AKK-C1-7'] + $this->questionnaire(['age' => '40']))
            ->assertStatus(404)->assertJsonPath('success', false)->assertJsonPath('message', 'Validation errors')
            ->assertJsonStructure(['data' => ['age']]);

        $this->postJson('/api/pre-test-application', ['token' => $token, 'code' => 'AKK-C1-7'])->assertOk()
            ->assertJsonPath('data.preTestObj.code', 'AKK-C1-7')->assertJsonStructure(['data' => ['forms', 'gouvernates']]);
    }

    public function test_readonly_and_location_endpoints(): void
    {
        $token = $this->token();
        $this->postJson('/api/get-caza', ['token' => $token, 'gouvernate_id' => 1])->assertOk()->assertJsonPath('data.0.name', 'Akkar');
        $this->postJson('/api/get-area', ['token' => $token])->assertStatus(404)->assertJsonPath('success', false);
        $this->getJson('/api/get-all-locations')->assertOk()->assertJsonStructure(['data' => ['gouvernates', 'caza', 'area']]);
        $this->postJson('/api/get-status', ['token' => $token])->assertOk();

        $this->collector->forceFill(['is_readonly' => true])->save();
        $this->postJson('/api/create-application', ['token' => $token])->assertStatus(404)->assertJsonPath('message', 'access blocked');

        $this->postJson('/api/logout', ['token' => $token])->assertOk();
        $this->postJson('/api/get-application', ['token' => $token])->assertStatus(401);
    }
}
