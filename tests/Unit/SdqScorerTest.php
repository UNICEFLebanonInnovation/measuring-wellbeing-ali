<?php

namespace Tests\Unit;

use App\Sdq\ScoringPolicy;
use App\Sdq\SdqItems;
use App\Sdq\SdqScorer;
use PHPUnit\Framework\TestCase;

class SdqScorerTest extends TestCase
{
    private function answers(array $overrides = [], string $default = '1'): array
    {
        $answers = [];
        foreach (SdqItems::all() as $item) {
            $answers[$item] = $default;
        }

        return array_merge($answers, $overrides);
    }

    public function test_all_items_answered_one_gives_five_point_five_per_scale(): void
    {
        $result = (new SdqScorer)->score($this->answers());

        // average 1 * 5 + 0.5 = 5.5 per scale; total = 4 scales (pro-social excluded)
        $this->assertSame(0, $result->naCount);
        $this->assertSame(5.5, $result->emotional);
        $this->assertSame(5.5, $result->conduct);
        $this->assertSame(5.5, $result->hyperactivity);
        $this->assertSame(5.5, $result->peerProblems);
        $this->assertSame(5.5, $result->prosocial);
        $this->assertSame(22.0, $result->total);
    }

    public function test_documented_policy_omits_na_from_the_average(): void
    {
        // Emotional scale: four items answered 2, one NA -> average 2 -> 10.5
        $answers = $this->answers([
            'often_complains_of_headaches_stomach_aches_or_sickness' => '2',
            'many_worries_or_often_seems_worried' => '2',
            'often_unhappy_depressed_or_tearful' => 'na',
            'nervous_or_clingy_in_new_situations_easily_loses_confidence' => '2',
            'many_fears_easily_scared' => '2',
        ], '0');

        $result = (new SdqScorer(ScoringPolicy::Documented))->score($answers);

        $this->assertSame(1, $result->naCount);
        $this->assertSame(10.5, $result->emotional);
        $this->assertSame(0.5, $result->conduct);
        $this->assertSame(12.0, $result->total); // 10.5 + 0.5 + 0.5 + 0.5
    }

    public function test_legacy_policy_reproduces_the_original_arithmetic(): void
    {
        // Same answers as above. Legacy: sum (8) + 0.5 = 8.5, NA contributes nothing.
        $answers = $this->answers([
            'often_complains_of_headaches_stomach_aches_or_sickness' => '2',
            'many_worries_or_often_seems_worried' => '2',
            'often_unhappy_depressed_or_tearful' => 'na',
            'nervous_or_clingy_in_new_situations_easily_loses_confidence' => '2',
            'many_fears_easily_scared' => '2',
        ], '0');

        $result = (new SdqScorer(ScoringPolicy::Legacy))->score($answers);

        $this->assertSame(1, $result->naCount);
        $this->assertSame(8.5, $result->emotional);
        $this->assertSame(0.5, $result->prosocial);
        $this->assertSame(10.0, $result->total);
    }

    public function test_policies_agree_when_there_are_no_na_answers(): void
    {
        $answers = $this->answers([], '2');
        $documented = (new SdqScorer(ScoringPolicy::Documented))->score($answers);
        $legacy = (new SdqScorer(ScoringPolicy::Legacy))->score($answers);

        $this->assertSame($documented->toArray(), $legacy->toArray());
        $this->assertSame(42.0, $documented->total); // 10.5 * 4
    }

    public function test_pro_social_scale_is_not_part_of_the_total(): void
    {
        $answers = $this->answers(array_fill_keys(SdqItems::PROSOCIAL, '2'), '0');
        $result = (new SdqScorer)->score($answers);

        $this->assertSame(10.5, $result->prosocial);
        $this->assertSame(2.0, $result->total); // 0.5 * 4
    }

    public function test_missing_items_are_ignored_and_not_counted_as_na(): void
    {
        $result = (new SdqScorer)->score(['often_loses_temper' => '2']);

        $this->assertSame(0, $result->naCount);
        $this->assertSame(10.5, $result->conduct);
        $this->assertSame(0.5, $result->emotional);
    }

    public function test_na_is_case_insensitive(): void
    {
        $result = (new SdqScorer)->score($this->answers(['often_lies_or_cheats' => 'NA']));

        $this->assertSame(1, $result->naCount);
    }
}
