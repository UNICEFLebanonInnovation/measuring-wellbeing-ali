@extends('admin.layout.app')

@section('title',"Analytics")

@section('breadcrumb')
	<a href="{{ url('/analytics') }}">Analytics</a>
@endsection

@section('css')
	<link href="{{ url('public/') }}/assets/vendors/chartist/dist/chartist.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Analytics
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<div id="m_amcharts_13" style="height: 500px;"></div>
	</div>
</div>

@endsection

@section('js')
	<script src="{{ url('public/') }}/assets/vendors/chartist/dist/chartist.js" type="text/javascript"></script>
	<script src="{{ url('public/') }}/assets/vendors/chart.js/dist/Chart.bundle.js" type="text/javascript"></script>
	<script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
@endsection