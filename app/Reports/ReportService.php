<?php

namespace App\Reports;

use App\Models\Application;
use App\Models\ApplicationLog;
use App\Models\Gouvernate;
use App\Models\Partner;
use App\Models\Status;
use App\Sdq\ApplicationStatus;
use App\Sdq\FormOptions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Analytics ported from the legacy ReportController. Every method returns
 * a plain array shaped for Pages/Reports/Show.vue:
 *   charts: [{type, title, labels, datasets:[{label, data}]}]
 *   table:  {columns:[{key,label}], rows:[...]}
 *   summary: [{label, value}]
 * Aggregation happens in SQL so the reports stay fast on a large table.
 */
final class ReportService
{
    public const SCALES = [
        'emotional_scale' => 'emotional',
        'conduct_scale' => 'conduct',
        'hyper_activity_scale' => 'hyperactivity',
        'peer_problem_scale' => 'peer_problems',
    ];

    public const REPORTS = [
        'dropout-reasons' => ['filters' => ['partner']],
        'scale-comparison' => ['filters' => ['partner', 'governorate', 'gender', 'form', 'nationality']],
        'partner-analysis' => ['filters' => ['partner', 'gender', 'form', 'nationality']],
        'governorate-analysis' => ['filters' => ['partner', 'gender', 'form', 'nationality']],
        'increase-scale' => ['filters' => ['partner', 'governorate', 'gender', 'form', 'nationality']],
        'uncompleted-per-partner' => ['filters' => ['partner']],
        'change-analysis' => ['filters' => ['partner', 'governorate', 'gender', 'form', 'nationality']],
        'analysis-data' => ['filters' => ['partner', 'governorate', 'gender', 'form', 'nationality']],
    ];

    public static function slugs(): array
    {
        return array_keys(self::REPORTS);
    }

    public function run(string $slug, ReportFilters $filters, ?int $page = null): array
    {
        return match ($slug) {
            'dropout-reasons' => $this->dropoutReasons($filters),
            'scale-comparison' => $this->scaleComparison($filters),
            'partner-analysis' => $this->partnerAnalysis($filters),
            'governorate-analysis' => $this->governorateAnalysis($filters),
            'increase-scale' => $this->increaseScale($filters),
            'uncompleted-per-partner' => $this->uncompletedPerPartner($filters),
            'change-analysis' => $this->changeAnalysis($filters),
            'analysis-data' => $this->analysisData($filters, $page ?? 1),
            default => throw new InvalidArgumentException("Unknown report {$slug}"),
        };
    }

    // ------------------------------------------------------------------ reports

    /** 1. Dropout-status applications per dropout reason, overall and per partner. */
    public function dropoutReasons(ReportFilters $f): array
    {
        $rows = $this->base($f, ApplicationStatus::Dropout, withPost: true)
            ->leftJoin('partners', 'partners.user_id', '=', 'application.partner_id')
            ->groupBy('application.partner_id', 'partners.name', 'post.dropout_reason')
            ->orderBy('partners.name')
            ->get([
                'application.partner_id',
                DB::raw('partners.name as partner_name'),
                DB::raw('post.dropout_reason as reason'),
                DB::raw('count(*) as total'),
            ]);

        $reasons = array_values(array_filter(FormOptions::DROPOUT_REASONS, fn ($r) => $r !== FormOptions::DID_NOT_DROP_OUT));
        $overall = array_fill_keys($reasons, 0);
        $byPartner = [];
        foreach ($rows as $row) {
            $reason = $row->reason ?: 'Other reason';
            $overall[$reason] = ($overall[$reason] ?? 0) + (int) $row->total;
            $name = $row->partner_name ?? '—';
            $byPartner[$name] ??= array_fill_keys($reasons, 0) + ['partner' => $name, 'total' => 0];
            $byPartner[$name][$reason] = ($byPartner[$name][$reason] ?? 0) + (int) $row->total;
            $byPartner[$name]['total'] += (int) $row->total;
        }
        $grand = array_sum($overall);
        $labels = array_keys($overall);

        $tableRows = [];
        foreach ($overall as $reason => $count) {
            $tableRows[] = ['reason' => $reason, 'total' => $count, 'percent' => $this->percent($count, $grand)];
        }

        return [
            'summary' => [['label' => 'total_dropouts', 'value' => $grand]],
            'charts' => [
                [
                    'type' => 'pie',
                    'title' => 'dropout_share',
                    'labels' => $labels,
                    'datasets' => [['label' => 'dropouts', 'data' => array_values($overall)]],
                ],
                [
                    'type' => 'bar',
                    'title' => 'dropouts_per_partner',
                    'labels' => array_keys($byPartner),
                    'datasets' => array_map(fn ($reason) => [
                        'label' => $reason,
                        'data' => array_map(fn ($p) => $p[$reason] ?? 0, array_values($byPartner)),
                    ], $labels),
                    'stacked' => true,
                ],
            ],
            'table' => [
                'columns' => [
                    ['key' => 'reason', 'label' => 'reason'],
                    ['key' => 'total', 'label' => 'total'],
                    ['key' => 'percent', 'label' => 'percent'],
                ],
                'rows' => $tableRows,
            ],
            'secondaryTable' => [
                'columns' => array_merge(
                    [['key' => 'partner', 'label' => 'partner']],
                    array_map(fn ($r) => ['key' => $r, 'label' => $r, 'raw' => true], $labels),
                    [['key' => 'total', 'label' => 'total']],
                ),
                'rows' => array_values($byPartner),
            ],
        ];
    }

    /** 2. Average scale scores, pre vs post, for Done applications. */
    public function scaleComparison(ReportFilters $f): array
    {
        $selects = [DB::raw('count(*) as total')];
        foreach (self::SCALES as $column => $key) {
            $selects[] = DB::raw("avg({$this->num("pre.$column")}) as pre_{$key}");
            $selects[] = DB::raw("avg({$this->num("post.$column")}) as post_{$key}");
        }
        $selects[] = DB::raw("avg({$this->num('pre.score')}) as pre_total");
        $selects[] = DB::raw("avg({$this->num('post.score')}) as post_total");

        $row = $this->base($f, ApplicationStatus::Done, withPost: true)->first($selects);

        $labels = array_values(self::SCALES);
        $labels[] = 'total';
        $pre = [];
        $post = [];
        $rows = [];
        foreach ($labels as $key) {
            $pre[] = round((float) $row->{"pre_$key"}, 2);
            $post[] = round((float) $row->{"post_$key"}, 2);
            $rows[] = [
                'scale' => $key,
                'pre' => round((float) $row->{"pre_$key"}, 2),
                'post' => round((float) $row->{"post_$key"}, 2),
                'difference' => round((float) $row->{"post_$key"} - (float) $row->{"pre_$key"}, 2),
            ];
        }

        return [
            'summary' => [['label' => 'applications_done', 'value' => (int) $row->total]],
            'charts' => [[
                'type' => 'bar',
                'title' => 'average_scale_scores',
                'labels' => $labels,
                'datasets' => [
                    ['label' => 'pre_test', 'data' => $pre],
                    ['label' => 'post_test', 'data' => $post],
                ],
                'translateLabels' => true,
            ]],
            'table' => [
                'columns' => [
                    ['key' => 'scale', 'label' => 'scale', 'translate' => true],
                    ['key' => 'pre', 'label' => 'pre_test'],
                    ['key' => 'post', 'label' => 'post_test'],
                    ['key' => 'difference', 'label' => 'difference'],
                ],
                'rows' => $rows,
            ],
        ];
    }

    /** 3. Done applications per partner per governorate. */
    public function partnerAnalysis(ReportFilters $f): array
    {
        $rows = $this->base($f, ApplicationStatus::Done)
            ->leftJoin('partners', 'partners.user_id', '=', 'application.partner_id')
            ->groupBy('partners.name', 'pre.gouvarnate')
            ->get([DB::raw('partners.name as partner_name'), DB::raw('pre.gouvarnate as governorate_id'), DB::raw('count(*) as total')]);

        $governorates = Gouvernate::orderBy('name')->get(['id', 'name']);
        $govNames = $governorates->pluck('name', 'id')->all();
        $matrix = [];
        foreach ($rows as $row) {
            $name = $row->partner_name ?? '—';
            $matrix[$name] ??= ['partner' => $name, 'total' => 0] + array_fill_keys($governorates->pluck('name')->all(), 0);
            $gov = $govNames[(int) $row->governorate_id] ?? 'Unknown';
            $matrix[$name][$gov] = ($matrix[$name][$gov] ?? 0) + (int) $row->total;
            $matrix[$name]['total'] += (int) $row->total;
        }
        ksort($matrix);
        $partnerNames = array_keys($matrix);

        return [
            'summary' => [['label' => 'applications_done', 'value' => array_sum(array_column($matrix, 'total'))]],
            'charts' => [[
                'type' => 'bar',
                'title' => 'done_per_partner_per_governorate',
                'labels' => $partnerNames,
                'datasets' => $governorates->map(fn ($g) => [
                    'label' => $g->name,
                    'data' => array_map(fn ($p) => $p[$g->name] ?? 0, array_values($matrix)),
                ])->all(),
                'stacked' => true,
            ]],
            'table' => [
                'columns' => array_merge(
                    [['key' => 'partner', 'label' => 'partner']],
                    $governorates->map(fn ($g) => ['key' => $g->name, 'label' => $g->name, 'raw' => true])->all(),
                    [['key' => 'total', 'label' => 'total']],
                ),
                'rows' => array_values($matrix),
            ],
        ];
    }

    /** 4. Done applications per governorate split by change and by gender. */
    public function governorateAnalysis(ReportFilters $f): array
    {
        $change = $this->changeExpression();
        $rows = $this->base($f, ApplicationStatus::Done, withPost: true)
            ->groupBy('pre.gouvarnate', 'pre.gender', DB::raw($change))
            ->get([
                DB::raw('pre.gouvarnate as governorate_id'),
                DB::raw('pre.gender as gender'),
                DB::raw("{$change} as change_type"),
                DB::raw('count(*) as total'),
            ]);

        $govNames = Gouvernate::orderBy('name')->pluck('name', 'id')->all();
        $data = [];
        foreach ($rows as $row) {
            $gov = $govNames[(int) $row->governorate_id] ?? 'Unknown';
            $data[$gov] ??= ['governorate' => $gov, 'Increase' => 0, 'Decrease' => 0, 'Same' => 0, 'male' => 0, 'female' => 0, 'total' => 0];
            $data[$gov][$row->change_type] += (int) $row->total;
            if (in_array($row->gender, ['male', 'female'], true)) {
                $data[$gov][$row->gender] += (int) $row->total;
            }
            $data[$gov]['total'] += (int) $row->total;
        }
        ksort($data);
        $labels = array_keys($data);
        $tableRows = array_map(fn ($r) => $r + ['percent_increase' => $this->percent($r['Increase'], $r['total'])], array_values($data));

        return [
            'summary' => [['label' => 'applications_done', 'value' => array_sum(array_column($data, 'total'))]],
            'charts' => [
                [
                    'type' => 'bar',
                    'title' => 'change_per_governorate',
                    'labels' => $labels,
                    'datasets' => array_map(fn ($c) => ['label' => strtolower($c), 'data' => array_map(fn ($g) => $g[$c], array_values($data))], ['Increase', 'Decrease', 'Same']),
                    'stacked' => true,
                    'translateDatasets' => true,
                ],
                [
                    'type' => 'bar',
                    'title' => 'gender_per_governorate',
                    'labels' => $labels,
                    'datasets' => array_map(fn ($g) => ['label' => $g, 'data' => array_map(fn ($r) => $r[$g], array_values($data))], ['male', 'female']),
                    'translateDatasets' => true,
                ],
            ],
            'table' => [
                'columns' => [
                    ['key' => 'governorate', 'label' => 'governorate'],
                    ['key' => 'Increase', 'label' => 'increase'],
                    ['key' => 'Decrease', 'label' => 'decrease'],
                    ['key' => 'Same', 'label' => 'same'],
                    ['key' => 'percent_increase', 'label' => 'percent_increase'],
                    ['key' => 'male', 'label' => 'male'],
                    ['key' => 'female', 'label' => 'female'],
                    ['key' => 'total', 'label' => 'total'],
                ],
                'rows' => $tableRows,
            ],
        ];
    }

    /** 5. Increase / Decrease / Same per partner and the % improved (programme indicator). */
    public function increaseScale(ReportFilters $f): array
    {
        $change = $this->changeExpression();
        $rows = $this->base($f, ApplicationStatus::Done, withPost: true)
            ->leftJoin('partners', 'partners.user_id', '=', 'application.partner_id')
            ->groupBy('partners.name', DB::raw($change))
            ->get([DB::raw('partners.name as partner_name'), DB::raw("{$change} as change_type"), DB::raw('count(*) as total')]);

        $data = [];
        foreach ($rows as $row) {
            $name = $row->partner_name ?? '—';
            $data[$name] ??= ['partner' => $name, 'Increase' => 0, 'Decrease' => 0, 'Same' => 0, 'total' => 0];
            $data[$name][$row->change_type] += (int) $row->total;
            $data[$name]['total'] += (int) $row->total;
        }
        ksort($data);
        $tableRows = array_map(fn ($r) => $r + ['percent_increase' => $this->percent($r['Increase'], $r['total'])], array_values($data));
        $totals = ['Increase' => array_sum(array_column($data, 'Increase')), 'Decrease' => array_sum(array_column($data, 'Decrease')), 'Same' => array_sum(array_column($data, 'Same'))];
        $all = array_sum($totals);

        return [
            'summary' => [
                ['label' => 'applications_done', 'value' => $all],
                ['label' => 'percent_improved', 'value' => $this->percent($totals['Increase'], $all).'%'],
            ],
            'charts' => [
                [
                    'type' => 'pie',
                    'title' => 'overall_change',
                    'labels' => ['increase', 'decrease', 'same'],
                    'datasets' => [['label' => 'applications', 'data' => array_values($totals)]],
                    'translateLabels' => true,
                ],
                [
                    'type' => 'bar',
                    'title' => 'change_per_partner',
                    'labels' => array_keys($data),
                    'datasets' => array_map(fn ($c) => ['label' => strtolower($c), 'data' => array_map(fn ($p) => $p[$c], array_values($data))], ['Increase', 'Decrease', 'Same']),
                    'stacked' => true,
                    'translateDatasets' => true,
                ],
            ],
            'table' => [
                'columns' => [
                    ['key' => 'partner', 'label' => 'partner'],
                    ['key' => 'Increase', 'label' => 'increase'],
                    ['key' => 'Decrease', 'label' => 'decrease'],
                    ['key' => 'Same', 'label' => 'same'],
                    ['key' => 'total', 'label' => 'total'],
                    ['key' => 'percent_increase', 'label' => 'percent_increase'],
                ],
                'rows' => $tableRows,
            ],
        ];
    }

    /** 6. Applications with a pre-test but no post-test, per partner (admin) or per collector (partner). */
    public function uncompletedPerPartner(ReportFilters $f): array
    {
        $excluded = Status::idsOf(
            ApplicationStatus::Done, ApplicationStatus::Dropout, ApplicationStatus::NotApplicable,
            ApplicationStatus::PreTestNoPermission, ApplicationStatus::PostTestNoPermission,
        );
        $query = Application::query()
            ->visibleTo($f->user)
            ->forYear($f->year)
            ->whereNotNull('application.pre_test_date')
            ->whereNull('application.post_test_date')
            ->whereNotIn('application.status', $excluded)
            ->when($f->partnerId(), fn ($q, $partner) => $q->where('application.partner_id', $partner));

        if ($f->user->isAdmin()) {
            $rows = $query->leftJoin('partners', 'partners.user_id', '=', 'application.partner_id')
                ->groupBy('partners.name')->orderBy('partners.name')
                ->get([DB::raw('partners.name as label'), DB::raw('count(*) as total')]);
            $labelKey = 'partner';
        } else {
            $name = DB::getDriverName() === 'mysql'
                ? "trim(concat(coalesce(users.firstname, ''), ' ', coalesce(users.lastname, '')))"
                : "trim(coalesce(users.firstname, '') || ' ' || coalesce(users.lastname, ''))";
            $rows = $query->leftJoin('users', 'users.id', '=', 'application.collector_id')
                ->groupBy('users.firstname', 'users.lastname')->orderBy('users.firstname')
                ->get([DB::raw("{$name} as label"), DB::raw('count(*) as total')]);
            $labelKey = 'collector';
        }

        $tableRows = $rows->map(fn ($r) => [$labelKey => $r->label ?? '—', 'total' => (int) $r->total])->all();

        return [
            'summary' => [['label' => 'uncompleted_total', 'value' => (int) $rows->sum('total')]],
            'charts' => [[
                'type' => 'bar',
                'title' => 'uncompleted_applications',
                'labels' => array_column($tableRows, $labelKey),
                'datasets' => [['label' => 'uncompleted', 'data' => array_column($tableRows, 'total')]],
            ]],
            'table' => [
                'columns' => [['key' => $labelKey, 'label' => $labelKey], ['key' => 'total', 'label' => 'total']],
                'rows' => $tableRows,
            ],
        ];
    }

    /** 7. Average pre/post totals per change group, plus per-scale averages per group. */
    public function changeAnalysis(ReportFilters $f): array
    {
        $change = $this->changeExpression();
        $selects = [DB::raw("{$change} as change_type"), DB::raw('count(*) as total'),
            DB::raw("avg({$this->num('pre.score')}) as pre_total"), DB::raw("avg({$this->num('post.score')}) as post_total")];
        foreach (self::SCALES as $column => $key) {
            $selects[] = DB::raw("avg({$this->num("pre.$column")}) as pre_{$key}");
            $selects[] = DB::raw("avg({$this->num("post.$column")}) as post_{$key}");
        }
        $rows = $this->base($f, ApplicationStatus::Done, withPost: true)
            ->groupBy(DB::raw($change))
            ->get($selects)
            ->keyBy('change_type');

        $groups = ['Increase', 'Decrease', 'Same'];
        $tableRows = [];
        foreach ($groups as $g) {
            $r = $rows->get($g);
            $row = ['group' => strtolower($g), 'count' => (int) ($r->total ?? 0), 'pre_total' => round((float) ($r->pre_total ?? 0), 2), 'post_total' => round((float) ($r->post_total ?? 0), 2)];
            foreach (self::SCALES as $key) {
                $row["pre_$key"] = round((float) ($r->{"pre_$key"} ?? 0), 2);
                $row["post_$key"] = round((float) ($r->{"post_$key"} ?? 0), 2);
            }
            $tableRows[] = $row;
        }

        $columns = [['key' => 'group', 'label' => 'group', 'translate' => true], ['key' => 'count', 'label' => 'total'],
            ['key' => 'pre_total', 'label' => 'pre_total'], ['key' => 'post_total', 'label' => 'post_total']];
        foreach (self::SCALES as $key) {
            $columns[] = ['key' => "pre_$key", 'label' => "pre_$key"];
            $columns[] = ['key' => "post_$key", 'label' => "post_$key"];
        }

        return [
            'summary' => [['label' => 'applications_done', 'value' => array_sum(array_column($tableRows, 'count'))]],
            'charts' => [
                [
                    'type' => 'bar',
                    'title' => 'average_total_by_group',
                    'labels' => array_map('strtolower', $groups),
                    'datasets' => [
                        ['label' => 'pre_test', 'data' => array_column($tableRows, 'pre_total')],
                        ['label' => 'post_test', 'data' => array_column($tableRows, 'post_total')],
                    ],
                    'translateLabels' => true,
                ],
                [
                    'type' => 'bar',
                    'title' => 'applications_by_group',
                    'labels' => array_map('strtolower', $groups),
                    'datasets' => [['label' => 'applications', 'data' => array_column($tableRows, 'count')]],
                    'translateLabels' => true,
                ],
            ],
            'table' => ['columns' => $columns, 'rows' => $tableRows],
        ];
    }

    /** 8. Per-application dataset (paginated). */
    public function analysisData(ReportFilters $f, int $page = 1): array
    {
        $paginator = $this->analysisDataQuery($f)->paginate(50, ['*'], 'page', $page)->withQueryString();
        $paginator->through(fn ($r) => $this->analysisRow($r));

        return [
            'summary' => [['label' => 'applications_done', 'value' => $paginator->total()]],
            'charts' => [],
            'table' => ['columns' => $this->analysisColumns(), 'rows' => []],
            'paginator' => $paginator,
        ];
    }

    /** Rows of analysis-data without pagination (CSV). */
    public function analysisDataRows(ReportFilters $f): \Generator
    {
        foreach ($this->analysisDataQuery($f)->lazy(500) as $r) {
            yield $this->analysisRow($r);
        }
    }

    public function analysisColumns(): array
    {
        $columns = [
            ['key' => 'code', 'label' => 'code'], ['key' => 'partner', 'label' => 'partner'],
            ['key' => 'governorate', 'label' => 'governorate'], ['key' => 'form', 'label' => 'form'],
            ['key' => 'gender', 'label' => 'gender'], ['key' => 'age', 'label' => 'age'],
            ['key' => 'nationality', 'label' => 'nationality'],
        ];
        foreach (self::SCALES as $key) {
            $columns[] = ['key' => "pre_$key", 'label' => "pre_$key"];
            $columns[] = ['key' => "post_$key", 'label' => "post_$key"];
        }
        $columns[] = ['key' => 'pre_total', 'label' => 'pre_total'];
        $columns[] = ['key' => 'post_total', 'label' => 'post_total'];
        $columns[] = ['key' => 'change', 'label' => 'change', 'translate' => true];

        return $columns;
    }

    public function activityLog(ReportFilters $f, ?string $code, int $page = 1): LengthAwarePaginator
    {
        $visible = Application::query()->visibleTo($f->user)->select('application.id');

        return ApplicationLog::query()
            ->leftJoin('application', 'application.id', '=', 'application_log.application_id')
            ->leftJoin('users', 'users.id', '=', 'application_log.causer_id')
            ->when(! $f->user->isAdmin(), fn ($q) => $q->whereIn('application_log.application_id', $visible))
            ->when($code, fn ($q) => $q->where('application.code', 'like', "%{$code}%"))
            ->orderByDesc('application_log.id')
            ->paginate(50, [
                'application_log.id', 'application_log.text', 'application_log.created_at',
                'application_log.application_id', 'application.code', 'users.firstname', 'users.lastname',
            ], 'page', $page)
            ->withQueryString()
            ->through(fn ($r) => [
                'id' => $r->id,
                'application_id' => $r->application_id,
                'code' => $r->code,
                'by' => trim(($r->firstname ?? '').' '.($r->lastname ?? '')) ?: '—',
                'text' => $r->text,
                'at' => $r->created_at ? (string) $r->created_at : null,
            ]);
    }

    // ------------------------------------------------------------------ helpers

    /**
     * Applications in a given status, joined to their pre-test (alias
     * "pre") and optionally post-test (alias "post"), with every common
     * filter applied.
     */
    private function base(ReportFilters $f, ApplicationStatus $status, bool $withPost = false): Builder
    {
        $query = Application::query()
            ->visibleTo($f->user)
            ->forYear($f->year)
            ->where('application.status', Status::idOf($status))
            ->join('application_value as pre', function ($join) {
                $join->on('pre.application_id', '=', 'application.id')->where('pre.type', 'pre_test');
            })
            ->when($f->partnerId(), fn ($q, $partner) => $q->where('application.partner_id', $partner))
            ->when($f->governorate, fn ($q) => $q->where('pre.gouvarnate', (string) $f->governorate))
            ->when($f->gender, fn ($q) => $q->where('pre.gender', $f->gender))
            ->when($f->form, fn ($q) => $q->where('pre.form', $f->form))
            ->when($f->nationality, fn ($q) => $q->where('pre.nationality', $f->nationality));

        if ($withPost) {
            $query->join('application_value as post', function ($join) {
                $join->on('post.application_id', '=', 'application.id')->where('post.type', 'post_test');
            });
        }

        return $query;
    }

    private function analysisDataQuery(ReportFilters $f): Builder
    {
        return $this->base($f, ApplicationStatus::Done, withPost: true)
            ->leftJoin('partners', 'partners.user_id', '=', 'application.partner_id')
            ->leftJoin('gouvernate', 'gouvernate.id', '=', DB::raw($this->num('pre.gouvarnate')))
            ->orderBy('application.id')
            ->select(array_merge([
                'application.id', 'application.code',
                DB::raw('partners.name as partner_name'), DB::raw('gouvernate.name as governorate_name'),
                'pre.form', 'pre.gender', 'pre.age', 'pre.nationality',
                DB::raw('pre.score as pre_total'), DB::raw('post.score as post_total'),
            ], array_merge(...array_map(fn ($column, $key) => [
                DB::raw("pre.$column as pre_$key"), DB::raw("post.$column as post_$key"),
            ], array_keys(self::SCALES), array_values(self::SCALES)))));
    }

    private function analysisRow(object $r): array
    {
        $pre = (float) $r->pre_total;
        $post = (float) $r->post_total;
        $row = [
            'id' => $r->id, 'code' => $r->code, 'partner' => $r->partner_name, 'governorate' => $r->governorate_name,
            'form' => $r->form, 'gender' => $r->gender, 'age' => $r->age, 'nationality' => $r->nationality,
        ];
        foreach (self::SCALES as $key) {
            $row["pre_$key"] = round((float) $r->{"pre_$key"}, 2);
            $row["post_$key"] = round((float) $r->{"post_$key"}, 2);
        }
        $row['pre_total'] = round($pre, 2);
        $row['post_total'] = round($post, 2);
        $row['change'] = $post > $pre ? 'decrease' : ($post < $pre ? 'increase' : 'same');

        return $row;
    }

    /** SQL expression classifying the change (post lower than pre = Increase in well-being). */
    private function changeExpression(): string
    {
        $pre = $this->num('pre.score');
        $post = $this->num('post.score');

        return "CASE WHEN {$post} < {$pre} THEN 'Increase' WHEN {$post} > {$pre} THEN 'Decrease' ELSE 'Same' END";
    }

    /** Numeric cast for the string-typed legacy score columns. */
    private function num(string $column): string
    {
        return DB::getDriverName() === 'mysql'
            ? "CAST({$column} AS DECIMAL(10,2))"
            : "CAST({$column} AS REAL)";
    }

    private function percent(int|float $part, int|float $whole): float
    {
        return $whole > 0 ? round($part / $whole * 100, 1) : 0.0;
    }

    /** Options for the filter controls. */
    public function filterOptions(ReportFilters $f): array
    {
        return [
            'partners' => $f->user->isAdmin() ? Partner::orderBy('name')->get(['user_id as id', 'name']) : [],
            'governorates' => Gouvernate::orderBy('name')->get(['id', 'name', 'arabic']),
            'genders' => FormOptions::GENDERS,
            'forms' => FormOptions::FORMS,
            'nationalities' => FormOptions::NATIONALITIES,
        ];
    }

    public static function toCsvRows(array $columns, iterable $rows): Collection
    {
        return collect($rows)->map(fn ($row) => array_map(fn ($c) => $row[$c['key']] ?? '', $columns));
    }
}
