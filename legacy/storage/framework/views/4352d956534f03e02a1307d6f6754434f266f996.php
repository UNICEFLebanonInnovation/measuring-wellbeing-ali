<?php $__env->startSection('title',"Dashboard"); ?>



<?php $__env->startSection('breadcrumb'); ?>

	<a href="<?php echo e(url('/')); ?>">Dashboard</a>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

	<link href="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo e(url('/public')); ?>/assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>





<?php $__env->startSection('content'); ?>

<!--begin:: Widgets/Stats-->

<?php echo $__env->make('admin.layout.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<!--end:: Widgets/Stats-->



<?php if(auth()->check() && auth()->user()->hasAnyRole("admin|partner")): ?>

<div class="row">

	<div class="col-xl-12">

		<div class="m-portlet m-portlet--full-height  m-portlet--unair">

			<div class="m-portlet__head">

				<div class="m-portlet__head-caption">

					<div class="m-portlet__head-title">

						<h3 class="m-portlet__head-text">

							Application

						</h3>

					</div>

				</div>

				<div class="m-portlet__head-tools">

						<input type="text" class="form-control text-filter m-input" id="year" name="year" value="<?php echo e(Session::has('year') && !empty(Session::get('year')) ? Session::get('year') : date('Y')); ?>" placeholder="Year">

					</ul>

				</div>

			</div>

			<div class="m-portlet__body">

				<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">

					<thead>

						<tr>

							<?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>

							<th>Partner</th>

							<?php endif; ?>

							<?php if(auth()->check() && auth()->user()->hasRole('partner')): ?>

							<th>Collector</th>

							<?php endif; ?>

							<th>Pre Test Pending</th>

							<th>Pre Test Completed</th>

							<th>Post Test Pending</th>

							<th>Done</th>
							<th>NA</th>
							<th>Pre No Permission</th>
							<th>Post No Permission</th>

							<th>Dropout</th>
							<?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>

							<th>Remaining</th>

							<?php endif; ?>

							<?php if(auth()->check() && auth()->user()->hasRole('partner')): ?>

							<th>Total/Partner</th>

							<?php endif; ?>

							<th>Total</th>

						</tr>

					</thead>

				</table>

			</div>

		</div>

	</div>

</div>

<?php endif; ?>



<?php $__env->stopSection(); ?>





<?php $__env->startSection('js'); ?>

	<script src="<?php echo e(url('/public')); ?>/assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

	<script src="<?php echo e(url('/public')); ?>/assets/app/js/dashboard.js" type="text/javascript"></script>

	<script src="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

	<?php if(auth()->check() && auth()->user()->hasAnyRole("admin|partner")): ?>

		<script>

			$(function() {

				getPartner();

				$('#year').datepicker({

		            todayHighlight: true,

		            autoclose: true,

		            viewMode: "years",

    				minViewMode: "years",

		            format: 'yyyy',

		            defaultDate: new Date(year)

		        });



		        $('#year').change(function(){

		        	window.location.href = "<?php echo e(url('save-filter')); ?>"+"/"+$(this).val();

		        })

			});

		</script>

	<?php endif; ?>

	<script>



		function getPartner(){

		    $('#m_table_1').DataTable({

		        processing: true,

		        serverSide: true,

		        ordering:true,

		        destroy: true,

		        ajax: {

		        	url: '<?php echo route('loadDashboard'); ?>',

		        	method: 'post',

		        	data: {

				        "_token": "<?php echo e(csrf_token()); ?>"

			        }

		        },

		        columns: [

		            { data: 'name', name: 'name' },
		            { data: 'pre_test_pending', name: 'pre_test_pending' ,sortable : false},
		            { data: 'pending', name: 'pending' ,sortable : false},
		            { data: 'in_prgress', name: 'in_prgress' ,sortable : false},
		            { data: 'completed', name: 'completed' ,sortable : false},
		            { data: 'na', name: 'na' ,sortable : false},
		            { data: 'pre_np', name: 'pre_np' ,sortable : false},
		            { data: 'post_np', name: 'post_np' ,sortable : false},
		            { data: 'dropout', name: 'dropout' ,sortable : false},
		            { data: 'remaining', name: 'remaining' ,sortable : false},
		            { data: 'total', name: 'total' ,sortable : false},

		        ]

		    });

		}

	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>