@extends('layouts.gym.index')
@section('page_title')
    {{__('app.gym.places_maintenence')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(Session::has('branch_file'))
        <meta http-equiv="refresh" content="5;url={{ Session::get('branch_file') }}">
    @endif
@endsection
@section('content')
    <!-- Start Header -->
    <div class="header">
        <div class="text-center main-logo">
            <a href="#" class="logo-m">
                <img src="{{resolveDark()}}/img/Group 5928.png" class="image mb-4 mt-4 mx-auto"
                     style="width: 170px">
            </a>
            <span><img src="{{resolveDark()}}/img/list.png" alt=""></span>
        </div>
        <!-- //////////// -->
        <ul class="branch branch-2nd nav nav-pills scroll-horizontal search_branch-ul top " id="pills-tab" role="tablist">
            {{--          <li class="nav-item" style="width: 445px;">--}}
            {{--                <a class="nav-link active" id="pills-home-tab"  href="{{route('places.index',[$usermodelbranchid])}}" aria-controls="pills-home" aria-selected="true">--}}
            {{--                    <img src="{{resolveDark()}}/img/icon-location.svg" alt="">--}}
            {{--               <span class="ml-1"> {{$usermodelbranch->branch->name}}</span></a>--}}
            <div class="scroll-horizontal--elm-cont" id='li-branches'>
                @foreach ($final_branches as $branch)
                    @php
                        $branch = (object)$branch;
                    @endphp
                    <li class="nav-item" data-bName='{{$branch->name}}'>
                        <a class="nav-link {{$branch->name == $usermodelbranch->branch->name ? 'active':''}}"
                           id="pills-home-tab" href="{{route('modelbranchpreview',[$branch->user_model_branch_id])}}"
                           aria-controls="pills-home" aria-selected="true">
                            {{-- <img src="{{resolveDark()}}/img/icon-location.svg" alt=""> --}}
                            <img
                                src="{{$branch->name == $usermodelbranch->branch->name ? url('/gym_dark'):(session()->has('darkMode') ?url('/gym_dark'):url('/gym'))}}/img/icon-location.svg"
                                alt=""
                            >
                            <span class="ml-1"> {{$branch->name}}</span></a>
                    </li>
                @endforeach
                    <li class="nav-item no_data hide">
                            <a href="javascript:void(0);" class="nav-link">
                                 {{__('app.no_data')}}
                            </a>
                    </li>

            </div>
        </ul>
        <ul class="model nav nav-pills scroll-vertical-custom" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-profile-tab" href="{{route('places.index',[$usermodelbranchid])}}"
                   role="tab" aria-controls="pills-profile" aria-selected="false">
                    <img src="{{url('/gym_dark')}}/img/Icon-area-1.svg" alt="Area-1" height="35px">
                    <span class="ml-1">{{__('app.gym.places_maintenence')}}</span>
                </a>
            </li>
        </ul>
        <div id="back" class='top'>
            <div class="backdash">
                <a href="{{route('home')}}"> <i class="fa fa-home"></i></a>
            </div>
        </div>
        <div class="search-cont top dropright">
            <button class='btn btn-icon ' data-toggle="dropdown" aria-expanded="false"><i class="fas fa-search"></i></button>
            <div class="dropdown-menu">
                <input autofocus type="text" class="form-control " aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-sm" placeholder="{{__('app.branch_search')}}" id="branch_search">
            </div>
        </div>
{{--        <div class="duration-ration-cont top">--}}
{{--            <p><b>@lang('app.staying_car_average') : </b> 15 minute</p>--}}
{{--        </div>--}}
        <div id="logout" class="top">
            <span class="close-setting" style="cursor: pointer;">
                <i class="fas fa-sign-out-alt"></i>
{{--                {{__('app.gym.Logout')}}--}}
            </span>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="text-center page-logo">
            <a href="{{route('home')}}" class="logo-m"><img src="{{resolveDark()}}/img/Group 5928.png"
                                                            class="image mb-4 mt-4 mx-auto" style="width: 170px"></a>
        </div>


        <div class="tab-content mt-1" id="pills-tabContent">


            <!-- Start one tabe-->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="open-door">
                    <div class="container">
                        <div class="row {{ $data ? 'right-100':'' }} left-100">
                            <div class="col-lg-3 setting-col">
                                <span class="setting-icon-sho ">
                                    <i class="fas fa-cog fa-spin"></i>
                                </span>
                                <span class="files-icon-sho ">
                                    <a title="prepared files" alt="prepared files" href="{{route('branchmodelpreview.files.index',[$usermodelbranch->branch_id,$usermodelbranchid])}}" class="text-white">
                                    <i class="far fa-file-alt"></i>
                                        <p style="display: none;">{{ __('app.prepared_files') }}</p>
                                    </a>
                                </span>
                                <div class="setting">
                                    <img src="{{resolveDark()}}/img/Group 5933.png" class="up">
                                    <img src="{{resolveDark()}}/img/Group 5931.png" class="down">

                                    <div class="card">
                                        <div class="card-body">
                                            <h6>{{__('app.gym.settings')}}</h6>
                                            <small>{{__('app.gym.Control_Settings')}}</small>
                                            <form method="POST" class="text-center onemaincolor"
                                                  action="{{ route('places.placesshiftsetting',[$usermodelbranchid]) }}">
                                                @csrf
                                                <div class="form-group input-group input-daterange">
                                                    <div class="row col-12 p-0 m-0">
                                                        <p class="col">{{__('app.gym.Start_Date')}}</p>
                                                        <p class="col">{{__('app.gym.End_Date')}}</p>
                                                    </div>
                                                    <input type="date"
                                                           value="{{old('start_date') ?old('start_date'):$lastsetting->start_date}}"
                                                           name="start_date" class="form-control" x-webkit-speech>
                                                    <div class="input-group-addon">
                                                        <small>{{ __('app.TO') }}</small>
                                                        <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                                                    </div>
                                                    <input type="date"
                                                           value="{{old('end_date') ?old('end_date'):$lastsetting->end_date}}"
                                                           name="end_date" class="form-control" x-webkit-speech>
                                                </div>


                                                <div class="form-group input-group input-daterange">
                                                    <div class="row col-12 p-0 m-0">
                                                        <p class="col">{{__('app.gym.Start_Time')}}</p>
                                                        <p class="col">{{__('app.gym.End_Time')}}</p>
                                                    </div>
                                                    <input type="time"
                                                           value="{{old('start_time') ?old('start_time'):$lastsetting->start_time}}"
                                                           name="start_time" class="form-control">
                                                    <div class="input-group-addon">
                                                        <small>{{ __('app.TO') }}</small>
                                                        <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                                                    </div>
                                                    <input type="time"
                                                           value="{{old('end_time') ?old('end_time'):$lastsetting->end_time}}"
                                                           name="end_time" class="form-control">
                                                </div>



                                                <div class="row">
                                                    <div class="col text-center">
                                                        <div class="switch_box box_1">
                                                            <p class="notifi onemaincolor">{{__('app.gym.Notifications')}}</p>
                                                            <input type="checkbox" id="notification" name="notification"
                                                                   class="switch_1" {{$lastsetting->notification=='1'?'checked':''}} >
                                                        </div>
                                                    </div>
                                                    <div class="col text-center">
                                                        <div class="switch_box box_1">
                                                            <p class="screen onemaincolor">{{__('app.gym.Screenshots')}}</p>
                                                            <input type="checkbox" name="screenshot"
                                                                   class="switch_1" {{$lastsetting->screenshot=='1'?'checked':''}} >
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group input-group input-daterange" id="notifytime">
                                                    <div class="row col-12 p-0 m-0">
                                                        <p class="col">{{__('app.gym.Start_Time')}}</p>
                                                        <p class="col">{{__('app.gym.End_Time')}}</p>
                                                    </div>
                                                    <input type="time"
                                                           value="{{old('notification_start') ?old('notification_start'):$lastsetting->notification_start}}"
                                                           name="notification_start" class="form-control">
                                                    <div class="input-group-addon">
                                                        <small>{{ __('app.TO') }}</small>
                                                        <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                                                    </div>
                                                    <input type="time"
                                                           value="{{old('notification_end') ?old('notification_end'):$lastsetting->notification_end}}"
                                                           name="notification_end" class="form-control">
                                                </div>

                                                <div class="text-center" >
                                                    <button type="submit "
                                                            class="btn close-setting mt-0">{{__('app.gym.Save')}}</button>
                                                </div>
                                            </form>

                                            <div class="bor"></div>
                                            <small>{{__('app.gym.Export_Settings')}}</small>
                                            <form method="GET" class="text-center onemaincolor" id="doorform"
                                                  action="{{ route('places.placesfilter',[$usermodelbranchid]) }}">
                                                @csrf


                                                <div class="form-group input-group input-daterange">
                                                    <div class="row col-12 p-0 m-0">
                                                        <p class="col">{{__('app.gym.Start_Date')}}</p>
                                                        <p class="col">{{__('app.gym.End_Date')}}</p>
                                                    </div>
                                                    <input type="date" value="{{old('start') ?old('start'):$start}}"
                                                           id="searchStart" name="start" class="form-control"
                                                           required x-webkit-speech>
                                                    <div class="input-group-addon">
                                                        <small>{{ __('app.TO') }}</small>
                                                        <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                                                    </div>
                                                    <input type="date" id="searchEnd"
                                                           value="{{old('end') ?old('end'):$end}}" name="end"
                                                           required class="form-control" x-webkit-speech>
                                                </div>


                                                <input type="hidden" value="1" name="submittype">
                                                <div>
                                                    <p>{{ __('app.File_Format') }}</p>
                                                    <select class="form-control" name="exportType" style="cursor: pointer">
                                                        <option value="" selected>{{ __('app.Select_File_Format') }}</option>
                                                        <option value="2" id="excel" >
                                                            {{__('app.gym.EXCEL')}}
                                                        </option>
                                                        <option value="1" id="pdf">
                                                            {{__('app.gym.PDF')}}
                                                        </option>
                                                    </select>
                                                </div>
                                                <br>
                                                <div class="d-flex justify-content-center btn-cont">
                                                        <button type="button" value="1" id="searchRecord"
                                                                class="btn close-setting">{{__('app.gym.search')}}
                                                        </button>
                                                        <button type="button" class="btn export" id="export">
                                                            {{__('app.gym.Export_Data')}}
                                                        </button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row area-section slider">
                                    @foreach($areas as $key=>$area)
                                        <div class="col">
                                            <div class="door-open">
                                                <div class="card model-card">
                                                    <div class="card-body p-0">
                                                        <span class="filter-badge filter-badge-{{$key}} badge badge-pill badge-light">{{__('app.all')}}</span>
                                                    <div class="setting-card-cont dropleft ">
                                                            <a href="#"  type="button" data-toggle="dropdown" id="dropdownMenuCardSetting" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-cog"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right custom-dropdown" aria-labelledby="dropdownMenuCardSetting">
                                                                <button type="button" class="close close-1" data-dismiss="dropdown" aria-label="Close">
                                                                    <span class='close-1' aria-hidden="true">&times;</span>
                                                                </button>
                                                               <div class="">
                                                                    <h6>{{__('app.duration')}}</h6>
                                                                    <select name="filter_date" data-key="{{$key}}"
                                                                            class="filter_date custom-select">
                                                                        <option value="all">{{__('app.all')}}</option>
                                                                        <option value="today">{{__('app.today')}}</option>
                                                                        <option value="week">{{__('app.week')}}</option>
                                                                        <option value="month">{{__('app.month')}}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="time-unit mt-4">

                                                                    <h6>{{__('app.duration_time_unit')}}</h4>
                                                                    <form action="">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" data-key={{$key}} value='hours' type="radio" name="duration_unit" id="duration_hours-{{$key}}" checked>
                                                                            <label class="form-check-label"  for="duration_hours-{{$key}}">
                                                                                {{__('app.Hours')}}
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input  class="form-check-input" data-key={{$key}} value='minutes' type="radio" name="duration_unit" id="duration_minutes-{{$key}}" >
                                                                            <label class="form-check-label" for="duration_minutes-{{$key}}">
                                                                                {{__('app.Minutes')}}
                                                                            </label>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="text-center border-bottom px-2 pt-3 pb-1">
                                                            <select name="filter_date" data-key="{{$key}}"
                                                                    class="filter_date">
                                                                <option value="all">All</option>
                                                                <option value="today">Today</option>
                                                                <option value="week">Week</option>
                                                                <option value="month">Month</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="text-center border-bottom px-2 pt-3 pb-1">
                                                            @if($area['areaavailable'] && $area['areaavailable']->status==1)
                                                                <img src="{{resolveDark()}}/img/Icon-area-1.svg"
                                                                     height="62" alt="Area-1">
                                                                <div
                                                                    class="area-title mt-1">{{__('app.gym.Area')}} {{$key}}</div>
                                                                <div class="status-cont"><span
                                                                        class="area-status danger"><i></i>{{__('app.gym.Unavailable')}}</span>
                                                                </div>

                                                            @else
                                                                <img src="{{resolveDark()}}/img/Icon-area-2.svg"
                                                                     height="62" alt="Area-1">
                                                                <div
                                                                    class="area-title mt-1">{{__('app.gym.Area')}} {{$key}}</div>
                                                                <div class="status-cont"><span
                                                                        class="area-status success"><i></i>{{__('app.gym.Available')}}</span>
                                                                </div>

                                                            @endif

                                                                {{-- <div>
                                                                    <input type="button"
                                                                           class="btn btn-primary btn-sm change-btn"
                                                                           id="btn-{{$key}}" value="Change to Minutes">
                                                                </div> --}}
                                                        </div>
                                                        <div class="d-flex aligh-items-center  area-desc">
                                                            <div class="spinner-cont d-none spinner-cont-{{$key}}">
                                                                <div class="spinner-border text-primary" role="status">
                                                                    <span class="sr-only">Loading...</span>
                                                                  </div>
                                                            </div>

                                                            <div
                                                                class="div-hours-btn-{{$key}} border-right text-center p-2 w-50">
                                                                <h2>{{__('app.gym.DurationEmpty')}}</h2>
                                                                <h3 id="hours_empty_{{$key}}">{{$area['areaavildura']}}</h3>
                                                                <p>{{__('app.gym.hours')}}</p>
                                                            </div>
                                                            <div class="div-hours-btn-{{$key}} p-2 w-50 text-center">
                                                                <h2>{{__('app.gym.DurationWork')}}</h2>
                                                                <h3 id="hours_work_{{$key}}" >{{$area['areabusydura']}}</h3>
                                                                <p>{{__('app.gym.hours')}}</p>
                                                            </div>
                                                            <div
                                                                class="div-minutes-btn-{{$key}} border-right text-center p-2 w-50"
                                                                style="display: none">
                                                                <h2>{{__('app.gym.DurationEmpty')}}</h2>
                                                                <h3 id="minutes_empty_{{$key}}">{{$area['areaavildura'] * 60 }}</h3>
                                                                <p>{{__('app.gym.minutes')}}</p>
                                                            </div>
                                                            <div class="div-minutes-btn-{{$key}} p-2 w-50 text-center"
                                                                 style="display: none">
                                                                <h2>{{__('app.gym.DurationWork')}}</h2>
                                                                <h3 id="minutes_work_{{$key}}" >{{$area['areabusydura'] * 60 }}</h3>
                                                                <p>{{__('app.gym.minutes')}}</p>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row d-none">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="duration-ration-cont" style="width: 100%">
                                            <p><b>@lang('app.in_active_time') : </b>
                                                20 {{__('app.Hours')}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if(count($data))
                                    <div class="iq-card mt-4 mb-4">
                                        <div class="iq-card-body">
                                            <div class="related-heading">
                                                <div
                                                    class="d-flex justify-content-between align-items-center border-bottom">
                                                    <h2 class="border-bottom-0">{{ __('app.Tables') }}</h2>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle" type="button"
                                                           data-toggle="dropdown">
                                                            <i class="fas fa-bars" style=""></i>
                                                        </a>
                                                        <ul class="dropdown-menu main-dropdown chart-type tables-type">
                                                            <li>
                                                                <a tabindex="-1" class="dropdown-item table-1
                                                                  {{ $userSettings ? ($userSettings->table_type == "1" ? 'selected' : '') :'selected' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-1.png')}}"
                                                                        alt="{{ __('app.Pie_Chart') }}" title="{{ __('app.Pie_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item table-2 {{ $userSettings ? ($userSettings->table_type == "2" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-2.png')}}"
                                                                        alt="{{ __('app.Bar_Chart') }}" title="{{ __('app.Bar_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item table-3 {{ $userSettings ? ($userSettings->table_type == "3" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-3.png')}}"
                                                                        alt="{{ __('app.Line_Chart') }}" title="{{ __('app.Line_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item table-4 {{ $userSettings ? ($userSettings->table_type == "4" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-4.png')}}"
                                                                        alt="{{ __('app.Pyramid_Chart') }}" title="{{ __('app.Pyramid_Chart') }}">
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tables text-center">
                                                {{--                                    <img src="{{resolveDark()}}/img/Group 23115.png" class="one">--}}
                                                {{--                                    <img src="{{resolveDark()}}/img/Group 23116.png" class="three">--}}

                                                <div class="custom-table">
                                                    <table id="paginationSimpleNumbers"
                                                           class="table mt-4     {{ $userSettings ? handleTableSetting($userSettings):'theme-1' }}"
                                                           width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th class="th-sm">{{__('app.gym.Date')}}
                                                            </th>
                                                            <th class="th-sm">{{__('app.gym.Timing')}}
                                                            </th>
                                                            <th class="th-sm">{{__('app.gym.Area')}}
                                                            </th>
                                                            <th class="th-sm">{{__('app.gym.Status')}}
                                                            </th>
                                                            <th class="th-sm">{{__('app.gym.Id_Camera')}}
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data as $item)
                                                            <tr style="cursor: pointer;" id="{{$item->path_screenshot}}"
                                                                class="record"
                                                                data-toggle="modal" data-target="#basicExampleModal">
                                                                <td>{{$item->date}}</td>
                                                                <td>{{$item->time}}</td>
                                                                <td class="open">{{ __('app.gym.Area').' '.$item->area}}</td>
                                                                <td class="open {{$item->status==0 ? 'warning':'danger'}} ">{{$item->status==0 ? 'Available':'Busy'}}</td>
                                                                <td>{{$item->camera_id}}</td>
                                                            </tr>
                                                        @endforeach


                                                        </tbody>

                                                    </table>
                                                </div>
                                                {{--                                    <img src="{{resolveDark()}}/img/Group 23115.png" class="four">--}}
                                                {{--                                    <img src="{{resolveDark()}}/img/Group 23116.png" class="two">--}}

                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination pg-blue">
                                                        {!! $data->appends(request()->query())->links() !!}

                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                @else

                                    <div class="col-12 text-center no-results-found">
                                        <img src="{{ asset('assets/images/not_found.svg') }}" class="mt-5"
                                             alt="" width="400">
                                        <h3>{{ __('app.No_Results_Found') }}</h3>
                                    </div>

                                @endif
                                @if(count($charts))
                                    <div class="iq-card mb-4">
                                        <div class="iq-card-body">
                                            <div class="related-heading mb-5">
                                                <div
                                                    class="d-flex justify-content-between align-items-center border-bottom">
                                                    <h2 class="border-bottom-0">{{ __('app.duration_work_per_each_area_chart') }}</h2>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle" type="button"
                                                           data-toggle="dropdown">
                                                            <i class="fas fa-bars" style=""></i>
                                                        </a>
                                                        <ul class="dropdown-menu main-dropdown chart-type charts">
                                                            <li>
                                                                <a tabindex="-1" class="dropdown-item chart-1
                                                               {{ $userSettings ? ($userSettings->chart_type == "bar" ? 'selected' : '') :'selected' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/chart-type/Bar-Chart.svg')}}"
                                                                        alt="{{ __('app.Bar_Chart') }}" title="{{ __('app.Bar_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item chart-2 {{ $userSettings ? ($userSettings->chart_type == "circle" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/chart-type/Pie-Chart.png')}}"
                                                                        alt="{{ __('app.Pie_Chart') }}" title="{{ __('app.Pie_Chart') }}">
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <div id="chart1" class="chartDiv" style="min-height: 400px"></div>
                                                <div class="pie-charts">
                                                    <div class="row d-flex justify-content-between align-items-center">
                                                        <div class="w-50">
                                                            <div id="chart2" class="chartDiv"
                                                                 style="min-height: 400px">
                                                            </div>
                                                            <h4 class="text-center">{{__('app.gym.DurationWork')}}</h4>
                                                        </div>
                                                        <div class="w-50">
                                                            <div id="chart3" class="chartDiv"
                                                                 style="min-height: 400px">
                                                            </div>
                                                            <h4 class="text-center">{{__('app.gym.DurationEmpty')}}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            </div>
                            <!-- test phpstorm git tool -->
                            <div class="col-lg-3 show-image">
                                <span class="show-image-icon-sho">
                                    <i class="fas fa-camera"></i>
                                </span>
                                <div class="screenshoot">
                                    <img src="{{resolveDark()}}/img/Group 5933.png" class="up">
                                    <img src="{{resolveDark()}}/img/Group 5931.png" class="down">
                                    <div class="card">
                                        <div class="card-body text-center position-relative">
                                            <h6>{{__('app.gym.Screenshots')}}</h6>
                                            <ul class="nav nav-tabs  md-tabs mt-1" id="myTabJust"
                                                role="tablist">
                                                @foreach($active_areas as $val)
                                                    @if((int)$val === 1)
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#home-just-{{$val}}"
                                                               id="home-tab-just-{{$val}}" data-toggle="tab" role="tab"
                                                               aria-controls="home-just-{{$val}}"
                                                               aria-selected="true">{{__('app.gym.Area')}} {{$val}}</a>
                                                        </li>
                                                    @else
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#home-just-{{$val}}"
                                                               id="home-tab-just-{{$val}}" data-toggle="tab" role="tab"
                                                               aria-controls="home-just-{{$val}}"
                                                               aria-selected="false">{{__('app.gym.Area')}} {{$val}}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <div class="tab-content  pt-3" id="myTabContentJust">
                                                @foreach($active_areas as $key=>$val)
                                                        <div class="tab-pane fade {{ $key == 0 ? 'show active': '' }}" id="home-just-{{$val}}"
                                                             role="tabpanel" aria-labelledby="home-tab-just-{{$val}}">
                                                            <div class="screenshoot-content">
                                                                @php
                                                                    $noImage=false;
                                                                 @endphp
                                                                @foreach($data as $item)
                                                                        @if((int)$item->area === (int)$val)
                                                                        @php
                                                                            $noImage=true;
                                                                        @endphp
                                                                            @if($item->screenshot != null)
                                                                                <div class="screenshot-img">
                                                                                    <img src="{{$item->path_screenshot}}"
                                                                                         height="251" alt=""
                                                                                         data-toggle="modal"
                                                                                         data-target="#basicExampleModal">
                                                                                    <div class="img-overlay">
                                                                                        <span
                                                                                            class="mr-1">{{$item->date}}</span>
                                                                                        <span>{{$item->time}}</span>
                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                        @endif

                                                                    @endforeach

                                                                @if($noImage == false)
                                                                    <img src="/assets/images/no_image.svg" class="mt-5 no_image" alt="" />
                                                                @endif

                                                            </div>
                                                        </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('js/report/branchCharts.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.dropdown-submenu a.test').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                $(this).next('ul').toggle();
            });
            $(' .dropdown-item.removeDefault').on("click", function (e) {
                $(this).find('.show-icon').toggle();
                e.stopPropagation();
                e.preventDefault();
            });
            /***** Tables Show ******/
            $('.chart-type.tables-type .dropdown-item').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                $(this).closest('.tables-type ').find('.dropdown-item').removeClass('selected');
                $(this).addClass('selected');
                $('.custom-table table').removeClass().addClass('table');

                if ($(this).hasClass('table-1')) {
                    $('.custom-table table').addClass('theme-1');
                    setUserSetting('table_type', 1);
                } else if ($(this).hasClass('table-2')) {
                    $('.custom-table table').addClass('table-bordered');
                    setUserSetting('table_type', 2);
                } else if ($(this).hasClass('table-3')) {
                    $('.custom-table table').addClass('table-striped');
                    setUserSetting('table_type', 3);
                } else if ($(this).hasClass('table-4')) {
                    $('.custom-table table').addClass('table-striped table-dark');
                    setUserSetting('table_type', 4);
                }
            });

            var index;
            var images;
            $('.screenshot-img').click(function (){
                // index image in slider
                index = $(this).index();
                // images in content div
                images = $(this).closest('.screenshoot-content').find('img');
                // check count images grater than 1 imag to controle in the arrow
                if(images.length <= 1){
                    $('.next-arrow, .prev-arrow').hide();
                }
                else {
                    $('.next-arrow, .prev-arrow').show();
                }
                $('#indexImage').html(index+1);
                console.log(images[index].src);
            });
            var q = 0;
            // arrow click change image src
            $('.next-arrow').click(function (){
                if(index < images.length-1){
                    index +=1;
                }else {
                    index = 0;
                }
                var src = images[index].src;
                // $('#image_to_show').attr('src', src).toggleClass('animationPlay');
                $('#image_to_show').remove();
                $('.show-image-models .position-relative').append('<img src="'+src+'" id="image_to_show" alt="">');
                $('#indexImage').html(index+1);
            });
            $('.prev-arrow').click(function (){
                if(index > 1){
                    index -=1;
                }else {
                    index = 6;
                }
                var src = images[index].src;
                // $('#image_to_show').attr('src', src).toggleClass('animationPlay');
                $('#image_to_show').remove();
                $('.show-image-models .position-relative').append('<img src="'+src+'" id="image_to_show" alt="">');
                $('#indexImage').html(index+1);
            });

            $('.show-image-models').on('shown.bs.modal', function (e) {
                $('body').toggleClass('over-flow-hidden');
            });

            $('.show-image-models').on('hidden.bs.modal', function (e) {
                $('body').toggleClass('over-flow-hidden');
            });

            // check modal has class show
            if($('.show-image-models').hasClass('show')){
                alert('ss')
            }
            /***** Charts Show ******/
            $('.chart-type.charts .dropdown-item').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();

                $(this).closest('.chart-type ').find('.dropdown-item').removeClass('selected');
                $(this).addClass('selected');
                @if(count($charts))
                if ($(this).hasClass('chart-1')) {
                    $('.pie-charts').hide();
                    $('#chart1').show();
                    branchPlaceBar('chart1',@json($charts['bar']));
                    setUserSetting('chart_type', 'bar');
                } else if ($(this).hasClass('chart-2')) {
                    $('#chart1').hide();
                    $('.pie-charts').show();
                    branchPlaceCircleWork('chart2',@json($charts['circle']['work']));
                    branchPlaceCircleEmpty('chart3',@json($charts['circle']['empty']));
                    setUserSetting('chart_type', 'circle');
                }
                @endif
            });
        });

        $(document).ready(function () {
            let filterDataFn = function (e) {
                var key = $(this).data('key');
                var branch_id = "{{$usermodelbranch->branch_id}}";
                var date = $(this).val();
                let selectedText = e.target.options[e.target.selectedIndex].text.trim();
                let spinnerCont = $(`.spinner-cont-${key}`);
                $(this.closest('.setting-card-cont')).dropdown('toggle');
                spinnerCont.removeClass('d-none');
                $.ajax({
                    type: 'get',
                    url: "{{route('branch.filter.area')}}",
                    data: {
                        area: key,
                        branch_id: branch_id,
                        date: date
                    },
                    success: function (res) {
                        console.log(date)
                        let empty_val = res.data.empty_by_minute??0;
                        let work_val = res.data.work_by_minute??0;

                        $(`#minutes_empty_${key}`).text(empty_val);
                        $(`#minutes_work_${key}`).text(work_val);
                        $(`#hours_empty_${key}`).text(Math.round(empty_val/60,0));
                        $(`#hours_work_${key}`).text(Math.round(work_val/60,0));
                        $(`.filter-badge-${key}.badge`).text(selectedText);

                    },
                    error: function (xhr, status, error) {
                    let customToast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    customToast.fire({
                        icon: 'error',
                        title: error || 'Failed To Load Data'
                    });
                },
                complete: function(xhr, status){
                    spinnerCont.addClass('d-none');
                }
                })
            }

            slickCarouselCardEvents(filterDataFn)
            $('.area-section.slider').on('afterChange', function(event, currentSlide){
                cr && (slickCarouselCardEvents(filterDataFn), cr = false);
            })
            $('.area-section.slider').on('breakpoint', function(event, slick){
                slickCarouselCardEvents(filterDataFn);
                cr = false;
            })
        });

        @if(count($charts))
            @if($userSettings)
                @if($userSettings->chart_type == 'bar')
                    $('.pie-charts').hide();
                    $('#chart1').show();
                    branchPlaceBar('chart1',@json($charts['bar']));
                @else
                    $('#chart1').hide();
                    $('.pie-charts').show();
                    branchPlaceCircleWork('chart2',@json($charts['circle']['work']));
                    branchPlaceCircleEmpty('chart3',@json($charts['circle']['empty']));
                @endif
            @else
                $('.pie-charts').hide();
                $('#chart1').show();
                branchPlaceBar('chart1',@json($charts['bar']));
            @endif
        @endif
    </script>
@endsection

