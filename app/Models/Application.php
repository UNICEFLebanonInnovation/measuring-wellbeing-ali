<?php

namespace App\Models;

use App\Sdq\ApplicationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * One child's SDQ record: a pre-test and (later) a post-test.
 */
class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'application';

    protected $fillable = [
        'code', 'pre_test_date', 'post_test_date', 'partner_id', 'collector_id',
        'language', 'status', 'reason_option', 'reason_details', 'year', 'sequence', 'client_uuid',
    ];

    protected function casts(): array
    {
        return [
            'pre_test_date' => 'datetime',
            'post_test_date' => 'datetime',
            'year' => 'integer',
            'sequence' => 'integer',
            'status' => 'integer',
        ];
    }

    public function statusRow(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'user_id');
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function values(): HasMany
    {
        return $this->hasMany(ApplicationValue::class, 'application_id');
    }

    public function preTest(): HasOne
    {
        return $this->hasOne(ApplicationValue::class, 'application_id')->where('type', ApplicationValue::PRE_TEST);
    }

    public function postTest(): HasOne
    {
        return $this->hasOne(ApplicationValue::class, 'application_id')->where('type', ApplicationValue::POST_TEST);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ApplicationLog::class, 'application_id')->orderByDesc('id');
    }

    public function statusEnum(): ?ApplicationStatus
    {
        $name = $this->statusRow?->name ?? Status::nameOf($this->status);

        return $name ? ApplicationStatus::tryFrom($name) : null;
    }

    public function setStatus(ApplicationStatus $status): void
    {
        $this->status = Status::idOf($status);
    }

    public function hasStatus(ApplicationStatus ...$statuses): bool
    {
        $current = $this->statusEnum();

        return $current !== null && in_array($current, $statuses, true);
    }

    /**
     * Direction of change between pre and post test. A LOWER total
     * difficulties score after the programme is an improvement, which the
     * programme reports as "Increase" (in well-being).
     */
    public function change(): ?string
    {
        $pre = $this->preTest?->score;
        $post = $this->postTest?->score;
        if ($pre === null || $post === null || $pre === '' || $post === '' || $pre === 'na' || $post === 'na') {
            return null;
        }
        $pre = (float) $pre;
        $post = (float) $post;

        return match (true) {
            $post > $pre => 'Decrease',
            $post < $pre => 'Increase',
            default => 'Same',
        };
    }

    /** Scope: applications visible to the given user according to their role. */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }
        if ($user->isPartner()) {
            $collectorIds = $user->collectorUserIds();

            return $query->where(function (Builder $q) use ($user, $collectorIds) {
                $q->where('application.partner_id', $user->id)
                    ->orWhereIn('application.collector_id', $collectorIds);
            });
        }

        return $query->where('application.collector_id', $user->id);
    }

    public function scopeForYear(Builder $query, ?int $year): Builder
    {
        return $year ? $query->where('application.year', $year) : $query;
    }
}
