<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!DOCTYPE html>

<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="<?php echo e(app()->getLocale()); ?>">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name')); ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<!--begin:: Global Mandatory Vendors -->
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" type="text/css" />

		<!--end:: Global Mandatory Vendors -->

		<!--begin:: Global Optional Vendors -->
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/tether/dist/css/tether.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/animate.css/animate.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/toastr/build/toastr.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/jstree/dist/themes/default/style.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/morris.js/morris.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/chartist/dist/chartist.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/socicon/css/socicon.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/vendors/line-awesome/css/line-awesome.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/vendors/flaticon/css/flaticon.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/vendors/metronic/css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/vendors/vendors/fontawesome5/css/all.min.css" rel="stylesheet" type="text/css" />

		<!--end:: Global Optional Vendors -->

		<!--begin::Global Theme Styles -->
		<link href="<?php echo e(url('/public')); ?>/assets/demo/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(url('/public')); ?>/assets/leb/leb.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->
		<link rel="shortcut icon" href="<?php echo e(url('/public')); ?>/images/icon.JPG" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<?php echo $__env->yieldContent('content'); ?>
		</div>

		<!-- end:: Page -->

		<!--begin:: Global Mandatory Vendors -->
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/jquery/dist/jquery.js" type="text/javascript"></script>
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/popper.js/dist/umd/popper.js" type="text/javascript"></script>
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/js-cookie/src/js.cookie.js" type="text/javascript"></script>
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/moment/min/moment.min.js" type="text/javascript"></script>
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/tooltip.js/dist/umd/tooltip.min.js" type="text/javascript"></script>
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>
		<script src="<?php echo e(url('/public')); ?>/assets/vendors/wnumb/wNumb.js" type="text/javascript"></script>

		<!--end:: Global Mandatory Vendors -->

		<!--begin::Global Theme Bundle -->
		<script src="<?php echo e(url('/public')); ?>/assets/demo/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->
		<script src="<?php echo e(url('public/js/jquery.validate.min.js')); ?>"></script>
		<?php echo $__env->yieldContent('js'); ?>

	</body>

	<!-- end::Body -->
</html><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/layout/login_app.blade.php ENDPATH**/ ?>