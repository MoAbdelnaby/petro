<div id="sidebar" class="app-sidebar">

    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">

        <div class="menu">
            <div class="menu-header">Navigation</div>

            @hasrole('customer')
            @if (auth()->user()->type != 'subcustomer')
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/customerhome' ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-cpu"></i></span>
                    <span class="menu-text">{{ __('app.website_name') }}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/customer/map' ? 'active' : '' }}">
                <a href="{{ route('map.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span class="menu-text">{{ __('app.Map') }}</span>
                </a>
            </div>
            @can('list-mypackages')
            <div class="menu-item">
                <a href="{{ route('customerPackages.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-eye"></i></span>
                    <span class="menu-text">{{ __('app.side_bar.customers.mymodels') }}</span>
                </a>
            </div>
            @endcan
            @can('list-CustomerUsers')
                <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/customer/customerUsers' ? 'active' : '' }}">
                    <a href="{{ route('customerUsers.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="fas fa-users"></i></span>
                        <span class="menu-text">{{ __('app.side_bar.auth_control.users') }}</span>
                    </a>
                </div>
            @endcan
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/customer/reports' ? 'active' : '' }}">
                <a href="{{ route('customerUsers.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-chart-pie"></i></span>
                    <span class="menu-text">{{ __('app.Reports') }}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/branches-status' ? 'active' : '' }}">
                <a href="{{ route('branches_status') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-code-branch"></i></span>
                    <span class="menu-text">{{ __('app.branchStatus') }}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/customer/config/place/get' ? 'active' : '' }}">
                <a href="{{ route('config.index', 'place') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-cogs"></i></span>
                    <span class="menu-text">{{ __('app.config') }}</span>
                </a>
            </div>
            @can('list-CustomerUsers')
                <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/customer/activities' ? 'active' : '' }}">
                    <a href="{{ route('activities.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="fas fa-arrows-alt"></i></span>
                        <span class="menu-text">{{ __('app.side_bar.auth_control.activities') }}</span>
                    </a>
                </div>
            @endcan
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/settings/reminder' ? 'active' : '' }}">
                <a href="{{ route('setting.reminder') }}" class="menu-link">
                    <span class="menu-icon"><i class="far fa-fw fa-sun"></i></span>
                    <span class="menu-text">{{ __('app.Settings') }}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/connection-speed' ? 'active' : '' }}">
                <a href="{{ route('connection-speed.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-wifi"></i></span>
                    <span class="menu-text">{{ __('app.Connections') }}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == "/branches/register" ? 'active': ''}}">
                <a href="{{route('branch.register')}}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-building"></i></span>
                    <span class="menu-text">{{__('app.customers.speed.registerBranch.page_title')}}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/branches/message-log' ? 'active' : '' }}">
                <a href="{{ route('branch.message_log') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-paper-plane"></i></span>
                    <span class="menu-text">{{ __('app.branch_message') }}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/services' ? 'active' : '' }}">
                <a href="{{ route('service.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fab fa-fw fa-servicestack"></i></span>
                    <span class="menu-text">{{ __('app.service.service') }}</span>
                </a>
            </div>
            <div class="menu-item {{ $_SERVER['REQUEST_URI'] == '/settings/translations' ? 'active' : '' }}">
                <a href="{{ url('settings/translations') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-fw fa-language"></i></span>
                    <span class="menu-text">{{ __('app.side_bar.auth_control.translations') }}</span>
                </a>
            </div>        
            @else

                @if (auth()->user()->type == 'subcustomer')
                    <div class="menu-item">
                        <a href="{{ route('myBranches') }}" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-fw fa-code-branch"></i></span>
                            <span class="menu-text">{{ __('app.saas.packages.items.active_branches') }}</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('subcustomer.settings') }}" class="menu-link">
                            <span class="menu-icon"><i class="far fa-fw fa-sun"></i></span>
                            <span class="menu-text">{{ __('app.Settings') }}</span>
                        </a>
                    </div>
                @endif
            @endif

            @else
                <div class="menu-item">
                    <i class="ri-subtract-line"></i><span>{{ __('app.dashboard') }}</span>
                </div>

                <div class="menu-item">
                    <a href="{{ route('home') }}" class="menu-link">
                        <span class="menu-icon"><i class="far fa-fw fa-sun"></i></span>
                        <span class="menu-text">{{ __('app.website_name') }}</span>
                    </a>
                </div>
                <div class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">
                        <i class="bi bi-envelope"></i>
                        </span>
                        <span class="menu-text">{{ __('app.side_bar.auth_controller') }}</span>
                        <span class="menu-caret"><b class="caret"></b></span>
                    </a>
                    <div class="menu-submenu" style="display: block;">
                        @can('list-users')                        
                        <div class="menu-item">
                            <a href="{{ route('users.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.auth_control.users') }}</span>
                            </a>
                        </div>
                        @endcan
                        @can('list-roles')
                        <div class="menu-item">
                            <a href="{{ route('roles.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.auth_control.roles') }}</span>
                            </a>
                        </div>
                        @endcan
                        @can('list-permissions')
                        <div class="menu-item">
                            <a href="{{ route('permissions.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.auth_control.permissions') }}</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">
                        <i class="bi bi-envelope"></i>
                        </span>
                        <span class="menu-text">{{ __('app.side_bar.saas_controller') }}</span>
                        <span class="menu-caret"><b class="caret"></b></span>
                    </a>
                    <div class="menu-submenu" style="display: block;">
                        @can('list-packages')                        
                        <div class="menu-item">
                            <a href="{{ route('packages.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.saas_control.packages') }}</span>
                            </a>
                        </div>
                        @endcan
                        @can('list-models')
                        <div class="menu-item">
                            <a href="{{ route('models.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.saas_control.models') }}</span>
                            </a>
                        </div>
                        @endcan
                        @can('list-features')
                        <div class="menu-item">
                            <a href="{{ route('features.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.saas_control.features') }}</span>
                            </a>
                        </div>
                        @endcan
                        @can('list-modelfeatures')
                        <div class="menu-item">
                            <a href="{{ route('modelfeatures.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.saas_control.modelfeatures') }}</span>
                            </a>
                        </div>
                        @endcan
                        <div class="menu-item">
                            <a href="{{ route('packageRequests.index') }}" class="menu-link">
                                <span class="menu-text">{{ __('app.side_bar.saas_control.packageRequests') }}</span>
                            </a>
                        </div>
                        
                    </div>
                </div>

            @endhasrole

        </div>
    </div>

</div>


{{-- <button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button> --}}
