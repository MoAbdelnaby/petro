@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.gym.places_maintenence')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-selection.select2-selection--multiple {
            min-height: 40px !important;
        }

        .select-model h3 {
            width: 230px;
        }
    </style>
@endpush
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">

                        <div class="iq-card-body">
{{--                            <div class="related-heading mb-5 ">--}}
{{--                                <form id="download_form" action="{{route('report.download','place')}}" method="get">--}}
{{--                                    <h2 class="d-flex justify-content-betweenfexport align-items-center">--}}
{{--                                        <div><img src="{{ asset('gym/img/active.svg') }}" width="20" alt=""> Reports</div>--}}
{{--                                        <a href="javascript:void(0)" class="cursor-pointer download d-flex align-items-center" title="download pdf">--}}
{{--                                            <i class=" fas fa-download"></i> <h3>Download</h3>--}}
{{--                                        </a>--}}
{{--                                    </h2>--}}
{{--                                </form>--}}
{{--                            </div>--}}
                            <div>
                                <div class="row col-12 p-0 m-0 mb-3 menu-and-filter menu-and-filter--custom">
                                    <div class="col-8">
                                        <ul class="nav nav-tabs nav-tabs--custom" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'place'], request()->toArray()))}} @else {{ route('reports.index','place')}} @endif">{{ __('app.Bay_Area') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'plate'], request()->toArray()))}} @else {{ route('reports.index','plate')}} @endif">{{ __('app.Car_Plate') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'invoice'], request()->toArray()))}} @else {{ route('reports.index','invoice')}} @endif">{{ __('app.Invoice') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'welcome'], request()->toArray()))}} @else {{ route('reports.index','welcome')}} @endif">{{ __('app.Welcome_Message') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'backout'], request()->toArray()))}} @else {{ route('reports.index','backout')}} @endif">{{ __('app.backout') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'stayingAverage'], request()->toArray()))}} @else {{ route('reports.index','stayingAverage')}} @endif">{{ __('app.staying_car_average') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end position-relative filter-cont">
                                            @include('customer.reports._filter',['type' => 'place'])
                                        </div>
                                    </div>
                                </div>

                               <div class="related-heading mb-3 m-0 row col-12 related-heading--custom">
                                    <h2 class="p-0 col">{{ __('app.Bay_area_reports') }}</h2>
                                   <div class="duration-cont col py-0">

                                       <div class="duration">
                                           <i>
                                               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                   <defs></defs>
                                                   <g id="Stockholm-icons-/-Home-/-Timer" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                       <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                       <path d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                                       <path d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z" id="Combined-Shape" fill="#000000"></path>
                                                       <path d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z" id="Combined-Shape" fill="#000000"></path>
                                                       <path d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" id="Path-107" fill="#000000"></path>
                                                   </g>
                                               </svg>
                                           </i>
                                           <p>
                                               <b>{{ __('app.from') }} : </b>
                                               {{request('start_date')??"First Date"}}
                                           </p>
                                           <i>
                                               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                   <defs></defs>
                                                   <g id="Stockholm-icons-/-Home-/-Timer" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                       <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                       <path d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                                       <path d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z" id="Combined-Shape" fill="#000000"></path>
                                                       <path d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z" id="Combined-Shape" fill="#000000"></path>
                                                       <path d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" id="Path-107" fill="#000000"></path>
                                                   </g>
                                               </svg>
                                           </i>
                                           <p>
                                               <b>{{ __('app.to') }} : </b>
                                               {{request('end_date')??now()->toDateString()}}
                                           </p>
                                       </div>
                                   </div>
                                    <div class="col-12 branches-cont pb-4">
                                        <h3>{{ __('app.Branches') }} : </h3>
                                        <ul>
                                            @foreach($branches_report as $branch_name)
                                                <li>{{$branch_name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active">
                                        <div class="row" id="statistic">
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('customerRegions.index')}}" class="iq-card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Regions') }}</h6>
                                                        </div>
                                                        <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-primary  mr-2">
                                                                    <i class="fa fa-id-card"></i></div>
                                                                <h3>{{$regioncount}}</h3>
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
                                                    <a href="{{route('customerBranches.index')}}" class="iq-card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Branches') }}</h6>
                                                        </div>
                                                        <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-danger mr-2">
                                                                    <i class="fa fa-subway"></i></div>
                                                                <h3>{{$branchcount}}</h3></div>
                                                            <div
                                                                class="iq-map text-danger font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('customerUsers.index')}}" class="iq-card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Users') }}</h6>
                                                        </div>
                                                        <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-warning mr-2">
                                                                    <i class="fa fa-bars"></i></div>
                                                                <h3>{{$userscount}}</h3></div>
                                                            <div
                                                                class="iq-map text-warning font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{url('customer/customerPackages')}}" class="iq-card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Models') }}</h6>
                                                        </div>
                                                        <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-info mr-2">
                                                                    <i class="fa fa-users"></i></div>
                                                                <h3>{{$modelscount}}</h3></div>
                                                            <div class="iq-map text-info font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        @if(count($charts))
                                        <div class="pt-4 mb-5" id="BranchPLaceBarCon"  style="display: none">
                                            <div id="BranchPLaceBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                        <div class="row pb-5" id="PlaceCircleCon" style="display: none">
                                            <div class="col-lg-6">
                                                <div class="pt-8">
                                                    <div id="PlaceCircleWork" class="chartDiv" style="min-height: 450px"></div>
                                                </div>
                                                <h4 class="text-center">{{__('app.gym.DurationWork')}} ({{ __('app.Hours') }})</h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="pt-8">
                                                    <div id="PlaceCircleEmpty" class="chartDiv" style="min-height: 450px"></div>
                                                </div>
                                                <h4 class="text-center">{{__('app.gym.DurationEmpty')}} ({{ __('app.Hours') }})</h4>
                                            </div>
                                        </div>

                                        <div class="pt-4 mb-5" id="BranchPLaceSideBarCon" style="display: none">
                                            <div id="BranchPLaceSideBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                        <div class="pt-4 mb-5" id="BranchPLaceTrendLineCon" style="display: none">
                                            <div id="BranchPLaceTrendLine" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

{{--                                        <div class="pt-4 mb-5" id="BranchPLaceSmoothCon" style="display: none">--}}
{{--                                            <div id="BranchPLaceSmooth" class="chartDiv" style="min-height: 450px"></div>--}}
{{--                                        </div>--}}

                                        <div class="pt-4 mb-5" id="BranchPLaceLineCon" style="display: none">
                                            <div id="BranchPLaceLine" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                        <div class="pt-4 mb-5" id="BranchPLaceDynamicBarCon" style="display: none">
                                            <div id="BranchPLaceDynamicBar" class="chartDiv" style="min-height: 450px;"></div>
                                            <h4 class="text-center">{{ __('app.Duration_Work_Flow') }}</h4>
                                        </div>

                                        <div class="p-4">
                                            <div class="custom-table mt-5">
{{--                                                <table class="table dataTable text-center {{handleTableConfig($config['table'],'report')}}"--}}
{{--                                                       id="place_table" width="100%">--}}
{{--                                                    <thead>--}}
{{--                                                    <tr>--}}
{{--                                                        <th class="th-sm">{{ucfirst($filter_key)}}--}}
{{--                                                        </th>--}}
{{--                                                        <th class="th-sm">{{ __('app.Duration_Work') }}</th>--}}
{{--                                                        <th class="th-sm">{{ __('app.Duration_Empty') }}</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <tbody>--}}
{{--                                                    @foreach($charts['bar'] as $place)--}}
{{--                                                        <tr style="cursor: pointer;" class="record">--}}
{{--                                                            <td>{{$place[$filter_key]}}</td>--}}
{{--                                                            <td class="open">{{$place['work']}} {{ __('app.Hours') }}</td>--}}
{{--                                                            <td class="open warning">{{$place['empty']}} {{ __('app.Hours') }}</td>--}}
{{--                                                        </tr>--}}
{{--                                                    @endforeach--}}
{{--                                                    </tbody>--}}
{{--                                                </table>--}}
                                            </div>
                                        </div>
                                        @else
                                            <div class="col-12 text-center">
                                                <img src="{{ asset('images/no-results.webp') }}" class="no-results-image col-12 col-md-7  mt-5"
                                                     alt="">
                                            </div>
                                        @endif
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
@push('js')
    <script src="{{asset('js/branchCharts.js')}}"></script>
    <script src="{{asset('js/comparisonChart.js')}}"></script>
    <script>
        /****** Place Chart ******/
        @php $key_name = 'report'; @endphp

        /*************** Start Table And Statistics *************/
        @if(!in_array($key_name ,array_values($config['statistics']['1'])))
            $("#statistics").hide();
        @endif
        @if(!in_array($key_name ,Arr::flatten(array_values($config['table']))))
            $("#place_table").hide();
        @endif
        /*************** End Table And Statistics *************/

        /************* Start Bar Chart ****************/
        @if(in_array($key_name ,array_values($config['chart']['bar'])))
            @if(count($charts))
                $("#BranchPLaceBarCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlaceBar('BranchPLaceBar', @json($charts['bar']));
                @else
                    branchPlaceBar('BranchPLaceBar', @json($charts['bar']));
                @endif
            @endif
        @endif
       /**************** End Bar Chart****************/

       /**************** Start Line Chart ************/
        @if(in_array($key_name ,array_values($config['chart']['line'])))
            @if(count($charts))
                $("#BranchPLaceLineCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlaceLine('BranchPLaceLine', @json($charts['bar']));
                @else
                    branchPlaceLine('BranchPLaceLine', @json($charts['bar']));
                @endif
            @endif
        @endif
        /************** End Line Chart ************/

        /**************** Start Line Chart ************/
        @if(in_array($key_name ,array_values($config['chart']['side_bar'])))
            @if(count($charts))
                $("#BranchPLaceSideBarCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlaceSideBar('BranchPLaceSideBar', @json($charts['bar']));
                @else
                    branchPlaceSideBar('BranchPLaceSideBar', @json($charts['bar']));
                @endif
            @endif
        @endif
        /************** End Line Chart ************/

        /********************* Start Dynamic Chart *********/
        @if($filter_type == 'comparison')
            @if(in_array($key_name ,array_values($config['chart']['circle'])))
                @if(count($charts))
                    @if(diffMonth($charts['dynamic_bar']['start_at'],$charts['dynamic_bar']['end_at']) > 1)
                        $("#BranchPLaceDynamicBarCon").show();
                        comparisonPlaceDynamicBar('BranchPLaceDynamicBar', @json($charts['dynamic_bar']['data']),"{{$charts['dynamic_bar']['start_at']}}","{{$charts['dynamic_bar']['end_at']}}");
                    @endif
                @endif
            @endif
        @endif
        /*********************** End Dynamic Chart *************/

        /********************** Start Circle Chart ************/
        @if(in_array($key_name ,array_values($config['chart']['circle'])))
            @if(count($charts))
                $("#PlaceCircleCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlaceCircleWork('PlaceCircleWork',@json($charts['circle']['work']));
                    comparisonPlaceCircleEmpty('PlaceCircleEmpty', @json($charts['circle']['empty']));
                @else
                    branchPlaceCircleWork('PlaceCircleWork',@json($charts['circle']['work']));
                    branchPlaceCircleWork('PlaceCircleEmpty', @json($charts['circle']['empty']));
                @endif
             @endif
        @endif
        /**************** End Circle Chart ***************/

        /************* Start Range Slider Chart ****************/
{{--        @if(in_array($key_name ,array_values($config['chart']['trend_line']??[])))--}}
{{--            @if(count($charts))--}}
{{--                $("#BranchPLaceTrendLineCon").show();--}}
{{--                @if($filter_type == 'comparison')--}}
{{--                    comparisonPlaceTrendLine('BranchPLaceTrendLine', @json($charts['bar']));--}}
{{--                    @else--}}
{{--                    branchPlaceTrendLine('BranchPLaceTrendLine', @json($charts['bar']));--}}
{{--                @endif--}}
{{--            @endif--}}
{{--        @endif--}}
        /**************** End Range Slider Chart****************/

        /************* Start Smooth Chart ****************/
        @if(in_array($key_name ,array_values($config['chart']['smooth']??[])))
            @if(count($charts))
            $("#BranchPLaceSmoothCon").show();
            @if($filter_type == 'comparison')
                comparisonPlaceSmooth('BranchPLaceSmooth', @json($charts['bar']));
            @else
                branchPlaceSmooth('BranchPLaceSmooth', @json($charts['bar']));
            @endif
             @endif
        @endif
        /**************** End Smooth Chart****************/

        $(".download").on('click',function (e){
            $("#download_form").submit();
        });
    </script>
@endpush
