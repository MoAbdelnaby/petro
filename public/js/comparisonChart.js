
var mode = document.getElementsByTagName('body')[0].getAttribute('data-mode');
if(mode == "dark"){
    var chart1Colrs = ["#68a8c7","#68a153"];
    var chart2Colrs = ["#68a8c7","#68a153"];
    var chart3Colrs = ["#68a8c7","#68a153"];
    var chart4Colrs = ["#68a8c7","#68a153"];
    var chart5Colrs = ["#68a8c7","#68a153"];
    var chart6Colrs = ["#68a8c7","#68a153"];
    var chart7Colrs = ["#68a8c7","#68a153"];
    var chart8Colrs = ["#68a8c7","#68a153"];
}
else{
    var chart1Colrs = ["#1a739f","#348117"];
    var chart2Colrs = ["#1a739f","#348117"];
    var chart3Colrs = ["#1a739f","#348117"];
    var chart4Colrs = ["#1a739f","#348117"];
    var chart5Colrs = ["#1a739f","#348117"];
    var chart6Colrs = ["#1a739f","#348117"];
    var chart7Colrs = ["#1a739f","#348117"];
    var chart8Colrs = ["#1a739f","#348117"];

}

var Jan = {"Jan": "Jan"},
    Feb = {"Feb": "Feb"},
    Mar = {"Mar": "Mar"},
    Apr = {"Apr": "Apr"},
    May = {"May": "May"},
    Jun = {"Jun": "Jun"},
    Jul = {"Jul": "Jul"},
    Aug = {"Aug": "Aug"},
    Sep = {"Sep": "Sep"},
    Oct = {"Oct": "Oct"},
    Nov = {"Nov": "Nov"},
    Dec = {"Dec": "Dec"};

// if(document.getElementsByTagName('html')[0].getAttribute('dir') == "rtl"){
//     Jan = {"Jan":"يناير"};
//     Feb = {"Feb":"فبراير"};
//     Mar = {"Mar":"مارس"};
//     Apr = {"Apr":"إبريل"};
//     May = {"May":"مايو"};
//     Jun = {"Jun":"يونيو"};
//     Jul = {"Jul":"يوليو"};
//     Aug = {"Aug":"أغسطس"};
//     Sep = {"Sep":"سبتمبر"};
//     Oct = {"Oct":"اكتوبر"};
//     Nov = {"Nov":"نوفمبر"};
//     Dec = {"Dec":"ديسمبر"};
// }else{
//     Jan = {"Jan":"Jan"};
//     Feb = {"Feb":"Feb"};
//     Mar = {"Mar":"Mar"};
//     Apr = {"Apr":"Apr"};
//     May = {"May":"May"};
//     Jun = {"Jun":"Jun"};
//     Jul = {"Jul":"Jul"};
//     Aug = {"Aug":"Aug"};
//     Sep = {"Sep":"Sep"};
//     Oct = {"Oct":"Oct"};
//     Nov = {"Nov":"Nov"};
//     Dec = {"Dec":"Dec"};
// }
/*** Helper Function ***/
function getMonths(startDate, endDate) {
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
    var resultList = [];
    var date = new Date(startDate);
    var endDate = new Date(endDate);
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

function comparisonPlaceBar(id, data) {
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
        yAxis.title.text = "Hours";
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

function comparisonPlaceCircleWork(divId, data) {
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
        pieSeries.slices.template.stroke = am4core.color("#ffffff");
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.labels.template.maxWidth = 140;
        pieSeries.labels.template.wrap = true;
        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        chart.hiddenState.properties.radius = am4core.percent(0);

    }); // end am4core.ready()
}

function comparisonPlaceCircleEmpty(divId, data) {
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

        pieSeries.labels.template.maxWidth = 140;
        pieSeries.labels.template.wrap = true;

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

        chart.hiddenState.properties.radius = am4core.percent(0);
    }); // end am4core.ready()
}

function comparisonPlaceLine(divId, data) {
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
        valueAxis.title.text = "Hours";
        valueAxis.renderer.minLabelPosition = 0.01;

        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "work";
        series1.dataFields.categoryX = "branch";
        series1.name = "Work Duration";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "Work Duration {categoryX}: {valueY} Hours";
        series1.legendSettings.valueText = "{valueY}";
        series1.visible = false;

        var series2 = chart.series.push(new am4charts.LineSeries());
        series2.dataFields.valueY = "empty";
        series2.dataFields.categoryX = "branch";
        series2.name = "Empty Duration";
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

function comparisonPlaceSideBar(divId, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.XYChart);
        chart.width = am4core.percent(99);
        chart.data = data;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "branch";
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.location = 0;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.opposite = true;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryY = "branch";
        series.dataFields.valueX = "work";
        series.name = "Work Duration (Hours)";
        series.columns.template.fillOpacity = 0.5;
        series.columns.template.strokeOpacity = 0;
        series.tooltipText = "Work Duration in {categoryY}: {valueX.value} Hours";

        var lineSeries = chart.series.push(new am4charts.LineSeries());
        lineSeries.dataFields.categoryY = "branch";
        lineSeries.dataFields.valueX = "empty";
        lineSeries.name = "Empty Duration (Hours)";
        lineSeries.strokeWidth = 3;
        lineSeries.tooltipText = "Empty Duration in {categoryY}: {valueX.value} Hours";

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

function comparisonPlateSideBar(divId, data) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.XYChart);
        chart.width = am4core.percent(99);

        chart.data = data;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "branch";
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.location = 0;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.opposite = true;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryY = "branch";
        series.dataFields.valueX = "count";
        series.name = "Car Count";
        series.columns.template.fillOpacity = 0.5;
        series.columns.template.strokeOpacity = 0;
        series.tooltipText = "Car Count in {categoryY}: {valueX.value}";

        //add chart cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";

        //add legend
        chart.legend = new am4charts.Legend();
    }); // end am4core.ready()
}

function comparisonPlateBar(id, data) {
    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create(id, am4charts.XYChart);
        chart.colors.list = [
            am4core.color("#29A0D8"),
            am4core.color("#0098cb"),
            am4core.color("#13153E"),
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
        yAxis.title.text = "Count";
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

function comparisonPlateLine(divId, data) {
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
        series1.dataFields.valueY = "count";
        series1.dataFields.categoryX = "branch";
        series1.name = "Car Count";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "Car Count {categoryX}: {valueY} Times";
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

function comparisonPlateCircle(divId, data) {
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

function comparisonPlaceDynamicBar(divId, data, start, end) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.XYChart);
        chart.padding(40, 40, 40, 40);

        chart.numberFormatter.bigNumberPrefixes = [
            {number: 1, suffix: " Hour"},
            // {"number": 24, "suffix": " Day"},
        ];

        var label = chart.plotContainer.createChild(am4core.Label);
        label.x = am4core.percent(97);
        label.y = am4core.percent(75);
        label.horizontalCenter = "right";
        label.verticalCenter = "middle";
        label.rotation = 90;

        label.dx = -15;
        label.fontSize = 40;

        var playButton = chart.plotContainer.createChild(am4core.PlayButton);
        playButton.x = am4core.percent(97);
        playButton.y = am4core.percent(95);
        playButton.dy = -2;
        playButton.verticalCenter = "middle";
        playButton.events.on("toggled", function (event) {
            if (event.target.isActive) {
                play();
            } else {
                stop();
            }
        });

        var stepDuration = 2500;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.dataFields.category = "branch";
        categoryAxis.renderer.minGridDistance = 1;
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.disabled = true;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.min = 0;
        valueAxis.rangeChangeEasing = am4core.ease.linear;
        valueAxis.rangeChangeDuration = stepDuration;
        valueAxis.extraMax = 0.1;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryY = "branch";
        series.dataFields.valueX = "work";
        series.tooltipText = "{valueX.value}";
        series.columns.template.strokeOpacity = 0;
        series.columns.template.column.cornerRadiusBottomRight = 5;
        series.columns.template.column.cornerRadiusTopRight = 5;
        series.interpolationDuration = stepDuration;
        series.interpolationEasing = am4core.ease.linear;

        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        labelBullet.label.horizontalCenter = "right";
        labelBullet.label.text =
            "{values.valueX.workingValue.formatNumber('#.0as')}";
        labelBullet.label.textAlign = "end";
        labelBullet.label.dx = -10;

        chart.zoomOutButton.disabled = true;

        // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
        series.columns.template.adapter.add("fill", function (fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
        });

        var mos = getMonths(start, end);
        var m = 0;

        label.text = lang_replace(mos[m].str, 'ar');

        var interval;

        function play() {
            interval = setInterval(function () {
                nextYear();
            }, stepDuration);
            nextYear();
        }

        function stop() {
            if (interval) {
                clearInterval(interval);
            }
        }

        function nextYear() {
            m++;
            if (m > mos.length - 1) {
                stop();
                return false;
            }

            var newData = allData[mos[m].str];

            var itemsWithNonZero = 0;

            for (var i = 0; i < chart.data.length; i++) {
                chart.data[i].work = newData[i].work;
                if (chart.data[i].work > 0) {
                    itemsWithNonZero++;
                }
            }

            series.interpolationDuration = stepDuration;
            valueAxis.rangeChangeDuration = stepDuration;

            chart.invalidateRawData();
            label.text = mos[m].str;

            categoryAxis.zoom({
                start: 0,
                end: itemsWithNonZero / categoryAxis.dataItems.length,
            });
        }

        categoryAxis.sortBySeries = series;

        var allData = data;

        chart.data = JSON.parse(JSON.stringify(allData[mos[m].str]));

        if (m > chart.data.length + 1) {
            return true;
        }

        categoryAxis.zoom({start: 0, end: 1 / chart.data.length});

        series.events.on("inited", function () {
            setTimeout(function () {
                playButton.isActive = true; // this starts interval
            }, 2000);
        });
    });
}

function comparisonPlateDynamicBar(divId, data, start, end) {
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create(divId, am4charts.XYChart);
        chart.padding(40, 40, 40, 40);

        chart.numberFormatter.bigNumberPrefixes = [
            {number: 1e3, suffix: " K"},
            {number: 1e6, suffix: " M"},
            {number: 1e9, suffix: " B"},
        ];

        var label = chart.plotContainer.createChild(am4core.Label);
        label.x = am4core.percent(97);
        label.y = am4core.percent(75);
        label.horizontalCenter = "right";
        label.verticalCenter = "middle";
        label.dx = -15;
        label.fontSize = 40;
        label.rotation = 90;

        var playButton = chart.plotContainer.createChild(am4core.PlayButton);
        playButton.x = am4core.percent(97);
        playButton.y = am4core.percent(95);
        playButton.dy = -2;
        playButton.verticalCenter = "middle";
        playButton.events.on("toggled", function (event) {
            if (event.target.isActive) {
                play();
            } else {
                stop();
            }
        });

        var stepDuration = 2500;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.dataFields.category = "branch";
        categoryAxis.renderer.minGridDistance = 1;
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.disabled = true;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.min = 0;
        valueAxis.rangeChangeEasing = am4core.ease.linear;
        valueAxis.rangeChangeDuration = stepDuration;
        valueAxis.extraMax = 0.1;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryY = "branch";
        series.dataFields.valueX = "count";
        series.tooltipText = "{valueX.value}";
        series.columns.template.strokeOpacity = 0;
        series.columns.template.column.cornerRadiusBottomRight = 5;
        series.columns.template.column.cornerRadiusTopRight = 5;
        series.interpolationDuration = stepDuration;
        series.interpolationEasing = am4core.ease.linear;

        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        labelBullet.label.horizontalCenter = "right";
        labelBullet.label.text =
            "{values.valueX.workingValue.formatNumber('#.0as')}";
        labelBullet.label.textAlign = "end";
        labelBullet.label.dx = -10;

        chart.zoomOutButton.disabled = true;

        // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
        series.columns.template.adapter.add("fill", function (fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
        });

        var mos = getMonths(start, end);
        var m = 0;

        label.text = mos[m].str;

        var interval;

        function play() {
            interval = setInterval(function () {
                nextYear();
            }, stepDuration);
            nextYear();
        }

        function stop() {
            if (interval) {
                clearInterval(interval);
            }
        }

        function nextYear() {
            m++;

            if (m > mos.length - 1) {
                stop();
                return false;
            }
            var newData = allData[mos[m].str];

            var itemsWithNonZero = 0;

            for (var i = 0; i < chart.data.length; i++) {
                chart.data[i].count = newData[i].count;
                if (chart.data[i].count > 0) {
                    itemsWithNonZero++;
                }
            }

            series.interpolationDuration = stepDuration;
            valueAxis.rangeChangeDuration = stepDuration;

            chart.invalidateRawData();
            label.text = mos[m].str;

            categoryAxis.zoom({
                start: 0,
                end: itemsWithNonZero / categoryAxis.dataItems.length,
            });
        }

        categoryAxis.sortBySeries = series;

        var allData = data;

        chart.data = JSON.parse(JSON.stringify(allData[mos[m].str]));
        categoryAxis.zoom({start: 0, end: 1 / chart.data.length});

        series.events.on("inited", function () {
            setTimeout(function () {
                playButton.isActive = true; // this starts interval
            }, 2000);
        });
    });
}

function lang_replace(string, flag) {
    var english = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var arabic = ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو', 'يوليو', 'سبتمبر', 'اكتوبر', 'نوفمبر', 'ديسمبر'];

    if (flag == 'ar') {
        for (var i = 0; i < arabic.length; i++) {
            string = string.replace(english[i], arabic[i]);
        }
        return string;
    }
}

function comparisonPlaceTrendLine(divId, data) {
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
        columnSeries.name = "Work Duration (Hours)";
        columnSeries.dataFields.valueY = "work";
        columnSeries.dataFields.categoryX = "branch";
        columnSeries.columns.template.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
        columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
        columnSeries.columns.template.propertyFields.stroke = "stroke";
        columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
        columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
        columnSeries.tooltip.label.textAlign = "middle";

        var lineSeries = chart.series.push(new am4charts.LineSeries());
        lineSeries.name = "Empty Duration (Hours)";
        lineSeries.dataFields.valueY = "empty";
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

function comparisonPlateTrendLine(divId, data) {
    console.log(data)
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
        columnSeries.name = "Car Count";
        columnSeries.dataFields.valueY = "count";
        columnSeries.dataFields.categoryX = "branch";
        columnSeries.columns.template.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
        columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
        columnSeries.columns.template.propertyFields.stroke = "stroke";
        columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
        columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
        columnSeries.tooltip.label.textAlign = "middle";

        var lineSeries = chart.series.push(new am4charts.LineSeries());
        lineSeries.name = "Car Count";
        lineSeries.dataFields.valueY = "count";
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

function comparisonPlaceSmooth(divId) {
    am4core.ready(function () {

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
        range.bullet.adapter.add("minY", function (minY, target) {
            target.maxY = chart.plotContainer.maxHeight;
            target.maxX = chart.plotContainer.maxWidth;
            return chart.plotContainer.maxHeight;
        })

        range.bullet.events.on("dragged", function () {
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

function comparisonPlateSmooth(divId) {
    am4core.ready(function () {

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
        range.bullet.adapter.add("minY", function (minY, target) {
            target.maxY = chart.plotContainer.maxHeight;
            target.maxX = chart.plotContainer.maxWidth;
            return chart.plotContainer.maxHeight;
        })

        range.bullet.events.on("dragged", function () {
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


