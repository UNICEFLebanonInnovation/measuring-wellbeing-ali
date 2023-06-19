<!DOCTYPE html>

<html lang="<?php echo e(app()->getLocale()); ?>">



	<head>

		<meta charset="utf-8" />

		<title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name')); ?></title>

		<meta name="description" content="Measuring Well-being">

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



		<!--end::Page Vendors Styles -->

		<link rel="shortcut icon" href="<?php echo e(url('/public')); ?>/images/icon.JPG" />

		<?php echo $__env->yieldContent('css'); ?>

	</head>



	<!-- end::Head -->



	<!-- begin::Body -->

	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">



		<!-- begin:: Page -->

		<div class="m-grid m-grid--hor m-grid--root m-page">



			<?php echo $__env->make('admin.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



			<!-- begin::Body -->

			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">



				<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>



				<?php echo $__env->make('admin.layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



				<div class="m-grid__item m-grid__item--fluid m-wrapper">



					<div class="m-subheader ">

						<div class="d-flex align-items-center">

							<div class="mr-auto">

								<h3 class="m-subheader__title "><?php echo $__env->yieldContent('breadcrumb'); ?></h3>

							</div>
							<?php if(auth()->check() && auth()->user()->hasAnyRole("admin|partner")): ?>
							<form action="<?php echo e(url('filter')); ?>" method="post">

								<?php echo csrf_field(); ?>

								<div class="row">

									<div class="col-md-4 range_label">

										Application Range

									</div>

									<div class="col-md-4">

										<input type="number" min="0" class="form-control text-filter m-input" id="from_range" name="from" value="<?php echo e(Session::has('from') && !empty(Session::get('from')) ? Session::get('from') : ""); ?>" placeholder="X">

									</div>

									<!-- <div class="col-md-3">

										<input type="number" min="0" class="form-control text-filter m-input" id="to_range" name="to" value="<?php echo e(Session::has('to') && !empty(Session::get('to')) ? Session::get('to') : ""); ?>" placeholder="To">

									</div>
 -->
									<div class="col-md-4">

										<input type="submit" id="range_filter_submit" name="filter" class="btn btn-info">

										<a href="<?php echo e(url('clear-filter')); ?>" class="btn btn-secondary">Reset</a>

									</div>

								</div>

							</form>
							<?php endif; ?>

						</div>

						<?php if(Session::has('filterrange')): ?>
							<div class="alert alert-success" id="filterrange">
								<ul>
								<?php echo Session::get('filterrange'); ?>

								</ul>
							</div>
						<?php endif; ?>

					</div>





					<div class="m-content">



						<?php echo $__env->yieldContent('content'); ?>



					</div>

				</div>

			</div>



			<!-- end:: Body -->



			<?php echo $__env->make('admin.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		</div>



		<!-- end:: Page -->





		<!-- begin::Scroll Top -->

		<div id="m_scroll_top" class="m-scroll-top">

			<i class="la la-arrow-up"></i>

		</div>



		<!-- end::Scroll Top -->



		<!--begin:: Global Mandatory Vendors -->

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/jquery/dist/jquery.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/popper.js/dist/umd/popper.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/js-cookie/src/js.cookie.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/moment/min/moment.min.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/tooltip.js/dist/umd/tooltip.min.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/wnumb/wNumb.js" type="text/javascript"></script>

		<script src="<?php echo e(url('/public')); ?>/assets/vendors/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>



		<!--end:: Global Mandatory Vendors -->



		<!--begin::Global Theme Bundle -->

		<script src="<?php echo e(url('/public')); ?>/assets/demo/base/scripts.bundle.js" type="text/javascript"></script>

		<script src="<?php echo e(url('public/js/jquery.validate.min.js')); ?>"></script>

		<!--end::Global Theme Bundle -->



		<!--begin::Page Scripts -->

		<?php echo $__env->yieldContent('js'); ?>

		<!--end::Page Scripts -->



		<script type="text/javascript">

			$(document).ready(function(){



				$('#from_range').blur(function(){

		        	$('#to_range').val($(this).val());

		        })

		        $('#to_range').blur(function(){

		        	if($('#from_range').val() > $(this).val()){

		        		$('#from_range').val($(this).val() - 1);

		        	}

		        })
				setTimeout(function() {
			        $("#flash_alert").remove();

			    }, 3000);

			    setTimeout(function() {
					$('#filterrange').remove();

			    }, 20000);

			})

</script>

	</body>



	<!-- end::Body -->

</html><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/layout/app.blade.php ENDPATH**/ ?>