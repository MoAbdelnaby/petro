function comparisonBackoutBar(id, data) {
    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create(id, am4charts.XYChart);
        chart.colors.list = [
            am4core.color("#fc696e"),
            am4core.color("#EF1B2F"),
            am4core.color("#ff8904"),
        ];
        chart.colors.step = 2;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "branch";
        xAxis.renderer.cellStartLocation = 0.1;
        xAxis.renderer.cellEndLocation = 0.9;
        xAxis.renderer.grid.template.location = 0;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.title.text = "Backout Count";
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = value;
            series.dataFields.categoryX = "branch";
            series.name = name;
            series.columns.template.width = am4core.percent(30);

            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet());
            bullet.interactionsEnabled = false;
            return series;
        }

        chart.data = data;

        createSeries("backout", "Backout Count");

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
    }); // end am4core
}

function comparisonBackoutLine(divId, data) {
    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);

        var chart = am4core.create(divId, am4charts.XYChart);

        chart.colors.list = [
            am4core.color("#29A0D8"),
            am4core.color("#eeae53"),
            am4core.color("#13153E"),
        ];
        chart.data = data;

        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "branch";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Backout Count";
        valueAxis.renderer.minLabelPosition = 0.01;

        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "backout";
        series1.dataFields.categoryX = "branch";
        series1.name = "Backout Count";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "Backout Count {categoryX}: {valueY} Record";
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
