<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Partner;
use App\Models\Status;
use App\Sdq\ApplicationStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        if ($user->isCollector()) {
            return Inertia::location(route('applications.index'));
        }

        $year = $request->session()->get('year');

        $pending = Status::idsOf(ApplicationStatus::PreTest, ApplicationStatus::PreTestPending);
        $preDone = Status::idsOf(ApplicationStatus::PostTest, ApplicationStatus::PreTestCompleted);
        $postPending = Status::idsOf(ApplicationStatus::PostTestPending);
        $done = Status::idsOf(ApplicationStatus::Done);
        $dropout = Status::idsOf(ApplicationStatus::Dropout);
        $na = Status::idsOf(ApplicationStatus::NotApplicable, ApplicationStatus::PreTestNoPermission, ApplicationStatus::PostTestNoPermission);

        $partners = Partner::query()
            ->join('users', 'users.id', '=', 'partners.user_id')
            ->when($user->isPartner(), fn ($q) => $q->where('partners.user_id', $user->id))
            ->orderBy('partners.name')
            ->get(['partners.id', 'partners.user_id', 'partners.name', 'partners.max_app_per_year', 'users.is_active']);

        $counts = Application::query()
            ->visibleTo($user)
            ->forYear($year)
            ->select('application.partner_id', 'application.status', DB::raw('count(*) as total'))
            ->groupBy('application.partner_id', 'application.status')
            ->get()
            ->groupBy('partner_id');

        $bucket = fn ($rows, array $ids) => (int) ($rows?->whereIn('status', $ids)->sum('total') ?? 0);

        $rows = $partners->map(function (Partner $partner) use ($counts, $bucket, $pending, $preDone, $postPending, $done, $dropout, $na) {
            $rows = $counts->get($partner->user_id);
            $total = (int) ($rows?->sum('total') ?? 0);

            return [
                'id' => $partner->id,
                'user_id' => $partner->user_id,
                'name' => $partner->name,
                'is_active' => (bool) $partner->is_active,
                'pre_test_pending' => $bucket($rows, $pending),
                'pre_test_completed' => $bucket($rows, $preDone),
                'post_test_pending' => $bucket($rows, $postPending),
                'done' => $bucket($rows, $done),
                'dropout' => $bucket($rows, $dropout),
                'not_applicable' => $bucket($rows, $na),
                'total' => $total,
                'quota' => (int) $partner->max_app_per_year,
                'remaining' => max(0, (int) $partner->max_app_per_year - $total),
            ];
        });

        $years = Application::query()->visibleTo($user)
            ->whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year')->all();

        return Inertia::render('Dashboard/Index', [
            'partners' => $rows,
            'totals' => [
                'applications' => $rows->sum('total'),
                'done' => $rows->sum('done'),
                'pre_test_pending' => $rows->sum('pre_test_pending'),
                'post_test_pending' => $rows->sum('post_test_pending'),
                'dropout' => $rows->sum('dropout'),
            ],
            'years' => $years,
            'year' => $year,
        ]);
    }

    public function setYear(Request $request): RedirectResponse
    {
        $data = $request->validate(['year' => ['nullable', 'integer', 'between:2019,2100']]);
        if (empty($data['year'])) {
            $request->session()->forget('year');
        } else {
            $request->session()->put('year', (int) $data['year']);
        }

        return back();
    }
}
