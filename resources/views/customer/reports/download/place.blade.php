<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{session()->has('darkMode') ?'ltr':(str_replace('_', '-', app()->getLocale())=='ar'?'rtl':'ltr')}}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>
    <link rel="shortcut icon" href="{{url('/images')}}/Logo.svg"/>
    <link rel="stylesheet" href="{{resolveLang()}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{resolveLang()}}/css/typography.css">
    <link rel="stylesheet" href="{{resolveLang()}}/css/style.css">
    <link rel="stylesheet" href="{{resolveLang()}}/css/responsive.css">
    <link rel="stylesheet" href="{{url('/css')}}/avatar.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{url('/')}}/assets/css/custom.css" rel="stylesheet" type="text/css"/>

    @if(app()->getLocale() =='ar')
        <link href="{{resolveDark()}}/css/style-rtl.css" rel="stylesheet" type="text/css"/>
    @endif

    <link rel="stylesheet" href=" {{url('/assets')}}/noty/noty.css ">
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <script src=" {{url('/assets')}}/noty/noty.min.js "></script>
</head>
<body class="sidebar-main">
    <div class="container-fluid" style="width: 80%; margin: 0 auto">
        <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="text-center alert-cont">
                    @if (session()->has('success'))
                        <div class="alert alert-success row" role="alert">
                            <div class="alert-head col-12">
                                <h3>{{ __('app.success') }} <small class="float-right"><i
                                            class="far fa-times-circle"></i></small></h3>
                            </div>
                            <div class="alert-body col-12">
                                <p>{{ session('success') }}</p>
                            </div>

                        </div>
                    @endif
                    @if (session()->has('danger'))
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-head col-12">
                                <h3>{{ __('app.fail') }} <small class="float-right"><i
                                            class="far fa-times-circle"></i></small></h3>
                            </div>
                            <div class="alert-body col-12">
                                <p>{{ session('danger') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row col-12 p-0 m-0 text-right d-block mb-2">
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="iq-card">
                            <div class="iq-card-body">
{{--                                <div class="related-heading mb-5 ">--}}
{{--                                    <form id="download_form" action="{{route('report.download','place')}}" method="get">--}}
{{--                                        <h2 class="d-flex justify-content-between align-items-center">--}}
{{--                                            <div><img src="{{ asset('gym/img/active.svg') }}" width="20" alt=""> Reports</div>--}}
{{--                                            <a href="javascript:void(0)" class="cursor-pointer download d-flex align-items-center" title="download pdf">--}}
{{--                                                <i class=" fas fa-download"></i> <h3>Download</h3>--}}
{{--                                            </a>--}}
{{--                                        </h2>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
                                <div>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{route('reports.index','place')}}">
                                                {{ __('app.Bay_area') }}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{route('reports.index','plate')}}">{{ __('app.Car_Plate') }}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active">
                                            <div class="d-flex justify-content-end position-relative">
                                                @include('customer.reports._filter',['type' => 'place'])
                                            </div>
                                            <div class="row mt-4" id="statistics">
                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                    <div
                                                        class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                        <div class="iq-card-body">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h6>{{ __('app.Regions') }}</h6>
                                                            </div>
                                                            <div
                                                                class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="rounded-circle iq-card-icon {{session()->has('darkMode') ? 'whitetext':'iq-bg-primary'}} mr-2">
                                                                        <i class="fa fa-id-card"></i></div>
                                                                    <h3>{{$regioncount}}</h3>
                                                                </div>
                                                                <div
                                                                    class="iq-map {{session()->has('darkMode') ? 'whitetext':'text-primary'}} font-size-32">
                                                                    <i class="ri-bar-chart-grouped-line"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                    <div
                                                        class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                        <div class="iq-card-body">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h6>{{ __('app.Branches') }}</h6>
                                                            </div>
                                                            <div
                                                                class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="rounded-circle iq-card-icon {{session()->has('darkMode') ? 'whitetext':'iq-bg-danger'}} mr-2">
                                                                        <i class="fa fa-subway"></i></div>
                                                                    <h3>{{$branchcount}}</h3></div>
                                                                <div
                                                                    class="iq-map {{session()->has('darkMode') ? 'whitetext':'text-danger'}} font-size-32">
                                                                    <i class="ri-bar-chart-grouped-line"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                    <div
                                                        class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                        <div class="iq-card-body">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h6>{{ __('app.Users') }}</h6>
                                                            </div>
                                                            <div
                                                                class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="rounded-circle iq-card-icon {{session()->has('darkMode') ? 'whitetext':'iq-bg-warning'}} mr-2">
                                                                        <i class="fa fa-bars"></i></div>
                                                                    <h3>{{$userscount}}</h3></div>
                                                                <div
                                                                    class="iq-map {{session()->has('darkMode') ? 'whitetext':'text-warning'}} font-size-32">
                                                                    <i class="ri-bar-chart-grouped-line"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                    <div
                                                        class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                        <div class="iq-card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <h6>{{ __('app.Models') }}</h6>
                                                            </div>
                                                            <div
                                                                class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="rounded-circle iq-card-icon {{session()->has('darkMode') ? 'whitetext':'iq-bg-info'}} mr-2">
                                                                        <i class="fa fa-users"></i></div>
                                                                    <h3>{{$modelscount}}</h3></div>
                                                                <div
                                                                    class="iq-map {{session()->has('darkMode') ? 'whitetext':'text-info'}} font-size-32">
                                                                    <i class="ri-bar-chart-grouped-line"></i>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                        <h4 class="text-center">{{__('app.gym.DurationWork')}}</h4>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="pt-8">
                                                            <div id="PlaceCircleEmpty" class="chartDiv" style="min-height: 450px"></div>
                                                        </div>
                                                        <h4 class="text-center">{{__('app.gym.DurationEmpty')}}</h4>
                                                    </div>
                                                </div>

                                                <div class="pt-4 mb-5" id="BranchPLaceSideBarCon" style="display: none">
                                                    <div id="BranchPLaceSideBar" class="chartDiv" style="min-height: 450px"></div>
                                                </div>

                                                <div class="pt-4 mb-5" id="BranchPLaceLineCon" style="display: none">
                                                    <div id="BranchPLaceLine" class="chartDiv" style="min-height: 450px"></div>
                                                </div>

                                                <div class="pt-4 mb-5" id="BranchPLaceDynamicBarCon" style="display: none">
                                                    <div id="BranchPLaceDynamicBar" class="chartDiv" style="min-height: 450px;"></div>
                                                    <h4 class="text-center">{{ __('app.Duration_Work_Flow') }}</h4>
                                                </div>

                                                <div class="p-4">
                                                    <div class="custom-table mt-5">
                                                        <table class="table {{handleTableConfig($config['table'],'report')}}"
                                                               id="place_table" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th class="th-sm">{{ucfirst($filter_key)}}</th>
                                                                <th class="th-sm">{{ __('app.Duration_Work') }}</th>
                                                                <th class="th-sm">{{ __('app.Duration_Empty') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($charts['bar'] as $place)
                                                                <tr style="cursor: pointer;" class="record">
                                                                    <td>{{$place[$filter_key]}}</td>
                                                                    <td class="open">{{$place['work']}} {{ __('app.Hours') }}</td>
                                                                    <td class="open warning">{{$place['empty']}} {{ __('app.Hours') }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
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
    </div>


    <script>var app_url = "{{url('/')}}";</script>
    <script src="{{resolveLang()}}/js/jquery.min.js"></script>
    <script src="{{url('/js')}}/jquery.validate.min.js"></script>
    <script src="{{resolveLang()}}/js/popper.min.js"></script>
    <script src="{{resolveLang()}}/js/bootstrap.min.js"></script>
    <script src="{{resolveLang()}}/js/jquery.appear.js"></script>
    <script src="{{resolveLang()}}/js/countdown.min.js"></script>
    <script src="{{resolveLang()}}/js/waypoints.min.js"></script>
    <script src="{{resolveLang()}}/js/jquery.counterup.min.js"></script>
    <script src="{{resolveLang()}}/js/wow.min.js"></script>
    <script src="{{resolveLang()}}/js/apexcharts.js"></script>
    <script src="{{resolveLang()}}/js/slick.min.js"></script>
    <script src="{{resolveLang()}}/js/select2.min.js"></script>
    <script src="{{resolveLang()}}/js/owl.carousel.min.js"></script>
    <script src="{{resolveLang()}}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{resolveLang()}}/js/smooth-scrollbar.js"></script>
    <script src="{{resolveLang()}}/js/lottie.js"></script>
    <script src="{{resolveLang()}}/js/chart-custom.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
    <script src="{{resolveLang()}}/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
            crossorigin="anonymous"></script>
    <script src="{{url('/js')}}/scripts.js"></script>
    <script src="{{url('/js')}}/avatar.js"></script>
    <script src="{{url('/js')}}/custom.js"></script>
    <script src="{{resolveDark()}}/js/mdb.min.js"></script>
    <script src="{{ asset('chartjs/amcharts4/core.js') }}"></script>
    <script src="{{ asset('chartjs/amcharts4/charts.js') }}"></script>
    <script src="{{ asset('chartjs/amcharts4/animated.js') }}"></script>
    <script src="{{ asset('chartjs/heatmap.js') }}"></script>
    <script src="{{asset('js/branchCharts.js')}}"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script>

    <script>
        var doc = new jsPDF();
        var specialElementHandlers = {
            '#editor': function (element, renderer) {
                return true;
            }
        };

        $('#download_file').click(function () {
            doc.fromHTML($('#content-page').html(), 15, 15, {
                'width': 170,
                'elementHandlers': specialElementHandlers
            });
            doc.save('sample-file.pdf');
        });

    </script>
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
                branchPlaceLine('BranchPLaceSideBar', @json($charts['bar']));
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

    $(".download").on('click',function (e){
    $("#download_form").submit();
    });
    </script>

</body>

</html>
