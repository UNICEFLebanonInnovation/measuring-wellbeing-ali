<?php

namespace App\Sdq;

use App\Models\Application;
use App\Models\ApplicationLog;
use App\Models\ApplicationValue;
use App\Models\Partner;
use App\Models\Status;
use App\Models\User;
use App\Notifications\PartnerQuotaReached;
use App\Sdq\Exceptions\WorkflowException;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * The single place where applications are created and move through the
 * workflow. Used by the web controllers, the v1 API and the legacy API so
 * every channel applies the same rules (scoring, NA rule, quota, status).
 */
final class ApplicationService
{
    public function __construct(
        private readonly ApplicationCodeGenerator $codes,
        private readonly SdqScorer $scorer,
    ) {}

    public static function make(): self
    {
        return new self(ApplicationCodeGenerator::fromConfig(), SdqScorer::fromConfig());
    }

    /**
     * Create a new (empty) application for a collector. When a client uuid
     * is supplied and an application with that uuid already exists, the
     * existing one is returned (idempotent sync).
     */
    public function create(User $collector, ?string $clientUuid = null, ?string $language = null): Application
    {
        $this->assertCanWrite($collector);

        if ($clientUuid) {
            $existing = Application::where('client_uuid', $clientUuid)->first();
            if ($existing) {
                return $existing;
            }
        }

        return DB::transaction(function () use ($collector, $clientUuid, $language) {
            $reserved = $this->codes->next($collector);
            /** @var Partner $partner */
            $partner = $reserved['partner'];

            $this->assertQuota($partner, $reserved['year']);

            $application = Application::create([
                'code' => $reserved['code'],
                'sequence' => $reserved['sequence'],
                'year' => $reserved['year'],
                'collector_id' => $collector->id,
                'partner_id' => $partner->user_id,
                'language' => $language,
                'client_uuid' => $clientUuid,
                'status' => Status::idOf(ApplicationStatus::PreTest),
            ]);

            $this->log($application, $collector, 'Application created');

            return $application;
        });
    }

    /**
     * Save (draft) or submit the pre-test answers.
     *
     * @param  array<string, mixed>  $data  validated questionnaire fields
     */
    public function savePreTest(Application $application, array $data, bool $submit, User $actor): Application
    {
        $this->assertCanWrite($actor);
        if (! $application->statusEnum()?->allowsPreTestEdit()) {
            throw new WorkflowException(__('messages.one_time_pre_test_error'));
        }

        return DB::transaction(function () use ($application, $data, $submit, $actor) {
            $values = $this->prepareValues($data);
            $values['type'] = ApplicationValue::PRE_TEST;

            if (($values['may_i_start_now'] ?? null) === 'no') {
                $this->upsertValues($application, ApplicationValue::PRE_TEST, $values);
                $application->setStatus(ApplicationStatus::PreTestNoPermission);
                $application->pre_test_date ??= now();
                $application->save();
                $this->log($application, $actor, 'Pre-test recorded without consent');

                return $application->refresh();
            }

            if (! $submit) {
                $this->upsertValues($application, ApplicationValue::PRE_TEST, $values);
                $application->setStatus(ApplicationStatus::PreTestPending);
                $application->save();
                $this->log($application, $actor, 'Pre-test saved as draft');

                return $application->refresh();
            }

            $score = $this->scorer->score($values);
            $values = array_merge($values, $score->toArray());
            $this->upsertValues($application, ApplicationValue::PRE_TEST, $values);

            $application->pre_test_date = $this->date($values['interview_date'] ?? null);
            $application->year ??= (int) $application->pre_test_date->format('Y');

            if ($score->naCount > (int) config('sdq.max_na_answers', 3)) {
                $application->setStatus(ApplicationStatus::NotApplicable);
                $application->save();
                $this->log($application, $actor, 'Pre-test submitted with too many NA answers; application set to NA');
            } else {
                $application->setStatus(ApplicationStatus::PostTest);
                $application->save();
                $this->log($application, $actor, 'Pre-test submitted');
            }

            return $application->refresh();
        });
    }

    /**
     * Save (draft) or submit the post-test answers.
     */
    public function savePostTest(Application $application, array $data, bool $submit, User $actor): Application
    {
        $this->assertCanWrite($actor);
        if (! $application->statusEnum()?->allowsPostTestEdit()) {
            throw new WorkflowException(__('messages.one_time_post_test_error'));
        }

        return DB::transaction(function () use ($application, $data, $submit, $actor) {
            $values = $this->prepareValues($data);
            $values['type'] = ApplicationValue::POST_TEST;

            if (($values['may_i_start_now'] ?? null) === 'no') {
                $this->upsertValues($application, ApplicationValue::POST_TEST, $values);
                $application->setStatus(ApplicationStatus::PostTestNoPermission);
                $application->save();
                $this->log($application, $actor, 'Post-test recorded without consent');

                return $application->refresh();
            }

            if (! $submit) {
                $this->upsertValues($application, ApplicationValue::POST_TEST, $values);
                $application->setStatus(ApplicationStatus::PostTestPending);
                $application->save();
                $this->log($application, $actor, 'Post-test saved as draft');

                return $application->refresh();
            }

            $score = $this->scorer->score($values);
            $values = array_merge($values, $score->toArray());
            $this->upsertValues($application, ApplicationValue::POST_TEST, $values);

            $application->post_test_date = $this->date($values['interview_date'] ?? null);

            if ($score->naCount > (int) config('sdq.max_na_answers', 3)) {
                $application->setStatus(ApplicationStatus::NotApplicable);
                $this->log($application, $actor, 'Post-test submitted with too many NA answers; application set to NA');
            } elseif (($values['dropout_reason'] ?? FormOptions::DID_NOT_DROP_OUT) !== FormOptions::DID_NOT_DROP_OUT) {
                $application->setStatus(ApplicationStatus::Dropout);
                $this->log($application, $actor, 'Post-test submitted; child dropped out ('.$values['dropout_reason'].')');
            } else {
                $application->setStatus(ApplicationStatus::Done);
                $this->log($application, $actor, 'Post-test submitted; application done');
            }
            $application->save();

            return $application->refresh();
        });
    }

    public function transferCollector(Application $application, User $newCollector, User $actor): Application
    {
        if ($application->hasStatus(ApplicationStatus::Done)) {
            throw new WorkflowException('A completed application cannot be transferred.');
        }
        if (! $newCollector->isCollector()) {
            throw new WorkflowException('Target user is not a collector.');
        }
        $application->collector_id = $newCollector->id;
        $application->save();
        $this->log($application, $actor, 'Application transferred to collector '.$newCollector->name);

        return $application;
    }

    public function setDecreaseReason(Application $application, array $reasons, ?string $details, User $actor): Application
    {
        $application->reason_option = $reasons ? implode(' | ', $reasons) : null;
        $application->reason_details = $details;
        $application->save();
        $this->log($application, $actor, $reasons ? 'Decrease reason recorded' : 'Decrease reason cleared');

        return $application;
    }

    public function delete(Application $application, User $actor): void
    {
        $this->log($application, $actor, 'Application deleted');
        $application->delete();
    }

    public function log(Application $application, ?User $actor, string $text): void
    {
        $who = $actor ? trim($actor->getRoleNames()->first().' '.$actor->name) : 'system';
        ApplicationLog::create([
            'application_id' => $application->id,
            'causer_id' => $actor?->id,
            'text' => $text.' by '.$who,
        ]);
    }

    /** Number of applications a partner has created (per year when configured). */
    public function partnerUsage(Partner $partner, ?int $year = null): int
    {
        $collectorIds = $partner->collectors()->pluck('user_id')->all();
        $query = Application::query()->where(function ($q) use ($partner, $collectorIds) {
            $q->where('partner_id', $partner->user_id)->orWhereIn('collector_id', $collectorIds);
        });
        if (config('sdq.quota_per_year', true) && $year) {
            $query->where('year', $year);
        }

        return $query->count();
    }

    private function assertQuota(Partner $partner, int $year): void
    {
        $max = (int) $partner->max_app_per_year;
        if ($max <= 0) {
            return;
        }
        $used = $this->partnerUsage($partner, $year);
        if ($used >= $max) {
            $partner->user?->notify(new PartnerQuotaReached($partner, $max));
            throw new WorkflowException("The partner's maximum of {$max} applications for {$year} has been reached.");
        }
    }

    private function assertCanWrite(User $user): void
    {
        if ($user->is_readonly) {
            throw new WorkflowException('This account is read-only and cannot submit applications.');
        }
        if (! $user->is_active) {
            throw new WorkflowException('This account is inactive.');
        }
    }

    /** Keep only questionnaire columns and normalise multi-valued fields. */
    private function prepareValues(array $data): array
    {
        $allowed = array_merge(
            ['category', 'child_code', 'gouvarnate', 'caza', 'area', 'agency_name', 'form', 'donor_name',
                'interview_date', 'interviewers_name', 'age', 'gender', 'nationality', 'other_nationality',
                'gateway_type', 'p_code', 'latitude', 'longitude', 'altitude', 'accuracy', 'may_i_start_now',
                'comment', 'number_of_hours_that_the_child_attended', 'total_number_of_hours_in_your_program',
                'dropout_reason', 'justify_the_dropout_reason', 'do_the_child_receive_any_other_child_protection_services'],
            SdqItems::all(),
        );
        $values = Arr::only($data, $allowed);
        $services = $values['do_the_child_receive_any_other_child_protection_services'] ?? null;
        if (is_array($services)) {
            $values['do_the_child_receive_any_other_child_protection_services'] = implode(',', $services);
        }
        foreach (SdqItems::all() as $item) {
            if (array_key_exists($item, $values) && $values[$item] !== null) {
                $values[$item] = strtolower((string) $values[$item]);
            }
        }

        return $values;
    }

    private function upsertValues(Application $application, string $type, array $values): ApplicationValue
    {
        $values['application_id'] = $application->id;
        $row = ApplicationValue::where('application_id', $application->id)->where('type', $type)->first();
        if ($row) {
            $row->fill($values)->save();

            return $row;
        }

        return ApplicationValue::create($values);
    }

    private function date(?string $value): Carbon
    {
        try {
            return $value ? Carbon::parse($value) : now();
        } catch (\Throwable) {
            return now();
        }
    }
}
