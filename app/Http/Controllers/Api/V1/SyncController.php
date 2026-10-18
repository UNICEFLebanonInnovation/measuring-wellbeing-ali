<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\TestRules;
use App\Models\Application;
use App\Models\Status;
use App\Sdq\ApplicationService;
use App\Sdq\Exceptions\WorkflowException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Batch upload used by the offline mobile app. Every item is processed
 * independently and identified by the client-generated uuid, so the same
 * batch can safely be re-sent after a lost connection.
 */
class SyncController extends ApiController
{
    public function __construct(private readonly ApplicationService $service) {}

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'applications' => ['required', 'array', 'min:1', 'max:200'],
            'applications.*.client_uuid' => ['required', 'uuid'],
            'applications.*.language' => ['nullable', 'string', 'max:5'],
            'applications.*.pre_test' => ['nullable', 'array'],
            'applications.*.post_test' => ['nullable', 'array'],
        ]);

        $user = $request->user();
        if ($user->collector === null) {
            return $this->error(__('ui.only_collectors_create'), 403);
        }

        $results = [];
        foreach ($request->input('applications') as $item) {
            $results[] = $this->process($item, $user);
        }

        return $this->success(['results' => $results], 'Sync processed');
    }

    private function process(array $item, $user): array
    {
        $uuid = $item['client_uuid'];
        $result = ['client_uuid' => $uuid, 'id' => null, 'code' => null, 'status' => null, 'result' => 'skipped', 'errors' => [], 'stages' => []];

        try {
            $application = Application::where('client_uuid', $uuid)->first();
            if ($application && ! $this->canEdit($user, $application)) {
                $result['result'] = 'error';
                $result['errors'][] = 'Forbidden';

                return $result;
            }
            if (! $application) {
                $application = $this->service->create($user, $uuid, $item['language'] ?? null);
                $result['result'] = 'created';
            }

            foreach (['pre_test' => false, 'post_test' => true] as $stage => $isPost) {
                if (empty($item[$stage]) || ! is_array($item[$stage])) {
                    continue;
                }
                $result['stages'][$stage] = $this->applyStage($application, $item[$stage], $isPost, $user);
                if (($result['stages'][$stage]['result'] ?? null) === 'updated' && $result['result'] !== 'created') {
                    $result['result'] = 'updated';
                }
                if (($result['stages'][$stage]['result'] ?? null) === 'error') {
                    $result['result'] = 'error';
                    $result['errors'][] = $result['stages'][$stage]['errors'];
                }
                $application->refresh();
            }

            $result['id'] = $application->id;
            $result['code'] = $application->code;
            $result['status'] = Status::nameOf($application->status);
        } catch (WorkflowException $e) {
            $result['result'] = 'error';
            $result['errors'][] = $e->getMessage();
        } catch (Throwable $e) {
            Log::error('Sync item failed', ['client_uuid' => $uuid, 'exception' => $e]);
            $result['result'] = 'error';
            $result['errors'][] = 'Unexpected error while processing this application.';
        }

        return $result;
    }

    private function applyStage(Application $application, array $data, bool $isPost, $user): array
    {
        $status = $application->statusEnum();
        $allowed = $isPost ? $status?->allowsPostTestEdit() : $status?->allowsPreTestEdit();
        if (! $allowed) {
            return ['result' => 'skipped', 'reason' => 'Stage not editable in status "'.($status?->value ?? 'unknown').'"'];
        }

        $validator = TestRules::validator($data, $isPost);
        if ($validator->fails()) {
            return ['result' => 'error', 'errors' => $validator->errors()->toArray()];
        }
        $validated = $validator->validated();
        $submit = ($data['submit'] ?? 'submit') === 'submit';

        try {
            $isPost
                ? $this->service->savePostTest($application, $validated, $submit, $user)
                : $this->service->savePreTest($application, $validated, $submit, $user);
        } catch (WorkflowException $e) {
            return ['result' => 'skipped', 'reason' => $e->getMessage()];
        }

        return ['result' => 'updated', 'submitted' => $submit];
    }
}
