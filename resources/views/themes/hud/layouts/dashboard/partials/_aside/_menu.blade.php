
<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
	<div id="kt_aside_menu" class="kt-aside-menu  kt-aside-menu--dropdown " data-ktmenu-vertical="1" data-ktmenu-dropdown="1" data-ktmenu-scroll="0" data-ktmenu-dropdown-timeout="500">
		<ul class="kt-menu__nav ">
            <li class="kt-menu__item  kt-menu__item--submenu {{active('home',1,true)}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="{{route('home')}}" class="kt-menu__link">
                    <i class="kt-menu__link-icon flaticon2-analytics-1"></i>
                    <span class="kt-menu__link-text">{{__('app.side_bar.home')}}</span>
                </a>

            </li>
            <li class="kt-menu__section ">
				<h4 class="kt-menu__section-text">{{__('app.side_bar.user_management')}}</h4>
				<i class="kt-menu__section-icon flaticon-more-v2"></i>
			</li>
            <li class="kt-menu__item  kt-menu__item--submenu {{active('settings',1,true)}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-gear"></i><span class="kt-menu__link-text">{{__('app.side_bar.settings_controller')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Apps</span></span></li>
                        @can('list-languages')

                            <li class="kt-menu__item {{active('languages',2)}}" aria-haspopup="true"><a href="{{route('languages.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">{{__('app.side_bar.settings_control.languages')}}</span><span class="kt-menu__link-badge"></span></a></li>
                        @endcan

                        @can('list-settings')

                            <li class="kt-menu__item {{active('show',2)}}" aria-haspopup="true"><a href="{{route('settings.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">{{__('app.side_bar.settings_control.settings')}}</span><span class="kt-menu__link-badge"></span></a></li>
                        @endcan
                    </ul>
                </div>
            </li>
			<li class="kt-menu__item  kt-menu__item--submenu {{active('auth',1,true)}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-user"></i><span class="kt-menu__link-text">{{__('app.side_bar.auth_controller')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
				<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
					<ul class="kt-menu__subnav">
						<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Apps</span></span></li>
						@can('list-users')
                            <li class="kt-menu__item {{active('users',2)}}" aria-haspopup="true"><a href="{{route('users.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">{{__('app.side_bar.auth_control.users')}}</span><span class="kt-menu__link-badge"></span></a></li>
                        @endcan
                        @can('list-roles')
                            <li class="kt-menu__item {{active('roles',2)}}" aria-haspopup="true"><a href="{{route('roles.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">{{__('app.side_bar.auth_control.roles')}}</span><span class="kt-menu__link-badge"></span></a></li>
                        @endcan
                        @can('list-permissions')
                            <li class="kt-menu__item {{active('permissions',2)}}" aria-haspopup="true"><a href="{{route('permissions.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">{{__('app.side_bar.auth_control.permissions')}}</span><span class="kt-menu__link-badge"><span class="kt-badge kt-badge--danger kt-badge--inline">{{__('app.new')}}</span></span></a></li>
                        @endcan

                    </ul>
				</div>
			</li>
			<li class="kt-menu__item  kt-menu__item--submenu {{active('saas',1,true)}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-open-box"></i><span class="kt-menu__link-text">{{__('app.side_bar.saas_controller')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
				<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
					<ul class="kt-menu__subnav">
						<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">{{ __('app.apps') }}</span></span></li>
						@can('list-packages')
                            <li class="kt-menu__item {{active('packages',2)}}" aria-haspopup="true"><a href="{{route('packages.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">{{__('app.side_bar.saas_control.packages')}}</span><span class="kt-menu__link-badge"></span></a></li>
                        @endcan
                    </ul>
				</div>
			</li>



		</ul>
	</div>
</div>

<!-- end:: Aside Menu -->
