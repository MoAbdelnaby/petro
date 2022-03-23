@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.Backout_report')}}
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
                            <div>
                                <div class="row col-12 p-0 m-0 mb-3 menu-and-filter menu-and-filter--custom">
                                    <div class="col-8">
                                        <ul class="nav nav-tabs nav-tabs--custom" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('reports.index')}}">{{ __('app.most_statistics') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('show_by') != null) {{route('reports.show',array_merge(['type'=>'place'], request()->toArray()))}} @else {{ route('reports.show','place')}} @endif">{{ __('app.Bay_Area') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('show_by') != null) {{route('reports.show',array_merge(['type'=>'plate'], request()->toArray()))}} @else {{ route('reports.show','plate')}} @endif">{{ __('app.Car_Plate') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('show_by') != null) {{route('reports.show',array_merge(['type'=>'invoice'], request()->toArray()))}} @else {{ route('reports.show','invoice')}} @endif">{{ __('app.Invoice') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('show_by') != null) {{route('reports.show',array_merge(['type'=>'welcome'], request()->toArray()))}} @else {{ route('reports.show','welcome')}} @endif">{{ __('app.Welcome_Message') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="@if(request('show_by') != null) {{route('reports.show',array_merge(['type'=>'backout'], request()->toArray()))}} @else {{ route('reports.show','backout')}} @endif">{{ __('app.backout') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="@if(request('show_by') != null) {{route('reports.show',array_merge(['type'=>'stayingAverage'], request()->toArray()))}} @else {{ route('reports.show','stayingAverage')}} @endif">{{ __('app.staying_car_average') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end position-relative filter-cont">
                                            @include('customer.reports.extra._filter',['type' => 'backout'])
                                        </div>
                                    </div>
                                </div>

                                <div class="related-heading mb-3 m-0 row col-12 related-heading--custom" >
                                    <h2 class="p-0 col ml-2">{{ __('app.Backout_report') }}</h2>
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
                                                {{request('start')??"2022-01-01"}}
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
                                                {{request('end')??now()->toDateString()}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 branches-cont pb-4">
                                        <h3>{{ __("app.".\Str::plural($report['type'])) }} : </h3>
                                        <ul>
                                            @foreach($list_report as $index => $elemnt)
                                                <li>{{$elemnt}}</li>
                                                @if($index == 4)
                                                    <li>.....</li>
                                                    @break
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active">
                                        @if(count($report['charts']))
                                            <div class="pt-4 mb-5" id="BranchBackoutBarCon"  style="display: none">
                                                <div id="BranchBackoutBar" class="chartDiv" style="min-height: 450px"></div>
                                            </div>
                                            <div class="pt-4 mb-5" id="BranchBackoutLineCon" style="display: none">
                                                <div id="BranchBackoutLine" class="chartDiv" style="min-height: 450px"></div>
                                            </div>
                                            <div class="row pb-5" id="BackoutCircleCon" style="display: none">
                                                @foreach($report['info']['columns']??[] as $column)
                                                    @if(count($report['info']['columns']) <2)
                                                        <div class="col-md-3"></div>
                                                    @else
                                                        <div class="col-md-1"></div>
                                                    @endif
                                                    <div class="col-lg-6">
                                                        <div class="pt-8">
                                                            <div id="BackoutCircle{{$column}}" class="chartDiv" style="min-height: 450px"></div>
                                                        </div>
                                                        <h4 class="text-center"  style="margin-left: 30%">
                                                            {{$report['info']['display_key'][$column]}}&nbsp;({{$report['info']['unit']}})
                                                        </h4>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="pt-4 mb-5" id="BranchBackoutSideBarCon" style="display: none">
                                                <div id="BranchBackoutSideBar" class="chartDiv" style="min-height: 450px"></div>
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
@php $key_name = 'report'; @endphp
@push('js')
    <script src="{{asset('js/report/report.js')}}"></script>
    <script>
        let charts = @json($report['charts']);
        let info = @json($report['info']);
        /************* Start Bar Chart ****************/
        @if(count($report['charts']))
            $("#BranchBackoutBarCon").show();
            barChart('BranchBackoutBar',charts.bar, info);
        @endif
        /**************** End Bar Chart****************/

        /**************** Start Line Chart ************/
        @if(count($report['charts']))
            $("#BranchBackoutLineCon").show();
            lineChart('BranchBackoutLine',charts.bar, info);
        @endif
        /************** End Line Chart ************/

        /**************** Start SideBar Chart ************/
        @if(count($report['charts']))
            $("#BranchBackoutSideBarCon").show();
            sideBarChart('BranchBackoutSideBar',charts.bar, info);
        @endif
        /************** End SideBar Chart ************/

        /********************** Start Circle Chart ************/
        @if(count($report['charts']))
            $("#BackoutCircleCon").show();
            info.columns.forEach(function (col) {
                pieChart(`BackoutCircle${col}`,charts.bar,info)
            });
        @endif
        /**************** End Circle Chart ***************/

        /************* Start TrendLine Chart ****************/
        @if(count($report['charts']))
            $("#BranchBackoutTrendLineCon").show();
            trendLineChart('BranchBackoutTrendLine',charts.bar, info);
        @endif
        /**************** End TrendLine Chart****************/
    </script>
@endpush
