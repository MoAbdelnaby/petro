@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.gym.car_Plates')}}
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
{{--                                <form id="download_form" action="{{route('report.download','Plate')}}" method="get">--}}
{{--                                    <h2 class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div><img src="{{ asset('gym/img/active.svg') }}" width="20" alt=""> Reports</div>--}}
{{--                                        <a href="javascript:void(0)" class="cursor-pointer download d-flex align-items-center" title="download pdf">--}}
{{--                                            <i class=" fas fa-download"></i> <h3>Download</h3>--}}
{{--                                        </a>--}}
{{--                                    </h2>--}}
{{--                                </form>--}}
{{--                            </div>--}}
                            <div>
                                <div class="row col-12 p-0 m-0 mb-3 menu-and-filter">
                                    <div class="col">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'place'], request()->toArray()))}} @else {{ route('reports.index','place')}} @endif">{{ __('app.Bay_Area') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'plate'], request()->toArray()))}} @else {{ route('reports.index','plate')}} @endif">{{ __('app.Car_Plate') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'invoice'], request()->toArray()))}} @else {{ route('reports.index','invoice')}} @endif">{{ __('app.Invoice') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-end position-relative mt-2">
                                            @include('customer.reports._filter',['type' => 'plate'])
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content" >
                                    <div class="tab-pane fade show active">
                                        <div class="row" id="statistic">
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('customerRegions.index')}}" class="iq-card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6>{{ __('app.Regions') }}</h6>
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
                                                            <h6>{{ __('app.Branches') }}</h6>
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
                                                            <h6>{{ __('app.Users') }}</h6>
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
                                                            <h6>{{ __('app.Models') }}</h6>
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
                                            <div class="pt-4" id="BranchPlateBarCon" style="display: none">
                                                <div id="BranchPlateBar" class="chartDiv" style="min-height: 450px"></div>
                                            </div>
                                            <div class="pt-4 pb-5" id="BranchPlateCircleCon" style="display: none">
                                                <div id="BranchPlateCircle" class="chartDiv" style="min-height: 450px"></div>
                                            </div>

                                            <div class="pt-4 mb-5" id="BranchPlateSideBarCon" style="display: none">
                                                <div id="BranchPlateSideBar" class="chartDiv" style="min-height: 450px"></div>
                                            </div>

                                            <div class="pt-4 mb-5" id="BranchPLateTrendLineCon" style="display: none">
                                                <div id="BranchPLateTrendLine" class="chartDiv" style="min-height: 450px"></div>
                                            </div>

{{--                                            <div class="pt-4 mb-5" id="BranchPLateSmoothCon" style="display: none">--}}
{{--                                                <div id="BranchPLateSmooth" class="chartDiv" style="min-height: 450px"></div>--}}
{{--                                            </div>--}}

                                            <div class="pt-4 mb-5"  id="BranchPlateLineCon" style="display: none">
                                                <div id="BranchPlateLine" class="chartDiv" style="min-height: 450px"></div>
                                            </div>

                                             <div class="pt-4 mb-5"  id="BranchPlateDynamicBarCon" style="display: none">
                                                <div id="BranchPlateDynamicBar" class="chartDiv" style="min-height: 450px"></div>
                                            </div>

                                            <div class="p-4">
                                                <div class="custom-table mt-5"  >
                                                    <table class="table dataTable text-center {{handleTableConfig($config['table'],'report')}}" id="Plate_table" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th class="th-sm">{{ucfirst($filter_key)}}</th>
                                                            <th class="th-sm">{{ __('app.Car_Count') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @isset($charts['data'] )
                                                            @foreach($charts['data'] as $Plate)
                                                                <tr style="cursor: pointer;" class="record">
                                                                    <td class="open">{{$Plate[$filter_key]}}</td>
                                                                    <td class="open warning ">{{$Plate['count']}} {{ __('app.Times') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12 text-center">
                                                <img src="{{ asset('images/no-results.webp') }}" class="no-results-image col-12 col-md-7  mt-5" alt="">
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
    <script src="{{asset('js/comparisonChart.js')}}"></script>
    <script src="{{asset('js/branchCharts.js')}}"></script>
    <script>
        @php $key_name = 'report'; @endphp

        /*************** Start Table And Statistics *************/
        @if(!in_array($key_name ,array_values($config['statistics']['1'])))
            $("#statistics").hide();
        @endif
        @if(!in_array($key_name ,Arr::flatten(array_values($config['table']))))
            $("#Plate_table").hide();
        @endif
        /*************** End Table And Statistics *************/

        /************* Start Bar Chart ****************/
        @if(in_array($key_name ,array_values($config['chart']['bar'])))
            @if(count($charts))
                $("#BranchPlateBarCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlateBar('BranchPlateBar', @json($charts['data']));
                @else
                    branchPlateBar('BranchPlateBar', @json($charts['data']));
                @endif
            @endif
        @endif
        /**************** End Bar Chart ****************/

        /*************** Start Circle Chart *****************/
        @if(in_array($key_name ,array_values($config['chart']['circle'])))
            @if(count($charts))
                $("#BranchPlateCircleCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlateCircle('BranchPlateCircle', @json($charts['data']));
                @else
                    branchPlateCircle('BranchPlateCircle',@json($charts['data']));
                @endif

            @endif
        @endif
        /*************** End Circle Chart *****************/

        /*************** Start DynamicBar Chart *****************/
        @if($filter_type == 'comparison')
            @if(in_array($key_name ,array_values($config['chart']['dynamic_bar'])))
                @if(count($charts))
                    $("#BranchPlateDynamicBarCon").show();
                    @if(diffMonth($charts['dynamic_bar']['start_at'],$charts['dynamic_bar']['end_at']) > 1)
                        comparisonPlateDynamicBar('BranchPlateDynamicBar', @json($charts['dynamic_bar']['data']),"{{$charts['dynamic_bar']['start_at']}}","{{$charts['dynamic_bar']['end_at']}}");
                    @else
                        $("#BranchPLateDynamicBar").hide();
                    @endif
                @endif
            @endif
        @endif
        /*************** End DynamicBar Chart *****************/

        /*************** Start Line Chart *****************/
        @if(in_array($key_name ,array_values($config['chart']['line'])))
            @if(count($charts))
                $("#BranchPlateLineCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlateLine('BranchPlateLine', @json($charts['data']));
                @else
                    branchPlateLine('BranchPlateLine', @json($charts['data']));
                @endif
            @endif
        @endif
        /*************** End Line Chart *****************/

        /*************** Start SdieBar Chart *****************/
        @if(in_array($key_name ,array_values($config['chart']['side_bar'])))
            @if(count($charts))
                $("#BranchPlateSideBarCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlateSideBar('BranchPlateSideBar', @json($charts['data']));
                @else
                    branchPlateSideBar('BranchPlateSideBar', @json($charts['data']));
                @endif
            @endif
        @endif
        /*************** End Line Chart *****************/

        /************* TrendLineChart ****************/
        @if(in_array($key_name ,array_values($config['chart']['trend_line']??[])))
            @if(count($charts))
                $("#BranchPLateTrendLineCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlateTrendLine('BranchPLateTrendLine', @json($charts['data']??[]));
                @else
                    branchPlateTrendLine('BranchPLateTrendLine', @json($charts['data']??[]));
                @endif
            @endif
        @endif

        /**************** TrendLine Chart****************/

        /************* Start Smooth Chart ****************/
        @if(in_array($key_name ,array_values($config['chart']['smooth']??[])))
            @if(count($charts))
                $("#BranchPLateSmoothCon").show();
                @if($filter_type == 'comparison')
                    comparisonPlateSmooth('BranchPLateSmooth', @json($charts['data']));
                @else
                 branchPlateSmooth('BranchPLateSmooth', @json($charts['data  ']));
                @endif
            @endif
        @endif
        /**************** End Smooth Chart****************/

        $(".download").on('click',function (e){
            $("#download_form").submit();
        });
    </script>
@endpush
