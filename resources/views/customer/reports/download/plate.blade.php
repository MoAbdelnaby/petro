@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.gym.car_plates')}}
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
            <div class="text-center alert-cont">

            </div>
            <div class="row col-12 p-0 m-0 text-right d-block mb-2">
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
{{--                            <div class="related-heading mb-5 ">--}}
{{--                                <h2 class="d-flex justify-content-between align-items-center">--}}
{{--                                    <div><img src="{{ asset('gym/img/active.svg') }}" width="20" alt=""> Reports</div>--}}
{{--                                    <a href="#" class="cursor-pointer download" title="download pdf" download>--}}
{{--                                        <i class=" fas fa-download "></i>--}}
{{--                                    </a>--}}
{{--                                </h2>--}}
{{--                            </div>--}}
                            <div>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{route('reports.index','place')}}">{{ __('app.Bay_area') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{route('reports.index','plate')}}">{{ __('app.Car_Plate') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" >
                                    <div class="tab-pane fade show active">
                                        <div class="d-flex justify-content-end position-relative">
                                            @include('customer.reports._filter',['type' => 'plate'])
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
                                                        <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon {{session()->has('darkMode') ? 'whitetext':'iq-bg-warning'}} mr-2">
                                                                    <i class="fa fa-bars"></i></div>
                                                                <h3>{{$userscount}}</h3></div>
                                                            <div class="iq-map {{session()->has('darkMode') ? 'whitetext':'text-warning'}} font-size-32">
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
                                        <div class="pt-4">
                                            <div id="BranchPLateBar" class="chartDiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="pt-4">
                                            <div id="BranchPlaceCircle" class="chartDiv" style="min-height: 450px"></div>
                                        </div>

                                        <div class="p-4">
                                            <div class="custom-table mt-5"  >
                                                <table class="table {{handleTableConfig($config['table'],'report')}}" id="plate_table" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="th-sm">{{ucfirst($filter_key)}}</th>
                                                        <th class="th-sm">{{ __('app.Car_Count') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($charts as $plate)
                                                        <tr style="cursor: pointer;" class="record">
                                                            <td class="open">{{$plate[$filter_key]}}</td>
                                                            <td class="open warning ">{{$plate['count']}} {{ __('app.Times') }}</td>
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
@endsection
@push('js')
    <script src="{{asset('js/branchCharts.js')}}"></script>
    <script>
        /****** Place Chart ******/
        @php $key_name = 'report'; @endphp

        @if(!in_array($key_name ,array_values($config['statistics']['1'])))
            $("#statistics").hide();
        @endif

        @if(!in_array($key_name ,array_values($config['chart']['bar'])))
            $("#BranchPLateBar").hide();
        @else
            @if(count($charts))
                @if($filter_type == 'comparison')
                    comparisonPlateBar('BranchPLateBar', @json($charts['data']));
                @else
                    branchPlateBar('BranchPLateBar', @json($charts['data']));
                @endif
            @endif
        @endif

        @if(!in_array($key_name ,array_values($config['chart']['circle'])))
            $("#BranchPlaceCircle").hide();
        @else

        @if(count($charts))
            @if($filter_type == 'comparison')
                comparisonPlateCircle('BranchPlaceCircle', @json($charts['data']));
            @else
                branchPlateCircle('BranchPlaceCircle',@json($charts['data']));
            @endif

            @endif
        @endif

        @if(!in_array($key_name ,Arr::flatten(array_values($config['table']))))
            $("#plate_table").hide();
        @endif
    </script>
@endpush
