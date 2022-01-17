/*** Helper Function ***/
function getMonths(startDate, endDate) {
    var resultList = [];
    var date = new Date(startDate);
    var endDate = new Date(endDate);
    var monthNameList = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];

    while (date <= endDate) {
        var stringDate =
            monthNameList[date.getMonth()] + " " + date.getFullYear();

        //get first and last day of month
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

        resultList.push({
            str: stringDate,
            first: firstDay,
            last: lastDay,
        });
        date.setMonth(date.getMonth() + 1);
    }

    return resultList;
}

function branchPlaceBar(id, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(id, am4charts.XYChart);
        chart.colors.list = [
            am4core.color("#29A0D8"),
            am4core.color("#110B30"),
            am4core.color("#13153E"),
        ];

        chart.colors.step = 1;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "area";
        xAxis.renderer.cellStartLocation = 0.1;
        xAxis.renderer.cellEndLocation = 0.9;
        xAxis.renderer.grid.template.location = 0;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.title.text = "Hours";
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = value;
            series.dataFields.categoryX = "area";
            series.name = name;

            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet());
            bullet.interactionsEnabled = false;
            return series;
        }

        chart.data = data;

        createSeries("work", "Work Duration");
        createSeries("empty", "Empty Duration");

        function arrangeColumns() {
            var series = chart.series.getIndex(0);

            var w =
                1 -
                xAxis.renderer.cellStartLocation -
                (1 - xAxis.renderer.cellEndLocation);
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
                    });
                    var visibleCount = newIndex;
                    var newMiddle = visibleCount / 2;

                    chart.series.each(function (series) {
                        var trueIndex = chart.series.indexOf(series);
                        var newIndex = series.dummyData;

                        var dx =
                            (newIndex - trueIndex + middle - newMiddle) * delta;

                        series.animate(
                            {
                                property: "dx",
                                to: dx,
                            },
                            series.interpolationDuration,
                            series.interpolationEasing
                        );
                        series.bulletsContainer.animate(
                            {
                                property: "dx",
                                to: dx,
                            },
                            series.interpolationDuration,
                            series.interpolationEasing
                        );
                    });
                }
            }
        }

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineX.disabled = true;
    }); // end am4core.ready()
}

function branchPlaceCircleWork(divId, data) {
    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        // Create chart instance
        var chart = am4core.create(divId, am4charts.PieChart);
        // Add data
        chart.data = data;
        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "value";
        pieSeries.dataFields.category = "branch";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeOpacity = 1;
        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        chart.hiddenState.properties.radius = am4core.percent(0);
    }); // end am4core.ready()
}

function branchPlaceCircleEmpty(divId, data) {
    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create(divId, am4charts.PieChart);

        // Add data
        chart.data = data;

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "value";
        pieSeries.dataFields.category = "branch";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeOpacity = 1;

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

        chart.hiddenState.properties.radius = am4core.percent(0);
    }); // end am4core.ready()
}

function branchPlaceLine(divId, data) {
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
        categoryAxis.dataFields.category = "area";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Work Duration";
        valueAxis.renderer.minLabelPosition = 0.01;

        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "work";
        series1.dataFields.categoryX = "area";
        series1.name = "Work Duration (Hours)";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "Work Duration {categoryX}: {valueY} Hours";
        series1.legendSettings.valueText = "{valueY}";
        series1.visible = false;

        var series2 = chart.series.push(new am4charts.LineSeries());
        series2.dataFields.valueY = "empty";
        series2.dataFields.categoryX = "area";
        series2.name = "Empty Duration (Hours)";
        series2.bullets.push(new am4charts.CircleBullet());
        series2.tooltipText = "Empty Duration {categoryX}: {valueY} Hours";
        series2.legendSettings.valueText = "{valueY}";

        // Add chart cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";

        let hs1 = series1.segments.template.states.create("hover");
        hs1.properties.strokeWidth = 5;
        series1.segments.template.strokeWidth = 1;

        let hs2 = series2.segments.template.states.create("hover");
        hs2.properties.strokeWidth = 5;
        series2.segments.template.strokeWidth = 1;

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

function branchPlateBar(id, data) {
    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create(id, am4charts.XYChart);
        chart.colors.list = [
            am4core.color("#29A0D8"),
            am4core.color("#29ABE2"),
            am4core.color("#13153E"),
        ];
        chart.colors.step = 2;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "area";
        xAxis.renderer.cellStartLocation = 0.1;
        xAxis.renderer.cellEndLocation = 0.9;
        xAxis.renderer.grid.template.location = 0;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.title.text = "Count";
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = value;
            series.dataFields.categoryX = "area";
            series.name = name;
            series.columns.template.width = am4core.percent(30);

            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet());
            bullet.interactionsEnabled = false;
            return series;
        }

        chart.data = data;

        createSeries("count", "Car Count");

        function arrangeColumns() {
            var series = chart.series.getIndex(0);

            var w =
                1 -
                xAxis.renderer.cellStartLocation -
                (1 - xAxis.renderer.cellEndLocation);
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
                    });
                    var visibleCount = newIndex;
                    var newMiddle = visibleCount / 2;

                    chart.series.each(function (series) {
                        var trueIndex = chart.series.indexOf(series);
                        var newIndex = series.dummyData;

                        var dx =
                            (newIndex - trueIndex + middle - newMiddle) * delta;

                        series.animate(
                            {
                                property: "dx",
                                to: dx,
                            },
                            series.interpolationDuration,
                            series.interpolationEasing
                        );
                        series.bulletsContainer.animate(
                            {
                                property: "dx",
                                to: dx,
                            },
                            series.interpolationDuration,
                            series.interpolationEasing
                        );
                    });
                }
            }
        }

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineX.disabled = true;
    }); // end am4core.ready()
}

function branchPlateCircle(divId, data) {
    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create(divId, am4charts.PieChart);

        // Add data
        chart.data = data;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "count";
        pieSeries.dataFields.category = "area";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeOpacity = 1;

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

        chart.hiddenState.properties.radius = am4core.percent(0);
    }); // end am4core.ready()
}

function branchPlateLine(divId, data) {
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
        categoryAxis.dataFields.category = "area";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Car Count";
        valueAxis.renderer.minLabelPosition = 0.01;

        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "count";
        series1.dataFields.categoryX = "area";
        series1.name = "Car Count";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "Car Count {categoryX}: {valueY}";
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

function branchPlaceSideBar(divId, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.XYChart);

        chart.data = data;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "area";
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.location = 0;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.opposite = true;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryY = "area";
        series.dataFields.valueX = "work";
        series.name = "Work Duration (Hours)";
        series.columns.template.fillOpacity = 0.5;
        series.columns.template.strokeOpacity = 0;
        series.tooltipText = "Work Duration in {categoryY}: {valueX.value}";

        var lineSeries = chart.series.push(new am4charts.LineSeries());
        lineSeries.dataFields.categoryY = "area";
        lineSeries.dataFields.valueX = "empty";
        lineSeries.name = "Empty Duration (Hours)";
        lineSeries.strokeWidth = 3;
        lineSeries.tooltipText =
            "Empty Duration in {categoryY}: {valueX.value} Hours";

        var circleBullet = lineSeries.bullets.push(
            new am4charts.CircleBullet()
        );
        circleBullet.circle.fill = am4core.color("#fff");
        circleBullet.circle.strokeWidth = 2;

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";

        chart.legend = new am4charts.Legend();
    });
}

function branchPlateSideBar(divId, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.XYChart);

        chart.data = data;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "area";
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.location = 0;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.opposite = true;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryY = "area";
        series.dataFields.valueX = "count";
        series.name = "Car Count";
        series.columns.template.fillOpacity = 0.5;
        series.columns.template.strokeOpacity = 0;
        series.tooltipText = "Car Count in {categoryY}: {valueX.value} Hours";

        //add chart cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";

        //add legend
        chart.legend = new am4charts.Legend();
    }); // end am4core.ready()
}

function branchPlaceTrendLine(divId){
    am4core.ready(function() {

        am4core.useTheme(am4themes_animated);

        var chart = am4core.create(divId, am4charts.XYChart);

        chart.data = generateChartData();

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "visits";
        series.dataFields.dateX = "date";
        series.strokeWidth = 1;
        series.minBulletDistance = 10;
        series.tooltipText = "{valueY}";
        series.fillOpacity = 0.1;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.getFillFromObject = false;
        series.tooltip.background.fill = series.fill;

        var seriesRange = dateAxis.createSeriesRange(series);
        seriesRange.contents.strokeDasharray = "2,3";
        seriesRange.contents.stroke = chart.colors.getIndex(8);
        seriesRange.contents.strokeWidth = 1;

        var pattern = new am4core.LinePattern();
        pattern.rotation = -45;
        pattern.stroke = seriesRange.contents.stroke;
        pattern.width = 1000;
        pattern.height = 1000;
        pattern.gap = 6;
        seriesRange.contents.fill = pattern;
        seriesRange.contents.fillOpacity = 0.5;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Cursor
        chart.cursor = new am4charts.XYCursor();

        function generateChartData() {
            var chartData = [];
            var firstDate = new Date();
            firstDate.setDate(firstDate.getDate() - 200);
            var visits = 1200;
            for (var i = 0; i < 200; i++) {
                // we create date objects here. In your data, you can have date strings
                // and then set format of your dates using chart.dataDateFormat property,
                // however when possible, use date objects, as this will speed up chart rendering.
                var newDate = new Date(firstDate);
                newDate.setDate(newDate.getDate() + i);

                visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);

                chartData.push({
                    date: newDate,
                    visits: visits
                });
            }
            return chartData;
        }

        // add range
        var range = dateAxis.axisRanges.push(new am4charts.DateAxisDataItem());
        range.grid.stroke = chart.colors.getIndex(0);
        range.grid.strokeOpacity = 1;
        range.bullet = new am4core.ResizeButton();
        range.bullet.background.fill = chart.colors.getIndex(0);
        range.bullet.background.states.copyFrom(chart.zoomOutButton.background.states);
        range.bullet.minX = 0;
        range.bullet.adapter.add("minY", function(minY, target) {
            target.maxY = chart.plotContainer.maxHeight;
            target.maxX = chart.plotContainer.maxWidth;
            return chart.plotContainer.maxHeight;
        })

        range.bullet.events.on("dragged", function() {
            range.value = dateAxis.xToValue(range.bullet.pixelX);
            seriesRange.value = range.value;
        })


        var firstTime = chart.data[0].date.getTime();
        var lastTime = chart.data[chart.data.length - 1].date.getTime();
        var date = new Date(firstTime + (lastTime - firstTime) / 2);

        range.date = date;

        seriesRange.date = date;
        seriesRange.endDate = chart.data[chart.data.length - 1].date;



    }); // end am4core.ready()
}

function branchPlateTrendLine(divId){
    am4core.ready(function() {

        am4core.useTheme(am4themes_animated);

        var chart = am4core.create(divId, am4charts.XYChart);

        chart.data = generateChartData();

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "visits";
        series.dataFields.dateX = "date";
        series.strokeWidth = 1;
        series.minBulletDistance = 10;
        series.tooltipText = "{valueY}";
        series.fillOpacity = 0.1;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.getFillFromObject = false;
        series.tooltip.background.fill = series.fill;

        var seriesRange = dateAxis.createSeriesRange(series);
        seriesRange.contents.strokeDasharray = "2,3";
        seriesRange.contents.stroke = chart.colors.getIndex(8);
        seriesRange.contents.strokeWidth = 1;

        var pattern = new am4core.LinePattern();
        pattern.rotation = -45;
        pattern.stroke = seriesRange.contents.stroke;
        pattern.width = 1000;
        pattern.height = 1000;
        pattern.gap = 6;
        seriesRange.contents.fill = pattern;
        seriesRange.contents.fillOpacity = 0.5;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Cursor
        chart.cursor = new am4charts.XYCursor();

        function generateChartData() {
            var chartData = [];
            var firstDate = new Date();
            firstDate.setDate(firstDate.getDate() - 200);
            var visits = 1200;
            for (var i = 0; i < 200; i++) {
                // we create date objects here. In your data, you can have date strings
                // and then set format of your dates using chart.dataDateFormat property,
                // however when possible, use date objects, as this will speed up chart rendering.
                var newDate = new Date(firstDate);
                newDate.setDate(newDate.getDate() + i);

                visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);

                chartData.push({
                    date: newDate,
                    visits: visits
                });
            }
            return chartData;
        }

        // add range
        var range = dateAxis.axisRanges.push(new am4charts.DateAxisDataItem());
        range.grid.stroke = chart.colors.getIndex(0);
        range.grid.strokeOpacity = 1;
        range.bullet = new am4core.ResizeButton();
        range.bullet.background.fill = chart.colors.getIndex(0);
        range.bullet.background.states.copyFrom(chart.zoomOutButton.background.states);
        range.bullet.minX = 0;
        range.bullet.adapter.add("minY", function(minY, target) {
            target.maxY = chart.plotContainer.maxHeight;
            target.maxX = chart.plotContainer.maxWidth;
            return chart.plotContainer.maxHeight;
        })

        range.bullet.events.on("dragged", function() {
            range.value = dateAxis.xToValue(range.bullet.pixelX);
            seriesRange.value = range.value;
        })


        var firstTime = chart.data[0].date.getTime();
        var lastTime = chart.data[chart.data.length - 1].date.getTime();
        var date = new Date(firstTime + (lastTime - firstTime) / 2);

        range.date = date;

        seriesRange.date = date;
        seriesRange.endDate = chart.data[chart.data.length - 1].date;



    }); // end am4core.ready()
}

function branchPlaceSmooth(divId){
    am4core.ready(function() {

        am4core.useTheme(am4themes_animated);

        var chart = am4core.create(divId, am4charts.XYChart);

        chart.data = generateChartData();

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "visits";
        series.dataFields.dateX = "date";
        series.strokeWidth = 1;
        series.minBulletDistance = 10;
        series.tooltipText = "{valueY}";
        series.fillOpacity = 0.1;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.getFillFromObject = false;
        series.tooltip.background.fill = series.fill;

        var seriesRange = dateAxis.createSeriesRange(series);
        seriesRange.contents.strokeDasharray = "2,3";
        seriesRange.contents.stroke = chart.colors.getIndex(8);
        seriesRange.contents.strokeWidth = 1;

        var pattern = new am4core.LinePattern();
        pattern.rotation = -45;
        pattern.stroke = seriesRange.contents.stroke;
        pattern.width = 1000;
        pattern.height = 1000;
        pattern.gap = 6;
        seriesRange.contents.fill = pattern;
        seriesRange.contents.fillOpacity = 0.5;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Cursor
        chart.cursor = new am4charts.XYCursor();

        function generateChartData() {
            var chartData = [];
            var firstDate = new Date();
            firstDate.setDate(firstDate.getDate() - 200);
            var visits = 1200;
            for (var i = 0; i < 200; i++) {
                // we create date objects here. In your data, you can have date strings
                // and then set format of your dates using chart.dataDateFormat property,
                // however when possible, use date objects, as this will speed up chart rendering.
                var newDate = new Date(firstDate);
                newDate.setDate(newDate.getDate() + i);

                visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);

                chartData.push({
                    date: newDate,
                    visits: visits
                });
            }
            return chartData;
        }

        // add range
        var range = dateAxis.axisRanges.push(new am4charts.DateAxisDataItem());
        range.grid.stroke = chart.colors.getIndex(0);
        range.grid.strokeOpacity = 1;
        range.bullet = new am4core.ResizeButton();
        range.bullet.background.fill = chart.colors.getIndex(0);
        range.bullet.background.states.copyFrom(chart.zoomOutButton.background.states);
        range.bullet.minX = 0;
        range.bullet.adapter.add("minY", function(minY, target) {
            target.maxY = chart.plotContainer.maxHeight;
            target.maxX = chart.plotContainer.maxWidth;
            return chart.plotContainer.maxHeight;
        })

        range.bullet.events.on("dragged", function() {
            range.value = dateAxis.xToValue(range.bullet.pixelX);
            seriesRange.value = range.value;
        })


        var firstTime = chart.data[0].date.getTime();
        var lastTime = chart.data[chart.data.length - 1].date.getTime();
        var date = new Date(firstTime + (lastTime - firstTime) / 2);

        range.date = date;

        seriesRange.date = date;
        seriesRange.endDate = chart.data[chart.data.length - 1].date;



    }); // end am4core.ready()
}

function branchPlateSmooth(divId){
    am4core.ready(function() {

        am4core.useTheme(am4themes_animated);

        var chart = am4core.create(divId, am4charts.XYChart);

        chart.data = generateChartData();

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "visits";
        series.dataFields.dateX = "date";
        series.strokeWidth = 1;
        series.minBulletDistance = 10;
        series.tooltipText = "{valueY}";
        series.fillOpacity = 0.1;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.getFillFromObject = false;
        series.tooltip.background.fill = series.fill;

        var seriesRange = dateAxis.createSeriesRange(series);
        seriesRange.contents.strokeDasharray = "2,3";
        seriesRange.contents.stroke = chart.colors.getIndex(8);
        seriesRange.contents.strokeWidth = 1;

        var pattern = new am4core.LinePattern();
        pattern.rotation = -45;
        pattern.stroke = seriesRange.contents.stroke;
        pattern.width = 1000;
        pattern.height = 1000;
        pattern.gap = 6;
        seriesRange.contents.fill = pattern;
        seriesRange.contents.fillOpacity = 0.5;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Cursor
        chart.cursor = new am4charts.XYCursor();

        function generateChartData() {
            var chartData = [];
            var firstDate = new Date();
            firstDate.setDate(firstDate.getDate() - 200);
            var visits = 1200;
            for (var i = 0; i < 200; i++) {
                // we create date objects here. In your data, you can have date strings
                // and then set format of your dates using chart.dataDateFormat property,
                // however when possible, use date objects, as this will speed up chart rendering.
                var newDate = new Date(firstDate);
                newDate.setDate(newDate.getDate() + i);

                visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);

                chartData.push({
                    date: newDate,
                    visits: visits
                });
            }
            return chartData;
        }

        // add range
        var range = dateAxis.axisRanges.push(new am4charts.DateAxisDataItem());
        range.grid.stroke = chart.colors.getIndex(0);
        range.grid.strokeOpacity = 1;
        range.bullet = new am4core.ResizeButton();
        range.bullet.background.fill = chart.colors.getIndex(0);
        range.bullet.background.states.copyFrom(chart.zoomOutButton.background.states);
        range.bullet.minX = 0;
        range.bullet.adapter.add("minY", function(minY, target) {
            target.maxY = chart.plotContainer.maxHeight;
            target.maxX = chart.plotContainer.maxWidth;
            return chart.plotContainer.maxHeight;
        })

        range.bullet.events.on("dragged", function() {
            range.value = dateAxis.xToValue(range.bullet.pixelX);
            seriesRange.value = range.value;
        })


        var firstTime = chart.data[0].date.getTime();
        var lastTime = chart.data[chart.data.length - 1].date.getTime();
        var date = new Date(firstTime + (lastTime - firstTime) / 2);

        range.date = date;

        seriesRange.date = date;
        seriesRange.endDate = chart.data[chart.data.length - 1].date;



    }); // end am4core.ready()
}

function branchInvoiceBar(id, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(id, am4charts.XYChart);
        chart.colors.list = [
            am4core.color("#29A0D8"),
            am4core.color("#110B30"),
            am4core.color("#13153E"),
        ];

        chart.colors.step = 1;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "area";
        xAxis.renderer.cellStartLocation = 0.1;
        xAxis.renderer.cellEndLocation = 0.9;
        xAxis.renderer.grid.template.location = 0;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.title.text = "Hours";
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = value;
            series.dataFields.categoryX = "area";
            series.name = name;

            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet());
            bullet.interactionsEnabled = false;
            return series;
        }

        chart.data = data;

        createSeries("work", "Work Duration");
        createSeries("empty", "Empty Duration");

        function arrangeColumns() {
            var series = chart.series.getIndex(0);

            var w =
                1 -
                xAxis.renderer.cellStartLocation -
                (1 - xAxis.renderer.cellEndLocation);
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
                    });
                    var visibleCount = newIndex;
                    var newMiddle = visibleCount / 2;

                    chart.series.each(function (series) {
                        var trueIndex = chart.series.indexOf(series);
                        var newIndex = series.dummyData;

                        var dx =
                            (newIndex - trueIndex + middle - newMiddle) * delta;

                        series.animate(
                            {
                                property: "dx",
                                to: dx,
                            },
                            series.interpolationDuration,
                            series.interpolationEasing
                        );
                        series.bulletsContainer.animate(
                            {
                                property: "dx",
                                to: dx,
                            },
                            series.interpolationDuration,
                            series.interpolationEasing
                        );
                    });
                }
            }
        }

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineX.disabled = true;
    }); // end am4core.ready()
}

function branchInvoiceLine(divId, data) {
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
        categoryAxis.dataFields.category = "area";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Work Duration";
        valueAxis.renderer.minLabelPosition = 0.01;

        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "work";
        series1.dataFields.categoryX = "area";
        series1.name = "Work Duration (Hours)";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "Work Duration {categoryX}: {valueY} Hours";
        series1.legendSettings.valueText = "{valueY}";
        series1.visible = false;

        var series2 = chart.series.push(new am4charts.LineSeries());
        series2.dataFields.valueY = "empty";
        series2.dataFields.categoryX = "area";
        series2.name = "Empty Duration (Hours)";
        series2.bullets.push(new am4charts.CircleBullet());
        series2.tooltipText = "Empty Duration {categoryX}: {valueY} Hours";
        series2.legendSettings.valueText = "{valueY}";

        // Add chart cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";

        let hs1 = series1.segments.template.states.create("hover");
        hs1.properties.strokeWidth = 5;
        series1.segments.template.strokeWidth = 1;

        let hs2 = series2.segments.template.states.create("hover");
        hs2.properties.strokeWidth = 5;
        series2.segments.template.strokeWidth = 1;

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
