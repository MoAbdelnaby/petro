@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branches.page_title.index')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>
@endsection
@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h4>{{  __('app.customers.speed.show.title', ['branch' => $branch->name]) }}</h4>
            <hr />
            <div class="related-product-block position-relative table">
                <div class="row">
                    <div class="col-md-6">

                        <div class="iq-card col">
                            <div class="iq-card-header">
                                <h2 class="text-white" style="font-size: 16px;line-height: 50px" >{{ __('app.overall') }}</h2>
                            </div>
                            <div class="iq-card-body">
                                <div id="chartdiv"></div>
{{--                                <canvas id="myChart" style="width:100%;max-width:100%"></canvas>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="iq-card col">
                            <div class="iq-card-header">
                                <h2 class="text-white" style="font-size: 16px;line-height: 50px" >{{ __('app.Today') }}</h2>
                            </div>
                            <div class="iq-card-body">
                                <canvas id="myChart2" style="width:100%;max-width:100%"></canvas>
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



    <!-- Chart code -->
    <script>
        am5.ready(function() {

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
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX"
            }));


// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none"
            }));
            cursor.lineY.set("visible", false);

// The data
            var xValues = [{{ implode(',', $internet_speed) }}];
            var labels_dates = [{{ implode(',', $dates) }}];
            var labels_times = [{{ implode(',', $times) }}];
            console.log(xValues +" ss")
            var data = [];
            for(var i=0; i < xValues.length; i++){
                data.push(
                    {
                        "date": labels_dates[i],
                        "upload": 100,
                        "download": xValues[i],
                    }
                )
            }


            console.log(data)

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "date",
                startLocation: 0.5,
                endLocation: 0.5,
                renderer: am5xy.AxisRendererX.new(root, {}),
                tooltip: am5.Tooltip.new(root, {})
            }));

            xAxis.data.setAll(data);

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {})
            }));

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/

            function createSeries(name, field) {
                var series = chart.series.push(am5xy.LineSeries.new(root, {
                    name: name,
                    xAxis: xAxis,
                    yAxis: yAxis,
                    stacked:true,
                    valueYField: field,
                    categoryXField: "date",
                    tooltip: am5.Tooltip.new(root, {
                        pointerOrientation: "horizontal",
                        labelText: "[bold]{name}[/]\n{categoryX}: {valueY}"
                    })
                }));

                series.fills.template.setAll({
                    fillOpacity: 0.5,
                    visible: true
                });

                series.data.setAll(data);
                series.appear(1000);
            }

            createSeries("upload", "download");
            createSeries("download", "upload");

// Add scrollbar
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal"
            }));

// Create axis ranges
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/axis-ranges/
            var rangeDataItem = xAxis.makeDataItem({
                category: "2001",
                endCategory: "2003"
            });

            var range = xAxis.createAxisRange(rangeDataItem);

            rangeDataItem.get("grid").setAll({
                stroke: am5.color(0x00ff33),
                strokeOpacity: 0.5,
                strokeDasharray: [3]
            });

            rangeDataItem.get("axisFill").setAll({
                fill: am5.color(0x00ff33),
                fillOpacity: 0.1
            });

            rangeDataItem.get("label").setAll({
                inside: true,
                text: "upload",
                rotation: 90,
                centerX: am5.p100,
                centerY: am5.p100,
                location: 0,
                paddingBottom: 10,
                paddingRight: 150
            });


            var rangeDataItem2 = xAxis.makeDataItem({
                category: "2007"
            });

            var range2 = xAxis.createAxisRange(rangeDataItem2);

            rangeDataItem2.get("grid").setAll({
                stroke: am5.color(0x00ff33),
                strokeOpacity: 1,
                strokeDasharray: [3]
            });

            rangeDataItem2.get("label").setAll({
                inside: true,
                text: "download",
                rotation: 90,
                centerX: am5.p100,
                centerY: am5.p100,
                location: 0,
                paddingBottom: 10,
                paddingRight: 15
            });

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
            chart.appear(1000, 100);

        }); // end am5.ready()
    </script>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script>
            var xValues = [{{ implode(',', $internet_speed) }}];
            var labels_dates = [{{ implode(',', $dates) }}];
            var labels_times = [{{ implode(',', $times) }}];
            console.log(labels_dates)
            console.log(labels_times)
            new Chart("myChart", {
            type: "line",
            data: {
                labels: labels_dates,
                datasets: [{
                    data: xValues,
                    borderColor: "red",
                    fill: false
                }]
        },
            options: {
            legend: {display: false}
        }
        });

            var today_xValues = [{{ implode(',', $today_internet_speed) }}];
            var today_labels_times = [{{ implode(',', $today_times) }}];

            new Chart("myChart2", {
                type: "line",
                data: {
                    labels: today_labels_times,
                    datasets: [{
                        data: today_xValues,
                        borderColor: "red",
                        fill: "red",
                    }]
                },
                options: {
                    legend: {display: false}
                }
            });
    </script>
@endpush


