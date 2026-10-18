<?php

namespace App\Sdq;

final readonly class ScoreResult
{
    public function __construct(
        public int $naCount,
        public float $emotional,
        public float $conduct,
        public float $hyperactivity,
        public float $peerProblems,
        public float $prosocial,
        public float $total,
    ) {}

    /** Keys match the application_value columns. */
    public function toArray(): array
    {
        return [
            'na_count' => $this->naCount,
            'emotional_scale' => $this->emotional,
            'conduct_scale' => $this->conduct,
            'hyper_activity_scale' => $this->hyperactivity,
            'peer_problem_scale' => $this->peerProblems,
            'pro_social_scale' => $this->prosocial,
            'score' => $this->total,
        ];
    }
}
