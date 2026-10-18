<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Status;
use App\Sdq\ApplicationStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class StatusController extends Controller
{
    public function index(): Response
    {
        $workflow = array_map(fn (ApplicationStatus $s) => $s->value, ApplicationStatus::cases());
        $statuses = Status::orderBy('id')->withCount('applications')->get()
            ->map(fn (Status $s) => [
                'id' => $s->id, 'name' => $s->name,
                'applications_count' => $s->applications_count,
                'is_workflow' => in_array($s->name, $workflow, true),
            ]);

        return Inertia::render('Statuses/Index', ['statuses' => $statuses]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:status,name']]);
        Status::create($data);

        return back()->with('success', __('ui.saved'));
    }

    public function update(Request $request, Status $status): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', Rule::unique('status', 'name')->ignore($status->id)]]);
        if (ApplicationStatus::tryFrom($status->name)) {
            return back()->with('error', __('ui.workflow_status_locked'));
        }
        $status->update($data);

        return back()->with('success', __('ui.saved'));
    }

    public function destroy(Status $status): RedirectResponse
    {
        if (ApplicationStatus::tryFrom($status->name) || Application::where('status', $status->id)->exists()) {
            return back()->with('error', __('ui.workflow_status_locked'));
        }
        $status->delete();

        return back()->with('success', __('ui.deleted'));
    }
}
