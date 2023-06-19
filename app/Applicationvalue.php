<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicationvalue extends Model
{
    protected $table = "application_value";

    protected $fillable = [
        'agency_name',
        'application_id',
        'category',
        'p_code',
        'score',
        'form',
        'child_code',
        'type',
        'donor_name',
        'interview_date',
        'interviewers_name',
        'age',
        'gender',
        'nationality',
        'gouvarnate',
        'caza',
        'area',
        'gateway_type',
        'latitude',
        'longitude',
        'altitude',
        'accuracy',
        'may_i_start_now',
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
        'thinks_things_out_before_acting',
        'steals_from_home_school_or_elsewhere',
        'gets_along_better_with_adults_than_with_other_children',
        'many_fears_easily_scared',
        'good_attention_span_sees_chores_or_homework_through_to_the_end',
        'often_offers_to_help_others',
        'comment',
        'number_of_hours_that_the_child_attended',
        'total_number_of_hours_in_your_program',
        'dropout_reason',
        "do_the_child_receive_any_other_child_protection_services",
        'justify_the_dropout_reason',
        "emotional_scale",
        "conduct_scale",
        "hyper_activity_scale",
        "peer_problem_scale",
        "pro_social_scale"
    ];
}
