<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
	<div class="m-container m-container--fluid m-container--full-height">
		<div class="m-stack m-stack--ver m-stack--desktop">

			<!-- BEGIN: Brand -->
			<div class="m-stack__item m-brand  m-brand--skin-dark ">
				<div class="m-stack m-stack--ver m-stack--general">
					<div class="m-stack__item m-stack__item--middle m-brand__logo">
						<a href="<?php echo e(url('/')); ?>" class="m-brand__logo-wrapper">
							<img style="margin-top:10px;" src="<?php echo e(url('/public')); ?>/images/inter-agency-web-small.JPG" height="80px" width="180px" />
						</a>
					</div>
					<div class="m-stack__item m-stack__item--middle m-brand__tools">

						<!-- BEGIN: Left Aside Minimize Toggle -->
						<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Responsive Aside Left Menu Toggler -->
						<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Responsive Header Menu Toggler -->
						<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Topbar Toggler -->
						<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
							<i class="flaticon-more"></i>
						</a>

						<!-- BEGIN: Topbar Toggler -->
					</div>
				</div>
			</div>

			<!-- END: Brand -->
			<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

				<!-- BEGIN: Horizontal Menu -->
				<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>


				<!-- END: Horizontal Menu -->

				<!-- BEGIN: Topbar -->
				<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
					<div class="m-stack__item m-topbar__nav-wrapper">
						<ul class="m-topbar__nav m-nav m-nav--inline">
							<li class="m-nav__item m-topbar__quick-actions m-dropdown m-dropdown--skin-light m-dropdown--large m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
								<a href="javascript:;" class="m-nav__link m-dropdown__toggle">
									<span class="m-nav__link-icon">
										<span class="m-nav__link-icon-wrapper"><i class="flaticon-menu-1"></i></span>
									</span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__header m--align-center">
											<span class="m-dropdown__header-title">Language</span>
										</div>
										<div class="m-dropdown__body m-dropdown__body--paddingless">
											<div class="m-dropdown__content">
												<div class="m-scrollable" data-scrollable="false" data-height="380" data-mobile-height="200">
													<div class="m-nav-grid m-nav-grid--skin-light">
														<div class="m-nav-grid__row">
															<a href="<?php echo e(url('locale/en')); ?>" class="m-nav-grid__item">
																<span class="m-nav-grid__text">English</span>
															</a>
															<a href="<?php echo e(url('locale/ar')); ?>" class="m-nav-grid__item">
																<span class="m-nav-grid__text">Arabic</span>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
								<a href="javascript:;" class="m-nav__link m-dropdown__toggle">
									<span class="m-topbar__userpic"><?php echo e(ucfirst(Auth::user()->firstname)); ?>

										
									</span>
									<span class="m-nav__link-icon m-topbar__usericon  m--hide">
										<span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
									</span>
									<span class="m-topbar__username m--hide"><?php echo e(ucfirst(Auth::user()->firstname)); ?></span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__header m--align-center">
											<div class="m-card-user m-card-user--skin-light">
												
												<div class="m-card-user__details">
													<span class="m-card-user__name m--font-weight-500"><?php echo e(ucfirst(Auth::user()->firstname)." ".ucfirst(Auth::user()->lastname)); ?></span>
													<a href="mailto:<?php echo e(Auth::user()->email); ?>" class="m-card-user__email m--font-weight-300 m-link"><?php echo e(Auth::user()->email); ?></a>
												</div>
											</div>
										</div>
										<div class="m-dropdown__body">
											<div class="m-dropdown__content">
												<ul class="m-nav m-nav--skin-light">
													<li class="m-nav__section m--hide">
														<span class="m-nav__section-text">Section</span>
													</li>
													
													<li class="m-nav__separator m-nav__separator--fit">
													</li>
													<li class="m-nav__item">
														<a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
															<form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
															Logout
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>

				<!-- END: Topbar -->
			</div>
		</div>
	</div>
</header>

<!-- END: Header --><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/layout/header.blade.php ENDPATH**/ ?>