

<?php $__env->startSection('title',"Partners"); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/partners-list')); ?>">Partners</a>
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
						Partners List
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?php echo e(url('add-partners')); ?>" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>Add Partner</span>
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
						<th><input type="text" class="form-control m-input" id="partner_id" name="partner_id" placeholder="Partner ID"></th>
						<th><input type="text" class="form-control m-input" id="name" name="name" placeholder="Name"></th>
						<th><input type="text" class="form-control m-input" id="firstname" name="firstname" placeholder="Firstname"></th>
						<th><input type="text" class="form-control m-input" id="lastname" name="lastname" placeholder="Lastname"></th>
						<th><input type="text" class="form-control m-input" id="email" name="email" placeholder="Email"></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th>Partner ID</th>
						<th>Name</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
						<th>Readonly</th>
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
		        searching:false,
		        destroy: true,
		        ajax: {
		        	url: '<?php echo route('loadPartnter'); ?>',
		        	method: 'post',
		        	data: {
				        "_token": "<?php echo e(csrf_token()); ?>",
				        "partner_id": $('#partner_id').val(),
				        "name": $('#name').val(),
				        "firstname": $('#firstname').val(),
				        "lastname": $('#lastname').val(),
				        "email": $('#email').val(),
			        }
		        },
		        columns: [
		            { data: 'partner_id', name: 'partner_id' },
		            { data: 'name', name: 'name' },
		            { data: 'firstname', name: 'firstname' },
		            { data: 'lastname', name: 'lastname' },
		            { data: 'email', name: 'email' },
		            { data: 'active', name: 'active' },
		            { data: 'status', name: 'status' },
		            { data: 'action', name: 'action' ,sortable : false,},
		        ]
		    });
		}
		function activatePartner(id,checked_or_not){
			var token = $('meta[name="csrf-token"]').attr('content');
			if (checked_or_not == 0) {
		    	var value = 1;
		    }else {
		    	var value = 0;
		    }
            $.post('<?php echo e(route('activate-partner')); ?>',{id:id,value:value,_token:"<?php echo e(csrf_token()); ?>"},function(response){
            	swal(response.status, response.response, "success");
				datatables();
			});
		}
		function deactivatePartner(id){
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
	                    $.post('<?php echo e(route('activate-partner')); ?>',{id:id,is_active:0,_token:"<?php echo e(csrf_token()); ?>"},function(response){
			            	swal("Deactivated", "Partner successfully deactivated", "success");
							datatables();
						});
	                }
            	});
			}
		}

		function deleteCollector(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, Delete",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('<?php echo e(route('delete-partner')); ?>',{id:id,_token:"<?php echo e(csrf_token()); ?>"},function(response){
			            	swal("Deleted", "Partner successfully deleted", "success");
							datatables();
						});
	                }
            	});
			}
		}

		function readonlyPartner(id,checked_or_not){
			if (checked_or_not == 0) {
		    	var value = 1;
		    }else {
		    	var value = 0;
		    }
			var token = $('meta[name="csrf-token"]').attr('content');
            $.post('<?php echo e(route('readonly-partner')); ?>',{id:id,value:value,_token:"<?php echo e(csrf_token()); ?>"},function(response){
            	//var output = JSON.parse(response);
            	swal(response.status, response.response, "success");
				datatables();
			});
			/*if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, readonly",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                }
            	});
			}*/
		}
		function unloackPartner(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, make functional",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('<?php echo e(route('readonly-partner')); ?>',{id:id,readonly:0,_token:"<?php echo e(csrf_token()); ?>"},function(response){
			            	swal("Deactivated", "Partner successfully moved to functional", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/partners/list.blade.php ENDPATH**/ ?>