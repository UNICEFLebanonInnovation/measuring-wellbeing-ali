<?php $__env->startSection('title',"Applications"); ?>



<?php $__env->startSection('breadcrumb'); ?>

	<a href="<?php echo e(url('/application-list')); ?>">Applications</a>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('css'); ?>

	<link href="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('admin.layout.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="m-portlet m-portlet--mobile">

		<div class="m-portlet__head">

			<div class="m-portlet__head-caption">

				<div class="m-portlet__head-title">

					<h3 class="m-portlet__head-text">

						Applications

					</h3>

				</div>

			</div>

			<?php if(auth()->check() && auth()->user()->hasAnyRole("collector|admin|partner")): ?>

			<div class="m-portlet__head-tools">

				<ul class="m-portlet__nav">

					<?php if(auth()->check() && auth()->user()->hasAnyRole("admin|partner")): ?>

					<li class="m-portlet__nav-item">

						<a href="<?php echo e(url('export-applications')); ?>" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">

							<span>

								<span>Export</span>

							</span>

						</a>

					</li>

					<?php endif; ?>

					<?php if(auth()->check() && auth()->user()->hasRole("collector")): ?>

					<?php

					if(Auth::user()->is_readonly != 1){ ?>

					<li class="m-portlet__nav-item">

						<a href="<?php echo e(url('create-application')); ?>" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">

							<span>

								<i class="la la-plus"></i>

								<span>Add Application</span>

							</span>

						</a>

					</li>

					<?php } ?>

					<?php endif; ?>

				</ul>

			</div>

			<?php endif; ?>

		</div>

		<div class="m-portlet__body">

			<?php

				$partner1 = "";

				if(isset($_GET['partner']) && !empty($_GET['partner'])){

					$partner1 = $_GET['partner'];

				}

				$status1 = "";

				if(isset($_GET['status']) && !empty($_GET['status'])){

					$status1 = $_GET['status'];

				}

			?>

			<!--begin: Datatable -->

			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">

				<thead>

					<tr>

						<th><input type="text" class="form-control text-filter m-input" id="code" name="code" placeholder="Code"></th>

						<th><input type="text" class="form-control text-filter m-input" id="pre_test_date" name="pre_test_date" placeholder="Pre Test Date"></th>

						<th><input type="text" class="form-control text-filter m-input" id="post_test_date" name="post_test_date" placeholder="Post Test Date"></th>

						<th></th>

						<th></th>

						<th>
							<!-- <select class="form-control m-input select-filter" id="change" name="change">
								<option value="">Select Change</option>
								<option value="Increase">Increase</option>
								<option value="Decrease">Decrease</option>
								<option value="Same">Same</option>
							</select> -->
						</th>
						<th>
							<select class="form-control m-input select-filter" id="governorate_filter" name="governorate_filter">
							<option value=""><?php echo e(trans('messages.select_gouvarnate')); ?></option>
							<?php $__currentLoopData = $gouvernates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($gov->id); ?>" ><?php echo e(app()->getLocale() == "ar" ? $gov->arabic != "" ? ucfirst($gov->arabic) : ucfirst($gov->name) : ucfirst($gov->name)); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						</th>

						<th>

							<?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>

							<select name="partner" id="partner" class="form-control select-filter m-input">

								<option value="">Select Partner</option>

								<?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<option value="<?php echo e($partner->user_id); ?>" <?php echo e($partner1 == $partner->user_id ? "selected" : ""); ?>><?php echo e(ucfirst($partner->name)); ?></option>

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							</select>

							<?php endif; ?>

						</th>

						<th>

							<?php if(auth()->check() && auth()->user()->hasAnyRole('admin|partner')): ?>

							<select name="collector" id="collector" class="form-control select-filter m-input">

								<option value="">Select collector</option>

								<?php $__currentLoopData = $collectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<option value="<?php echo e($col->user_id); ?>"><?php echo e(ucfirst($col->firstname)); ?> <?php echo e(ucfirst($col->lastname)); ?></option>

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							</select>

							<?php endif; ?>

						</th>

						<th>

							<?php if(auth()->check() && auth()->user()->hasAnyRole('admin|partner')): ?>

							<select name="status" id="status" class="form-control select-filter m-input">

								<option value="">Select status</option>

								<?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<option value="<?php echo e($st->id); ?>" <?php echo e($status1 == $st->id ? "selected" : ""); ?>><?php echo e(ucfirst($st->name)); ?></option>

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							</select>

							<?php endif; ?>

						</th>

						<th></th>

					</tr>

					<tr>

						<th>Code</th>

						<th>Pre-Test Date</th>

						<th>Post-Test Date</th>

						<th>Pre Test Score</th>

						<th>Post Test Score</th>

						<th>Change</th>

						<th>Govornorate</th>
						<th>Partner</th>

						<th>Agent Name</th>

						<th>Status</th>

						<th>Action</th>

					</tr>

				</thead>

			</table>

		</div>

	</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

	<script src="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

	<script>

		$(function() {

			datatables();



			$('.text-filter').keyup(function(){

				datatables();

				$(this).focus();

			})



			$('.select-filter').change(function(){

				datatables();

				$(this).focus();

			})

		});



		function datatables(){

		    $('#m_table_1').DataTable({

		        processing: true,

		        serverSide: true,

		        ordering:true,

		        destroy: true,

		        searching:false,

		        ajax: {

		        	url: '<?php echo route('loadApplication'); ?>',

		        	method: 'post',

		        	data: {

				        "_token": "<?php echo e(csrf_token()); ?>",

				        "code": $('#code').val(),

				        "pre_test_date": $('#pre_test_date').val(),

				        "post_test_date": $('#post_test_date').val(),

				        "partner": $('#partner').val(),

				        "collector": $('#collector').val(),

				        "status": $('#status').val(),
				        "change": $('#change').val(),
				        "governorate_filter": $('#governorate_filter').val(),

			        }

		        },

		        columns: [

		            { data: 'code', name: 'code' },

		            { data: 'pre_test_date', name: 'pre_test_date' },

		            { data: 'post_test_date', name: 'post_test_date' },

		            { data: 'pre_test_score', name: 'score',sortable : false, },

		            { data: 'post_test_score', name: 'score',sortable : false, },

		            { data: 'change', name: 'change',sortable : false, },

		            { data: 'gouvernate', name: 'gouvernate' },
		            { data: 'partner', name: 'partner' },

		            { data: 'collector', name: 'collector' },

		            { data: 'status_name', name: 'status_name' },

		            { data: 'action', name: 'action' ,sortable : false,},

		        ]

		    });

		}

	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/application/list.blade.php ENDPATH**/ ?>