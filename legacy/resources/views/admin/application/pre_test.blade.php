<style>

.lang_en { direction: ltr; }
.lang_ar { direction: rtl; }
.lang_ar .alert-danger{ text-align:right!important; }

form.lang_ar label, form.lang_ar h5 { display: table; text-align: right; }
form.lang_ar span.m-form__help { display: block!important; text-align: right!important; }

select.form-control { padding: 5px; }
.col-lg-12 { margin:0 0 20px 0; }
.m-form.m-form--group-seperator-dashed .m-form__group { border: 0px!important; }
.m-form.m-form--group-seperator-dashed .m-form__group, .m-form.m-form--group-seperator .m-form__group { padding: 10px!important; }

.m-form.m-form--group-seperator-dashed .m-portlet__body, .m-form.m-form--group-seperator .m-portlet__body {
    padding-top: 30px!important;
    padding-bottom: 30px!important;
	width: 500px;
    margin: 0 auto;
}

.m-portlet .m-portlet__head{
    margin: 0 auto;
    width: 230px;
}

#footer_div{ margin: 0 auto; }
#footer_div button{ width: 100px; margin: 0 10px; }

.language-menu{
	position: absolute;
	top: 10px;
	right: 250px;
	z-index: 100;
	width: 50px;
	height: 50px;
	font-size: 14px;
}
.language-menu a{color: white;}

.logout-section{
	position: absolute;
	top: 13px;
	right: 10px;
	z-index: 100;
}

#m_aside_left_offcanvas_toggle, 
#m_aside_header_topbar_mobile_toggle,
#m_aside_header_menu_mobile_toggle, .m-nav__item.m-topbar__quick-actions, #m_aside_left_minimize_toggle { display:none!important; }

@media only screen and (max-width: 600px) {

	#m_header .m-brand__logo-wrapper img{
		width: 115px;
		height: 50px;
		margin: 0!important;
	}
	.m-form.m-form--group-seperator-dashed .m-portlet__body, .m-form.m-form--group-seperator .m-portlet__body {
		width: 320px;
		margin: 0 auto;
	}

	.language-menu{
		position: absolute;
		top: 10px;
		right: 150px;
		z-index: 100;
		width: 50px;
		height: 50px;
		font-size: 14px;
	}
	.language-menu a{color: white;}
	
	.logout-section{
		position: absolute;
		top: 10px;
		right: 10px;
		z-index: 100;
	}
}

</style>

@php $lang = App::getLocale(); @endphp

@extends('admin.layout.app')

@section('title',"Pre Test Application")

@section('breadcrumb')
	<a href="{{ url('/application-list') }}">Application List</a>
@endsection

@section('css')
	<link href="{{ url('/public') }}/assets/vendors/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
	<link href="{{ url('/public') }}/assets/vendors/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
	<link href="{{ url('/public') }}/assets/vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ url('/public') }}/assets/leb/bootstrap-material-datetimepicker.css" />
@endsection

@section('content')
<div class="row lang_{{$lang}}">

	<div class="language-menu">
		<a href="{{ url('locale/en') }}" class="m-nav-grid__item"><span class="m-nav-grid__text">English</span></a>
		<a href="{{ url('locale/ar') }}" class="m-nav-grid__item"><span class="m-nav-grid__text">Arabic</span></a>		
	</div>
	<div class="logout-section">
		<a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
			<form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">@csrf</form>
			Logout
		</a>
	</div>

	<div class="col-lg-3 d-none"></div>
	<div class="col-lg-12">

		<!--begin::Portlet-->
		@php
			if($type == "pre_test"){
				$action = url('save-pre-test-application');
				$readonly = "";
				$disabled = "";
			}else{
				$action = url('save-post-test-application');
				$readonly = "readonly=''";
				$disabled = "disabled=''";
			}
			$lang = App::getLocale();
			if(count($errors) > 0){
				$preTestObj->form = old('form');
				$preTestObj->agency_name = old('agency_name');
				$preTestObj->category = old('category');
				$preTestObj->donor_name = old('donor_name');
				$preTestObj->interview_date = old('interview_date');
				$preTestObj->interviewrs_name = old('interviewrs_name');
				$preTestObj->age = old('age');
				$preTestObj->gender = old('gender');
				$preTestObj->nationality = old('nationality');
				$preTestObj->other_nationality = old('other_nationality');
				$preTestObj->total_number_of_hours_in_your_program = old('total_number_of_hours_in_your_program');
				$preTestObj->number_of_hours_that_the_child_attended = old('number_of_hours_that_the_child_attended');
				$preTestObj->dropout_reason = old('dropout_reason');
				$preTestObj->justify_the_dropout_reason = old('justify_the_dropout_reason');
				$preTestObj->gouvarnate = old('gouvarnate');
				$preTestObj->area = old('area');
				$preTestObj->gateway_type = old('gateway_type');
				$preTestObj->p_code = old('p_code');
				$preTestObj->latitude = old('latitude');
				$preTestObj->longitude = old('longitude');
				$preTestObj->altitude = old('altitude');
				$preTestObj->accuracy = old('accuracy');
				$preTestObj->may_i_start_now = old('may_i_start_now');
				$preTestObj->comment = old('comment');
				$preTestObj->considerate_of_other_peoples_feelings = old('considerate_of_other_peoples_feelings');
				$preTestObj->restless_overactive_cannot_stay_still_for_long = old('restless_overactive_cannot_stay_still_for_long');
				$preTestObj->often_complains_of_headaches_stomach_aches_or_sickness = old('often_complains_of_headaches_stomach_aches_or_sickness');
				$preTestObj->shares_readily_with_other_children_for_example_toys = old('shares_readily_with_other_children_for_example_toys');
				$preTestObj->often_loses_temper = old('often_loses_temper');
				$preTestObj->rather_solitary_prefers_to_play_alone = old('rather_solitary_prefers_to_play_alone');
				$preTestObj->generally_well_behaved_usually_does_what_adults_request = old('generally_well_behaved_usually_does_what_adults_request');
				$preTestObj->many_worries_or_often_seems_worried = old('many_worries_or_often_seems_worried');
				$preTestObj->helpful_if_someone_is_hurt_upset_or_feeling_ill = old('helpful_if_someone_is_hurt_upset_or_feeling_ill');
				$preTestObj->constantly_fidgeting_or_squirming = old('constantly_fidgeting_or_squirming');
				$preTestObj->has_at_least_one_good_friend = old('has_at_least_one_good_friend');
				$preTestObj->often_fights_with_other_hildren_or_bullies_them = old('often_fights_with_other_hildren_or_bullies_them');
				$preTestObj->often_unhappy_depressed_or_tearful = old('often_unhappy_depressed_or_tearful');
				$preTestObj->generally_liked_by_other_children = old('generally_liked_by_other_children');
				$preTestObj->easily_distracted_concentration_wanders = old('easily_distracted_concentration_wanders');
				$preTestObj->nervous_or_clingy_in_new_situations_easily_loses_confidence = old('nervous_or_clingy_in_new_situations_easily_loses_confidence');
				$preTestObj->kind_to_younger_children = old('kind_to_younger_children');
				$preTestObj->often_lies_or_cheats = old('often_lies_or_cheats');
				$preTestObj->picked_on_or_bullied_by_other_children = old('picked_on_or_bullied_by_other_children');
				$preTestObj->thinks_things_out_before_acting = old('thinks_things_out_before_acting');
				$preTestObj->steals_from_home_school_or_elsewhere = old('steals_from_home_school_or_elsewhere');
				$preTestObj->gets_along_better_with_adults_than_with_other_children = old('gets_along_better_with_adults_than_with_other_children');
				$preTestObj->many_fears_easily_scared = old('many_fears_easily_scared');
				$preTestObj->good_attention_span_sees_chores_or_homework_through_to_the_end = old('good_attention_span_sees_chores_or_homework_through_to_the_end');
				$preTestObj->often_offers_to_help_others = old('often_offers_to_help_others');
				$preTestObj->do_the_child_receive_any_other_child_protection_services = old('do_the_child_receive_any_other_child_protection_services');
			}


		@endphp

		@if (count($errors) > 0)
	        <div class="alert alert-danger">
	            <!-- <ul>
	                @foreach ($errors->all() as $error)
	                    <li>{{ $error }}</li>
	                @endforeach
	            </ul> -->
				{{ trans('messages.error_message_global') }}
	        </div>
		@endif

		<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed lang_{{$lang}}" id="pre_test" method="post" action="{{ $action }}">
			@csrf
			<input type="hidden" name="code" value="{{ $preTestObj->code }}">
			<input type="hidden" name="agency_name" value="{{ $preTestObj->agency_name }}">
			<input type="hidden" name="interviewers_name" value="{{ $preTestObj->interviewers_name }}">
			@if($type == 'post_test')
			<input type="hidden" name="form" value="{{ $preTestObj->form }}">
			<input type="hidden" name="category" value="{{ $preTestObj->category }}">
			<input type="hidden" name="donor_name" value="{{ $preTestObj->donor_name }}">
			<input type="hidden" name="gender" value="{{ $preTestObj->gender }}">
			<input type="hidden" name="nationality" value="{{ $preTestObj->nationality }}">
			<input type="hidden" name="gouvarnate" value="{{ $preTestObj->gouvarnate }}">
			<input type="hidden" name="caza" value="{{ $preTestObj->caza }}">
			<input type="hidden" name="area" value="{{ $preTestObj->area }}">
			<input type="hidden" name="gateway_type" value="{{ $preTestObj->gateway_type }}">
			@endif
			<div class="m-portlet">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<span class="m-portlet__head-icon m--hide">
								<i class="la la-gear"></i>
							</span>
							<h3 class="m-portlet__head-text">
								@php
									if($type == "pre_test"){
										echo "Pre Test";
									}else{
										echo "Post Test";
									}
								@endphp
								Application
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-12">
							<!-- <label>{{ trans('messages.Form') }}:</label> -->
							<select class="form-control m-input {{ $errors->has('form') ? "has-error" : "" }}" id="form" name="form" {{ $disabled }} >
								<option value="">{{ trans('messages.select_form') }}</option>
								<option value="Form 6-11" {{ $preTestObj->form == "Form 6-11" || old('form') ? "selected" : "" }}>{{ trans('messages.form_6_11') }}</option>
								<option value="Form 12-17" {{ $preTestObj->form == "Form 12-17" ? "selected" : "" }}>{{ trans('messages.form_12_17') }}</option>
							</select>
							@if ($errors->has('form'))
			                  	<span class="m-form__help">{{ $errors->first('form') }}</span>
			              	@endif
						</div>
					</div>
					<div id="main_form" style="{{ $preTestObj->form == "" ? 'display:none;' : "" }}">
<!-- agency_name -->
							<div class="col-lg-12">
								<label class="agency_name_message">{{ trans_choice('messages.agency_name',1) }}:</label>
								<input type="text" name="agency_name" value="{{ old('agency_name') ? old('agency_name') : $preTestObj->agency_name }}" placeholder="{{ trans_choice('messages.agency_name',1) }}" id="agency_name" class="form-control m-input {{ $errors->has('agency_name') ? "has-error" : "" }}" readonly="">
								@if ($errors->has('agency_name'))
				                  	<span class="m-form__help">{{ $errors->first('agency_name') }}</span>
				              	@endif
							</div>
<!-- category -->
							<div class="col-lg-12">
								<label>{{ trans('messages.select_category') }}:</label>
								<select {{ $disabled }} class="form-control m-input {{ $errors->has('category') ? "has-error" : "" }}" id="category" name="category">
									<option value=""></option>
									<option value="Child Labour Activity" {{ $preTestObj->category == "Child Labour Activity" ? "selected" : "" }}>{{ trans('messages.child_labour_activity') }}</option>
									<option value="Child Mariage Activity" {{ $preTestObj->category == "Child Mariage Activity" ? "selected" : "" }}>{{ trans('messages.child_mariage_activity') }}</option>
									<option value="Violent Discipline  Activity" {{ $preTestObj->category == "Violent Discipline  Activity" ? "selected" : "" }}>{{ trans('messages.violent_discipline_activity') }}</option>
									<option value="Other" {{ $preTestObj->agency_name == "Other" ? "selected" : "" }}>{{ trans('messages.other') }}</option>
								</select>
								@if ($errors->has('category'))
				                  	<span class="m-form__help">{{ $errors->first('category') }}</span>
				              	@endif
							</div>
<!-- donor_name -->
							<div class="col-lg-12">
								<label>{{ trans('messages.donor_name') }}:</label>
								<select {{ $disabled }} class="form-control m-input {{ $errors->has('donor_name') ? "has-error" : "" }}" id="donor_name" name="donor_name">
									<option value=""></option>
									<option value="UNICEF" {{ $preTestObj->donor_name == "UNICEF" ? "selected" : "" }}>UNICEF</option>
									<option value="UNHCR" {{ $preTestObj->donor_name == "UNHCR" ? "selected" : "" }}>UNHCR</option>
									<option value="ERF" {{ $preTestObj->donor_name == "ERF" ? "selected" : "" }}>ERF</option>
									<option value="BPRM" {{ $preTestObj->donor_name == "BPRM" ? "selected" : "" }}>BPRM</option>
									<option value="SiDA" {{ $preTestObj->donor_name == "SiDA" ? "selected" : "" }}>SiDA</option>
									<option value="UNRWA" {{ $preTestObj->donor_name == "UNRWA" ? "selected" : "" }}>UNRWA</option>
									<option value="UNFPA" {{ $preTestObj->donor_name == "UNFPA" ? "selected" : "" }}>UNFPA</option>
									<option value="DFID" {{ $preTestObj->donor_name == "DFID" ? "selected" : "" }}>DFID</option>
									<option value="ECHO" {{ $preTestObj->donor_name == "ECHO" ? "selected" : "" }}>ECHO</option>
									<option value="UNDP" {{ $preTestObj->donor_name == "UNDP" ? "selected" : "" }}>UNDP</option>
									<option value="DFATD - Canada" {{ $preTestObj->donor_name == "DFATD - Canada" ? "selected" : "" }}>DFATD - Canada</option>
									<option value="EC - DEVCO" {{ $preTestObj->donor_name == "EC - DEVCO" ? "selected" : "" }}>EC - DEVCO</option>
									<option value="Other" {{ $preTestObj->donor_name == "Other" ? "selected" : "" }}>Other</option>
								</select>
								@if ($errors->has('donor_name'))
				                  	<span class="m-form__help">{{ $errors->first('donor_name') }}</span>
				              	@endif
							</div>
<!-- interview_date -->
							<div class="col-lg-12">
								<label>{{ trans('messages.interview_date') }}:</label>
								<input type="text" {{ $readonly }} autocomplete="off" name="interview_date" value="{{ old('interview_date') ? old('interview_date') : $preTestObj->interview_date }}" placeholder="{{ trans('messages.interview_date') }}" id="interview_date" class="form-control m-input {{ $errors->has('interview_date') ? "has-error" : "" }}">
								@if ($errors->has('interview_date'))
				                  	<span class="m-form__help">{{ $errors->first('interview_date') }}</span>
				              	@endif
							</div>
<!-- interviewrs_name -->
							<div class="col-lg-12">
								<label>{{ trans('messages.interviewrs_name') }}:</label>
								<input type="text" {{ $readonly }} name="interviewers_name" value="{{ $preTestObj->interviewers_name }}" placeholder="{{ trans('messages.interviewrs_name') }}" id="interviewers_name" class="form-control m-input {{ $errors->has('interviewers_name') ? "has-error" : "" }}" readonly="">
								@if ($errors->has('interviewers_name'))
				                  	<span class="m-form__help">{{ $errors->first('interviewers_name') }}</span>
				              	@endif
							</div>
<!-- code -->
							<div class="col-lg-12">
								<label>{{ trans('messages.code') }}:</label>
								<input type="text" name="code" value="{{ $preTestObj->code }}" placeholder="{{ trans('messages.code') }}" id="code" class="form-control m-input {{ $errors->has('code') ? "has-error" : "" }}" readonly="">
								@if ($errors->has('code'))
				                  	<span class="m-form__help">{{ $errors->first('code') }}</span>
				              	@endif
							</div>
<!-- age -->
							<div class="col-lg-12">
								<label>{{ trans('messages.age') }}:</label>
								<input type="text" {{ $readonly }} name="age" value="{{ old('age') ? old('age') : $preTestObj->age }}"  placeholder="{{ trans('messages.age') }}" id="age" class="form-control m-input {{ $errors->has('age') ? "has-error" : "" }}">
								@if ($errors->has('age'))
				                  	<span class="m-form__help">{{ $errors->first('age') }}</span>
				              	@endif
							</div>
<!-- gender -->
							<div class="col-lg-12">
								<label>{{ trans('messages.gender') }}:</label>
								<select {{ $disabled }} class="form-control m-input {{ $errors->has('gender') ? "has-error" : "" }}" id="gender" name="gender">
									<option value=""></option>
									<option value="male" {{ $preTestObj->gender == "male" ? "selected" : "" }}>{{ trans('messages.male') }}</option>
									<option value="female" {{ $preTestObj->gender == "female" ? "selected" : "" }}>{{ trans('messages.female') }}</option>
								</select>
								@if ($errors->has('gender'))
				                  	<span class="m-form__help">{{ $errors->first('gender') }}</span>
				              	@endif
							</div>
<!-- nationality -->
							<div class="col-lg-12">
								<label>{{ trans('messages.nationality') }}:</label>
								<select {{ $disabled }} class="form-control m-input {{ $errors->has('nationality') ? "has-error" : "" }}" id="nationality" name="nationality">
									<option value=""></option>
									<option value="Lebanese" {{ $preTestObj->nationality == "Lebanese" ? "selected" : "" }}>{{ trans('messages.lebanese') }}</option>
									<option value="Syrian" {{ $preTestObj->nationality == "Syrian" ? "selected" : "" }}>{{ trans('messages.syrian') }}</option>
									<option value="Palestinian" {{ $preTestObj->nationality == "Palestinian" ? "selected" : "" }}>{{ trans('messages.palestinian') }}</option>
									<option value="Other Nationality" {{ $preTestObj->nationality == "Other Nationality" ? "selected" : "" }}>{{ trans('messages.other_nationality') }}</option>
								</select>
								@if ($errors->has('nationality'))
				                  	<span class="m-form__help">{{ $errors->first('nationality') }}</span>
				              	@endif
							</div>
<!-- other_nationality -->
							<div class="col-lg-12" id="other_nationality_div" style="{{ $preTestObj->nationality != "Other Nationality" ? "display: none;" : ""}}">
								<label>{{ trans('messages.other_nationality') }}:</label>
								<input type="text" min="0" name="other_nationality" value="{{ $preTestObj->other_nationality }}"  placeholder="{{ trans('messages.other_nationality') }}" id="other_nationality" class="form-control m-input {{ $errors->has('other_nationality') ? "has-error" : "" }}" >
								@if ($errors->has('other_nationality'))
				                  	<span class="m-form__help">{{ $errors->first('other_nationality') }}</span>
				              	@endif
							</div>
<!-- [Post test] -->
<!-- total_number_of_hours_in_your_program -->
							@if($type == "post_test")
								<div class="col-lg-12">
									<label>{{ trans('messages.total_number_of_hours_in_your_program') }}:</label>
									<input type="number" min="0" name="total_number_of_hours_in_your_program" value="{{ old('total_number_of_hours_in_your_program') ? old('total_number_of_hours_in_your_program') : $preTestObj->total_number_of_hours_in_your_program }}"  placeholder="{{ trans('messages.total_number_of_hours_in_your_program') }}" id="total_number_of_hours_in_your_program" class="form-control m-input {{ $errors->has('total_number_of_hours_in_your_program') ? "has-error" : "" }}" >
									@if ($errors->has('total_number_of_hours_in_your_program'))
										<span class="m-form__help">{{ $errors->first('total_number_of_hours_in_your_program') }}</span>
									@endif
								</div>
<!-- number_of_hours_that_the_child_attended -->
								<div class="col-lg-12">
									<label>{{ trans('messages.number_of_hours_that_the_child_attended') }}:</label>
									<input type="number" min="0" name="number_of_hours_that_the_child_attended" value="{{ old('number_of_hours_that_the_child_attended') ? old('number_of_hours_that_the_child_attended') : $preTestObj->number_of_hours_that_the_child_attended }}"  placeholder="{{ trans('messages.number_of_hours_that_the_child_attended') }}" id="number_of_hours_that_the_child_attended" class="form-control m-input {{ $errors->has('number_of_hours_that_the_child_attended') ? "has-error" : "" }}" >
									@if ($errors->has('number_of_hours_that_the_child_attended'))
										<span class="m-form__help">{{ $errors->first('number_of_hours_that_the_child_attended') }}</span>
									@endif
								</div>
<!-- dropout_reason -->
								<div class="col-lg-12">
									<label>{{ trans('messages.dropout_reason') }}:</label>
									<select class="form-control m-input {{ $errors->has('dropout_reason') ? "has-error" : "" }}" id="dropout_reason" name="dropout_reason" >
										<option value="">{{ trans('messages.not_selected') }}</option>
										<option value="Did Not Drop Out" {{ $preTestObj->dropout_reason == "Did Not Drop Out" ? "selected" : "" }}>{{ trans('messages.did_not_drop_out') }}</option>
										<option value="Child was no longer allowed to access activity" {{ $preTestObj->dropout_reason == "Child was no longer allowed to access activity" ? "selected" : "" }}>{{ trans('messages.child_was_no_longer_allowed_to_access_activity') }}</option>
										<option value="Child said he did not want to participate in activity any longer" {{ $preTestObj->dropout_reason == "Child said he did not want to participate in activity any longer" ? "selected" : "" }}>{{ trans('messages.child_said_he_did_not_want_to_participate_in_activity_any_longer') }}</option>
										<option value="Relocation within Lebanon" {{ $preTestObj->dropout_reason == "Relocation within Lebanon" ? "selected" : "" }}>{{ trans('messages.relocation_within_lebanon') }}</option>
										<option value="Returned to Syria" {{ $preTestObj->dropout_reason == "Returned to Syria" ? "selected" : "" }}>{{ trans('messages.returned_to_syria') }}</option>
										<option value="Left for third country" {{ $preTestObj->dropout_reason == "Left for third country" ? "selected" : "" }}>{{ trans('messages.left_for_third_country') }}</option>
										<option value="Other reason" {{ $preTestObj->dropout_reason == "Other reason" ? "selected" : "" }}>{{ trans('messages.other_reason') }}</option>
									</select>
									@if ($errors->has('dropout_reason'))
										<span class="m-form__help">{{ $errors->first('dropout_reason') }}</span>
									@endif
								</div>
<!-- justify_the_dropout_reason_div -->
								<div class="col-lg-12" id="justify_the_dropout_reason_div" style="display: {{ $preTestObj->dropout_reason != "Did Not Drop Out" ? "block" : "none" }};">
									<label>{{ trans('messages.justify_the_dropout_reason') }}:</label>
									<input type="text" min="0" name="justify_the_dropout_reason" value="{{ $preTestObj->justify_the_dropout_reason }}"  placeholder="{{ trans('messages.justify_the_dropout_reason') }}" id="justify_the_dropout_reason" class="form-control m-input {{ $errors->has('justify_the_dropout_reason') ? "has-error" : "" }}" >
									@if ($errors->has('justify_the_dropout_reason'))
										<span class="m-form__help">{{ $errors->first('justify_the_dropout_reason') }}</span>
									@endif
								</div>
							@endif

						<div id="location_div" style="display: {{ $preTestObj->dropout_reason == "Did Not Drop Out" || $preTestObj->dropout_reason == "" ? "block" : "none" }};">
<!-- gouvarnate -->
								<div class="col-lg-12">
									<label>{{ trans('messages.gouvarnate') }}:</label>
									<select {{ $disabled }} class="form-control m-input {{ $errors->has('gouvarnate') ? "has-error" : "" }}" id="gouvarnate" name="gouvarnate">
										<option value=""></option>
										@foreach($gouvernates as $gov)
											<option value="{{ $gov->id }}" {{ $preTestObj->gouvarnate == $gov->id ? 'selected':'' }}>{{ app()->getLocale() == "ar" ? $gov->arabic != "" ? ucfirst($gov->arabic) : ucfirst($gov->name) : ucfirst($gov->name) }}</option>
										@endforeach
									</select>
									@if ($errors->has('gouvarnate'))
					                  	<span class="m-form__help">{{ $errors->first('gouvarnate') }}</span>
					              	@endif
								</div>
<!-- caza -->
								<div class="col-lg-12">
									<label>{{ trans('messages.caza') }}:</label>
									<select {{ $disabled }} class="form-control m-input {{ $errors->has('caza') ? "has-error" : "" }}" id="caza" name="caza">
										<option value=""></option>
									</select>
									@if ($errors->has('caza'))
					                  	<span class="m-form__help">{{ $errors->first('caza') }}</span>
					              	@endif
								</div>
<!-- area -->
								<div class="col-lg-12">
									<label>{{ trans('messages.area') }}:</label>
									<select {{ $disabled }} class="form-control m-input {{ $errors->has('area') ? "has-error" : "" }}" id="area" name="area">
										<option value=""></option>
									</select>
									@if ($errors->has('area'))
					                  	<span class="m-form__help">{{ $errors->first('area') }}</span>
					              	@endif
								</div>
<!-- gateway_type -->
								<div class="col-lg-12">
									<label>{{ trans('messages.gateway_type') }}:</label>
									<select {{ $disabled }} class="form-control m-input {{ $errors->has('gateway_type') ? "has-error" : "" }}" id="gateway_type" name="gateway_type">
										<option value=""></option>
										<option value="Informal Settlement" {{ $preTestObj->gateway_type == "Informal Settlement" ? "selected" : "" }}>{{ trans('messages.informal_settlement') }}</option>
										<option value="Social Development Center" {{ $preTestObj->gateway_type == "Social Development Center" ? "selected" : "" }}>{{ trans('messages.social_development_center') }}</option>
										<option value="School" {{ $preTestObj->gateway_type == "School" ? "selected" : "" }}>{{ trans('messages.school') }}</option>
										<option value="Primary Health Center" {{ $preTestObj->gateway_type == "Primary Health Center" ? "selected" : "" }}>{{ trans('messages.primary_health_center') }}</option>
										<option value="Secondary Health Center" {{ $preTestObj->gateway_type == "Secondary Health Center" ? "selected" : "" }}>{{ trans('messages.secondary_health_center') }}</option>
										<option value="Municipality" {{ $preTestObj->gateway_type == "Municipality" ? "selected" : "" }}>{{ trans('messages.municipality') }}</option>
										<option value="Community center" {{ $preTestObj->gateway_type == "Community center" ? "selected" : "" }}>{{ trans('messages.community_center') }}</option>
										<option value="Palestinian camp" {{ $preTestObj->gateway_type == "Palestinian camp" ? "selected" : "" }}>{{ trans('messages.palestinian_camp') }}</option>
										<option value="Palestinian gathering" {{ $preTestObj->gateway_type == "Palestinian gathering" ? "selected" : "" }}>{{ trans('messages.palestinian_gathering') }}</option>
										<option value="UNHCR registration center" {{ $preTestObj->gateway_type == "UNHCR registration center" ? "selected" : "" }}>{{ trans('messages.UNHCR_registration_center') }}</option>
										<option value="Border crossing, Other" {{ $preTestObj->gateway_type == "Border crossing, Other" ? "selected" : "" }}>{{ trans('messages.border_crossing_other') }}</option>
									</select>
									@if ($errors->has('gateway_type'))
					                  	<span class="m-form__help">{{ $errors->first('gateway_type') }}</span>
					              	@endif
								</div>
<!-- p_code -->
								<div class="col-lg-12">
									<label>{{ trans('messages.p_code') }}:</label>
									<input type="text" {{ $readonly }} name="p_code" placeholder="{{ trans('messages.p_code') }}" id="p_code" value="{{ old('p_code') ? old('p_code') : $preTestObj->p_code }}" class="form-control m-input {{ $errors->has('p_code') ? "has-error" : "" }}">
									@if ($errors->has('p_code'))
					                  	<span class="m-form__help">{{ $errors->first('p_code') }}</span>
					              	@endif
								</div>
<!-- latitude -->
								<div class="col-lg-12">
									<div class="form-group m-form__group row">
										<div class="col-lg-12">
											<label>{{ trans('messages.latitude') }}:</label>
											<input type="text" {{ $readonly }} name="latitude" placeholder="{{ trans('messages.latitude') }}" id="latitude" value="{{ old('latitude') ? old('latitude') : $preTestObj->latitude }}" class="form-control m-input {{ $errors->has('latitude') ? "has-error" : "" }}">
											@if ($errors->has('latitude'))
							                  	<span class="m-form__help">{{ $errors->first('latitude') }}</span>
							              	@endif
										</div>
<!-- longitude -->
										<div class="col-lg-12">
											<label>{{ trans('messages.longitude') }}:</label>
											<input type="text" {{ $readonly }} name="longitude" placeholder="{{ trans('messages.longitude') }}" id="longitude" value="{{ old('longitude') ? old('longitude') : $preTestObj->longitude }}" class="form-control m-input {{ $errors->has('longitude') ? "has-error" : "" }}">
											@if ($errors->has('longitude'))
							                  	<span class="m-form__help">{{ $errors->first('longitude') }}</span>
							              	@endif
										</div>
<!-- altitude -->
										<div class="col-lg-12">
											<label>{{ trans('messages.altitude') }}:</label>
											<input type="number" {{ $readonly }} name="altitude" placeholder="{{ trans('messages.altitude') }}" id="altitude" value="{{ old('altitude') ? old('altitude') : $preTestObj->altitude }}" class="form-control m-input {{ $errors->has('altitude') ? "has-error" : "" }}">
											@if ($errors->has('altitude'))
							                  	<span class="m-form__help">{{ $errors->first('altitude') }}</span>
							              	@endif
										</div>
<!-- accuracy -->
										<div class="col-lg-12">
											<label>{{ trans('messages.accuracy') }}:</label>
											<input type="number" {{ $readonly }} name="accuracy" placeholder="{{ trans('messages.accuracy') }}" id="accuracy" value="{{ old('accuracy') ? old('accuracy') : $preTestObj->accuracy }}" class="form-control m-input {{ $errors->has('accuracy') ? "has-error" : "" }}">
											@if ($errors->has('accuracy'))
							                  	<span class="m-form__help">{{ $errors->first('accuracy') }}</span>
							              	@endif
										</div>
									</div>
								</div>
								<div class="col-lg-12"></div>

								<div class="col-lg-12">
									<h5>{{ trans('messages.consent_title') }}</h5>
									<label>
										{{ trans('messages.consent', ['name' => $preTestObj->interviewers_name, 'agency' => $preTestObj->agency_name]) }}

										@if($type == "pre_test")
										<p>{{ trans('messages.consent_extra_pretest') }}</p>
										@endif

										@if($type == "post_test")
										<p>{{ trans('messages.consent_extra_postest') }}</p>
										@endif

									</label>
								</div>

								<div class="col-lg-12">
									<label>{{ trans('messages.may_i_start_now') }}:</label>
									<select  class="form-control m-input {{ $errors->has('may_i_start_now') ? "has-error" : "" }}" id="may_i_start_now" name="may_i_start_now">
										<option value="">{{ trans('messages.not_selected') }}</option>
										<option value="yes" {{ $preTestObj->may_i_start_now == "yes" ? "selected" : "" }}>{{ trans('messages.yes_permission') }}</option>
										<option value="no" {{ $preTestObj->may_i_start_now == "no" ? "selected" : "" }}>{{ trans('messages.no_permission') }}</option>
									</select>
									@if ($errors->has('may_i_start_now'))
					                  	<span class="m-form__help">{{ $errors->first('may_i_start_now') }}</span>
					              	@endif
								</div>
								<div class="col-lg-12">
									<label>{{ trans('messages.comment') }}:</label>
									<textarea name="comment" placeholder="{{ trans('messages.comment') }}" id="comment" class="form-control m-input {{ $errors->has('comment') ? "has-error" : "" }}">{{ old('comment') ? old('comment') : $preTestObj->comment }}</textarea>
									@if ($errors->has('comment'))
					                  	<span class="m-form__help">{{ $errors->first('comment') }}</span>
					              	@endif
								</div>

						</div>
					</div>
				</div>

				<!--end::Form-->
			</div>
			<div class="m-portlet" id="step_2" style="display: {{ $preTestObj->may_i_start_now == "yes" ? "block" : "none" }};">
				<div class="m-portlet__body">
<!-- considerate_of_other_peoples_feelings -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.considerate_of_other_peoples_feelings') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.considerate_of_other_peoples_feelings') }}:</label>
							<select class="form-control m-input {{ $errors->has('considerate_of_other_peoples_feelings') ? "has-error" : "" }}" id="considerate_of_other_peoples_feelings" name="considerate_of_other_peoples_feelings">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->considerate_of_other_peoples_feelings == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->considerate_of_other_peoples_feelings == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->considerate_of_other_peoples_feelings == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->considerate_of_other_peoples_feelings == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('considerate_of_other_peoples_feelings'))
			                  	<span class="m-form__help">{{ $errors->first('considerate_of_other_peoples_feelings') }}</span>
			              	@endif
						</div>
<!-- restless_overactive_cannot_stay_still_for_long -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.restless_overactive_cannot_stay_still_for_long') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.restless_overactive_cannot_stay_still_for_long') }}:</label>
							<select class="form-control m-input {{ $errors->has('restless_overactive_cannot_stay_still_for_long') ? "has-error" : "" }}" id="restless_overactive_cannot_stay_still_for_long" name="restless_overactive_cannot_stay_still_for_long">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->restless_overactive_cannot_stay_still_for_long == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->restless_overactive_cannot_stay_still_for_long == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->restless_overactive_cannot_stay_still_for_long == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->restless_overactive_cannot_stay_still_for_long == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('restless_overactive_cannot_stay_still_for_long'))
			                  	<span class="m-form__help">{{ $errors->first('restless_overactive_cannot_stay_still_for_long') }}</span>
			              	@endif
						</div>
<!-- often_complains_of_headaches_stomach_aches_or_sickness -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.often_complains_of_headaches_stomach_aches_or_sickness') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.often_complains_of_headaches_stomach_aches_or_sickness') }}:</label>
							<select class="form-control m-input {{ $errors->has('often_complains_of_headaches_stomach_aches_or_sickness') ? "has-error" : "" }}" id="often_complains_of_headaches_stomach_aches_or_sickness" name="often_complains_of_headaches_stomach_aches_or_sickness">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->often_complains_of_headaches_stomach_aches_or_sickness == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->often_complains_of_headaches_stomach_aches_or_sickness == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->often_complains_of_headaches_stomach_aches_or_sickness == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->often_complains_of_headaches_stomach_aches_or_sickness == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('often_complains_of_headaches_stomach_aches_or_sickness'))
			                  	<span class="m-form__help">{{ $errors->first('often_complains_of_headaches_stomach_aches_or_sickness') }}</span>
			              	@endif
						</div>
<!-- shares_readily_with_other_children_for_example_toys -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.shares_readily_with_other_children_for_example_toys') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.shares_readily_with_other_children_for_example_toys') }}:</label>
							<select class="form-control m-input {{ $errors->has('shares_readily_with_other_children_for_example_toys') ? "has-error" : "" }}" id="shares_readily_with_other_children_for_example_toys" name="shares_readily_with_other_children_for_example_toys">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->shares_readily_with_other_children_for_example_toys == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->shares_readily_with_other_children_for_example_toys == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->shares_readily_with_other_children_for_example_toys == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->shares_readily_with_other_children_for_example_toys == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('shares_readily_with_other_children_for_example_toys'))
			                  	<span class="m-form__help">{{ $errors->first('shares_readily_with_other_children_for_example_toys') }}</span>
			              	@endif
						</div>
<!-- often_loses_temper -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.often_loses_temper') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.often_loses_temper') }}:</label>
							<select class="form-control m-input {{ $errors->has('often_loses_temper') ? "has-error" : "" }}" id="often_loses_temper" name="often_loses_temper">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->often_loses_temper == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->often_loses_temper == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->often_loses_temper == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->often_loses_temper == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('often_loses_temper'))
			                  	<span class="m-form__help">{{ $errors->first('often_loses_temper') }}</span>
			              	@endif
						</div>
<!-- rather_solitary_prefers_to_play_alone -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.rather_solitary_prefers_to_play_alone') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.rather_solitary_prefers_to_play_alone') }}:</label>
							<select class="form-control m-input {{ $errors->has('rather_solitary_prefers_to_play_alone') ? "has-error" : "" }}" id="rather_solitary_prefers_to_play_alone" name="rather_solitary_prefers_to_play_alone">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->rather_solitary_prefers_to_play_alone == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->rather_solitary_prefers_to_play_alone == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->rather_solitary_prefers_to_play_alone == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->rather_solitary_prefers_to_play_alone == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('rather_solitary_prefers_to_play_alone'))
			                  	<span class="m-form__help">{{ $errors->first('rather_solitary_prefers_to_play_alone') }}</span>
			              	@endif
						</div>
<!-- generally_well_behaved_usually_does_what_adults_request -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.generally_well_behaved_usually_does_what_adults_request') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.generally_well_behaved_usually_does_what_adults_request') }}:</label>
							<select class="form-control m-input {{ $errors->has('generally_well_behaved_usually_does_what_adults_request') ? "has-error" : "" }}" id="generally_well_behaved_usually_does_what_adults_request" name="generally_well_behaved_usually_does_what_adults_request">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="2" {{ $preTestObj->generally_well_behaved_usually_does_what_adults_request == "2" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->generally_well_behaved_usually_does_what_adults_request == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="0" {{ $preTestObj->generally_well_behaved_usually_does_what_adults_request == "0" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->generally_well_behaved_usually_does_what_adults_request == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('generally_well_behaved_usually_does_what_adults_request'))
			                  	<span class="m-form__help">{{ $errors->first('generally_well_behaved_usually_does_what_adults_request') }}</span>
			              	@endif
						</div>
<!-- many_worries_or_often_seems_worried -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.many_worries_or_often_seems_worried') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.many_worries_or_often_seems_worried') }}:</label>
							<select class="form-control m-input {{ $errors->has('many_worries_or_often_seems_worried') ? "has-error" : "" }}" id="many_worries_or_often_seems_worried" name="many_worries_or_often_seems_worried">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->many_worries_or_often_seems_worried == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->many_worries_or_often_seems_worried == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->many_worries_or_often_seems_worried == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->many_worries_or_often_seems_worried == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('many_worries_or_often_seems_worried'))
			                  	<span class="m-form__help">{{ $errors->first('many_worries_or_often_seems_worried') }}</span>
			              	@endif
						</div>
<!-- helpful_if_someone_is_hurt_upset_or_feeling_ill -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.helpful_if_someone_is_hurt_upset_or_feeling_ill') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.helpful_if_someone_is_hurt_upset_or_feeling_ill') }}:</label>
							<select class="form-control m-input {{ $errors->has('helpful_if_someone_is_hurt_upset_or_feeling_ill') ? "has-error" : "" }}" id="helpful_if_someone_is_hurt_upset_or_feeling_ill" name="helpful_if_someone_is_hurt_upset_or_feeling_ill">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->helpful_if_someone_is_hurt_upset_or_feeling_ill == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->helpful_if_someone_is_hurt_upset_or_feeling_ill == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->helpful_if_someone_is_hurt_upset_or_feeling_ill == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->helpful_if_someone_is_hurt_upset_or_feeling_ill == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('helpful_if_someone_is_hurt_upset_or_feeling_ill'))
			                  	<span class="m-form__help">{{ $errors->first('helpful_if_someone_is_hurt_upset_or_feeling_ill') }}</span>
			              	@endif
						</div>
<!-- constantly_fidgeting_or_squirming -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.constantly_fidgeting_or_squirming') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.constantly_fidgeting_or_squirming') }}:</label>
							<select class="form-control m-input {{ $errors->has('helpful_if_someone_is_hurt_upset_or_feeling_ill') ? "has-error" : "" }}" id="constantly_fidgeting_or_squirming" name="constantly_fidgeting_or_squirming">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->constantly_fidgeting_or_squirming == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->constantly_fidgeting_or_squirming == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->constantly_fidgeting_or_squirming == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->constantly_fidgeting_or_squirming == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('constantly_fidgeting_or_squirming'))
			                  	<span class="m-form__help">{{ $errors->first('constantly_fidgeting_or_squirming') }}</span>
			              	@endif
						</div>
<!-- has_at_least_one_good_friend -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.has_at_least_one_good_friend') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.has_at_least_one_good_friend') }}:</label>
							<select class="form-control m-input {{ $errors->has('has_at_least_one_good_friend') ? "has-error" : "" }}" id="has_at_least_one_good_friend" name="has_at_least_one_good_friend">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="2" {{ $preTestObj->has_at_least_one_good_friend == "2" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->has_at_least_one_good_friend == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="0" {{ $preTestObj->has_at_least_one_good_friend == "0" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->has_at_least_one_good_friend == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('has_at_least_one_good_friend'))
			                  	<span class="m-form__help">{{ $errors->first('has_at_least_one_good_friend') }}</span>
			              	@endif
						</div>
<!-- often_fights_with_other_hildren_or_bullies_them -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.often_fights_with_other_hildren_or_bullies_them') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.often_fights_with_other_hildren_or_bullies_them') }}:</label>
							<select class="form-control m-input {{ $errors->has('often_fights_with_other_hildren_or_bullies_them') ? "has-error" : "" }}" id="often_fights_with_other_hildren_or_bullies_them" name="often_fights_with_other_hildren_or_bullies_them">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->often_fights_with_other_hildren_or_bullies_them == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->often_fights_with_other_hildren_or_bullies_them == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->often_fights_with_other_hildren_or_bullies_them == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->often_fights_with_other_hildren_or_bullies_them == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('often_fights_with_other_hildren_or_bullies_them'))
			                  	<span class="m-form__help">{{ $errors->first('often_fights_with_other_hildren_or_bullies_them') }}</span>
			              	@endif
						</div>
<!-- often_unhappy_depressed_or_tearful -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.often_unhappy_depressed_or_tearful') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.often_unhappy_depressed_or_tearful') }}:</label>
							<select class="form-control m-input {{ $errors->has('often_unhappy_depressed_or_tearful') ? "has-error" : "" }}" id="often_unhappy_depressed_or_tearful" name="often_unhappy_depressed_or_tearful">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->often_unhappy_depressed_or_tearful == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->often_unhappy_depressed_or_tearful == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->often_unhappy_depressed_or_tearful == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->often_unhappy_depressed_or_tearful == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('often_unhappy_depressed_or_tearful'))
			                  	<span class="m-form__help">{{ $errors->first('often_unhappy_depressed_or_tearful') }}</span>
			              	@endif
						</div>
<!-- generally_liked_by_other_children -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.generally_liked_by_other_children') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.generally_liked_by_other_children') }}:</label>
							<select class="form-control m-input {{ $errors->has('generally_liked_by_other_children') ? "has-error" : "" }}" id="generally_liked_by_other_children" name="generally_liked_by_other_children">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="2" {{ $preTestObj->generally_liked_by_other_children == "2" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->generally_liked_by_other_children == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="0" {{ $preTestObj->generally_liked_by_other_children == "0" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->generally_liked_by_other_children == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('generally_liked_by_other_children'))
			                  	<span class="m-form__help">{{ $errors->first('generally_liked_by_other_children') }}</span>
			              	@endif
						</div>
<!-- easily_distracted_concentration_wanders -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.easily_distracted_concentration_wanders') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.easily_distracted_concentration_wanders') }}:</label>
							<select class="form-control m-input {{ $errors->has('easily_distracted_concentration_wanders') ? "has-error" : "" }}" id="easily_distracted_concentration_wanders" name="easily_distracted_concentration_wanders">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->easily_distracted_concentration_wanders == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->easily_distracted_concentration_wanders == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->easily_distracted_concentration_wanders == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->easily_distracted_concentration_wanders == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('easily_distracted_concentration_wanders'))
			                  	<span class="m-form__help">{{ $errors->first('easily_distracted_concentration_wanders') }}</span>
			              	@endif
						</div>
<!-- nervous_or_clingy_in_new_situations_easily_loses_confidence -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.nervous_or_clingy_in_new_situations_easily_loses_confidence') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.nervous_or_clingy_in_new_situations_easily_loses_confidence') }}:</label>
							<select class="form-control m-input {{ $errors->has('nervous_or_clingy_in_new_situations_easily_loses_confidence') ? "has-error" : "" }}" id="nervous_or_clingy_in_new_situations_easily_loses_confidence" name="nervous_or_clingy_in_new_situations_easily_loses_confidence">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->nervous_or_clingy_in_new_situations_easily_loses_confidence == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->nervous_or_clingy_in_new_situations_easily_loses_confidence == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->nervous_or_clingy_in_new_situations_easily_loses_confidence == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->nervous_or_clingy_in_new_situations_easily_loses_confidence == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('nervous_or_clingy_in_new_situations_easily_loses_confidence'))
			                  	<span class="m-form__help">{{ $errors->first('nervous_or_clingy_in_new_situations_easily_loses_confidence') }}</span>
			              	@endif
						</div>
<!-- kind_to_younger_children -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.kind_to_younger_children') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.kind_to_younger_children') }}:</label>
							<select class="form-control m-input {{ $errors->has('kind_to_younger_children') ? "has-error" : "" }}" id="kind_to_younger_children" name="kind_to_younger_children">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->kind_to_younger_children == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->kind_to_younger_children == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->kind_to_younger_children == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->kind_to_younger_children == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('kind_to_younger_children'))
			                  	<span class="m-form__help">{{ $errors->first('kind_to_younger_children') }}</span>
			              	@endif
						</div>
<!-- often_lies_or_cheats -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.often_lies_or_cheats') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.often_lies_or_cheats') }}:</label>
							<select class="form-control m-input {{ $errors->has('often_lies_or_cheats') ? "has-error" : "" }}" id="often_lies_or_cheats" name="often_lies_or_cheats">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->often_lies_or_cheats == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->often_lies_or_cheats == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->often_lies_or_cheats == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->often_lies_or_cheats == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('often_lies_or_cheats'))
			                  	<span class="m-form__help">{{ $errors->first('often_lies_or_cheats') }}</span>
			              	@endif
						</div>
<!-- picked_on_or_bullied_by_other_children -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.picked_on_or_bullied_by_other_children') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.picked_on_or_bullied_by_other_children') }}:</label>
							<select class="form-control m-input {{ $errors->has('picked_on_or_bullied_by_other_children') ? "has-error" : "" }}" id="picked_on_or_bullied_by_other_children" name="picked_on_or_bullied_by_other_children">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->picked_on_or_bullied_by_other_children == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->picked_on_or_bullied_by_other_children == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->picked_on_or_bullied_by_other_children == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->picked_on_or_bullied_by_other_children == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('picked_on_or_bullied_by_other_children'))
			                  	<span class="m-form__help">{{ $errors->first('picked_on_or_bullied_by_other_children') }}</span>
			              	@endif
						</div>
<!-- often_offers_to_help_others -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.often_offers_to_help_others') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.often_offers_to_help_others') }}:</label>
							<select class="form-control m-input {{ $errors->has('often_offers_to_help_others') ? "has-error" : "" }}" id="often_offers_to_help_others" name="often_offers_to_help_others">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->often_offers_to_help_others == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->often_offers_to_help_others == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->often_offers_to_help_others == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->often_offers_to_help_others == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('often_offers_to_help_others'))
			                  	<span class="m-form__help">{{ $errors->first('often_offers_to_help_others') }}</span>
			              	@endif
						</div>
<!-- thinks_things_out_before_acting -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.thinks_things_out_before_acting') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.thinks_things_out_before_acting') }}:</label>
							<select class="form-control m-input {{ $errors->has('thinks_things_out_before_acting') ? "has-error" : "" }}" id="thinks_things_out_before_acting" name="thinks_things_out_before_acting">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="2" {{ $preTestObj->thinks_things_out_before_acting == "2" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->thinks_things_out_before_acting == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="0" {{ $preTestObj->thinks_things_out_before_acting == "0" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->thinks_things_out_before_acting == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('thinks_things_out_before_acting'))
			                  	<span class="m-form__help">{{ $errors->first('thinks_things_out_before_acting') }}</span>
			              	@endif
						</div>
<!-- steals_from_home_school_or_elsewhere -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.steals_from_home_school_or_elsewhere') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.steals_from_home_school_or_elsewhere') }}:</label>
							<select class="form-control m-input {{ $errors->has('steals_from_home_school_or_elsewhere') ? "has-error" : "" }}" id="steals_from_home_school_or_elsewhere" name="steals_from_home_school_or_elsewhere">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->steals_from_home_school_or_elsewhere == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->steals_from_home_school_or_elsewhere == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->steals_from_home_school_or_elsewhere == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->steals_from_home_school_or_elsewhere == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('steals_from_home_school_or_elsewhere'))
			                  	<span class="m-form__help">{{ $errors->first('steals_from_home_school_or_elsewhere') }}</span>
			              	@endif
						</div>
<!-- gets_along_better_with_adults_than_with_other_children -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.gets_along_better_with_adults_than_with_other_children') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.gets_along_better_with_adults_than_with_other_children') }}:</label>
							<select class="form-control m-input {{ $errors->has('gets_along_better_with_adults_than_with_other_children') ? "has-error" : "" }}" id="gets_along_better_with_adults_than_with_other_children" name="gets_along_better_with_adults_than_with_other_children">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->gets_along_better_with_adults_than_with_other_children == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->gets_along_better_with_adults_than_with_other_children == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->gets_along_better_with_adults_than_with_other_children == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->gets_along_better_with_adults_than_with_other_children == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('gets_along_better_with_adults_than_with_other_children'))
			                  	<span class="m-form__help">{{ $errors->first('gets_along_better_with_adults_than_with_other_children') }}</span>
			              	@endif
						</div>
<!-- many_fears_easily_scared -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.many_fears_easily_scared') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.many_fears_easily_scared') }}:</label>
							<select class="form-control m-input {{ $errors->has('many_fears_easily_scared') ? "has-error" : "" }}" id="many_fears_easily_scared" name="many_fears_easily_scared">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="0" {{ $preTestObj->many_fears_easily_scared == "0" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->many_fears_easily_scared == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="2" {{ $preTestObj->many_fears_easily_scared == "2" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->many_fears_easily_scared == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('many_fears_easily_scared'))
			                  	<span class="m-form__help">{{ $errors->first('many_fears_easily_scared') }}</span>
			              	@endif
						</div>
<!-- good_attention_span_sees_chores_or_homework_through_to_the_end -->
						<div class="col-lg-12">
							<label class="6_11">{{ trans('messages.6_11.good_attention_span_sees_chores_or_homework_through_to_the_end') }}:</label>
							<label class="12_17" style="display:none;">{{ trans('messages.12_17.good_attention_span_sees_chores_or_homework_through_to_the_end') }}:</label>
							<select class="form-control m-input {{ $errors->has('good_attention_span_sees_chores_or_homework_through_to_the_end') ? "has-error" : "" }}" id="good_attention_span_sees_chores_or_homework_through_to_the_end" name="good_attention_span_sees_chores_or_homework_through_to_the_end">
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="2" {{ $preTestObj->good_attention_span_sees_chores_or_homework_through_to_the_end == "2" ? 'selected' : "" }}>{{ trans('messages.not_true') }}</option>
								<option value="1" {{ $preTestObj->good_attention_span_sees_chores_or_homework_through_to_the_end == "1" ? 'selected' : "" }}>{{ trans('messages.somewhat_true') }}</option>
								<option value="0" {{ $preTestObj->good_attention_span_sees_chores_or_homework_through_to_the_end == "0" ? 'selected' : "" }}>{{ trans('messages.certainly_true') }}</option>
								<option value="na" {{ $preTestObj->good_attention_span_sees_chores_or_homework_through_to_the_end == "na" ? 'selected' : "" }}>{{ trans('messages.no_answer') }}</option>
							</select>
							@if ($errors->has('good_attention_span_sees_chores_or_homework_through_to_the_end'))
			                  	<span class="m-form__help">{{ $errors->first('good_attention_span_sees_chores_or_homework_through_to_the_end') }}</span>
			              	@endif
						</div>

						<!-- do_the_child_receive_any_other_child_protection_services -->
						@if($type == "post_test")
							<div class="form-group m-form__group row">
								@php
									$multiselect = array();
									if($preTestObj->do_the_child_receive_any_other_child_protection_services){
										$multiselect = explode(",", $preTestObj->do_the_child_receive_any_other_child_protection_services);
									}
								@endphp
								<div class="col-lg-12">
									<label >{{ trans('messages.do_the_child_receive_any_other_child_protection_services') }}:</label>
									<label class="m-radio m-radio--bold m-radio--state-brand">
										<input type="radio" name="services" value="yes" {{ !in_array("No", $multiselect) && count($multiselect) > 0 ? 'checked' : "" }}> {{ trans('messages.yes') }}
										<span></span>
									</label>
									<label class="m-radio m-radio--bold m-radio--state-brand">
										<input type="radio" name="services" value="no" {{ in_array("No", $multiselect) || count($multiselect) == 0 ? 'checked' : "" }}> {{ trans('messages.no') }}
										<span></span>
									</label>
								</div>
							</div>
							
							<div class="form-group m-form__group row" id="service_div" style="{{ count($multiselect) == 0 ? 'display: none;' : "" }}">
								<div class="col-lg-12">
									<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
										<input type="checkbox" value="Case management" {{ in_array("Case management", $multiselect) ? 'checked' : "" }} name="do_the_child_receive_any_other_child_protection_services[]">{{ trans('messages.case_management') }}
										<span></span>
									</label><br>
									<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
										<input type="checkbox" value="Community based Child protection activities" {{ in_array("Community based Child protection activities", $multiselect) ? 'checked' : "" }} name="do_the_child_receive_any_other_child_protection_services[]">{{ trans('messages.community_based_child_protection_activities') }}
										<span></span>
									</label><br>
									<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
										<input type="checkbox" value="Formal Education" {{ in_array("Formal Education", $multiselect) ? 'checked' : "" }} name="do_the_child_receive_any_other_child_protection_services[]">{{ trans('messages.formal_education') }}
										<span></span>
									</label><br>
									<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
										<input type="checkbox" value="Non-formal education (VET programs…)" {{ in_array("Non-formal education (VET programs…)", $multiselect) ? 'checked' : "" }} name="do_the_child_receive_any_other_child_protection_services[]">{{ trans('messages.non_formal_education') }}
										<span></span>
									</label><br>
									@if ($errors->has('do_the_child_receive_any_other_child_protection_services'))
										<span class="m-form__help">{{ $errors->first('do_the_child_receive_any_other_child_protection_services') }}</span>
									@endif
								</div>
							</div>
						@endif

					</div>


				</div>
			</div>
			<div class="" id="footer_div" style="{{ $preTestObj->form == "" ? 'display:none;' : "" }}">
				<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions--solid">
						<div class="row">

								@if((empty($preTestObj->pre_test_date) && $type == "pre_test") || (empty($preTestObj->post_test_date) && $type == "post_test"))
									<button type="submit" name="submit" value="save" class="btn btn-info">{{ trans('messages.save') }}</button>
								@endif
								<button type="submit" name="submit" value="submit" class="btn btn-info">{{ trans('messages.submit') }}</button>
								<button type="reset" class="btn btn-secondary">{{ trans('messages.reset') }}</button>

						</div>
					</div>
				</div>
			</div>

		<!--end::Portlet-->
		</form>
	</div>
	<div class="col-lg-3 d-none"></div>
</div>
@endsection

@section('js')
<script src="{{ url('/public') }}/assets/vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="{{ url('/public') }}/assets/vendors/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
<script src="{{ url('/public') }}/assets/vendors/select2/dist/js/select2.full.js" type="text/javascript"></script>
<script type="text/javascript" src="{{ url('/public') }}/assets/leb/bootstrap-material-datetimepicker.js" /></script>
<script type="text/javascript">
   $(document).ready(function(){
   		$('#form').trigger('change');
   		var app_locale = "{{ app()->getLocale() }}";
   		/*$('#interview_date').datetimepicker({
            todayHighlight: true,
            autoclose: true,
            defaultDate:new Date(),
            initialDate: new Date("+2D"),
            format: 'yyyy-mm-dd hh:ii'
        });*/
        $('#interview_date').bootstrapMaterialDatePicker({ 
        	format : 'YYYY-MM-DD HH:mm', 
        	autoclose: true,
        	minDate : new Date() 
        });
   		getCaza("{{ $preTestObj->gouvarnate }}");
   		getArea("{{ $preTestObj->caza }}");
   		getLocation();
   		$('#gouvarnate').change(function(e){
   			e.preventDefault();
   			var gov_id = $(this).val();
   			$('#caza').html("");
   			getCaza(gov_id);
   			$('#area').html("<option value=''>{{ trans('messages.select_area') }}</option>");
   		})

   		$(document).on('blur','.has-error',function(){
   			if($(this).val() != ""){
   				$(this).removeClass('has-error');
   				$(this).next('.m-form__help').hide();
   			}
   		})

   		$('input[type=radio][name=services]').change(function() {
		    if (this.value == 'yes') {
		        $('#service_div').show();
		    }else{
		        $('#service_div').hide();
		    }
		});

   		$('#nationality').change(function(){
   			if($(this).val() == "Other Nationality"){
   				$('#other_nationality_div').show();
   			}else{
   				$('#other_nationality_div').hide();
   				$('#other_nationality').val("");
   			}
   		})

   		$('#form').change(function(){
   			if("Form 6-11" == $(this).val()){
   				$('#main_form').show();
   				$('#footer_div').show();
   				$('.6_11').show();
   				$('.12_17').hide();
   			}else if("Form 12-17" == $(this).val()){
   				$('#main_form').show();
   				$('#footer_div').show();
   				$('.6_11').hide();
   				$('.12_17').show();
   			}else{
   				$('#main_form').hide();
   				$('#footer_div').hide();
   				$('.6_11').show();
   				$('.12_17').hide();
   			}
   		})

   		$('#caza').change(function(e){
   			e.preventDefault();
   			var caza_id = $(this).val();
   			getArea(caza_id);
   		})

   		$('#may_i_start_now').change(function(){
   			if($(this).val() == "yes"){
   				$('#step_2').show();
		        $('#do_the_child_receive_any_other_child_protection_services').select2({
		            placeholder: "{{ trans('messages.do_the_child_receive_any_other_child_protection_services') }}",
		        });
   			}else{
   				$('#step_2').hide();
   			}
   		})

   		$('#dropout_reason').change(function(){
   			if($(this).val() != "Did Not Drop Out"){
   				$('#justify_the_dropout_reason_div').show();
   				$('#location_div').hide();
   				$('#step_2').hide();
   			}else{
   				$('#location_div').show();
   				$('#justify_the_dropout_reason_div').hide();
   			}
   		})
   });
   	function getCaza(gov_id){
   		var app_locale = "{{ app()->getLocale() }}";
		var selected_caza = "{{ $preTestObj->caza }}";
		$.post('{{ url("get-caza") }}',{gov_id:gov_id,selected_caza:selected_caza,_token:"{{ csrf_token() }}"},function(response){
			var optionHtml       = "<option value=''>{{ trans('messages.select_caza') }}</option>"
			for(var i=0;i<response.response.length;i++){
				var selected = "";
				if(response.response[i]['id'] == selected_caza){
					selected = "selected";
				}
				var caza_name = response.response[i]['name'];
				if(app_locale == "ar"){
					if(response.response[i]['arabic'] != ""){
						caza_name = response.response[i]['arabic'];
					}else{
						caza_name = response.response[i]['name'];
					}
				}
				optionHtml += '<option value="'+response.response[i]['id']+'" '+selected+'>'+ caza_name+'</option>';
            }
        	$('#caza').html(optionHtml);
     	});
   	}
   	function getArea(caza_id){
   		var app_locale = "{{ app()->getLocale() }}";
		var selected_area = "{{ $preTestObj->area }}";
		$.post('{{ url("get-area") }}',{caza_id:caza_id,selected_area:selected_area,_token:"{{ csrf_token() }}"},function(response){
			var optionHtml       = "<option value=''>{{ trans('messages.select_area') }}</option>"
			for(var i=0;i<response.response.length;i++){
				var selected = "";
				if(response.response[i]['id'] == selected_area){
					selected = "selected";
				}
				var area_name = response.response[i]['name'];
				if(app_locale == "ar"){
					if(response.response[i]['arabic'] != ""){
						area_name = response.response[i]['arabic'];
					}else{
						area_name = response.response[i]['name'];
					}
				}
				optionHtml += '<option value="'+response.response[i]['id']+'" '+selected+'>'+area_name+'</option>';
            }
        	$('#area').html(optionHtml);
     	});
   	}
   	function getLocation(){
   		$.post('{{ url("get-location") }}',{_token:"{{ csrf_token() }}"},function(response){
   			if(response.location != "null" && response.location != null){
   				$('#latitude').val(response.location['latitude']);
   				$('#longitude').val(response.location['longitude']);
   			}
     	});
   	}
</script>
@endsection