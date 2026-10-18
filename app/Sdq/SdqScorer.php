<?php

namespace App\Sdq;

/**
 * Computes the five SDQ scale scores and the total difficulties score for
 * one questionnaire (a pre-test or a post-test).
 *
 * Answers are the raw item values as stored: "0", "1", "2" or "na".
 * Items that are missing or empty are ignored and are NOT counted as NA,
 * mirroring the legacy behaviour.
 */
final class SdqScorer
{
    public function __construct(private readonly ScoringPolicy $policy = ScoringPolicy::Documented) {}

    public static function fromConfig(): self
    {
        return new self(ScoringPolicy::from(config('sdq.scoring_policy', ScoringPolicy::Documented->value)));
    }

    public function policy(): ScoringPolicy
    {
        return $this->policy;
    }

    /**
     * @param  array<string, mixed>  $answers  item column => "0"|"1"|"2"|"na"
     */
    public function score(array $answers): ScoreResult
    {
        $naCount = 0;
        $scales = [];

        foreach (SdqItems::scales() as $scale => $items) {
            $sum = 0;
            $answered = 0;
            foreach ($items as $item) {
                $value = $answers[$item] ?? null;
                if ($value === null || $value === '') {
                    continue; // not provided at all
                }
                if (strtolower((string) $value) === 'na') {
                    $naCount++;

                    continue;
                }
                $sum += (int) $value;
                $answered++;
            }

            $scales[$scale] = match ($this->policy) {
                ScoringPolicy::Legacy => $sum + 0.5,
                ScoringPolicy::Documented => $answered > 0
                    ? round(($sum / $answered) * 5 + 0.5, 2)
                    : 0.5,
            };
        }

        $total = 0.0;
        foreach (SdqItems::totalScales() as $scale) {
            $total += $scales[$scale];
        }

        return new ScoreResult(
            naCount: $naCount,
            emotional: $scales['emotional_scale'],
            conduct: $scales['conduct_scale'],
            hyperactivity: $scales['hyper_activity_scale'],
            peerProblems: $scales['peer_problem_scale'],
            prosocial: $scales['pro_social_scale'],
            total: round($total, 2),
        );
    }
}
