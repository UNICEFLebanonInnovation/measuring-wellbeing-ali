<?php

namespace App\Http\Controllers;

use App\Reports\ReportFilters;
use App\Reports\ReportService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reports) {}

    public function index(): Response
    {
        return Inertia::render('Reports/Index', [
            'reports' => array_map(fn ($slug) => ['slug' => $slug], ReportService::slugs()),
        ]);
    }

    public function show(Request $request, string $report): Response|StreamedResponse
    {
        abort_unless(in_array($report, ReportService::slugs(), true), 404);

        $filters = ReportFilters::fromRequest($request);

        if ($request->query('format') === 'csv') {
            return $this->csv($report, $filters);
        }

        $data = $this->reports->run($report, $filters, (int) $request->query('page', 1));

        return Inertia::render('Reports/Show', [
            'slug' => $report,
            'data' => $data,
            'filters' => $filters->toArray(),
            'availableFilters' => ReportService::REPORTS[$report]['filters'],
            'options' => $this->reports->filterOptions($filters),
            'year' => $filters->year,
        ]);
    }

    public function activityLog(Request $request): Response
    {
        $code = $request->string('code')->toString() ?: null;
        $filters = ReportFilters::fromRequest($request);

        return Inertia::render('Reports/ActivityLog', [
            'logs' => $this->reports->activityLog($filters, $code, (int) $request->query('page', 1)),
            'code' => $code,
        ]);
    }

    private function csv(string $report, ReportFilters $filters): StreamedResponse
    {
        $filename = $report.'_'.now()->format('Y_m_d_His').'.csv';

        return response()->streamDownload(function () use ($report, $filters) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            if ($report === 'analysis-data') {
                $columns = $this->reports->analysisColumns();
                fputcsv($out, array_column($columns, 'label'));
                foreach ($this->reports->analysisDataRows($filters) as $row) {
                    fputcsv($out, array_map(fn ($c) => $row[$c['key']] ?? '', $columns));
                }
            } else {
                $data = $this->reports->run($report, $filters);
                foreach (array_filter([$data['table'] ?? null, $data['secondaryTable'] ?? null]) as $i => $table) {
                    if ($i > 0) {
                        fputcsv($out, []);
                    }
                    fputcsv($out, array_column($table['columns'], 'label'));
                    foreach ($table['rows'] as $row) {
                        fputcsv($out, array_map(fn ($c) => $row[$c['key']] ?? '', $table['columns']));
                    }
                }
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
