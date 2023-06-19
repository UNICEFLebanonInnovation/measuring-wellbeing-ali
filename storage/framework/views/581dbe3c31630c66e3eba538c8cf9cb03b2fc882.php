<?php $__env->startSection('title',"Reports"); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/reports')); ?>">Reports</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
	<link href="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Reports
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Application</th>
						<th>User</th>
						<th>Log</th>
						<th>Date</th>
					</tr>
				</thead>
			</table>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			datatables();
		});
		function datatables(){
		    $('#m_table_1').DataTable({
		        processing: true,
		        serverSide: true,
		        searching:false,
		        ordering:true,
		        destroy: true,
		        ajax: {
		        	url: '<?php echo route('load-reports'); ?>',
		        	method: 'post',
		        	data: {
				        "_token": "<?php echo e(csrf_token()); ?>",
				        'id': $('#id').val(),
				        'name': $('#name').val()
			        }
		        },
		        columns: [
		            { data: 'code', name: 'code' },
		            { data: 'firstname', name: 'firstname' },
		            { data: 'text', name: 'text' },
		            { data: 'created_at', name: 'created_at' }
		        ]
		    });
		}
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/report.blade.php ENDPATH**/ ?>