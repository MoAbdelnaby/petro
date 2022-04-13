function barChart(id, data, info) {

    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(id, am4charts.XYChart);

        chart.colors.list = [
            am4core.color("#fc696e"),
            am4core.color("#EF1B2F"),
            am4core.color("#ff8904"),
        ];
        chart.colors.step = 2;
        chart.exporting.menu = new am4core.ExportMenu();
        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "list";
        xAxis.renderer.cellStartLocation = 0.1;
        xAxis.renderer.cellEndLocation = 0.9;
        xAxis.renderer.grid.template.location = 0;
        xAxis.events.on("sizechanged", function (ev) {
            var axis = ev.target;
            var cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
            axis.renderer.labels.template.maxWidth = cellWidth;
        });
        var label = xAxis.renderer.labels.template;
        label.wrap = true;
        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.title.text = info.unit;
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = value;
            series.dataFields.categoryX = "list";
            series.name = name;

            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet());
            bullet.interactionsEnabled = false;
            return series;
        }

        chart.data = data;

        info.columns.forEach(function (el) {
            createSeries(el, info.display_key[el]);
        });

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
                    });
                    var visibleCount = newIndex;
                    var newMiddle = visibleCount / 2;

                    chart.series.each(function (series) {
                        var trueIndex = chart.series.indexOf(series);
                        var newIndex = series.dummyData;
                        var dx = (newIndex - trueIndex + middle - newMiddle) * delta;

                        series.animate({
                            property: "dx",
                            to: dx,
                        }, series.interpolationDuration, series.interpolationEasing);
                        series.bulletsContainer.animate({property: "dx", to: dx,},
                            series.interpolationDuration,
                            series.interpolationEasing
                        );
                    });
                }
            }
        }

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineX.disabled = true;
    }); // end am4core.ready()
}

function lineChart(id, data, info) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(id, am4charts.XYChart);
        chart.exporting.menu = new am4core.ExportMenu();
        chart.colors.list = [
            am4core.color("#29A0D8"),
            am4core.color("#eeae53"),
            am4core.color("#13153E"),
        ];
        chart.data = data;

        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "list";
        categoryAxis.events.on("sizechanged", function (ev) {
            var axis = ev.target;
            var cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
            axis.renderer.labels.template.maxWidth = cellWidth;
        });
        var label = categoryAxis.renderer.labels.template;
        label.wrap = true;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = info.unit;
        valueAxis.renderer.minLabelPosition = 0.01;

        info.columns.forEach(function (el) {
            createSeries(el, info.display_key[el]);
        });

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = value;
            series.dataFields.categoryX = "list";
            series.name = name;
            series.bullets.push(new am4charts.CircleBullet());
            series.tooltipText = `${name} {categoryX}: {valueY} ${info.unit}`;
            series.legendSettings.valueText = "{valueY}";
            series.visible = false;
            let hs1 = series.segments.template.states.create("hover");
            hs1.properties.strokeWidth = 5;
            series.segments.template.strokeWidth = 1;
            return series;
        }

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";
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

function sideBarChart(id, data, info) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(id, am4charts.XYChart);
        chart.exporting.menu = new am4core.ExportMenu();
        chart.width = am4core.percent(99);
        chart.data = data;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "list";
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.location = 0;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.opposite = true;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryY = "list";
        series.dataFields.valueX = info.columns[0];
        series.name = `${info.display_key[info.columns[0]]} (${info.unit})`;
        series.columns.template.fillOpacity = 0.5;
        series.columns.template.strokeOpacity = 0;
        series.tooltipText = `${info.display_key[info.columns[0]]} in {categoryY}: {valueX.value} ${info.unit}`;

        if (info.columns.length > 1) {
            var lineSeries = chart.series.push(new am4charts.LineSeries());
            lineSeries.dataFields.categoryY = "list";
            lineSeries.dataFields.valueX = info.columns[1];
            lineSeries.name = `${info.display_key[info.columns[1]]} (${info.unit})`;
            lineSeries.strokeWidth = 3;
            lineSeries.tooltipText = `${info.display_key[info.columns[1]]} in {categoryY}: {valueX.value} ${info.unit}`;
            var circleBullet = lineSeries.bullets.push(new am4charts.CircleBullet());
            circleBullet.circle.fill = am4core.color("#fff");
            circleBullet.circle.strokeWidth = 2;
        }

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";

        chart.legend = new am4charts.Legend();
    });
}

function trendLineChart(id, data, info) {
    console.log(info);
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(id, am4charts.XYChart);
        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;
        chart.exporting.menu = new am4core.ExportMenu();
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "list";
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.events.on("sizechanged", function (ev) {
            var axis = ev.target;
            var cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
            axis.renderer.labels.template.maxWidth = cellWidth;
        });
        var label = categoryAxis.renderer.labels.template;
        label.wrap = true;

        chart.yAxes.push(new am4charts.ValueAxis());

        var columnSeries = chart.series.push(new am4charts.ColumnSeries());
        columnSeries.name = `${info.display_key[info.columns[0]]} (${info.unit})`;
        columnSeries.dataFields.valueY = info.columns[0];
        columnSeries.dataFields.categoryX = "list";
        columnSeries.columns.template.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
        columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
        columnSeries.columns.template.propertyFields.stroke = "stroke";
        columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
        columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
        columnSeries.tooltip.label.textAlign = "middle";

        if (info.columns.length > 1) {
            var lineSeries = chart.series.push(new am4charts.LineSeries());
            lineSeries.name = `${info.display_key[info.columns[1]]} (${info.unit})`;
            lineSeries.dataFields.valueY = info.columns[1];
            lineSeries.dataFields.categoryX = "list";
            lineSeries.stroke = am4core.color("#fdd400");
            lineSeries.strokeWidth = 3;
            lineSeries.propertyFields.strokeDasharray = "lineDash";
            lineSeries.tooltip.label.textAlign = "middle";
            var bullet = lineSeries.bullets.push(new am4charts.Bullet());
            bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
            bullet.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
            var circle = bullet.createChild(am4core.Circle);
            circle.radius = 4;
            circle.fill = am4core.color("#fff");
            circle.strokeWidth = 3;
            chart.data = data;
        }
    });
}

function pieChart(id, data, info) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(id, am4charts.PieChart);
        chart.data = data;
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "value";
        pieSeries.dataFields.category = "list";
        pieSeries.slices.template.stroke = am4core.color("#ffffff");
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.labels.template.maxWidth = 140;
        pieSeries.labels.template.wrap = true;
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        chart.hiddenState.properties.radius = am4core.percent(0);
        pieSeries.labels.template.disabled = true;
        chart.legend = new am4charts.Legend();
        chart.legend.position = "left";
        chart.exporting.menu = new am4core.ExportMenu();
    }); // end am4core.ready()
}
