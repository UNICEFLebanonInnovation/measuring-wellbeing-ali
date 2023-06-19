<?php $__env->startSection('title',"SDQ Analysis Data"); ?>

<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(url('/status-list')); ?>">SDQ Analysis Data</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
<?php echo $__env->make('admin.layout.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

		<?php if(Auth::user()->roles[0]->id == 2): ?>

		<li class="">
			<span class="graph_filter">Partner</span>
			<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
				<option value="">Select Partner</option>
				<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
		</li>
		<?php else: ?>
		<li class="">
			<span class="graph_filter">Partner</span>
			<select class="form-control m-input partner_filter" id="partner_filter" name="partner_filter">
				<option value="">Select Partner</option>
				<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($pat->id); ?>" ><?php echo e($pat->firstname); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
		</li>

		<?php endif; ?>

		<li class="">
			<span class="graph_filter"><?php echo e(trans('messages.gouvarnate')); ?></span>
			<select class="form-control m-input governorate_filter" id="governorate_filter" name="governorate_filter">
				<option value=""><?php echo e(trans('messages.select_gouvarnate')); ?></option>
				<?php $__currentLoopData = $gouvernates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($gov->id); ?>" ><?php echo e(app()->getLocale() == "ar" ? $gov->arabic != "" ? ucfirst($gov->arabic) : ucfirst($gov->name) : ucfirst($gov->name)); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
				<?php if(count($data) > 0): ?>
				<?php for($i =0; $i < count($data); $i++): ?>
				<tr>
					<td><?php echo e($data[$i]['hours']); ?></td>
					<td><?php echo e(number_format($data[$i]['attended'],2)); ?></td>
					<td><?php echo e($data[$i]['children']); ?></td>
					<td><?php echo e($data[$i]['increase']); ?></td>
					<td><?php echo e(number_format($data[$i]['welbeing'],2)); ?> %</td>
				</tr>
				<?php endfor; ?>
				<?php endif; ?>
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
				<?php if(count($govArray) > 0): ?>
				<?php for($i =0; $i < count($govArray); $i++): ?>
				<tr>
					<td><?php echo e($govArray[$i]['gov']); ?></td>
					<td><?php echo e(number_format($govArray[$i]['attended'],2)); ?></td>
					<td><?php echo e($govArray[$i]['children']); ?></td>
					<td><?php echo e($govArray[$i]['increase']); ?></td>
					<td><?php echo e(number_format($govArray[$i]['welbeing'],2)); ?> %</td>
				</tr>
				<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
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
				url: '<?php echo route('load-sdq-analysis-data'); ?>',
				method: 'post',
				data: {
					"_token": "<?php echo e(csrf_token()); ?>"
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

			$.post('<?php echo e(route('load-sdq-analysis-ajax')); ?>',{_token:"<?php echo e(csrf_token()); ?>",gender:gender,form_filter:form_filter,nationlity_filter:nationlity_filter,governorate_filter:governorate_filter,partner_filter:partner_filter},function(response){
				console.log(response.success);

				if(response.success == true)
				{

						$('.ajax').html(response.html);
				}

			});


		}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/reports/analysis_data.blade.php ENDPATH**/ ?>