@extends('admin.layout.app')

@section('title',"Analysys Change")

@section('breadcrumb')
<a href="{{ url('/analytics') }}">Analysis Change</a>
@endsection

@section('css')
<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					% of increase in wellbeing
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Gender</span>
					<select class="form-control m-input gender_filter" id="gender" name="gender">
						<option value="">Select Gender</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</li>
				@if(Auth::user()->roles[0]->id == 2)
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Partner</span>
					<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
						<option value="">Select Partner</option>
						@foreach($partner as $pat)
						<option value="{{ $pat->id }}" >{{ $pat->firstname }}</option>
						@endforeach
					</select>
				</li>
				@else
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Partner</span>
					<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
						<option value="">Select Partner</option>
						@foreach($partner as $pat)
						<option value="{{ $pat->id }}" >{{ $pat->firstname }}</option>
						@endforeach
					</select>
				</li>
				@endif

				<li class="m-portlet__nav-item">
					<span class="graph_filter">{{ trans('messages.gouvarnate') }}</span>
					<select class="form-control m-input governorate_filter" id="governorate_filter" name="governorate_filter">
						<option value="">{{ trans('messages.select_gouvarnate') }}</option>
						@foreach($gouvernates as $gov)
						<option value="{{ $gov->id }}" >{{ app()->getLocale() == "ar" ? $gov->arabic != "" ? ucfirst($gov->arabic) : ucfirst($gov->name) : ucfirst($gov->name) }}</option>
						@endforeach
					</select>
				</li>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Nationality</span>
					<select class="form-control m-input nationlity_filter" id="nationlity_filter" name="nationlity_filter">
						<option value="">Select Nationality</option>
						<option value="Lebanese">Lebanese</option>
						<option value="Syrian">Syrian</option>
						<option value="Palestinian">Palestinian</option>
						<option value="Other Nationality">Other Nationality</option>
					</select>
				</li>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Age Group</span>
					<select class="form-control m-input form_filter" id="age" name="age">
						<option value="">Select Age Group</option>
						<option value="Form 6-11">6-11</option>
						<option value="Form 12-17">12-17</option>
					</select>
				</li>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Service</span>
					<select class="form-control m-input service_filter" id="service_filter" name="service_filter">
						<option value="">Select Service</option>
						<option value="Case management">{{ trans('messages.case_management') }}</option>
						<option value="Community based Child protection activities">{{ trans('messages.community_based_child_protection_activities') }}</option>
						<option value="Formal Education">{{ trans('messages.formal_education') }}</option>
						<option value="Non-formal education (VET programs…)">{{ trans('messages.non_formal_education') }}</option>
						<option value="No">{{ trans('messages.no') }}</option>
					</select>
				</li>
			</ul>
		</div>
	</div>
	<div class="m-portlet__body">
		<div id="m_amcharts_1" style="height: 500px;"></div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Male before and after 6-11
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_2" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Male before and after 12-17
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_3" style="height: 500px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Female before and after 6-11
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_4" style="height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Female before and after 12-17
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="m_amcharts_5" style="height: 500px;"></div>
			</div>
		</div>
	</div>
</div>





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
		var category_filter = '';
		var nationlity_filter = '';
		var governorate_filter = '';
		var partner_filter = '';
		var service_filter = '';

		load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);

		$('body').on('change', '.gender_filter', function() {
			gender = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);
		});

		$('body').on('change', '.form_filter', function() {
			form_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);
		});

		$('body').on('change', '.category_filter', function() {
			category_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);
		});

		$('body').on('change', '.nationlity_filter', function() {
			nationlity_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);
		});

		$('body').on('change', '.governorate_filter', function() {
			governorate_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);
		});


		$('body').on('change', '.partner_filter', function() {
			partner_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);
		});
		$('body').on('change', '.service_filter', function() {
			service_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter);
		});



	// Themes begin
	am4core.useTheme(am4themes_animated);
	// var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
	var chart2 = am4core.create("m_amcharts_2", am4charts.XYChart);
	chart2.exporting.menu = new am4core.ExportMenu();

		chart2.colors.step = 2;
		chart2.legend = new am4charts.Legend()
		chart2.legend.position = 'top'
		chart2.legend.paddingBottom = 20
		chart2.legend.labels.template.maxWidth = 95

	var chart3 = am4core.create("m_amcharts_3", am4charts.XYChart);
	chart3.exporting.menu = new am4core.ExportMenu();
		chart3.colors.step = 2;
		chart3.legend = new am4charts.Legend()
		chart3.legend.position = 'top'
		chart3.legend.paddingBottom = 20
		chart3.legend.labels.template.maxWidth = 95
	var chart4 = am4core.create("m_amcharts_4", am4charts.XYChart);
	chart4.exporting.menu = new am4core.ExportMenu();

		chart4.colors.step = 2;
		chart4.legend = new am4charts.Legend()
		chart4.legend.position = 'top'
		chart4.legend.paddingBottom = 20
		chart4.legend.labels.template.maxWidth = 95

	var chart5 = am4core.create("m_amcharts_5", am4charts.XYChart);
	chart5.exporting.menu = new am4core.ExportMenu();
		chart5.colors.step = 2;
		chart5.legend = new am4charts.Legend()
		chart5.legend.position = 'top'
		chart5.legend.paddingBottom = 20
		chart5.legend.labels.template.maxWidth = 95

	function load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter,service_filter)
	{

		var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
		chart.exporting.menu = new am4core.ExportMenu();

		chart.colors.step = 2;
		chart.legend = new am4charts.Legend()
		chart.legend.position = 'top'
		chart.legend.paddingBottom = 20
		chart.legend.labels.template.maxWidth = 95
		chart.data = [];

		// Add data
		$.post('{{route('load-analysis-change')}}',{_token:"{{ csrf_token() }}",gender:gender,form_filter:form_filter,category_filter:category_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter,service_filter:service_filter},function(response){

			res = JSON.parse(response);
			chart.data = res;

			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "change";
			//categoryAxis.title.text = "Change";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				if (target.dataItem && target.dataItem.index & 2 == 2) {
					return dy + 25;
				}
				return dy;
			});

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.title.text = "Avg. Score";


			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "pre_test";
			series.dataFields.categoryX = "change";
			series.name = "Pre Test";
			series.clustered = true;
			series.columns.template.tooltipText = "Pre Test: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.9;

			var series2 = chart.series.push(new am4charts.ColumnSeries());
			series2.dataFields.valueY = "post_test";
			series2.dataFields.categoryX = "change";
			series2.name = "Post Test";
			series2.clustered = true;
			series2.columns.template.tooltipText = "Post Test: [bold]{valueY}[/]";

		});
	}

		$.post('{{route('load-analysis-change1')}}',{_token:"{{ csrf_token() }}","age":"Form 6-11","gender":"male"},function(response){

			res = JSON.parse(response);
			chart2.data = res;

			var categoryAxis = chart2.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "change";
			//categoryAxis.title.text = "Change";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				if (target.dataItem && target.dataItem.index & 2 == 2) {
					return dy + 25;
				}
				return dy;
			});

			var valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.title.text = "Avg. Score";


			var series = chart2.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "pre_test";
			series.dataFields.categoryX = "change";
			series.name = "Pre Test";
			series.clustered = true;
			series.columns.template.tooltipText = "Pre Test: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.9;

			var series2 = chart2.series.push(new am4charts.ColumnSeries());
			series2.dataFields.valueY = "post_test";
			series2.dataFields.categoryX = "change";
			series2.name = "Post Test";
			series2.clustered = true;
			series2.columns.template.tooltipText = "Post Test: [bold]{valueY}[/]";

		});

		$.post('{{route('load-analysis-change1')}}',{_token:"{{ csrf_token() }}","age":"Form 12-17","gender":"male"},function(response){

			res = JSON.parse(response);
			chart3.data = res;

			var categoryAxis = chart3.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "change";
			//categoryAxis.title.text = "Change";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				if (target.dataItem && target.dataItem.index & 2 == 2) {
					return dy + 25;
				}
				return dy;
			});

			var valueAxis = chart3.yAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.title.text = "Avg. Score";


			var series = chart3.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "pre_test";
			series.dataFields.categoryX = "change";
			series.name = "Pre Test";
			series.clustered = true;
			series.columns.template.tooltipText = "Pre Test: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.9;

			var series2 = chart3.series.push(new am4charts.ColumnSeries());
			series2.dataFields.valueY = "post_test";
			series2.dataFields.categoryX = "change";
			series2.name = "Post Test";
			series2.clustered = true;
			series2.columns.template.tooltipText = "Post Test: [bold]{valueY}[/]";

		});

		$.post('{{route('load-analysis-change1')}}',{_token:"{{ csrf_token() }}","age":"Form 6-11","gender":"female"},function(response){

			res = JSON.parse(response);
			chart4.data = res;

			var categoryAxis = chart4.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "change";
			//categoryAxis.title.text = "Change";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				if (target.dataItem && target.dataItem.index & 2 == 2) {
					return dy + 25;
				}
				return dy;
			});

			var valueAxis = chart4.yAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.title.text = "Avg. Score";


			var series = chart4.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "pre_test";
			series.dataFields.categoryX = "change";
			series.name = "Pre Test";
			series.clustered = true;
			series.columns.template.tooltipText = "Pre Test: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.9;

			var series2 = chart4.series.push(new am4charts.ColumnSeries());
			series2.dataFields.valueY = "post_test";
			series2.dataFields.categoryX = "change";
			series2.name = "Post Test";
			series2.clustered = true;
			series2.columns.template.tooltipText = "Post Test: [bold]{valueY}[/]";

		});

		$.post('{{route('load-analysis-change1')}}',{_token:"{{ csrf_token() }}","age":"Form 12-17","gender":"female"},function(response){

			res = JSON.parse(response);
			chart5.data = res;

			var categoryAxis = chart5.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "change";
			//categoryAxis.title.text = "Change";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
				if (target.dataItem && target.dataItem.index & 2 == 2) {
					return dy + 25;
				}
				return dy;
			});

			var valueAxis = chart5.yAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.title.text = "Avg. Score";


			var series = chart5.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "pre_test";
			series.dataFields.categoryX = "change";
			series.name = "Pre Test";
			series.clustered = true;
			series.columns.template.tooltipText = "Pre Test: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.9;

			var series2 = chart5.series.push(new am4charts.ColumnSeries());
			series2.dataFields.valueY = "post_test";
			series2.dataFields.categoryX = "change";
			series2.name = "Post Test";
			series2.clustered = true;
			series2.columns.template.tooltipText = "Post Test: [bold]{valueY}[/]";

		});

	});
</script>
@endsection