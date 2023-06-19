@extends('admin.layout.app')

@section('title',"Pre Test Application")

@section('breadcrumb')
	<a href="{{ url('/application-list') }}">Application List</a>
@endsection

@section('css')
	<link href="{{ url('/public') }}/assets/vendors/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
	<link href="{{ url('/public') }}/assets/vendors/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
	<link href="{{ url('/public') }}/assets/vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
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
		@endphp
		
		
		@if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif
		
		<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="pre_test" method="post" action="{{ $action }}">
			@csrf
			<input type="hidden" name="code" value="{{ $preTestObj->code }}">
			@if($type == 'post_test')
			<input type="hidden" name="form" value="{{ $preTestObj->form }}">
			<input type="hidden" name="agency_name" value="{{ $preTestObj->agency_name }}">
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

				<!--begin::Form-->
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.Form') }}:</label>
							<select class="form-control m-input" id="form" name="form" {{ $disabled }} >
								<option value="">{{ trans('messages.select_form') }}</option>
								<option value="Form 6-11" {{ $preTestObj->form == "Form 6-11" ? "selected" : "" }}>{{ trans('messages.form_6_11') }}</option>
								<option value="Form 12-17" {{ $preTestObj->form == "Form 12-17" ? "selected" : "" }}>{{ trans('messages.form_12_17') }}</option>
							</select>
							@if ($errors->has('form'))
			                  	<span class="m-form__help">{{ $errors->first('form') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.agency_name') }}:</label>
							<select {{ $disabled }} class="form-control m-input" id="agency_name" name="agency_name">
								<option value="">{{ trans('messages.select_agency') }}</option>
								<option value="ABAAD" {{ $preTestObj->agency_name == "ABAAD" ? "selected" : "" }}>ABAAD</option>
								<option value="AMEL" {{ $preTestObj->agency_name == "AMEL" ? "selected" : "" }}>AMEL</option>
								<option value="AND" {{ $preTestObj->agency_name == "AND" ? "selected" : "" }}>AND</option>
								<option value="ARC" {{ $preTestObj->agency_name == "ARC" ? "selected" : "" }}>ARC</option>
								<option value="ASMAE" {{ $preTestObj->agency_name == "ASMAE" ? "selected" : "" }}>ASMAE</option>
								<option value="CARE International" {{ $preTestObj->agency_name == "CARE International" ? "selected" : "" }}>CARE International</option>
								<option value="Caritas Lebanon" {{ $preTestObj->agency_name == "Caritas Lebanon" ? "selected" : "" }}>Caritas Lebanon</option>
								<option value="CONECRN" {{ $preTestObj->agency_name == "CONECRN" ? "selected" : "" }}>CONECRN</option>
								<option value="Dorcas" {{ $preTestObj->agency_name == "Dorcas" ? "selected" : "" }}>Dorcas</option>
								<option value="Danish Refugee Council" {{ $preTestObj->agency_name == "Danish Refugee Council" ? "selected" : "" }}>Danish Refugee Council</option>
								<option value="Himaya" {{ $preTestObj->agency_name == "Himaya" ? "selected" : "" }}>Himaya</option>
								<option value="ICRC" {{ $preTestObj->agency_name == "ICRC" ? "selected" : "" }}>ICRC</option>
								<option value="Intersos" {{ $preTestObj->agency_name == "Intersos" ? "selected" : "" }}>Intersos</option>
								<option value="IOCC" {{ $preTestObj->agency_name == "IOCC" ? "selected" : "" }}>IOCC</option>
								<option value="IRC" {{ $preTestObj->agency_name == "IRC" ? "selected" : "" }}>IRC</option>
								<option value="KAFA" {{ $preTestObj->agency_name == "KAFA" ? "selected" : "" }}>KAFA</option>
								<option value="Makhzoumi Foundation" {{ $preTestObj->agency_name == "Makhzoumi Foundation" ? "selected" : "" }}>Makhzoumi Foundation</option>
								<option value="Mercy Corps" {{ $preTestObj->agency_name == "Mercy Corps" ? "selected" : "" }}>Mercy Corps</option>
								<option value="Mouvement Social" {{ $preTestObj->agency_name == "Mouvement Social" ? "selected" : "" }}>Mouvement Social</option>
								<option value="MSF" {{ $preTestObj->agency_name == "MSF" ? "selected" : "" }}>MSF</option>
								<option value="Nabad" {{ $preTestObj->agency_name == "Nabad" ? "selected" : "" }}>Nabad</option>
								<option value="NRC" {{ $preTestObj->agency_name == "NRC" ? "selected" : "" }}>NRC</option>
								<option value="RAHMA" {{ $preTestObj->agency_name == "RAHMA" ? "selected" : "" }}>RAHMA</option>
								<option value="RESTART" {{ $preTestObj->agency_name == "RESTART" ? "selected" : "" }}>RESTART</option>
								<option value="Renee Mouawad Foundation" {{ $preTestObj->agency_name == "Renee Mouawad Foundation" ? "selected" : "" }}>Renee Mouawad Foundation</option>
								<option value="RtP" {{ $preTestObj->agency_name == "RtP" ? "selected" : "" }}>RtP</option>
								<option value="Sanabel Al Janoub" {{ $preTestObj->agency_name == "Sanabel Al Janoub" ? "selected" : "" }}>Sanabel Al Janoub</option>
								<option value="SAWA" {{ $preTestObj->agency_name == "SAWA" ? "selected" : "" }}>SAWA</option>
								<option value="SCI" {{ $preTestObj->agency_name == "SCI" ? "selected" : "" }}>SCI</option>
								<option value="SIF" {{ $preTestObj->agency_name == "SIF" ? "selected" : "" }}>SIF</option>
								<option value="TDH-Italy" {{ $preTestObj->agency_name == "TDH-Italy" ? "selected" : "" }}>TDH-Italy</option>
								<option value="TDH-Lausanne" {{ $preTestObj->agency_name == "TDH-Lausanne" ? "selected" : "" }}>TDH-Lausanne</option>
								<option value="WCH" {{ $preTestObj->agency_name == "WCH" ? "selected" : "" }}>WCH</option>
								<option value="WVI" {{ $preTestObj->agency_name == "WVI" ? "selected" : "" }}>WVI</option>
								<option value="YNCA" {{ $preTestObj->agency_name == "YNCA" ? "selected" : "" }}>YNCA</option>
								<option value="MAP-UK" {{ $preTestObj->agency_name == "MAP-UK" ? "selected" : "" }}>MAP-UK</option>
								<option value="Other" {{ $preTestObj->agency_name == "Other" ? "selected" : "" }}>Other</option>
							</select>
							@if ($errors->has('agency_name'))
			                  	<span class="m-form__help">{{ $errors->first('agency_name') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>{{ trans('messages.category') }}:</label>
							<select {{ $disabled }} class="form-control m-input" id="category" name="category">
								<option value="">{{ trans('messages.select_category') }}</option>
								<option value="Child Labour Activity" {{ $preTestObj->category == "Child Labour Activity" ? "selected" : "" }}>{{ trans('messages.child_labour_activity') }}</option>
								<option value="Child Mariage Activity" {{ $preTestObj->category == "Child Mariage Activity" ? "selected" : "" }}>{{ trans('messages.child_mariage_activity') }}</option>
								<option value="Violent Discipline  Activity" {{ $preTestObj->category == "Violent Discipline  Activity" ? "selected" : "" }}>{{ trans('messages.violent_discipline_activity') }}</option>
								<option value="Other" {{ $preTestObj->agency_name == "Other" ? "selected" : "" }}>{{ trans('messages.other') }}</option>
							</select>
							@if ($errors->has('category'))
			                  	<span class="m-form__help">{{ $errors->first('category') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.donor_name') }}:</label>
							<select {{ $disabled }} class="form-control m-input" id="donor_name" name="donor_name">
								<option value="">{{ trans('messages.select_donor_name') }}</option>
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
						<div class="col-lg-6">
							<label>{{ trans('messages.interview_date') }}:</label>
							<input type="text" {{ $readonly }} name="interview_date" value="{{ $preTestObj->interview_date }}" placeholder="{{ trans('messages.interview_date') }}" id="interview_date" class="form-control m-input">
							@if ($errors->has('interview_date'))
			                  	<span class="m-form__help">{{ $errors->first('interview_date') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.interviewrs_name') }}:</label>
							<input type="text" {{ $readonly }} name="interviewers_name" value="{{ $preTestObj->interviewers_name }}" placeholder="{{ trans('messages.interviewrs_name') }}" id="interviewers_name" class="form-control m-input">
							@if ($errors->has('interview_date'))
			                  	<span class="m-form__help">{{ $errors->first('interview_date') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>{{ trans('messages.code') }}:</label>
							<input type="text" name="code" value="{{ $preTestObj->code }}" placeholder="{{ trans('messages.code') }}" id="code" class="form-control m-input" readonly="">
							@if ($errors->has('code'))
			                  	<span class="m-form__help">{{ $errors->first('code') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.age') }}:</label>
							<input type="text" {{ $readonly }} name="age" value="{{ $preTestObj->age }}"  placeholder="{{ trans('messages.age') }}" id="age" class="form-control m-input">
							@if ($errors->has('age'))
			                  	<span class="m-form__help">{{ $errors->first('age') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>{{ trans('messages.gender') }}:</label>
							<select {{ $disabled }} class="form-control m-input" id="gender" name="gender">
								<option value="">{{ trans('messages.select_gender') }}</option>
								<option value="male" {{ $preTestObj->gender == "male" ? "selected" : "" }}>{{ trans('messages.male') }}</option>
								<option value="female" {{ $preTestObj->gender == "female" ? "selected" : "" }}>{{ trans('messages.female') }}</option>
							</select>
							@if ($errors->has('gender'))
			                  	<span class="m-form__help">{{ $errors->first('gender') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-4">
							<label>{{ trans('messages.nationality') }}:</label>
							<select {{ $disabled }} class="form-control m-input" id="nationality" name="nationality">
								<option value="">{{ trans('messages.select_nationality') }}</option>
								<option value="Lebanese" {{ $preTestObj->nationality == "Lebanese" ? "selected" : "" }}>{{ trans('messages.lebanese') }}</option>
								<option value="Syrian" {{ $preTestObj->nationality == "Syrian" ? "selected" : "" }}>{{ trans('messages.syrian') }}</option>
								<option value="Palestinian" {{ $preTestObj->nationality == "Palestinian" ? "selected" : "" }}>{{ trans('messages.palestinian') }}</option>
								<option value="Other Nationality" {{ $preTestObj->nationality == "Other Nationality" ? "selected" : "" }}>{{ trans('messages.other_nationality') }}</option>
							</select>
							@if ($errors->has('nationality'))
			                  	<span class="m-form__help">{{ $errors->first('nationality') }}</span>
			              	@endif
						</div>
						@if($type == "post_test")
						<div class="col-lg-4">
							<label>{{ trans('messages.total_number_of_hours_in_your_program') }}:</label>
							<input type="number" min="0" name="total_number_of_hours_in_your_program" value="{{ $preTestObj->total_number_of_hours_in_your_program }}"  placeholder="{{ trans('messages.total_number_of_hours_in_your_program') }}" id="total_number_of_hours_in_your_program" class="form-control m-input" >
							@if ($errors->has('total_number_of_hours_in_your_program'))
			                  	<span class="m-form__help">{{ $errors->first('total_number_of_hours_in_your_program') }}</span>
			              	@endif
						</div>
						<div class="col-lg-4">
							<label>{{ trans('messages.number_of_hours_that_the_child_attended') }}:</label>
							<input type="number" min="0" name="number_of_hours_that_the_child_attended" value="{{ $preTestObj->number_of_hours_that_the_child_attended }}"  placeholder="{{ trans('messages.number_of_hours_that_the_child_attended') }}" id="number_of_hours_that_the_child_attended" class="form-control m-input" >
							@if ($errors->has('number_of_hours_that_the_child_attended'))
			                  	<span class="m-form__help">{{ $errors->first('number_of_hours_that_the_child_attended') }}</span>
			              	@endif
						</div>
						@endif
					</div>
					@if($type == "post_test")
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.dropout_reason') }}:</label>
							<select class="form-control m-input" id="dropout_reason" name="dropout_reason" >
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
						<div class="col-lg-6" id="justify_the_dropout_reason_div" style="display: {{ $preTestObj->dropout_reason != "Did Not Drop Out" ? "block" : "none" }};">
							<label>{{ trans('messages.justify_the_dropout_reason') }}:</label>
							<input type="text" min="0" name="justify_the_dropout_reason" value="{{ $preTestObj->justify_the_dropout_reason }}"  placeholder="{{ trans('messages.justify_the_dropout_reason') }}" id="justify_the_dropout_reason" class="form-control m-input" >
							@if ($errors->has('justify_the_dropout_reason'))
			                  	<span class="m-form__help">{{ $errors->first('justify_the_dropout_reason') }}</span>
			              	@endif
						</div>
					</div>
					@endif
					<div id="location_div" style="display: {{ $preTestObj->dropout_reason == "Did Not Drop Out" || $preTestObj->dropout_reason == "" ? "block" : "none" }};">
						<div class="form-group m-form__group row">
							<div class="col-lg-4">
								<label>{{ trans('messages.gouvarnate') }}:</label>
								<select {{ $disabled }} class="form-control m-input" id="gouvarnate" name="gouvarnate">
									<option value="">{{ trans('messages.select_gouvarnate') }}</option>
									@foreach($gouvernates as $gov)
										<option value="{{ $gov->id }}" {{ $preTestObj->gouvarnate == $gov->id ? 'selected':'' }}>{{ app()->getLocale() == "ar" ? $gov->arabic != "" ? ucfirst($gov->arabic) : ucfirst($gov->name) : ucfirst($gov->name) }}</option>
									@endforeach
								</select>
								@if ($errors->has('gouvarnate'))
				                  	<span class="m-form__help">{{ $errors->first('gouvarnate') }}</span>
				              	@endif
							</div>
							<div class="col-lg-4">
								<label>{{ trans('messages.caza') }}:</label>
								<select {{ $disabled }} class="form-control m-input" id="caza" name="caza">
									<option value="">{{ trans('messages.select_caza') }}</option>
								</select>
								@if ($errors->has('caza'))
				                  	<span class="m-form__help">{{ $errors->first('caza') }}</span>
				              	@endif
							</div>
							<div class="col-lg-4">
								<label>{{ trans('messages.area') }}:</label>
								<select {{ $disabled }} class="form-control m-input" id="area" name="area">
									<option value="">{{ trans('messages.select_area') }}</option>
								</select>
								@if ($errors->has('area'))
				                  	<span class="m-form__help">{{ $errors->first('area') }}</span>
				              	@endif
							</div>
						</div>
						<div class="form-group m-form__group row">
							<div class="col-lg-6">
								<label>{{ trans('messages.gateway_type') }}:</label>
								<select {{ $disabled }} class="form-control m-input" id="gateway_type" name="gateway_type">
									<option value="">{{ trans('messages.select_gateway_type') }}</option>
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
							<div class="col-lg-6">
								<label>{{ trans('messages.p_code') }}:</label>
								<input type="text" {{ $readonly }} name="p_code" placeholder="{{ trans('messages.p_code') }}" id="p_code" value="{{ $preTestObj->p_code }}" class="form-control m-input">
								@if ($errors->has('p_code'))
				                  	<span class="m-form__help">{{ $errors->first('p_code') }}</span>
				              	@endif
							</div>
						</div>
						<div class="form-group m-form__group row">
							<div class="col-lg-6">
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>{{ trans('messages.latitude') }}:</label>
										<input type="text" {{ $readonly }} name="latitude" placeholder="{{ trans('messages.latitude') }}" id="latitude" value="{{ $preTestObj->latitude }}" class="form-control m-input">
										@if ($errors->has('latitude'))
						                  	<span class="m-form__help">{{ $errors->first('latitude') }}</span>
						              	@endif
									</div>
									<div class="col-lg-12">
										<label>{{ trans('messages.longitude') }}:</label>
										<input type="text" {{ $readonly }} name="longitude" placeholder="{{ trans('messages.longitude') }}" id="longitude" value="{{ $preTestObj->longitude }}" class="form-control m-input">
										@if ($errors->has('longitude'))
						                  	<span class="m-form__help">{{ $errors->first('longitude') }}</span>
						              	@endif
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>{{ trans('messages.altitude') }}:</label>
										<input type="number" {{ $readonly }} name="altitude" placeholder="{{ trans('messages.altitude') }}" id="altitude" value="{{ $preTestObj->altitude }}" class="form-control m-input">
										@if ($errors->has('altitude'))
						                  	<span class="m-form__help">{{ $errors->first('altitude') }}</span>
						              	@endif
									</div>
									<div class="col-lg-12">
										<label>{{ trans('messages.accuracy') }}:</label>
										<input type="number" {{ $readonly }} name="accuracy" placeholder="{{ trans('messages.accuracy') }}" id="accuracy" value="{{ $preTestObj->accuracy }}" class="form-control m-input">
										@if ($errors->has('accuracy'))
						                  	<span class="m-form__help">{{ $errors->first('accuracy') }}</span>
						              	@endif
									</div>
								</div>
							</div>
							<div class="col-lg-6"></div>
						</div>
						<div class="form-group m-form__group row">
							<div class="col-lg-6">
								<label>{{ trans('messages.may_i_start_now') }}:</label>
								<select  class="form-control m-input" id="may_i_start_now" name="may_i_start_now">
									<option value="">{{ trans('messages.not_selected') }}</option>
									<option value="yes" {{ $preTestObj->may_i_start_now == "yes" ? "selected" : "" }}>{{ trans('messages.yes_permission') }}</option>
									<option value="no" {{ $preTestObj->may_i_start_now == "no" ? "selected" : "" }}>{{ trans('messages.no_permission') }}</option>
								</select>
								@if ($errors->has('may_i_start_now'))
				                  	<span class="m-form__help">{{ $errors->first('may_i_start_now') }}</span>
				              	@endif
							</div>
							<div class="col-lg-6">
								<label>{{ trans('messages.comment') }}:</label>
								<textarea name="comment" placeholder="{{ trans('messages.comment') }}" id="comment" class="form-control m-input"></textarea>
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
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.considerate_of_other_peoples_feelings') }}:</label>
							<select class="form-control m-input" id="considerate_of_other_peoples_feelings" name="considerate_of_other_peoples_feelings">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.restless_overactive_cannot_stay_still_for_long') }}:</label>
							<select class="form-control m-input" id="restless_overactive_cannot_stay_still_for_long" name="restless_overactive_cannot_stay_still_for_long">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.often_complains_of_headaches_stomach_aches_or_sickness') }}:</label>
							<select class="form-control m-input" id="often_complains_of_headaches_stomach_aches_or_sickness" name="often_complains_of_headaches_stomach_aches_or_sickness">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.shares_readily_with_other_children_for_example_toys') }}:</label>
							<select class="form-control m-input" id="shares_readily_with_other_children_for_example_toys" name="shares_readily_with_other_children_for_example_toys">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.often_loses_temper') }}:</label>
							<select class="form-control m-input" id="often_loses_temper" name="often_loses_temper">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.rather_solitary_prefers_to_play_alone') }}:</label>
							<select class="form-control m-input" id="rather_solitary_prefers_to_play_alone" name="rather_solitary_prefers_to_play_alone">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.generally_well_behaved_usually_does_what_adults_request') }}:</label>
							<select class="form-control m-input" id="generally_well_behaved_usually_does_what_adults_request" name="generally_well_behaved_usually_does_what_adults_request">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.many_worries_or_often_seems_worried') }}:</label>
							<select class="form-control m-input" id="many_worries_or_often_seems_worried" name="many_worries_or_often_seems_worried">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.helpful_if_someone_is_hurt_upset_or_feeling_ill') }}:</label>
							<select class="form-control m-input" id="helpful_if_someone_is_hurt_upset_or_feeling_ill" name="helpful_if_someone_is_hurt_upset_or_feeling_ill">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.constantly_fidgeting_or_squirming') }}:</label>
							<select class="form-control m-input" id="constantly_fidgeting_or_squirming" name="constantly_fidgeting_or_squirming">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.has_at_least_one_good_friend') }}:</label>
							<select class="form-control m-input" id="has_at_least_one_good_friend" name="has_at_least_one_good_friend">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.often_fights_with_other_hildren_or_bullies_them') }}:</label>
							<select class="form-control m-input" id="often_fights_with_other_hildren_or_bullies_them" name="often_fights_with_other_hildren_or_bullies_them">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.often_unhappy_depressed_or_tearful') }}:</label>
							<select class="form-control m-input" id="often_unhappy_depressed_or_tearful" name="often_unhappy_depressed_or_tearful">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.generally_liked_by_other_children') }}:</label>
							<select class="form-control m-input" id="generally_liked_by_other_children" name="generally_liked_by_other_children">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.easily_distracted_concentration_wanders') }}:</label>
							<select class="form-control m-input" id="easily_distracted_concentration_wanders" name="easily_distracted_concentration_wanders">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.nervous_or_clingy_in_new_situations_easily_loses_confidence') }}:</label>
							<select class="form-control m-input" id="nervous_or_clingy_in_new_situations_easily_loses_confidence" name="nervous_or_clingy_in_new_situations_easily_loses_confidence">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.kind_to_younger_children') }}:</label>
							<select class="form-control m-input" id="kind_to_younger_children" name="kind_to_younger_children">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.often_lies_or_cheats') }}:</label>
							<select class="form-control m-input" id="often_lies_or_cheats" name="often_lies_or_cheats">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.picked_on_or_bullied_by_other_children') }}:</label>
							<select class="form-control m-input" id="picked_on_or_bullied_by_other_children" name="picked_on_or_bullied_by_other_children">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.often_offers_to_help_others') }}:</label>
							<select class="form-control m-input" id="often_offers_to_help_others" name="often_offers_to_help_others">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.thinks_things_out_before_acting') }}:</label>
							<select class="form-control m-input" id="thinks_things_out_before_acting" name="thinks_things_out_before_acting">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.steals_from_home_school_or_elsewhere') }}:</label>
							<select class="form-control m-input" id="steals_from_home_school_or_elsewhere" name="steals_from_home_school_or_elsewhere">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.gets_along_better_with_adults_than_with_other_children') }}:</label>
							<select class="form-control m-input" id="gets_along_better_with_adults_than_with_other_children" name="gets_along_better_with_adults_than_with_other_children">
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
						<div class="col-lg-6">
							<label>{{ trans('messages.many_fears_easily_scared') }}:</label>
							<select class="form-control m-input" id="many_fears_easily_scared" name="many_fears_easily_scared">
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
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>{{ trans('messages.good_attention_span_sees_chores_or_homework_through_to_the_end') }}:</label>
							<select class="form-control m-input" id="good_attention_span_sees_chores_or_homework_through_to_the_end" name="good_attention_span_sees_chores_or_homework_through_to_the_end">
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
						@if($type == "post_test")
						@php
							$multiselect = explode(",", $preTestObj->do_the_child_receive_any_other_child_protection_services);
						@endphp
						<div class="col-lg-6">
							<label >{{ trans('messages.do_the_child_receive_any_other_child_protection_services') }}:</label>
							<select class="form-control m-input" id="do_the_child_receive_any_other_child_protection_services" name="do_the_child_receive_any_other_child_protection_services[]" multiple="multiple" >
								<option value="">{{ trans('messages.not_selected') }}</option>
								<option value="Case management" {{ in_array("Case management", $multiselect) ? 'selected' : "" }}>{{ trans('messages.case_management') }}</option>
								<option value="Community based Child protection activities" {{ in_array("Community based Child protection activities", $multiselect) ? 'selected' : "" }}>{{ trans('messages.community_based_child_protection_activities') }}</option>
								<option value="Formal Education" {{ in_array("Formal Education", $multiselect) ? 'selected' : "" }}>{{ trans('messages.formal_education') }}</option>
								<option value="Non-formal education (VET programs…)" {{ in_array("Non-formal education (VET programs,…)", $multiselect) ? 'selected' : "" }}>{{ trans('messages.non_formal_education') }}</option>
								<option value="No"{{ in_array("No", $multiselect) ? 'selected' : "" }}>{{ trans('messages.no') }}</option>
							</select>
							@if ($errors->has('do_the_child_receive_any_other_child_protection_services'))
			                  	<span class="m-form__help">{{ $errors->first('do_the_child_receive_any_other_child_protection_services') }}</span>
			              	@endif
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="m-portlet">
				<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions--solid">
						<div class="row">
							<div class="col-lg-10"></div>
							<div class="col-lg-2">
								@if((empty($preTestObj->pre_test_date) && $type == "pre_test") || (empty($preTestObj->post_test_date) && $type == "post_test"))
									<button type="submit" name="submit" value="save" class="btn btn-info">Save</button>
								@endif
								<button type="submit" name="submit" value="submit" class="btn btn-info">Submit</button>
								<button type="reset" class="btn btn-secondary">Reset</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		<!--end::Portlet-->
		</form>
	</div>
</div>
@endsection

@section('js')
<script src="{{ url('/public') }}/assets/vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="{{ url('/public') }}/assets/vendors/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
<script src="{{ url('/public') }}/assets/vendors/select2/dist/js/select2.full.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function(){
   		var app_locale = "{{ app()->getLocale() }}";
   		$('#interview_date').datetimepicker({
            todayHighlight: true,
            autoclose: true,
            format: 'yyyy-mm-dd hh:ii'
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