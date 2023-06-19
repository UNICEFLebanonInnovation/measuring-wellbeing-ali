@extends('admin.layout.app')

@section('title',$age." Comparison")

@section('breadcrumb')
	<a href="{{ url('/analytics') }}">{{ $age." Comparison" }}</a>
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
					{{ $age." Comparison" }}
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<div id="m_amcharts_1" style="height: 500px;"></div>
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

	// Themes begin
	am4core.useTheme(am4themes_animated);
		var chart = am4core.create("m_amcharts_1", am4charts.XYChart);

		// Add data
		var age = "{{ $age }}";
		$.post('{{route('load-normal-conparison')}}',{age:age,_token:"{{ csrf_token() }}"},function(response){

			res = JSON.parse(response);
			chart.data = res;

			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "reason";
			categoryAxis.title.text = "Scale";
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
			valueAxis.title.text = "Avg. Scale";

			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "pre_test";
			series.dataFields.categoryX = "reason";
			series.name = "Pre Test";
			series.clustered = true;
			series.columns.template.tooltipText = "Pre Test: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.9;
			var series3 = chart.series.push(new am4charts.ColumnSeries());
			series3.dataFields.valueY = "static";
			series3.dataFields.categoryX = "reason";
			series3.name = "Static";
			series3.clustered = true;
			series3.columns.template.tooltipText = "static: [bold]{valueY}[/]";

			var series2 = chart.series.push(new am4charts.ColumnSeries());
			series2.dataFields.valueY = "post_test";
			series2.dataFields.categoryX = "reason";
			series2.name = "Post Test";
			series2.clustered = true;
			series2.columns.template.tooltipText = "Post Test: [bold]{valueY}[/]";

		});

	});

	function initChart(){
	}
</script>
@endsection