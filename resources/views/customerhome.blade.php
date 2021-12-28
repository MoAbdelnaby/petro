@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.home')}}
@endsection

@section('content')
    <!-- Page Content  -->

{{--    @dd($config)--}}
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @if(in_array('home' ,array_values($config['place']['statistics'][1])) || in_array('home' ,array_values($config['place']['chart']['dynamic_bar'])) || in_array('home' ,array_values($config['plate']['chart']['dynamic_bar'])) || in_array('home' ,Arr::flatten(array_values($config['place']['table']))) || in_array('home' ,Arr::flatten(array_values($config['plate']['table']))) || in_array('home' ,array_values($config['place']['InternetStatus'][1])))
                @if(!empty($charts['place']))
                    @if(in_array('home' ,array_values($config['place']['statistics'][1])))
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
                                                    <img src="{{ asset('/images/homepageIcon/regions.svg') }}" width="30" class="d-inline" alt="" />
                                                </div>
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
                                                <div class="rounded-circle iq-card-icon iq-bg-danger mr-2">
                                                    <img src="{{ asset('/images/homepageIcon/branches.svg') }}" width="30" class="d-inline" alt="" />
                                                </div>
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
                                                    <i class="fa fa-users"></i>
                                                </div>
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
                                                    <img src="{{ asset('/images/homepageIcon/models.svg') }}" width="30" class="d-inline" alt="" />

                                                </div>
                                                <h3>{{$modelscount}}</h3></div>
                                            <div class="iq-map text-info font-size-32">
                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif


                @if(in_array('home' ,array_values($config['place']['chart']['dynamic_bar'])) || in_array('home' ,array_values($config['plate']['chart']['dynamic_bar'])))
                    <div class="row">
                        @if(in_array('home' ,array_values($config['place']['chart']['dynamic_bar'])))
                            <div class="col-12">
                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height p-0">
                                    <div class="iq-card-body p-0">

                                        <div class="related-heading mb-5">
                                            <h2 class="p-2">{{ __('app.Bay_area_charts') }}</h2>
                                        </div>
                                        <div class="mb-5 bg-gray" id="BranchPlaceDynamicBarCon">
                                            <div id="BranchPLaceDynamicBar" class="chartDiv" style="min-height: 450px"></div>
                                            <h4 class="text-center">{{ __('app.Duration_Work_Flow') }}</h4>
                                        </div>
                                        <div class="mb-5 bg-gray">
                                            <div id="comparisonPlaceBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="pt-4 bg-gray" id="comparisonPlaceTrendLineCon">
                                            <div id="comparisonPlaceTrendLine" class="chartDiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="row m-0 p-0 bg-gray">
                                            <div class="col-lg-6 mb-5 "  id="comparisonPlaceWorkCon">
                                                <div class="pt-4 " >
                                                    <div id="comparisonPlaceWork" class="chartDiv" style="min-height: 450px"></div>
                                                </div>
                                                <h4 class="text-center">{{__('app.gym.DurationWork')}} ({{ __('app.Hours') }})</h4>
                                            </div>
                                            <div class="col-lg-6 mb-5 " id="comparisonPlaceEmptyCon">
                                                <div class="pt-4 ">
                                                    <div id="comparisonPlaceEmpty" class="chartDiv" style="min-height: 450px"></div>
                                                </div>
                                                <h4 class="text-center">{{__('app.gym.DurationEmpty')}} ({{ __('app.Hours') }})</h4>
                                            </div>
                                        </div>
                                        <div class="mt-5 bg-gray" id="comparisonPlaceSideBarCon">
                                            <div id="comparisonPlaceSideBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="mt-5 bg-gray" id="comparisonPlaceLineCon">
                                            <div id="comparisonPlaceLine" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(in_array('home' ,array_values($config['plate']['chart']['dynamic_bar'])))
                            <div class="col-12">
                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height p-0">
                                    <div class="iq-card-body p-0">

                                        <div class="related-heading mb-5">
                                            <h2 class="p-2">{{ __('app.Car_Plate_charts') }}</h2>
                                        </div>
                                        <div class="pt-4 mb-5 bg-gray" id="BranchPlateDynamicBarCon">
                                            <div id="BranchPlateDynamicBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="pt-4 bg-gray">
                                            <div id="comparisonPlateBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="pt-4 bg-gray" id="comparisonPlateTrendLineCon">
                                            <div id="comparisonPlateTrendLine" class="chartDiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="pt-4 mb-5 bg-gray" id="comparisonPlateCircleCon">
                                            <div id="comparisonPlateCircle" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                        <div class="pt-4 mb-5 bg-gray" id="comparisonPlateSideBarCon">
                                            <div id="comparisonPlateSideBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                        <div class="pt-8 bg-gray"  id="comparisonPlateLineCon">
                                            <div id="comparisonPlateLine" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if(in_array('home' ,Arr::flatten(array_values($config['place']['table']))) || in_array('home' ,Arr::flatten(array_values($config['plate']['table']))))
                    <div class="row">
                        @if(in_array('home' ,Arr::flatten(array_values($config['place']['table']))))
                            <div class="col-lg-6">
                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                    <div class="iq-card-body">
                                        <div class="related-heading mb-2">
                                            <h2 class="p-2">{{ __('app.Bay_area_statistics') }}</h2>
                                        </div>
                                        <div class="custom-table">
                                            <table class="table text-center dataTable {{handleTableConfig($config['place']['table'])}}" id="place_table" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="th-sm">{{ __('app.branch') }} </th>
                                                    <th class="th-sm">{{ __('app.Duration_Work') }} </th>
                                                    <th class="th-sm">{{ __('app.Duration_Empty') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($charts['place']))
                                                    @foreach($charts['place']['bar'] as $place)
                                                        <tr style="cursor: pointer;" class="record">
                                                            <td>{{$place['branch']}}</td>
                                                            <td>{{$place['work']}} {{ __('app.Hours') }}</td>
                                                            <td>{{$place['empty']}} {{__('app.Hours')}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(in_array('home' ,Arr::flatten(array_values($config['plate']['table']))))
                            <div class="col-lg-6">
                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                    <div class="iq-card-body ">
                                        <div class="related-heading mb-2">
                                            <h2 class="p-2">{{ __('app.Car_Plate_statistics') }}</h2>
                                        </div>
                                        <div class="custom-table">
                                            <table class="table dataTable text-center {{handleTableConfig($config['plate']['table'])}}" id="plate_table" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="th-sm">{{ __('app.branch') }}</th>
                                                    <th class="th-sm">{{ __('app.Car_Count') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($charts['plate']))
                                                    @foreach($charts['plate']['data'] as $plate)
                                                        <tr style="cursor: pointer;" class="record">
                                                            <td class="open">{{$plate['branch']}}</td>
                                                            <td class="open warning ">{{$plate['count']}} {{ __('app.Times') }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

            @else
                <div class="nothingtoshoehere">
                    @if (session()->has('darkMode'))
                        <img alt="Logo" src="{{url('/images')}}/wakeball/wakebwhite.png" class="img-fluid mainlogo" width="150"  alt="" style=""/>
                    @else
                        <img  src="{{url('/images')}}/wakeball/wakebdark.png"  class="img-fluid mainlogo" width="150"  alt="" style="">
                    @endif
                    <h2>{{ __('app.No_Thing_TO_Show_Here') }}</h2>
                    <p>Please Go To Config and change some thing to display in home page</p>
                    <a href="{{ route('config.index', 'place') }}" class="btn btn-info">Config</a>
                </div>
            @endif


{{--            @dd($config['place']['InternetStatus'])--}}
            @if(in_array('home' ,array_values($config['place']['InternetStatus'][1])))

                <div class="row justify-content-center">
                    <div class="iq-card secondary-custom-card mb-4 col-6">
                        <div class="iq-card-body">
                            <div class="related-heading mb-4">
                                <div class="d-flex justify-content-between align-items-center border-bottom config_key_parent">
                                    <h2 class="border-bottom-0">{{ __('app.Internet_status') }}</h2>
                                </div>
                            </div>
                            <div class="row pt-3 mx-0 px-0" id="sortable" data-sortable-id="0" aria-dropeffect="move">

                                <div class="col-lg-6 col-md-6">
                                    <div class="card text-center col-12">
                                        <div class="card-header row online">
                                            <div class="col-4"><img width="60" src="{{ asset("images/online-svgrepo-com.svg") }}" alt=""></div>
                                            <div class="col-8">
                                                <h5><b><i class="fas fa-circle" style="color: green"></i> {{ __('app.branch_online')  }}</b></h5>
                                                <h3><b>6</b></h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="card text-center col-12">
                                        <div class="card-header row offline">
                                            <div class="col-4"><img width="60" fill="red" src="{{ asset("images/offline-svgrepo-com.svg") }}" alt=""></div>
                                            <div class="col-8">
                                                <h5><b><i class="fas fa-circle" style="color: red"></i> {{ __('app.branch_offline') }}</b></h5>
                                                <h3><b>8</b></h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('js/branchCharts.js')}}"></script>
    <script src="{{asset('js/comparisonChart.js')}}"></script>
    <script>
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

            // var oProgress = document.getElementById("progress");
            // if (oProgress) {
            //     var actualHTML = (typeof msg == "string") ? msg : msg.join("<br />");
            //     oProgress.innerHTML = actualHTML;
            // }
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

            @php $key_name = 'home'; @endphp
            /************************** Palce Branch Charts *********************/
            @if(!empty($charts['InternetStatus']))
                @if(!in_array($key_name ,array_values($config['place']['InternetStatus']['1'])))
                $("#statistic").hide();
                @endif
            @endif


            /************************** Palce Branch Charts *********************/
            @if(!empty($charts['place']))
                @if(!in_array($key_name ,array_values($config['place']['statistics']['1'])))
                    $("#statistic").hide();
                @endif
            @endif

            /*************** Start Table ********/
            @if(!in_array($key_name ,Arr::flatten(array_values($config['place']['table']))))
                $("#place_table").hide();
            @endif
            /*************** End Table *********/

            /************** Start Bar Chart ******************/
            @if(!in_array($key_name ,array_values($config['place']['chart']['trend_line']??[])))
                $("#comparisonPlaceTrendLineCon").hide();
            @else
             comparisonPlaceTrendLine('comparisonPlaceTrendLine', @json($charts['place']['bar']));
            @endif
            /************** End Bar Chart ******************/

            /************** Start Bar Chart ******************/
            @if(!in_array($key_name ,array_values($config['place']['chart']['bar'])))
                $("#comparisonPlaceBarCon").hide();
            @else
             comparisonPlaceBar('comparisonPlaceBar', @json($charts['place']['bar']));
            @endif
            /************** End Bar Chart ******************/

            /************** Start Circle Chart ******************/
            @if(!in_array($key_name ,array_values($config['place']['chart']['circle'])))
                $("#comparisonPlaceWorkCon").hide();
                $("#comparisonPlaceEmptyCon").hide();
            @else
                branchPlaceCircleWork('comparisonPlaceWork',@json($charts['place']['circle']['work']));
                branchPlaceCircleEmpty('comparisonPlaceEmpty', @json($charts['place']['circle']['empty']));
            @endif
            /************** Start Circle Chart ******************/

            /************** Start Line Chart ******************/
            @if(!in_array($key_name ,array_values($config['place']['chart']['line'])))
                $("#comparisonPlaceLineCon").hide();
            @else
                comparisonPlaceLine('comparisonPlaceLine', @json($charts['place']['bar']));
            @endif
            /************** End Line Chart  ******************/

            /************** Start Side Bar ******************/
            @if(!in_array($key_name ,array_values($config['place']['chart']['side_bar'])))
                $("#comparisonPlaceSideBarCon").hide();
            @else
                comparisonPlaceSideBar('comparisonPlaceSideBar', @json($charts['place']['bar']));
            @endif
            /*************** End SideBar Chart*********/

            /*************** Start Dynamic Chart ********/
            @if(!in_array($key_name ,array_values($config['place']['chart']['dynamic_bar'])))
                $("#BranchPlaceDynamicBarCon").hide();
            @else
                @if(count($charts))
                    comparisonPlaceDynamicBar('BranchPLaceDynamicBar', @json($charts['place']['dynamic_bar']['data']),"{{$charts['place']['dynamic_bar']['start_at']}}","{{$charts['place']['dynamic_bar']['end_at']}}");
                @endif
            @endif
            /*************** End Dynamic Chart  ********/


            /*********************** Plate Charts *********************/
            @if(!empty($charts['plate']))
            /************* Start Bar Chart **********/
            @if(!in_array($key_name ,array_values($config['plate']['chart']['bar'])))
                $("#comparisonPlateBarCon").hide();
            @else
                comparisonPlateBar('comparisonPlateBar', @json($charts['plate']['data']));
            @endif
            /************* End Bar Chart **********/

            /************* Start Bar Chart **********/
            @if(!in_array($key_name ,array_values($config['plate']['chart']['circle'])))
                $("#comparisonPlateCircleCon").hide();
            @else
                comparisonPlateCircle('comparisonPlateCircle', @json($charts['plate']['data']));
            @endif
            /************* End Bar Chart **********/

            /************* Start Line Chart **********/
            @if(!in_array($key_name ,array_values($config['plate']['chart']['line'])))
                $("#comparisonPlateLineCon").hide();
            @else
                comparisonPlateLine('comparisonPlateLine', @json($charts['plate']['data']));
            @endif
            /************* End Line Chart **********/

            /************* Start DynamicChart **********/
            @if(!in_array($key_name ,array_values($config['plate']['chart']['dynamic_bar'])))
                $("#BranchPlateDynamicBarCon").hide();
            @else
                @if(count($charts))
                    comparisonPlateDynamicBar('BranchPlateDynamicBar', @json($charts['plate']['dynamic_bar']['data']),"{{$charts['plate']['dynamic_bar']['start_at']}}","{{$charts['plate']['dynamic_bar']['end_at']}}");
                @endif
            @endif
           /************* End DynamicChart **********/

            /************** Start Side Bar ******************/
            @if(!in_array($key_name ,array_values($config['plate']['chart']['side_bar'])))
                $("#comparisonPlateSideBarCon").hide();
            @else
                comparisonPlateSideBar('comparisonPlateSideBar', @json($charts['plate']['data']));
            @endif
            /*************** End SideBar Chart*********/

            /************** Start TrendLine ******************/
            @if(!in_array($key_name ,array_values($config['plate']['chart']['trend_line']??[])))
                $("#comparisonPlateTrendLineCon").hide();
            @else
                comparisonPlateTrendLine('comparisonPlateTrendLine', @json($charts['plate']['data']));
            @endif
            /*************** End TrendLineChart*********/

           /************* Start table **********/
            @if(!in_array($key_name ,Arr::flatten(array_values($config['plate']['table']))))
                $("#plate_table").hide();
            @endif
            /************* End table  **********/
            @endif
        });
    </script>
@endsection
