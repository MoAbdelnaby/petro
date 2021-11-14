$(document).ready(function (e) {


    $("#ch7_mo").attr('disabled',true);
    $("#ch7_da").attr('disabled',true);

    let image_id=0;
    if( $("input#camera").val()==1){
         image_id = $("input#mainimg1").val();
        pushDataToChart7(image_id, "year", "all", 0, 0, "years", "high");
    }else{
         image_id = $("input#mainimg2").val();
        pushDataToChart7(image_id, "year", "all", 0, 0, "years", "high");
    }



    $(".top-low > div").on("click", function (e) {
        $(this).addClass("active");
        $(this).siblings().removeClass("active");

        if ($(".top").hasClass("active")) {
            $("input#activity").val("high");
            let image_id=0;
            if( $("input#camera").val()==1){
                image_id = $("input#mainimg1").val();
                pushDataToChart7(image_id, "year", "all", 0, 0, "Years", "high");
            }else{
                image_id = $("input#mainimg2").val();
                pushDataToChart7(image_id, "year", "all", 0, 0, "Years", "high");
            }

            $("#ch7_y").val("all");
            $("#ch7_mo").val("all");
            $("#ch7_da").val("all");

        } else {
            $("input#activity").val("low");
            let image_id=0;
            if( $("input#camera").val()==1){
                image_id = $("input#mainimg1").val();
                pushDataToChart7(image_id, "year", "all", 0, 0, "Years", "low");
            }else{
                image_id = $("input#mainimg2").val();
                pushDataToChart7(image_id, "year", "all", 0, 0, "Years", "low");
            }

            $("#ch7_y").val("all");
            $("#ch7_mo").val("all");
            $("#ch7_da").val("all");
        }
    });

    $(".disable-reg").change(function (e) {
        let regions = $(".disable-reg").val();
        let image_id=0;
        if( $("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
            let year = $("#ch3_y").val();
            let month = $("#ch3_mo").val();
            let day = $("#ch3_da").val();
            pushDataToChart3Plus(image_id, year, month, day, regions);
        }else{
            image_id = $("input#mainimg2").val();
            let year = $("#ch3_y").val();
            let month = $("#ch3_mo").val();
            let day = $("#ch3_da").val();
            pushDataToChart3Plus(image_id, year, month, day, regions);
        }

    });

    const date = new Date();

    function getYear() {
        let year = date.getFullYear();
        return year;
    }

    function getMonth() {
        let month = date.getMonth() + 1;
        return month;
    }
    function getWeek() {
        let day = date.getDate();
        if (day >= 1 && day <= 7) return 1;
        else if (day >= 8 && day <= 14) return 2;
        else if (day >= 15 && day <= 21) return 3;
        else if (day > 22) return 4;
    }
    function getDay() {
        let day = date.getDate();
        return day;
    }
    function getHour() {
        let hour = date.getHours();
        return hour;
    }

    $("#play").click(function (e) {
        $("#content_body").addClass("active");
    });




    function generateChart7(json, lable = "Months", xaxios, color) {
        //  chart5.data = json;
        am4core.ready(function () {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chart7-data", am4charts.XYChart);
            chart.colors.step = 2;
            chart.colors.list = [am4core.color(color)];
            chart.logo.disabled = true;
            chart.legend = new am4charts.Legend();
            chart.legend.position = "top";
            chart.legend.paddingBottom = 20;
            chart.legend.labels.template.maxWidth = 95;

            var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            xAxis.dataFields.category = "category";
            // xAxis.stroke = am4core.color("#fff");
            xAxis.renderer.labels.template.fill = "#29abe2";
            xAxis.renderer.baseGrid.stroke = "#29abe2";
            xAxis.dataFields.fill = am4core.color("#29abe2");
            xAxis.renderer.cellStartLocation = 0.1;
            xAxis.renderer.cellEndLocation = 0.9;
            xAxis.renderer.grid.template.location = 0;
            xAxis.renderer.minGridDistance = 10;
            xAxis.title.text = lable;
            xAxis.title.fill = am4core.color("#29abe2");
            xAxis.title.strok = am4core.color("#29abe2");
            xAxis.renderer.line.strokeOpacity = 1;
            xAxis.renderer.line.strokeWidth = 1;
            xAxis.renderer.line.stroke = am4core.color("#29abe2");

            var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
            // yAxis.min = 0;
            // yAxis.max = 100000;
            yAxis.renderer.line.strokeOpacity = 1;
            yAxis.renderer.line.strokeWidth = 1;
            yAxis.renderer.line.stroke = am4core.color("#29abe2");
            // yAxis.stroke = am4core.color("#fff");
            yAxis.renderer.labels.template.fill = "#29abe2";
            yAxis.renderer.baseGrid.stroke = "#29abe2";
            yAxis.renderer.grid.template.strokeWidth = 1;
            yAxis.renderer.grid.template.strokeOpacity = 0.6;
            yAxis.renderer.grid.template.strokeDasharray = "10";
            yAxis.renderer.baseGrid.stroke = "#29abe2";
            yAxis.renderer.grid.template.stroke = "#29abe2";

            function createSeries(value, name) {
                var series = chart.series.push(new am4charts.ColumnSeries());

                series.dataFields.valueY = value;
                series.dataFields.categoryX = "category";
                series.tooltipText = "{key}";

                chart.cursor = new am4charts.XYCursor();
                chart.cursor.lineY.disabled = true;
                chart.cursor.lineX.disabled = true;

                series.name = name;
                series.columns.template.width = am4core.percent(30);
                series.events.on("hidden", arrangeColumns);
                series.events.on("shown", arrangeColumns);

                var label = series.columns.template.createChild(am4core.Label);
                label.text = "{valueY}";
                label.align = "center";
                label.width = 20;
                label.dy = -20;
                label.fill = am4core.color("#fff");
                label.valign = "top";
                label.zIndex = 2;
                label.strokeWidth = 0;
                return series;
            }

            chart.data = json;

            createSeries(xaxios, "", "");

            function arrangeColumns() {
                var series = chart.series.getIndex(0);

                var w =
                    1 -
                    xAxis.renderer.cellStartLocation -
                    (1 - xAxis.renderer.cellEndLocation);
                if (series.dataItems.length > 1) {
                    var x0 = xAxis.getX(
                        series.dataItems.getIndex(0),
                        "categoryX"
                    );
                    var x1 = xAxis.getX(
                        series.dataItems.getIndex(1),
                        "categoryX"
                    );
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
                                (newIndex - trueIndex + middle - newMiddle) *
                                delta;

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
        }); // end am4core.ready()
    }




    function generateChart8(json, lable = "Months") {
        //  chart5.data = json;
        am4core.ready(function () {
            // Themes begin
            am4core.useTheme(am4themes_animated);

            // Themes end

            var chart = am4core.create("chart8-data", am4charts.XYChart);
            chart.colors.list = [
                am4core.color("#28C76F"),
                am4core.color("#D1000E"),
                am4core.color("#199BFC"),
            ];

            chart.legend = new am4charts.Legend();
            chart.legend.labels.template.fill = am4core.color("#fff");
            chart.legend.valueLabels.template.fill = am4core.color("#fff");
            chart.legend.position = "top";
            chart.legend.paddingBottom = 20;
            chart.legend.labels.template.maxWidth = 95;
            chart.focusFilter.strokeWidth = 5;

            var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            xAxis.dataFields.category = "category";
            // xAxis.stroke = am4core.color("#fff");
            xAxis.renderer.labels.template.fill = "#fff";
            xAxis.renderer.baseGrid.stroke = "#ffffff";
            xAxis.dataFields.fill = am4core.color("#fff");
            xAxis.renderer.cellStartLocation = 0.1;
            xAxis.renderer.cellEndLocation = 0.9;
            xAxis.renderer.grid.template.location = 0;
            xAxis.renderer.minGridDistance = 10;
            xAxis.title.text = lable;
            xAxis.title.fill = am4core.color("#fff");
            xAxis.title.strok = am4core.color("#fff");
            xAxis.renderer.line.strokeOpacity = 1;
            xAxis.renderer.line.strokeWidth = 5;
            xAxis.renderer.line.stroke = am4core.color("#292d3f");

            var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
            yAxis.min = 0;
            yAxis.renderer.line.strokeOpacity = 1;
            yAxis.renderer.line.strokeWidth = 5;
            yAxis.renderer.line.stroke = am4core.color("#292d3f");
            // yAxis.stroke = am4core.color("#fff");
            yAxis.renderer.labels.template.fill = "#fff";
            yAxis.renderer.baseGrid.stroke = "#ffffff";
            yAxis.renderer.grid.template.strokeWidth = 1;
            yAxis.renderer.grid.template.strokeOpacity = 0.6;
            yAxis.renderer.grid.template.strokeDasharray = "10";
            yAxis.renderer.baseGrid.stroke = "#ffffff";
            yAxis.renderer.grid.template.stroke = "#ffffff";

            function createSeries(value, name) {
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = value;
                series.dataFields.categoryX = "category";
                series.name = name;
                series.columns.template.width = am4core.percent(30);

                series.events.on("hidden", arrangeColumns);
                series.events.on("shown", arrangeColumns);
                var label = series.columns.template.createChild(am4core.Label);
                label.text = "{valueY}";
                label.align = "center";
                label.width = 20;
                label.dy = -20;
                label.fill = am4core.color("#fff");
                label.valign = "top";
                label.zIndex = 2;
                label.strokeWidth = 0;

                return series;
            }

            chart.data = json;

            createSeries("happy", "happy");
            createSeries("angry", "angry");
            createSeries("neutral", "neutral");

            function arrangeColumns() {
                var series = chart.series.getIndex(0);

                var w =
                    1 -
                    xAxis.renderer.cellStartLocation -
                    (1 - xAxis.renderer.cellEndLocation);
                if (series.dataItems.length > 1) {
                    var x0 = xAxis.getX(
                        series.dataItems.getIndex(0),
                        "categoryX"
                    );
                    var x1 = xAxis.getX(
                        series.dataItems.getIndex(1),
                        "categoryX"
                    );
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
                                (newIndex - trueIndex + middle - newMiddle) *
                                delta;

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
        }); // end am4core.ready()
    }

    function pushDataToChart7(image_id, flag, year, month, day, lable, check) {
        let form_data = new FormData();
        form_data.append("usermodelbranchid", $('#usermodelbranchid').val());
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);
        form_data.append("image_id", image_id);
        form_data.append("camera", $("input#camera").val());

        $.ajax({
            type: "POST",
            url: app_url + "/api/charts/heatmapLowHigh",
            data: form_data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (responce) {
                if (responce.data.length === 0) {
                    $("#chart7-data").empty();
                    $("#chart7-data").css("text-align", "center");
                    $("#chart7-data").css("font-size", "30px");
                    $("#chart7-data").append("<b>No data found</b>");
                    $(".chart7-data b").css("color", "#3f79f1");
                } else {
                    var total = 0;
                    var chart_data = [];
                    let loops = 12;
                    switch (responce.data[0]["flag"]) {
                        case "year":
                            loops = "years";
                            break;
                        case "month":
                            loops = 12;
                            break;
                        case "day":
                            loops = 31;
                            break;
                        case "hour":
                            loops = 24;
                            break;
                    }

                    if (loops != "years") {
                        if (check == "high") {
                            for (let i = 0; i < loops; i++) {
                                chart_data.push({
                                    category: loops == 24 ? i : i + 1,
                                    max: 0,
                                    key: 0,
                                });
                            }

                            responce.data.forEach((value) => {
                                let x =
                                    loops == 24
                                        ? parseInt(value.time)
                                        : parseInt(value.time) - 1;
                                chart_data[x].category = value.time;
                                chart_data[x].max = value.max;
                                chart_data[x].key = value.max_regname;
                            });
                            $(".heat-chart-title .text-blue").text(
                                " Activity location"
                            );
                            $(".heat-chart-title .text-red").text("");
                            generateChart7(chart_data, lable, "max", "#199bfc");
                        } else {
                            for (let i = 0; i < loops; i++) {
                                chart_data.push({
                                    category: i + 1,
                                    min: 0,
                                    key: 0,
                                });
                            }

                            responce.data.forEach((value) => {
                                let x = parseInt(value.time) - 1;
                                chart_data[x].category = value.time;
                                chart_data[x].min = value.min;
                                chart_data[x].key = value.min_regname;
                            });
                            $(".heat-chart-title .text-red").text(
                                " Activity location"
                            );
                            $(".heat-chart-title .text-blue").text("");
                            generateChart7(chart_data, lable, "min", "#d1000e");
                        }
                    } else {
                        let x = 0;
                        if (check == "high") {
                            responce.data.forEach((value) => {
                                chart_data[x++] = {
                                    category: value.time,
                                    max: value.max,
                                    key: value.max_regname,
                                };
                            });
                            $(".heat-chart-title .text-blue").text(
                                " Activity location"
                            );
                            $(".heat-chart-title .text-red").text("");
                            generateChart7(chart_data, lable, "max", "#199bfc");
                        } else {
                            responce.data.forEach((value) => {
                                chart_data[x++] = {
                                    category: value.time,
                                    min: value.min,
                                    key: value.min_regname,
                                };
                            });
                            $(".heat-chart-title .text-red").text(
                                " Activity location"
                            );
                            $(".heat-chart-title .text-blue").text("");
                            generateChart7(chart_data, lable, "min", "#d1000e");
                        }
                    }

                    // chart5.dispose();
                }
            },
        });
    }

    function pushDataToChart3(image_id, year, month, day) {
        let form_data = new FormData();
        form_data.append("usermodelbranchid", $('#usermodelbranchid').val());
        form_data.append("image_id", image_id);
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);
        form_data.append("camera", $("input#camera").val());
        $.ajax({
            type: "POST",
            url: app_url + "/api/charts/getHeatMapData",
            data: form_data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (responce) {
                // alert(responce.data.length);
                if (responce.data.length == 0) {
                    $(".heat-low-data .text").text("");
                    $(".heat-top-data .text").text("");
                    $(".heatmap-canvas").remove();
                    $(".heat-filter").prop("checked", false);
                    $("#heatmapContainer span").remove();
                }
                $(".heat-low-data .text").text(
                    "( " +
                        responce.percent.minRateName +
                        " ) " +
                        responce.percent.minRateValue +
                        " %"
                );
                $(".heat-top-data .text").text(
                    "( " +
                        responce.percent.maxRateName +
                        ")  " +
                        responce.percent.maxRateValue +
                        " %"
                );
                var config = {
                    container: document.getElementById("heatmapContainer"),
                    radius: 70,
                    maxOpacity: 0.5,
                    minOpacity: 0,
                    blur: 0.75,
                    gradient: {
                        ".5": "blue",
                        ".8": "yellow",
                        ".95": "red",
                    },
                };

                $(".heatmap-canvas").remove();
                $("#heatmapContainer span").remove();
                $(".heat-filter").prop("checked", false);
                heatmapInstance = h337.create(config);

                var data = {
                    max: responce.max,
                    min: 0,
                    data: responce.data,
                };
                // heatmapInstance.setDataMax(12000);
                heatmapInstance.setData(data);
                responce.rates.forEach((value) => {
                    $("#heatmapContainer").append(
                        '<span addClass="rate-hint" style=" left:' +
                            value.x +
                            "px !important;top:" +
                            value.y +
                            'px !important ">' +
                            '<div class="pr-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="26" viewBox="0 0 11.332 18.855">\n' +
                            '  <g id="Group_7383" data-name="Group 7383" transform="translate(-164.504 -865.461)">\n' +
                            '    <path id="Path_5942" data-name="Path 5942" d="M175.675,872.467a5.666,5.666,0,1,0-11.01,0,8.446,8.446,0,0,0,.619,2.2c.557,1.17,2.9,5.03,3.975,6.789-1.454.185-2.13.81-2.13,1.4,0,.7.952,1.456,3.041,1.456s3.041-.755,3.041-1.456c0-.59-.675-1.215-2.129-1.4,1.075-1.759,3.419-5.619,3.975-6.789A8.469,8.469,0,0,0,175.675,872.467Zm-3.341,10.393c-.059.166-.791.581-2.164.581-1.389,0-2.122-.426-2.166-.576.04-.145.637-.5,1.765-.574l.028.046a.437.437,0,0,0,.745,0l.028-.046C171.685,882.362,172.281,882.711,172.334,882.86Zm2.487-10.585c0,.011,0,.022-.006.034a7.809,7.809,0,0,1-.548,1.986c-.562,1.18-3.127,5.394-4.1,6.977-.97-1.583-3.535-5.8-4.1-6.977a7.81,7.81,0,0,1-.547-1.986c0-.012,0-.023-.007-.034a4.791,4.791,0,1,1,9.3,0Z" transform="translate(0 0)" fill="#fff"/>\n' +
                            '    <path id="Path_5943" data-name="Path 5943" d="M172.436,870.083a3.041,3.041,0,1,0,3.041,3.04A3.044,3.044,0,0,0,172.436,870.083Zm0,5.206a2.165,2.165,0,1,1,2.166-2.165A2.168,2.168,0,0,1,172.436,875.289Z" transform="translate(-2.266 -2.142)" fill="#fff"/>\n' +
                            "  </g>\n" +
                            "</svg>\n<br>" +
                            value.name +
                            "</div>" +
                            '<div class="ml-2">Rate: ' +
                            value.rate +
                            "% </div>" +
                            "</span>"
                    );
                });
            },
        });
    } // end pushDataToChart3
    function pushDataToChart3Plus(image_id, year, month, day, regions) {
        let form_data = new FormData();
        form_data.append("usermodelbranchid", $('#usermodelbranchid').val());
        form_data.append("image_id", image_id);
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);
        form_data.append("regions", regions);
        form_data.append("camera", $("input#camera").val());
        $.ajax({
            type: "POST",
            url: app_url + "/api/charts/ignoreDisabledData",
            data: form_data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (responce) {
                if (responce.data.length === 0) {
                    $(".heat-low-data .text").text("");
                    $(".heat-top-data .text").text("");
                    $(".heatmap-canvas").remove();
                    $(".heat-filter").prop("checked", false);
                    $("#heatmapContainer span").remove();
                }
                $(".heat-low-data .text").text(
                    "( " +
                        responce.percent.minRateName +
                        " ) " +
                        responce.percent.minRateValue +
                        " %"
                );
                $(".heat-top-data .text").text(
                    "( " +
                        responce.percent.maxRateName +
                        ")  " +
                        responce.percent.maxRateValue +
                        " %"
                );
                var config = {
                    container: document.getElementById("heatmapContainer"),
                    radius: 70,
                    maxOpacity: 0.5,
                    minOpacity: 0,
                    blur: 0.75,
                    gradient: {
                        ".5": "blue",
                        ".8": "yellow",
                        ".95": "red",
                    },
                };

                $(".heatmap-canvas").remove();
                $("#heatmapContainer span").remove();
                $(".heat-filter").prop("checked", false);
                heatmapInstance = h337.create(config);

                var data = {
                    max: responce.max,
                    min: 0,
                    data: responce.data,
                };
                // heatmapInstance.setDataMax(12000);
                heatmapInstance.setData(data);
                responce.rates.forEach((value) => {
                    $("#heatmapContainer").append(
                        '<span addClass="rate-hint" style=" left:' +
                            value.x +
                            "px !important;top:" +
                            value.y +
                            'px !important ">' +
                            '<div class="pr-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="26" viewBox="0 0 11.332 18.855">\n' +
                            '  <g id="Group_7383" data-name="Group 7383" transform="translate(-164.504 -865.461)">\n' +
                            '    <path id="Path_5942" data-name="Path 5942" d="M175.675,872.467a5.666,5.666,0,1,0-11.01,0,8.446,8.446,0,0,0,.619,2.2c.557,1.17,2.9,5.03,3.975,6.789-1.454.185-2.13.81-2.13,1.4,0,.7.952,1.456,3.041,1.456s3.041-.755,3.041-1.456c0-.59-.675-1.215-2.129-1.4,1.075-1.759,3.419-5.619,3.975-6.789A8.469,8.469,0,0,0,175.675,872.467Zm-3.341,10.393c-.059.166-.791.581-2.164.581-1.389,0-2.122-.426-2.166-.576.04-.145.637-.5,1.765-.574l.028.046a.437.437,0,0,0,.745,0l.028-.046C171.685,882.362,172.281,882.711,172.334,882.86Zm2.487-10.585c0,.011,0,.022-.006.034a7.809,7.809,0,0,1-.548,1.986c-.562,1.18-3.127,5.394-4.1,6.977-.97-1.583-3.535-5.8-4.1-6.977a7.81,7.81,0,0,1-.547-1.986c0-.012,0-.023-.007-.034a4.791,4.791,0,1,1,9.3,0Z" transform="translate(0 0)" fill="#fff"/>\n' +
                            '    <path id="Path_5943" data-name="Path 5943" d="M172.436,870.083a3.041,3.041,0,1,0,3.041,3.04A3.044,3.044,0,0,0,172.436,870.083Zm0,5.206a2.165,2.165,0,1,1,2.166-2.165A2.168,2.168,0,0,1,172.436,875.289Z" transform="translate(-2.266 -2.142)" fill="#fff"/>\n' +
                            "  </g>\n" +
                            "</svg>\n<br>" +
                            value.name +
                            "</div>" +
                            '<div class="ml-2">Rate: ' +
                            value.rate +
                            "% </div>" +
                            "</span>"
                    );
                });
            },
        });
    } // end pushDataToChart3Plus



    $("#ch3_y").change(function (e) {
        if($(this).val()=="none" || $(this).val()=="all"){
            $("#ch3_mo").attr('disabled',true);
            $("#ch3_da").attr('disabled',true);
        }else{
            $("#ch3_mo").removeAttr('disabled');
            $("#ch3_da").removeAttr('disabled');
        }
        $(".disable-reg").val('').trigger('change');
        $("#ch3_mo").val("all");
        $("#ch3_da").val("all");

        let year = $(this).val();
        let image_id=0;
        if($("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }
        pushDataToChart3(image_id, year, 0, 0);
    });

    $("#ch3_mo").change(function (e) {
        $(".disable-reg").val('').trigger('change');
        $("#ch3_da").val("all");
        if ($("#ch3_y").val() == "all") {
            $("#ch3_y").prop("selectedIndex", 1);
        }
        let year = $("#ch3_y").val();
        let month = $("#ch3_mo").val();
        let image_id=0;
        if($("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }

        pushDataToChart3(image_id, year, month, 0);
    });

    $("#ch3_da").change(function (e) {
        $(".disable-reg").val('').trigger('change');
        if ($("#ch3_y").val() == "all") {
            $("#ch3_y").prop("selectedIndex", 1);
        }
        let year = $("#ch3_y").val();
        let month = $("#ch3_mo").val();
        let day = $("#ch3_da").val();

        let image_id=0;
        if($("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }

        pushDataToChart3(image_id, year, month, day);
    });















    $("#ch7_y").change(function (e) {
        if($(this).val()=="none" || $(this).val()=="all"){
            $("#ch7_mo").attr('disabled',true);
            $("#ch7_da").attr('disabled',true);
        }else{
            $("#ch7_mo").removeAttr('disabled');
            $("#ch7_da").removeAttr('disabled');
        }
        $("#ch7_mo").val("all");
        $("#ch7_da").val("all");

        let year = $(this).val();
        let image_id=0;
        if($("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }
        let data = $("input#activity").val();
        pushDataToChart7(image_id, "year", year, 0, 0, "Months", data);
    });

    $("#ch7_mo").change(function (e) {
        $("#ch7_da").val("all");
        if ($("#ch7_y").val() == "all") {
            $("#ch7_y").prop("selectedIndex", 1);
        }
        let year = $("#ch7_y").val();
        let month = $("#ch7_mo").val();
        let image_id=0;
        if($("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }
        let data = $("input#activity").val();

        pushDataToChart7(image_id, "month", year, month, 0, "Days", data);
    });

    $("#ch7_da").change(function (e) {
        if ($("#ch7_y").val() == "all") {
            $("#ch7_y").prop("selectedIndex", 1);
        }
        let year = $("#ch7_y").val();
        let month = $("#ch7_mo").val();
        let day = $("#ch7_da").val();

        let image_id=0;
        if($("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }
        let data = $("input#activity").val();

        pushDataToChart7(image_id, "day", year, month, day, "Hours", data);
    });


    $("#ch3filter").change(function (e) {
        let image_id=0;
        if($("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }
        $.ajax({
            url: app_url + "/api/charts/getFilterImage/" + image_id,
            type: "GET",
            dataType: "json",
            success: function (res) {
                $("#ch3_y").val("none");
                $("#heatmapContainer").empty();
                $("#heatmapContainer").append(
                    '<img id="theImg" style="width:100%;height:100%;" src="' +
                      +
                        res.data.name +
                        '" />'
                );
                $("#mainimg1").val(res.data.id);
            },
        });
    });

    setTimeout(function () {
        $("#ch3_y").val("all");
        $("#ch3_y").trigger("change");
        $("#ch3_mo").attr('disabled',true);
        $("#ch3_da").attr('disabled',true);

        let image_id=0;
        if( $("input#camera").val()==1){
            image_id = $("input#mainimg1").val();
            pushDataToChart3(image_id, 'all', 0, 0);
        }else{
            image_id = $("input#mainimg2").val();
            pushDataToChart3(image_id, 'all', 0, 0);
        }

    }, 7000);
});
