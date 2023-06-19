@extends('admin.layout.app')



@section('title',"Change Decrease")



@section('breadcrumb')

<a href="{{ url('/application-list') }}">Change Decrease</a>

@endsection



@section('css')

<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

<style type="text/css">

	.btn.btn-primary.open_reason_popup,

	.btn.btn-primary.open_reason_popup:hover,

	.btn.btn-primary.open_reason_popup:focus,

	.btn.btn-primary.reset-action,

	.btn.btn-primary.reset-action:hover,

	.btn.btn-primary.reset-action:focus {

	    padding: 0;

	    background-color: transparent !important;

	    color: #0472ca !important;

	    border: 0px;

	    margin: 0px 3px;

	    text-decoration: underline !important;

	    font-size: 11px;

	    font-weight: 500;

	}

	i.fas.fa-check-circle {

		color: #000;

	    font-size: 12px;

	    display: inline-block;

	    margin: 0px 3px;

	}

</style>

@endsection



@section('content')

@include('admin.layout.flash')

<div class="m-portlet m-portlet--mobile">

	<div class="m-portlet__head">

		<div class="m-portlet__head-caption">

			<div class="m-portlet__head-title">

				<h3 class="m-portlet__head-text">

					Change Decrease

				</h3>

			</div>

		</div>

		@hasanyrole("collector|admin|partner")

		<div class="m-portlet__head-tools">

			<ul class="m-portlet__nav">



			</ul>

		</div>

		@endhasanyrole

	</div>

	<div class="m-portlet__body">

		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">



		@php

		$partner1 = "";

		if(isset($_GET['partner']) && !empty($_GET['partner'])){

		$partner1 = $_GET['partner'];

	}

	$status1 = "";

	if(isset($_GET['status']) && !empty($_GET['status'])){

	$status1 = $_GET['status'];

}

@endphp





<!--begin: Datatable -->

<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">

	<thead>

		<tr>

			<th><input type="text" class="form-control text-filter m-input" id="code" name="code" placeholder="Code"></th>

			<th>

				<select class="form-control select-filter m-input" id="age" name="age">

					<option value="">Select Age Group</option>

					<option value="Form 6-11">6-11</option>

					<option value="Form 12-17">12-17</option>

				</select>

			</th>

			<th>

				<select class="form-control select-filter m-input" id="pre_test_date" name="pre_test_date">

					<option value="">Select Pre Test Date</option>

					@for($m=1; $m<=12; ++$m)

					<option value="{{date('m', mktime(0, 0, 0, $m, 1))}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>

					@endfor

				</select>

			</th>

			<th>

				<select class="form-control select-filter m-input" id="post_test_date" name="post_test_date">

					<option value="">Select Post Test Date</option>

					@for($m=1; $m<=12; ++$m)

					<option value="{{date('m', mktime(0, 0, 0, $m, 1))}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>

					@endfor

				</select>

			</th>

			<th></th>

			<th></th>

			<th>

				<select name="partner" id="gouv" class="form-control select-filter m-input">

					<option value="">{{ trans('messages.select_gouvarnate') }}</option>

					@foreach($governate as $gov)

					<option value="{{ $gov->id }}">{{ ucfirst($gov->name) }}</option>

					@endforeach

				</select>

			</th>

			<th>

				<select name="partner" id="caza" class="form-control select-filter m-input">

					<option value="">Select Caza</option>

					@foreach($caza as $caz)

					<option value="{{ $caz->id }}">{{ ucfirst($caz->name) }}</option>

					@endforeach

				</select>

			</th>

			<th>

				@hasrole('admin')

				<select name="partner" id="partner" class="form-control select-filter m-input">

					<option value="">Select Partner</option>

					@foreach($partners as $partner)

					<option value="{{ $partner->user_id }}" {{ $partner1 == $partner->user_id ? "selected" : "" }}>{{ ucfirst($partner->name) }}</option>

					@endforeach

				</select>

				@endhasrole

			</th>

			<th>

				@hasanyrole('admin|partner')

				<select name="collector" id="collector" class="form-control select-filter m-input">

					<option value="">Select collector</option>

					@foreach($collectors as $col)

					<option value="{{ $col->user_id }}">{{ ucfirst($col->firstname) }} {{ ucfirst($col->lastname) }}</option>

					@endforeach

				</select>

				@endhasanyrole

			</th>



			<th></th>

		</tr>

		<tr>

			<th>Code</th>

			<th>Category</th>

			<th>Pre-Test Date</th>

			<th>Post-Test Date</th>

			<th>Pre Test Score</th>

			<th>Post Test Score</th>

			<th>Govermont</th>

			<th>Caza</th>

			<th>Partner</th>

			<th>Collector Name</th>

			<th>Action</th>

		</tr>

	</thead>

</table>

</div>

</div>





<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true">×</span>

				</button>

			</div>

			<div class="modal-body">



				<form action="javascript:;"  id="reason_form" name="reason_form" method="post">

					@csrf

					<input type="hidden" name="application_id" id="application_id">

					<span>
						<b>Decrease Reason</b> (Please select maximum two reasons)
					</span><br>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Change in the family personnel status (Death, Divorce, .)" name="reason_option[]">{{ trans('messages.family_personal_status') }}
									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Change in the family economic status" name="reason_option[]">{{ trans('messages.family_economic_status') }}
									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Child faced with Bullying" name="reason_option[]">{{ trans('messages.child_faced_bulying') }}
									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Family violence and neglect from parents" name="reason_option[]">{{ trans('messages.family_violence') }}
									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="No obvious or concrete reasons reported" name="reason_option[]">{{ trans('messages.concreate_reasons_reported') }}
									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
									<input type="checkbox" value="Others" name="reason_option[]">{{ trans('messages.others') }}
									<span></span>
								</label>
							</div>
						</div>
						<!-- <select class="form-control select-filter m-input" id="reason_option" name="reason_option[]" multiple="">
							<option value="Change in the family personnel status (Death, Divorce, .)">{{trans('messages.family_personal_status')}}</option>
							<option value="Change in the family economic status">{{trans('messages.family_economic_status')}}</option>
							<option value="Child faced with Bullying">{{trans('messages.child_faced_bulying')}}</option>
							<option value="Family violence and neglect from parents">{{trans('messages.family_violence')}}</option>
							<option value="No obvious or concrete reasons reported">{{trans('messages.concreate_reasons_reported')}}</option>
							<option value="Others">{{trans('messages.others')}}</option>

						</select> -->

					</div>

					<div class="form-group">

						<textarea class="form-control" rows="5" id="reason_details" name="reason_details" placeholder="More Details"></textarea>

					</div>

					<div class="form-group text-right">

						<button type="button" class="btn btn-default reset_button">Reset</button>

						<button type="submit" class="btn btn-default submit_button">Submit</button>

					</div>

				</form>



			</div>

      <!-- <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary">Save changes</button>

    </div> -->

</div>

</div>

</div>





<div class="modal fade" id="basicModal1" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel1">  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true">×</span>

				</button>

			</div>

			<div class="modal-body">



				<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text" id="rea_option1">
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body" id="rea_desc1">
					</div>
				</div>


			</div>



</div>

</div>

</div>



@endsection

@section('js')

<script src="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

<script>

	$(function() {

		datatables();

		$('.text-filter').keyup(function(){

			datatables();

			$(this).focus();

		})

		$('.select-filter').change(function(){

			datatables();

			$(this).focus();

		})

		$(document).on('click', '.open_reason_popup', function (e) {


			$(document).find('input[name="reason_option[]"]').removeAttr('disabled');
			document.getElementById("reason_form").reset();

			var application_id = $(this).attr('data-id');

			var application_code = $(this).attr('data-code');

			var application_option = $(this).attr('data-dropdown');

			var res = application_option.split(" | ");
			for (var i = res.length - 1; i >= 0; i--) {
				$(document).find('input[value="'+res[i]+'"]').prop("checked", true);
			}
			if(res.length > 1){
				$(document).find('input[name="reason_option[]"]:unchecked').attr('disabled','disabled');
			}
			var application_reason_details = $(this).attr('data-details');

			$('#application_id').val(application_id);

			$('#myModalLabel').text('Change Decrease :  ' + application_code);

			$('#reason_option').val(res);

			$('#reason_details').val(application_reason_details);

			$('#basicModal').modal('show');

		});





			$(document).on('click', '.open_reason_view', function (e) {

			var application_id = $(this).attr('data-id');

			var application_code = $(this).attr('data-code');

			var application_option = $(this).attr('data-dropdown');

			var application_reason_details = $(this).attr('data-details');



			$('#myModalLabel1').text('Change Decrease :  ' + application_code);

			$('#rea_option1').text(application_option);

			$('#rea_desc1').text(application_reason_details);

			$('#basicModal1').modal('show');

		});



			$('input[name="reason_option[]"]').click(function(){
				var total =$(document).find('input[name="reason_option[]"]:checked').length;
	            if(total > 2){
		            $(this). prop("checked", false);
		            $(document).find('input[name="reason_option[]"]:unchecked').attr('disabled','disabled');
	            }else if(total < 2){
		            $(document).find('input[name="reason_option[]"]:unchecked').removeAttr('disabled');
	            }else if(total == 2){
		            $(document).find('input[name="reason_option[]"]:unchecked').attr('disabled','disabled');

	            }
	        });





		$("form[name='reason_form']").validate({

			rules: {

				'reason_option[]': "required",

				reason_details: "required",

			},

			messages: {

				        // reason_option: "",

				        // reason_details: "",



				    },

				    submitHandler: function(form) {

				    	$.ajax({

				    		type: 'POST',

				    		url: "{{Route('reason-from')}}",

				    		data: {

				    			_token: '{!! csrf_token() !!}',

				    			application_id: $('#application_id').val(),

				    			reason_option: $('input[name="reason_option[]"]:checked').serialize(),

				    			reason_details: $('#reason_details').val(),

				    		},

				    		success: function(data) {

				    			alert('Change Decrease Application  Successfully');

				    			$('#basicModal').modal('hide');

				    			datatables();

				    		}

				    	});

				    	form.submit();

				    }

				});



		$(document).on('click', '.reset_button', function (e) {

			$.ajax({

				type: 'POST',

				url: "{{Route('reason-from')}}",

				data: {

					_token: '{!! csrf_token() !!}',

					application_id: $('#application_id').val(),

					reason_option: '',

					reason_details: '',

				},

				success: function(data) {



					alert('Change Decrease Application  Reset  Successfully');

					$('#basicModal').modal('hide');

					datatables();

				}

			});

		});

	});



	function datatables(){

		$('#m_table_1').DataTable({

			processing: true,

			serverSide: true,

			ordering:true,

			destroy: true,

			searching:false,

			 columnDefs: [

		            { width: 70, targets: 10 }

		        ],

			ajax: {

				url: '{!! route('loadChangeDecrease') !!}',

				method: 'post',

				data: {

					"_token": $('#token').val(),

					"code": $('#code').val(),

					"age": $('#age').val(),

					"pre_test_date": $('#pre_test_date').val(),

					"post_test_date": $('#post_test_date').val(),

					"partner": $('#partner').val(),

					"collector": $('#collector').val(),

					"gouv": $('#gouv').val(),

					"caza": $('#caza').val(),

				}

			},

			columns: [

			{ data: 'code', name: 'code' },

			{ data: 'age_name', name: 'age_name' },

			{ data: 'pre_test_date', name: 'pre_test_date' },

			{ data: 'post_test_date', name: 'post_test_date' },

			{ data: 'pre_test_score', name: 'pre_test_score' },

			{ data: 'post_test_score', name: 'post_test_score' },

			{ data: 'gover_nate_name', name: 'gover_nate_name' },

			{ data: 'caza_name', name: 'caza_name' },

			{ data: 'partner_name', name: 'partner_name' },

			{ data: 'collector_name', name: 'collector_name' },

			{ data: 'action', name: 'action' },

			]

		});

	}


</script>

@endsection