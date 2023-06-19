

<?php $__env->startSection('title',"Partner Detail"); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/partners-list')); ?>">Partners</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
	<link href="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

	<div class="row">
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								<?php echo e(ucfirst($partnerObj->name)); ?> Detail
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						<?php if(isset($partnerObj->firstname) && !empty($partnerObj->firstname)): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Name
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e(ucfirst($partnerObj->firstname." ".$partnerObj->lastname)); ?>

							</span>
						</div>
						<?php endif; ?>
						<?php if(isset($partnerObj->zone) && !empty($partnerObj->zone)): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Zone:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($partnerObj->zone); ?>

							</span>
						</div>
						<?php endif; ?>
						<?php if(isset($partnerObj->phone) && !empty($partnerObj->phone)): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Phone:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($partnerObj->phone); ?>

							</span>
						</div>
						<?php endif; ?>
						<?php if(isset($partnerObj->fax) && !empty($partnerObj->fax)): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Fax:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($partnerObj->fax); ?>

							</span>
						</div>
						<?php endif; ?>
						<?php if(isset($partnerObj->address) && !empty($partnerObj->address)): ?>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Address:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($partnerObj->address); ?>

							</span>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Programs
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-right">
								No of collectors
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								<?php echo e($collectorCount); ?>

							</span>
						</div>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-center">
								<a href="<?php echo e(url('collector-list')); ?>?partner=<?php echo e($partnerObj->id); ?>" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">View Collectors</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Logo
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						<div class="m-widget13__item">
							<?php if(!empty($partnerObj->logo)): ?>
							<img src="<?php echo e(url('/public')); ?>/images/partner_logo/<?php echo e($partnerObj->logo); ?>" alt="">
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="m-portlet m-portlet--mobile">
		
		<div class="m-portlet__body">
			<div class="m-separator m-separator--md m-separator--dashed"></div>
			<input type="hidden" name="partner" id="partner" value="<?php echo e($partnerObj->id); ?>">
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th><input type="text" class="form-control text-filter m-input filter" id="code" name="code" placeholder="Code"></th>
						<th><input type="text" class="form-control text-filter m-input filter" id="pre_test_date" name="pre_test_date" placeholder="Pre Test Date"></th>
						<th><input type="text" class="form-control text-filter m-input filter" id="post_test_date" name="post_test_date" placeholder="Post Test Date"></th>
						<th></th>
						<th>
							<?php if(auth()->check() && auth()->user()->hasAnyRole('admin|partner')): ?>
							<select name="status" id="status" class="form-control select-filter m-input filter">
								<option value="">Select status</option>
								<?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($st->id); ?>"><?php echo e(ucfirst($st->name)); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
							<?php endif; ?>
						</th>
					</tr>
					<tr>
						<th>Code</th>
						<th>Pre-Test Date</th>
						<th>Post-Test Date</th>
						<th>Score</th>
						<th>Status</th>
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

			$('.filter').on('keyup change',function(){
				datatables();
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
		        	url: '<?php echo route('loadProvidersCollector'); ?>',
		        	method: 'post',
		        	data: {
				        "_token": "<?php echo e(csrf_token()); ?>",
				        "code": $('#code').val(),
				        "pre_test_date": $('#pre_test_date').val(),
				        "post_test_date": $('#post_test_date').val(),
				        "partner": $('#partner').val(),
				        "status": $('#status').val(),
			        }
		        },
		        columns: [
		            { data: 'code', name: 'code' },
		            { data: 'pre_test_date', name: 'pre_test_date' },
		            { data: 'post_test_date', name: 'post_test_date' },
		            { data: 'score', name: 'score',sortable : false, },
		            { data: 'status_name', name: 'status_name' },
		        ]
		    });
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
	                    $.post('<?php echo e(route('delete-collector')); ?>',{id:id,_token:"<?php echo e(csrf_token()); ?>"},function(response){
			            	swal("Deleted", "Collector successfully deleted", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/partners/view.blade.php ENDPATH**/ ?>