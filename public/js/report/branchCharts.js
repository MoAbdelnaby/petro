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
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.PieChart);
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
        chart.legend.position = "left"
    });
}

function branchPlaceCircleEmpty(divId, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.PieChart);
        chart.data = data;
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "value";
        pieSeries.dataFields.category = "branch";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        pieSeries.labels.template.disabled = true;
        chart.legend = new am4charts.Legend();
        chart.legend.position = "left"
        chart.hiddenState.properties.radius = am4core.percent(0);
    });
}

function branchPlateBar(id, data) {
    console.log(data);
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
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
        am4core.useTheme(am4themes_animated);

        var chart = am4core.create(divId, am4charts.PieChart);

        chart.data = data;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";
        chart.legend.paddingBottom = 20;
        chart.legend.labels.template.maxWidth = 95;
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "count";
        pieSeries.dataFields.category = "area";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        chart.hiddenState.properties.radius = am4core.percent(0);
    }); // end am4core.ready()
}

function branchInvoiceBar(id, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
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
        xAxis.dataFields.category = "list";
        xAxis.renderer.cellStartLocation = 0.1;
        xAxis.renderer.cellEndLocation = 0.9;
        xAxis.renderer.grid.template.location = 0;
        xAxis.events.on("sizechanged", function(ev) {
            var axis = ev.target;
            var cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
            axis.renderer.labels.template.maxWidth = cellWidth;
        });
        var label = xAxis.renderer.labels.template;
        label.wrap = true;
        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.title.text = "Record";
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

        createSeries("invoice", "Invoice");
        createSeries("no_invoice", "No Invocie");

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
