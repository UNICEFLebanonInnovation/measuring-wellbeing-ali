@extends('admin.layout.app')



@section('title',"Dashboard")



@section('breadcrumb')

	<a href="{{ url('/') }}">Dashboard</a>

@endsection

@section('css')

	<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

	<link href="{{ url('/public') }}/assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />

@endsection





@section('content')

<!--begin:: Widgets/Stats-->

@include('admin.layout.flash')

{{-- <div class="m-portlet  m-portlet--unair">

	<div class="m-portlet__body  m-portlet__body--no-padding">

		<div class="row m-row--no-padding m-row--col-separator-xl">

			<div class="col-md-12 col-lg-6 col-xl-3">



				<!--begin::Total Profit-->

				<div class="m-widget24">

					<div class="m-widget24__item">

						<h4 class="m-widget24__title">

							Total Profit

						</h4><br>

						<span class="m-widget24__desc">

							All Customs Value

						</span>

						<span class="m-widget24__stats m--font-brand">

							$18M

						</span>

						<div class="m--space-10"></div>

						<div class="progress m-progress--sm">

							<div class="progress-bar m--bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

						</div>

						<span class="m-widget24__change">

							Change

						</span>

						<span class="m-widget24__number">

							78%

						</span>

					</div>

				</div>



				<!--end::Total Profit-->

			</div>

			<div class="col-md-12 col-lg-6 col-xl-3">



				<!--begin::New Feedbacks-->

				<div class="m-widget24">

					<div class="m-widget24__item">

						<h4 class="m-widget24__title">

							New Feedbacks

						</h4><br>

						<span class="m-widget24__desc">

							Customer Review

						</span>

						<span class="m-widget24__stats m--font-info">

							1349

						</span>

						<div class="m--space-10"></div>

						<div class="progress m-progress--sm">

							<div class="progress-bar m--bg-info" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

						</div>

						<span class="m-widget24__change">

							Change

						</span>

						<span class="m-widget24__number">

							84%

						</span>

					</div>

				</div>



				<!--end::New Feedbacks-->

			</div>

			<div class="col-md-12 col-lg-6 col-xl-3">



				<!--begin::New Orders-->

				<div class="m-widget24">

					<div class="m-widget24__item">

						<h4 class="m-widget24__title">

							New Orders

						</h4><br>

						<span class="m-widget24__desc">

							Fresh Order Amount

						</span>

						<span class="m-widget24__stats m--font-danger">

							567

						</span>

						<div class="m--space-10"></div>

						<div class="progress m-progress--sm">

							<div class="progress-bar m--bg-danger" role="progressbar" style="width: 69%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

						</div>

						<span class="m-widget24__change">

							Change

						</span>

						<span class="m-widget24__number">

							69%

						</span>

					</div>

				</div>



				<!--end::New Orders-->

			</div>

			<div class="col-md-12 col-lg-6 col-xl-3">



				<!--begin::New Users-->

				<div class="m-widget24">

					<div class="m-widget24__item">

						<h4 class="m-widget24__title">

							New Users

						</h4><br>

						<span class="m-widget24__desc">

							Joined New User

						</span>

						<span class="m-widget24__stats m--font-success">

							276

						</span>

						<div class="m--space-10"></div>

						<div class="progress m-progress--sm">

							<div class="progress-bar m--bg-success" role="progressbar" style="width: 90%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

						</div>

						<span class="m-widget24__change">

							Change

						</span>

						<span class="m-widget24__number">

							90%

						</span>

					</div>

				</div>



				<!--end::New Users-->

			</div>

		</div>

	</div>

</div> --}}



<!--end:: Widgets/Stats-->



@hasanyrole("admin|partner")

<div class="row">

	<div class="col-xl-12">

		<div class="m-portlet m-portlet--full-height  m-portlet--unair">

			<div class="m-portlet__head">

				<div class="m-portlet__head-caption">

					<div class="m-portlet__head-title">

						<h3 class="m-portlet__head-text">

							Application

						</h3>

					</div>

				</div>

				<div class="m-portlet__head-tools">

						<input type="text" class="form-control text-filter m-input" id="year" name="year" value="{{ Session::has('year') && !empty(Session::get('year')) ? Session::get('year') : date('Y') }}" placeholder="Year">

					</ul>

				</div>

			</div>

			<div class="m-portlet__body">

				<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">

					<thead>

						<tr>

							@hasrole('admin')

							<th>Partner</th>

							@endhasrole

							@hasrole('partner')

							<th>Collector</th>

							@endhasrole

							<th>Pre Test Pending</th>

							<th>Pre Test Completed</th>

							<th>Post Test Pending</th>

							<th>Done</th>
							<th>NA</th>
							<th>Pre No Permission</th>
							<th>Post No Permission</th>

							<th>Dropout</th>
							@hasrole('admin')

							<th>Remaining</th>

							@endhasrole

							@hasrole('partner')

							<th>Total/Partner</th>

							@endhasrole

							<th>Total</th>

						</tr>

					</thead>

				</table>

			</div>

		</div>

	</div>

</div>

@endhasanyrole



@endsection





@section('js')

	<script src="{{ url('/public') }}/assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

	<script src="{{ url('/public') }}/assets/app/js/dashboard.js" type="text/javascript"></script>

	<script src="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

	@hasanyrole("admin|partner")

		<script>

			$(function() {

				getPartner();

				$('#year').datepicker({

		            todayHighlight: true,

		            autoclose: true,

		            viewMode: "years",

    				minViewMode: "years",

		            format: 'yyyy',

		            defaultDate: new Date(year)

		        });



		        $('#year').change(function(){

		        	window.location.href = "{{ url('save-filter') }}"+"/"+$(this).val();

		        })

			});

		</script>

	@endhasanyrole

	<script>



		function getPartner(){

		    $('#m_table_1').DataTable({

		        processing: true,

		        serverSide: true,

		        ordering:true,

		        destroy: true,

		        ajax: {

		        	url: '{!! route('loadDashboard') !!}',

		        	method: 'post',

		        	data: {

				        "_token": "{{ csrf_token() }}"

			        }

		        },

		        columns: [

		            { data: 'name', name: 'name' },
		            { data: 'pre_test_pending', name: 'pre_test_pending' ,sortable : false},
		            { data: 'pending', name: 'pending' ,sortable : false},
		            { data: 'in_prgress', name: 'in_prgress' ,sortable : false},
		            { data: 'completed', name: 'completed' ,sortable : false},
		            { data: 'na', name: 'na' ,sortable : false},
		            { data: 'pre_np', name: 'pre_np' ,sortable : false},
		            { data: 'post_np', name: 'post_np' ,sortable : false},
		            { data: 'dropout', name: 'dropout' ,sortable : false},
		            { data: 'remaining', name: 'remaining' ,sortable : false},
		            { data: 'total', name: 'total' ,sortable : false},

		        ]

		    });

		}

	</script>

@endsection