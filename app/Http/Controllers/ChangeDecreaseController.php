<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Status;
use App\Sdq\ApplicationService;
use App\Sdq\ApplicationStatus;
use App\Sdq\FormOptions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Applications whose post-test score is worse than the pre-test
 * ("Decrease"). UNICEF asks partners to explain each one.
 */
class ChangeDecreaseController extends Controller
{
    public function __construct(private readonly ApplicationService $service) {}

    public function index(Request $request): Response
    {
        $user = $request->user();
        $filters = $request->validate([
            'code' => ['nullable', 'string', 'max:50'],
            'explained' => ['nullable', 'in:yes,no'],
        ]);

        $applications = Application::query()
            ->visibleTo($user)
            ->forYear($request->session()->get('year'))
            ->where('application.status', Status::idOf(ApplicationStatus::Done))
            ->with(['partner:id,user_id,name', 'collector:id,firstname,lastname', 'preTest:id,application_id,score', 'postTest:id,application_id,score'])
            ->when($filters['code'] ?? null, fn ($q, $v) => $q->where('application.code', 'like', "%{$v}%"))
            ->when(($filters['explained'] ?? null) === 'yes', fn ($q) => $q->whereNotNull('reason_option'))
            ->when(($filters['explained'] ?? null) === 'no', fn ($q) => $q->whereNull('reason_option'))
            ->orderByDesc('application.post_test_date')
            ->get()
            ->filter(fn (Application $a) => $a->change() === 'Decrease')
            ->values()
            ->map(fn (Application $a) => [
                'id' => $a->id,
                'code' => $a->code,
                'partner' => $a->partner?->name,
                'collector' => $a->collector?->name,
                'pre_test_score' => $a->preTest?->totalScore(),
                'post_test_score' => $a->postTest?->totalScore(),
                'post_test_date' => $a->post_test_date?->toDateString(),
                'reasons' => $a->reason_option ? explode(' | ', $a->reason_option) : [],
                'details' => $a->reason_details,
            ]);

        return Inertia::render('ChangeDecrease/Index', [
            'applications' => $applications,
            'filters' => $filters,
            'reasons' => FormOptions::DECREASE_REASONS,
            'canEdit' => $user->isPartner() && ! $user->is_readonly,
        ]);
    }

    public function update(Request $request, Application $application): RedirectResponse
    {
        $user = $request->user();
        abort_unless(Application::visibleTo($user)->whereKey($application->id)->exists(), 403);

        $data = $request->validate([
            'reasons' => ['nullable', 'array', 'max:2'],
            'reasons.*' => [Rule::in(FormOptions::DECREASE_REASONS)],
            'details' => ['nullable', 'string', 'max:2000', 'required_with:reasons'],
        ]);

        $this->service->setDecreaseReason($application, $data['reasons'] ?? [], $data['details'] ?? null, $user);

        return back()->with('success', __('ui.saved'));
    }
}
