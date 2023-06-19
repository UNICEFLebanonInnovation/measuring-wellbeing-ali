

<?php $__env->startSection('title',"Add Application"); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<a href="<?php echo e(url('/application-list')); ?>">Application List</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

	<link href="<?php echo e(url('/public')); ?>/assets/vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
	<div class="col-lg-12">

		<!--begin::Portlet-->
		<div class="m-portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
							<i class="la la-gear"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Add Application
						</h3>
					</div>
				</div>
			</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="add_application" method="post" action="<?php echo e(route('change-collector',$applicationObj->code)); ?>">
				<?php echo csrf_field(); ?>
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Collector:</label>
							<select class="form-control m-input" id="collector" name="collector">
								<option value="">Select Collector</option>
								<?php $__currentLoopData = $collectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($col->user_id); ?>" <?php echo e($applicationObj->collector_id == $col->user_id ? 'selected':''); ?>><?php echo e(ucfirst($col->name)); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
							<?php if($errors->has('collector')): ?>
			                  	<span class="m-form__help"><?php echo e($errors->first('collector')); ?></span>
			              	<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions--solid">
						<div class="row">
							<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button type="submit" class="btn btn-info">Save</button>
								<button type="reset" class="btn btn-secondary">Reset</button>
							</div>
						</div>
					</div>
				</div>
			</form>

			<!--end::Form-->
		</div>

		<!--end::Portlet-->
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('/public')); ?>/assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function(){
      	$("#add_application").validate({
         	rules:{
	         	category:{
	         		required:true
	         	}

         	},
         	messages:{
	            category:{
	         		required:"Please select category"
	         	}
         	}
      	})
   });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/application/change_collector.blade.php ENDPATH**/ ?>