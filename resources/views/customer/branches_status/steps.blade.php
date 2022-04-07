@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.branch_status')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@push('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .invalid-feedback {
            display: block;
        }

        #stepCharts {
            width: 100%;
            height: 500px;
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

                            <div class="row col-12 p-0 m-0 mb-3  menu-and-filter menu-and-filter--custom">
                                <div class="col">
                                    <ul class="nav nav-tabs nav-tabs--custom" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            {{ __('app.Branch_Status_Header') }}: {{$branch->name}}
                                        </li>

                                    </ul>
                                </div>
                                <div class="mb-2 filter-pills-cont">
                                    <div class="filter-dropdown">

                                        <a class="btn-filter btn btn-primary waves-effect waves-light px-2 py-2"
                                           data-toggle="dropdown" href="#">
                                            <i class="fa-solid fa-filter"></i> &nbsp;{{ __('app.Filter') }}
                                        </a>
                                        <div class="filter-content" aria-labelledby="dropdownMenuButton">
                                            <form action="" method="get" class="filter-form">
                                                @csrf

                                                <div class="form-group input-group input-daterange">
                                                    <div class="d-flex align-items-end row">
                                                        <div class="col-md-12 mt-2">
                                                            <label
                                                                class="mb-0  p-0">{{__('app.gym.Start_Date')}}</label>
                                                            <input type="datetime-local"
                                                                   value="{{request('start')}}" name="start"
                                                                   class="form-control"
                                                                   max="{{\Carbon\Carbon::now()->addDay()->format('Y-m-d')}}"
                                                                   oninput="if (this.value >= this.max) this.value = this.max;"
                                                            />
                                                        </div>

                                                        <div class="col-md-12 mt-2">
                                                            <label class="mb-0 ">{{__('app.gym.End_Date')}}</label>
                                                            <input type="datetime-local" value="{{request('end')}}"
                                                                   name="end"
                                                                   class="form-control"
                                                                   max="{{\Carbon\Carbon::now()->addDay()->format('Y-m-d')}}"
                                                                   oninput="if (this.value >= this.max) this.value = this.max;"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit"
                                                            class="btn btn-secondary waves-effect waves-light px-4 py-2 submit-btn">
                                                        {{ __('app.Filter') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="related-heading">--}}
{{--                                <h2>--}}
{{--                                    <img src="{{resolveDark()}}/img/icon_menu/building.svg" width="24"--}}
{{--                                         class="tab_icon-img" alt="">--}}
{{--                                    {{ __('app.Branch_Status_Header') }}: {{$branch->name}}--}}
{{--                                </h2>--}}
{{--                            </div>--}}

                            <div class="container-fluid">
                                <div class="card-body">
                                    <div class="related-product-block position-relative col-12">
                                        <div class="pt-4 mb-5">
                                            <div id="stepCharts" class="chartdiv" style="min-height: 450px"></div>
                                        </div>
                                        <div class="product_table table-responsive row p-0 m-0 col-12"
                                             style="overflow-x: hidden">
                                            <table class="table dataTable ui celled table-bordered text-center">
                                                <thead class="">
                                                <th>#</th>
                                                <th>{{ __('app.branch_status') }}</th>
                                                <th>{{ __('app.gym.Start_Date') }}</th>
                                                <th>{{ __('app.gym.End_Date') }}</th>
                                                <th>{{ __('app.duration') }}</th>
                                                </thead>
                                                <tbody class="trashbody">
                                                @foreach($steps as $k => $stable)
                                                    <tr>
                                                        <td>{{ $k+1 }}</td>
                                                        <td>
                                                            @if ($stable['status'] == 'stable')
                                                                <i class="fas fa-circle" style="color: green"></i>
                                                                <strong
                                                                    style="color: green">{{ __('app.stable')  }}</strong>
                                                            @else
                                                                <i class="fas fa-circle" style="color: red"></i>
                                                                <strong
                                                                    style="color: red">{{ __('app.not_staple') }}</strong>
                                                            @endif
                                                        </td>
                                                        <td>{{$stable['start_date']}}</td>
                                                        <td>{{$stable['end_date']}}</td>
                                                        <td>{{$stable['stability']}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    {{--  {{ $branches->links() }}--}}
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
    {{--    <script src="{{asset('js/report/report.js')}}"></script>--}}
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>

        $(document).ready(function () {
            $('.btn-filter').on('click', function () {
                $(this).closest('.filter-dropdown').find('.filter-content').toggleClass('open');
            })
        });
        $(function () {
            let steps = @json($charts, JSON_THROW_ON_ERROR);
            @if($charts->count())
                stepCharts('stepCharts', steps);
            @endif
        });

        function stepCharts(id, data) {
            am5.ready(function () {
                var root = am5.Root.new(id);
                root.dateFormatter.setAll({
                    dateFormat: "YYY-MM-dd H:i:s",
                    dateFields: ["valueX"]
                });
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX"
                }));
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                    behavior: "none"
                }));
                cursor.lineY.set("visible", false);
                var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
                    maxDeviation: 0.5,
                    baseInterval: {timeUnit: "second", count: 1},
                    renderer: am5xy.AxisRendererX.new(root, {pan: "zoom"}),
                    tooltip: am5.Tooltip.new(root, {})
                }));
                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 1,
                    renderer: am5xy.AxisRendererY.new(root, {pan: "zoom"})
                }));
                var series = chart.series.push(am5xy.StepLineSeries.new(root, {
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "value",
                    valueXField: "date",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueX}: {valueY}"
                    })
                }));
                series.strokes.template.setAll({
                    strokeWidth: 3
                });
                series.data.processor = am5.DataProcessor.new(root, {
                    dateFormat: "YYY-MM-dd H:i:s",
                    dateFields: ["date"]
                });
                series.data.setAll(data);
                chart.set("scrollbarX", am5.Scrollbar.new(root, {
                    orientation: "horizontal"
                }));
                series.appear(1000);
                chart.appear(1000, 100);
            });
        }
    </script>
@endpush

