@extends('admin.layout.app')



@section('title',"Applications")



@section('breadcrumb')

	<a href="{{ url('/application-list') }}">Applications</a>

@endsection



@section('css')

	<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

@endsection



@section('content')

	@include('admin.layout.flash')

	<div class="m-portlet m-portlet--mobile">

		<div class="m-portlet__head">

			<div class="m-portlet__head-caption">

				<div class="m-portlet__head-title">

					<h3 class="m-portlet__head-text">

						Applications

					</h3>

				</div>

			</div>

			@hasanyrole("collector|admin|partner")

			<div class="m-portlet__head-tools">

				<ul class="m-portlet__nav">

					@hasanyrole("admin|partner")

					<li class="m-portlet__nav-item">

						<a href="{{ url('export-applications') }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">

							<span>

								<span>Export</span>

							</span>

						</a>

					</li>

					@endhasanyrole

					@hasrole("collector")

					@php

					if(Auth::user()->is_readonly != 1){ @endphp

					<li class="m-portlet__nav-item">

						<a href="{{ url('create-application') }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">

							<span>

								<i class="la la-plus"></i>

								<span>Add Application</span>

							</span>

						</a>

					</li>

					@php } @endphp

					@endhasrole

				</ul>

			</div>

			@endhasanyrole

		</div>

		<div class="m-portlet__body">

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

						<th><input type="text" class="form-control text-filter m-input" id="pre_test_date" name="pre_test_date" placeholder="Pre Test Date"></th>

						<th><input type="text" class="form-control text-filter m-input" id="post_test_date" name="post_test_date" placeholder="Post Test Date"></th>

						<th></th>

						<th></th>

						<th>
							<!-- <select class="form-control m-input select-filter" id="change" name="change">
								<option value="">Select Change</option>
								<option value="Increase">Increase</option>
								<option value="Decrease">Decrease</option>
								<option value="Same">Same</option>
							</select> -->
						</th>
						<th>
							<select class="form-control m-input select-filter" id="governorate_filter" name="governorate_filter">
							<option value="">{{ trans('messages.select_gouvarnate') }}</option>
							@foreach($gouvernates as $gov)
								<option value="{{ $gov->id }}" >{{ app()->getLocale() == "ar" ? $gov->arabic != "" ? ucfirst($gov->arabic) : ucfirst($gov->name) : ucfirst($gov->name) }}</option>
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

						<th>

							@hasanyrole('admin|partner')

							<select name="status" id="status" class="form-control select-filter m-input">

								<option value="">Select status</option>

								@foreach($status as $st)

									<option value="{{ $st->id }}" {{ $status1 == $st->id ? "selected" : "" }}>{{ ucfirst($st->name) }}</option>

								@endforeach

							</select>

							@endhasanyrole

						</th>

						<th></th>

					</tr>

					<tr>

						<th>Code</th>

						<th>Pre-Test Date</th>

						<th>Post-Test Date</th>

						<th>Pre Test Score</th>

						<th>Post Test Score</th>

						<th>Change</th>

						<th>Govornorate</th>
						<th>Partner</th>

						<th>Agent Name</th>

						<th>Status</th>

						<th>Action</th>

					</tr>

				</thead>

			</table>

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

		});



		function datatables(){

		    $('#m_table_1').DataTable({

		        processing: true,

		        serverSide: true,

		        ordering:true,

		        destroy: true,

		        searching:false,

		        ajax: {

		        	url: '{!! route('loadApplication') !!}',

		        	method: 'post',

		        	data: {

				        "_token": "{{ csrf_token() }}",

				        "code": $('#code').val(),

				        "pre_test_date": $('#pre_test_date').val(),

				        "post_test_date": $('#post_test_date').val(),

				        "partner": $('#partner').val(),

				        "collector": $('#collector').val(),

				        "status": $('#status').val(),
				        "change": $('#change').val(),
				        "governorate_filter": $('#governorate_filter').val(),

			        }

		        },

		        columns: [

		            { data: 'code', name: 'code' },

		            { data: 'pre_test_date', name: 'pre_test_date' },

		            { data: 'post_test_date', name: 'post_test_date' },

		            { data: 'pre_test_score', name: 'score',sortable : false, },

		            { data: 'post_test_score', name: 'score',sortable : false, },

		            { data: 'change', name: 'change',sortable : false, },

		            { data: 'gouvernate', name: 'gouvernate' },
		            { data: 'partner', name: 'partner' },

		            { data: 'collector', name: 'collector' },

		            { data: 'status_name', name: 'status_name' },

		            { data: 'action', name: 'action' ,sortable : false,},

		        ]

		    });

		}

	</script>

@endsection