

<?php $__env->startSection('title',"Login"); ?>


<?php $__env->startSection('content'); ?>
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" >
		<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
			<div class="m-login__container">
				<div class="m-login__logo">
					<a href="#">
						<img width="400" height="300" src="<?php echo e(url('/public')); ?>/images/inter-agency-web-big-2.JPG" />
					</a>
				</div>
				<div class="m-login__signin">
					<div class="m-login__head">
						<h3 class="m-login__title">Sign In To Admin</h3>
					</div>
					<form class="m-login__form m-form" id="login" action="<?php echo e(url('login-post')); ?>" method="post">
					<?php echo $__env->make('admin.layout.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php echo csrf_field(); ?>
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Email" value="<?php echo e(old('email')); ?>" name="email" autocomplete="off">
							<?php if($errors->has('email')): ?>
			                  	<span class="m-form__help"><?php echo e($errors->first('email')); ?></span>
			              	<?php endif; ?>
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
							<?php if($errors->has('password')): ?>
			                  	<span class="m-form__help"><?php echo e($errors->first('password')); ?></span>
			              	<?php endif; ?>
						</div>
						<div class="row m-login__form-sub">
							<div class="col m--align-left m-login__form-left">
								<label class="m-checkbox  m-checkbox--light">
									<input type="checkbox" name="remember" value="1"> Remember me
									<span></span>
								</label>
							</div>
							<div class="col m--align-right m-login__form-right">
								<a href="<?php echo e(url('forgot-password')); ?>" class="m-link">Forget Password ?</a>
							</div>
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign In</button>
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
      $("#login").validate({
         rules:{
            email:{
               required:true,
               email:true,
            },
            password:{
               required:true,
            },
         },
         messages:{
            password:{
               required:"Please enter your password",
            },
            email:{
               required:"Please enter your email",
               email:"Please enter your valid email",
            },
         }
      })
   });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.login_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/login.blade.php ENDPATH**/ ?>