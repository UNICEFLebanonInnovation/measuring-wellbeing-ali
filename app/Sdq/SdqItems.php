<?php

namespace App\Sdq;

/**
 * The 25 SDQ items grouped by scale. Column names are those of the
 * legacy application_value table (including the historical typo in
 * "often_fights_with_other_hildren_or_bullies_them") so stored data keeps
 * working unchanged.
 */
final class SdqItems
{
    public const EMOTIONAL = [
        'often_complains_of_headaches_stomach_aches_or_sickness',
        'many_worries_or_often_seems_worried',
        'often_unhappy_depressed_or_tearful',
        'nervous_or_clingy_in_new_situations_easily_loses_confidence',
        'many_fears_easily_scared',
    ];

    public const CONDUCT = [
        'often_loses_temper',
        'generally_well_behaved_usually_does_what_adults_request',
        'often_fights_with_other_hildren_or_bullies_them',
        'often_lies_or_cheats',
        'steals_from_home_school_or_elsewhere',
    ];

    public const HYPERACTIVITY = [
        'restless_overactive_cannot_stay_still_for_long',
        'constantly_fidgeting_or_squirming',
        'easily_distracted_concentration_wanders',
        'thinks_things_out_before_acting',
        'good_attention_span_sees_chores_or_homework_through_to_the_end',
    ];

    public const PEER_PROBLEMS = [
        'rather_solitary_prefers_to_play_alone',
        'has_at_least_one_good_friend',
        'generally_liked_by_other_children',
        'picked_on_or_bullied_by_other_children',
        'gets_along_better_with_adults_than_with_other_children',
    ];

    public const PROSOCIAL = [
        'considerate_of_other_peoples_feelings',
        'shares_readily_with_other_children_for_example_toys',
        'helpful_if_someone_is_hurt_upset_or_feeling_ill',
        'kind_to_younger_children',
        'often_offers_to_help_others',
    ];

    /** Scale column name => item column names. */
    public static function scales(): array
    {
        return [
            'emotional_scale' => self::EMOTIONAL,
            'conduct_scale' => self::CONDUCT,
            'hyper_activity_scale' => self::HYPERACTIVITY,
            'peer_problem_scale' => self::PEER_PROBLEMS,
            'pro_social_scale' => self::PROSOCIAL,
        ];
    }

    /** Scales that make up the total difficulties score (pro-social is excluded). */
    public static function totalScales(): array
    {
        return ['emotional_scale', 'conduct_scale', 'hyper_activity_scale', 'peer_problem_scale'];
    }

    /** All 25 item column names in questionnaire order. */
    public static function all(): array
    {
        return [
            'considerate_of_other_peoples_feelings',
            'restless_overactive_cannot_stay_still_for_long',
            'often_complains_of_headaches_stomach_aches_or_sickness',
            'shares_readily_with_other_children_for_example_toys',
            'often_loses_temper',
            'rather_solitary_prefers_to_play_alone',
            'generally_well_behaved_usually_does_what_adults_request',
            'many_worries_or_often_seems_worried',
            'helpful_if_someone_is_hurt_upset_or_feeling_ill',
            'constantly_fidgeting_or_squirming',
            'has_at_least_one_good_friend',
            'often_fights_with_other_hildren_or_bullies_them',
            'often_unhappy_depressed_or_tearful',
            'generally_liked_by_other_children',
            'easily_distracted_concentration_wanders',
            'nervous_or_clingy_in_new_situations_easily_loses_confidence',
            'kind_to_younger_children',
            'often_lies_or_cheats',
            'picked_on_or_bullied_by_other_children',
            'often_offers_to_help_others',
            'thinks_things_out_before_acting',
            'steals_from_home_school_or_elsewhere',
            'gets_along_better_with_adults_than_with_other_children',
            'many_fears_easily_scared',
            'good_attention_span_sees_chores_or_homework_through_to_the_end',
        ];
    }

    /** Allowed answer values for an item. */
    public const ANSWERS = ['0', '1', '2', 'na'];
}
