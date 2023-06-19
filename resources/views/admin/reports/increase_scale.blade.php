@extends('admin.layout.app')

@section('title',"% Increase Scale")

@section('breadcrumb')
	<a href="{{ url('/analytics') }}">% Increase Scale</a>
@endsection

@section('css')
	<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<style type="text/css">
	.portlet-group-dropdown ul {
		list-style-type: none;
	}
	.portlet-group-dropdown ul li {
		margin-right: 16px;
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
<div class="row">
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Conduct Scale
						</h3>
					</div>
				</div>
			</div>

			<div class="m-portlet__body">
				<div id="m_amcharts_1" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Emotional Scale
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_2" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Hyperactivity Scale
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_3" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Peer Problem Scale
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_4" style="height: 500px;"></div>
			</div>
		</div>
	</div>
</div>

<!-- <div class="row">
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Conduct Scale 12-17
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_5" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Emotional Scale 12-17
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_6" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Hyperactivity Scale 12-17
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_7" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Peer Problem Scale 12-17
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_8" style="height: 500px;"></div>
			</div>
		</div>
	</div>
</div> -->

@endsection

@section('js')
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script type="text/javascript">
	var token = $('meta[name="csrf-token"]').attr('content');
	$(function(){
		var m_amcharts_1;
		initChart()
	})
	am4core.ready(function() {


			var gender = '';
			var form_filter = '';
			var nationlity_filter = '';
			var governorate_filter = '';
			var partner_filter = '';
			var scale_filter = '';

		load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter);

		$('body').on('change', '.gender_filter', function() {
			gender = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter);
		});
		$('body').on('change', '.form_filter', function() {
			form_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter);
		});

		$('body').on('change', '.nationlity_filter', function() {
			nationlity_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter);
		});

		$('body').on('change', '.governorate_filter', function() {
			governorate_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter);
		});


		$('body').on('change', '.partner_filter', function() {
			partner_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter);
		});

		$('body').on('change', '.scale_filter', function() {
			scale_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter);
		});




	// Themes begin
	am4core.useTheme(am4themes_animated);


		// var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
		// var chart2 = am4core.create("m_amcharts_2", am4charts.XYChart);
		// var chart3 = am4core.create("m_amcharts_3", am4charts.XYChart);
		// var chart4 = am4core.create("m_amcharts_4", am4charts.XYChart);
		// var chart5 = am4core.create("m_amcharts_5", am4charts.XYChart);
		// var chart6 = am4core.create("m_amcharts_6", am4charts.XYChart);
		// var chart7 = am4core.create("m_amcharts_7", am4charts.XYChart);
		// var chart8 = am4core.create("m_amcharts_8", am4charts.XYChart);

			function load_partner_dropout_chart(gender,form_filter,nationlity_filter,governorate_filter,partner_filter,scale_filter){

				var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
				chart.exporting.menu = new am4core.ExportMenu();
				chart.colors.step = 2;
				chart.legend = new am4charts.Legend()
				chart.legend.position = 'top'
				chart.legend.paddingBottom = 20
				chart.legend.labels.template.maxWidth = 95
				chart.data = [];


				var chart2 = am4core.create("m_amcharts_2", am4charts.XYChart);
				chart2.exporting.menu = new am4core.ExportMenu();
				chart2.colors.step = 2;
				chart2.legend = new am4charts.Legend()
				chart2.legend.position = 'top'
				chart2.legend.paddingBottom = 20
				chart2.legend.labels.template.maxWidth = 95
				chart2.data = [];

				var chart3 = am4core.create("m_amcharts_3", am4charts.XYChart);
				chart3.exporting.menu = new am4core.ExportMenu();
				chart3.colors.step = 2;
				chart3.legend = new am4charts.Legend()
				chart3.legend.position = 'top'
				chart3.legend.paddingBottom = 20
				chart3.legend.labels.template.maxWidth = 95
				chart3.data = [];

				var chart4 = am4core.create("m_amcharts_4", am4charts.XYChart);
				chart4.exporting.menu = new am4core.ExportMenu();
				chart4.colors.step = 2;
				chart4.legend = new am4charts.Legend()
				chart4.legend.position = 'top'
				chart4.legend.paddingBottom = 20
				chart4.legend.labels.template.maxWidth = 95
				chart4.data = [];
				// var chart5 = am4core.create("m_amcharts_5", am4charts.XYChart);
				// chart5.data = [];
				// var chart6 = am4core.create("m_amcharts_6", am4charts.XYChart);
				// chart6.data = [];
				// var chart7 = am4core.create("m_amcharts_7", am4charts.XYChart);
				// chart7.data = [];
				// var chart8 = am4core.create("m_amcharts_8", am4charts.XYChart);
				// chart8.data = [];

		// Add data
			$.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"conduct_scale","form":"Form 6-11",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

				res = JSON.parse(response);
				chart.data = res;

				var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "type";
				categoryAxis.title.text = "Change";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.title.marginTop = 40;

				categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				  if (target.dataItem && target.dataItem.index & 2 == 2) {
				    return dy + 25;
				  }
				  return dy;
				});

				var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
				valueAxis.min = 0;
				valueAxis.title.text = "Applications";

				// Create series
				var series = chart.series.push(new am4charts.ColumnSeries());
				series.dataFields.valueY = "count";
				series.dataFields.categoryX = "type";
				series.name = "Type";
				series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
				series.columns.template.fillOpacity = .8;

				var columnTemplate = series.columns.template;
				columnTemplate.strokeWidth = 2;
				columnTemplate.strokeOpacity = 1;

			});

			$.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"emotional_scale","form":"Form 6-11",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

				res = JSON.parse(response);
				chart2.data = res;

				var categoryAxis = chart2.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "type";
				categoryAxis.title.text = "Change";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.title.marginTop = 40;

				categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				  if (target.dataItem && target.dataItem.index & 2 == 2) {
				    return dy + 25;
				  }
				  return dy;
				});

				var valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());
				valueAxis.min = 0;
				valueAxis.title.text = "Applications";

				// Create series
				var series = chart2.series.push(new am4charts.ColumnSeries());
				series.dataFields.valueY = "count";
				series.dataFields.categoryX = "type";
				series.name = "Type";
				series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
				series.columns.template.fillOpacity = .8;

				var columnTemplate = series.columns.template;
				columnTemplate.strokeWidth = 2;
				columnTemplate.strokeOpacity = 1;

			});

			$.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"hyper_activity_scale","form":"Form 6-11",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

				res = JSON.parse(response);
				chart3.data = res;

				var categoryAxis = chart3.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "type";
				categoryAxis.title.text = "Change";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.title.marginTop = 40;

				categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				  if (target.dataItem && target.dataItem.index & 2 == 2) {
				    return dy + 25;
				  }
				  return dy;
				});

				var valueAxis = chart3.yAxes.push(new am4charts.ValueAxis());
				valueAxis.min = 0;
				valueAxis.title.text = "Applications";

				// Create series
				var series = chart3.series.push(new am4charts.ColumnSeries());
				series.dataFields.valueY = "count";
				series.dataFields.categoryX = "type";
				series.name = "Type";
				series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
				series.columns.template.fillOpacity = .8;

				var columnTemplate = series.columns.template;
				columnTemplate.strokeWidth = 2;
				columnTemplate.strokeOpacity = 1;

			});

			$.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"peer_problem_scale","form":"Form 6-11",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

				res = JSON.parse(response);
				chart4.data = res;

				var categoryAxis = chart4.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "type";
				categoryAxis.title.text = "Change";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.title.marginTop = 40;

				categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				  if (target.dataItem && target.dataItem.index & 2 == 2) {
				    return dy + 25;
				  }
				  return dy;
				});

				var valueAxis = chart4.yAxes.push(new am4charts.ValueAxis());
				valueAxis.min = 0;
				valueAxis.title.text = "Applications";

				// Create series
				var series = chart4.series.push(new am4charts.ColumnSeries());
				series.dataFields.valueY = "count";
				series.dataFields.categoryX = "type";
				series.name = "Type";
				series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
				series.columns.template.fillOpacity = .8;

				var columnTemplate = series.columns.template;
				columnTemplate.strokeWidth = 2;
				columnTemplate.strokeOpacity = 1;

			});

			// $.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"conduct_scale","form":"Form 12-17",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

			// 	res = JSON.parse(response);
			// 	chart5.data = res;

			// 	var categoryAxis = chart5.xAxes.push(new am4charts.CategoryAxis());
			// 	categoryAxis.dataFields.category = "type";
			// 	categoryAxis.title.text = "Change";
			// 	categoryAxis.renderer.grid.template.location = 0;
			// 	categoryAxis.renderer.minGridDistance = 30;

			// 	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
			// 	  if (target.dataItem && target.dataItem.index & 2 == 2) {
			// 	    return dy + 25;
			// 	  }
			// 	  return dy;
			// 	});

			// 	var valueAxis = chart5.yAxes.push(new am4charts.ValueAxis());
			// 	valueAxis.min = 0;
			// 	valueAxis.title.text = "Applications";

			// 	// Create series
			// 	var series = chart5.series.push(new am4charts.ColumnSeries());
			// 	series.dataFields.valueY = "count";
			// 	series.dataFields.categoryX = "type";
			// 	series.name = "Type";
			// 	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			// 	series.columns.template.fillOpacity = .8;

			// 	var columnTemplate = series.columns.template;
			// 	columnTemplate.strokeWidth = 2;
			// 	columnTemplate.strokeOpacity = 1;

			// });

			// $.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"emotional_scale","form":"Form 12-17",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

			// 	res = JSON.parse(response);
			// 	chart6.data = res;

			// 	var categoryAxis = chart6.xAxes.push(new am4charts.CategoryAxis());
			// 	categoryAxis.dataFields.category = "type";
			// 	categoryAxis.title.text = "Change";
			// 	categoryAxis.renderer.grid.template.location = 0;
			// 	categoryAxis.renderer.minGridDistance = 30;

			// 	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
			// 	  if (target.dataItem && target.dataItem.index & 2 == 2) {
			// 	    return dy + 25;
			// 	  }
			// 	  return dy;
			// 	});

			// 	var valueAxis = chart6.yAxes.push(new am4charts.ValueAxis());
			// 	valueAxis.min = 0;
			// 	valueAxis.title.text = "Applications";

			// 	// Create series
			// 	var series = chart6.series.push(new am4charts.ColumnSeries());
			// 	series.dataFields.valueY = "count";
			// 	series.dataFields.categoryX = "type";
			// 	series.name = "Type";
			// 	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			// 	series.columns.template.fillOpacity = .8;

			// 	var columnTemplate = series.columns.template;
			// 	columnTemplate.strokeWidth = 2;
			// 	columnTemplate.strokeOpacity = 1;

			// });

			// $.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"hyper_activity_scale","form":"Form 12-17",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

			// 	res = JSON.parse(response);
			// 	chart7.data = res;

			// 	var categoryAxis = chart7.xAxes.push(new am4charts.CategoryAxis());
			// 	categoryAxis.dataFields.category = "type";
			// 	categoryAxis.title.text = "Change";
			// 	categoryAxis.renderer.grid.template.location = 0;
			// 	categoryAxis.renderer.minGridDistance = 30;

			// 	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
			// 	  if (target.dataItem && target.dataItem.index & 2 == 2) {
			// 	    return dy + 25;
			// 	  }
			// 	  return dy;
			// 	});

			// 	var valueAxis = chart7.yAxes.push(new am4charts.ValueAxis());
			// 	valueAxis.min = 0;
			// 	valueAxis.title.text = "Applications";

			// 	// Create series
			// 	var series = chart7.series.push(new am4charts.ColumnSeries());
			// 	series.dataFields.valueY = "count";
			// 	series.dataFields.categoryX = "type";
			// 	series.name = "Type";
			// 	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			// 	series.columns.template.fillOpacity = .8;

			// 	var columnTemplate = series.columns.template;
			// 	columnTemplate.strokeWidth = 2;
			// 	columnTemplate.strokeOpacity = 1;

			// });

			// $.post('{{route('load-increase-scale')}}',{_token:"{{ csrf_token() }}","scale":"peer_problem_scale","form":"Form 12-17",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,scale_filter:scale_filter},function(response){

			// 	res = JSON.parse(response);
			// 	chart8.data = res;

			// 	var categoryAxis = chart8.xAxes.push(new am4charts.CategoryAxis());
			// 	categoryAxis.dataFields.category = "type";
			// 	categoryAxis.title.text = "Change";
			// 	categoryAxis.renderer.grid.template.location = 0;
			// 	categoryAxis.renderer.minGridDistance = 30;

			// 	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
			// 	  if (target.dataItem && target.dataItem.index & 2 == 2) {
			// 	    return dy + 25;
			// 	  }
			// 	  return dy;
			// 	});

			// 	var valueAxis = chart8.yAxes.push(new am4charts.ValueAxis());
			// 	valueAxis.min = 0;
			// 	valueAxis.title.text = "Applications";

			// 	// Create series
			// 	var series = chart8.series.push(new am4charts.ColumnSeries());
			// 	series.dataFields.valueY = "count";
			// 	series.dataFields.categoryX = "type";
			// 	series.name = "Type";
			// 	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			// 	series.columns.template.fillOpacity = .8;

			// 	var columnTemplate = series.columns.template;
			// 	columnTemplate.strokeWidth = 2;
			// 	columnTemplate.strokeOpacity = 1;

			// });
		}

	});

	function initChart(){
	}
</script>
@endsection