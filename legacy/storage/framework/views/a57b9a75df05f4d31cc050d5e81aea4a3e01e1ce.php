<div class="row" id="flash_alert">
	<div class="col-md-1">
	</div>
	<div class="col-md-10">
		<?php if($message = Session::get('success')): ?>
          	<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				</button>
				<?php echo e($message); ?>

			</div>
        <?php endif; ?>
        <?php if($message = Session::get('error')): ?>
          	<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				</button>
				<?php echo e($message); ?>

			</div>
        <?php endif; ?>
	</div>
	<div class="col-md-1"></div>
</div><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/layout/flash.blade.php ENDPATH**/ ?>