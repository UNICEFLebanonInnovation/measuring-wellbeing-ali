@extends('admin.layout.app')

@section('title',"Normal Comparison")

@section('breadcrumb')
	<a href="{{ url('/analytics') }}">Normal Comparison</a>
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
					Normal Comparison
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
			<!-- 	<li class="m-portlet__nav-item">
					<select class="form-control m-input category_filter" id="category" name="category">
						<option value="">Select Category</option>
						<option value="Child Labour Activity">Child Labour Activity</option>
						<option value="Child Mariage Activity">Child Mariage Activity</option>
						<option value="Violent Discipline  Activity">Violent Discipline  Activity</option>
						<option value="Other">Other</option>
					</select>
				</li> -->

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
			</ul>
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


		var gender = '';
		var form_filter = '';
		var category_filter = '';
		var nationlity_filter = '';
		var governorate_filter = '';
		var partner_filter = '';

		load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter);

		$('body').on('change', '.gender_filter', function() {
			gender = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter);
		});

		$('body').on('change', '.form_filter', function() {
			form_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter);
		});

		$('body').on('change', '.category_filter', function() {
			category_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter);
		});

		$('body').on('change', '.nationlity_filter', function() {
			nationlity_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter);
		});

		$('body').on('change', '.governorate_filter', function() {
			governorate_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter);
		});


		$('body').on('change', '.partner_filter', function() {
			partner_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter);
		});


	// Themes begin
	am4core.useTheme(am4themes_animated);



function load_partner_dropout_chart(gender,form_filter,category_filter,nationlity_filter,governorate_filter,partner_filter)
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
		$.post('{{route('load-normal-conparison')}}',{_token:"{{ csrf_token() }}",gender:gender,form_filter:form_filter,category_filter:category_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter},function(response){

			res = JSON.parse(response);
			chart.data = res;

			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "reason";
			categoryAxis.title.text = "Reasons";
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
	}


	});

function arrangeColumns() {

    let series = chart.series.getIndex(0);

    let w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        let x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        let x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
        let delta = ((x1 - x0) / chart.series.length) * w;
        if (am4core.isNumber(delta)) {
            let middle = chart.series.length / 2;

            let newIndex = 0;
            chart.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart.series.indexOf(series);
                }
            })
            let visibleCount = newIndex;
            let newMiddle = visibleCount / 2;

            chart.series.each(function(series) {
                let trueIndex = chart.series.indexOf(series);
                let newIndex = series.dummyData;

                let dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
            })
        }
    }
}

	function initChart(){
	}
</script>
@endsection