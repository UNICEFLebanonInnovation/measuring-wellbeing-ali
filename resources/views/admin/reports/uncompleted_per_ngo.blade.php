@extends('admin.layout.app')

@section('title',"Uncompleted per ".$title)

@section('breadcrumb')
	<a href="{{ url('/analytics') }}">Uncompleted per {{ $title }}</a>
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
					Uncompleted per {{ $title }}
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
		var chart1 = am4core.create("m_amcharts_1", am4charts.XYChart);
		chart1.exporting.menu = new am4core.ExportMenu();
		chart1.colors.step = 2;
		chart1.legend = new am4charts.Legend()
		chart1.legend.position = 'top'
		chart1.legend.paddingBottom = 20
		chart1.legend.labels.template.maxWidth = 95




		// Add data
		$.post('{{route('load-uncompleted-per-ngo')}}',{_token:"{{ csrf_token() }}"},function(response){
			res = JSON.parse(response);
			chart1.data = res;
			var categoryAxis = chart1.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "partner";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
			  if (target.dataItem && target.dataItem.index & 2 == 2) {
			    return dy + 25;
			  }
			  return dy;
			});

			var valueAxis = chart1.yAxes.push(new am4charts.ValueAxis());

			// Create series
			var series = chart1.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "count";
			series.dataFields.categoryX = "partner";
			series.name = "Applications";
			series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = .8;

			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;
		});

	});

	function initChart(){
	}
</script>
@endsection