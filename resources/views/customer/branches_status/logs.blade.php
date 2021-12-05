@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.customers.branches.page_title.create')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <style>
        .invalid-feedback{
            display: block;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h3>{{ $branchName }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="logChart"></div>
                                </div>
                                <div class="col-12">
                                    <table class="table table-bordered text-center">

                                        <thead class="bg-primary">
                                        <th>#</th>
                                        <th>{{ __('app.user_name') }}</th>
                                        <th>{{ __('app.branch_status') }}</th>
                                        <th>{{ __('app.lastError') }}</th>
                                        <th>{{ __('app.createdIn') }}</th>
                                        </thead>
                                        <tbody class="trashbody">
                                        @foreach($logs as $k => $log)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $log->user->name }}</td>
                                                <td>{{ $log->status }}</td>
                                                <td>{{ $log->error }}</td>
                                                <td>{{ \Carbon\Carbon::parse($log->created_at)->isoFormat("LLL") }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/branchCharts.js')}}"></script>
    <script src="{{asset('js/comparisonChart.js')}}"></script>
    <script>
        $(document).ready(function () {
            comparisonBranchLogLine("logChart",@json($logChart))
        })

        function comparisonBranchLogLine(divId, data) {
            am4core.ready(function () {
                // Themes begin
                am4core.useTheme(am4themes_animated);

                var chart = am4core.create(divId, am4charts.XYChart);
                chart.colors.list = [
                    am4core.color("#29A0D8"),
                    am4core.color("#732877"),
                    am4core.color("#13153E"),
                ];

                chart.data = data;

                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "branch";

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.title.text = "Car Count";
                valueAxis.renderer.minLabelPosition = 0.01;

                var series1 = chart.series.push(new am4charts.LineSeries());
                series1.dataFields.valueY = "status";
                series1.dataFields.categoryX = "created_at";
                series1.name = "Branch Log";
                series1.bullets.push(new am4charts.CircleBullet());
                series1.tooltipText = "Branch {categoryX}: {valueY} status";
                series1.legendSettings.valueText = "{valueY}";
                series1.visible = false;

                // Add chart cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.behavior = "zoomY";

                let hs1 = series1.segments.template.states.create("hover");
                hs1.properties.strokeWidth = 5;
                series1.segments.template.strokeWidth = 1;

                chart.legend = new am4charts.Legend();
                chart.legend.itemContainers.template.events.on(
                    "over",
                    function (event) {
                        var segments = event.target.dataItem.dataContext.segments;
                        segments.each(function (segment) {
                            segment.isHover = true;
                        });
                    }
                );

                chart.legend.itemContainers.template.events.on("out", function (event) {
                    var segments = event.target.dataItem.dataContext.segments;
                    segments.each(function (segment) {
                        segment.isHover = false;
                    });
                });
            });
        }
    </script>
@endsection
