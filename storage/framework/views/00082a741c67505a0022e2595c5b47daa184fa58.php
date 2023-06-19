

<?php $__env->startSection('title',"Admin"); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/admin-list')); ?>">Admin</a>
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
						Admin List
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?php echo e(url('add-admin')); ?>" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>Add Admin</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th><input type="text" class="form-control m-input" id="firstname" name="firstname" placeholder="Firstname"></th>
						<th><input type="text" class="form-control m-input" id="lastname" name="lastname" placeholder="Lastname"></th>
						<th><input type="text" class="form-control m-input" id="email" name="email" placeholder="Email"></th>
						<th><input type="text" class="form-control m-input" id="phone" name="phone" placeholder="Phone"></th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
						<th>Phone</th>
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

			$('.m-input').keyup(function(){
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
		        	url: '<?php echo route('loadAdmin'); ?>',
		        	method: 'post',
		        	data: {
				        "_token": "<?php echo e(csrf_token()); ?>",
				        "firstname": $('#firstname').val(),
				        "lastname": $('#lastname').val(),
				        "email": $('#email').val(),
				        "phone": $('#phone').val(),
			        }
		        },
		        columns: [
		            { data: 'firstname', name: 'firstname' },
		            { data: 'lastname', name: 'lastname' },
		            { data: 'email', name: 'email' },
		            { data: 'phone', name: 'phone' },
		            { data: 'status', name: 'status' },
		            { data: 'action', name: 'action' ,sortable : false,},
		        ]
		    });
		}
		function activateAdmin(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, Activate",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('<?php echo e(route('activate-admin')); ?>',{id:id,is_active:1,_token:"<?php echo e(csrf_token()); ?>"},function(response){
			            	swal("Activated", "Admin successfully activated", "success");
							datatables();
						});
	                }
            	});
			}
		}
		function deactivateAdmin(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, In-activate",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('<?php echo e(route('activate-admin')); ?>',{id:id,is_active:0,_token:"<?php echo e(csrf_token()); ?>"},function(response){
			            	swal("Deactivated", "Admin successfully deactivated", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/user/list.blade.php ENDPATH**/ ?>