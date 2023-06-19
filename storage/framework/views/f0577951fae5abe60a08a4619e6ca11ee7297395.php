<?php $__env->startSection('title',$data['application']['code']); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/application-list')); ?>">Application List</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
	<link href="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
	if(!$data['application']['post_test_date']){
		unset($data['post_test']);
	}
?>
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								<?php echo e($data['application']['code']); ?> Detail
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						<?php if(isset($data['application']['pre_test_date']) && !empty($data['application']['pre_test_date'])): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Pre Test Date:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($data['application']['pre_test_date']); ?>

							</span>
						</div>
						<?php endif; ?>
						<?php if(isset($data['application']['post_test_date']) && !empty($data['application']['post_test_date'])): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Post Test Date:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($data['application']['post_test_date']); ?>

							</span>
						</div>
						<?php endif; ?>
						<?php if(isset($data['application']['collector_name']) && !empty($data['application']['collector_name'])): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Collector:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($data['application']['collector_name']); ?>

							</span>
						</div>
						<?php endif; ?>

						<?php if(isset($data['application']['partner_name']) && !empty($data['application']['partner_name'])): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Parter:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($data['application']['partner_name']); ?>

							</span>
						</div>
						<?php endif; ?>

						<?php if(isset($data['application']['status_name']) && !empty($data['application']['status_name'])): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Status:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($data['application']['status_name']); ?>

							</span>
						</div>
						<?php endif; ?>
						<?php if(isset($data['application']['pre_test_date']) && !empty($data['application']['pre_test_date'])): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Change:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($data['change']); ?>

							</span>
						</div>
						<?php endif; ?>
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
									<?php echo e(trans('messages.agency_name')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['agency_name'])): ?> <?php echo e($data['pre_test']['agency_name']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['agency_name'])): ?> <?php echo e($data['post_test']['agency_name']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.Form')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['form'])): ?> <?php echo e($data['pre_test']['form']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['form'])): ?> <?php echo e($data['post_test']['form']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.donor_name')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['donor_name'])): ?> <?php echo e($data['pre_test']['donor_name']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['donor_name'])): ?> <?php echo e($data['post_test']['donor_name']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.interview_date')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['interview_date'])): ?> <?php echo e($data['pre_test']['interview_date']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['interview_date'])): ?> <?php echo e($data['post_test']['interview_date']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.interviewrs_name')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['interviewers_name'])): ?> <?php echo e($data['pre_test']['interviewers_name']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['interviewers_name'])): ?> <?php echo e($data['post_test']['interviewers_name']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.age')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['age'])): ?> <?php echo e($data['pre_test']['age']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['age'])): ?> <?php echo e($data['post_test']['age']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.gender')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['gender'])): ?> <?php echo e($data['pre_test']['gender']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['gender'])): ?> <?php echo e($data['post_test']['gender']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.nationality')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['nationality'])): ?> <?php echo e($data['pre_test']['nationality']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['nationality'])): ?> <?php echo e($data['post_test']['nationality']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.total_number_of_hours_in_your_program')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['total_number_of_hours_in_your_program'])): ?> <?php echo e($data['pre_test']['total_number_of_hours_in_your_program']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['total_number_of_hours_in_your_program'])): ?> <?php echo e($data['post_test']['total_number_of_hours_in_your_program']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.number_of_hours_that_the_child_attended')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['number_of_hours_that_the_child_attended'])): ?> <?php echo e($data['pre_test']['number_of_hours_that_the_child_attended']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['number_of_hours_that_the_child_attended'])): ?> <?php echo e($data['post_test']['number_of_hours_that_the_child_attended']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.dropout_reason')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['dropout_reason'])): ?> <?php echo e($data['pre_test']['dropout_reason']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['dropout_reason'])): ?> <?php echo e($data['post_test']['dropout_reason']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.justify_the_dropout_reason')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['justify_the_dropout_reason'])): ?> <?php echo e($data['pre_test']['justify_the_dropout_reason']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['justify_the_dropout_reason'])): ?> <?php echo e($data['post_test']['justify_the_dropout_reason']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.gouvarnate')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['gouvername_name'])): ?> <?php echo e($data['pre_test']['gouvername_name']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['gouvername_name'])): ?> <?php echo e($data['post_test']['gouvername_name']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.caza')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['caza_name'])): ?> <?php echo e($data['pre_test']['caza_name']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['caza_name'])): ?> <?php echo e($data['post_test']['caza_name']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.area')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['area_name'])): ?> <?php echo e($data['pre_test']['area_name']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['area_name'])): ?> <?php echo e($data['post_test']['area_name']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.gateway_type')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['gateway_type'])): ?> <?php echo e($data['pre_test']['gateway_type']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['gateway_type'])): ?> <?php echo e($data['post_test']['gateway_type']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.p_code')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['p_code'])): ?> <?php echo e($data['pre_test']['p_code']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['p_code'])): ?> <?php echo e($data['post_test']['p_code']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.latitude')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['latitude'])): ?> <?php echo e($data['pre_test']['latitude']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['latitude'])): ?> <?php echo e($data['post_test']['latitude']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.longitude')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['longitude'])): ?> <?php echo e($data['pre_test']['longitude']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['longitude'])): ?> <?php echo e($data['post_test']['longitude']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.altitude')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['altitude'])): ?> <?php echo e($data['pre_test']['altitude']); ?><?php endif; ?></td>
								<td><?php if(isset($data['post_test']['altitude'])): ?> <?php echo e($data['post_test']['altitude']); ?><?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.accuracy')); ?>

								</td>
								<td><?php if(isset($data['post_test']['accuracy'])): ?> <?php echo e($data['post_test']['accuracy']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['accuracy'])): ?> <?php echo e($data['post_test']['accuracy']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>---</td>
								<td>---</td>
								<td>---</td>
							</tr>

<!-- A- Emotional scale -->
							<tr>
								<td>
									<strong>A- Emotional scale</strong>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.often_complains_of_headaches_stomach_aches_or_sickness')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['often_complains_of_headaches_stomach_aches_or_sickness'])): ?> <?php echo e($data['pre_test']['often_complains_of_headaches_stomach_aches_or_sickness']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['often_complains_of_headaches_stomach_aches_or_sickness'])): ?> <?php echo e($data['post_test']['often_complains_of_headaches_stomach_aches_or_sickness']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.many_worries_or_often_seems_worried')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['many_worries_or_often_seems_worried'])): ?> <?php echo e($data['pre_test']['many_worries_or_often_seems_worried']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['many_worries_or_often_seems_worried'])): ?> <?php echo e($data['post_test']['many_worries_or_often_seems_worried']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.often_unhappy_depressed_or_tearful')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['often_unhappy_depressed_or_tearful'])): ?> <?php echo e($data['pre_test']['often_unhappy_depressed_or_tearful']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['often_unhappy_depressed_or_tearful'])): ?> <?php echo e($data['post_test']['often_unhappy_depressed_or_tearful']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.nervous_or_clingy_in_new_situations_easily_loses_confidence')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence'])): ?> <?php echo e($data['pre_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence'])): ?> <?php echo e($data['post_test']['nervous_or_clingy_in_new_situations_easily_loses_confidence']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.many_fears_easily_scared')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['many_fears_easily_scared'])): ?> <?php echo e($data['pre_test']['many_fears_easily_scared']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['many_fears_easily_scared'])): ?> <?php echo e($data['post_test']['many_fears_easily_scared']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td><strong>Emotional Scale</strong></td>
								<td><strong><?php if(isset($data['pre_test']['emotional_scale'])): ?> <?php echo e($data['pre_test']['emotional_scale']); ?> <?php endif; ?></strong></td>
								<td><strong><?php if(isset($data['post_test']['emotional_scale'])): ?> <?php echo e($data['post_test']['emotional_scale']); ?> <?php endif; ?></strong></td>
							</tr>
							<tr>
								<td>---</td>
								<td>---</td>
								<td>---</td>
							</tr>
<!-- END A- Emotional scale start -->

<!-- B- Conduct scale -->
							<tr>
								<td>
									<strong>B- Conduct scale</strong>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.often_loses_temper')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['often_loses_temper'])): ?> <?php echo e($data['pre_test']['often_loses_temper']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['often_loses_temper'])): ?> <?php echo e($data['post_test']['often_loses_temper']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.generally_well_behaved_usually_does_what_adults_request')); ?>*
								</td>
								<td><?php if(isset($data['pre_test']['generally_well_behaved_usually_does_what_adults_request'])): ?> <?php echo e($data['pre_test']['generally_well_behaved_usually_does_what_adults_request']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['generally_well_behaved_usually_does_what_adults_request'])): ?> <?php echo e($data['post_test']['generally_well_behaved_usually_does_what_adults_request']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.often_fights_with_other_hildren_or_bullies_them')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['often_fights_with_other_hildren_or_bullies_them'])): ?> <?php echo e($data['pre_test']['often_fights_with_other_hildren_or_bullies_them']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['often_fights_with_other_hildren_or_bullies_them'])): ?> <?php echo e($data['post_test']['often_fights_with_other_hildren_or_bullies_them']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.often_lies_or_cheats')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['often_lies_or_cheats'])): ?> <?php echo e($data['pre_test']['often_lies_or_cheats']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['often_lies_or_cheats'])): ?> <?php echo e($data['post_test']['often_lies_or_cheats']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.steals_from_home_school_or_elsewhere')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['steals_from_home_school_or_elsewhere'])): ?> <?php echo e($data['pre_test']['steals_from_home_school_or_elsewhere']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['steals_from_home_school_or_elsewhere'])): ?> <?php echo e($data['post_test']['steals_from_home_school_or_elsewhere']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<strong>Conduct Scale</strong>
								</td>
								<td><strong><?php if(isset($data['pre_test']['conduct_scale'])): ?> <?php echo e($data['pre_test']['conduct_scale']); ?> <?php endif; ?></strong></td>
								<td><strong><?php if(isset($data['post_test']['conduct_scale'])): ?> <?php echo e($data['post_test']['conduct_scale']); ?> <?php endif; ?></strong></td>
							</tr>
							<tr>
								<td>---</td>
								<td>---</td>
								<td>---</td>
							</tr>
<!-- END B- Conduct scale -->

<!-- C- Hyperactivity scale -->
							<tr>
								<td>
									<strong>C- Hyperactivity scale</strong>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.restless_overactive_cannot_stay_still_for_long')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['restless_overactive_cannot_stay_still_for_long'])): ?> <?php echo e($data['pre_test']['restless_overactive_cannot_stay_still_for_long']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['restless_overactive_cannot_stay_still_for_long'])): ?> <?php echo e($data['post_test']['restless_overactive_cannot_stay_still_for_long']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.constantly_fidgeting_or_squirming')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['constantly_fidgeting_or_squirming'])): ?> <?php echo e($data['pre_test']['constantly_fidgeting_or_squirming']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['constantly_fidgeting_or_squirming'])): ?> <?php echo e($data['post_test']['constantly_fidgeting_or_squirming']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.easily_distracted_concentration_wanders')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['easily_distracted_concentration_wanders'])): ?> <?php echo e($data['pre_test']['easily_distracted_concentration_wanders']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['easily_distracted_concentration_wanders'])): ?> <?php echo e($data['post_test']['easily_distracted_concentration_wanders']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.thinks_things_out_before_acting')); ?> *
								</td>
								<td><?php if(isset($data['pre_test']['thinks_things_out_before_acting'])): ?> <?php echo e($data['pre_test']['thinks_things_out_before_acting']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['thinks_things_out_before_acting'])): ?> <?php echo e($data['post_test']['thinks_things_out_before_acting']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.good_attention_span_sees_chores_or_homework_through_to_the_end')); ?> *
								</td>
								<td><?php if(isset($data['pre_test']['good_attention_span_sees_chores_or_homework_through_to_the_end'])): ?> <?php echo e($data['pre_test']['good_attention_span_sees_chores_or_homework_through_to_the_end']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['good_attention_span_sees_chores_or_homework_through_to_the_end'])): ?> <?php echo e($data['post_test']['good_attention_span_sees_chores_or_homework_through_to_the_end']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								<strong>Hyperactivity Scale</strong>
								</td>
								<td><strong><?php if(isset($data['pre_test']['hyper_activity_scale'])): ?> <?php echo e($data['pre_test']['hyper_activity_scale']); ?> <?php endif; ?></strong></td>
								<td><strong><?php if(isset($data['post_test']['hyper_activity_scale'])): ?> <?php echo e($data['post_test']['hyper_activity_scale']); ?> <?php endif; ?></strong></td>
							</tr>
							<tr>
								<td>---</td>
								<td>---</td>
								<td>---</td>
							</tr>
<!-- END C- Hyperactivity scale -->

<!-- D- Peer problems scale -->
							<tr>
								<td>
									<strong>D- Peer problems scale</strong>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.rather_solitary_prefers_to_play_alone')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['rather_solitary_prefers_to_play_alone'])): ?> <?php echo e($data['pre_test']['rather_solitary_prefers_to_play_alone']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['rather_solitary_prefers_to_play_alone'])): ?> <?php echo e($data['post_test']['rather_solitary_prefers_to_play_alone']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.has_at_least_one_good_friend')); ?> *
								</td>
								<td><?php if(isset($data['pre_test']['has_at_least_one_good_friend'])): ?> <?php echo e($data['pre_test']['has_at_least_one_good_friend']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['has_at_least_one_good_friend'])): ?> <?php echo e($data['post_test']['has_at_least_one_good_friend']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.generally_liked_by_other_children')); ?> *
								</td>
								<td><?php if(isset($data['pre_test']['generally_liked_by_other_children'])): ?> <?php echo e($data['pre_test']['generally_liked_by_other_children']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['generally_liked_by_other_children'])): ?> <?php echo e($data['post_test']['generally_liked_by_other_children']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.picked_on_or_bullied_by_other_children')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['picked_on_or_bullied_by_other_children'])): ?> <?php echo e($data['pre_test']['picked_on_or_bullied_by_other_children']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['picked_on_or_bullied_by_other_children'])): ?> <?php echo e($data['post_test']['picked_on_or_bullied_by_other_children']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.gets_along_better_with_adults_than_with_other_children')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['gets_along_better_with_adults_than_with_other_children'])): ?> <?php echo e($data['pre_test']['gets_along_better_with_adults_than_with_other_children']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['gets_along_better_with_adults_than_with_other_children'])): ?> <?php echo e($data['post_test']['gets_along_better_with_adults_than_with_other_children']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								<strong>Peer Problem Scale</strong>
								</td>
								<td><strong><?php if(isset($data['pre_test']['peer_problem_scale'])): ?> <?php echo e($data['pre_test']['peer_problem_scale']); ?> <?php endif; ?></strong></td>
								<td><strong><?php if(isset($data['post_test']['peer_problem_scale'])): ?> <?php echo e($data['post_test']['peer_problem_scale']); ?> <?php endif; ?></strong></td>
							</tr>
							<tr>
								<td>---</td>
								<td>---</td>
								<td>---</td>
							</tr>
<!-- END D- Peer problems scale -->

<!-- E- Pro social scale -->
							<tr>
								<td>
									<strong>E- Pro social scale</strong>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.considerate_of_other_peoples_feelings')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['considerate_of_other_peoples_feelings'])): ?> <?php echo e($data['pre_test']['considerate_of_other_peoples_feelings']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['considerate_of_other_peoples_feelings'])): ?> <?php echo e($data['post_test']['considerate_of_other_peoples_feelings']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.shares_readily_with_other_children_for_example_toys')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['shares_readily_with_other_children_for_example_toys'])): ?> <?php echo e($data['pre_test']['shares_readily_with_other_children_for_example_toys']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['shares_readily_with_other_children_for_example_toys'])): ?> <?php echo e($data['post_test']['shares_readily_with_other_children_for_example_toys']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.helpful_if_someone_is_hurt_upset_or_feeling_ill')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill'])): ?> <?php echo e($data['pre_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill'])): ?> <?php echo e($data['post_test']['helpful_if_someone_is_hurt_upset_or_feeling_ill']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.kind_to_younger_children')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['kind_to_younger_children'])): ?> <?php echo e($data['pre_test']['kind_to_younger_children']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['kind_to_younger_children'])): ?> <?php echo e($data['post_test']['kind_to_younger_children']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.often_offers_to_help_others')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['often_offers_to_help_others'])): ?> <?php echo e($data['pre_test']['often_offers_to_help_others']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['often_offers_to_help_others'])): ?> <?php echo e($data['post_test']['often_offers_to_help_others']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								<strong>Pro Social Scale</strong>
								</td>
								<td><strong><?php if(isset($data['pre_test']['pro_social_scale'])): ?> <?php echo e($data['pre_test']['pro_social_scale']); ?> <?php endif; ?></strong></td>
								<td><strong><?php if(isset($data['post_test']['pro_social_scale'])): ?> <?php echo e($data['post_test']['pro_social_scale']); ?> <?php endif; ?></strong></td>
							</tr>
<!-- END E- Pro social scale -->
							<tr>
								<td>---</td>
								<td>---</td>
								<td>---</td>
							</tr>



							<tr>
								<td>
									<?php echo e(trans('messages.do_the_child_receive_any_other_child_protection_services')); ?>

								</td>
								<td><?php if(isset($data['pre_test']['do_the_child_receive_any_other_child_protection_services'])): ?> <?php echo e($data['pre_test']['do_the_child_receive_any_other_child_protection_services']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['do_the_child_receive_any_other_child_protection_services'])): ?> <?php echo e($data['post_test']['do_the_child_receive_any_other_child_protection_services']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									Emotional Scale
								</td>
								<td><?php if(isset($data['pre_test']['emotional_scale'])): ?> <?php echo e($data['pre_test']['emotional_scale']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['emotional_scale'])): ?> <?php echo e($data['post_test']['emotional_scale']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									Conduct Scale
								</td>
								<td><?php if(isset($data['pre_test']['conduct_scale'])): ?> <?php echo e($data['pre_test']['conduct_scale']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['conduct_scale'])): ?> <?php echo e($data['post_test']['conduct_scale']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									Hyperactivity Scale
								</td>
								<td><?php if(isset($data['pre_test']['hyper_activity_scale'])): ?> <?php echo e($data['pre_test']['hyper_activity_scale']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['hyper_activity_scale'])): ?> <?php echo e($data['post_test']['hyper_activity_scale']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									Peer Problem Scale
								</td>
								<td><?php if(isset($data['pre_test']['peer_problem_scale'])): ?> <?php echo e($data['pre_test']['peer_problem_scale']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['peer_problem_scale'])): ?> <?php echo e($data['post_test']['peer_problem_scale']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									Pro Social Scale
								</td>
								<td><?php if(isset($data['pre_test']['pro_social_scale'])): ?> <?php echo e($data['pre_test']['pro_social_scale']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['pro_social_scale'])): ?> <?php echo e($data['post_test']['pro_social_scale']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									Score
								</td>
								<td><?php if(isset($data['pre_test']['score'])): ?> <?php echo e($data['pre_test']['score']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test']['score'])): ?> <?php echo e($data['post_test']['score']); ?> <?php endif; ?></td>
							</tr>
							<tr>
								<td>
									<?php echo e(trans('messages.comment')); ?>

								</td>
								<td><?php if(isset($data['pre_test'][''])): ?> <?php echo e($data['pre_test']['comment']); ?> <?php endif; ?></td>
								<td><?php if(isset($data['post_test'][''])): ?> <?php echo e($data['post_test']['comment']); ?> <?php endif; ?></td>
							</tr>
						</tbody>
					</table>
						<div class="row">
							<div class="col-lg-2">
								<a href="<?php echo e(url('application-list')); ?>" class="btn btn-secondary">Back</a>
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
							<?php if(count($data['log']) > 0): ?>
								<?php $__currentLoopData = $data['log']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($l->text); ?></td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
								<tr>
									<td>No logs available</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3"></div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/application/view.blade.php ENDPATH**/ ?>