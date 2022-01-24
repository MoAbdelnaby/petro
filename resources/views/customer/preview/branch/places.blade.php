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
                <img src="{{resolveDark()}}/img/Group 5928.png" class="image mb-4 mt-4 mx-auto" style="width: 170px">
            </a>
            <span>
                <img src="{{resolveDark()}}/img/list.png" alt="">
            </span>
        </div>

        <ul class="branch nav nav-pills scroll-vertical-custom main" id="pills-tab" role="tablist">
            <div class="scroll-vertical-custom-div">
                @foreach ($activeRegions as $reg)
                    <li class="nav-item">
                        <a class="nav-link {{$current_branch->region_id==$reg->id ? 'active':''}}" id="pills-home-tab"
                           href="{{route('regionmodelpreview.index',[$reg->id])}}" aria-controls="pills-home"
                           aria-selected="true">
                            <span class="ml-1"> {{$reg->name}}</span>
                        </a>
                    </li>
                @endforeach
            </div>

        </ul>
        <!-- //////////// -->

        {{--            here start --}}

        <ul class="branch nav nav-pills scroll-vertical-custom search_branch-ul" id="pills-tab" role="tablist">

                <div class="scroll-vertical-custom-div " id='li-branches'>


                    @foreach ($activebranches as $branch)
                        <li class="nav-item" data-bName='{{$branch->bname}}'>
                            <a class="nav-link {{$branch->b_id==$branch_id ? 'active':''}}" id="pills-home-tab"
                               href="{{route('branchmodelpreview.index',[$branch->b_id])}}"
                               aria-controls="pills-home"
                               aria-selected="true">
                                <img
                                    src="{{$branch->b_id==$branch_id ? url('/gym_dark'):(session()->has('darkMode') ?url('/gym_dark'):url('/gym'))}}/img/icon-location.svg"
                                    alt="">
                                <span class="ml-1 b-name"> {{$branch->bname}}</span></a>
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
            <div class="scroll-vertical-custom-div">
                @foreach ($modelswithbranches as $model)
                    @if($model->lt_id==1)

                        <li class="nav-item-one">
                            <a class="nav-link " id="pills-home-tab"
                               href="{{route('branchmodelpreview.door',[$branch_id,$model->id])}}"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/door.svg" alt="" height="35px">

                                <span class="ml-1"> {{$model->mname}} </span></a>
                        </li>
                    @endif
                    @if($model->lt_id==4)
                        <li class="nav-item-one">
                            <a class="nav-link " id="pills-home-tab"
                               href="{{route('branchmodelpreview.car',[$branch_id,$model->id])}}"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/car_o.svg" alt="" height="35px">

                                <span class="ml-1"> {{$model->mname}}</span></a>
                        </li>
                    @endif


                    @if($model->lt_id==2)

                        <li class="nav-item-one">
                            <a class="nav-link " id="pills-home-tab"
                               href="{{route('branchmodelpreview.recieption',[$branch_id,$model->id])}}"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/recieption.svg" alt="" height="35px">

                                <span class="ml-1"> {{$model->mname}}</span></a>
                        </li>
                    @endif

                    @if($model->lt_id==3)
                        <li class="nav-item-one">
                            <a class="nav-link" id="pills-home-tab"
                               href="{{route('branchmodelpreview.people',[$branch_id,$model->id])}}"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/icon-count.svg" alt="" height="35px">
                                <span class="ml-1"> {{$model->mname}}</span></a>
                        </li>
                    @endif
                    @if($model->lt_id==5)
                        <li class="nav-item-one">
                            <a class="nav-link " id="pills-home-tab"
                               href="{{route('branchmodelpreview.emotion',[$branch_id,$model->id])}}"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/emotionlogo.svg" alt="" height="35px">

                                <span class="ml-1"> {{$model->mname}}</span></a>
                        </li>
                    @endif
                    @if($model->lt_id==6)
                        <li class="nav-item-one">
                            <a class="nav-link " id="pills-home-tab"
                               href="{{route('branchmodelpreview.mask',[$branch_id,$model->id])}}"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/masklogo.svg" alt="" height="35px">

                                <span class="ml-1"> {{$model->mname}}</span></a>
                        </li>
                    @endif
                    @if($model->lt_id==7)
                        <li class="nav-item-one">
                            <a class="nav-link" id="pills-home-tab"
                               href="{{route('branchmodelpreview.heatmap',[$branch_id,$model->id])}}"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/icon-heatmap.svg" alt="" height="35px">

                                <span class="ml-1"> {{$model->mname}}</span></a>
                        </li>
                    @endif
                    @if($model->lt_id==8)
                        <li class="nav-item-one">
                            <a class="nav-link active" id="pills-home-tab"
                               href="@if(request()->is('*/placesfilter*'))
                               {{route('branchmodelpreview.placesfilter',array_merge([ 'branchid' => $branch_id, 'usermodelbranchid'=>$model->id],request()->toArray()))}}
                               @else
                               {{route('branchmodelpreview.places',[$branch_id,$model->id])}}
                               @endif"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{url('/gym_dark')}}/img/Icon-area-1.svg" alt="Area-1" height="35px">
                                <span class="ml-1"> {{$model->mname}}</span>
                            </a>
                        </li>
                    @endif
                    @if($model->lt_id==9)
                        <li class="nav-item-one">
                            <a class="nav-link" id="pills-home-tab"
                               href="@if(request()->is('*/placesfilter*'))
                               {{route('branchmodelpreview.platesfilter',array_merge([ 'branchid'=>$branch_id, 'usermodelbranchid'=>$model->id],request()->toArray()))}}
                               @else
                               {{route('branchmodelpreview.plates',[$branch_id,$model->id])}}
                               @endif"
                               aria-controls="pills-home" aria-selected="true">
                                <img src="{{resolveDark()}}/img/Icon-car.svg" alt="Area-1" height="32px">
                                <span class="ml-1"> {{$model->mname}}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </div>
        </ul>

        <div id="back">
            <div class="backdash">
                <a href="{{route('home')}}"> <i class="fas fa-home"></i></a>
            </div>
        </div>
         <div class="search-cont dropright">
            <button class='btn btn-icon ' data-toggle="dropdown" aria-expanded="false"><i class="fas fa-search"></i></button>
            <div class="dropdown-menu">
                <input autofocus type="text" class="form-control " aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-sm" placeholder="{{__('app.branch_search')}}" id="branch_search">
            </div>
        </div>
{{--        <div class="duration-ration-cont">--}}
{{--            <p><b>@lang('app.staying_car_average') : </b> 15 minute</p>--}}
{{--        </div>--}}
        <div id="logout">
             <span class="close-setting" style="cursor: pointer;">
                 <i class="fas fa-sign-out-alt"></i>
                 {{__('app.gym.Logout')}}
             </span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="text-center page-logo">
            <a href="{{route('home')}}" class="logo-m">
                <img src="{{resolveDark()}}/img/Group 5928.png" class="image mb-4 mt-4 mx-auto" style="width: 170px">
            </a>
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
                                    <a title="prepared files" alt="prepared files"
                                       href="{{route('branchmodelpreview.files.index',[$branch_id,$usermodelbranchid])}}"
                                       class="text-white">
                                    <i class="far fa-file-alt"></i>
                                        <p style="display: none;">{{ __('app.prepared_files') }}</p>
                                    </a>
                                </span>
                                <div class="setting">
                                    <img src="{{resolveDark()}}/img/Group 5933.png" class="up">
                                    <img src="{{resolveDark()}}/img/Group 5931.png" class="down">

                                    <div class="card ">
                                        <div class="card-body">
                                            <h6>{{__('app.gym.settings')}}</h6>
                                            <small>{{__('app.gym.Control_Settings')}}</small>
                                            <form method="POST" class="text-center onemaincolor"
                                                  action="{{ route('branchmodelpreview.placesshiftSettingSave',[$branch_id,$usermodelbranchid]) }}">
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
                                                        <i class="fas fa-long-arrow-alt-right"></i>
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
                                                        <i class="fas fa-long-arrow-alt-right"></i>
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
                                                        <i class="fas fa-long-arrow-alt-right"></i>
                                                    </div>
                                                    <input type="time"
                                                           value="{{old('notification_end') ?old('notification_end'):$lastsetting->notification_end}}"
                                                           name="notification_end" class="form-control">

                                                </div>
                                                <div class="text-center" style="margin-top: -30px">
                                                    <button type="submit"
                                                            class="btn close-setting">{{__('app.gym.Save')}}</button>
                                                </div>
                                            </form>
                                            <div class="bor"></div>
                                            <small>{{__('app.gym.Export_Settings')}}</small>
                                            <form method="GET" class="text-center onemaincolor" id="doorform"
                                                  action="{{ route('branchmodelpreview.placesfilter',[$branch_id,$usermodelbranchid]) }}">
                                                @csrf
                                                <div class="form-group input-group input-daterange">
                                                    <div class="row col-12 p-0 m-0">
                                                        <p class="col">{{__('app.gym.Start_Date')}}</p>
                                                        <p class="col">{{__('app.gym.End_Date')}}</p>
                                                    </div>
                                                    <input type="date" required
                                                           value="{{old('start') ?old('start'):$start}}"
                                                           id="searchStart" name="start" class="form-control"
                                                           x-webkit-speech>
                                                    <div class="input-group-addon">
                                                        <small>{{ __('app.TO') }}</small>
                                                        <i class="fas fa-long-arrow-alt-right"></i>
                                                    </div>
                                                    <input type="date" required id="searchEnd"
                                                           value="{{old('end') ?old('end'):$end}}" name="end"
                                                           class="form-control" x-webkit-speech>

                                                </div>
                                                <input type="hidden" value="1" name="submittype">
                                                <div>
                                                    <p>{{ __('app.File_Format') }}</p>
                                                    <select class="form-control" name="exportType"
                                                            style="cursor: pointer">
                                                        <option value=""
                                                                selected>{{ __('app.Select_File_Format') }}</option>
                                                        <option value="2" id="excel">
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
                                <div class=" area-section slider row">
                                    @foreach($areas as $key=>$area)
                                        <div class="col ">
                                            <div class="door-open">
                                                <div class="card model-card">
                                                    <div class="card-body p-0">
                                                        <span class="filter-badge filter-badge-{{$key}} badge badge-pill badge-light">All</span>
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
                                                                    </div>
                                                                    </form>
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
                                                        </div>
                                                        <div class="d-flex aligh-items-center  area-desc">

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
                                                        <ul class="dropdown-menu main-dropdown chart-type   tables-type">
                                                            <li>
                                                                <a tabindex="-1" class="dropdown-item table-1
                                                                  {{ $userSettings ? ($userSettings->table_type == "1" ? 'selected' : '') :'selected' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-1.png')}}"
                                                                        alt="{{ __('app.Pie_Chart') }}"
                                                                        title="{{ __('app.Pie_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item table-2 {{ $userSettings ? ($userSettings->table_type == "2" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-2.png')}}"
                                                                        alt="{{ __('app.Bar_Chart') }}"
                                                                        title="{{ __('app.Bar_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item table-3 {{ $userSettings ? ($userSettings->table_type == "3" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-3.png')}}"
                                                                        alt="{{ __('app.Line_Chart') }}"
                                                                        title="{{ __('app.Line_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item table-4 {{ $userSettings ? ($userSettings->table_type == "4" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/tables-type/table-4.png')}}"
                                                                        alt="{{ __('app.Pyramid_Chart') }}"
                                                                        title="{{ __('app.Pyramid_Chart') }}">
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tables text-center">
                                                {{--                                    <img src="{{resolveDark()}}/img/Group 23115.png" class="one">--}}
                                                {{--                                    <img src="{{session()->has('darkMode') ?url('/gym_dark'):url('/gym')}}/img/Group 23116.png" class="three">--}}
                                                <div class="custom-table">
                                                    <table id="paginationSimpleNumbers" class="table mt-4
                                                            {{ $userSettings ? handleTableSetting($userSettings):'theme-1' }}"
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
                                                                class="record" data-toggle="modal"
                                                                data-target="#basicExampleModal">
                                                                <td>{{$item->date}}</td>
                                                                <td>{{$item->time}}</td>
                                                                <td class="open">{{ __('app.gym.Area').' '.$item->area }}</td>
                                                                <td class="open {{$item->status==0 ? 'warning':'danger'}} ">{{$item->status==0 ? 'Available':'Busy'}}</td>
                                                                <td>{{$item->camera_id}}</td>
                                                            </tr>
                                                        @endforeach


                                                        </tbody>

                                                    </table>
                                                </div>
                                                {{--                                    <img src="{{resolveDark()}}/img/Group 23115.png" class="four">--}}
                                                {{--                                    <img src="{{session()->has('darkMode') ?url('/gym_dark'):url('/gym')}}/img/Group 23116.png" class="two">--}}

                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination pg-blue">
                                                        {!! $data->appends(request()->query())->links() !!}
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12 text-center">
                                        <img src="{{ asset('images/no-results.webp') }}"
                                             class="no-results-image col-12 col-md-7  mt-5"
                                             alt="">
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
                                                                        alt="{{ __('app.Bar_Chart') }}"
                                                                        title="{{ __('app.Bar_Chart') }}">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a tabindex="-1"
                                                                   class="dropdown-item chart-2 {{ $userSettings ? ($userSettings->chart_type == "circle" ? 'selected' : '') :'' }}"
                                                                   href="#">
                                                                    <img
                                                                        src="{{ asset('assets/images/chart-type/Pie-Chart.png')}}"
                                                                        alt="{{ __('app.Pie_Chart') }}"
                                                                        title="{{ __('app.Pie_Chart') }}">
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                @if(count($charts))
                                                    <div id="chart1" class="chartDiv" style="min-height: 400px"></div>
                                                    <div class="pie-charts">
                                                        <div
                                                            class="row d-flex justify-content-between align-items-center">
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
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if(count($data))
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
                                                <ul class="nav nav-tabs  md-tabs mt-1" id="myTabJust" role="tablist">

                                                    @foreach($active_areas as $val)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ $val === 1 ? 'active':'' }} "
                                                               href="#home-just-{{$val}}"
                                                               id="home-tab-just-{{$val}}" data-toggle="tab"
                                                               role="tab" aria-controls="home-just-{{$val}}"
                                                               aria-selected="true">{{__('app.gym.Area')}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="tab-content  pt-3" id="myTabContentJust">
                                                    @foreach($active_areas as $key=>$val)
                                                        <div class="tab-pane fade {{ $key == 0 ? 'show active': '' }}"
                                                             id="home-just-{{$key}}"
                                                             role="tabpanel" aria-labelledby="home-tab-just-{{$key}}">
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
                                                                    <img src="/assets/images/no_image.svg"
                                                                         class="mt-5 no_image" alt=""/>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        {{--                                                    @else--}}
                                                        {{--                                                        <div class="tab-pane fade " id="home-just-{{$val}}"--}}
                                                        {{--                                                             role="tabpanel"--}}
                                                        {{--                                                             aria-labelledby="profile-tab-just-{{$val}}">--}}
                                                        {{--                                                            <div class="screenshoot-content">--}}
                                                        {{--                                                                @foreach($data as $item)--}}
                                                        {{--                                                                    @if((int)$item->area === (int)$val)--}}

                                                        {{--                                                                        @if($item->screenshot != null)--}}
                                                        {{--                                                                            <div class="screenshot-img">--}}
                                                        {{--                                                                                <img src="{{$item->path_screenshot}}"--}}
                                                        {{--                                                                                     height="251" alt=""--}}
                                                        {{--                                                                                     data-toggle="modal"--}}
                                                        {{--                                                                                     data-target="#basicExampleModal">--}}
                                                        {{--                                                                                <div class="img-overlay">--}}
                                                        {{--                                                                                    <span--}}
                                                        {{--                                                                                        class="mr-1">{{$item->date}}</span>--}}
                                                        {{--                                                                                    <span>{{$item->time}}</span>--}}
                                                        {{--                                                                                </div>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        @endif--}}
                                                        {{--                                                                    @endif--}}

                                                        {{--                                                                @endforeach--}}

                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End one tabe-->
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/branchCharts.js')}}"></script>
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

        $(document).ready(function () {
             let filterDataFn = function () {
                var key = $(this).data('key');
                var branch_id = "{{$current_branch->id}}";
                var date = $(this).val();
                 $(this.closest('.setting-card-cont')).dropdown('toggle');
                $.ajax({
                    type: 'get',
                    url : "{{route('branch.filter.area')}}",
                    data: {
                        area: key,
                        branch_id: branch_id,
                        date: date
                    },
                    success: function (res) {

                        let empty_val = res.data.empty_by_minute??0;
                        let work_val = res.data.work_by_minute??0;

                        $(`#minutes_empty_${key}`).text(empty_val);
                        $(`#minutes_work_${key}`).text(work_val);
                        $(`#hours_empty_${key}`).text(Math.round(empty_val/60,0));
                        $(`#hours_work_${key}`).text(Math.round(work_val/60,0));
                        $(`.filter-badge-${key}.badge`).text(date);

                    }
                })
            }
               slickCarouselCardEvents(filterDataFn);
                $('.area-section.slider').on('afterChange', function(event, slick){
                     cr && (slickCarouselCardEvents(filterDataFn), cr = false);
                })
        });

    </script>
@endsection
