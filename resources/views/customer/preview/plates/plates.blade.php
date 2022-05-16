@extends('layouts.gym.index')
@section('page_title')
    {{__('app.gym.car_plates')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(Session::has('branch_file'))
        <meta http-equiv="refresh" content="5;url={{ Session::get('branch_file') }}">
    @endif
@endsection
@push('css')
    <style>
        .loader {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #4285f4;
            width: 30px;
            height: 30px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            position: absolute;
            top: 9px;
            left: -56%;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
@section('content')
    <!-- Start Header -->
    <div class="header">
        <div class="text-center main-logo">
            <a href="#" class="logo-m"><img src="{{resolveDark()}}/img/petromin.png" class="image mb-4 mt-4 mx-auto"
                                            style="width: 170px"></a>
            <span><img src="{{resolveDark()}}/img/list.png" alt=""></span>
        </div>
        <ul class="branch branch-2nd nav nav-pills scroll-horizontal search_branch-ul top" id="pills-tab" role="tablist">
            <div class="scroll-horizontal--elm-cont" id='li-branches'>
                @foreach ($final_branches as $branch)
                    <li class="nav-item" data-bName='{{$branch->name}}'>
                        <a class="nav-link {{$branch->name==$usermodelbranch->branch->name ? 'active':''}}"
                           id="pills-home-tab"
                           href="{{route('modelbranchpreview',[$branch->user_model_branch_id])}}"
                           aria-controls="pills-home" aria-selected="true">
                            {{-- <img src="{{resolveDark()}}/img/icon-location.svg" alt=""> --}}
                             <img
                                    src="{{$branch->name==$usermodelbranch->branch->name ? url('/gym_dark'):(session()->has('darkMode') ?url('/gym_dark'):url('/gym'))}}/img/icon-location.svg"
                                    alt="">
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
                <a class="nav-link active" id="pills-profile-tab" href="{{route('plates.index',[$usermodelbranchid])}}"
                   role="tab" aria-controls="pills-profile" aria-selected="false">
                    <img src="{{url('/gym_dark')}}/img/Icon-car.svg" alt="Area-1">

                    <span class="ml-1">{{__('app.gym.car_plates')}}</span></a>
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

        <div id="logout" class="top">
            <span class="close-setting" style="cursor: pointer;"><i class="fas fa-sign-out-alt"></i>
{{--                {{__('app.gym.Logout')}}--}}
            </span>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <div class="text-center page-logo">
            <a href="{{route('home')}}" class="logo-m"><img src="{{resolveDark()}}/img/petromin.png"
                                                            class="image mb-4 mt-4 mx-auto" style="width: 170px"></a>
        </div>

        <div class="tab-content mt-1" id="pills-tabContent">


            <!-- Start one tabe-->
            <div class="tab-pane fade show active overflow-hidden" id="pills-home" role="tabpanel"
                 aria-labelledby="pills-home-tab">
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
                                                  action="{{ route('plates.platesshiftsetting',[$usermodelbranchid]) }}">
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
                                                <input type="date" value="{{old('end_date') ?old('end_date'):$lastsetting->end_date}}"
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
                                                    <button type="submit"
                                                            class="btn close-setting mt-0">{{__('app.gym.Save')}}</button>
                                                </div>
                                            </form>
                                            <div class="bor"></div>
                                            <small>{{__('app.gym.Export_Settings')}}</small>
                                            <form method="GET" class="text-center onemaincolor" id="doorform"
                                                  action="{{ route('plates.platesfilter',[$usermodelbranchid]) }}">
                                                @csrf

                                                <div class="form-group input-group input-daterange">
                                                    <div class="row col-12 p-0 m-0">
                                                        <p class="col">{{__('app.gym.Start_Date')}}</p>
                                                        <p class="col">{{__('app.gym.End_Date')}}</p>
                                                    </div>
                                                    <input type="date" value="{{old('start') ?old('start'):$start}}"
                                                           id="searchStart" name="start" class="form-control"
                                                           x-webkit-speech>
                                                    <div class="input-group-addon">
                                                        <small>{{ __('app.TO') }}</small>
                                                        <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                                                    </div>
                                                    <input type="date" id="searchEnd"
                                                           value="{{old('end') ?old('end'):$end}}" name="end" placeholder="dd/yy/dd"
                                                           class="form-control" x-webkit-speech>
                                                </div>


                                                <input type="hidden" value="1" name="submittype">
                                                <div>
                                                    <p>{{ __('app.File_Format') }}</p>
                                                    <select class="form-control" name="exportType"
                                                            style="cursor: pointer">
                                                        <option value="" selected>{{ __('app.Select_File_Format') }}</option>
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
                                <div class="row area-section slider">

                                    @foreach($areatimes as $key=>$val)
                                        <div class="col">
                                            <div class="door-open">
                                                <div class="card model-card">
                                                    <div class="card-body  p-0">
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
                                                            </div>
                                                        </div>


                                                        <div class="text-center border-bottom px-2 pt-3 pb-1">
                                                            {{-- <div class="text-center border-bottom px-2 pt-3 pb-1">
                                                                <select name="filter_date" data-key="{{$key}}"
                                                                        class="filter_date">
                                                                    <option value="all">All</option>
                                                                    <option value="today">Today</option>
                                                                    <option value="week">Week</option>
                                                                    <option value="month">Month</option>
                                                                </select>
                                                            </div> --}}

                                                            <img src="{{resolveDark()}}/img/Icon-car.svg"
                                                                 alt="Area-{{$val}}">
                                                            <div
                                                                class="area-title mt-1">{{__('app.gym.Area')}} {{$key}}</div>

                                                        </div>
                                                        <div class="d-flex aligh-items-center  area-desc">
                                                            <div class="spinner-cont d-none spinner-cont-{{$key}}">
                                                                <div class="spinner-border text-primary" role="status">
                                                                    <span class="sr-only">Loading...</span>
                                                                  </div>
                                                            </div>
                                                            <div class=" text-center p-2 w-100">
                                                                <h2>{{__('app.gym.car_plates')}}</h2>
                                                                <h3 id="times_value_{{$key}}">{{$val}}</h3>
                                                                <p>{{__('app.gym.times')}}</p>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="duration-ration-cont ">
                                            <p><b>
                                                    @lang('app.staying_car_average') : </b>
                                                {{$duration_ratio??0}} {{__('app.Minutes')}}
                                                </p>        </div>
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
                                                           class="table mt-4 {{ $userSettings ? handleTableSetting($userSettings):'theme-1' }}"
                                                           width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th class="th-sm">{{__('app.gym.check_in_date')}}</th>
                                                            <th class="th-sm">{{__('app.gym.check_out_date')}}</th>
                                                            <th class="th-sm">{{__('app.gym.period')}}</th>
                                                            <th class="th-sm">{{__('app.gym.Area')}}</th>
                                                            <th class="th-sm">{{__('app.gym.plate_no_ar')}}</th>
                                                            <th class="th-sm">{{__('app.gym.plate_no_en')}}</th>
                                                            <th class="th-sm">{{ __('app.status') }}</th>
                                                            <th class="th-sm">{{ __('app.Welcome_Message') }}</th>
                                                            <th class="th-sm">{{ __('app.Invoice') }}</th>
                                                            <th class="th-sm">{{ __('app.action') }}</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @foreach($data as $item)
                                                            <tr style="cursor: pointer; position: relative"
                                                                data-screen2="{{$item->path_area_screenshot}}"
                                                                id="{{$item->path_screenshot}}" class="record"
                                                                data-toggle="modal" data-target="#basicExampleModal0">
                                                                <td class="checkin-date">{{$item->checkInDate}}</td>
                                                                <td class="checkout-date">{{$item->checkOutDate}}</td>
                                                                <td class="period">{{ str_replace('before','',\Carbon\Carbon::parse($item->checkInDate)->diffForHumans($item->checkOutDate)) }}</td>
                                                                <td class="open area">{{ __('app.gym.Area').' '.$item->BayCode}}</td>
                                                                <td class="open ar-plate">
                                                                    {{$item->plate_ar}}
                                                                </td>
                                                                <td class="open en-plate">
                                                                    {{$item->plate_en}}
                                                                </td>
                                                                <td class="open status" id="status{{$item->id}}"
                                                                    style="position:relative;">
                                                                    @if($item->plate_status == 'error')
                                                                        <span class="badge badge-pill badge-danger">{{ __('app.Error') }}</span>
                                                                    @elseif($item->plate_status == 'success')
                                                                        <span class="badge badge-pill badge-success">{{ __('app.success') }}</span>
                                                                    @elseif($item->plate_status == 'modified')
                                                                        <span class="badge badge-pill badge-info">{{ __('app.Modified') }}</span>
                                                                    @elseif($item->plate_status == 'reported')
                                                                        <span class="badge badge-pill badge-warning">{{ __('app.Reported') }}</span>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    @if(is_null($item->failMessage))
                                                                        <i class="fas fa-comment text-success"></i>

                                                                    @else
                                                                        <a class="" data-toggle="popover"
                                                                           data-trigger="hover"
                                                                           data-content="{{$item->failMessage->status}}">
                                                                            <i class="fas fa-comment-slash text-danger"></i>
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if (!is_null($item->invoiceStatus))
                                                                        @if($item->invoiceStatus->status == 'sent')
                                                                            <a id="download-{{$item->id}}" download
                                                                               class="download_invoice"
                                                                               onclick="reviewPdf('{{$item->plate_en}}','{{$item->id}}',event)"
                                                                               data-toggle="popover" data-trigger="hover"
                                                                               data-content="Preview Invoice">
                                                                                <i class="fas fa-file-pdf text-success"
                                                                                   style="font-size: 19px"></i>
                                                                            </a>

                                                                        @elseif( $item->invoiceStatus->status == 'failed')
                                                                            <a data-toggle="popover" data-trigger="hover" data-content="{{$item->invoiceStatus->error_reason}}">
                                                                                <i class="fas fa-file-prescription text-warning"
                                                                                   style="font-size: 19px"></i>
                                                                            </a>
                                                                        @elseif($item->invoiceStatus->status == 'received')
                                                                            <a data-toggle="popover" data-trigger="hover" data-content=" {{ __('Invoiced Received') }}">
                                                                                <i class="fas fa-file-import text-info" style="font-size: 19px"></i>
                                                                            </a>
                                                                        @endif

                                                                    @else
                                                                        <a data-toggle="popover" data-trigger="hover" data-content="No invoice Sent">
                                                                            <i class="fas fa-file-excel text-danger"
                                                                               style="font-size: 19px"></i>

                                                                        </a>

                                                                    @endif


                                                                </td>

                                                                <td class="open action-col position-relative action_drop">
                                                                    <div class="loader" id="status_loading{{$item->id}}"
                                                                         style="display: none"></div>

                                                                    <div class="filter-dropdown">
                                                                        <a class="btn-filter btn btn-sm btn-primary waves-effect waves-light"
                                                                           data-toggle="dropdown" href="#">
                                                                            <i class="fas fa-edit mr-0"></i>
                                                                        </a>
                                                                        <div class="filter-content"
                                                                             aria-labelledby="dropdownMenuButton">

{{--                                                                            <a  class="text-info fw-normal" onclick="openMessage('{{$item->plate_en}}','Welcome',event,'{{$item->id}}')">--}}
{{--                                                                                {{ __('app.Welcome_Message') }}--}}
{{--                                                                                <i class="fas fa-sign-language"></i>--}}

{{--                                                                                <i style="fill: #EFAF94;width:15px">--}}
{{--                                                                                    <svg data-name="Layer 1"--}}
{{--                                                                                         xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                                                         viewBox="0 0 109.22 122.88">--}}
{{--                                                                                        <defs>--}}
{{--                                                                                            <style>.cls-1 {--}}
{{--                                                                                                    fill-rule: evenodd;--}}
{{--                                                                                                }</style>--}}
{{--                                                                                        </defs>--}}
{{--                                                                                        <title>{{ __('app.hand_wave') }}</title>--}}
{{--                                                                                        <path width="30" class="cls-1" d="M41.83,97.57c0-.13,0-.26,0-.38a17,17,0,0,1,4.31-11.57L32.39,71.88a5.76,5.76,0,0,0-8.13,0h0a5.76,5.76,0,0,0,0,8.12L41.83,97.57Zm-8.13,11.5a4.08,4.08,0,1,1-2.27,7.84,47.87,47.87,0,0,1-19.92-11A44.75,44.75,0,0,1,.23,88.11a4.09,4.09,0,0,1,7.71-2.72A36.71,36.71,0,0,0,17.14,100a39.73,39.73,0,0,0,16.56,9.12ZM63.88,22.38A4.08,4.08,0,1,1,67.36,15a44.74,44.74,0,0,1,10.19,6.55,41.61,41.61,0,0,1,7.63,8.63,4.09,4.09,0,1,1-6.82,4.51,33.56,33.56,0,0,0-6.12-6.93,36.66,36.66,0,0,0-8.36-5.37ZM68.05,8A4.08,4.08,0,1,1,70.32.16a48,48,0,0,1,19.93,11A44.84,44.84,0,0,1,101.52,29a4.09,4.09,0,0,1-7.71,2.72,36.71,36.71,0,0,0-9.2-14.56A39.73,39.73,0,0,0,68.05,8ZM92.51,71.35A29.16,29.16,0,0,0,84,76.83a14.41,14.41,0,0,0-4.16,6.78,11,11,0,0,0,.56,7A16.51,16.51,0,0,0,84,95.8L82,97.65C71.69,86.59,77.13,76,90.11,69.4l-3.85-3.66a12.25,12.25,0,0,0-1-.9,1.85,1.85,0,0,1-.56-.32,11.5,11.5,0,0,0-7.35-1.74,11.34,11.34,0,0,0-7,3.28l-.75.75-.06,0,0,0L48.89,87.56a1.83,1.83,0,0,1-.54.38l-.37.38a11.37,11.37,0,0,0-3.28,6.89,12,12,0,0,0,.21,3.73,11.77,11.77,0,0,0,3,5.12l12.42,12.42a21.7,21.7,0,0,0,15.24,6.4,21.06,21.06,0,0,0,15.1-6.21l9.42-9.42a21.85,21.85,0,0,0,7.12-16.71v-.11h0v0l-.14-29.23a1.5,1.5,0,0,1,0-.3l2.13.13-2.12-.13c.28-4.55-1.33-7.49-3.47-8.8a5.16,5.16,0,0,0-2.47-.78,4.64,4.64,0,0,0-2.4.52c-1.89,1-3.32,3.33-3.32,7.16,0,.88,0,3.21-.06,5.42a27,27,0,0,1-.53,5.27,2.13,2.13,0,0,1-.58,1.08,2.1,2.1,0,0,1-1.76.62ZM47.89,83.61,56,75.48l-22-22A5.78,5.78,0,0,0,30,51.84a5.72,5.72,0,0,0-4.07,1.67h0a5.79,5.79,0,0,0,0,8.14l22,22Zm10.3-10.3,8.13-8.13-29-29a5.79,5.79,0,0,0-8.14,0h0a5.79,5.79,0,0,0,0,8.14l29,29Zm10.74-9.49a17.55,17.55,0,0,1,11.63-4.34h.28L55.14,33.77a5.77,5.77,0,0,0-8.13,0h0a5.77,5.77,0,0,0,0,8.13L68.92,63.83Z"/>--}}
{{--                                                                                    </svg>--}}
{{--                                                                                </i>--}}
{{--                                                                            </a>--}}
                                                                            <a class="text-warning fw-normal" onclick="openMessage('{{$item->plate_en}}','Reminder',event)">
                                                                                {{ __('app.Reminder') }}
                                                                                <i class="fas fa-bell"
                                                                                   style="color: #dfab0c;"></i>
                                                                            </a>
                                                                            <a class="text-danger fw-normal put-error" data-item_id="{{$item->id}}" data-item_status="{{$item->plate_status}}">
                                                                                {{ __('app.Report_Error') }}
                                                                                <i class="fas fa-exclamation-triangle"></i>
                                                                            </a>
                                                                            <a href="#" class="text-info fw-normal"
                                                                               id="download-{{$item->id}}" download
                                                                               onclick="reviewPdf('{{$item->plate_en}}','{{$item->id}}',event)">
                                                                                {{ __('app.invoice_review') }}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination pg-blue">
                                                        {!! $data->appends(request()->query())->links() !!}
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="iq-card mb-4">
                                        <div class="iq-card-body">
                                            <div class="related-heading mb-5">
                                                <div
                                                    class="d-flex justify-content-between align-items-center border-bottom">
                                                    <h2 class="border-bottom-0">{{ __('app.invoice_chart') }}</h2>
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <div id="invoiceChart" class="chartDiv" style="min-height: 400px"></div>
                                            </div>
                                        </div>
                                    </div>
                                @else

                                    <div class="col-12 text-center">
                                        <img src="{{ asset('images/no-results.webp') }}" class="no-results-image col-12 col-md-7  mt-5" alt="">
                                    </div>

                                @endif
                                @if(count($charts))
                                    <div class="iq-card mb-4">
                                        <div class="iq-card-body">
                                            <div class="related-heading mb-5">
                                                <div
                                                    class="d-flex justify-content-between align-items-center border-bottom">
                                                    <h2 class="border-bottom-0">{{ __('app.car_count_per_each_area_chart') }}</h2>
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
                                                        <div class="w-100">
                                                            <div id="chart2" class="chartDiv"
                                                                 style="min-height: 400px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>

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
                                                @foreach($areatimes as $key=>$val)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $key === 1 ? 'active':'' }} "
                                                           href="#home-just-{{$key}}"
                                                           id="home-tab-just-{{$key}}" data-toggle="tab" role="tab"
                                                           aria-controls="home-just-{{$key}}"
                                                           aria-selected="true">{{__('app.gym.Area')}} {{$key}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content  pt-3" id="myTabContentJust">
                                                @foreach($areatimes as $key=>$val)
                                                    <div class="tab-pane fade {{ $key == 1 ? 'show active': '' }}"
                                                         id="home-just-{{$key}}"
                                                         role="tabpanel" aria-labelledby="home-tab-just-{{$key}}">
                                                        <div class="screenshoot-content">
                                                            @php
                                                                $noImage=false;
                                                            @endphp
                                                            @foreach($data as $item)
                                                                @if((int)$item->BayCode === (int)$key)
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
                                                                                <span class="mr-1">{{$item->checkInDate}}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                            @if($noImage == false)
                                                                <img src="/assets/images/no_image.svg" class="mt-5 no_image" alt=""/>
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

        <!-- start reminder modal -->
        <div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reminderModalLabel">{{ __('app.Set_new_reminder') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form novalidate id="reminder-form">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="form-group col-12 col-md-12 mb-4">
                                        <label for="kilometer">{{ __('app.Kilometer') }} ({{ __('app.Km') }})</label>
                                        <input type="number" class="form-control" id="kilometer" min="1"
                                               aria-describedby="number of kilometers" placeholder="KM">
                                        <div class="invalid-feedback km">
                                            {{ __('app.enter_a_valid_number_of_kilometer') }}.
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <label for="days">{{ __('app.Days') }}</label>
                                        <input type="number" class="form-control" id="days" min="1" max="365"
                                               aria-describedby="number of days" placeholder="(1  - 365)">
                                        <div class="invalid-feedback day">
                                            {{ __('app.enter_a_valid_number_of_days') }}.
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn close-btn btn-danger" data-dismiss="modal">{{ __('app.Close') }}</button>
                        <button type="submit" class="btn  confirm-btn col-4" form="reminder-form">{{ __('app.Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
    <script src="{{asset('js/report/branchCharts.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="{{asset('js/report/invoice.js')}}"></script>
    <script>
        branchInvoiceBar('invoiceChart',@json($invoice_chart));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var you_sure = "{{ __('app.Are_you_sure_to_send') }}",
            message = "{{ __('app.message') }}",
            messageText = "{!!__('app.You_wont_be_able_to_revert_this') !!}",
            canselMassage = "{{ __('app.Your_request_has_been_canceled') }}",
            confBtnText1 = "{{ __('app.Send') }}",
            confBtnText = "{{ __('app.Ok_got_it') }}",
            Reported = "{{ __('app.Reported') }}";

        function openMessage(plate, type, e, plateID=null) {
            e.preventDefault();

            var type = type;
            Swal.fire({
                title: `${you_sure} ${type} ${message} ?`,
                text: messageText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confBtnText1
            }).then((result) => {
                if (result.value) {
                    var plateNumber = plate;
                    $.ajax({
                        url: `${app_url}/models/plates/${type}/sendMessage`,
                        method: "POST",
                        data: {
                            plateNumber: plateNumber,
                            plateID: plateID,
                            type: type,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $('td#status'+plateID).closest('tr').find('i.fas.fa-comment-slash').toggleClass('fa-comment-slash fa-comment text-danger text-success');
                            var message = data.message;
                            const Toast = Swal.mixin({
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
                            Toast.fire({
                                icon: 'success',
                                title: message
                            })
                        },
                        error: function (data) {
                            var message = data.responseJSON.message;
                            const Toast = Swal.mixin({
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
                            Toast.fire({
                                icon: 'error',
                                title: message
                            })
                        }

                    });
                } else {
                    Swal.fire({
                        text: canselMassage,
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: confBtnText,
                        customClass: {confirmButton: "btn fw-bold btn-primary"}
                    })
                }


            });
        }

        $(document).ready(function () {

            $('[data-toggle="popover"]').popover();

            var item_update = false;

            $('.put-error').on('click', function (e) {
                e.stopPropagation();
                e.preventDefault();

                $(this).parentsUntil('filter-dropdown').find('.filter-content').removeClass('open');

                var item_id = $(this).data('item_id');
                let item_status = $(this).data("item_status");
                let status = 'reported';

                if (status == item_status) {
                    return true;
                }

                $("#status" + item_id).empty();
                $("#status_loading" + item_id).css('display', 'block');


                $.ajax({
                    url: `${app_url}/models/plates/${item_id}/putError`,
                    method: "POST",
                    data: {
                        item_id: item_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {

                        $("#status_loading" + item_id).css('display', 'none');

                        if (data.success) {
                            var data = `<span class="badge badge-pill badge-warning">`+Reported+`</span>`;
                            $("#status" + item_id).html(data);
                        } else {
                            var data = `<span class="badge badge-pill success">${item_status}</span>`;
                            $("#status" + item_id).html(data);
                        }

                    }
                });

            });

            $(".action_drop").on("click", e => e.stopPropagation())

            $(".download_invoice").on('click', function (e) {
                e.stopPropagation();
                e.preventDefault();
            });

            $('.btn-filter').on('click', function (e) {

                e.stopPropagation();
                e.preventDefault();

                let openD = $(".filter-content.open")
                if (openD.length) {
                    let closest = $(this).closest('.filter-dropdown').find('.filter-content');
                    if (openD[0].isSameNode(closest[0])) {
                        openD.removeClass("open")
                    } else {
                        openD.removeClass("open")
                        closest.addClass("open")
                    }

                } else {
                    $(this).closest('.filter-dropdown').find('.filter-content').toggleClass('open');
                }

                $('body').click((event) => {
                    if (!$(event.target).is('.filter-content')) {
                        $('.filter-content.open').removeClass('open');
                        $('body').off("click");
                    }
                });
            })

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

                if ($(this).hasClass('chart-1')) {
                    $('.pie-charts').hide();
                    $('#chart1').show();
                    branchPlateBar('chart1',@json($charts));
                    setUserSetting('chart_type', 'bar');


                } else if ($(this).hasClass('chart-2')) {
                    $('#chart1').hide();
                    $('.pie-charts').show();
                    branchPlateCircle('chart2',@json($charts));
                    setUserSetting('chart_type', 'circle');

                }
            });

        });

        @if($userSettings)
            @if($userSettings->chart_type == 'bar')
                $('.pie-charts').hide();
                $('#chart1').show();
                branchPlateBar('chart1',@json($charts));
            @else
                $('#chart1').hide();
                $('.pie-charts').show();
                branchPlateCircle('chart2',@json($charts));
            @endif
        @else
            branchPlateBar('chart1',@json($charts));
        @endif

        $(document).ready(function () {
           // $(".filter_date").on('change', );
            let filterDataFn  = function (e) {
                var area = $(this).data('key');
                var branch_id = "{{$usermodelbranch->branch->id}}";
                var date = $(this).val();
                let selectedText = e.target.options[e.target.selectedIndex].text.trim();
                let spinnerCont = $(`.spinner-cont-${area}`);
                $(this.closest('.setting-card-cont')).dropdown('toggle');
                spinnerCont.removeClass('d-none');
                // console.log(area,branch_id,date);
                $.ajax({
                    type: 'get',
                    url: "{{route('branch.plates.times')}}",
                    data: {
                        area: area,
                        branch_id: branch_id,
                        date: date
                    },
                    success: function (res) {
                        var count = res.data.count;
                        $(`#times_value_${area}`).text(count);
                        $(`.filter-badge-${area}.badge`).text(selectedText);
                    },
                    error: function (xhr, status, error) {
                        let customToast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,

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

    </script>
@endsection
