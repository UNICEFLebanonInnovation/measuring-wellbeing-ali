<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationValue;
use App\Sdq\SdqItems;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * CSV export of applications: one row per questionnaire (pre and post),
 * same column set as the legacy export so existing analysis spreadsheets
 * keep working. Streams in chunks so large exports do not exhaust memory.
 */
class ExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $user = $request->user();
        $filters = $request->validate([
            'code' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'integer'],
            'partner' => ['nullable', 'integer'],
            'collector' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        $query = Application::query()
            ->visibleTo($user)
            ->forYear($request->session()->get('year'))
            ->with(['statusRow', 'partner:id,user_id,name', 'collector:id,firstname,lastname',
                'preTest.governorate', 'preTest.cazaRow', 'preTest.areaRow',
                'postTest.governorate', 'postTest.cazaRow', 'postTest.areaRow'])
            ->when($filters['code'] ?? null, fn ($q, $v) => $q->where('application.code', 'like', "%{$v}%"))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('application.status', $v))
            ->when($filters['partner'] ?? null, fn ($q, $v) => $q->where('application.partner_id', $v))
            ->when($filters['collector'] ?? null, fn ($q, $v) => $q->where('application.collector_id', $v))
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->whereDate('application.pre_test_date', '>=', $v))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->whereDate('application.pre_test_date', '<=', $v))
            ->orderBy('application.id');

        $filename = 'applications_export_'.now()->format('Y_m_d_His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel renders Arabic correctly
            fputcsv($out, self::columns());
            $query->chunk(200, function ($applications) use ($out) {
                foreach ($applications as $application) {
                    foreach ([$application->preTest, $application->postTest] as $test) {
                        if ($test) {
                            fputcsv($out, self::row($application, $test));
                        }
                    }
                }
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public static function columns(): array
    {
        return array_merge([
            'Code', 'Type', 'Year', 'Pre Test Date', 'Post Test Date', 'Pre Test Score', 'Post Test Score', 'Change',
            'Partner', 'Collector', 'Status', 'Governorate', 'Caza', 'Area', 'Agency', 'Form', 'Donor Name',
            'Interview Date', "Interviewer's Name", 'Age', 'Gender', 'Nationality', 'Other Nationality', 'Gateway Type', 'P-Code',
            'Latitude', 'Longitude', 'Altitude', 'Accuracy', 'Consent',
        ], array_map(fn ($item) => ucfirst(str_replace('_', ' ', $item)), SdqItems::all()), [
            'Comment', "Child's code", 'Hours attended', 'Total hours in programme', 'Dropout reason',
            'Dropout justification', 'Other child protection services', 'Emotional Scale', 'Conduct Scale',
            'Hyper Activity Scale', 'Peer Problem Scale', 'Pro Social Scale', 'NA count', 'Decrease Reason', 'Decrease Note',
        ]);
    }

    public static function row(Application $application, ApplicationValue $test): array
    {
        $items = array_map(fn ($item) => $test->{$item}, SdqItems::all());

        return array_merge([
            $application->code,
            $test->type === ApplicationValue::PRE_TEST ? 'Pre test' : 'Post test',
            $application->year,
            $application->pre_test_date?->toDateString(),
            $application->post_test_date?->toDateString(),
            $application->preTest?->totalScore(),
            $application->postTest?->totalScore(),
            $application->change() ?? '-',
            $application->partner?->name,
            $application->collector?->name,
            $application->statusRow?->name,
            $test->governorate?->name,
            $test->cazaRow?->name,
            $test->areaRow?->name,
            $test->agency_name,
            $test->form,
            $test->donor_name,
            $test->interview_date,
            $test->interviewers_name,
            $test->age,
            $test->gender ? ucfirst($test->gender) : null,
            $test->nationality,
            $test->other_nationality,
            $test->gateway_type,
            $test->p_code,
            $test->latitude,
            $test->longitude,
            $test->altitude,
            $test->accuracy,
            $test->may_i_start_now === 'yes' ? 'Yes, permission is given' : 'No, permission is not given',
        ], $items, [
            $test->comment,
            $test->child_code,
            $test->number_of_hours_that_the_child_attended,
            $test->total_number_of_hours_in_your_program,
            $test->dropout_reason,
            $test->justify_the_dropout_reason,
            $test->do_the_child_receive_any_other_child_protection_services,
            $test->emotional_scale,
            $test->conduct_scale,
            $test->hyper_activity_scale,
            $test->peer_problem_scale,
            $test->pro_social_scale,
            $test->na_count,
            $application->reason_option,
            $application->reason_details,
        ]);
    }
}
