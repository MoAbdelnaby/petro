@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.home')}}
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush



@section('content')
    <div id="content-page" class="content-page home_page" style="margin-top: -30px">
        <div class="container-fluid">
            @if(in_array('home' ,array_values($config['place']['statistics'][1])) || in_array('home' ,array_values($config['place']['chart']['dynamic_bar'])) || in_array('home' ,array_values($config['plate']['chart']['dynamic_bar'])) || in_array('home' ,Arr::flatten(array_values($config['place']['table']))) || in_array('home' ,Arr::flatten(array_values($config['plate']['table']))) || in_array('home' ,array_values($config['place']['InternetStatus'][1])))
                <div class="row">
                    <div class="col-12">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height p-0">
                            <div class="iq-card-body p-0">
                                <div class="custom-head mb-2 c-flex">
                                    <h2>{{ __('app.most_statistics') }}</h2>
{{--                                    <div class="filter-pills-cont">--}}
{{--                                        <ul class="nav nav-pills ">--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link btn btn-outline-secondary home_filter {{request('time_range') == 'year' ? 'active' : '' }}"--}}
{{--                                                   data-value="year">--}}
{{--                                                    <span class="nav-text">{{__('app.this_year')}}</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link btn btn-outline-secondary home_filter {{request('time_range') == 'month' ? 'active' : ''}}"--}}
{{--                                                   data-value="month">--}}
{{--                                                    <span class="nav-text">{{__('app.this_month')}}</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link btn btn-outline-secondary home_filter {{request('time_range') == 'last_week' ? 'active' : '' }}"--}}
{{--                                                   data-value="last_week">--}}
{{--                                                    <span class="nav-text ">{{__('app.last_week')}}</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link btn btn-outline-secondary home_filter {{request('time_range') == 'week' ? 'active' : '' }}"--}}
{{--                                                   data-value="week">--}}
{{--                                                    <span class="nav-text ">{{__('app.this_week')}}</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link btn btn-outline-secondary home_filter {{request('time_range') == 'today' ? 'active' : ''}}"--}}
{{--                                                   data-value="today">--}}
{{--                                                    <span class="nav-text font-size-sm">{{__('app.today')}}</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
                                </div>
                                @if(in_array('home' ,array_values($config['place']['InternetStatus'][1])))
                                    <div class="row pt-3 px-3 " id="sortable" data-sortable-id="0"
                                         aria-dropeffect="move">
                                        <div class="col-lg-6 col-md-6 mb-3">
                                            <div class="card text-center col-12">
                                                <div class="card-header row online">
                                                    <div class="col-4 d-flex justify-content-center align-items-center">
                                                        <img width="60"
                                                             src="{{ asset("images/online-svgrepo-com.svg") }}"
                                                             alt="">
                                                    </div>
                                                    <div
                                                        class="col-8 d-flex flex-column justify-content-center align-items-center">
                                                        <h5><b><i class="fas fa-circle"
                                                                  style="color: green"></i> {{ __('app.branch_online')  }}
                                                            </b></h5>
                                                        <h3><b>{{ $on }}</b></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="card text-center col-12">
                                                <div class="card-header row offline">
                                                    <div class="col-4 d-flex justify-content-center align-items-center">
                                                        <img width="60"
                                                             fill="red"
                                                             src="{{ asset("images/offline-svgrepo-com.svg") }}"
                                                             alt="">
                                                    </div>
                                                    <div
                                                        class="col-8 d-flex flex-column justify-content-center align-items-center">
                                                        <h5><b><i class="fas fa-circle"
                                                                  style="color: red"></i> {{ __('app.branch_offline') }}
                                                            </b></h5>
                                                        <h3><b>{{ $off }}</b></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(in_array('home' ,array_values($config['place']['statistics'][1])))
                                    <div class="row px-3" id="statistic">
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{route('customerRegions.index')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.Regions') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle iq-card-icon iq-bg-primary  mr-2">
                                                                <i class="fa-solid fa-location-dot"></i></div>
                                                            <h3>{{$statistics['regions']}}</h3>
                                                        </div>
                                                        <div
                                                            class="iq-map text-primary font-size-32">
                                                            <i class="ri-bar-chart-grouped-line"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{route('customerBranches.index')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.Branches') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle iq-card-icon iq-bg-danger mr-2">
                                                                <i class="fa-solid fa-code-branch"></i>
                                                            </div>
                                                            <h3>{{$statistics['active_branches']}}</h3>
                                                            <h4>&nbsp;({{$statistics['branches']??0}})</h4>
                                                        </div>
                                                        <div
                                                            class="iq-map text-danger font-size-32">
                                                            <i class="ri-bar-chart-grouped-line"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{url('customer/customerPackages')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.Models') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle iq-card-icon iq-bg-warning mr-2">
                                                                <i class="fa-solid fa-server"></i></div>
                                                            <h3>2</h3>
                                                        </div>
                                                        <div
                                                            class="iq-map text-warning font-size-32">
                                                            <i class="ri-bar-chart-grouped-line"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{route('customerUsers.index')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.Users') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle iq-card-icon iq-bg-info mr-2">
                                                                <i class="fa fa-users"></i></div>
                                                            <h3>{{$statistics['users']}}</h3></div>
                                                        <div class="iq-map text-info font-size-32">
                                                            <i class="ri-bar-chart-grouped-line"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{route('reports.show','invoice')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.staying_car_average') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle iq-card-icon iq-bg-primary  mr-2">
                                                                <i class="fa fa-clock-o"></i></div>
                                                            <h3>{{$statistics['serving']??0}}</h3>&nbsp;<h4>@lang('app.minute')</h4>
                                                        </div>
                                                        <div
                                                            class="iq-map text-primary font-size-32">
                                                            <i class="ri-bar-chart-grouped-line"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{route('reports.show','plate')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.Car_Count') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle iq-card-icon iq-bg-info mr-2">
                                                                <i class="fa fa-car"></i></div>
                                                            <h3>{{$statistics['cars']}}</h3></div>
                                                        <div class="iq-map text-info font-size-32">
                                                            <i class="ri-bar-chart-grouped-line"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{route('reports.show','backout')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.backout') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle iq-card-icon iq-bg-danger mr-2">
                                                                <i class="fas fa-file-excel text-danger"></i></div>
                                                            <h3>{{$statistics['backout']}}</h3></div>
                                                        <div
                                                            class="iq-map text-danger font-size-32">
                                                            <i class="ri-bar-chart-grouped-line"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                <a href="{{route('reports.show','invoice')}}" class="iq-card-body"
                                                   style="padding: 25px 20px !important;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class='iq-card-title'>{{ __('app.Invoice') }}</h6>
                                                    </div>
                                                    <div
                                                        class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle iq-card-icon  mr-2" style="background: #00ff9e29">
                                                                <i class="fa fa-file-text text-success"></i>
                                                            </div>
                                                            <h3>{{$statistics['invoice']}}</h3>
                                                        </div>
                                                        <div
                                                            class="iq-map text-warning font-size-32">
                                                            <i class="ri-bar-chart-grouped-line text-success"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height p-0">
                            <div class="iq-card-body p-0">
                                <div class="related-heading mb-5 c-flex">
                                    <h2 class="">{{ __('app.Car_Plate_Report') }}</h2>
                                    <div class="duration-cont">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
                                                <defs/>
                                                <g id="Stockholm-icons-/-Home-/-Timer" stroke="none" stroke-width="1"
                                                   fill="none" fill-rule="evenodd">
                                                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                    <path
                                                        d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                        id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                    <path
                                                        d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                        id="Path-107" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </i>
                                        <div class="duration mr-4">
                                            <p>
                                                <b>{{ __('app.from') }} : </b>
                                                {{request('start')??now()->startOfYear()->toDateString()}}
                                            </p>
                                            <i>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <defs/>
                                                    <g id="Stockholm-icons-/-Home-/-Timer" stroke="none"
                                                       stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                            id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                        <path
                                                            d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                            id="Path-107" fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </i>
                                            <p>
                                                <b>{{ __('app.to') }} : </b>
                                                {{request('end')??now()->toDateString()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 mb-5" id="BranchPlateBarCon" style="display: none">
                                <div id="BranchPlateBar" class="chartDiv" style="min-height: 450px"></div>
                            </div>
                            <div class="pt-4 mb-5" id="BranchPlateLineCon" style="display: none">
                                <div id="BranchPlateLine" class="chartDiv" style="min-height: 450px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height p-0">
                            <div class="iq-card-body p-0">
                                <div class="related-heading mb-5 c-flex">
                                    <h2 class="">{{ __('app.Bay_area_report') }}</h2>
                                    <div class="duration-cont">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
                                                <defs/>
                                                <g id="Stockholm-icons-/-Home-/-Timer" stroke="none" stroke-width="1"
                                                   fill="none" fill-rule="evenodd">
                                                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                    <path
                                                        d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                        id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                    <path
                                                        d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                        id="Path-107" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </i>
                                        <div class="duration mr-4">
                                            <p>
                                                <b>{{ __('app.from') }} : </b>
                                                {{request('start')??now()->startOfYear()->toDateString()}}
                                            </p>
                                            <i>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px"
                                                     viewBox="0 0 24 24" version="1.1">
                                                    <defs/>
                                                    <g id="Stockholm-icons-/-Home-/-Timer" stroke="none"
                                                       stroke-width="1"
                                                       fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                            id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                        <path
                                                            d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                            id="Path-107" fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </i>
                                            <p>
                                                <b>{{ __('app.to') }} : </b>
                                                {{request('end')??now()->toDateString()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 mb-5" id="BranchPlaceBarCon" style="display: none">
                                    <div id="BranchPlaceBar" class="chartDiv" style="min-height: 450px"></div>
                                </div>
                                <div class="pt-4 mb-5" id="BranchPlaceLineCon" style="display: none">
                                    <div id="BranchPlaceLine" class="chartDiv" style="min-height: 450px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height p-0">
                            <div class="iq-card-body p-0">
                                <div class="related-heading mb-5 c-flex">
                                    <h2 class="">{{ __('app.Staying_report') }}</h2>
                                    <div class="duration-cont">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
                                                <defs/>
                                                <g id="Stockholm-icons-/-Home-/-Timer" stroke="none" stroke-width="1"
                                                   fill="none" fill-rule="evenodd">
                                                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                    <path
                                                        d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                        id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                    <path
                                                        d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                        id="Path-107" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </i>
                                        <div class="duration mr-4">
                                            <p>
                                                <b>{{ __('app.from') }} : </b>
                                                {{request('start')??now()->startOfYear()->toDateString()}}
                                            </p>
                                            <i>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px"
                                                     viewBox="0 0 24 24" version="1.1">
                                                    <defs/>
                                                    <g id="Stockholm-icons-/-Home-/-Timer" stroke="none"
                                                       stroke-width="1"
                                                       fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                            id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                        <path
                                                            d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                            id="Path-107" fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </i>
                                            <p>
                                                <b>{{ __('app.to') }} : </b>
                                                {{request('end')??now()->toDateString()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 mb-5" id="BranchStayingBarCon" style="display: none">
                                <div id="BranchStayingBar" class="chartDiv" style="min-height: 450px"></div>
                            </div>
                            <div class="pt-4 mb-5" id="BranchStayingSideBarCon" style="display: none">
                                <div id="BranchStayingSideBar" class="chartDiv" style="min-height: 450px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height p-0">
                            <div class="iq-card-body p-0">
                                <div class="related-heading mb-5 c-flex">
                                    <h2 class="">{{ __('app.Invoice_report') }}</h2>
                                    <div class="duration-cont">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
                                                <defs/>
                                                <g id="Stockholm-icons-/-Home-/-Timer" stroke="none" stroke-width="1"
                                                   fill="none" fill-rule="evenodd">
                                                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                    <path
                                                        d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                        id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                    <path
                                                        d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                        id="Combined-Shape" fill="#000000"/>
                                                    <path
                                                        d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                        id="Path-107" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </i>
                                        <div class="duration mr-4">
                                            <p>
                                                <b>{{ __('app.from') }} : </b>
                                                {{request('start')??now()->startOfYear()->toDateString()}}
                                            </p>
                                            <i>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px"
                                                     viewBox="0 0 24 24" version="1.1">
                                                    <defs/>
                                                    <g id="Stockholm-icons-/-Home-/-Timer" stroke="none"
                                                       stroke-width="1"
                                                       fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                            id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                        <path
                                                            d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                            id="Combined-Shape" fill="#000000"/>
                                                        <path
                                                            d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                            id="Path-107" fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </i>
                                            <p>
                                                <b>{{ __('app.to') }} : </b>
                                                {{request('end')??now()->toDateString()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 mb-5" id="BranchInvoiceBarCon" style="display: none">
                                <div id="BranchInvoiceBar" class="chartDiv" style="min-height: 450px"></div>
                            </div>
                            <div class="pt-4 mb-5" id="BranchInvoiceLineCon" style="display: none">
                                <div id="BranchInvoiceLine" class="chartDiv" style="min-height: 450px"></div>
                            </div>
                        </div>
                    </div>
                </div>


        </div>
        @else
            <div class="nothingtoshoehere">
                @if (session()->has('darkMode'))
                    <img alt="Logo" src="{{url('/images')}}/wakeball/wakebwhite.png" class="img-fluid mainlogo mb-3"
                         width="150" alt="" style=""/>
                @else
                    <img src="{{url('/images')}}/wakeball/wakebdark.png" class="img-fluid mainlogo  mb-3"
                         width="150" alt="" style="">
                @endif
                <h2>{{ __('app.No_Thing_TO_Show_Here') }}</h2>
                <p>{{ __('app.No_thing_to_paragraph') }}</p>
                <a href="{{ route('config.index', 'place') }}" class="btn btn-info">{{ __('app.config') }}</a>
            </div>
        @endif
    </div>
@endsection
@php $key_name = 'home'; @endphp

@section('scripts')
    <script src="{{asset('js/report/report.js')}}"></script>
    <script>
        $(".home_filter").on('click', function (e) {
            e.preventDefault();
            let time_range = $(this).data("value")
            let url = '{{url('/customerhome')}}';
            let inputs = [];
            inputs += `<input name="time_range" value=${time_range} >`;

            $(`<form action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
        });

        var imageAddr = "/images/to-download.jpg";
        var downloadSize = 2936012.8; //bytes
        function ShowProgressMessage(msg) {
            if (console) {
                if (typeof msg == "string") {
                    console.log(msg);
                } else {
                    for (var i = 0; i < msg.length; i++) {
                        console.log(msg[i]);
                    }
                }
            }
        }

        function InitiateSpeedDetection() {
            console.log('InitiateSpeedDetection')
            ShowProgressMessage("Loading the image, please wait...");
            window.setTimeout(MeasureConnectionSpeed, 1);
        };

        if (window.addEventListener) {
            window.addEventListener('load', InitiateSpeedDetection, false);
        } else if (window.attachEvent) {
            window.attachEvent('onload', InitiateSpeedDetection);
        }

        function MeasureConnectionSpeed() {
            var startTime, endTime;
            var download = new Image();
            download.onload = function () {
                endTime = (new Date()).getTime();
                showResults();
            }
            download.onerror = function (err, msg) {
                ShowProgressMessage("Invalid image, or error downloading");
            }
            startTime = (new Date()).getTime();
            var cacheBuster = "?nnn=" + startTime;
            download.src = imageAddr + cacheBuster;

            function showResults() {
                var duration = (endTime - startTime) / 1000;
                var bitsLoaded = downloadSize * 8;
                var speedBps = (bitsLoaded / duration).toFixed(2);
                var speedKbps = (speedBps / 1024).toFixed(2);
                var speedMbps = (speedKbps / 1024).toFixed(2);
                ShowProgressMessage([
                    "Your connection speed is:",
                    speedBps + " bps",
                    speedKbps + " kbps",
                    speedMbps + " Mbps"
                ]);

                axios.post('/connection-speed', {
                    internet_speed: speedMbps
                })
            }
        }

        $(document).ready(function () {
            let place = @json($report['place']['charts']);
            let plate = @json($report['plate']['charts']);
            let staying = @json($report['stayingAverage']['charts']);
            let invoice = @json($report['invoice']['charts']);
            let place_info = @json($report['place']['info']);
            let plate_info = @json($report['plate']['info']);
            let staying_info = @json($report['stayingAverage']['info']);
            let invoice_info = @json($report['invoice']['info']);

            /************* Start Bar Chart ****************/
            @if(in_array($key_name ,array_values($config['place']['chart']['bar'])))
            @if(count($report['place']['charts']))
            $("#BranchPlaceBarCon").show();
            barChart('BranchPlaceBar', place.bar, place_info);
            @endif
            @endif
            /**************** End Bar Chart****************/

            /**************** Start Line Chart ************/
            @if(in_array($key_name ,array_values($config['place']['chart']['line'])))
            @if(count($report['place']['charts']))
            $("#BranchPlaceLineCon").show();
            lineChart('BranchPlaceLine', place.bar, place_info);
            @endif
            @endif
            /************** End Line Chart ************/

            /************* Start Bar Chart ****************/
            @if(in_array($key_name ,array_values($config['plate']['chart']['bar'])))
            @if(count($report['plate']['charts']))
            $("#BranchPlateBarCon").show();
            barChart('BranchPlateBar', plate.bar, plate_info);
            @endif
            @endif
            /**************** End Bar Chart****************/

            /**************** Start Line Chart ************/
            @if(in_array($key_name ,array_values($config['plate']['chart']['line'])))
            @if(count($report['plate']['charts']))
            $("#BranchPlateLineCon").show();
            lineChart('BranchPlateLine', plate.bar, plate_info);
            @endif
            @endif
            /************** End Line Chart ************/

            /************* Start Bar Chart ****************/
            @if(count($report['stayingAverage']['charts']))
            $("#BranchStayingBarCon").show();
            barChart('BranchStayingBar', staying.bar, staying_info);
            @endif
            /**************** End Bar Chart****************/

            /**************** Start SideBar Chart ************/
            @if(count($report['stayingAverage']['charts']))
            $("#BranchStayingSideBarCon").show();
            sideBarChart('BranchStayingSideBar', staying.bar, staying_info);
            @endif
            /************** End SideBar Chart ************/

            /************* Start Bar Chart ****************/
            @if(count($report['invoice']['charts']))
            $("#BranchInvoiceBarCon").show();
            barChart('BranchInvoiceBar', invoice.bar, invoice_info);
            @endif
            /**************** End Bar Chart****************/

            /**************** Start Line Chart ************/
            @if(count($report['invoice']['charts']))
            $("#BranchInvoiceLineCon").show();
            lineChart('BranchInvoiceLine', invoice.bar, invoice_info);
            @endif
            /************** End Line Chart ************/

        });
    </script>
@endsection
