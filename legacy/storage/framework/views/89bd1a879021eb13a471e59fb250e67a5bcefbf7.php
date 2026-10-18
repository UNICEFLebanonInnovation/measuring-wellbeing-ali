

<?php $__env->startSection('title',"Reset Password"); ?>


<?php $__env->startSection('content'); ?>
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signup m-login--2 m-login-2--skin-3" id="m_login">
		<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
			<div class="m-login__container">
				<div class="m-login__logo">
					<a href="#">
						<img width="400" height="300" src="<?php echo e(url('/public')); ?>/images/inter-agency-web-big-2.JPG" />
					</a>
				</div>
				<div class="m-login__signup">
					<div class="m-login__head">
						<h3 class="m-login__title">SDQ</h3>
						<div class="m-login__title">Reset your Password</div>
					</div>
					<?php echo $__env->make('admin.layout.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<form class="m-login__form m-form" id="reset" action="<?php echo e(url('savePassword')); ?>" method="post">
						<?php echo csrf_field(); ?>
						<input id="user_id" type="hidden" class="form-control" name="user_id" value="<?php echo e(isset($id)?$id:''); ?>" required />
						<div class="form-group m-form__group">
							<input class="form-control m-input" id="password" type="password" placeholder="Password" name="password">
							<?php if($errors->has('password')): ?>
			                  	<span class="m-form__help"><?php echo e($errors->first('password')); ?></span>
			              	<?php endif; ?>
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Re-type Password" name="password_confirmation">
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Set Password</button>&nbsp;&nbsp;
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
   $(document).ready(function(){
      $("#reset").validate({
         rules:{
            password:{
               required:true,
            },
            password_confirmation:{
               required:true,
               equalTo: "#password"
            }
         },
         messages:{
            password:{
               required:"Please enter your password",
            },
            password_confirmation:{
               required:"Please enter confirm password",
               equalTo:"Password not match"
            }
         }
      })
   });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.login_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/reset_password.blade.php ENDPATH**/ ?>