.@extends('layouts.dashboard.index')
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
                            <div>
                                <div class="row col-12 p-0 m-0 mb-3 menu-and-filter">
                                    <div class="col">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'place'], request()->toArray()))}} @else {{ route('reports.index','place')}} @endif">{{ __('app.Bay_Area') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'plate'], request()->toArray()))}} @else {{ route('reports.index','plate')}} @endif">{{ __('app.Car_Plate') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active"
                                                   href="@if(request('filter_type') != null) {{route('report.filter',array_merge(['type'=>'invoice'], request()->toArray()))}} @else {{ route('reports.index','invoice')}} @endif">{{ __('app.Invoice') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-end position-relative mt-2">
                                            @include('customer.reports._filter',['type' => 'place'])
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active">
                                        @if(count($charts))
                                            <div class="row">
                                                <div class="pt-4 mb-5 col-md-12" id="BranchInoiceeBarCon"
                                                     style="display: none">
                                                    <div id="BranchInoiceeBar" class="chartDiv" style="min-height: 450px"></div>
                                                </div>

                                                <div class="pt-4 mb-5 col-md-12" id="BranceInvoiceLineCon" style="display: none">
                                                    <div id="BranceInvoiceLine" class="chartDiv"
                                                         style="min-height: 450px"></div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12 text-center">
                                                <img src="{{ asset('images/no-results.webp') }}"
                                                     class="no-results-image col-12 col-md-7  mt-5"
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

        /************* Start Bar Chart ****************/
        @if(count($charts))
            $("#BranchInoiceeBarCon").show();
            @if($filter_type == 'comparison')
                comparisonInvoiceBar('BranchInoiceeBar', @json($charts, JSON_THROW_ON_ERROR));
            @else
                branchInvoiceBar('BranchInoiceeBar', @json($charts, JSON_THROW_ON_ERROR));
            @endif
        @endif
        /**************** End Bar Chart****************/

        /**************** Start Line Chart ************/
        @if(count($charts))
            $("#BranceInvoiceLineCon").show();
            @if($filter_type == 'comparison')
                comparisonInvoiceLine('BranceInvoiceLine', @json($charts, JSON_THROW_ON_ERROR));
            @else
                branchInvoiceLine('BranceInvoiceLine', @json($charts, JSON_THROW_ON_ERROR));
            @endif
        @endif
        /************** End Line Chart ************/
    </script>
@endpush
