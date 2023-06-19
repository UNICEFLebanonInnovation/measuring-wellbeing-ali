<?php $__env->startSection('title',$title." Analysys"); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/analytics')); ?>"><?php echo e($title); ?> Analysis</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
	<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					<?php echo e($title); ?> Analysis
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
				<?php if(Auth::user()->roles[0]->id == 2): ?>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Partner</span>
					<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
						<option value="">Select Partner</option>
						<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</li>
				<?php else: ?>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Partner</span>
					<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
						<option value="">Select Partner</option>
						<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</li>
				<?php endif; ?>
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

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__body">
		<div id="m_amcharts_2" style="height: 500px;"></div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
		var partner_filter = '';


		load_partner_dropout_chart(gender,form_filter,nationlity_filter,partner_filter);

		$('body').on('change', '.gender_filter', function() {
			gender = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,partner_filter);
		});
		$('body').on('change', '.form_filter', function() {
			form_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,partner_filter);
		});
		$('body').on('change', '.nationlity_filter', function() {
			nationlity_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,partner_filter);
		});
		$('body').on('change', '.partner_filter', function() {
			partner_filter = $(this).val();
			load_partner_dropout_chart(gender,form_filter,nationlity_filter,partner_filter);
		});

	// Themes begin
	am4core.useTheme(am4themes_animated);
		// var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
		// var chart1 = am4core.create("m_amcharts_2", am4charts.XYChart);


		function  load_partner_dropout_chart(gender,form_filter,nationlity_filter,partner_filter){

			var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
			chart.exporting.menu = new am4core.ExportMenu();

			chart.colors.step = 2;
			chart.legend = new am4charts.Legend()
			chart.legend.position = 'top'
			chart.legend.paddingBottom = 20
			chart.legend.labels.template.maxWidth = 95

			chart.data = [];
			var chart1 = am4core.create("m_amcharts_2", am4charts.XYChart);
			chart1.exporting.menu = new am4core.ExportMenu();

			chart1.colors.step = 2;
			chart1.legend = new am4charts.Legend()
			chart1.legend.position = 'top'
			chart1.legend.paddingBottom = 20
			chart1.legend.labels.template.maxWidth = 95
			chart1.data = [];


		// Add data
		$.post('<?php echo e(route('load-partner-analysys')); ?>',{_token:"<?php echo e(csrf_token()); ?>",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,partner_filter:partner_filter},function(response){

			res = JSON.parse(response);
			chart.data = res['chartData'];

			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "part";
			categoryAxis.title.text = "Govornorate";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 20;
			categoryAxis.renderer.cellStartLocation = 0.1;
			categoryAxis.renderer.cellEndLocation = 0.9;

			var  valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.title.text = "Applications";

			function createSeries(field, name, stacked) {
			  var series = chart.series.push(new am4charts.ColumnSeries());
			  series.dataFields.valueY = field;
			  series.dataFields.categoryX = "part";
			  series.name = name;
			  series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
			  series.stacked = stacked;
			  series.columns.template.width = am4core.percent(95);
			}
			for (var i = 0; i < res['partners'].length; i++) {
				createSeries(res['partners'][i]['name'], res['partners'][i]['name'], false);
			}

		});

		$.post('<?php echo e(route('load-partner-analysys1')); ?>',{_token:"<?php echo e(csrf_token()); ?>",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,partner_filter:partner_filter},function(response){
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
	}

	});

	function initChart(){
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/reports/partner_analysys.blade.php ENDPATH**/ ?>