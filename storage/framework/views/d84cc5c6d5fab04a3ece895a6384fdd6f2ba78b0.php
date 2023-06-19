<?php $__env->startSection('title',"Govornorate Analysys"); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/analytics')); ?>">Govornorate Analysis</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
	<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.m-portlet__nav {
			padding: 0;
		}
		.m-portlet__nav:after, .m-portlet__nav:before {
		    display: block;
		    content: '';
		    clear: both;
		}
		.m-portlet__nav li {
		    list-style-type: none;
		    width: 33.33%;
		    float: left;
		}
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
		@media (max-width: 575px) {
			.m-portlet__nav li {
				width:100%;
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Completed SDQ test per governorate
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Gender</span>
					<select class="form-control m-input gender_com_gov" id="gender_com_gov" name="gender_com_gov">
						<option value="">Select Gender</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</li>
				<?php if(Auth::user()->roles[0]->id == 2): ?>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Partner</span>
					<select class="form-control m-input gender_com_partner" id="gender_com_partner" name="gender_com_partner">
						<option value="">Select Partner</option>
						<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</li>
				<?php else: ?>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Partner</span>
					<select class="form-control m-input gender_com_partner" id="gender_com_partner" name="gender_com_partner">
						<option value="">Select Partner</option>
						<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</li>
				<?php endif; ?>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Nationality</span>
					<select class="form-control m-input nationality_com_gov" id="nationality_com_gov" name="nationality_com_gov">
						<option value="">Select Nationality</option>
						<option value="Lebanese">Lebanese</option>
						<option value="Syrian">Syrian</option>
						<option value="Palestinian">Palestinian</option>
						<option value="Other Nationality">Other Nationality</option>
					</select>
				</li>
				<li class="m-portlet__nav-item">
					<span class="graph_filter">Age Group</span>
					<select class="form-control m-input age_com_gov" id="age_com_gov" name="age_com_gov">
						<option value="">Select Age Group</option>
						<option value="Form 6-11">6-11</option>
						<option value="Form 12-17">12-17</option>
					</select>
				</li>
			</ul>
		</div>
	</div>
	<div class="m-portlet__body portlet-group-dropdown">
		<div id="m_amcharts_1" style="height: 500px;"></div>
	</div>
</div>

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Mean descrease in overall stress per governorate
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body portlet-group-dropdown">
			<ul class="d-flex flex-wrap p-0">
				<li class="">
					<select class="form-control m-input gender_mean_des_gov" id="gender_mean_des_gov" name="gender_mean_des_gov">
						<option value="">Select Gender</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</li>
				<?php if(Auth::user()->roles[0]->id == 2): ?>
				<li class="">
					<select class="form-control m-input partner_mean_des_gov" id="partner_mean_des_gov" name="partner_mean_des_gov">
						<option value="">Select Partner</option>
						<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</li>
				<?php else: ?>
				<li class="">
					<select class="form-control m-input partner_mean_des_gov" id="partner_mean_des_gov" name="partner_mean_des_gov">
						<option value="">Select Partner</option>
						<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</li>
				<?php endif; ?>
				<li class="">
					<select class="form-control m-input nationality_mean_des_gov" id="nationality_mean_des_gov" name="nationality_mean_des_gov">
						<option value="">Select Nationality</option>
						<option value="Lebanese">Lebanese</option>
						<option value="Syrian">Syrian</option>
						<option value="Palestinian">Palestinian</option>
						<option value="Other Nationality">Other Nationality</option>
					</select>
				</li>
				<li class="">
					<select class="form-control m-input age_mean_des_gov" id="age_mean_des_gov" name="age_mean_des_gov">
						<option value="">Select Age Group</option>
						<option value="Form 6-11">6-11</option>
						<option value="Form 12-17">12-17</option>
					</select>
				</li>
			</ul>


		<div id="m_amcharts_2" style="height: 500px;"></div>
	</div>
</div>
<!-- <div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Mean descrease in overall stress per governorate AGE 6-11
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<div id="m_amcharts_3" style="height: 500px;"></div>
	</div>
</div>
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Mean descrease in overall stress per governorate AGE 12-17
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<div id="m_amcharts_4" style="height: 500px;"></div>
	</div>
</div> -->

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

	// Themes begin
	am4core.useTheme(am4themes_animated);
		// var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
		// var chart1 = am4core.create("m_amcharts_2", am4charts.XYChart);
		// var chart2 = am4core.create("m_amcharts_3", am4charts.XYChart);
		// var chart3 = am4core.create("m_amcharts_4", am4charts.XYChart);



		var gender_com_gov = '';
		var nationality_com_gov = '';
		var age_com_gov = '';
		var gender_com_partner = '';

		load_completed_test_gov_chart(gender_com_gov,nationality_com_gov,age_com_gov,gender_com_partner);


		$('body').on('change', '.gender_com_gov', function() {
			gender_com_gov = $(this).val();
			load_completed_test_gov_chart(gender_com_gov,nationality_com_gov,age_com_gov,gender_com_partner);
		});

		$('body').on('change', '.nationality_com_gov', function() {
			nationality_com_gov = $(this).val();
			load_completed_test_gov_chart(gender_com_gov,nationality_com_gov,age_com_gov,gender_com_partner);
		});

		$('body').on('change', '.age_com_gov', function() {
			age_com_gov = $(this).val();
			load_completed_test_gov_chart(gender_com_gov,nationality_com_gov,age_com_gov,gender_com_partner);
		});
		$('body').on('change', '.gender_com_partner', function() {
			gender_com_partner = $(this).val();
			load_completed_test_gov_chart(gender_com_gov,nationality_com_gov,age_com_gov,gender_com_partner);
		});



		function load_completed_test_gov_chart(gender_com_gov,nationality_com_gov,age_com_gov,gender_com_partner)
		{

		var chart = am4core.create("m_amcharts_1", am4charts.XYChart);
		chart.exporting.menu = new am4core.ExportMenu();
		chart.colors.step = 2;
		chart.legend = new am4charts.Legend()
		chart.legend.position = 'top'
		chart.legend.paddingBottom = 20
		chart.legend.labels.template.maxWidth = 95
		chart.data = [];

		$.post('<?php echo e(route('load-gov-analysys')); ?>',{_token:"<?php echo e(csrf_token()); ?>",gender_com_gov:gender_com_gov,nationality_com_gov:nationality_com_gov,age_com_gov:age_com_gov,gender_com_partner:gender_com_partner},function(response){
			res = JSON.parse(response);
		 	chart.data = res;
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "gov";
			categoryAxis.title.text = "Governorate";
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
			valueAxis.title.text = "Applications";

			// Create series
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "count";
			series.dataFields.categoryX = "gov";
			series.name = "Applications";
			series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = .8;

			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;
		});
	}



		var gender_mean_des_gov = '';
		var nationality_mean_des_gov = '';
		var age_mean_des_gov = '';
		var partner_mean_des_gov = '';

		load_mean_desc_gov_chart(gender_mean_des_gov,nationality_mean_des_gov,age_mean_des_gov,partner_mean_des_gov);

		$('body').on('change', '.gender_mean_des_gov', function() {
			gender_mean_des_gov = $(this).val();
			load_mean_desc_gov_chart(gender_mean_des_gov,nationality_mean_des_gov,age_mean_des_gov,partner_mean_des_gov);
		});

		$('body').on('change', '.nationality_mean_des_gov', function() {
			nationality_mean_des_gov = $(this).val();
			load_mean_desc_gov_chart(gender_mean_des_gov,nationality_mean_des_gov,age_mean_des_gov,partner_mean_des_gov);
		});

		$('body').on('change', '.age_mean_des_gov', function() {
			age_mean_des_gov = $(this).val();
			load_mean_desc_gov_chart(gender_mean_des_gov,nationality_mean_des_gov,age_mean_des_gov,partner_mean_des_gov);
		});
		$('body').on('change', '.partner_mean_des_gov', function() {
			partner_mean_des_gov = $(this).val();
			load_mean_desc_gov_chart(gender_mean_des_gov,nationality_mean_des_gov,age_mean_des_gov,partner_mean_des_gov);
		});



		function load_mean_desc_gov_chart(gender_mean_des_gov,nationality_mean_des_gov,age_mean_des_gov,partner_mean_des_gov){
			var chart1 = am4core.create("m_amcharts_2", am4charts.XYChart);
			chart1.exporting.menu = new am4core.ExportMenu();
			chart1.colors.step = 2;
			chart1.legend = new am4charts.Legend()
			chart1.legend.position = 'top'
			chart1.legend.paddingBottom = 20
			chart1.legend.labels.template.maxWidth = 95
			chart1.data = [];

		$.post('<?php echo e(route('load-gov-analysys1')); ?>',{_token:"<?php echo e(csrf_token()); ?>",gender_mean_des_gov:gender_mean_des_gov,nationality_mean_des_gov:nationality_mean_des_gov,age_mean_des_gov:age_mean_des_gov,partner_mean_des_gov:partner_mean_des_gov},function(response){
			res = JSON.parse(response);
		 	chart1.data = res;
			var categoryAxis = chart1.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "gov";
			categoryAxis.title.text = "Governorate";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
			  if (target.dataItem && target.dataItem.index & 2 == 2) {
			    return dy + 25;
			  }
			  return dy;
			});

			var valueAxis = chart1.yAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.title.text = "Applications";

			// Create series
			var series = chart1.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "pre_test";
			series.dataFields.categoryX = "gov";
			series.name = "Pre Test";
			series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = .8;

			var series1 = chart1.series.push(new am4charts.ColumnSeries());
			series1.dataFields.valueY = "post_test";
			series1.dataFields.categoryX = "gov";
			series1.name = "Post Test";
			series1.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series1.columns.template.fillOpacity = .8;

			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;
		});
	}

		// $.post('<?php echo e(route('load-gov-analysys1')); ?>',{age:"Form 6-11",_token:"<?php echo e(csrf_token()); ?>"},function(response){
		// 	res = JSON.parse(response);
		//  	chart2.data = res;
		// 	var categoryAxis = chart2.xAxes.push(new am4charts.CategoryAxis());
		// 	categoryAxis.dataFields.category = "gov";
		// 	categoryAxis.title.text = "Governorate";
		// 	categoryAxis.renderer.grid.template.location = 0;
		// 	categoryAxis.renderer.minGridDistance = 30;

		// 	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
		// 	  if (target.dataItem && target.dataItem.index & 2 == 2) {
		// 	    return dy + 25;
		// 	  }
		// 	  return dy;
		// 	});

		// 	var valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());
		// 	valueAxis.min = 0;
		// 	valueAxis.title.text = "Applications";

		// 	// Create series
		// 	var series = chart2.series.push(new am4charts.ColumnSeries());
		// 	series.dataFields.valueY = "pre_test";
		// 	series.dataFields.categoryX = "gov";
		// 	series.name = "Pre Test";
		// 	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
		// 	series.columns.template.fillOpacity = .8;

		// 	var series1 = chart2.series.push(new am4charts.ColumnSeries());
		// 	series1.dataFields.valueY = "post_test";
		// 	series1.dataFields.categoryX = "gov";
		// 	series1.name = "Post Test";
		// 	series1.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
		// 	series1.columns.template.fillOpacity = .8;

		// 	var columnTemplate = series.columns.template;
		// 	columnTemplate.strokeWidth = 2;
		// 	columnTemplate.strokeOpacity = 1;
		// });

		// $.post('<?php echo e(route('load-gov-analysys1')); ?>',{age:"Form 12-17",_token:"<?php echo e(csrf_token()); ?>"},function(response){
		// 	res = JSON.parse(response);
		//  	chart3.data = res;
		// 	var categoryAxis = chart3.xAxes.push(new am4charts.CategoryAxis());
		// 	categoryAxis.dataFields.category = "gov";
		// 	categoryAxis.title.text = "Governorate";
		// 	categoryAxis.renderer.grid.template.location = 0;
		// 	categoryAxis.renderer.minGridDistance = 30;

		// 	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
		// 	  if (target.dataItem && target.dataItem.index & 2 == 2) {
		// 	    return dy + 25;
		// 	  }
		// 	  return dy;
		// 	});

		// 	var valueAxis = chart3.yAxes.push(new am4charts.ValueAxis());
		// 	valueAxis.min = 0;
		// 	valueAxis.title.text = "Applications";

		// 	// Create series
		// 	var series = chart3.series.push(new am4charts.ColumnSeries());
		// 	series.dataFields.valueY = "pre_test";
		// 	series.dataFields.categoryX = "gov";
		// 	series.name = "Pre Test";
		// 	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
		// 	series.columns.template.fillOpacity = .8;

		// 	var series1 = chart3.series.push(new am4charts.ColumnSeries());
		// 	series1.dataFields.valueY = "post_test";
		// 	series1.dataFields.categoryX = "gov";
		// 	series1.name = "Post Test";
		// 	series1.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
		// 	series1.columns.template.fillOpacity = .8;

		// 	var columnTemplate = series.columns.template;
		// 	columnTemplate.strokeWidth = 2;
		// 	columnTemplate.strokeOpacity = 1;
		// });

	});

	function initChart(){
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/reports/gov_analysys.blade.php ENDPATH**/ ?>