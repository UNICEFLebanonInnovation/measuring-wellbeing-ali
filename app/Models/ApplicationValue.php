<?php

namespace App\Models;

use App\Sdq\SdqItems;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The answers of one questionnaire (pre-test or post-test) plus the
 * computed scale scores.
 */
class ApplicationValue extends Model
{
    use HasFactory;

    public const PRE_TEST = 'pre_test';

    public const POST_TEST = 'post_test';

    protected $table = 'application_value';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'emotional_scale' => 'float',
            'conduct_scale' => 'float',
            'hyper_activity_scale' => 'float',
            'peer_problem_scale' => 'float',
            'pro_social_scale' => 'float',
            'na_count' => 'integer',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Gouvernate::class, 'gouvarnate');
    }

    public function cazaRow(): BelongsTo
    {
        return $this->belongsTo(Caza::class, 'caza');
    }

    public function areaRow(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area');
    }

    /** The 25 raw item answers keyed by column. */
    public function answers(): array
    {
        return collect(SdqItems::all())->mapWithKeys(fn ($item) => [$item => $this->{$item}])->all();
    }

    public function totalScore(): ?float
    {
        $score = $this->score;
        if ($score === null || $score === '' || $score === 'na') {
            return null;
        }

        return (float) $score;
    }

    public function servicesList(): array
    {
        $raw = $this->do_the_child_receive_any_other_child_protection_services;

        return $raw ? array_values(array_filter(array_map('trim', explode(',', $raw)))) : [];
    }
}
