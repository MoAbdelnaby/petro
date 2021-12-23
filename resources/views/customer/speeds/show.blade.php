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


                <div class="product_table table-responsive row p-0 m-0 col-12">
                    <table class="table dataTable ui celled table-bordered text-center no-footer"
                           id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
{{--                            <th>id</th>--}}
                            <th>{{ __('app.customers.speed.index.downloadSpeed') }}</th>
                            <th>{{ __('app.customers.speed.index.downloadTime') }}</th>
                            <th>{{ __('app.customers.speed.index.uploadSpeed') }}</th>
                            <th>{{ __('app.customers.speed.index.uploadTime') }}</th>
                            <th>{{ __('app.customers.speed.index.date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr class="item{{$log->id}}">
{{--                                <td>{{ $log->id }}</td>--}}
                                <td>{{ number_format($log->internet_speed, 2) }} {{ __('app.customers.speed.unit') }}</td>
                                <td>{{$log->load_time ?? 0}} {{ __('app.customers.second') }}</td>
                                <td>{{ number_format($log->upload_speed, 2) }} {{ __('app.customers.speed.unit') }}</td>
                                <td>{{$log->uploaded_time ?? 0}} {{ __('app.customers.second') }}</td>
                                <td>{{$log->created_at->format('d-m-Y h:i A')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Styles -->
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <!-- Chart code -->
    <script>
        var data = [
                @foreach($logsChart as $log)
            {//year, month, day, hours, minutes, seconds
                date: new Date({{ $log->created_at->format('Y') }}, {{ $log->created_at->subMonth()->format('m') }}, {{ $log->created_at->format('d') }}, {{ $log->created_at->format('H') }}, {{ $log->created_at->format('i') }}, {{ $log->created_at->format('s') }}),
                value: {{ $log->internet_speed ?? 0 }}
            },
            @endforeach
        ];

        var data2 = [
                @foreach($logs as $log)
            {
                date: new Date({{ $log->created_at->format('Y') }}, {{ $log->created_at->subMonth()->format('m') }}, {{ $log->created_at->format('d') }}, {{ $log->created_at->format('H') }}, {{ $log->created_at->format('i') }}, {{ $log->created_at->format('s') }}),
                value: {{ $log->upload_speed ?? 0 }}
            },
            @endforeach

        ];

        am5.ready(function () {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(
                am5xy.XYChart.new(root, {
                    focusable: true,
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX"
                })
            );

            var easing = am5.ease.linear;
            chart.get("colors").set("step", 3);
// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xAxis = chart.xAxes.push(
                am5xy.DateAxis.new(root, {
                    maxDeviation: 0.1,
                    groupData: false,
                    baseInterval: {
                        timeUnit: "min",
                        count: 1
                    },
                    renderer: am5xy.AxisRendererX.new(root, {}),
                    tooltip: am5.Tooltip.new(root, {})
                })
            );

            function createAxisAndSeries(data, opposite, legend='Download') {
                var yRenderer = am5xy.AxisRendererY.new(root, {
                    opposite: opposite
                });
                var yAxis = chart.yAxes.push(
                    am5xy.ValueAxis.new(root, {
                        maxDeviation: 1,
                        renderer: yRenderer
                    })
                );

                if (chart.yAxes.indexOf(yAxis) > 0) {
                    yAxis.set("syncWithAxis", chart.yAxes.getIndex(0));
                }

                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(
                    am5xy.LineSeries.new(root, {
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "value",
                        valueXField: "date",
                        tooltip: am5.Tooltip.new(root, {
                            pointerOrientation: "horizontal",
                            labelText: '{valueY}'
                        }),
                        legendValueText: legend
                    })
                );
                //series.fills.template.setAll({ fillOpacity: 0.2, visible: true });
                series.strokes.template.setAll({strokeWidth: 1});

                yRenderer.grid.template.set("strokeOpacity", 0.05);
                yRenderer.labels.template.set("fill", series.get("fill"));
                yRenderer.setAll({
                    stroke: series.get("fill"),
                    strokeOpacity: 1,
                    opacity: 1
                });

                // Set up data processor to parse string dates
                // https://www.amcharts.com/docs/v5/concepts/data/#Pre_processing_data
                series.data.processor = am5.DataProcessor.new(root, {
                    dateFormat: "yyyy-MM-dd",
                    dateFields: ["date"]
                });

                series.data.setAll(data);
            }
// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                xAxis: xAxis,
                behavior: "none"
            }));
            cursor.lineY.set("visible", false);

// add scrollbar
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal"
            }));

            createAxisAndSeries(data, false, 'Download');
            createAxisAndSeries(data2, true, 'Upload');
            // createAxisAndSeries(8000, true);



            var legend = chart.bottomAxesContainer.children.push(am5.Legend.new(root, {
                nameField: "legendValueText",
                x: am5.percent(50),
                centerX: am5.percent(50),
            }));

// When legend item container is hovered, dim all the series except the hovered one
            legend.itemContainers.template.events.on("pointerover", function(e) {
                var itemContainer = e.target;

                // As series list is data of a legend, dataContext is series
                var series = itemContainer.dataItem.dataContext;

                chart.series.each(function(chartSeries) {
                    if (chartSeries != series) {
                        chartSeries.strokes.template.setAll({
                            strokeOpacity: 0.15,
                            stroke: am5.color(0x000000)
                        });
                    } else {
                        chartSeries.strokes.template.setAll({
                            strokeWidth: 3
                        });
                    }
                })
            })

// When legend item container is unhovered, make all series as they are
            legend.itemContainers.template.events.on("pointerout", function(e) {
                var itemContainer = e.target;
                var series = itemContainer.dataItem.dataContext;

                chart.series.each(function(chartSeries) {
                    chartSeries.strokes.template.setAll({
                        strokeOpacity: 1,
                        strokeWidth: 1,
                        stroke: chartSeries.get("fill")
                    });
                });
            })



// It's is important to set legend data after all the events are set on template, otherwise events won't be copied
            legend.data.setAll(chart.series.values);


            chart.appear(1000, 100);


        }); // end am5.ready()
    </script>

@endpush

