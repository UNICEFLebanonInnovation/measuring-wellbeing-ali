@extends('admin.layout.app')

@section('title',"SDQ Analysis Data")

@section('breadcrumb')
<a href="{{ url('/status-list') }}">SDQ Analysis Data</a>
@endsection

@section('css')
<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<style type="text/css">
	.portlet-group-dropdown ul {
		list-style-type: none;
	}
	.portlet-group-dropdown ul li {
		margin-right: 16px;
	}
	@media (max-width: 1199px) {
		.portlet-group-dropdown ul li {
			margin-bottom: 10px;
		}
	}
	@media (max-width: 640px) {
		.portlet-group-dropdown ul li {
			width: 48%;
			margin-right: 3px;
			margin-bottom: 3px;
		}
	}
	@media (max-width: 480px) {
		.portlet-group-dropdown ul li select {
			padding: 0.85rem 0.55rem;
    		font-size: 12px;
		}
	}
	@media (max-width: 320px) {
		.portlet-group-dropdown ul li select {
			padding: 0.85rem 0.30rem;
			font-size: 12px;
		}
	}
</style>
@include('admin.layout.flash')

	<div class="m-portlet__head-tools portlet-group-dropdown">
	<ul class="d-flex flex-wrap p-0">
		<li class="">
			<span class="graph_filter">Gender</span>
			<select class="form-control m-input gender_filter" id="gender" name="gender">
				<option value="">Select Gender</option>
				<option value="male">Male</option>
				<option value="female">Female</option>
			</select>
		</li>

		@if(Auth::user()->roles[0]->id == 2)

		<li class="">
			<span class="graph_filter">Partner</span>
			<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
				<option value="">Select Partner</option>
				@foreach($partner as $pat)
					<option value="{{ $pat->id }}" >{{ $pat->firstname }}</option>
				@endforeach
			</select>
		</li>
		@else
		<li class="">
			<span class="graph_filter">Partner</span>
			<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
				<option value="">Select Partner</option>
				@foreach($partner as $pat)
					<option value="{{ $pat->id }}" >{{ $pat->firstname }}</option>
				@endforeach
			</select>
		</li>

		@endif

		<li class="">
			<span class="graph_filter">{{ trans('messages.gouvarnate') }}</span>
			<select class="form-control m-input governorate_filter" id="governorate_filter" name="governorate_filter">
				<option value="">{{ trans('messages.select_gouvarnate') }}</option>
				@foreach($gouvernates as $gov)
					<option value="{{ $gov->id }}" >{{ app()->getLocale() == "ar" ? $gov->arabic != "" ? ucfirst($gov->arabic) : ucfirst($gov->name) : ucfirst($gov->name) }}</option>
				@endforeach
			</select>
		</li>
		<li class="">
			<span class="graph_filter">Nationality</span>
			<select class="form-control m-input nationlity_filter" id="nationlity_filter" name="nationlity_filter">
				<option value="">Select Nationality</option>
				<option value="Lebanese">Lebanese</option>
				<option value="Syrian">Syrian</option>
				<option value="Palestinian">Palestinian</option>
				<option value="Other Nationality">Other Nationality</option>
			</select>
		</li>
		 <li class="">
		 	<span class="graph_filter">Age Group</span>
			<select class="form-control m-input form_filter" id="age" name="age">
				<option value="">Select Age Group</option>
				<option value="Form 6-11">6-11</option>
				<option value="Form 12-17">12-17</option>
			</select>
		</li>
		<!-- <li class="">
			<select class="form-control m-input scale_filter" id="scale_filter" name="scale_filter">
				<option value="">Select Scale</option>
				<option value="emotional_scale">Emotional Scale</option>
				<option value="conduct_scale">Conduct Scale</option>
				<option value="hyper_activity_scale">Hyper Activity Scale</option>
				<option value="peer_problem_scale">Peer Problem Scale</option>
			</select>
		</li> -->
	</ul>
</div>

<div class='ajax'>
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					SDQ Analysis Data
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
			<thead>
				<tr>
					<th>Prog. Hrs Range</th>
					<th>Average rate of attendance %</th>
					<th>No. of children addressed</th>
					<th>Increase</th>
					<th>% children showing improvement in wellbeing</th>
				</tr>
			</thead>
			<tbody>
				@if(count($data) > 0)
				@for($i =0; $i < count($data); $i++)
				<tr>
					<td>{{ $data[$i]['hours'] }}</td>
					<td>{{ number_format($data[$i]['attended'],2) }}</td>
					<td>{{ $data[$i]['children'] }}</td>
					<td>{{ $data[$i]['increase'] }}</td>
					<td>{{ number_format($data[$i]['welbeing'],2) }} %</td>
				</tr>
				@endfor
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					SDQ Analysis Data
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">

		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
			<thead>
				<tr>
					<th>Governorate</th>
					<th>Average rate of attendance %</th>
					<th>No. of children addressed</th>
					<th>Increase</th>
					<th>% children showing improvement in wellbeing</th>
				</tr>
			</thead>
			<tbody>
				@if(count($govArray) > 0)
				@for($i =0; $i < count($govArray); $i++)
				<tr>
					<td>{{ $govArray[$i]['gov'] }}</td>
					<td>{{ number_format($govArray[$i]['attended'],2) }}</td>
					<td>{{ $govArray[$i]['children'] }}</td>
					<td>{{ $govArray[$i]['increase'] }}</td>
					<td>{{ number_format($govArray[$i]['welbeing'],2) }} %</td>
				</tr>
				@endfor
				@endif
			</tbody>
		</table>
	</div>
</div>
</div>
@endsection

@section('js')
<script src="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script>
	$(function() {
			//datatables();
		});

	function datatables(){
		$('#m_table_1').DataTable({
			processing: true,
			serverSide: true,
			searching:false,
			ordering:true,
			destroy: true,
			ajax: {
				url: '{!! route('load-sdq-analysis-data') !!}',
				method: 'post',
				data: {
					"_token": "{{ csrf_token() }}"
				}
			},
			columns: [
			{ data: 'hours', name: 'hours',sortable : false },
			{ data: 'children', name: 'children',sortable : false },
			{ data: 'increase', name: 'increase',sortable : false },
			{ data: 'welbeing', name: 'welbeing',sortable : false }
			]
		});
	}


		var gender = '';
		var form_filter = '';
		var nationlity_filter = '';
		var governorate_filter = '';
		var partner_filter = '';



		$('body').on('change', '.gender_filter', function() {
			gender = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter);
		});

		$('body').on('change', '.form_filter', function() {
			form_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter);
		});
		$('body').on('change', '.nationlity_filter', function() {
			nationlity_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter);
		});

		$('body').on('change', '.governorate_filter', function() {
			governorate_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter);
		});


		$('body').on('change', '.partner_filter', function() {
			partner_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter);
		});


		function load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter)
		{

			$.post('{{route('load-sdq-analysis-ajax')}}',{_token:"{{ csrf_token() }}",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter},function(response){
				console.log(response.success);

				if(response.success == true)
				{

						$('.ajax').html(response.html);
				}

			});


		}

</script>
@endsection