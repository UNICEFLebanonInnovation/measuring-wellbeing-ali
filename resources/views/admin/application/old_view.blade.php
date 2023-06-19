@extends('admin.layout.app')

@section('title',$data['application']['code'])

@section('breadcrumb')
	<a href="{{ url('/application-list') }}">Application List</a>
@endsection

@section('css')
	<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@php
	/*echo "<pre>";
	print_r($data);
	exit();*/
@endphp
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								{{ $data['application']['code'] }} Detail
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						@if(isset($data['application']['pre_test_date']) && !empty($data['application']['pre_test_date']))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Pre Test Date:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $data['application']['pre_test_date'] }}
							</span>
						</div>
						@endif
						@if(isset($data['application']['post_test_date']) && !empty($data['application']['post_test_date']))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Post Test Date:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $data['application']['post_test_date'] }}
							</span>
						</div>
						@endif
						@if(isset($data['application']['collector_name']) && !empty($data['application']['collector_name']))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Collector:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $data['application']['collector_name'] }}
							</span>
						</div>
						@endif

						@if(isset($data['application']['partner_name']) && !empty($data['application']['partner_name']))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Parter:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $data['application']['partner_name'] }}
							</span>
						</div>
						@endif

						@if(isset($data['application']['status_name']) && !empty($data['application']['status_name']))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Status:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $data['application']['status_name'] }}
							</span>
						</div>
						@endif
						@if(isset($data['application']['pre_test_date']) && !empty($data['application']['pre_test_date']))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Change:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $data['change'] }}
							</span>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3"></div>
	</div>
	<div class="row">
		<div class="col-xl-12">
			<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Application Test Result
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<table class="table table-striped- table-bordered table-hover" id="m_table_1">
						<thead>
							<tr>
								<th>Questions</th>
								<th>Pre Test Value</th>
								<th>Post Test Value</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{ trans('messages.agency_name') }}
								</td>
								<td>@if(isset($data['pre_test']['agency_name'])) {{ $data['pre_test']['agency_name'] }} @endif</td>
								<td>@if(isset($data['post_test']['agency_name'])) {{ $data['post_test']['agency_name'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.Form') }}
								</td>
								<td>@if(isset($data['pre_test']['form'])) {{ $data['pre_test']['form'] }} @endif</td>
								<td>@if(isset($data['post_test']['form'])) {{ $data['post_test']['form'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.donor_name') }}
								</td>
								<td>@if(isset($data['pre_test']['donor_name'])) {{ $data['pre_test']['donor_name'] }} @endif</td>
								<td>@if(isset($data['post_test']['donor_name'])) {{ $data['post_test']['donor_name'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.interview_date') }}
								</td>
								<td>@if(isset($data['pre_test']['interview_date'])) {{ $data['pre_test']['interview_date'] }} @endif</td>
								<td>@if(isset($data['post_test']['interview_date'])) {{ $data['post_test']['interview_date'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.interviewrs_name') }}
								</td>
								<td>@if(isset($data['pre_test']['interviewers_name'])) {{ $data['pre_test']['interviewers_name'] }} @endif</td>
								<td>@if(isset($data['post_test']['interviewers_name'])) {{ $data['post_test']['interviewers_name'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.age') }}
								</td>
								<td>@if(isset($data['pre_test']['age'])) {{ $data['pre_test']['age'] }} @endif</td>
								<td>@if(isset($data['post_test']['age'])) {{ $data['post_test']['age'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.gender') }}
								</td>
								<td>@if(isset($data['pre_test']['gender'])) {{ $data['pre_test']['gender'] }} @endif</td>
								<td>@if(isset($data['post_test']['gender'])) {{ $data['post_test']['gender'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.nationality') }}
								</td>
								<td>@if(isset($data['pre_test']['nationality'])) {{ $data['pre_test']['nationality'] }} @endif</td>
								<td>@if(isset($data['post_test']['nationality'])) {{ $data['post_test']['nationality'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.total_number_of_hours_in_your_program') }}
								</td>
								<td>@if(isset($data['pre_test']['total_number_of_hours_in_your_program'])) {{ $data['pre_test']['total_number_of_hours_in_your_program'] }} @endif</td>
								<td>@if(isset($data['post_test']['total_number_of_hours_in_your_program'])) {{ $data['post_test']['total_number_of_hours_in_your_program'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.number_of_hours_that_the_child_attended') }}
								</td>
								<td>@if(isset($data['pre_test']['number_of_hours_that_the_child_attended'])) {{ $data['pre_test']['number_of_hours_that_the_child_attended'] }} @endif</td>
								<td>@if(isset($data['post_test']['number_of_hours_that_the_child_attended'])) {{ $data['post_test']['number_of_hours_that_the_child_attended'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.dropout_reason') }}
								</td>
								<td>@if(isset($data['pre_test']['dropout_reason'])) {{ $data['pre_test']['dropout_reason'] }} @endif</td>
								<td>@if(isset($data['post_test']['dropout_reason'])) {{ $data['post_test']['dropout_reason'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.justify_the_dropout_reason') }}
								</td>
								<td>@if(isset($data['pre_test']['justify_the_dropout_reason'])) {{ $data['pre_test']['justify_the_dropout_reason'] }} @endif</td>
								<td>@if(isset($data['post_test']['justify_the_dropout_reason'])) {{ $data['post_test']['justify_the_dropout_reason'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.gouvarnate') }}
								</td>
								<td>@if(isset($data['pre_test']['gouvername_name'])) {{ $data['pre_test']['gouvername_name'] }} @endif</td>
								<td>@if(isset($data['post_test']['gouvername_name'])) {{ $data['post_test']['gouvername_name'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.caza') }}
								</td>
								<td>@if(isset($data['pre_test']['caza_name'])) {{ $data['pre_test']['caza_name'] }} @endif</td>
								<td>@if(isset($data['post_test']['caza_name'])) {{ $data['post_test']['caza_name'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.area') }}
								</td>
								<td>@if(isset($data['pre_test']['area_name'])) {{ $data['pre_test']['area_name'] }} @endif</td>
								<td>@if(isset($data['post_test']['area_name'])) {{ $data['post_test']['area_name'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.gateway_type') }}
								</td>
								<td>@if(isset($data['pre_test']['gateway_type'])) {{ $data['pre_test']['gateway_type'] }} @endif</td>
								<td>@if(isset($data['post_test']['gateway_type'])) {{ $data['post_test']['gateway_type'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.p_code') }}
								</td>
								<td>@if(isset($data['pre_test']['p_code'])) {{ $data['pre_test']['p_code'] }} @endif</td>
								<td>@if(isset($data['post_test']['p_code'])) {{ $data['post_test']['p_code'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.latitude') }}
								</td>
								<td>@if(isset($data['pre_test']['latitude'])) {{ $data['pre_test']['latitude'] }} @endif</td>
								<td>@if(isset($data['post_test']['latitude'])) {{ $data['post_test']['latitude'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.longitude') }}
								</td>
								<td>@if(isset($data['pre_test']['longitude'])) {{ $data['pre_test']['longitude'] }} @endif</td>
								<td>@if(isset($data['post_test']['longitude'])) {{ $data['post_test']['longitude'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.altitude') }}
								</td>
								<td>@if(isset($data['pre_test']['altitude'])) {{ $data['pre_test']['altitude'] }}@endif</td>
								<td>@if(isset($data['post_test']['altitude'])) {{ $data['post_test']['altitude'] }}@endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.accuracy') }}
								</td>
								<td>@if(isset($data['post_test']['accuracy'])) {{ $data['post_test']['accuracy'] }} @endif</td>
								<td>@if(isset($data['post_test']['accuracy'])) {{ $data['post_test']['accuracy'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.considerate_of_other_peoples_feelings') }}
								</td>
								<td>@if(isset($data['pre_test']['considerate_of_other_peoples_feelings'])) {{ $data['pre_test']['considerate_of_other_peoples_feelings'] }} @endif</td>
								<td>@if(isset($data['post_test']['considerate_of_other_peoples_feelings'])) {{ $data['post_test']['considerate_of_other_peoples_feelings'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.restless_overactive_cannot_stay_still_for_long') }}
								</td>
								<td>@if(isset($data['pre_test']['restless_overactive_cannot_stay_still_for_long'])) {{ $data['pre_test']['restless_overactive_cannot_stay_still_for_long'] }} @endif</td>
								<td>@if(isset($data['post_test']['restless_overactive_cannot_stay_still_for_long'])) {{ $data['post_test']['restless_overactive_cannot_stay_still_for_long'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.often_complains_of_headaches_stomach_aches_or_sickness') }}
								</td>
								<td>@if(isset($data['pre_test']['often_complains_of_headaches_stomach_aches_or_sickness'])) {{ $data['pre_test']['often_complains_of_headaches_stomach_aches_or_sickness'] }} @endif</td>
								<td>@if(isset($data['post_test']['often_complains_of_headaches_stomach_aches_or_sickness'])) {{ $data['post_test']['often_complains_of_headaches_stomach_aches_or_sickness'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.shares_readily_with_other_children_for_example_toys') }}
								</td>
								<td>@if(isset($data['pre_test']['shares_readily_with_other_children_for_example_toys'])) {{ $data['pre_test']['shares_readily_with_other_children_for_example_toys'] }} @endif</td>
								<td>@if(isset($data['post_test']['shares_readily_with_other_children_for_example_toys'])) {{ $data['post_test']['shares_readily_with_other_children_for_example_toys'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.often_loses_temper') }}
								</td>
								<td>@if(isset($data['pre_test']['often_loses_temper'])) {{ $data['pre_test']['often_loses_temper'] }} @endif</td>
								<td>@if(isset($data['post_test']['often_loses_temper'])) {{ $data['post_test']['often_loses_temper'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.rather_solitary_prefers_to_play_alone') }}
								</td>
								<td>@if(isset($data['pre_test']['rather_solitary_prefers_to_play_alone'])) {{ $data['pre_test']['rather_solitary_prefers_to_play_alone'] }} @endif</td>
								<td>@if(isset($data['post_test']['rather_solitary_prefers_to_play_alone'])) {{ $data['post_test']['rather_solitary_prefers_to_play_alone'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.generally_well_behaved_usually_does_what_adults_request') }}
								</td>
								<td>@if(isset($data['pre_test']['generally_well_behaved_usually_does_what_adults_request'])) {{ $data['pre_test']['generally_well_behaved_usually_does_what_adults_request'] }} @endif</td>
								<td>@if(isset($data['post_test']['generally_well_behaved_usually_does_what_adults_request'])) {{ $data['post_test']['generally_well_behaved_usually_does_what_adults_request'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.many_worries_or_often_seems_worried') }}
								</td>
								<td>@if(isset($data['pre_test']['many_worries_or_often_seems_worried'])) {{ $data['pre_test']['many_worries_or_often_seems_worried'] }} @endif</td>
								<td>@if(isset($data['post_test']['many_worries_or_often_seems_worried'])) {{ $data['post_test']['many_worries_or_often_seems_worried'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.helpful_if_someone_is_hurt_upset_or_feeling_ill') }}
								</td>
								<td>@if(isset($data['pre_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill'])) {{ $data['pre_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill'] }} @endif</td>
								<td>@if(isset($data['post_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill'])) {{ $data['post_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.constantly_fidgeting_or_squirming') }}
								</td>
								<td>@if(isset($data['pre_test']['constantly_fidgeting_or_squirming'])) {{ $data['pre_test']['constantly_fidgeting_or_squirming'] }} @endif</td>
								<td>@if(isset($data['post_test']['constantly_fidgeting_or_squirming'])) {{ $data['post_test']['constantly_fidgeting_or_squirming'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.has_at_least_one_good_friend') }}
								</td>
								<td>@if(isset($data['pre_test']['has_at_least_one_good_friend'])) {{ $data['pre_test']['has_at_least_one_good_friend'] }} @endif</td>
								<td>@if(isset($data['post_test']['has_at_least_one_good_friend'])) {{ $data['post_test']['has_at_least_one_good_friend'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.often_fights_with_other_hildren_or_bullies_them') }}
								</td>
								<td>@if(isset($data['pre_test']['often_fights_with_other_hildren_or_bullies_them'])) {{ $data['pre_test']['often_fights_with_other_hildren_or_bullies_them'] }} @endif</td>
								<td>@if(isset($data['post_test']['often_fights_with_other_hildren_or_bullies_them'])) {{ $data['post_test']['often_fights_with_other_hildren_or_bullies_them'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.often_unhappy_depressed_or_tearful') }}
								</td>
								<td>@if(isset($data['pre_test']['often_unhappy_depressed_or_tearful'])) {{ $data['pre_test']['often_unhappy_depressed_or_tearful'] }} @endif</td>
								<td>@if(isset($data['post_test']['often_unhappy_depressed_or_tearful'])) {{ $data['post_test']['often_unhappy_depressed_or_tearful'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.generally_liked_by_other_children') }}
								</td>
								<td>@if(isset($data['pre_test']['generally_liked_by_other_children'])) {{ $data['pre_test']['generally_liked_by_other_children'] }} @endif</td>
								<td>@if(isset($data['post_test']['generally_liked_by_other_children'])) {{ $data['post_test']['generally_liked_by_other_children'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.easily_distracted_concentration_wanders') }}
								</td>
								<td>@if(isset($data['pre_test']['easily_distracted_concentration_wanders'])) {{ $data['pre_test']['easily_distracted_concentration_wanders'] }} @endif</td>
								<td>@if(isset($data['post_test']['easily_distracted_concentration_wanders'])) {{ $data['post_test']['easily_distracted_concentration_wanders'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.nervous_or_clingy_in_new_situations_easily_loses_confidence') }}
								</td>
								<td>@if(isset($data['pre_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence'])) {{ $data['pre_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence'] }} @endif</td>
								<td>@if(isset($data['post_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence'])) {{ $data['post_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.kind_to_younger_children') }}
								</td>
								<td>@if(isset($data['pre_test']['kind_to_younger_children'])) {{ $data['pre_test']['kind_to_younger_children'] }} @endif</td>
								<td>@if(isset($data['post_test']['kind_to_younger_children'])) {{ $data['post_test']['kind_to_younger_children'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.often_lies_or_cheats') }}
								</td>
								<td>@if(isset($data['pre_test']['often_lies_or_cheats'])) {{ $data['pre_test']['often_lies_or_cheats'] }} @endif</td>
								<td>@if(isset($data['post_test']['often_lies_or_cheats'])) {{ $data['post_test']['often_lies_or_cheats'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.picked_on_or_bullied_by_other_children') }}
								</td>
								<td>@if(isset($data['pre_test']['picked_on_or_bullied_by_other_children'])) {{ $data['pre_test']['picked_on_or_bullied_by_other_children'] }} @endif</td>
								<td>@if(isset($data['post_test']['picked_on_or_bullied_by_other_children'])) {{ $data['post_test']['picked_on_or_bullied_by_other_children'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.often_offers_to_help_others') }}
								</td>
								<td>@if(isset($data['pre_test']['often_offers_to_help_others'])) {{ $data['pre_test']['often_offers_to_help_others'] }} @endif</td>
								<td>@if(isset($data['post_test']['often_offers_to_help_others'])) {{ $data['post_test']['often_offers_to_help_others'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.thinks_things_out_before_acting') }}
								</td>
								<td>@if(isset($data['pre_test']['thinks_things_out_before_acting'])) {{ $data['pre_test']['thinks_things_out_before_acting'] }} @endif</td>
								<td>@if(isset($data['post_test']['thinks_things_out_before_acting'])) {{ $data['post_test']['thinks_things_out_before_acting'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.steals_from_home_school_or_elsewhere') }}
								</td>
								<td>@if(isset($data['pre_test']['steals_from_home_school_or_elsewhere'])) {{ $data['pre_test']['steals_from_home_school_or_elsewhere'] }} @endif</td>
								<td>@if(isset($data['post_test']['steals_from_home_school_or_elsewhere'])) {{ $data['post_test']['steals_from_home_school_or_elsewhere'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.gets_along_better_with_adults_than_with_other_children') }}
								</td>
								<td>@if(isset($data['pre_test']['gets_along_better_with_adults_than_with_other_children'])) {{ $data['pre_test']['gets_along_better_with_adults_than_with_other_children'] }} @endif</td>
								<td>@if(isset($data['post_test']['gets_along_better_with_adults_than_with_other_children'])) {{ $data['post_test']['gets_along_better_with_adults_than_with_other_children'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.many_fears_easily_scared') }}
								</td>
								<td>@if(isset($data['pre_test']['many_fears_easily_scared'])) {{ $data['pre_test']['many_fears_easily_scared'] }} @endif</td>
								<td>@if(isset($data['post_test']['many_fears_easily_scared'])) {{ $data['post_test']['many_fears_easily_scared'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.good_attention_span_sees_chores_or_homework_through_to_the_end') }}
								</td>
								<td>@if(isset($data['pre_test']['good_attention_span_sees_chores_or_homework_through_to_the_end'])) {{ $data['pre_test']['good_attention_span_sees_chores_or_homework_through_to_the_end'] }} @endif</td>
								<td>@if(isset($data['post_test']['good_attention_span_sees_chores_or_homework_through_to_the_end'])) {{ $data['post_test']['good_attention_span_sees_chores_or_homework_through_to_the_end'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.do_the_child_receive_any_other_child_protection_services') }}
								</td>
								<td>@if(isset($data['pre_test']['do_the_child_receive_any_other_child_protection_services'])) {{ $data['pre_test']['do_the_child_receive_any_other_child_protection_services'] }} @endif</td>
								<td>@if(isset($data['post_test']['do_the_child_receive_any_other_child_protection_services'])) {{ $data['post_test']['do_the_child_receive_any_other_child_protection_services'] }} @endif</td>
							</tr>
							<tr>
								<td>
									Emotional Scale
								</td>
								<td>@if(isset($data['pre_test']['emotional_scale'])) {{ $data['pre_test']['emotional_scale'] }} @endif</td>
								<td>@if(isset($data['post_test']['emotional_scale'])) {{ $data['post_test']['emotional_scale'] }} @endif</td>
							</tr>
							<tr>
								<td>
									Conduct Scale
								</td>
								<td>@if(isset($data['pre_test']['conduct_scale'])) {{ $data['pre_test']['conduct_scale'] }} @endif</td>
								<td>@if(isset($data['post_test']['conduct_scale'])) {{ $data['post_test']['conduct_scale'] }} @endif</td>
							</tr>
							<tr>
								<td>
									Peer Problem Scale
								</td>
								<td>@if(isset($data['pre_test']['peer_problem_scale'])) {{ $data['pre_test']['peer_problem_scale'] }} @endif</td>
								<td>@if(isset($data['post_test']['peer_problem_scale'])) {{ $data['post_test']['peer_problem_scale'] }} @endif</td>
							</tr>
							<tr>
								<td>
									Hyperactivity Scale
								</td>
								<td>@if(isset($data['pre_test']['hyper_activity_scale'])) {{ $data['pre_test']['hyper_activity_scale'] }} @endif</td>
								<td>@if(isset($data['post_test']['hyper_activity_scale'])) {{ $data['post_test']['hyper_activity_scale'] }} @endif</td>
							</tr>
							<tr>
								<td>
									Pro Social Scale
								</td>
								<td>@if(isset($data['pre_test']['pro_social_scale'])) {{ $data['pre_test']['pro_social_scale'] }} @endif</td>
								<td>@if(isset($data['post_test']['pro_social_scale'])) {{ $data['post_test']['pro_social_scale'] }} @endif</td>
							</tr>
							<tr>
								<td>
									Score
								</td>
								<td>@if(isset($data['pre_test']['score'])) {{ $data['pre_test']['score'] }} @endif</td>
								<td>@if(isset($data['post_test']['score'])) {{ $data['post_test']['score'] }} @endif</td>
							</tr>
							<tr>
								<td>
									{{ trans('messages.comment') }}
								</td>
								<td>@if(isset($data['pre_test'][''])) {{ $data['pre_test']['comment'] }} @endif</td>
								<td>@if(isset($data['post_test'][''])) {{ $data['post_test']['comment'] }} @endif</td>
							</tr>
						</tbody>
					</table>
						<div class="row">
							<div class="col-lg-2">
								<a href="{{ url('application-list') }}" class="btn btn-secondary">Back</a>
							</div>
							<div class="col-lg-10"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6">
			<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Application Log
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<table class="table table-striped- table-bordered table-hover">
						<thead>
							<tr>
								<th>log</th>
							</tr>
						</thead>
						<tbody>
							@if(count($data['log']) > 0)
								@foreach($data['log'] as $l)
									<tr>
										<td>{{ $l->text }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td>No logs available</td>
								</tr>
							@endif
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3"></div>
	</div>
@endsection