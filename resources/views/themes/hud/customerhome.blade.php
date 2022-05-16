@extends('themes.hud.layouts.dashboard.index')

@section('page_title')
    {{__('app.home')}}
@endsection

@section('content')
<div id="content" class="app-content">
    <div class="row">
        <h1 class="page-header">
        {{ __('app.most_statistics') }} {{-- <small></small> --}}
        </h1>
    </div>
    @if(in_array('home' ,array_values($config['place']['statistics'][1])) || in_array('home' ,array_values($config['place']['chart']['dynamic_bar'])) || in_array('home' ,array_values($config['plate']['chart']['dynamic_bar'])) || in_array('home' ,Arr::flatten(array_values($config['place']['table']))) || in_array('home' ,Arr::flatten(array_values($config['plate']['table']))) || in_array('home' ,array_values($config['place']['InternetStatus'][1])))
        @if(in_array('home' ,array_values($config['place']['InternetStatus'][1])))
        <div class="row">
            <div class="col-xl-6 col-lg-6">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex fw-bold small mb-3">
                            <span class="flex-grow-1">{{ __('app.branch_online') }}</span>
                            <a href="#" data-toggle="card-expand" class="text-white text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
                        </div>


                        <div class="row align-items-center mb-2">
                            <div class="col-7">
                                <h3 class="mb-0">{{ $on }}</h3>
                            </div>
                            <div class="col-5">
                                <div class="mt-n2" data-render="apexchart" data-type="bar" data-title="Visitors" data-height="30"></div>
                            </div>
                        </div>


                        <div class="small text-white text-opacity-50 text-truncate">
                            <i class="fa fa-chevron-up fa-fw me-1"></i> 33.3% more than last week<br />
                            <i class="far fa-user fa-fw me-1"></i> 45.5% new visitors<br />
                            <i class="far fa-times-circle fa-fw me-1"></i> 3.25% bounce rate
                        </div>

                    </div>


                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>

                </div>

            </div>
            <div class="col-xl-6 col-lg-6">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex fw-bold small mb-3">
                            <span class="flex-grow-1">{{ __('app.branch_offline') }}</span>
                            <a href="#" data-toggle="card-expand" class="text-white text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
                        </div>


                        <div class="row align-items-center mb-2">
                            <div class="col-7">
                                <h3 class="mb-0">{{ $off }}</h3>
                            </div>
                            <div class="col-5">
                                <div class="mt-n2" data-render="apexchart" data-type="bar" data-title="Visitors" data-height="30"></div>
                            </div>
                        </div>


                        <div class="small text-white text-opacity-50 text-truncate">
                            <i class="fa fa-chevron-up fa-fw me-1"></i> 33.3% more than last week<br />
                            <i class="far fa-user fa-fw me-1"></i> 45.5% new visitors<br />
                            <i class="far fa-times-circle fa-fw me-1"></i> 3.25% bounce rate
                        </div>

                    </div>


                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>

                </div>

            </div>
        </div>
        @endif

    @if(in_array('home' ,array_values($config['place']['statistics'][1])))
        <div class="row mt-5">
            <div class="col-xl-3 col-lg-6">
                <a href="{{route('customerRegions.index')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.Regions') }}</div>
                        <h2>{{$statistics['regions']}}</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-id-card fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{route('customerBranches.index')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.Branches') }}</div>
                        <h2>{{$statistics['branches']}}</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-subway fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{url('customer/customerPackages')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.Models') }}</div>
                        <h2>22,930</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-bars fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{route('customerUsers.index')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.Users') }}</div>
                        <h2>{{$statistics['users']}}</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-users fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
            <div class="col-xl-3 col-lg-6 mt-3">
                <a href="{{route('reports.show','invoice')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.staying_car_average') }}</div>
                        <h2>{{$statistics['serving']??0}}</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-bus fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
            <div class="col-xl-3 col-lg-6 mt-3">
                <a href="{{route('reports.show','plate')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.Car_Count') }}</div>
                        <h2>{{$statistics['cars']}}</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-car fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
            <div class="col-xl-3 col-lg-6 mt-3">
                <a href="{{route('reports.show','backout')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.backout') }}</div>
                        <h2>{{$statistics['backout']}}</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-outdent fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
            <div class="col-xl-3 col-lg-6 mt-3">
                <a href="{{route('reports.show','invoice')}}" class="card text-decoration-none">
                    <div class="card-body d-flex align-items-center text-white m-5px bg-white bg-opacity-15">
                        <div class="flex-fill">
                        <div class="mb-1">{{ __('app.Invoice') }}</div>
                        <h2>{{$statistics['invoice']}}</h2>
                        <div>Today, 11:25AM</div>
                        </div>
                        <div class="opacity-5">
                        <i class="fa fa-file-text fa-4x"></i>
                        </div>
                    </div>

                    <!-- card-arrow -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                    </a>
            </div>
        </div>
    @endif
    <div class="row mt-5">
        <div class="col-12">

            <div class="card">
                <div class="card-header fw-bold small">{{ __('app.Car_Plate_Report') }}</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <small><i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.from') }} :  {{request('start')??'2022-01-01'}} <i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.to') }} : {{request('end')??now()->toDateString()}}</small>
                    </h5>
                    <div class="pt-4 mb-5" id="BranchPlateBarCon" style="display: none">
                        <div id="BranchPlateBar" class="chartDiv" style="min-height: 450px"></div>
                    </div>
                    <div class="pt-4 mb-5" id="BranchPlateLineCon" style="display: none">
                        <div id="BranchPlateLine" class="chartDiv" style="min-height: 450px"></div>
                    </div>

                </div>

                <!-- arrow -->
                <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
                </div>
            </div>


        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">

            <div class="card">
                <div class="card-header fw-bold">{{ __('app.Bay_area_report') }}</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <small><i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.from') }} :  {{request('start')??'2022-01-01'}} <i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.to') }} : {{request('end')??now()->toDateString()}}</small>
                    </h5>
                    <div class="pt-4 mb-5" id="BranchPlaceBarCon" style="display: none">
                        <div id="BranchPlaceBar" class="chartDiv" style="min-height: 450px"></div>
                    </div>
                    <div class="pt-4 mb-5" id="BranchPlaceLineCon" style="display: none">
                        <div id="BranchPlaceLine" class="chartDiv" style="min-height: 450px"></div>
                    </div>

                </div>

                <!-- arrow -->
                <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
                </div>
            </div>


        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">

            <div class="card">
                <div class="card-header fw-bold">{{ __('app.Bay_area_report') }}</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <small><i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.from') }} :  {{request('start')??'2022-01-01'}} <i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.to') }} : {{request('end')??now()->toDateString()}}</small>
                    </h5>
                    <div class="pt-4 mb-5" id="BranchPlaceBarCon" style="display: none">
                        <div id="BranchPlaceBar" class="chartDiv" style="min-height: 450px"></div>
                    </div>
                    <div class="pt-4 mb-5" id="BranchPlaceLineCon" style="display: none">
                        <div id="BranchPlaceLine" class="chartDiv" style="min-height: 450px"></div>
                    </div>

                </div>

                <!-- arrow -->
                <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
                </div>
            </div>


        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">

            <div class="card">
                <div class="card-header fw-bold">{{ __('app.Staying_report') }}</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <small><i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.from') }} :  {{request('start')??'2022-01-01'}} <i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.to') }} : {{request('end')??now()->toDateString()}}</small>
                    </h5>
                    <div class="pt-4 mb-5" id="BranchStayingBarCon" style="display: none">
                        <div id="BranchStayingBar" class="chartDiv" style="min-height: 450px"></div>
                    </div>
                    <div class="pt-4 mb-5" id="BranchStayingSideBarCon" style="display: none">
                        <div id="BranchStayingSideBar" class="chartDiv" style="min-height: 450px"></div>
                    </div>

                </div>

                <!-- arrow -->
                <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
                </div>
            </div>


        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">

            <div class="card">
                <div class="card-header fw-bold">{{ __('app.Invoice_report') }}</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <small><i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.from') }} :  {{request('start')??'2022-01-01'}} <i class="fas fa-lg fa-fw fa-clock"></i> {{ __('app.to') }} : {{request('end')??now()->toDateString()}}</small>
                    </h5>
                    <div class="pt-4 mb-5" id="BranchInvoiceBarCon" style="display: none">
                        <div id="BranchInvoiceBar" class="chartDiv" style="min-height: 450px"></div>
                    </div>
                    <div class="pt-4 mb-5" id="BranchInvoiceLineCon" style="display: none">
                        <div id="BranchInvoiceLine" class="chartDiv" style="min-height: 450px"></div>
                    </div>

                </div>

                <!-- arrow -->
                <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
                </div>
            </div>


        </div>
    </div>

    @else
            <div class="nothingtoshoehere">
                @if (session()->has('darkMode'))
                    <img alt="Logo" src="{{url('/images')}}/wakeball/petrominwhite.png" class="img-fluid mainlogo mb-3"
                         width="150" alt="" style=""/>
                @else
                    <img src="{{url('/images')}}/wakeball/petromindark.png" class="img-fluid mainlogo  mb-3"
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
