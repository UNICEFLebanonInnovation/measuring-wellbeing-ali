<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model {
	protected $table = "application";

	protected $fillable = [
		'code',
		'pre_test_date',
		'post_test_date',
		'collector_id',
		'partner_id',
		'status',
	];

	public function countScore($formData) {
		$emotionalScale = 0;
		$naCount = 0;
		if (isset($formData['often_complains_of_headaches_stomach_aches_or_sickness']) && !empty($formData['often_complains_of_headaches_stomach_aches_or_sickness'])) {
			if ($formData['often_complains_of_headaches_stomach_aches_or_sickness'] != "na") {
				$emotionalScale += intval($formData['often_complains_of_headaches_stomach_aches_or_sickness']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['many_worries_or_often_seems_worried']) && !empty($formData['many_worries_or_often_seems_worried'])) {
			if ($formData['many_worries_or_often_seems_worried'] != "na") {
				$emotionalScale += intval($formData['many_worries_or_often_seems_worried']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['often_unhappy_depressed_or_tearful']) && !empty($formData['often_unhappy_depressed_or_tearful'])) {
			if ($formData['often_unhappy_depressed_or_tearful'] != "na") {
				$emotionalScale += intval($formData['often_unhappy_depressed_or_tearful']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['nervous_or_clingy_in_new_situations_easily_loses_confidence']) && !empty($formData['nervous_or_clingy_in_new_situations_easily_loses_confidence'])) {
			if ($formData['nervous_or_clingy_in_new_situations_easily_loses_confidence'] != "na") {
				$emotionalScale += intval($formData['nervous_or_clingy_in_new_situations_easily_loses_confidence']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['many_fears_easily_scared']) && !empty($formData['many_fears_easily_scared'])) {
			if ($formData['many_fears_easily_scared'] != "na") {
				$emotionalScale += intval($formData['many_fears_easily_scared']);
			} else {
				$naCount++;
			}
		}

		$conductScale = 0;
		if (isset($formData['often_loses_temper']) && !empty($formData['often_loses_temper'])) {
			if ($formData['often_loses_temper'] != "na") {
				$conductScale += intval($formData['often_loses_temper']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['generally_well_behaved_usually_does_what_adults_request']) && !empty($formData['generally_well_behaved_usually_does_what_adults_request'])) {
			if ($formData['generally_well_behaved_usually_does_what_adults_request'] != "na") {
				$conductScale += intval($formData['generally_well_behaved_usually_does_what_adults_request']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['often_fights_with_other_hildren_or_bullies_them']) && !empty($formData['often_fights_with_other_hildren_or_bullies_them'])) {
			if ($formData['often_fights_with_other_hildren_or_bullies_them'] != "na") {
				$conductScale += intval($formData['often_fights_with_other_hildren_or_bullies_them']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['often_lies_or_cheats']) && !empty($formData['often_lies_or_cheats'])) {
			if ($formData['often_lies_or_cheats'] != "na") {
				$conductScale += intval($formData['often_lies_or_cheats']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['steals_from_home_school_or_elsewhere']) && !empty($formData['steals_from_home_school_or_elsewhere'])) {
			if ($formData['steals_from_home_school_or_elsewhere'] != "na") {
				$conductScale += intval($formData['steals_from_home_school_or_elsewhere']);
			} else {
				$naCount++;
			}
		}

		$hyperactivityScale = 0;
		if (isset($formData['restless_overactive_cannot_stay_still_for_long']) && !empty($formData['restless_overactive_cannot_stay_still_for_long'])) {
			if ($formData['restless_overactive_cannot_stay_still_for_long'] != "na") {
				$hyperactivityScale += intval($formData['restless_overactive_cannot_stay_still_for_long']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['constantly_fidgeting_or_squirming']) && !empty($formData['constantly_fidgeting_or_squirming'])) {
			if ($formData['constantly_fidgeting_or_squirming'] != "na") {
				$hyperactivityScale += intval($formData['constantly_fidgeting_or_squirming']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['easily_distracted_concentration_wanders']) && !empty($formData['easily_distracted_concentration_wanders'])) {
			if ($formData['easily_distracted_concentration_wanders'] != "na") {
				$hyperactivityScale += intval($formData['easily_distracted_concentration_wanders']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['thinks_things_out_before_acting']) && !empty($formData['thinks_things_out_before_acting'])) {
			if ($formData['thinks_things_out_before_acting'] != "na") {
				$hyperactivityScale += intval($formData['thinks_things_out_before_acting']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['good_attention_span_sees_chores_or_homework_through_to_the_end']) && !empty($formData['good_attention_span_sees_chores_or_homework_through_to_the_end'])) {
			if ($formData['good_attention_span_sees_chores_or_homework_through_to_the_end'] != "na") {
				$hyperactivityScale += intval($formData['good_attention_span_sees_chores_or_homework_through_to_the_end']);
			} else {
				$naCount++;
			}
		}

		$peerProblemScale = 0;
		if (isset($formData['rather_solitary_prefers_to_play_alone']) && !empty($formData['rather_solitary_prefers_to_play_alone'])) {
			if ($formData['rather_solitary_prefers_to_play_alone'] != "na") {
				$peerProblemScale += intval($formData['rather_solitary_prefers_to_play_alone']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['has_at_least_one_good_friend']) && !empty($formData['has_at_least_one_good_friend'])) {
			if ($formData['has_at_least_one_good_friend'] != "na") {
				$peerProblemScale += intval($formData['has_at_least_one_good_friend']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['generally_liked_by_other_children']) && !empty($formData['generally_liked_by_other_children'])) {
			if ($formData['generally_liked_by_other_children'] != "na") {
				$peerProblemScale += intval($formData['generally_liked_by_other_children']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['picked_on_or_bullied_by_other_children']) && !empty($formData['picked_on_or_bullied_by_other_children'])) {
			if ($formData['picked_on_or_bullied_by_other_children'] != "na") {
				$peerProblemScale += intval($formData['picked_on_or_bullied_by_other_children']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['gets_along_better_with_adults_than_with_other_children']) && !empty($formData['gets_along_better_with_adults_than_with_other_children'])) {
			if ($formData['gets_along_better_with_adults_than_with_other_children'] != "na") {
				$peerProblemScale += intval($formData['gets_along_better_with_adults_than_with_other_children']);
			} else {
				$naCount++;
			}
		}

		$proSocialScale = 0;
		if (isset($formData['considerate_of_other_peoples_feelings']) && !empty($formData['considerate_of_other_peoples_feelings'])) {
			if ($formData['considerate_of_other_peoples_feelings'] != "na") {
				$proSocialScale += intval($formData['considerate_of_other_peoples_feelings']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['shares_readily_with_other_children_for_example_toys']) && !empty($formData['shares_readily_with_other_children_for_example_toys'])) {
			if ($formData['shares_readily_with_other_children_for_example_toys'] != "na") {
				$proSocialScale += intval($formData['shares_readily_with_other_children_for_example_toys']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['helpful_if_someone_is_hurt_upset_or_feeling_ill']) && !empty($formData['helpful_if_someone_is_hurt_upset_or_feeling_ill'])) {
			if ($formData['helpful_if_someone_is_hurt_upset_or_feeling_ill'] != "na") {
				$proSocialScale += intval($formData['helpful_if_someone_is_hurt_upset_or_feeling_ill']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['kind_to_younger_children']) && !empty($formData['kind_to_younger_children'])) {
			if ($formData['kind_to_younger_children'] != "na") {
				$proSocialScale += intval($formData['kind_to_younger_children']);
			} else {
				$naCount++;
			}
		}
		if (isset($formData['often_offers_to_help_others']) && !empty($formData['often_offers_to_help_others'])) {
			if ($formData['often_offers_to_help_others'] != "na") {
				$proSocialScale += intval($formData['often_offers_to_help_others']);
			} else {
				$naCount++;
			}
		}

		$finalEmotionalScale = (($emotionalScale / 5) * 5) + 0.5;
		$finalConductScale = (($conductScale / 5) * 5) + 0.5;
		$finalhyperactivityScale = (($hyperactivityScale / 5) * 5) + 0.5;
		$finalPeerProblemScale = (($peerProblemScale / 5) * 5) + 0.5;
		$finalProSocialScale = (($proSocialScale / 5) * 5) + 0.5;

		$score = [
			'na_count' => $naCount,
			'emotional_scale' => $finalEmotionalScale,
			'conduct_scale' => $finalConductScale,
			'hyper_activity_scale' => $finalhyperactivityScale,
			'peer_problem_scale' => $finalPeerProblemScale,
			'pro_social_scale' => $finalProSocialScale,
			'score' => floatval($finalEmotionalScale) + floatval($finalConductScale) + floatval($finalhyperactivityScale) + floatval($finalPeerProblemScale),
		];
		return $score;
		/*$score = floatval($finalEmotionalScale) + floatval($finalhyperactivityScale) + floatval($finalConductScale) + floatval($finalPeerProblemScale);

        return intval($score);*/
	}

	public function get_application_value() {
		return $this->hasMany('App\Applicationvalue', 'application_id', 'id');
	}

}
