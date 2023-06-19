<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

	<!-- BEGIN: Aside Menu -->

	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">

		<ul class="m-menu__nav ">

			@hasanyrole("admin|partner")

				@php

					$activeDashboardMenu = "";

					if(Request::segment(1) == '' || Request::segment(1) == 'dashboard' ){

						$activeDashboardMenu = "m-menu__item--active";

					}



				@endphp

				<li class="m-menu__item  {{ $activeDashboardMenu }}" aria-haspopup="true">

					<a href="{{ url('/dashboard') }}" class="m-menu__link " title="Dashboard">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-line-graph"></i>

						<span class="m-menu__link-text">Dashboard</span>

					</a>

				</li>

			@endhasanyrole







			@hasrole('admin')

				@php

					$activeAdminMenu = "";

					if(Request::segment(1) == 'admin-list' || Request::segment(1) == 'add-admin' || Request::segment(1) == 'edit-admin'){

						$activeAdminMenu = "m-menu__item--active";

					}



				@endphp

				<li class="m-menu__item {{ $activeAdminMenu }}" aria-haspopup="true" title="Admin">

					<a href="{{ url('admin-list') }}" class="m-menu__link ">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-users"></i>

						<span class="m-menu__link-text">Admin</span>

					</a>

				</li>

				@php

					$activePartnerMenu = "";

					if(Request::segment(1) == 'partners-list' || Request::segment(1) == 'add-partners' || Request::segment(1) == 'edit-partners' || Request::segment(1) == 'view-partners'){

						$activePartnerMenu = "m-menu__item--active";

					}



				@endphp

				<li class="m-menu__item {{ $activePartnerMenu }}" aria-haspopup="true" title="Partners">

					<a href="{{ url('partners-list') }}" class="m-menu__link ">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-users"></i>

						<span class="m-menu__link-text">Partners</span>

					</a>

				</li>

			@endhasrole

			@hasanyrole("admin|partner")

				@php

					$activeCollectorMenu = "";

					if(Request::segment(1) == 'collector-list' || Request::segment(1) == 'add-collector' || Request::segment(1) == 'edit-collector'){

						$activeCollectorMenu = "m-menu__item--active";

					}



				@endphp

				<li class="m-menu__item {{ $activeCollectorMenu }}" aria-haspopup="true" >

					<a href="{{ url('collector-list') }}" class="m-menu__link " title="Collectors">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-map"></i>

						<span class="m-menu__link-text">Collectors</span>

					</a>

				</li>

			@endhasanyrole

			@hasanyrole("collector|partner|admin")

				@php

					$activeApplicationMenu = "";

					if(Request::segment(1) == 'application-list' || Request::segment(1) == 'pre-test-application' || Request::segment(1) == 'post-test-application'){

						$activeApplicationMenu = "m-menu__item--active";

					}



				@endphp

				<li class="m-menu__item {{ $activeApplicationMenu }}" aria-haspopup="true">

					<a href="{{ url('application-list') }}" class="m-menu__link " title="Applications">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-list"></i>

						<span class="m-menu__link-text">Applications</span>

					</a>

				</li>

			@endhasanyrole

			@hasanyrole("partner|admin")

				@php

					$activeChangeDeMenu = "";

					if(Request::segment(1) == '' || Request::segment(1) == 'change-decrease-list' ){

						$activeChangeDeMenu = "m-menu__item--active";

					}

				@endphp

				<li class="m-menu__item  {{ $activeChangeDeMenu }}" aria-haspopup="true">

					<a href="{{ url('/change-decrease-list') }}" class="m-menu__link " title="Dashboard">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-line-graph"></i>

						<span class="m-menu__link-text">Change Decrease</span>

					</a>

				</li>

				@php

					$activeAnalyticMenu = "";

					$activeDropoutMenu = "";

					$activeNormalCompMenu = "";

					$age_6_11_menu = "";

					$age_12_17_menu = "";

					$partnerAnaMenu = "";

					$govAnaMenu = "";

					$IncreaseScaleMenu = "";

					$uncompletedNgoMenu = "";

					$analysisDataMenu = "";

					$analysisChangeMenu = "";

					if(Request::segment(1) == 'reason-for-dropout' || Request::segment(1) == 'normal-conparison' || Request::segment(1) == '6-11-comparision' || Request::segment(1) == '12-17-comparision' || Request::segment(1) == 'partner-analysys' || Request::segment(1) == 'gov-analysys' || Request::segment(1) == 'increase-scale' || Request::segment(1) == 'uncompleted-per-ngo' || Request::segment(1) == 'sdq-analysis-data' || Request::segment(1) == 'analysis-change'){

						$activeAnalyticMenu = "m-menu__item--active m-menu__item--open";

					}

					if(Request::segment(1) == 'reason-for-dropout'){

						$activeDropoutMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'normal-conparison'){

						$activeNormalCompMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == '6-11-comparision'){

						$age_6_11_menu = "m-menu__item--active";

					}

					if(Request::segment(1) == '12-17-comparision'){

						$age_12_17_menu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'partner-analysys'){

						$partnerAnaMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'gov-analysys'){

						$govAnaMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'increase-scale'){

						$IncreaseScaleMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'uncompleted-per-ngo'){

						$uncompletedNgoMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'sdq-analysis-data'){

						$analysisDataMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'analysis-change'){

						$analysisChangeMenu = "m-menu__item--active";

					}

				@endphp

				<li class="m-menu__item  m-menu__item--submenu {{ $activeAnalyticMenu }}" aria-haspopup="true" m-menu-submenu-toggle="hover">

					<a href="javascript:;" class="m-menu__link m-menu__toggle" title="Analytics">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-list"></i>

						<span class="m-menu__link-text">Analytics</span>

						<i class="m-menu__ver-arrow la la-angle-right"></i>

					</a>

					<div class="m-menu__submenu "><span class="m-menu__arrow"></span>

						<ul class="m-menu__subnav">

							<li class="m-menu__item {{ $activeDropoutMenu }}" aria-haspopup="true">

								<a href="{{ url('reason-for-dropout') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Reason For Dropout</span>

								</a>

							</li>

							<li class="m-menu__item {{ $activeNormalCompMenu }}" aria-haspopup="true">

								<a href="{{ url('normal-conparison') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Normal Comparison</span>

								</a>

							</li>

							<!-- <li class="m-menu__item {{ $age_6_11_menu }}" aria-haspopup="true">

								<a href="{{ url('6-11-comparision') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">6-11 Comparison</span>

								</a>

							</li>

							<li class="m-menu__item {{ $age_12_17_menu }}" aria-haspopup="true">

								<a href="{{ url('12-17-comparision') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">12-17 Comparison</span>

								</a>

							</li> -->

							@hasrole('admin')

							<li class="m-menu__item {{ $partnerAnaMenu }}" aria-haspopup="true">

								<a href="{{ url('partner-analysys') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Partner analysis</span>

								</a>

							</li>

							@endhasrole

							@hasrole('partner')

							<li class="m-menu__item {{ $partnerAnaMenu }}" aria-haspopup="true">

								<a href="{{ url('partner-analysys') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Collector analysis</span>

								</a>

							</li>

							@endhasrole

							<li class="m-menu__item {{ $govAnaMenu }}" aria-haspopup="true">

								<a href="{{ url('gov-analysys') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Govornarate Analysis</span>

								</a>

							</li>

							<li class="m-menu__item {{ $IncreaseScaleMenu }}" aria-haspopup="true">

								<a href="{{ url('increase-scale') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">% Increase Scale</span>

								</a>

							</li>

							@hasrole('admin')

							<li class="m-menu__item {{ $uncompletedNgoMenu }}" aria-haspopup="true">

								<a href="{{ url('uncompleted-per-ngo') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Uncompleted per NGO</span>

								</a>

							</li>

							@endhasrole

							@hasrole('partner')

							<li class="m-menu__item {{ $uncompletedNgoMenu }}" aria-haspopup="true">

								<a href="{{ url('uncompleted-per-ngo') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Uncompleted per Collector</span>

								</a>

							</li>

							@endhasrole

							<li class="m-menu__item {{ $analysisDataMenu }}" aria-haspopup="true">

								<a href="{{ url('sdq-analysis-data') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">SDQ Analysis Data</span>

								</a>

							</li>

							<li class="m-menu__item {{ $analysisChangeMenu }}" aria-haspopup="true">

								<a href="{{ url('analysis-change') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Analysis Change</span>

								</a>

							</li>

						</ul>

					</div>

				</li>

			@endhasanyrole

			@hasrole('admin')

				<li class="m-menu__item " aria-haspopup="true">

					<a href="{{ url('reports') }}" class="m-menu__link " title="Reports">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-edit-1"></i>

						<span class="m-menu__link-text">Reports</span>

					</a>

				</li>

				@php

					$activeFormsionMenu = "";

					if(Request::segment(1) == 'form-list' || Request::segment(1) == 'add-form' || Request::segment(1) == 'view-form'){

						$activeFormsionMenu = "m-menu__item--active";

					}



				@endphp

				{{-- <li class="m-menu__item {{ $activeFormsionMenu }}" aria-haspopup="true">

					<a href="{{ url('form-list') }}" class="m-menu__link ">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-edit-1"></i>

						<span class="m-menu__link-text">Forms</span>

					</a>

				</li> --}}

				@php

					$activeStatusMenu = "";

					if(Request::segment(1) == 'status-list' || Request::segment(1) == 'add-status' || Request::segment(1) == 'edit-status'){

						$activeStatusMenu = "m-menu__item--active";

					}



				@endphp

				<li class="m-menu__item {{ $activeStatusMenu }}" aria-haspopup="true">

					<a href="{{ url('status-list') }}" class="m-menu__link " title="Status">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-edit-1"></i>

						<span class="m-menu__link-text">Status</span>

					</a>

				</li>

				@php

					$activeLocationionMenu = "";

					$activeGovMenu = "";

					$activeCazaMenu = "";

					$activeAreaMenu = "";

					if(Request::segment(1) == 'gouvernate-list' || Request::segment(1) == 'add-gouvernate' || Request::segment(1) == 'edit-gouvernate' || Request::segment(1) == 'caza-list' || Request::segment(1) == 'add-caza' || Request::segment(1) == 'edit-caza' || Request::segment(1) == 'area-list' || Request::segment(1) == 'add-area' || Request::segment(1) == 'edit-area'){

						$activeLocationionMenu = "m-menu__item--active m-menu__item--open";

					}

					if(Request::segment(1) == 'gouvernate-list' || Request::segment(1) == 'add-gouvernate' || Request::segment(1) == 'edit-gouvernate'){

						$activeGovMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'caza-list' || Request::segment(1) == 'add-caza' || Request::segment(1) == 'edit-caza'){

						$activeCazaMenu = "m-menu__item--active";

					}

					if(Request::segment(1) == 'area-list' || Request::segment(1) == 'add-area' || Request::segment(1) == 'edit-area'){

						$activeAreaMenu = "m-menu__item--active";

					}

				@endphp

				<li class="m-menu__item  m-menu__item--submenu {{ $activeLocationionMenu }}" aria-haspopup="true" m-menu-submenu-toggle="hover">

					<a href="javascript:;" class="m-menu__link m-menu__toggle" title="Location">

						<span class="m-menu__item-here"></span>

						<i class="m-menu__link-icon flaticon-map-location"></i>

						<span class="m-menu__link-text">Location</span>

						<i class="m-menu__ver-arrow la la-angle-right"></i>

					</a>

					<div class="m-menu__submenu "><span class="m-menu__arrow"></span>

						<ul class="m-menu__subnav">

							<li class="m-menu__item {{ $activeGovMenu }}" aria-haspopup="true">

								<a href="{{ url('gouvernate-list') }}" class="m-menu__link " title="Gouvernate">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">{{ trans('messages.gouvarnate') }}</span>

								</a>

							</li>

							<li class="m-menu__item {{ $activeCazaMenu }}" aria-haspopup="true">

								<a href="{{ url('caza-list') }}" class="m-menu__link " title="Caza">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Caza</span>

								</a>

							</li>

							<li class="m-menu__item {{ $activeAreaMenu }}" aria-haspopup="true">

								<a href="{{ url('area-list') }}" class="m-menu__link " title="Area">

									<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

									<span class="m-menu__link-text">Area</span>

								</a>

							</li>

						</ul>

					</div>

				</li>

			@endhasrole



			{{-- <li class="m-menu__item " aria-haspopup="true">

				<a href="{{ url('blank-page') }}" class="m-menu__link ">

					<span class="m-menu__item-here"></span>

					<i class="m-menu__link-icon flaticon-browser"></i>

					<span class="m-menu__link-text">Blank Page</span>

				</a>

			</li> --}}

		</ul>

	</div>



	<!-- END: Aside Menu -->

</div>