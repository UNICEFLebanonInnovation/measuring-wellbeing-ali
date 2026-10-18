<?php

namespace App\Http\Controllers\Api\Legacy;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\TestRules;
use App\Models\Application;
use App\Models\ApplicationValue;
use App\Models\Collector;
use App\Models\Form;
use App\Models\Gouvernate;
use App\Models\Partner;
use App\Models\Status;
use App\Sdq\ApplicationService;
use App\Sdq\ApplicationStatus;
use App\Sdq\Exceptions\WorkflowException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Endpoints used by the Android application currently in the field.
 *
 * The app generates application codes on the device and sends them with
 * each save/submit. To keep that app working during the transition:
 *  - /create-application creates a server-coded application (the legacy
 *    endpoint ignored any client code as well);
 *  - save/submit endpoints look the application up by `code`; when the
 *    code is unknown, a new application is created on the server and the
 *    client-supplied code is kept (if it is not already in use), so the
 *    device and the server stay in sync.
 */
class LegacyApplicationController extends ApiController
{
    public function __construct(private readonly ApplicationService $service) {}

    public function create(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->is_readonly) {
            return $this->legacyError('access blocked');
        }
        if (! Collector::where('user_id', $user->id)->exists()) {
            return $this->legacyError('Collector not found or unauthorized user');
        }
        try {
            $application = $this->service->create($user, null, $request->input('language'));
        } catch (WorkflowException|\RuntimeException $e) {
            return $this->legacyError($e->getMessage());
        }

        return $this->success($this->applicationArray($application), 'Application Generated');
    }

    public function savePreTest(Request $request): JsonResponse
    {
        return $this->handleTest($request, false, false);
    }

    public function submitPreTest(Request $request): JsonResponse
    {
        return $this->handleTest($request, false, true);
    }

    public function savePostTest(Request $request): JsonResponse
    {
        return $this->handleTest($request, true, false);
    }

    public function submitPostTest(Request $request): JsonResponse
    {
        return $this->handleTest($request, true, true);
    }

    public function list(Request $request): JsonResponse
    {
        $user = $request->user();
        $collector = Collector::where('user_id', $user->id)->first();
        if (! $collector) {
            return $this->legacyError('Collector not found or unauthorized user');
        }
        $partner = Partner::where('user_id', $collector->partner_id)->first();
        $applicationCount = $partner
            ? Application::whereIn('collector_id', $partner->collectors()->pluck('user_id'))->count()
            : Application::where('collector_id', $user->id)->count();

        $hidden = Status::idsOf(ApplicationStatus::PreTestNoPermission, ApplicationStatus::NotApplicable);
        $applications = Application::query()
            ->visibleTo($user)
            ->whereNotIn('application.status', $hidden)
            ->when($request->filled('status'), fn ($q) => $q->where('application.status', $request->input('status')))
            ->with(['preTest.governorate', 'preTest.cazaRow', 'postTest.governorate', 'postTest.cazaRow'])
            ->orderBy('application.id')
            ->get();

        $main = ['application_count' => $applicationCount, 'application' => []];
        foreach ($applications as $application) {
            $row = $this->applicationArray($application);
            $row['form'] = $application->preTest?->form ?? '';
            $row['gouvername_name'] = $application->preTest?->governorate?->name ?? '';
            $row['caza_name'] = $application->preTest?->cazaRow?->name ?? '';
            $row['pre_test'] = $this->valueArray($application->preTest);
            $row['post_test'] = $this->valueArray($application->postTest);
            $main['application'][] = $row;
        }

        return $this->success($main, 'Application List Retrieved');
    }

    public function view(Request $request): JsonResponse
    {
        if (! $request->filled('code')) {
            return $this->legacyError('Validation Error.', ['code' => ['The code field is required.']]);
        }
        $application = $this->findVisible($request, $request->input('code'));
        if (! $application) {
            return $this->legacyError('Application not found or invalid code');
        }
        $application->load(['preTest.governorate', 'preTest.cazaRow', 'preTest.areaRow', 'postTest.governorate', 'postTest.cazaRow', 'postTest.areaRow', 'partner', 'collector']);

        $row = $this->applicationArray($application);
        $row['partner_name'] = $application->partner?->name;
        $row['collector_name'] = $application->collector?->firstname;

        return $this->success([
            'application' => $row,
            'pre_test' => $this->valueArray($application->preTest, true) ?? [],
            'post_test' => $this->valueArray($application->postTest, true) ?? [],
        ], 'Application Data Retrieved');
    }

    public function preTest(Request $request): JsonResponse
    {
        return $this->testPayload($request, ApplicationValue::PRE_TEST);
    }

    public function postTest(Request $request): JsonResponse
    {
        return $this->testPayload($request, ApplicationValue::POST_TEST);
    }

    private function testPayload(Request $request, string $type): JsonResponse
    {
        if (! $request->filled('code')) {
            return $this->legacyError('Validation Error.', ['code' => ['The code field is required.']]);
        }
        $application = $this->findVisible($request, $request->input('code'));
        if (! $application) {
            return $this->legacyError(__('messages.application_code_error'));
        }
        $value = ApplicationValue::firstOrCreate(['application_id' => $application->id, 'type' => $type]);
        $value->load(['governorate', 'cazaRow']);

        $payload = array_merge($value->toArray(), $this->applicationArray($application), [
            'gouvarnate_name' => $value->governorate?->name,
            'caza_name' => $value->cazaRow?->name,
        ]);

        return $this->success([
            'preTestObj' => $payload,
            'forms' => Form::all()->toArray(),
            'gouvernates' => Gouvernate::all()->toArray(),
        ], 'Application Data Retrieved');
    }

    private function handleTest(Request $request, bool $isPost, bool $submit): JsonResponse
    {
        $user = $request->user();
        if ($user->is_readonly) {
            return $this->legacyError('access blocked');
        }
        $code = trim((string) $request->input('code'));
        if ($code === '') {
            return $this->legacyError(__('messages.application_code_missing'));
        }

        $data = $request->except(['token', '_token', 'code']);
        $data['submit'] = $submit ? 'submit' : 'save';
        if (! empty($data['do_the_child_receive_any_other_child_protection_services']) && is_string($data['do_the_child_receive_any_other_child_protection_services'])) {
            $data['do_the_child_receive_any_other_child_protection_services'] = array_map('trim', explode(',', $data['do_the_child_receive_any_other_child_protection_services']));
        }

        $validator = TestRules::validator($data, $isPost);
        if ($validator->fails()) {
            return $this->legacyError('Validation errors', $validator->errors()->toArray());
        }
        $validated = $validator->validated();
        $validated['child_code'] = $validated['child_code'] ?? $code;

        try {
            $application = DB::transaction(function () use ($user, $code, $isPost, $request) {
                $application = Application::where('code', $code)->first();
                if ($application) {
                    if (! $this->canEdit($user, $application)) {
                        throw new WorkflowException('Application belongs to another collector.');
                    }

                    return $application;
                }
                if ($isPost) {
                    throw new WorkflowException(__('messages.application_code_error'));
                }
                // Unknown client-generated code: create on the server and keep the device's code.
                $application = $this->service->create($user, null, $request->input('language'));
                $application->code = $code;
                $application->save();

                return $application;
            });

            // sdq-12.apk sends the reporting year chosen in the form.
            $year = (int) $request->input('year');
            if ($year >= 2019 && $year <= 2100 && $application->year !== $year) {
                $application->forceFill(['year' => $year])->save();
            }

            $application = $isPost
                ? $this->service->savePostTest($application, $validated, $submit, $user)
                : $this->service->savePreTest($application, $validated, $submit, $user);
        } catch (WorkflowException|\RuntimeException $e) {
            return $this->legacyError($e->getMessage());
        }

        $message = match (true) {
            $application->hasStatus(ApplicationStatus::NotApplicable) => 'Application submitted as NA',
            $application->hasStatus(ApplicationStatus::PreTestNoPermission) => __('messages.pre_test_no_permission'),
            $application->hasStatus(ApplicationStatus::PostTestNoPermission) => __('messages.post_test_no_permission'),
            $isPost && $submit => __('messages.post_test_submitted'),
            $isPost => __('messages.post_test_draft_saved'),
            $submit => __('messages.pre_test_submitted'),
            default => __('messages.pre_test_draft_saved'),
        };

        return $this->success($this->applicationArray($application), $message);
    }

    private function findVisible(Request $request, string $code): ?Application
    {
        $application = Application::where('code', $code)->first();
        if (! $application || ! $this->canView($request->user(), $application)) {
            return null;
        }

        return $application;
    }

    private function applicationArray(Application $application): array
    {
        return [
            'id' => $application->id,
            'code' => $application->code,
            'pre_test_date' => $application->pre_test_date?->toDateTimeString(),
            'post_test_date' => $application->post_test_date?->toDateTimeString(),
            'created_at' => $application->created_at?->toDateTimeString(),
            'updated_at' => $application->updated_at?->toDateTimeString(),
            'partner_id' => $application->partner_id,
            'collector_id' => $application->collector_id,
            'status' => $application->status,
            'language' => $application->language,
            'status_name' => Status::nameOf($application->status),
        ];
    }

    private function valueArray(?ApplicationValue $value, bool $withArea = false): ?array
    {
        if (! $value) {
            return null;
        }
        $row = $value->toArray();
        $row['gouvername_name'] = $value->governorate?->name;
        $row['caza_name'] = $value->cazaRow?->name;
        if ($withArea) {
            $row['area_name'] = $value->areaRow?->name;
        }

        return $row;
    }

    private function legacyError(string $message, mixed $data = null): JsonResponse
    {
        $body = ['success' => false, 'message' => $message];
        if ($data !== null) {
            $body['data'] = $data;
        }

        return response()->json($body, 404);
    }
}
