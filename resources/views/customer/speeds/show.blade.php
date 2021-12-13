@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branches.page_title.index')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #chartdiv, #chartdiv2 {
            width: 100%;
            height: 500px;
        }
    </style>
@endsection
@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h4>{{  __('app.customers.speed.show.title', ['branch' => $branch->name]) }}</h4>
            <hr/>
            <div class="related-product-block position-relative table">
                <div class="row">
                    <div class="col-md-12">

                        <div class="iq-card col">
{{--                            <div class="iq-card-header">--}}
{{--                                <h2 class="text-white"--}}
{{--                                    style="font-size: 16px;line-height: 50px">{{ __('app.overall') }}</h2>--}}
{{--                            </div>--}}
                            <div class="iq-card-body">
                                <div id="chartdiv"></div>
                                {{--                                <canvas id="myChart" style="width:100%;max-width:100%"></canvas>--}}
                            </div>
                        </div>
                    </div>
                </div>


                {{--                <div class="product_table table-responsive row p-0 m-0 col-12">--}}
                {{--                    <table class="table dataTable ui celled table-bordered text-center no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">--}}
                {{--                        <thead>--}}
                {{--                        <tr role="row">--}}
                {{--                            <th>{{ __('app.customers.speed.index.speed') }}</th>--}}
                {{--                            <th>{{ __('app.customers.speed.index.date') }}</th>--}}
                {{--                        </tr>--}}
                {{--                        </thead>--}}
                {{--                        <tbody>--}}
                {{--                        @foreach($logs as $log)--}}
                {{--                            <tr class="item{{$log->id}}">--}}
                {{--                                <td>{{$log->internet_speed}} {{ __('app.customers.speed.unit') }}</td>--}}
                {{--                                <td>{{$log->created_at->format('d-m-Y h:i A')}}</td>--}}
                {{--                            </tr>--}}
                {{--                        @endforeach--}}
                {{--                        </tbody>--}}
                {{--                    </table>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        am5.ready(function () {
            var root = am5.Root.new("chartdiv");
            root.setThemes([
                am5themes_Animated.new(root)
            ]);
            var chart = root.container.children.push(
                am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX"
                })
            );
            chart.get("colors").set("step", 5);
            var cursor = chart.set(
                "cursor",
                am5xy.XYCursor.new(root, {
                    behavior: "none"
                })
            );
            cursor.lineY.set("visible", false);
            var xAxis = chart.xAxes.push(
                am5xy.DateAxis.new(root, {
                    baseInterval: {timeUnit: "day", count: 1},
                    renderer: am5xy.AxisRendererX.new(root, {}),
                    tooltip: am5.Tooltip.new(root, {})
                })
            );
            var yAxis = chart.yAxes.push(
                am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {})
                })
            );
            var series1 = chart.series.push(
                am5xy.LineSeries.new(root, {
                    name: "Series",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "open",
                    openValueYField: "close",
                    valueXField: "date",
                    stroke: root.interfaceColors.get("positive"),
                    fill: root.interfaceColors.get("positive"),
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                })
            );
            series1.fills.template.setAll({
                fillOpacity: 0.6,
                visible: true
            });
            var series2 = chart.series.push(
                am5xy.LineSeries.new(root, {
                    name: "Series",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "close",
                    valueXField: "date",
                    stroke: root.interfaceColors.get("negative"),
                    fill: root.interfaceColors.get("negative"),
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                })
            );
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal"
            }));
            var data = [
                    @foreach($groupingByDay as $day => $values)
                {
                    "date": new Date({{ explode('-', $day)[0] }}, {{ explode('-', $day)[1]-1 }}, {{ explode('-', $day)[2] }}).getTime(),
                    "open": {{ $values['download'] }},
                    "close": {{ $values['upload'] }}
                },
                @endforeach
                //{"date":1635541200000,"open":804,"close":775},
            ];
            series1.data.setAll(data);
            series2.data.setAll(data);

            var i = 0;
            var baseInterval = xAxis.get("baseInterval");
            var baseDuration = xAxis.baseDuration();
            var rangeDataItem;
            am5.array.each(series1.dataItems, function (s1DataItem) {
                var s1PreviousDataItem;
                var s2PreviousDataItem;
                var s2DataItem = series2.dataItems[i];
                if (i > 0) {
                    s1PreviousDataItem = series1.dataItems[i - 1];
                    s2PreviousDataItem = series2.dataItems[i - 1];
                }
                var startTime = am5.time
                    .round(
                        new Date(s1DataItem.get("valueX")),
                        baseInterval.timeUnit,
                        baseInterval.count
                    )
                    .getTime();
                // intersections
                if (s1PreviousDataItem && s2PreviousDataItem) {
                    var x0 =
                        am5.time
                            .round(
                                new Date(s1PreviousDataItem.get("valueX")),
                                baseInterval.timeUnit,
                                baseInterval.count
                            )
                            .getTime() +
                        baseDuration / 2;
                    var y01 = s1PreviousDataItem.get("valueY");
                    var y02 = s2PreviousDataItem.get("valueY");
                    var x1 = startTime + baseDuration / 2;
                    var y11 = s1DataItem.get("valueY");
                    var y12 = s2DataItem.get("valueY");
                    var intersection = getLineIntersection(
                        {x: x0, y: y01},
                        {x: x1, y: y11},
                        {x: x0, y: y02},
                        {x: x1, y: y12}
                    );
                    startTime = Math.round(intersection.x);
                }
                // start range here
                if (s2DataItem.get("valueY") > s1DataItem.get("valueY")) {
                    if (!rangeDataItem) {
                        rangeDataItem = xAxis.makeDataItem({});
                        var range = series1.createAxisRange(rangeDataItem);
                        rangeDataItem.set("value", startTime);
                        range.fills.template.setAll({
                            fill: series2.get("fill"),
                            fillOpacity: 0.6,
                            visible: true
                        });
                        range.strokes.template.setAll({
                            stroke: series1.get("stroke"),
                            strokeWidth: 1
                        });
                    }
                } else {
                    // if negative range started
                    if (rangeDataItem) {
                        rangeDataItem.set("endValue", startTime);
                    }
                    rangeDataItem = undefined;
                }
                // end if last
                if (i == series1.dataItems.length - 1) {
                    if (rangeDataItem) {
                        rangeDataItem.set(
                            "endValue",
                            s1DataItem.get("valueX") + baseDuration / 2
                        );
                        rangeDataItem = undefined;
                    }
                }
                i++;
            });
            series1.appear(1000);
            series2.appear(1000);
            chart.appear(1000, 100);

            function getLineIntersection(pointA1, pointA2, pointB1, pointB2) {
                let x =
                    ((pointA1.x * pointA2.y - pointA2.x * pointA1.y) * (pointB1.x - pointB2.x) -
                        (pointA1.x - pointA2.x) *
                        (pointB1.x * pointB2.y - pointB1.y * pointB2.x)) /
                    ((pointA1.x - pointA2.x) * (pointB1.y - pointB2.y) -
                        (pointA1.y - pointA2.y) * (pointB1.x - pointB2.x));
                let y =
                    ((pointA1.x * pointA2.y - pointA2.x * pointA1.y) * (pointB1.y - pointB2.y) -
                        (pointA1.y - pointA2.y) *
                        (pointB1.x * pointB2.y - pointB1.y * pointB2.x)) /
                    ((pointA1.x - pointA2.x) * (pointB1.y - pointB2.y) -
                        (pointA1.y - pointA2.y) * (pointB1.x - pointB2.x));
                return {x: x, y: y};
            }


        }); // end am5.ready()
    </script>
@endpush

