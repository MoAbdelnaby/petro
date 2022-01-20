
function comparisonInvoiceBar(id, data) {
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
        xAxis.dataFields.category = "branch";
        xAxis.renderer.cellStartLocation = 0.1;
        xAxis.renderer.cellEndLocation = 0.9;
        xAxis.renderer.grid.template.location = 0;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.title.text = "Record";
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = value;
            series.dataFields.categoryX = "branch";
            series.name = name;

            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet());
            bullet.interactionsEnabled = false;
            return series;
        }

        console.log(data)
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

function comparisonInvoiceLine(divId, data) {
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
        valueAxis.title.text = "Record";
        valueAxis.renderer.minLabelPosition = 0.01;

        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "invoice";
        series1.dataFields.categoryX = "branch";
        series1.name = "Invocie";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "Invoice {categoryX}: {valueY} Record";
        series1.legendSettings.valueText = "{valueY}";
        series1.visible = false;

        var series2 = chart.series.push(new am4charts.LineSeries());
        series2.dataFields.valueY = "no_invoice";
        series2.dataFields.categoryX = "branch";
        series2.name = "No Invoice";
        series2.bullets.push(new am4charts.CircleBullet());
        series2.tooltipText = "No Invoice {categoryX}: {valueY} Record";
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

function comparisonInvoiceTrendLine(divId, data) {
    console.log(data);
    am4core.ready(function () {

        am4core.useTheme(am4themes_animated);

        var chart = am4core.create(divId, am4charts.XYChart);

        chart.exporting.menu = new am4core.ExportMenu();

        /* Create axes */
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "branch";
        categoryAxis.renderer.minGridDistance = 30;

        /* Create value axis */
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        /* Create series */
        var columnSeries = chart.series.push(new am4charts.ColumnSeries());
        columnSeries.name = "Invoice (Record)";
        columnSeries.dataFields.valueY = "invoice";
        columnSeries.dataFields.categoryX = "branch";
        columnSeries.columns.template.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
        columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
        columnSeries.columns.template.propertyFields.stroke = "stroke";
        columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
        columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
        columnSeries.tooltip.label.textAlign = "middle";

        var lineSeries = chart.series.push(new am4charts.LineSeries());
        lineSeries.name = "No Invoice (Record)";
        lineSeries.dataFields.valueY = "no_invoice";
        lineSeries.dataFields.categoryX = "branch";

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

    });
}
