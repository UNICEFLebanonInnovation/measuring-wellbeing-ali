<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostTestRequest;
use App\Http\Requests\PreTestRequest;
use App\Models\Application;
use App\Models\Collector;
use App\Models\Gouvernate;
use App\Models\Partner;
use App\Models\Status;
use App\Models\User;
use App\Sdq\ApplicationService;
use App\Sdq\ApplicationStatus;
use App\Sdq\Exceptions\WorkflowException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ApplicationController extends Controller
{
    public function __construct(private readonly ApplicationService $service) {}

    public function index(Request $request): Response
    {
        $user = $request->user();
        $filters = $request->validate([
            'code' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'integer'],
            'partner' => ['nullable', 'integer'],
            'collector' => ['nullable', 'integer'],
            'governorate' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'sort' => ['nullable', 'in:code,pre_test_date,post_test_date,status,created_at'],
            'dir' => ['nullable', 'in:asc,desc'],
        ]);

        $applications = Application::query()
            ->visibleTo($user)
            ->forYear($request->session()->get('year'))
            ->with(['statusRow', 'partner:id,user_id,name', 'collector:id,firstname,lastname', 'preTest:id,application_id,score,gouvarnate,form', 'preTest.governorate:id,name,arabic', 'postTest:id,application_id,score'])
            ->when($filters['code'] ?? null, fn ($q, $v) => $q->where('application.code', 'like', "%{$v}%"))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('application.status', $v))
            ->when($filters['partner'] ?? null, fn ($q, $v) => $q->where('application.partner_id', $v))
            ->when($filters['collector'] ?? null, fn ($q, $v) => $q->where('application.collector_id', $v))
            ->when($filters['governorate'] ?? null, fn ($q, $v) => $q->whereHas('preTest', fn ($p) => $p->where('gouvarnate', (string) $v)))
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->whereDate('application.pre_test_date', '>=', $v))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->whereDate('application.pre_test_date', '<=', $v))
            ->orderBy('application.'.($filters['sort'] ?? 'created_at'), $filters['dir'] ?? 'desc')
            ->paginate(25)
            ->withQueryString()
            ->through(fn (Application $a) => $this->summarise($a));

        return Inertia::render('Applications/Index', [
            'applications' => $applications,
            'filters' => $filters,
            'statuses' => Status::orderBy('id')->get(['id', 'name']),
            'partners' => $user->isAdmin() ? Partner::orderBy('name')->get(['user_id as id', 'name']) : [],
            'collectors' => $this->collectorsFor($user),
            'governorates' => Gouvernate::orderBy('name')->get(['id', 'name', 'arabic']),
            'canCreate' => ($user->isCollector() || $user->isPartner()) && ! $user->is_readonly && $user->collector !== null,
        ]);
    }

    public function show(Request $request, Application $application): Response
    {
        $this->authorizeView($request->user(), $application);
        $application->load(['statusRow', 'partner', 'collector', 'preTest', 'postTest', 'logs.causer']);

        return Inertia::render('Applications/Show', [
            'application' => $this->detail($application),
            'collectors' => $this->collectorsFor($request->user(), $application),
            'can' => [
                'preTest' => $this->canEdit($request->user(), $application) && $application->statusEnum()?->allowsPreTestEdit(),
                'postTest' => $this->canEdit($request->user(), $application) && $application->statusEnum()?->allowsPostTestEdit(),
                'transfer' => ($request->user()->isAdmin() || $request->user()->isPartner()) && ! $application->hasStatus(ApplicationStatus::Done),
                'delete' => $this->canEdit($request->user(), $application) && ! $application->hasStatus(ApplicationStatus::Done),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->collector === null) {
            return back()->with('error', __('ui.only_collectors_create'));
        }

        try {
            $application = $this->service->create($user, null, app()->getLocale());
        } catch (WorkflowException|\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('applications.pre-test', $application)
            ->with('success', __('messages.application_generated').$application->code);
    }

    public function editPreTest(Request $request, Application $application): Response
    {
        $this->authorizeEdit($request->user(), $application);
        $application->load(['preTest', 'collector', 'partner']);

        return $this->form($application, 'pre_test');
    }

    public function updatePreTest(PreTestRequest $request, Application $application): RedirectResponse
    {
        $this->authorizeEdit($request->user(), $application);
        $application = $this->service->savePreTest($application, $request->validated(), $request->isSubmitting(), $request->user());

        return redirect()->route('applications.show', $application)
            ->with('success', $request->isSubmitting() ? __('messages.pre_test_submitted') : __('messages.pre_test_draft_saved'));
    }

    public function editPostTest(Request $request, Application $application): Response
    {
        $this->authorizeEdit($request->user(), $application);
        $application->load(['preTest', 'postTest', 'collector', 'partner']);

        return $this->form($application, 'post_test');
    }

    public function updatePostTest(PostTestRequest $request, Application $application): RedirectResponse
    {
        $this->authorizeEdit($request->user(), $application);
        $application = $this->service->savePostTest($application, $request->validated(), $request->isSubmitting(), $request->user());

        return redirect()->route('applications.show', $application)
            ->with('success', $request->isSubmitting() ? __('messages.post_test_submitted') : __('messages.post_test_draft_saved'));
    }

    public function transfer(Request $request, Application $application): RedirectResponse
    {
        $this->authorizeView($request->user(), $application);
        $data = $request->validate(['collector_id' => ['required', 'exists:users,id']]);
        $target = User::findOrFail($data['collector_id']);
        if (! $request->user()->isAdmin() && ! in_array($target->id, $request->user()->collectorUserIds(), true)) {
            abort(403);
        }
        $this->service->transferCollector($application, $target, $request->user());

        return back()->with('success', __('ui.application_transferred'));
    }

    public function destroy(Request $request, Application $application): RedirectResponse
    {
        $this->authorizeEdit($request->user(), $application);
        if ($application->hasStatus(ApplicationStatus::Done)) {
            return back()->with('error', __('ui.cannot_delete_done'));
        }
        $this->service->delete($application, $request->user());

        return redirect()->route('applications.index')->with('success', __('ui.application_deleted'));
    }

    private function form(Application $application, string $type): Response
    {
        $values = $type === 'pre_test' ? $application->preTest : $application->postTest;
        // A post-test starts pre-filled with the demographic part of the pre-test.
        $defaults = [];
        if ($type === 'post_test' && ! $values && $application->preTest) {
            $defaults = collect($application->preTest->toArray())->only([
                'category', 'child_code', 'gouvarnate', 'caza', 'area', 'agency_name', 'form', 'donor_name',
                'interviewers_name', 'age', 'gender', 'nationality', 'other_nationality', 'gateway_type', 'p_code',
            ])->all();
        }

        return Inertia::render('Applications/TestForm', [
            'application' => $this->summarise($application),
            'type' => $type,
            'values' => $values?->toArray() ?? $defaults,
            'preTestSummary' => $type === 'post_test' && $application->preTest ? [
                'interview_date' => $application->preTest->interview_date,
                'score' => $application->preTest->score,
            ] : null,
            'governorates' => Gouvernate::with(['cazas:id,gouvernate_id,name,arabic'])->orderBy('name')->get(['id', 'name', 'arabic']),
            'agency' => $application->partner?->name,
            'interviewer' => $application->collector?->name,
        ]);
    }

    private function summarise(Application $a): array
    {
        return [
            'id' => $a->id,
            'code' => $a->code,
            'year' => $a->year,
            'status' => $a->statusRow?->name ?? Status::nameOf($a->status),
            'status_id' => $a->status,
            'pre_test_date' => $a->pre_test_date?->toDateString(),
            'post_test_date' => $a->post_test_date?->toDateString(),
            'pre_test_score' => $a->preTest?->totalScore(),
            'post_test_score' => $a->postTest?->totalScore(),
            'change' => $a->change(),
            'partner' => $a->partner?->name,
            'collector' => $a->collector?->name,
            'collector_id' => $a->collector_id,
            'form' => $a->preTest?->form,
            'governorate' => $a->preTest?->governorate?->name,
        ];
    }

    private function detail(Application $a): array
    {
        return array_merge($this->summarise($a), [
            'reason_option' => $a->reason_option,
            'reason_details' => $a->reason_details,
            'pre_test' => $a->preTest?->toArray(),
            'post_test' => $a->postTest?->toArray(),
            'locations' => [
                'governorate' => $a->preTest?->governorate?->name,
                'caza' => $a->preTest?->cazaRow?->name,
                'area' => $a->preTest?->areaRow?->name,
            ],
            'logs' => $a->logs->map(fn ($log) => [
                'id' => $log->id,
                'text' => $log->text,
                'by' => $log->causer?->name,
                'at' => $log->created_at?->toDateTimeString(),
            ]),
        ]);
    }

    private function collectorsFor(User $user, ?Application $application = null)
    {
        $query = Collector::query()->join('users', 'users.id', '=', 'collectors.user_id')
            ->where('users.is_active', true)
            ->orderBy('users.firstname');
        if ($user->isPartner()) {
            $query->where('collectors.partner_id', $user->id);
        } elseif ($user->isAdmin() && $application) {
            $query->where('collectors.partner_id', $application->partner_id);
        } elseif ($user->isCollector()) {
            return [];
        }

        return $query->get(['users.id', 'users.firstname', 'users.lastname'])
            ->map(fn ($u) => ['id' => $u->id, 'name' => trim($u->firstname.' '.$u->lastname)]);
    }

    private function canEdit(User $user, Application $application): bool
    {
        if ($user->is_readonly) {
            return false;
        }
        if ($user->isCollector()) {
            return $application->collector_id === $user->id;
        }
        if ($user->isPartner()) {
            return $application->partner_id === $user->id || in_array($application->collector_id, $user->collectorUserIds(), true);
        }

        return false;
    }

    private function authorizeView(User $user, Application $application): void
    {
        if ($user->isAdmin()) {
            return;
        }
        abort_unless(Application::visibleTo($user)->whereKey($application->id)->exists(), 403);
    }

    private function authorizeEdit(User $user, Application $application): void
    {
        abort_unless($this->canEdit($user, $application), 403);
    }
}
