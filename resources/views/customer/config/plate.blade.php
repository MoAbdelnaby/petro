@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.config')}}
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
                            <div class="related-heading mb-5">
                                <h2>
                                    <img src="{{resolveDark()}}/img/icon_menu/config.png" width="20" alt=""> {{ __('app.config') }}
                                </h2>
                            </div>
                            <div class="row col-12 p-0 m-0 mb-3 menu-and-filter">
                                <div class="col">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{route('config.index','place')}}">{{ __('app.Place') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{route('config.index','plate')}}">{{ __('app.Plate') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>

                                <div class="tab-content" id="myTabContent">
                                    @include('customer.config.includes._plate')
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
    <script>
        $(document).ready(function () {

            $('.drop-icon').on("click", function (e) {
                $('.dropdown-menu.child').hide()
            })
            $('.dropdown-submenu .dropdown-item').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                if ($(this).next('ul').is(':visible')) {

                    $(this).next('.dropdown-menu').hide();

                } else {
                    // $('.dropdown-menu.child').hide()
                    $(this).next('.dropdown-menu').show();
                }

            });

            $('.dropdown-item.removeDefault').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                $(this).find('.show-icon').toggle();
            });

            /***** Tables Show ******/
            $('.chart-type.tables-type  a.test').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();

                $(this).closest('.tables-type ').find('.dropdown-item').removeClass('selected');
                $(this).addClass('selected');

                $(this).closest('.iq-card ').find('.custom-table table').removeClass().addClass('table');

                if ($(this).hasClass('table-1')) {
                    $(this).closest('.iq-card ').find('.custom-table table').addClass('theme-1')
                } else if ($(this).hasClass('table-2')) {
                    $(this).closest('.iq-card ').find('.custom-table table').addClass('table-bordered')
                } else if ($(this).hasClass('table-3')) {
                    $(this).closest('.iq-card ').find('.custom-table table').addClass('table-striped')
                } else if ($(this).hasClass('table-4')) {
                    $(this).closest('.iq-card ').find('.custom-table table').addClass('table-striped table-dark')
                }

            });

            /***** Charts Show ******/
            $('.chart-type.charts > li > a.test').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();

                $(this).closest('.chart-type ').find('.test').removeClass('selected');
                $(this).addClass('selected');

                if ($(this).hasClass('chart-1')) {

                    var div = $(this).closest('.iq-card ').find('.chartDiv');
                    div.attr("id", Date.now())
                    chart1(div.attr('id'));

                } else if ($(this).hasClass('chart-2')) {
                    var div = $(this).closest('.iq-card ').find('.chartDiv');
                    div.attr("id", Date.now())
                    chart2(div.attr('id'));
                } else if ($(this).hasClass('chart-3')) {
                    var div = $(this).closest('.iq-card ').find('.chartDiv');
                    div.attr("id", Date.now())
                    chart3(div.attr('id'));
                }
                else if ($(this).hasClass('chart-4')) {
                    var div = $(this).closest('.iq-card ').find('.chartDiv');
                    div.attr("id", Date.now())
                    chart4(div.attr('id'));
                } else if ($(this).hasClass('chart-5')) {
                    var div = $(this).closest('.iq-card ').find('.chartDiv');
                    div.attr("id", Date.now())
                    chart5(div.attr('id'));
                }

            });

            var Place1= "{{ __('app.Place1') }}";
            var Place2= "{{ __('app.Place2') }}";
            var Place3= "{{ __('app.Place3') }}";
            var Place4= "{{ __('app.Place4') }}";

            /***** bar chart1 *****/
            function chart1(id) {
                am4core.ready(function () {

                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    // Themes end

                    var chart = am4core.create(id, am4charts.XYChart)
                    chart.colors.list = [
                        am4core.color("#29A0D8"),
                        am4core.color("#EF1B2F"),
                        am4core.color("#13153E"),
                    ];
                    chart.colors.step = 2;

                    chart.legend = new am4charts.Legend()
                    chart.legend.position = 'bottom'
                    chart.legend.paddingBottom = 20
                    chart.legend.labels.template.maxWidth = 95

                    var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
                    xAxis.dataFields.category = 'category'
                    xAxis.renderer.cellStartLocation = 0.1
                    xAxis.renderer.cellEndLocation = 0.9
                    xAxis.renderer.grid.template.location = 0;

                    var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    yAxis.title.text = "{{ __('app.Places') }}";
                    yAxis.min = 0;

                    function createSeries(value, name) {
                        var series = chart.series.push(new am4charts.ColumnSeries())
                        series.dataFields.valueY = value
                        series.dataFields.categoryX = 'category'
                        series.name = name

                        series.events.on("hidden", arrangeColumns);
                        series.events.on("shown", arrangeColumns);

                        var bullet = series.bullets.push(new am4charts.LabelBullet())
                        bullet.interactionsEnabled = false
                        return series;
                    }

                    chart.data = [
                        {
                            category: Place1,
                            first: 40,
                            second: 55,
                        },
                        {
                            category: Place2,
                            first: 30,
                            second: 78,
                        },
                        {
                            category: Place3,
                            first: 27,
                            second: 40,
                        },
                        {
                            category: Place4,
                            first: 50,
                            second: 33,
                        }
                    ]


                    createSeries('first', 'The First');
                    createSeries('second', 'The Second');

                    function arrangeColumns() {

                        var series = chart.series.getIndex(0);

                        var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
                        if (series.dataItems.length > 1) {
                            var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                            var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                            var delta = ((x1 - x0) / chart.series.length) * w;
                            if (am4core.isNumber(delta)) {
                                var middle = chart.series.length / 2;

                                var newIndex = 0;
                                chart.series.each(function (series) {
                                    if (!series.isHidden && !series.isHiding) {
                                        series.dummyData = newIndex;
                                        newIndex++;
                                    } else {
                                        series.dummyData = chart.series.indexOf(series);
                                    }
                                })
                                var visibleCount = newIndex;
                                var newMiddle = visibleCount / 2;

                                chart.series.each(function (series) {
                                    var trueIndex = chart.series.indexOf(series);
                                    var newIndex = series.dummyData;

                                    var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                                    series.animate({
                                        property: "dx",
                                        to: dx
                                    }, series.interpolationDuration, series.interpolationEasing);
                                    series.bulletsContainer.animate({
                                        property: "dx",
                                        to: dx
                                    }, series.interpolationDuration, series.interpolationEasing);
                                })
                            }
                        }
                    }

                    // Add cursor
                    chart.cursor = new am4charts.XYCursor();
                    chart.cursor.lineX.disabled = true;

                }); // end am4core.ready()
            }
            chart1('chart1')
            chart1('chart3')

            /********* Pie chart2*************/
            function chart2(divId) {
                am4core.ready(function () {

                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    // Themes end

                    // Create chart instance
                    var chart = am4core.create(divId, am4charts.PieChart);

                    // Add data
                    chart.data = [{
                        "country": "Lithuania",
                        "litres": 501.9
                    }, {
                        "country": "Czechia",
                        "litres": 301.9
                    }, {
                        "country": "Ireland",
                        "litres": 201.1
                    }, {
                        "country": "Germany",
                        "litres": 165.8
                    }, {
                        "country": "Australia",
                        "litres": 139.9
                    }, {
                        "country": "Austria",
                        "litres": 128.3
                    }, {
                        "country": "UK",
                        "litres": 99
                    }
                    ];
                    chart.legend = new am4charts.Legend()
                    chart.legend.position = 'bottom'
                    chart.legend.paddingBottom = 20
                    chart.legend.labels.template.maxWidth = 95

                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "litres";
                    pieSeries.dataFields.category = "country";
                    pieSeries.slices.template.stroke = am4core.color("#fff");
                    pieSeries.slices.template.strokeOpacity = 1;

                    // This creates initial animation
                    pieSeries.hiddenState.properties.opacity = 1;
                    pieSeries.hiddenState.properties.endAngle = -90;
                    pieSeries.hiddenState.properties.startAngle = -90;

                    chart.hiddenState.properties.radius = am4core.percent(0);


                }); // end am4core.ready()
            }
            chart2('chart2')

            /********* Line chart3*************/
            function chart3(divId) {

                am4core.ready(function() {

                    // Themes begin
                    am4core.useTheme(am4themes_animated);

                    var chart = am4core.create(divId, am4charts.XYChart);
                    chart.colors.list = [
                        am4core.color("#29ABE2"),
                        am4core.color("#732877"),
                        am4core.color("#110B30"),
                    ];
                    chart.data = [{
                        "branch": "Branch 1",
                        "italy": 1,
                        "germany": 5,
                        "uk": 3
                    }, {
                        "branch": "Branch 2",
                        "italy": 1,
                        "germany": 2,
                        "uk": 6
                    }, {
                        "branch": "Branch 3",
                        "italy": 2,
                        "germany": 3,
                        "uk": 1
                    }, {
                        "branch": "Branch 4",
                        "italy": 3,
                        "germany": 4,
                        "uk": 1
                    }, {
                        "branch": "Branch 5",
                        "italy": 5,
                        "germany": 1,
                        "uk": 2
                    }, {
                        "branch": "Branch 6",
                        "italy": 3,
                        "germany": 2,
                        "uk": 1
                    }, {
                        "branch": "Branch 7",
                        "italy": 1,
                        "germany": 2,
                        "uk": 3
                    }, {
                        "branch": "Branch 8",
                        "italy": 2,
                        "germany": 1,
                        "uk": 5
                    }, {
                        "branch": "Branch 9",
                        "italy": 3,
                        "germany": 5,
                        "uk": 2
                    }, {
                        "branch": "Branch 10",
                        "italy": 4,
                        "germany": 3,
                        "uk": 6
                    }];

                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "branch";


                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    valueAxis.title.text = "Place taken";
                    valueAxis.renderer.minLabelPosition = 0.01;


                    var series1 = chart.series.push(new am4charts.LineSeries());
                    series1.dataFields.valueY = "italy";
                    series1.dataFields.categoryX = "branch";
                    series1.name = "Italy";
                    series1.bullets.push(new am4charts.CircleBullet());
                    series1.tooltipText = "Place taken by {name} in {categoryX}: {valueY}";
                    series1.legendSettings.valueText = "{valueY}";
                    series1.visible  = false;

                    var series2 = chart.series.push(new am4charts.LineSeries());
                    series2.dataFields.valueY = "germany";
                    series2.dataFields.categoryX = "branch";
                    series2.name = 'Germany';
                    series2.bullets.push(new am4charts.CircleBullet());
                    series2.tooltipText = "Place taken by {name} in {categoryX}: {valueY}";
                    series2.legendSettings.valueText = "{valueY}";

                    var series3 = chart.series.push(new am4charts.LineSeries());
                    series3.dataFields.valueY = "uk";
                    series3.dataFields.categoryX = "branch";
                    series3.name = 'United Kingdom';
                    series3.bullets.push(new am4charts.CircleBullet());
                    series3.tooltipText = "Place taken by {name} in {categoryX}: {valueY}";
                    series3.legendSettings.valueText = "{valueY}";

// Add chart cursor
                    chart.cursor = new am4charts.XYCursor();
                    chart.cursor.behavior = "zoomY";


                    let hs1 = series1.segments.template.states.create("hover")
                    hs1.properties.strokeWidth = 5;
                    series1.segments.template.strokeWidth = 1;

                    let hs2 = series2.segments.template.states.create("hover")
                    hs2.properties.strokeWidth = 5;
                    series2.segments.template.strokeWidth = 1;

                    let hs3 = series3.segments.template.states.create("hover")
                    hs3.properties.strokeWidth = 5;
                    series3.segments.template.strokeWidth = 1;

                    chart.legend = new am4charts.Legend();
                    chart.legend.itemContainers.template.events.on("over", function(event){
                        var segments = event.target.dataItem.dataContext.segments;
                        segments.each(function(segment){
                            segment.isHover = true;
                        })
                    })

                    chart.legend.itemContainers.template.events.on("out", function(event){
                        var segments = event.target.dataItem.dataContext.segments;
                        segments.each(function(segment){
                            segment.isHover = false;
                        })
                    })

                });
            }

            /********* Bar chart4*************/
            function chart4(divId) {
                am4core.ready(function() {

                    am4core.useTheme(am4themes_animated);

                    var chart = am4core.create(divId, am4charts.XYChart);

                    var data = [
                        {
                            country: "Lithuania",
                            research: 501.9
                        },
                        {
                            country: "Czechia",
                            research: 301.9
                        },
                        {
                            country: "Ireland",
                            research: 271.1
                        },
                        {
                            country: "Hungary",
                            research: 361.9
                        },
                        {
                            country: "Poland",
                            research: 271.1
                        }
                    ];

                    chart.data = data;
// Create axes
                    var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "country";
                    categoryAxis.renderer.grid.template.location = 0;
                    categoryAxis.renderer.minGridDistance = 10;
                    categoryAxis.interpolationDuration = 2000;

                    var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());

// Create series
                    function createSeries(field, name) {
                        var series = chart.series.push(new am4charts.ColumnSeries());
                        series.dataFields.valueX = "research";
                        series.dataFields.categoryY = "country";
                        series.columns.template.tooltipText = "[bold]{valueX}[/]";
                        series.columns.template.cursorOverStyle = am4core.MouseCursorStyle.pointer;

                        var hs = series.columns.template.states.create("hover");
                        hs.properties.fillOpacity = 0.7;

                        var columnTemplate = series.columns.template;
                        columnTemplate.maxX = 0;
                        columnTemplate.draggable = true;

                        columnTemplate.events.on("dragstart", function (ev) {
                            var dataItem = ev.target.dataItem;

                            var axislabelItem = categoryAxis.dataItemsByCategory.getKey(
                                dataItem.categoryY
                            )._label;
                            axislabelItem.isMeasured = false;
                            axislabelItem.minX = axislabelItem.pixelX;
                            axislabelItem.maxX = axislabelItem.pixelX;

                            axislabelItem.dragStart(ev.target.interactions.downPointers.getIndex(0));
                            axislabelItem.dragStart(ev.pointer);
                        });
                        columnTemplate.events.on("dragstop", function (ev) {
                            var dataItem = ev.target.dataItem;
                            var axislabelItem = categoryAxis.dataItemsByCategory.getKey(
                                dataItem.categoryY
                            )._label;
                            axislabelItem.dragStop();
                            handleDragStop(ev);
                        });
                    }
                    createSeries("research", "Research");

                    function handleDragStop(ev) {
                        data = [];
                        chart.series.each(function (series) {
                            if (series instanceof am4charts.ColumnSeries) {
                                series.dataItems.values.sort(compare);

                                var indexes = {};
                                series.dataItems.each(function (seriesItem, index) {
                                    indexes[seriesItem.categoryY] = index;
                                });

                                categoryAxis.dataItems.values.sort(function (a, b) {
                                    var ai = indexes[a.category];
                                    var bi = indexes[b.category];
                                    if (ai == bi) {
                                        return 0;
                                    } else if (ai < bi) {
                                        return -1;
                                    } else {
                                        return 1;
                                    }
                                });

                                var i = 0;
                                categoryAxis.dataItems.each(function (dataItem) {
                                    dataItem._index = i;
                                    i++;
                                });

                                categoryAxis.validateDataItems();
                                series.validateDataItems();
                            }
                        });
                    }

                    function compare(a, b) {
                        if (a.column.pixelY < b.column.pixelY) {
                            return 1;
                        }
                        if (a.column.pixelY > b.column.pixelY) {
                            return -1;
                        }
                        return 0;
                    }

                }); // end am4core.ready()
            }

            /********* Bar chart5*************/
            function chart5(divId) {
                am4core.ready(function() {

                    am4core.useTheme(am4themes_animated);

                    var chart = am4core.create(divId, am4charts.XYChart);
                    chart.padding(40, 40, 40, 40);

                    chart.numberFormatter.bigNumberPrefixes = [
                        { "number": 1e+3, "suffix": "K" },
                        { "number": 1e+6, "suffix": "M" },
                        { "number": 1e+9, "suffix": "B" }
                    ];

                    var label = chart.plotContainer.createChild(am4core.Label);
                    label.x = am4core.percent(97);
                    label.y = am4core.percent(95);
                    label.horizontalCenter = "right";
                    label.verticalCenter = "middle";
                    label.dx = -15;
                    label.fontSize = 50;

                    var playButton = chart.plotContainer.createChild(am4core.PlayButton);
                    playButton.x = am4core.percent(97);
                    playButton.y = am4core.percent(95);
                    playButton.dy = -2;
                    playButton.verticalCenter = "middle";
                    playButton.events.on("toggled", function(event) {
                        if (event.target.isActive) {
                            play();
                        }
                        else {
                            stop();
                        }
                    })

                    var stepDuration = 4000;

                    var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.renderer.grid.template.location = 0;
                    categoryAxis.dataFields.category = "network";
                    categoryAxis.renderer.minGridDistance = 1;
                    categoryAxis.renderer.inversed = true;
                    categoryAxis.renderer.grid.template.disabled = true;

                    var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                    valueAxis.min = 0;
                    valueAxis.rangeChangeEasing = am4core.ease.linear;
                    valueAxis.rangeChangeDuration = stepDuration;
                    valueAxis.extraMax = 0.1;

                    var series = chart.series.push(new am4charts.ColumnSeries());
                    series.dataFields.categoryY = "network";
                    series.dataFields.valueX = "MAU";
                    series.tooltipText = "{valueX.value}"
                    series.columns.template.strokeOpacity = 0;
                    series.columns.template.column.cornerRadiusBottomRight = 5;
                    series.columns.template.column.cornerRadiusTopRight = 5;
                    series.interpolationDuration = stepDuration;
                    series.interpolationEasing = am4core.ease.linear;

                    var labelBullet = series.bullets.push(new am4charts.LabelBullet())
                    labelBullet.label.horizontalCenter = "right";
                    labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}";
                    labelBullet.label.textAlign = "end";
                    labelBullet.label.dx = -10;

                    chart.zoomOutButton.disabled = true;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
                    series.columns.template.adapter.add("fill", function(fill, target){
                        return chart.colors.getIndex(target.dataItem.index);
                    });

                    var year = 2003;
                    label.text = year.toString();

                    var interval;

                    function play() {
                        interval = setInterval(function(){
                            nextYear();
                        }, stepDuration)
                        nextYear();
                    }

                    function stop() {
                        if (interval) {
                            clearInterval(interval);
                        }
                    }

                    function nextYear() {
                        year++

                        if (year > 2018) {
                            year = 2003;
                        }

                        var newData = allData[year];
                        var itemsWithNonZero = 0;
                        for (var i = 0; i < chart.data.length; i++) {
                            chart.data[i].MAU = newData[i].MAU;
                            if (chart.data[i].MAU > 0) {
                                itemsWithNonZero++;
                            }
                        }

                        if (year == 2003) {
                            series.interpolationDuration = stepDuration / 4;
                            valueAxis.rangeChangeDuration = stepDuration / 4;
                        }
                        else {
                            series.interpolationDuration = stepDuration;
                            valueAxis.rangeChangeDuration = stepDuration;
                        }

                        chart.invalidateRawData();
                        label.text = year.toString();

                        categoryAxis.zoom({ start: 0, end: itemsWithNonZero / categoryAxis.dataItems.length });
                    }


                    categoryAxis.sortBySeries = series;

                    var allData = {
                        "2003": [
                            {
                                "network": "Facebook",
                                "MAU": 0
                            },
                            {
                                "network": "Flickr",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },

                            {
                                "network": "Friendster",
                                "MAU": 4470000
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 0
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 0
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 0
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 0
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 0
                            }
                        ],
                        "2004": [
                            {
                                "network": "Facebook",
                                "MAU": 0
                            },
                            {
                                "network": "Flickr",
                                "MAU": 3675135
                            },
                            {
                                "network": "Friendster",
                                "MAU": 5970054
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 980036
                            },
                            {
                                "network": "Orkut",
                                "MAU": 4900180
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 0
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 0
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 0
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 0
                            }
                        ],
                        "2005": [
                            {
                                "network": "Facebook",
                                "MAU": 0
                            },
                            {
                                "network": "Flickr",
                                "MAU": 7399354
                            },
                            {
                                "network": "Friendster",
                                "MAU": 7459742
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 9731610
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 19490059
                            },
                            {
                                "network": "Orkut",
                                "MAU": 9865805
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 0
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 0
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 0
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 1946322
                            }
                        ],
                        "2006": [
                            {
                                "network": "Facebook",
                                "MAU": 0
                            },
                            {
                                "network": "Flickr",
                                "MAU": 14949270
                            },
                            {
                                "network": "Friendster",
                                "MAU": 8989854
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 19932360
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 54763260
                            },
                            {
                                "network": "Orkut",
                                "MAU": 14966180
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 248309
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 0
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 0
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 19878248
                            }
                        ],
                        "2007": [
                            {
                                "network": "Facebook",
                                "MAU": 0
                            },
                            {
                                "network": "Flickr",
                                "MAU": 29299875
                            },
                            {
                                "network": "Friendster",
                                "MAU": 24253200
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 29533250
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 69299875
                            },
                            {
                                "network": "Orkut",
                                "MAU": 26916562
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 488331
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 0
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 0
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 143932250
                            }
                        ],
                        "2008": [
                            {
                                "network": "Facebook",
                                "MAU": 100000000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 30000000
                            },
                            {
                                "network": "Friendster",
                                "MAU": 51008911
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 55045618
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 72408233
                            },
                            {
                                "network": "Orkut",
                                "MAU": 44357628
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 1944940
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 0
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 0
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 294493950
                            }
                        ],
                        "2009": [
                            {
                                "network": "Facebook",
                                "MAU": 276000000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 41834525
                            },
                            {
                                "network": "Friendster",
                                "MAU": 28804331
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 57893524
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 70133095
                            },
                            {
                                "network": "Orkut",
                                "MAU": 47366905
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 3893524
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 0
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 0
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 413611440
                            }
                        ],
                        "2010": [
                            {
                                "network": "Facebook",
                                "MAU": 517750000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 54708063
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 166029650
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 59953290
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 68046710
                            },
                            {
                                "network": "Orkut",
                                "MAU": 49941613
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 0
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 43250000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 0
                            },
                            {
                                "network": "Weibo",
                                "MAU": 19532900
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 480551990
                            }
                        ],
                        "2011": [
                            {
                                "network": "Facebook",
                                "MAU": 766000000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 66954600
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 170000000
                            },
                            {
                                "network": "Google+",
                                "MAU": 0
                            },
                            {
                                "network": "Hi5",
                                "MAU": 46610848
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 46003536
                            },
                            {
                                "network": "Orkut",
                                "MAU": 47609080
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 0
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 0
                            },
                            {
                                "network": "Twitter",
                                "MAU": 92750000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 47818400
                            },
                            {
                                "network": "Weibo",
                                "MAU": 48691040
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 642669824
                            }
                        ],
                        "2012": [
                            {
                                "network": "Facebook",
                                "MAU": 979750000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 79664888
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 170000000
                            },
                            {
                                "network": "Google+",
                                "MAU": 107319100
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 0
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 45067022
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 0
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 146890156
                            },
                            {
                                "network": "Twitter",
                                "MAU": 160250000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 118123370
                            },
                            {
                                "network": "Weibo",
                                "MAU": 79195730
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 0
                            },
                            {
                                "network": "YouTube",
                                "MAU": 844638200
                            }
                        ],
                        "2013": [
                            {
                                "network": "Facebook",
                                "MAU": 1170500000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 80000000
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 170000000
                            },
                            {
                                "network": "Google+",
                                "MAU": 205654700
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 117500000
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 0
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 0
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 293482050
                            },
                            {
                                "network": "Twitter",
                                "MAU": 223675000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 196523760
                            },
                            {
                                "network": "Weibo",
                                "MAU": 118261880
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 300000000
                            },
                            {
                                "network": "YouTube",
                                "MAU": 1065223075
                            }
                        ],
                        "2014": [
                            {
                                "network": "Facebook",
                                "MAU": 1334000000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 0
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 170000000
                            },
                            {
                                "network": "Google+",
                                "MAU": 254859015
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 250000000
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 0
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 135786956
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 388721163
                            },
                            {
                                "network": "Twitter",
                                "MAU": 223675000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 444232415
                            },
                            {
                                "network": "Weibo",
                                "MAU": 154890345
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 498750000
                            },
                            {
                                "network": "YouTube",
                                "MAU": 1249451725
                            }
                        ],
                        "2015": [
                            {
                                "network": "Facebook",
                                "MAU": 1516750000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 0
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 170000000
                            },
                            {
                                "network": "Google+",
                                "MAU": 298950015
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 400000000
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 0
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 0
                            },
                            {
                                "network": "Reddit",
                                "MAU": 163346676
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 475923363
                            },
                            {
                                "network": "Twitter",
                                "MAU": 304500000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 660843407
                            },
                            {
                                "network": "Weibo",
                                "MAU": 208716685
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 800000000
                            },
                            {
                                "network": "YouTube",
                                "MAU": 1328133360
                            }
                        ],
                        "2016": [
                            {
                                "network": "Facebook",
                                "MAU": 1753500000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 0
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 398648000
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 550000000
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 0
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 143250000
                            },
                            {
                                "network": "Reddit",
                                "MAU": 238972480
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 238648000
                            },
                            {
                                "network": "TikTok",
                                "MAU": 0
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 565796720
                            },
                            {
                                "network": "Twitter",
                                "MAU": 314500000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 847512320
                            },
                            {
                                "network": "Weibo",
                                "MAU": 281026560
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 1000000000
                            },
                            {
                                "network": "YouTube",
                                "MAU": 1399053600
                            }
                        ],
                        "2017": [
                            {
                                "network": "Facebook",
                                "MAU": 2035750000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 0
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 495657000
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 750000000
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 0
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 195000000
                            },
                            {
                                "network": "Reddit",
                                "MAU": 297394200
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 239142500
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 593783960
                            },
                            {
                                "network": "Twitter",
                                "MAU": 328250000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 921742750
                            },
                            {
                                "network": "Weibo",
                                "MAU": 357569030
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 1333333333
                            },
                            {
                                "network": "YouTube",
                                "MAU": 1495657000
                            }
                        ],
                        "2018": [
                            {
                                "network": "Facebook",
                                "MAU": 2255250000
                            },
                            {
                                "network": "Flickr",
                                "MAU": 0
                            },
                            {
                                "network": "Friendster",
                                "MAU": 0
                            },
                            {
                                "network": "Google Buzz",
                                "MAU": 0
                            },
                            {
                                "network": "Google+",
                                "MAU": 430000000
                            },
                            {
                                "network": "Hi5",
                                "MAU": 0
                            },
                            {
                                "network": "Instagram",
                                "MAU": 1000000000
                            },
                            {
                                "network": "MySpace",
                                "MAU": 0
                            },
                            {
                                "network": "Orkut",
                                "MAU": 0
                            },
                            {
                                "network": "Pinterest",
                                "MAU": 246500000
                            },
                            {
                                "network": "Reddit",
                                "MAU": 355000000
                            },
                            {
                                "network": "Snapchat",
                                "MAU": 0
                            },
                            {
                                "network": "TikTok",
                                "MAU": 500000000
                            },
                            {
                                "network": "Tumblr",
                                "MAU": 624000000
                            },
                            {
                                "network": "Twitter",
                                "MAU": 329500000
                            },
                            {
                                "network": "WeChat",
                                "MAU": 1000000000
                            },
                            {
                                "network": "Weibo",
                                "MAU": 431000000
                            },
                            {
                                "network": "Whatsapp",
                                "MAU": 1433333333
                            },
                            {
                                "network": "YouTube",
                                "MAU": 1900000000
                            }
                        ]
                    }

                    chart.data = JSON.parse(JSON.stringify(allData[year]));
                    categoryAxis.zoom({ start: 0, end: 1 / chart.data.length });

                    series.events.on("inited", function() {
                        setTimeout(function() {
                            playButton.isActive = true; // this starts interval
                        }, 2000)
                    })

                }); // end am4core.ready()
            }
        })
    </script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script>
        $(function () {
            $("#sortable").sortable();
            $("#sortable").disableSelection();
        });
    </script>
@endpush
