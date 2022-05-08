<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-center p-0">
        <a href="{{ route('home') }}"></a>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu p-0 m-0">
                @hasrole('customer')
                @if (auth()->user()->type != 'subcustomer')
                    <div
                        class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customerhome' ? 'active' : '' }}">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('home') }}" class="iq-waves-effect">
                                    <img alt="Logo" src="{{ resolveDark() }}/img/icon_menu/homemenu.svg"
                                         class="img-fluid"/>
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('home') }}"
                                   class="iq-waves-effect menutext">{{ __('app.website_name') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom clearfix"></div>
                    <div
                        class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/map' ? 'active' : '' }}">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('map.index') }}" class="iq-waves-effect">
                                    <img src="{{ resolveDark() }}/img/icon_menu/map.svg" alt="product-image"
                                         class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('map.index') }}"
                                   class="iq-waves-effect menutext">{{ __('app.Map') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom clearfix"></div>

                    @can('list-mypackages')
                        <div
                            class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/customerPackages' ? 'active' : '' }}">
                            <div class="col-12 justify-content-center">
                                <div class="iq-product-cover d-flex justify-content-center">
                                    <a href="{{ route('customerPackages.index') }}" class="iq-waves-effect">
                                        <img src="{{ resolveDark() }}/img/icon_menu/package.svg" alt="product-image"
                                             class="img-fluid">
                                    </a>
                                </div>
                                <div class="iq-product-cover d-flex justify-content-center"><a
                                        href="{{ route('customerPackages.index') }}"
                                        class="iq-waves-effect menutext">{{ __('app.side_bar.customers.mymodels') }}</a>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <div class="border-bottom clearfix"></div>

                    {{-- @can('list-CustomerBranches') --}}
                    {{-- <div class="row justify-content-center"> --}}
                    {{-- <div class="col-12 justify-content-center"> --}}
                    {{-- <div class="iq-product-cover d-flex justify-content-center"> --}}
                    {{-- <a href="{{route('customerRegions.index')}}" class="iq-waves-effect"> --}}
                    {{-- <img src="{{   session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') }}" alt="product-image" class="img-fluid"> --}}
                    {{-- </a> --}}
                    {{-- </div> --}}
                    {{-- <div class="iq-product-cover d-flex justify-content-center"> <a  href="{{route('customerRegions.index')}}" class="iq-waves-effect menutext" >{{__('app.side_bar.customers.regions')}}</a></div> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- @endcan --}}

                    {{-- <hr style="{{session()->has('darkMode') ?'background-color:#d1d1d1d4;':''}}"> --}}


                    {{-- @can('list-CustomerBranches') --}}
                    {{-- <div class="row justify-content-center"> --}}
                    {{-- <div class="col-12 justify-content-center"> --}}
                    {{-- <div class="iq-product-cover d-flex justify-content-center"> --}}
                    {{-- <a href="{{route('customerBranches.index')}}" class="iq-waves-effect"> --}}
                    {{-- <img src="{{resolveDark()}}/img/branch.svg" alt="product-image" class="img-fluid"></a> --}}
                    {{-- </div> --}}
                    {{-- <div class="iq-product-cover d-flex justify-content-center"> <a  href="{{route('customerBranches.index')}}" class="iq-waves-effect menutext" >{{__('app.side_bar.customers.branches')}}</a></div> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- @endcan --}}

                    {{-- <div class="border-bottom clearfix"></div> --}}


                    @can('list-CustomerUsers')
                        <div
                            class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/customerUsers' ? 'active' : '' }}">
                            <div class="col-12 justify-content-center">
                                <div class="iq-product-cover d-flex justify-content-center">
                                    <a href="{{ route('customerUsers.index') }}" class="iq-waves-effect"><img
                                            src="{{ resolveDark() }}/img/icon_menu/users.svg" alt="product-image"
                                            class="img-fluid"></a>
                                </div>
                                <div class="iq-product-cover d-flex justify-content-center"><a
                                        href="{{ route('customerUsers.index') }}"
                                        class="iq-waves-effect menutext">{{ __('app.side_bar.auth_control.users') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom clearfix"></div>

                    @endcan

                    <div class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/positions' ? 'active' : '' }}">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ url('customer/positions') }}" class="iq-waves-effect">
                                    <img src="{{ resolveDark() }}/img/icon_menu/positions.svg" alt="Reports" class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ url('customer/positions') }}" class="iq-waves-effect menutext">
                                    {{ __('app.positions') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom clearfix"></div>

                    <div class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/escalations' ? 'active' : '' }}">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ url('customer/escalations') }}" class="iq-waves-effect">
                                    <img src="{{ resolveDark() }}/img/icon_menu/escalations.svg" alt="Reports" class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ url('customer/escalations') }}" class="iq-waves-effect menutext">
                                    {{ __('app.escalations') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom clearfix"></div>

                    <div
                        class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/reports' ? 'active' : '' }}">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('reports.index') }}" class="iq-waves-effect"><img
                                        src="{{ resolveDark() }}/img/icon_menu/report.svg" alt="Reports"
                                        class="img-fluid"></a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center"><a
                                    href="{{ route('reports.index') }}"
                                    class="iq-waves-effect menutext">{{ __('app.Reports') }}</a></div>
                        </div>
                    </div>
                    <div class="border-bottom clearfix"></div>
                    <div
                        class="row justify-content-center  p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/branches-status' ? 'active' : '' }} ">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('branches_status') }}" class="iq-waves-effect">
                                    {{--                                    <i class="fas fa-building fa-2x"></i>--}}
                                    <img
                                        src="{{ resolveDark() }}/img/icon_menu/building.svg" alt="Settings"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('branches_status') }}"
                                   class="iq-waves-effect menutext">{{ __('app.branchStatus') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom clearfix"></div>
                    <div
                        class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/config/place/get' ? 'active' : '' }}">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('config.index', 'place') }}" class="iq-waves-effect"><img
                                        src="{{ resolveDark() }}/img/icon_menu/config.svg" alt="Config"
                                        class="img-fluid"></a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center"><a
                                    href="{{ route('config.index', 'place') }}"
                                    class="iq-waves-effect menutext">{{ __('app.config') }}</a>
                            </div>
                        </div>
                    </div>
                    @can('list-CustomerUsers')
                        <div class="border-bottom clearfix"></div>

                        <div
                            class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/customer/activities' ? 'active' : '' }}">
                            <div class="col-12 justify-content-center">
                                <div class="iq-product-cover d-flex justify-content-center">
                                    <a href="{{ route('activities.index') }}" class="iq-waves-effect"><img
                                            src="{{ resolveDark() }}/img/icon_menu/work-time.svg" alt="product-image"
                                            class="img-fluid"></a>
                                </div>
                                <div class="iq-product-cover d-flex justify-content-center"><a
                                        href="{{ route('activities.index') }}"
                                        class="iq-waves-effect menutext">{{ __('app.side_bar.auth_control.activities') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom clearfix"></div>
                    @endcan
                    <div
                        class="row justify-content-center  p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/settings/reminder' ? 'active' : '' }} ">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('setting.reminder') }}" class="iq-waves-effect"><img
                                        src="{{ resolveDark() }}/img/icon_menu/settings.svg" alt="Settings"
                                        class="img-fluid"></a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center"><a
                                    href="{{ route('setting.reminder') }}"
                                    class="iq-waves-effect menutext">{{ __('app.Settings') }}</a></div>

                        <!-- <div class="iq-product-cover d-flex justify-content-center">
                                                                                                <a href="#reminder" class="setting-link iq-waves-effect collapsed" data-toggle="collapse"
                                                                                            aria-expanded="false">
                                                                                            <img src="{{ resolveDark() }}/img/icon_menu/config.png" alt="settings" class="img-fluid" style="width: 25px; height:25px;">
                                                                                            <span class="text menutext">Settings <i class="ri-arrow-right-s-line iq-arrow-right"></i></span>
                                                                                            </a>
                                                                                        </div>
                                                                                         <ul id="reminder" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                                                                                    <li>
                                                                                                        <a href="{{ route('setting.reminder') }}" class="d-flex justify-content-between">
                                                                                                            <i class="fas fa-bell"></i>Reminder</a>
                                                                                                    </li>
                                                                                            </ul> -->

                        </div>
                    </div>

                    <div class="border-bottom clearfix"></div>

                    <div
                        class="row justify-content-center  p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/connection-speed' ? 'active' : '' }} ">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('connection-speed.index') }}" class="iq-waves-effect">
                                    {{--                                    <i class="fas fa-wifi fa-2x"></i>--}}
                                    <img
                                        src="{{ resolveDark() }}/img/icon_menu/wifi.svg" alt="Settings"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center"><a
                                    href="{{ route('connection-speed.index') }}"
                                    class="iq-waves-effect menutext">{{ __('app.Connections') }}</a></div>
                        </div>
                    </div>

                    <div class="border-bottom clearfix"></div>

                    <div
                        class="row justify-content-center  p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == "/branches/register" ? 'active': ''}} ">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a target="_blank" href="{{route('branch.register')}}" class="iq-waves-effect">
                                    {{--                                    <i class="fas fa-building fa-2x"></i>--}}
                                    <img
                                        src="{{ resolveDark() }}/img/icon_menu/building.svg" alt="Settings"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center"><a
                                    href="{{route('branch.register')}}"
                                    target="_blank"
                                    class="iq-waves-effect menutext">{{__('app.customers.speed.registerBranch.page_title')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom clearfix"></div>

                    <div
                        class="row justify-content-center  p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/branches/message-log' ? 'active' : '' }} ">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('branch.message_log') }}" class="iq-waves-effect">
                                    {{--                                    <i class="fa fa-envelope-open fa-2x"></i>--}}
                                    <img
                                        src="{{ resolveDark() }}/img/icon_menu/envelope.svg" alt="Settings"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('branch.message_log') }}"
                                   class="iq-waves-effect menutext">{{ __('app.branch_message') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom clearfix"></div>

                    <div
                        class="row justify-content-center  p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/services' ? 'active' : '' }} ">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('service.index') }}" class="iq-waves-effect">
                                    {{--                                    <i class="fab fa-servicestack fa-2x"></i>--}}
                                    <img
                                        src="{{ resolveDark() }}/img/icon_menu/servicestack.svg" alt="Settings"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ route('service.index') }}"
                                   class="iq-waves-effect menutext">{{ __('app.service.service') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom clearfix"></div>

                    <div class="row justify-content-center p-0 m-0 py-3 item-menu {{ $_SERVER['REQUEST_URI'] == '/settings/translations' ? 'active' : '' }}">
                        <div class="col-12 justify-content-center">
                            <div class="iq-product-cover d-flex justify-content-center">
                                <a href="{{ url('settings/translations') }}" class="iq-waves-effect"><img
                                        src="{{ resolveDark() }}/img/icon_menu/translate.svg" alt="Reports"
                                        class="img-fluid"></a>
                            </div>
                            <div class="iq-product-cover d-flex justify-content-center"><a
                                    href="{{ url('settings/translations') }}"
                                    class="iq-waves-effect menutext">{{ __('app.side_bar.auth_control.translations') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom clearfix"></div>
                @else

                    @if (auth()->user()->type == 'subcustomer')
                        <div class="row justify-content-center p-0 m-0 py-3 item-menu">
                            <div class="col-12 justify-content-center">
                                <div class="iq-product-cover d-flex justify-content-center">
                                    <a href="{{ route('myBranches') }}" class="iq-waves-effect"><img
                                            src="{{ resolveDark() }}/img/icon_menu/package.svg" alt="product-image"
                                            class="img-fluid"></a>
                                </div>
                                <div class="iq-product-cover d-flex justify-content-center"><a
                                        href="{{ route('myBranches') }}"
                                        class="iq-waves-effect menutext">{{ __('app.saas.packages.items.active_branches') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom clearfix"></div>
                        <div class="row justify-content-center p-0 m-0 py-3 item-menu">
                            <div class="col-12 justify-content-center">

                                <div class="iq-product-cover d-flex justify-content-center">
                                    <a href="{{ route('subcustomer.settings') }}" class="iq-waves-effect"><img
                                            src="{{ resolveDark() }}/img/icon_menu/settings.svg" alt="Settings"
                                            class="img-fluid"></a>
                                </div>
                                <div class="iq-product-cover d-flex justify-content-center"><a
                                        href="{{ route('subcustomer.settings') }}"
                                        class="iq-waves-effect menutext">{{ __('app.Settings') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="border-bottom clearfix"></div>

                @else

                    <li class="iq-menu-title"><i class="ri-subtract-line"></i><span>{{ __('app.dashboard') }}</span>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="iq-waves-effect"><i
                                class="ri-home-4-line"></i><span>{{ __('app.website_name') }}</span></a>
                    </li>
                    <li>
                        <a href="#userinfo" class="iq-waves-effect collapsed" data-toggle="collapse"
                           aria-expanded="false"><i
                                class="ri-user-line"></i><span>{{ __('app.side_bar.auth_controller') }}</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="userinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            @can('list-users')
                                <li><a href="{{ route('users.index') }}"><i
                                            class="ri-profile-line"></i>{{ __('app.side_bar.auth_control.users') }}</a>
                                </li>
                            @endcan
                            @can('list-roles')
                                <li><a href="{{ route('roles.index') }}"><i
                                            class="ri-file-edit-line"></i>{{ __('app.side_bar.auth_control.roles') }}
                                    </a>
                                </li>
                            @endcan
                            @can('list-permissions')
                                <li><a href="{{ route('permissions.index') }}"><i
                                            class="ri-user-add-line"></i>{{ __('app.side_bar.auth_control.permissions') }}
                                    </a></li>
                            @endcan

                        </ul>
                    </li>

                    <li>
                        <a href="#saas" class="iq-waves-effect collapsed" data-toggle="collapse"
                           aria-expanded="false"><i
                                class="ri-pencil-ruler-line"></i><span>{{ __('app.side_bar.saas_controller') }}</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="saas" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">

                            @can('list-packages')
                                <li><a href="{{ route('packages.index') }}"><i
                                            class="ri-profile-line"></i>{{ __('app.side_bar.saas_control.packages') }}
                                    </a>
                                </li>
                            @endcan
                            @can('list-models')
                                <li><a href="{{ route('models.index') }}"><i
                                            class="ri-profile-line"></i>{{ __('app.side_bar.saas_control.models') }}</a>
                                </li>
                            @endcan
                            @can('list-features')
                                <li><a href="{{ route('features.index') }}"><i
                                            class="ri-profile-line"></i>{{ __('app.side_bar.saas_control.features') }}
                                    </a>
                                </li>
                            @endcan
                            @can('list-modelfeatures')
                                <li><a href="{{ route('modelfeatures.index') }}"><i
                                            class="ri-profile-line"></i>{{ __('app.side_bar.saas_control.modelfeatures') }}
                                    </a></li>
                            @endcan
                            <li>
                                <a href="{{ route('packageRequests.index') }}"><i
                                        class="ri-profile-line"></i>{{ __('app.side_bar.saas_control.packageRequests') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endhasrole
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
