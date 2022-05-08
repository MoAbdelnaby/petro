<!-- TOP Nav Bar -->
<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <div class="iq-sidebar-logo">
            <div class="top-logo">
                <a href="{{route('home')}}" class="logo">
                    <img src="{{url('/images')}}/wakeb.png" class="img-fluid" alt="">
                    <span>{{__('app.website_name')}}</span>
                </a>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light p-0 allshadow">
            {{--            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">--}}
            {{--                <i class="ri-menu-3-line"></i>--}}
            {{--            </button>--}}
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
                    <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
                </div>
            </div>
            <div class=" navbar" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto navbar-list">
                    <li>
                        <a class="wrapper-menu">
                            <i class="fas fa-bars" style="display: none"></i>
                            {{--                            <i class="fas fa-close" style="display: none"></i>--}}
                            <i class="fas fa-indent"></i>
                        </a>
                    </li>
                    <li class="nav-item navDark">
                        @if(session()->has('darkMode'))
                            <a href="{{ route('dark',['off']) }}" class="text-white" data-toggle="tooltip"
                               data-placement="top" title="" data-original-title="{{__('app.Default')}}">
                                <i class="fas fa-sun"></i>
                            </a>
                        @else
                            <a href="{{ route('dark',['on']) }}" data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="{{__('app.Dark')}}">
                                <i class="fas fa-moon"></i>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if(str_replace('_', '-', app()->getLocale())=='en')
                            <a class="language-title {{session()->has('darkMode') ? 'whitetext':''}}"
                               href="{{route('select','ar')}}" data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="{{__('app.Arabic')}}">
                                <i class="fas fa-language"></i>
                                <small>{{ __('app.ar') }}</small>
                            </a>
                        @else
                            <a class="language-title {{session()->has('darkMode') ? 'whitetext':''}}"
                               href="{{route('select','en')}}" data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="{{__('app.English')}}">
                                <i class="fas fa-language"></i>
                                <small>{{ __('app.en') }}</small>
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
            <ul class="navbar-list">
                <li class="nav-item mr-1">
                    <a href="#" class="search-toggle iq-waves-effect" data-toggle="tooltip" data-placement="top"
                       title="" data-original-title="{{__('app.gym.Notifications')}}">
                        @if(count($oldRequest))
                            <div id="lottie-beil"></div>
                            <span class="bg-danger dots"></span>
                        @else
                            <i class="far fa-bell" style="font-size: 14px"></i>
                        @endif
                    </a>
                    <div class="iq-sub-dropdown">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0 ">
                                <div class="bg-primary">
                                    <h5 class="mb-0 text-white">{{ __('app.All_notification') }}
                                        <small
                                            class="badge  badge-light float-right pt-1">{{count(Auth::user()->notifications)}}</small>
                                    </h5>
                                </div>
                                @foreach(Auth::user()->notifications->take(5) as $notification)
                                    <span class="iq-sub-card notify{{$notification->id}}" id="row{{$notification->id}}">
                                        <div class="media align-items-center">
                                            <div class="">
                                                <img class="avatar-40" src="{{url('/')}}/images/user/1.jpg" alt="">
                                            </div>
                                            <div class="media-body ml-3">
                                                 @if($notification->data['come_from'] == 'status_of_branch')
                                                    <p>Branch {{$notification->data['branch_name']??''}} which code is {{$notification->data['branch_code']??''}} has been offline <br><button
                                                            class="btn btn-sm btn-primary notificationEscalation"
                                                            data-id="{{$notification->data['escalation_branch_id']??0}}">take Action</button></p>
                                                @else
                                                    <h6 class="mb-0 ">{{ __('app.'.$notification->data['message']) }} {{ __('app.created_by') }} {{$notification->data['created_by']}} </h6>
                                                    @if($notification->data['come_from'] == 'add_branch')
                                                        <small>{{ __('app.branch_name_is') }} : {{ $notification->data['branch_name'] }}</small>
                                                        <small>{{ __('app.branch_code_is') }} : {{ $notification->data['branch_code'] }}</small>
                                                        <small>{{ __('app.region_name_is') }} : {{ $notification->data['region_name'] }}</small>
                                                    @endif
                                                    @if($notification->data['come_from'] == 'add_region')
                                                        <small>{{ __('app.region_name_is') }} : {{ $notification->data['region_name'] }}</small>
                                                    @endif
                                                @endif
                                                <small
                                                    class="float-right font-size-12">{{$notification->created_at->diffForHumans()}}</small>
                                            </div>
                                        </div>
                                    </span>
                                @endforeach
                                <a href="{{ route("notfication") }}" class="text-center">{{ __('app.show_all') }}</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="user-settings">
                    <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                        <img
                            src="{{auth()->user()->avatar ? url('storage/'.auth()->user()->avatar) : url('/images/user/1.jpg') }}"
                            class="img-fluid rounded mr-3" alt="user">
                        <div class="caption">
                            <h6 class="mb-0 line-height">{{auth()->user()->name}}</h6>
                            <span class="font-size-12">{{ __('app.Available') }}</span>
                        </div>
                    </a>
                    <div class="iq-sub-dropdown iq-user-dropdown">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-1">
                                    <h5 class="mb-0 text-white ">{{auth()->user()->name}}</h5>
                                </div>
                                <a href="{{route('users.profile')}}" class="iq-sub-card iq-bg-primary-hover">
                                    <h6 class=""><i class="ri-file-user-line"></i> {{ __('app.profile') }}</h6>
                                </a>
                                <a href="{{route('users.changepassword',[auth()->user()->id])}}"
                                   class="iq-sub-card iq-bg-primary-hover">
                                    <h6 class=""><i class="ri-profile-line"></i> {{ __('app.change_password') }}</h6>
                                </a>

                                <div class="w-100 p-0">
                                    <a class="iq-sub-card iq-bg-primary-hover border-0" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                       role="button">
                                        <h6><i class="ri-login-box-line"></i> {{__('app.auth.Logout')}}</h6>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>


    </div>
</div>
<!-- TOP Nav Bar END -->

@push('js')
    <script>
        $(".notificationEscalation").on('click', function (e) {
            e.preventDefault();
            let url = '{{route('escalations.updateStatus')}}';
            let escalation_branch_id = $(this).data('id');
            let token = '{{csrf_token()}}';

            let inputs = `<input name="_token" value=${token}>`;
            inputs += `<input type="hidden" name="escalation_branch_id" value="${escalation_branch_id}">`;
            inputs += `<input type="hidden" name="_method" value="PUT">`;

            $(`<form method="post" action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
        });
    </script>
@endpush
