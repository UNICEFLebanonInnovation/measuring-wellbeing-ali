

<?php $__env->startSection('title',"Setup Profile"); ?>


<?php $__env->startSection('content'); ?>
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signup m-login--2 m-login-2--skin-3" id="m_login" >
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
						<div class="m-login__title"><?php echo e($users->getRoleNames()); ?> Set Password</div>
					</div>
					<form class="m-login__form m-form" action="<?php echo e(route('setup-profile',$key)); ?>" method="post" id="setup_profile">
						<?php echo csrf_field(); ?>
						<input id="user_id" type="hidden" class="form-control" name="user_id" value="<?php echo e(isset($id)?$id:''); ?>" required />
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Name" readonly="" value="<?php echo e($name); ?>" id="name" name="name">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" readonly="" value="<?php echo e($users->email); ?>" placeholder="Email" id="email" name="email" autocomplete="off">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="password" placeholder="Password" id="password" name="password">
							<?php if($errors->has('password')): ?>
			                  	<span class="m-form__help"><?php echo e($errors->first('password')); ?></span>
			              	<?php endif; ?>
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Re-type Password" id="password_confirmation" name="password_confirmation">
							<?php if($errors->has('password_confirmation')): ?>
			                  	<span class="m-form__help"><?php echo e($errors->first('password_confirmation')); ?></span>
			              	<?php endif; ?>
						</div>
						<div class="row form-group m-form__group m-login__form-sub">
							<div class="col m--align-left">
								<label class="m-checkbox m-checkbox--light">
									<input type="checkbox" required="" name="agree">I Agree to the <a href="#" class=" m-link--focus">Terms of Use</a> and <a href="#" class="m-link--focus">Privacy Policy</a>
									<span></span>
								</label>
								<?php if($errors->has('agree')): ?>
				                  	<span class="m-form__help"><?php echo e($errors->first('agree')); ?></span>
				              	<?php endif; ?>
								<span class="m-form__help"></span>
							</div>
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Proceed</button>&nbsp;&nbsp;
							<a href="#" class="m-link--focus">Learn more</a>
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
      $("#setup_profile").validate({
         rules:{
         	name:{
         		required:true
         	},
            password:{
               required:true,
            },
            password_confirmation:{
               required:true,
               equalTo: "#password"
            }
         },
         messages:{
         	name:{
         		required:"Please enter name"
         	},
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
<?php echo $__env->make('admin.layout.login_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/setup_profile.blade.php ENDPATH**/ ?>