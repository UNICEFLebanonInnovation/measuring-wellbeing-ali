<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PostTestRequest;
use App\Http\Requests\PreTestRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Sdq\ApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApplicationController extends ApiController
{
    public function __construct(private readonly ApplicationService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'updated_since' => ['nullable', 'date'],
            'status' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer', 'between:1,200'],
        ]);

        $applications = Application::query()
            ->visibleTo($request->user())
            ->with(['preTest', 'postTest'])
            ->when($filters['updated_since'] ?? null, fn ($q, $v) => $q->where('application.updated_at', '>=', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('application.status', $v))
            ->orderByDesc('application.updated_at')
            ->paginate($filters['per_page'] ?? 50)
            ->withQueryString();

        return ApplicationResource::collection($applications);
    }

    public function show(Request $request, Application $application): JsonResponse
    {
        if (! $this->canView($request->user(), $application)) {
            return $this->error('Forbidden', 403);
        }
        $application->load(['preTest', 'postTest']);

        return $this->success(new ApplicationResource($application));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'client_uuid' => ['required', 'uuid'],
            'language' => ['nullable', 'string', 'max:5'],
        ]);
        $user = $request->user();
        if ($user->collector === null) {
            return $this->error(__('ui.only_collectors_create'), 403);
        }

        $existing = Application::where('client_uuid', $data['client_uuid'])->first();
        if ($existing) {
            if (! $this->canView($user, $existing)) {
                return $this->error('Forbidden', 403);
            }

            return $this->success(new ApplicationResource($existing->load(['preTest', 'postTest'])), 'Application already exists', 200);
        }

        $application = $this->service->create($user, $data['client_uuid'], $data['language'] ?? null);

        return $this->success(new ApplicationResource($application->load(['preTest', 'postTest'])), 'Application created', 201);
    }

    public function preTest(PreTestRequest $request, Application $application): JsonResponse
    {
        if (! $this->canEdit($request->user(), $application)) {
            return $this->error('Forbidden', 403);
        }
        $application = $this->service->savePreTest($application, $request->validated(), $request->isSubmitting(), $request->user());

        return $this->success(
            new ApplicationResource($application->load(['preTest', 'postTest'])),
            $request->isSubmitting() ? __('messages.pre_test_submitted') : __('messages.pre_test_draft_saved'),
        );
    }

    public function postTest(PostTestRequest $request, Application $application): JsonResponse
    {
        if (! $this->canEdit($request->user(), $application)) {
            return $this->error('Forbidden', 403);
        }
        $application = $this->service->savePostTest($application, $request->validated(), $request->isSubmitting(), $request->user());

        return $this->success(
            new ApplicationResource($application->load(['preTest', 'postTest'])),
            $request->isSubmitting() ? __('messages.post_test_submitted') : __('messages.post_test_draft_saved'),
        );
    }
}
