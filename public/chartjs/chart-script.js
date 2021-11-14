$(document).ready(function (e) {
    // pushDataToChart5("year", "all", 0, 0, "years");
    $("#ch4_mo").attr('disabled',true);

    // pushDataToChart4("year", "all", 'all', 0, "years");

    // pushDataToChart6("year", "all", 0, 0, "years");
    // let image_id = $("input#mainimg-filter").val();
    // pushDataToChart7(image_id, "year", "all", 0, 0, "years", "high");
    // pushDataToChart8("year", "all", 0, 0, "years");
    //
    // $(".top-low > div").on("click", function (e) {
    //     $(this).addClass("active");
    //     $(this).siblings().removeClass("active");
    //
    //     if ($(".top").hasClass("active")) {
    //         $("input#activity").val("high");
    //         let image_id = $("input#mainimg-filter").val();
    //         pushDataToChart7(image_id, "year", "all", 0, 0, "Years", "high");
    //         $("#ch7_y").val("all");
    //         $("#ch7_mo").val("all");
    //         $("#ch7_da").val("all");
    //     } else {
    //         $("input#activity").val("low");
    //         let image_id = $("input#mainimg-filter").val();
    //         pushDataToChart7(image_id, "year", "all", 0, 0, "Years", "low");
    //         $("#ch7_y").val("all");
    //         $("#ch7_mo").val("all");
    //         $("#ch7_da").val("all");
    //     }
    // });
    //
    // $(".disable-reg").change(function (e) {
    //     let regions = $(".disable-reg").val();
    //     let image_id = $("input#mainimg").val();
    //     let year = $("#ch3_y").val();
    //     let month = $("#ch3_mo").val();
    //     let day = $("#ch3_da").val();
    //     pushDataToChart3Plus(image_id, year, month, day, regions);
    // });

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

    // $("#play").click(function (e) {
    //     $("#content_body").addClass("active");
    // });

    // function generateChart6(json, lable = "Months") {
    //     chart6 = am4core.create("chart6-data", am4charts.XYChart);
    //
    //     chart6.colors.list = [
    //         am4core.color("#28c76f"),
    //         am4core.color("#ff0000"),
    //         am4core.color("#29abe2"),
    //     ];
    //
    //     var xAxis = chart6.xAxes.push(new am4charts.CategoryAxis());
    //     xAxis.title.text = lable;
    //     xAxis.dataFields.category = "time";
    //     xAxis.renderer.minGridDistance = 10;
    //     xAxis.title.fill = am4core.color("#fff");
    //     // xAxis.title.strok = am4core.color("#fff");
    //     // xAxis.stroke = am4core.color("#fff");
    //     xAxis.renderer.labels.template.fill = am4core.color("#fff");
    //     xAxis.renderer.baseGrid.stroke = am4core.color("#fff");
    //     xAxis.dataFields.fill = am4core.color("#fff");
    //     xAxis.renderer.line.strokeOpacity = 1;
    //     xAxis.renderer.line.strokeWidth = 1;
    //     xAxis.renderer.line.stroke = am4core.color("#fff");
    //
    //     function createAxisAndSeries(field, name, opposite, bullet) {
    //         var yAxis = chart6.yAxes.push(new am4charts.ValueAxis());
    //
    //         var series = chart6.series.push(new am4charts.LineSeries());
    //         series.dataFields.valueY = field;
    //         series.dataFields.categoryX = "time";
    //         series.strokeWidth = 2;
    //         series.focusable = false;
    //         series.yAxis = yAxis;
    //         series.name = name;
    //         series.fill = "#29ABE2";
    //         // series.stroke = am4core.color("#1C439A");
    //         series.bullets.tooltipText = "{name}: [bold]{valueY}[/]";
    //         series.tensionX = 0.8;
    //         series.legendSettings.itemValueText = "[bold]{valueY}[/bold]";
    //
    //         var interfaceColors = new am4core.InterfaceColorSet();
    //
    //         switch (bullet) {
    //             case "triangle":
    //                 var bullet = series.bullets.push(new am4charts.Bullet());
    //                 bullet.width = 12;
    //                 bullet.height = 12;
    //                 bullet.horizontalCenter = "middle";
    //                 bullet.verticalCenter = "middle";
    //
    //                 var triangle = bullet.createChild(am4core.Triangle);
    //                 triangle.stroke = interfaceColors.getFor("background");
    //                 triangle.strokeWidth = 2;
    //                 triangle.direction = "top";
    //                 triangle.width = 12;
    //                 triangle.height = 12;
    //                 break;
    //             case "rectangle":
    //                 var bullet = series.bullets.push(new am4charts.Bullet());
    //                 bullet.width = 10;
    //                 bullet.height = 10;
    //                 bullet.horizontalCenter = "middle";
    //                 bullet.verticalCenter = "middle";
    //
    //                 var rectangle = bullet.createChild(am4core.Rectangle);
    //                 rectangle.stroke = interfaceColors.getFor("background");
    //                 rectangle.strokeWidth = 2;
    //                 rectangle.width = 10;
    //                 rectangle.height = 10;
    //                 break;
    //             default:
    //                 var bullet = series.bullets.push(
    //                     new am4charts.CircleBullet()
    //                 );
    //                 bullet.circle.stroke = interfaceColors.getFor("background");
    //                 bullet.circle.strokeWidth = 2;
    //                 break;
    //         }
    //
    //         bullet.tooltipText = "{name}: [bold]{valueY}[/]";
    //
    //         yAxis.renderer.opposite = opposite;
    //         yAxis.renderer.grid.template.disabled = true;
    //         yAxis.renderer.labels.template.disabled = true; //disables labels
    //         //
    //         yAxis.renderer.baseGrid.stroke = am4core.color("#fff");
    //         yAxis.renderer.grid.template.stroke = am4core.color("#fff");
    //         yAxis.renderer.labels.template.fill = am4core.color("#fff");
    //         yAxis.renderer.grid.template.strokeWidth = 1;
    //         yAxis.renderer.grid.template.strokeOpacity = 0.8;
    //         yAxis.renderer.grid.template.strokeDasharray = "10";
    //         yAxis.renderer.line.strokeOpacity = 1;
    //         yAxis.renderer.line.strokeWidth = 1;
    //         yAxis.renderer.line.stroke = am4core.color("#fff");
    //     }
    //
    //     createAxisAndSeries("mask", "mask", false, "circle");
    //     createAxisAndSeries("nomask", "no mask", false, "triangle");
    //     createAxisAndSeries("total_faces", "total", false, "rectangle");
    //
    //     chart6.data = json;
    //
    //     chart6.legend = new am4charts.Legend();
    //     chart6.legend.labels.template.fill = am4core.color("#fff");
    //     chart6.legend.valueLabels.template.fill = am4core.color("#fff");
    //     chart6.cursor = new am4charts.XYCursor();
    //     chart6.cursor.behavior = "none";
    // }
    //
    // function generateChart5(json, lable = "Months") {
    //     chart5 = am4core.create("chart5-data", am4charts.XYChart);
    //     chart5.colors.step = 2;
    //
    //     var xAxis = chart5.xAxes.push(new am4charts.CategoryAxis());
    //     xAxis.title.text = lable;
    //     xAxis.dataFields.category = "time";
    //     xAxis.renderer.minGridDistance = 10;
    //     xAxis.title.fill = am4core.color("#fff");
    //     // xAxis.title.strok = am4core.color("#fff");
    //     // xAxis.stroke = am4core.color("#fff");
    //     xAxis.renderer.labels.template.fill = "#fff";
    //     xAxis.renderer.baseGrid.stroke = "#ffffff";
    //     xAxis.dataFields.fill = am4core.color("#fff");
    //     xAxis.renderer.line.strokeOpacity = 1;
    //     xAxis.renderer.line.strokeWidth = 1;
    //     xAxis.renderer.line.stroke = am4core.color("#fff");
    //
    //     function createAxisAndSeries(field, name, opposite, bullet) {
    //         var yAxis = chart5.yAxes.push(new am4charts.ValueAxis());
    //
    //         var series = chart5.series.push(new am4charts.LineSeries());
    //         series.dataFields.valueY = field;
    //         series.dataFields.categoryX = "time";
    //         series.strokeWidth = 2;
    //         series.yAxis = yAxis;
    //         series.name = name;
    //
    //         series.bullets.tooltipText = "{name}: [bold]{valueY}[/]";
    //         series.tensionX = 0.8;
    //         series.legendSettings.itemValueText = "[bold]{valueY}[/bold]";
    //
    //         var interfaceColors = new am4core.InterfaceColorSet();
    //
    //         switch (bullet) {
    //             case "triangle":
    //                 var bullet = series.bullets.push(new am4charts.Bullet());
    //                 bullet.width = 12;
    //                 bullet.height = 12;
    //                 bullet.horizontalCenter = "middle";
    //                 bullet.verticalCenter = "middle";
    //
    //                 var triangle = bullet.createChild(am4core.Triangle);
    //                 triangle.stroke = interfaceColors.getFor("background");
    //                 triangle.strokeWidth = 2;
    //                 triangle.direction = "top";
    //                 triangle.width = 12;
    //                 triangle.height = 12;
    //                 break;
    //             case "rectangle":
    //                 var bullet = series.bullets.push(new am4charts.Bullet());
    //                 bullet.width = 10;
    //                 bullet.height = 10;
    //                 bullet.horizontalCenter = "middle";
    //                 bullet.verticalCenter = "middle";
    //
    //                 var rectangle = bullet.createChild(am4core.Rectangle);
    //                 rectangle.stroke = interfaceColors.getFor("background");
    //                 rectangle.strokeWidth = 2;
    //                 rectangle.width = 10;
    //                 rectangle.height = 10;
    //                 break;
    //             default:
    //                 var bullet = series.bullets.push(
    //                     new am4charts.CircleBullet()
    //                 );
    //                 bullet.circle.stroke = interfaceColors.getFor("background");
    //                 bullet.circle.strokeWidth = 2;
    //                 break;
    //         }
    //
    //         bullet.tooltipText = "{name}: [bold]{valueY}[/]";
    //
    //         // yAxis.renderer.line.stroke = series.stroke;
    //         yAxis.renderer.opposite = opposite;
    //         yAxis.renderer.grid.template.disabled = true;
    //         yAxis.renderer.labels.template.disabled = true; //disables labels
    //
    //         yAxis.renderer.baseGrid.stroke = am4core.color("#fff");
    //         yAxis.renderer.grid.template.stroke = am4core.color("#fff");
    //         yAxis.renderer.labels.template.fill = am4core.color("#fff");
    //         yAxis.renderer.grid.template.strokeWidth = 1;
    //         yAxis.renderer.grid.template.strokeOpacity = 0.8;
    //         yAxis.renderer.grid.template.strokeDasharray = "10";
    //         yAxis.renderer.baseGrid.stroke = am4core.color("#fff");
    //         yAxis.renderer.line.strokeOpacity = 1;
    //         yAxis.renderer.line.strokeWidth = 1;
    //         yAxis.renderer.line.stroke = am4core.color("#fff");
    //     }
    //
    //     createAxisAndSeries("angry", "angry", false, "circle");
    //     createAxisAndSeries("disgust", "disgust", false, "triangle");
    //     createAxisAndSeries("happy", "happy", false, "rectangle");
    //     createAxisAndSeries("neutral", "neutral", false, "circle");
    //     createAxisAndSeries("sad", "sad", false, "triangle");
    //     createAxisAndSeries("surprise", "surprise", false, "rectangle");
    //     createAxisAndSeries("fear", "fear", false, "rectangle");
    //
    //     chart5.data = json;
    //     chart5.legend = new am4charts.Legend();
    //     chart5.legend.labels.template.fill = am4core.color("#fff");
    //     chart5.legend.valueLabels.template.fill = am4core.color("#fff");
    //     chart5.cursor = new am4charts.XYCursor();
    //     chart5.cursor.behavior = "none";
    // }
    //
    // function pushDataToChart5(flag, year, month, day, lable) {
    //     let form_data = new FormData();
    //     form_data.append("year", year);
    //     form_data.append("month", month);
    //     form_data.append("day", day);
    //
    //     $.ajax({
    //         type: "POST",
    //         url: app_url + "/api/charts/getEmotions",
    //         data: form_data,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //         contentType: false,
    //         processData: false,
    //         success: function (responce) {
    //             const monthNames = [
    //                 "January",
    //                 "February",
    //                 "March",
    //                 "April",
    //                 "May",
    //                 "June",
    //                 "July",
    //                 "August",
    //                 "September",
    //                 "October",
    //                 "November",
    //                 "December",
    //             ];
    //             if (responce.data.length === 0) {
    //                 $(".chart5-data").empty();
    //                 $(".chart5-data").css("text-align", "center");
    //                 $(".chart5-data").css("font-size", "30px");
    //                 $(".chart5-data").append("<b>No data found</b>");
    //                 $(".chart5-data b").css("color", "#fff");
    //                 $(".emotions-flag .text").text(responce.flag);
    //                 $(".top-happy-data .text-green").text("");
    //                 $(".low-happy-data .text-red").text("");
    //                 $(".top-neutral-data .text-green").text("");
    //                 $(".low-neutral-data .text-red").text("");
    //                 $(".top-angry-data .text-green").text("");
    //                 $(".low-angry-data .text-red").text("");
    //             } else {
    //                 $(".emotions-flag .text").text(responce.flag);
    //                 $(".top-happy-data .text-green").text(
    //                     responce.states.tophappy.count + "%"
    //                 );
    //                 $(".low-happy-data .text-red").text(
    //                     responce.states.lowhappy.count + "%"
    //                 );
    //                 $(".top-neutral-data .text-green").text(
    //                     responce.states.topneurtal.count + "%"
    //                 );
    //                 $(".low-neutral-data .text-red").text(
    //                     responce.states.lowneurtal.count + "%"
    //                 );
    //                 $(".top-angry-data .text-green").text(
    //                     responce.states.topangry.count + "%"
    //                 );
    //                 $(".low-angry-data .text-red").text(
    //                     responce.states.lowangry.count + "%"
    //                 );
    //                 if (responce.flag == "Month") {
    //                     $(".top-happy-data .text").text(
    //                         monthNames[responce.states.tophappy.month - 1] +
    //                             " :"
    //                     );
    //                     $(".low-happy-data .text").text(
    //                         monthNames[responce.states.lowhappy.month - 1] +
    //                             " :"
    //                     );
    //                     $(".top-neutral-data .text").text(
    //                         monthNames[responce.states.topneurtal.month - 1] +
    //                             " :"
    //                     );
    //                     $(".low-neutral-data .text").text(
    //                         monthNames[responce.states.lowneurtal.month - 1] +
    //                             " :"
    //                     );
    //                     $(".top-angry-data .text").text(
    //                         monthNames[responce.states.topangry.month - 1] +
    //                             " :"
    //                     );
    //                     $(".low-angry-data .text").text(
    //                         monthNames[responce.states.lowangry.month - 1] +
    //                             " :"
    //                     );
    //                 } else if (responce.flag == "Day") {
    //                     $(".top-happy-data .text").text(
    //                         "Day " + responce.states.tophappy.day + " :"
    //                     );
    //                     $(".low-happy-data .text").text(
    //                         "Day " + responce.states.lowhappy.day + " :"
    //                     );
    //                     $(".top-neutral-data .text").text(
    //                         "Day " + responce.states.topneurtal.day + " :"
    //                     );
    //                     $(".low-neutral-data .text").text(
    //                         "Day " + responce.states.lowneurtal.day + " :"
    //                     );
    //                     $(".top-angry-data .text").text(
    //                         "Day " + responce.states.topangry.day + " :"
    //                     );
    //                     $(".low-angry-data .text").text(
    //                         "Day " + responce.states.lowangry.day + " :"
    //                     );
    //                 } else if (responce.flag == "Hour") {
    //                     $(".top-happy-data .text").text(
    //                         "Hour " + responce.states.tophappy.hour + " :"
    //                     );
    //                     $(".low-happy-data .text").text(
    //                         "Hour " + responce.states.lowhappy.hour + " :"
    //                     );
    //                     $(".top-neutral-data .text").text(
    //                         "Hour " + responce.states.topneurtal.hour + " :"
    //                     );
    //                     $(".low-neutral-data .text").text(
    //                         "Hour " + responce.states.lowneurtal.hour + " :"
    //                     );
    //                     $(".top-angry-data .text").text(
    //                         "Hour " + responce.states.topangry.hour + " :"
    //                     );
    //                     $(".low-angry-data .text").text(
    //                         "Hour " + responce.states.lowangry.hour + " :"
    //                     );
    //                 } else if (responce.flag == "Year") {
    //                     $(".top-happy-data .text").text(
    //                         "Year " + responce.states.tophappy.year + " :"
    //                     );
    //                     $(".low-happy-data .text").text(
    //                         "Year " + responce.states.lowhappy.year + " :"
    //                     );
    //                     $(".top-neutral-data .text").text(
    //                         "Year " + responce.states.topneurtal.year + " :"
    //                     );
    //                     $(".low-neutral-data .text").text(
    //                         "Year " + responce.states.lowneurtal.year + " :"
    //                     );
    //                     $(".top-angry-data .text").text(
    //                         "Year " + responce.states.topangry.year + " :"
    //                     );
    //                     $(".low-angry-data .text").text(
    //                         "Year " + responce.states.lowangry.year + " :"
    //                     );
    //                 }
    //
    //                 var total = 0;
    //                 var chart_data = [];
    //                 let loops = 12;
    //                 switch (Object.keys(responce.data[0])[0]) {
    //                     case "year":
    //                         loops = "years";
    //                         break;
    //
    //                     case "month":
    //                         loops = 12;
    //                         break;
    //                     case "day":
    //                         loops = 31;
    //                         break;
    //                     case "hour":
    //                         loops = 24;
    //                         break;
    //                 }
    //
    //                 if (loops != "years") {
    //                     for (let i = 0; i < loops; i++) {
    //                         chart_data.push({
    //                             time: loops == 24 ? i : i + 1,
    //                             angry: 0,
    //                             disgust: 0,
    //                             happy: 0,
    //                             neutral: 0,
    //                             sad: 0,
    //                             surprise: 0,
    //                             fear: 0,
    //                         });
    //                     }
    //
    //                     responce.data.forEach((value) => {
    //                         let total =
    //                             parseInt(value.totalAngry) +
    //                             parseInt(value.totalDisgust) +
    //                             parseInt(value.totalHappy) +
    //                             parseInt(value.totalNeutral) +
    //                             parseInt(value.totalSad) +
    //                             parseInt(value.totalSurprise) +
    //                             parseInt(value.totalFear);
    //                         let x =
    //                             loops == 24
    //                                 ? parseInt(value.time)
    //                                 : parseInt(value.time) - 1;
    //                         chart_data[x].time = value.time;
    //                         chart_data[x].angry = Math.round(
    //                             (parseInt(value.totalAngry) / total) * 100
    //                         );
    //                         chart_data[x].disgust = Math.round(
    //                             (parseInt(value.totalDisgust) / total) * 100
    //                         );
    //                         chart_data[x].happy = Math.round(
    //                             (parseInt(value.totalHappy) / total) * 100
    //                         );
    //                         chart_data[x].neutral = Math.round(
    //                             (parseInt(value.totalNeutral) / total) * 100
    //                         );
    //                         chart_data[x].sad = Math.round(
    //                             (parseInt(value.totalSad) / total) * 100
    //                         );
    //                         chart_data[x].surprise = Math.round(
    //                             (parseInt(value.totalSurprise) / total) * 100
    //                         );
    //                         chart_data[x].fear = Math.round(
    //                             (parseInt(value.totalFear) / total) * 100
    //                         );
    //                     });
    //                 } else {
    //                     let x = 0;
    //                     responce.data.forEach((value) => {
    //                         let total =
    //                             parseInt(value.totalAngry) +
    //                             parseInt(value.totalDisgust) +
    //                             parseInt(value.totalHappy) +
    //                             parseInt(value.totalNeutral) +
    //                             parseInt(value.totalSad) +
    //                             parseInt(value.totalSurprise) +
    //                             parseInt(value.totalFear);
    //                         chart_data[x++] = {
    //                             time: value.time,
    //                             angry: Math.round(
    //                                 (parseInt(value.totalAngry) / total) * 100
    //                             ),
    //                             disgust: Math.round(
    //                                 (parseInt(value.totalDisgust) / total) * 100
    //                             ),
    //                             happy: Math.round(
    //                                 (parseInt(value.totalHappy) / total) * 100
    //                             ),
    //                             neutral: Math.round(
    //                                 (parseInt(value.totalNeutral) / total) * 100
    //                             ),
    //                             sad: Math.round(
    //                                 (parseInt(value.totalSad) / total) * 100
    //                             ),
    //                             surprise: Math.round(
    //                                 (parseInt(value.totalSurprise) / total) *
    //                                     100
    //                             ),
    //                             fear: Math.round(
    //                                 (parseInt(value.totalFear) / total) * 100
    //                             ),
    //                         };
    //                     });
    //                 }
    //
    //                 // chart5.dispose();
    //                 generateChart5(chart_data, lable);
    //             }
    //         },
    //     });
    // }
    //
    // function pushDataToChart6(flag, year, month, day, lable) {
    //     let form_data = new FormData();
    //     form_data.append("year", year);
    //     form_data.append("month", month);
    //     form_data.append("day", day);
    //
    //     $.ajax({
    //         type: "POST",
    //         url: app_url + "/api/charts/getMasks",
    //         data: form_data,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //         contentType: false,
    //         processData: false,
    //         success: function (responce) {
    //             if (responce.data.length === 0) {
    //                 $(".chart6-data").empty();
    //                 $(".chart6-data").css("text-align", "center");
    //                 $(".chart6-data").css("font-size", "30px");
    //                 $(".chart6-data").append("<b>No data found</b>");
    //                 $(".chart6-data b").css("color", "#fff");
    //                 $(".mask-data .text-green").text("");
    //                 $(".nomask-data .text-red").text("");
    //                 $(".totalmask .text-red").text("");
    //             } else {
    //                 $(".mask-data .text-green").text(responce.mask);
    //                 $(".nomask-data .text-red").text(responce.nomask);
    //                 $(".totalmask-data .text-red").text(responce.total);
    //                 var total = 0;
    //                 var chart_data = [];
    //                 let loops = 12;
    //
    //                 switch (Object.keys(responce.data[0])[0]) {
    //                     case "year":
    //                         loops = "years";
    //                         break;
    //                     case "month":
    //                         loops = 12;
    //                         break;
    //                     case "day":
    //                         loops = 31;
    //                         break;
    //                     case "hour":
    //                         loops = 24;
    //                         break;
    //                 }
    //
    //                 if (loops != "years") {
    //                     for (let i = 0; i < loops; i++) {
    //                         chart_data.push({
    //                             time: loops == 24 ? i : i + 1,
    //                             mask: 0,
    //                             nomask: 0,
    //                             total_faces: 0,
    //                         });
    //                     }
    //
    //                     responce.data.forEach((value) => {
    //                         let x =
    //                             loops == 24
    //                                 ? parseInt(value.time)
    //                                 : parseInt(value.time) - 1;
    //                         chart_data[x].time = value.time;
    //                         chart_data[x].mask = value.totalMask;
    //                         chart_data[x].nomask = value.totalNoMask;
    //                         chart_data[x].total_faces = value.total;
    //                     });
    //                 } else {
    //                     let x = 0;
    //                     responce.data.forEach((value) => {
    //                         chart_data[x++] = {
    //                             time: value.time,
    //                             mask: value.totalMask,
    //                             nomask: value.totalNoMask,
    //                             total_faces: value.total,
    //                         };
    //                     });
    //                 }
    //                 // chart5.dispose();
    //                 generateChart6(chart_data, lable);
    //             } //end else
    //         },
    //     });
    // }

    function generateChart4(json, lable = "Months", grid = 10) {
        // Use themes
        am4core.useTheme(am4themes_animated);
        chrart4 = am4core.create("chart4-data", am4charts.XYChart);
        chrart4.logo.disabled= true;

        // Add data
        chrart4.data = json;
        //  chrart4.plotContainer.background.stroke = "#ffffff";

        var xAxis = chrart4.xAxes.push(new am4charts.ValueAxis());
        xAxis.integersOnly = true;
        xAxis.renderer.minGridDistance = grid;
        xAxis.renderer.grid.template.location = 0.5;
        xAxis.startLocation = 1;
        xAxis.endLocation = 1;
        xAxis.title.text = lable;
        xAxis.renderer.labels.template.fill = "#29ABE2";
        xAxis.renderer.baseGrid.stroke = "#29ABE2";
        xAxis.renderer.line.strokeOpacity = 1;
        xAxis.renderer.line.strokeWidth = 1;
        xAxis.renderer.line.stroke = "#29ABE2";
        xAxis.title.fill = am4core.color("#29ABE2");
        xAxis.title.strok = am4core.color("#29ABE2");
        xAxis.numberFormatter = new am4core.NumberFormatter();
        xAxis.numberFormatter.numberFormat = "#";

        var yAxis = chrart4.yAxes.push(new am4charts.ValueAxis());
        yAxis.integersOnly = true;
        yAxis.renderer.baseGrid.stroke = "#29ABE2";
        yAxis.renderer.grid.template.stroke = "#29ABE2";
        yAxis.renderer.labels.template.fill = "#29ABE2";
        yAxis.renderer.grid.template.strokeWidth = 1;
        yAxis.renderer.grid.template.strokeOpacity = 0.8;
        yAxis.renderer.grid.template.strokeDasharray = "10";
        yAxis.renderer.baseGrid.stroke = "#29ABE2";
        yAxis.renderer.line.strokeOpacity = 1;
        yAxis.renderer.line.strokeWidth = 1;
        yAxis.renderer.line.stroke = "#29ABE2";

        yAxis.numberFormatter = new am4core.NumberFormatter();
        yAxis.numberFormatter.numberFormat = "#";

        series4 = chrart4.series.push(new am4charts.LineSeries());
        series4.dataFields.valueX = "time";
        series4.dataFields.valueY = "count";
        series4.strokeWidth = 3;
        series4.fill = "#29ABE2";
        series4.stroke = am4core.color("#29ABE2");

        var bullet1 = series4.bullets.push(new am4charts.CircleBullet());
        series4.heatRules.push({
            target: bullet1.circle,
            min: 5,
            max: 20,
            property: "radius",
        });

        bullet1.tooltipText = "Number of people: {valueY}";
    }
    // function generateChart7(json, lable = "Months", xaxios, color) {
    //     //  chart5.data = json;
    //     am4core.ready(function () {
    //         // Themes begin
    //         am4core.useTheme(am4themes_animated);
    //         // Themes end
    //
    //         var chart = am4core.create("chart7-data", am4charts.XYChart);
    //         chart.colors.step = 2;
    //         chart.colors.list = [am4core.color(color)];
    //
    //         chart.legend = new am4charts.Legend();
    //         chart.legend.position = "top";
    //         chart.legend.paddingBottom = 20;
    //         chart.legend.labels.template.maxWidth = 95;
    //
    //         var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //         xAxis.dataFields.category = "category";
    //         // xAxis.stroke = am4core.color("#fff");
    //         xAxis.renderer.labels.template.fill = "#fff";
    //         xAxis.renderer.baseGrid.stroke = "#ffffff";
    //         xAxis.dataFields.fill = am4core.color("#fff");
    //         xAxis.renderer.cellStartLocation = 0.1;
    //         xAxis.renderer.cellEndLocation = 0.9;
    //         xAxis.renderer.grid.template.location = 0;
    //         xAxis.renderer.minGridDistance = 10;
    //         xAxis.title.text = lable;
    //         xAxis.title.fill = am4core.color("#fff");
    //         xAxis.title.strok = am4core.color("#fff");
    //         xAxis.renderer.line.strokeOpacity = 1;
    //         xAxis.renderer.line.strokeWidth = 5;
    //         xAxis.renderer.line.stroke = am4core.color("#292d3f");
    //
    //         var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //         // yAxis.min = 0;
    //         // yAxis.max = 100000;
    //         yAxis.renderer.line.strokeOpacity = 1;
    //         yAxis.renderer.line.strokeWidth = 5;
    //         yAxis.renderer.line.stroke = am4core.color("#292d3f");
    //         // yAxis.stroke = am4core.color("#fff");
    //         yAxis.renderer.labels.template.fill = "#fff";
    //         yAxis.renderer.baseGrid.stroke = "#ffffff";
    //         yAxis.renderer.grid.template.strokeWidth = 1;
    //         yAxis.renderer.grid.template.strokeOpacity = 0.6;
    //         yAxis.renderer.grid.template.strokeDasharray = "10";
    //         yAxis.renderer.baseGrid.stroke = "#ffffff";
    //         yAxis.renderer.grid.template.stroke = "#ffffff";
    //
    //         function createSeries(value, name) {
    //             var series = chart.series.push(new am4charts.ColumnSeries());
    //
    //             series.dataFields.valueY = value;
    //             series.dataFields.categoryX = "category";
    //             series.tooltipText = "{key}";
    //
    //             chart.cursor = new am4charts.XYCursor();
    //             chart.cursor.lineY.disabled = true;
    //             chart.cursor.lineX.disabled = true;
    //
    //             series.name = name;
    //             series.columns.template.width = am4core.percent(30);
    //             series.events.on("hidden", arrangeColumns);
    //             series.events.on("shown", arrangeColumns);
    //
    //             var label = series.columns.template.createChild(am4core.Label);
    //             label.text = "{valueY}";
    //             label.align = "center";
    //             label.width = 20;
    //             label.dy = -20;
    //             label.fill = am4core.color("#fff");
    //             label.valign = "top";
    //             label.zIndex = 2;
    //             label.strokeWidth = 0;
    //             return series;
    //         }
    //
    //         chart.data = json;
    //
    //         createSeries(xaxios, "", "");
    //
    //         function arrangeColumns() {
    //             var series = chart.series.getIndex(0);
    //
    //             var w =
    //                 1 -
    //                 xAxis.renderer.cellStartLocation -
    //                 (1 - xAxis.renderer.cellEndLocation);
    //             if (series.dataItems.length > 1) {
    //                 var x0 = xAxis.getX(
    //                     series.dataItems.getIndex(0),
    //                     "categoryX"
    //                 );
    //                 var x1 = xAxis.getX(
    //                     series.dataItems.getIndex(1),
    //                     "categoryX"
    //                 );
    //                 var delta = ((x1 - x0) / chart.series.length) * w;
    //                 if (am4core.isNumber(delta)) {
    //                     var middle = chart.series.length / 2;
    //
    //                     var newIndex = 0;
    //                     chart.series.each(function (series) {
    //                         if (!series.isHidden && !series.isHiding) {
    //                             series.dummyData = newIndex;
    //                             newIndex++;
    //                         } else {
    //                             series.dummyData = chart.series.indexOf(series);
    //                         }
    //                     });
    //                     var visibleCount = newIndex;
    //                     var newMiddle = visibleCount / 2;
    //
    //                     chart.series.each(function (series) {
    //                         var trueIndex = chart.series.indexOf(series);
    //                         var newIndex = series.dummyData;
    //
    //                         var dx =
    //                             (newIndex - trueIndex + middle - newMiddle) *
    //                             delta;
    //
    //                         series.animate(
    //                             {
    //                                 property: "dx",
    //                                 to: dx,
    //                             },
    //                             series.interpolationDuration,
    //                             series.interpolationEasing
    //                         );
    //                         series.bulletsContainer.animate(
    //                             {
    //                                 property: "dx",
    //                                 to: dx,
    //                             },
    //                             series.interpolationDuration,
    //                             series.interpolationEasing
    //                         );
    //                     });
    //                 }
    //             }
    //         }
    //     }); // end am4core.ready()
    // }
    // function generateChart8(json, lable = "Months") {
    //     //  chart5.data = json;
    //     am4core.ready(function () {
    //         // Themes begin
    //         am4core.useTheme(am4themes_animated);
    //
    //         // Themes end
    //
    //         var chart = am4core.create("chart8-data", am4charts.XYChart);
    //         chart.colors.list = [
    //             am4core.color("#28C76F"),
    //             am4core.color("#D1000E"),
    //             am4core.color("#199BFC"),
    //         ];
    //
    //         chart.legend = new am4charts.Legend();
    //         chart.legend.labels.template.fill = am4core.color("#fff");
    //         chart.legend.valueLabels.template.fill = am4core.color("#fff");
    //         chart.legend.position = "top";
    //         chart.legend.paddingBottom = 20;
    //         chart.legend.labels.template.maxWidth = 95;
    //         chart.focusFilter.strokeWidth = 5;
    //
    //         var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //         xAxis.dataFields.category = "category";
    //         // xAxis.stroke = am4core.color("#fff");
    //         xAxis.renderer.labels.template.fill = "#fff";
    //         xAxis.renderer.baseGrid.stroke = "#ffffff";
    //         xAxis.dataFields.fill = am4core.color("#fff");
    //         xAxis.renderer.cellStartLocation = 0.1;
    //         xAxis.renderer.cellEndLocation = 0.9;
    //         xAxis.renderer.grid.template.location = 0;
    //         xAxis.renderer.minGridDistance = 10;
    //         xAxis.title.text = lable;
    //         xAxis.title.fill = am4core.color("#fff");
    //         xAxis.title.strok = am4core.color("#fff");
    //         xAxis.renderer.line.strokeOpacity = 1;
    //         xAxis.renderer.line.strokeWidth = 5;
    //         xAxis.renderer.line.stroke = am4core.color("#292d3f");
    //
    //         var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //         yAxis.min = 0;
    //         yAxis.renderer.line.strokeOpacity = 1;
    //         yAxis.renderer.line.strokeWidth = 5;
    //         yAxis.renderer.line.stroke = am4core.color("#292d3f");
    //         // yAxis.stroke = am4core.color("#fff");
    //         yAxis.renderer.labels.template.fill = "#fff";
    //         yAxis.renderer.baseGrid.stroke = "#ffffff";
    //         yAxis.renderer.grid.template.strokeWidth = 1;
    //         yAxis.renderer.grid.template.strokeOpacity = 0.6;
    //         yAxis.renderer.grid.template.strokeDasharray = "10";
    //         yAxis.renderer.baseGrid.stroke = "#ffffff";
    //         yAxis.renderer.grid.template.stroke = "#ffffff";
    //
    //         function createSeries(value, name) {
    //             var series = chart.series.push(new am4charts.ColumnSeries());
    //             series.dataFields.valueY = value;
    //             series.dataFields.categoryX = "category";
    //             series.name = name;
    //             series.columns.template.width = am4core.percent(30);
    //
    //             series.events.on("hidden", arrangeColumns);
    //             series.events.on("shown", arrangeColumns);
    //             var label = series.columns.template.createChild(am4core.Label);
    //             label.text = "{valueY}";
    //             label.align = "center";
    //             label.width = 20;
    //             label.dy = -20;
    //             label.fill = am4core.color("#fff");
    //             label.valign = "top";
    //             label.zIndex = 2;
    //             label.strokeWidth = 0;
    //
    //             return series;
    //         }
    //
    //         chart.data = json;
    //
    //         createSeries("happy", "happy");
    //         createSeries("angry", "angry");
    //         createSeries("neutral", "neutral");
    //
    //         function arrangeColumns() {
    //             var series = chart.series.getIndex(0);
    //
    //             var w =
    //                 1 -
    //                 xAxis.renderer.cellStartLocation -
    //                 (1 - xAxis.renderer.cellEndLocation);
    //             if (series.dataItems.length > 1) {
    //                 var x0 = xAxis.getX(
    //                     series.dataItems.getIndex(0),
    //                     "categoryX"
    //                 );
    //                 var x1 = xAxis.getX(
    //                     series.dataItems.getIndex(1),
    //                     "categoryX"
    //                 );
    //                 var delta = ((x1 - x0) / chart.series.length) * w;
    //                 if (am4core.isNumber(delta)) {
    //                     var middle = chart.series.length / 2;
    //
    //                     var newIndex = 0;
    //                     chart.series.each(function (series) {
    //                         if (!series.isHidden && !series.isHiding) {
    //                             series.dummyData = newIndex;
    //                             newIndex++;
    //                         } else {
    //                             series.dummyData = chart.series.indexOf(series);
    //                         }
    //                     });
    //                     var visibleCount = newIndex;
    //                     var newMiddle = visibleCount / 2;
    //
    //                     chart.series.each(function (series) {
    //                         var trueIndex = chart.series.indexOf(series);
    //                         var newIndex = series.dummyData;
    //
    //                         var dx =
    //                             (newIndex - trueIndex + middle - newMiddle) *
    //                             delta;
    //
    //                         series.animate(
    //                             {
    //                                 property: "dx",
    //                                 to: dx,
    //                             },
    //                             series.interpolationDuration,
    //                             series.interpolationEasing
    //                         );
    //                         series.bulletsContainer.animate(
    //                             {
    //                                 property: "dx",
    //                                 to: dx,
    //                             },
    //                             series.interpolationDuration,
    //                             series.interpolationEasing
    //                         );
    //                     });
    //                 }
    //             }
    //         }
    //     }); // end am4core.ready()
    // }
    //
    // function pushDataToChart7(image_id, flag, year, month, day, lable, check) {
    //     let form_data = new FormData();
    //     form_data.append("year", year);
    //     form_data.append("month", month);
    //     form_data.append("day", day);
    //     form_data.append("image_id", image_id);
    //
    //     $.ajax({
    //         type: "POST",
    //         url: app_url + "/api/charts/heatmapLowHigh",
    //         data: form_data,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //         contentType: false,
    //         processData: false,
    //         success: function (responce) {
    //             if (responce.data.length === 0) {
    //                 $("#chart7-data").empty();
    //                 $("#chart7-data").css("text-align", "center");
    //                 $("#chart7-data").css("font-size", "30px");
    //                 $("#chart7-data").append("<b>No data found</b>");
    //                 $(".chart7-data b").css("color", "#fff");
    //             } else {
    //                 var total = 0;
    //                 var chart_data = [];
    //                 let loops = 12;
    //                 switch (responce.data[0]["flag"]) {
    //                     case "year":
    //                         loops = "years";
    //                         break;
    //                     case "month":
    //                         loops = 12;
    //                         break;
    //                     case "day":
    //                         loops = 31;
    //                         break;
    //                     case "hour":
    //                         loops = 24;
    //                         break;
    //                 }
    //
    //                 if (loops != "years") {
    //                     if (check == "high") {
    //                         for (let i = 0; i < loops; i++) {
    //                             chart_data.push({
    //                                 category: loops == 24 ? i : i + 1,
    //                                 max: 0,
    //                                 key: 0,
    //                             });
    //                         }
    //
    //                         responce.data.forEach((value) => {
    //                             let x =
    //                                 loops == 24
    //                                     ? parseInt(value.time)
    //                                     : parseInt(value.time) - 1;
    //                             chart_data[x].category = value.time;
    //                             chart_data[x].max = value.max;
    //                             chart_data[x].key = value.max_regname;
    //                         });
    //                         $(".heat-chart-title .text-blue").text(
    //                             "TOP Activity location"
    //                         );
    //                         $(".heat-chart-title .text-red").text("");
    //                         generateChart7(chart_data, lable, "max", "#199bfc");
    //                     } else {
    //                         for (let i = 0; i < loops; i++) {
    //                             chart_data.push({
    //                                 category: i + 1,
    //                                 min: 0,
    //                                 key: 0,
    //                             });
    //                         }
    //
    //                         responce.data.forEach((value) => {
    //                             let x = parseInt(value.time) - 1;
    //                             chart_data[x].category = value.time;
    //                             chart_data[x].min = value.min;
    //                             chart_data[x].key = value.min_regname;
    //                         });
    //                         $(".heat-chart-title .text-red").text(
    //                             "Lowest Activity location"
    //                         );
    //                         $(".heat-chart-title .text-blue").text("");
    //                         generateChart7(chart_data, lable, "min", "#d1000e");
    //                     }
    //                 } else {
    //                     let x = 0;
    //                     if (check == "high") {
    //                         responce.data.forEach((value) => {
    //                             chart_data[x++] = {
    //                                 category: value.time,
    //                                 max: value.max,
    //                                 key: value.max_regname,
    //                             };
    //                         });
    //                         $(".heat-chart-title .text-blue").text(
    //                             "TOP Activity location"
    //                         );
    //                         $(".heat-chart-title .text-red").text("");
    //                         generateChart7(chart_data, lable, "max", "#199bfc");
    //                     } else {
    //                         responce.data.forEach((value) => {
    //                             chart_data[x++] = {
    //                                 category: value.time,
    //                                 min: value.min,
    //                                 key: value.min_regname,
    //                             };
    //                         });
    //                         $(".heat-chart-title .text-red").text(
    //                             "Lowest Activity location"
    //                         );
    //                         $(".heat-chart-title .text-blue").text("");
    //                         generateChart7(chart_data, lable, "min", "#d1000e");
    //                     }
    //                 }
    //
    //                 // chart5.dispose();
    //             }
    //         },
    //     });
    // }
    // function pushDataToChart8(flag, year, month, day, lable) {
    //     let form_data = new FormData();
    //     form_data.append("year", year);
    //     form_data.append("month", month);
    //     form_data.append("day", day);
    //
    //     $.ajax({
    //         type: "POST",
    //         url: app_url + "/api/charts/getMainEmotions",
    //         data: form_data,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //         contentType: false,
    //         processData: false,
    //         success: function (responce) {
    //             if (responce.data.length === 0) {
    //                 $(".chart8-data").empty();
    //                 $(".chart8-data").css("text-align", "center");
    //                 $(".chart8-data").css("font-size", "30px");
    //                 $(".chart8-data").append("<b>No data found</b>");
    //                 $(".chart8-data b").css("color", "#fff");
    //             } else {
    //                 var total = 0;
    //                 var chart_data = [];
    //                 let loops = 12;
    //                 switch (responce.data[0]["flag"]) {
    //                     case "year":
    //                         loops = "years";
    //                         break;
    //                     case "month":
    //                         loops = 12;
    //                         break;
    //                     case "day":
    //                         loops = 31;
    //                         break;
    //                     case "hour":
    //                         loops = 24;
    //                         break;
    //                 }
    //                 if (loops != "years") {
    //                     for (let i = 0; i < loops; i++) {
    //                         chart_data.push({
    //                             category: loops == 24 ? i : i + 1,
    //                             happy: 0,
    //                             neutral: 0,
    //                             angry: 0,
    //                         });
    //                     }
    //                     responce.data.forEach((value) => {
    //                         let x =
    //                             loops == 24
    //                                 ? parseInt(value.time)
    //                                 : parseInt(value.time) - 1;
    //                         chart_data[x].category = value.time;
    //                         chart_data[x].happy = value.happy;
    //                         chart_data[x].neutral = value.neutral;
    //                         chart_data[x].angry = value.angry;
    //                     });
    //                 } else {
    //                     let x = 0;
    //                     responce.data.forEach((value) => {
    //                         chart_data[x++] = {
    //                             category: value.time,
    //                             happy: value.happy,
    //                             neutral: value.neutral,
    //                             angry: value.angry,
    //                         };
    //                     });
    //                 }
    //
    //                 // chart5.dispose();
    //                 generateChart8(chart_data, lable);
    //             }
    //         },
    //     });
    // }

    function pushDataToChart4(flag, year, month, day, lable) {
        let form_data = new FormData();

        form_data.append("flag", flag);
        form_data.append("usermodelbranchid", $('#usermodelbranchid').val());
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);

        $.ajax({
            type: "POST",
            url: app_url + "/api/charts/getTotalPeople",
            data: form_data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response.data.data);
                const monthNames = [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ];
                if (!response.data.data) {
                    $(".chart4-data").empty();
                    $(".chart4-data").css("text-align", "center");
                    $(".chart4-data").css("font-size", "30px");
                    $(".chart4-data").append("<b>No data found</b>");
                    $(".chart4-data b").css("color", "#29ABE2");
                    $(".people_top_flag .text").text(response.flag);
                    $(".people_low_flag .text").text(response.flag);
                    $(".people_top_data .text-green").text("");
                    $(".people_low_data .text-red").text("");
                    $(".people_top_data .text").text("");
                    $(".people_low_data .text").text("");
                } else {
                    $(".people_top_flag .text").text(response.flag);
                    $(".people_low_flag .text").text(response.flag);
                    $(".people_top_data .text-green").text(response.top.count);
                    $(".people_low_data .text-red").text(response.low.count);
                    if (response.flag == "Month") {
                        $(".people_top_data .text").text(
                            monthNames[response.top.month - 1] + " :"
                        );
                        $(".people_low_data .text").text(
                            monthNames[response.low.month - 1] + " :"
                        );
                    } else if (response.flag == "Year") {
                        $(".people_top_data .text").text(
                            "Year " + response.top.year + " :"
                        );
                        $(".people_low_data .text").text(
                            "Year " + response.low.year + " :"
                        );
                    }

                    var total = 0;
                    var chart_data = [];
                    let loops = 12;
                    if (response.flag == "Year") {

                            loops = "years";
                     }else  if (response.flag == "Month"){

                        loops = 12;
                    }else{
                        loops = 31;
                    }

                    if (loops != "years") {
                        if(loops==12) {

                            for (let i = 0; i <= loops; i++) {
                                chart_data.push({
                                    time:  i,
                                    count: 0,
                                });
                            }
                            Object.entries(response.filter).forEach((value) => {
                                let x =parseInt(value[0]);
                                chart_data[x].time = value[0];
                                chart_data[x].count = value[1];
                            });

                            generateChart4(chart_data, lable,2);
                        }else{
                            for (let i = 0; i < loops; i++) {
                                chart_data.push({
                                    time:  i+1,
                                    count: 0,
                                });
                            }
                            Object.entries(response.filter).forEach((value) => {
                                let x =parseInt(value[0]);
                                chart_data[x].time = value[0];
                                chart_data[x].count = value[1];
                            });

                            generateChart4(chart_data, lable);
                        }
                    } else {
                        let x = 0;
                        console.log(Object.entries(response.filter));
                        Object.entries(response.filter).forEach((value) => {

                            chart_data[x++] = {
                                time: value[0],
                                count: value[1],
                            };
                        });
                        $year = parseInt(chart_data[0].time) - 1;
                       // alert($year);
                        chart_data.push({
                            time: String($year),
                            count: 0,
                        });
                        generateChart4(chart_data, lable, 400);
                    }
                }
            },
        });
    }

    // function pushDataToChart3(image_id, year, month, day) {
    //     let form_data = new FormData();
    //
    //     form_data.append("image_id", image_id);
    //     form_data.append("year", year);
    //     form_data.append("month", month);
    //     form_data.append("day", day);
    //
    //     $.ajax({
    //         type: "POST",
    //         url: app_url + "/api/charts/getHeatMapData",
    //         data: form_data,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //         contentType: false,
    //         processData: false,
    //         success: function (responce) {
    //             if (responce.data.length === 0) {
    //                 $(".heat-low-data .text").text("");
    //                 $(".heat-top-data .text").text("");
    //                 $(".heatmap-canvas").remove();
    //                 $(".heat-filter").prop("checked", false);
    //                 $("#heatmapContainer span").remove();
    //             }
    //             $(".heat-low-data .text").text(
    //                 "( " +
    //                     responce.percent.minRateName +
    //                     " ) " +
    //                     responce.percent.minRateValue +
    //                     " %"
    //             );
    //             $(".heat-top-data .text").text(
    //                 "( " +
    //                     responce.percent.maxRateName +
    //                     ")  " +
    //                     responce.percent.maxRateValue +
    //                     " %"
    //             );
    //             var config = {
    //                 container: document.getElementById("heatmapContainer"),
    //                 radius: 70,
    //                 maxOpacity: 0.5,
    //                 minOpacity: 0,
    //                 blur: 0.75,
    //                 gradient: {
    //                     ".5": "blue",
    //                     ".8": "yellow",
    //                     ".95": "red",
    //                 },
    //             };
    //
    //             $(".heatmap-canvas").remove();
    //             $("#heatmapContainer span").remove();
    //             $(".heat-filter").prop("checked", false);
    //             heatmapInstance = h337.create(config);
    //
    //             var data = {
    //                 max: responce.max,
    //                 min: 0,
    //                 data: responce.data,
    //             };
    //             // heatmapInstance.setDataMax(12000);
    //             heatmapInstance.setData(data);
    //             responce.rates.forEach((value) => {
    //                 $("#heatmapContainer").append(
    //                     '<span addClass="rate-hint" style=" left:' +
    //                         value.x +
    //                         "px !important;top:" +
    //                         value.y +
    //                         'px !important ">' +
    //                         '<div class="pr-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="26" viewBox="0 0 11.332 18.855">\n' +
    //                         '  <g id="Group_7383" data-name="Group 7383" transform="translate(-164.504 -865.461)">\n' +
    //                         '    <path id="Path_5942" data-name="Path 5942" d="M175.675,872.467a5.666,5.666,0,1,0-11.01,0,8.446,8.446,0,0,0,.619,2.2c.557,1.17,2.9,5.03,3.975,6.789-1.454.185-2.13.81-2.13,1.4,0,.7.952,1.456,3.041,1.456s3.041-.755,3.041-1.456c0-.59-.675-1.215-2.129-1.4,1.075-1.759,3.419-5.619,3.975-6.789A8.469,8.469,0,0,0,175.675,872.467Zm-3.341,10.393c-.059.166-.791.581-2.164.581-1.389,0-2.122-.426-2.166-.576.04-.145.637-.5,1.765-.574l.028.046a.437.437,0,0,0,.745,0l.028-.046C171.685,882.362,172.281,882.711,172.334,882.86Zm2.487-10.585c0,.011,0,.022-.006.034a7.809,7.809,0,0,1-.548,1.986c-.562,1.18-3.127,5.394-4.1,6.977-.97-1.583-3.535-5.8-4.1-6.977a7.81,7.81,0,0,1-.547-1.986c0-.012,0-.023-.007-.034a4.791,4.791,0,1,1,9.3,0Z" transform="translate(0 0)" fill="#fff"/>\n' +
    //                         '    <path id="Path_5943" data-name="Path 5943" d="M172.436,870.083a3.041,3.041,0,1,0,3.041,3.04A3.044,3.044,0,0,0,172.436,870.083Zm0,5.206a2.165,2.165,0,1,1,2.166-2.165A2.168,2.168,0,0,1,172.436,875.289Z" transform="translate(-2.266 -2.142)" fill="#fff"/>\n' +
    //                         "  </g>\n" +
    //                         "</svg>\n<br>" +
    //                         value.name +
    //                         "</div>" +
    //                         '<div class="ml-2">Rate: ' +
    //                         value.rate +
    //                         "% </div>" +
    //                         "</span>"
    //                 );
    //             });
    //         },
    //     });
    // } // end pushDataToChart3
    //
    // function pushDataToChart3Plus(image_id, year, month, day, regions) {
    //     let form_data = new FormData();
    //     form_data.append("image_id", image_id);
    //     form_data.append("year", year);
    //     form_data.append("month", month);
    //     form_data.append("day", day);
    //     form_data.append("regions", regions);
    //     $.ajax({
    //         type: "POST",
    //         url: app_url + "/api/charts/ignoreDisabledData",
    //         data: form_data,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //         contentType: false,
    //         processData: false,
    //         success: function (responce) {
    //             if (responce.data.length === 0) {
    //                 $(".heat-low-data .text").text("");
    //                 $(".heat-top-data .text").text("");
    //                 $(".heatmap-canvas").remove();
    //                 $(".heat-filter").prop("checked", false);
    //                 $("#heatmapContainer span").remove();
    //             }
    //             $(".heat-low-data .text").text(
    //                 "( " +
    //                     responce.percent.minRateName +
    //                     " ) " +
    //                     responce.percent.minRateValue +
    //                     " %"
    //             );
    //             $(".heat-top-data .text").text(
    //                 "( " +
    //                     responce.percent.maxRateName +
    //                     ")  " +
    //                     responce.percent.maxRateValue +
    //                     " %"
    //             );
    //             var config = {
    //                 container: document.getElementById("heatmapContainer"),
    //                 radius: 70,
    //                 maxOpacity: 0.5,
    //                 minOpacity: 0,
    //                 blur: 0.75,
    //                 gradient: {
    //                     ".5": "blue",
    //                     ".8": "yellow",
    //                     ".95": "red",
    //                 },
    //             };
    //
    //             $(".heatmap-canvas").remove();
    //             $("#heatmapContainer span").remove();
    //             $(".heat-filter").prop("checked", false);
    //             heatmapInstance = h337.create(config);
    //
    //             var data = {
    //                 max: responce.max,
    //                 min: 0,
    //                 data: responce.data,
    //             };
    //             // heatmapInstance.setDataMax(12000);
    //             heatmapInstance.setData(data);
    //             responce.rates.forEach((value) => {
    //                 $("#heatmapContainer").append(
    //                     '<span addClass="rate-hint" style=" left:' +
    //                         value.x +
    //                         "px !important;top:" +
    //                         value.y +
    //                         'px !important ">' +
    //                         '<div class="pr-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="26" viewBox="0 0 11.332 18.855">\n' +
    //                         '  <g id="Group_7383" data-name="Group 7383" transform="translate(-164.504 -865.461)">\n' +
    //                         '    <path id="Path_5942" data-name="Path 5942" d="M175.675,872.467a5.666,5.666,0,1,0-11.01,0,8.446,8.446,0,0,0,.619,2.2c.557,1.17,2.9,5.03,3.975,6.789-1.454.185-2.13.81-2.13,1.4,0,.7.952,1.456,3.041,1.456s3.041-.755,3.041-1.456c0-.59-.675-1.215-2.129-1.4,1.075-1.759,3.419-5.619,3.975-6.789A8.469,8.469,0,0,0,175.675,872.467Zm-3.341,10.393c-.059.166-.791.581-2.164.581-1.389,0-2.122-.426-2.166-.576.04-.145.637-.5,1.765-.574l.028.046a.437.437,0,0,0,.745,0l.028-.046C171.685,882.362,172.281,882.711,172.334,882.86Zm2.487-10.585c0,.011,0,.022-.006.034a7.809,7.809,0,0,1-.548,1.986c-.562,1.18-3.127,5.394-4.1,6.977-.97-1.583-3.535-5.8-4.1-6.977a7.81,7.81,0,0,1-.547-1.986c0-.012,0-.023-.007-.034a4.791,4.791,0,1,1,9.3,0Z" transform="translate(0 0)" fill="#fff"/>\n' +
    //                         '    <path id="Path_5943" data-name="Path 5943" d="M172.436,870.083a3.041,3.041,0,1,0,3.041,3.04A3.044,3.044,0,0,0,172.436,870.083Zm0,5.206a2.165,2.165,0,1,1,2.166-2.165A2.168,2.168,0,0,1,172.436,875.289Z" transform="translate(-2.266 -2.142)" fill="#fff"/>\n' +
    //                         "  </g>\n" +
    //                         "</svg>\n<br>" +
    //                         value.name +
    //                         "</div>" +
    //                         '<div class="ml-2">Rate: ' +
    //                         value.rate +
    //                         "% </div>" +
    //                         "</span>"
    //                 );
    //             });
    //         },
    //     });
    // } // end pushDataToChart3Plus

    // $("#ch5_y").change(function (e) {
    //     $("#ch5_mo").val("all");
    //     $("#ch5_da").val("all");
    //     let year = $(this).val();
    //
    //     if (year == "all") {
    //         pushDataToChart5("year", "all", 0, 0, "years");
    //     } else {
    //         pushDataToChart5("year", year, 0, 0, "Months");
    //     }
    // });

    // $("#ch5_mo").change(function (e) {
    //     $("#ch5_da").val("all");
    //     if ($("#ch5_y").val() == "all") {
    //         $("#ch5_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch5_y").val();
    //     let month = $("#ch5_mo").val();
    //     pushDataToChart5("month", year, month, 0, "Days");
    // });
    //
    // $("#ch5_da").change(function (e) {
    //     if ($("#ch5_y").val() == "all") {
    //         $("#ch5_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch5_y").val();
    //     let month = $("#ch5_mo").val();
    //     let day = $("#ch5_da").val();
    //     pushDataToChart5("day", year, month, day, "Hours");
    // });
    //
    // $("#ch6_y").change(function (e) {
    //     $("#ch6_mo").val("all");
    //     $("#ch6_da").val("all");
    //     let year = $(this).val();
    //
    //     if (year == "all") {
    //         pushDataToChart6("year", "all", 0, 0, "years");
    //     } else {
    //         pushDataToChart6("year", year, 0, 0, "Months");
    //     }
    // });
    //
    // $("#ch6_mo").change(function (e) {
    //     $("#ch6_da").val("all");
    //     if ($("#ch6_y").val() == "all") {
    //         $("#ch6_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch6_y").val();
    //     let month = $("#ch6_mo").val();
    //     pushDataToChart6("month", year, month, 0, "Days");
    // });
    //
    // $("#ch6_da").change(function (e) {
    //     if ($("#ch6_y").val() == "all") {
    //         $("#ch6_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch6_y").val();
    //     let month = $("#ch6_mo").val();
    //     let day = $("#ch6_da").val();
    //     pushDataToChart6("day", year, month, day, "Hours");
    // });

    $("#ch4_ye").change(function (e) {
        if($(this).val()=="none" || $(this).val()=="all"){
            $("#ch4_mo").attr('disabled',true);
        }else{
            $("#ch4_mo").removeAttr('disabled');
        }
        $("#ch4_mo").val("all");
        let year = $(this).val();
        if (year == "all") {
            pushDataToChart4("year", "all", 'all', 0, "years");
        } else {
            pushDataToChart4("month", year, 'all', 0, "Months");
        }
    });

    $("#ch4_mo").change(function (e) {
        // $("#ch4_da").val("all");
        if ($("#ch4_ye").val() == "all") {
            $("#ch4_ye").prop("selectedIndex", 1);
        }
        let year = $("#ch4_ye").val();
        let month = $("#ch4_mo").val();
        if( $("#ch4_ye").val()=='all'){
            pushDataToChart4("year", "all", 'all', 0, "years");
        }else {
            if( $("#ch4_mo").val()=='all'){
                pushDataToChart4("month", year, month, 0, "Months");
            }else {
                pushDataToChart4("month", year, month, 0, "Days");
            }

        }
    });

    // $("#ch4_da").change(function (e) {
    //     if ($("#ch4_ye").val() == "all") {
    //         $("#ch4_ye").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch4_ye").val();
    //     let month = $("#ch4_mo").val();
    //     let day = $("#ch4_da").val();
    //     pushDataToChart4("day", year, month, day, "Hours");
    // });
    //
    // $("#ch3_y").change(function (e) {
    //     $("#ch3_mo").val("all");
    //     $("#ch3_da").val("all");
    //
    //     let year = $(this).val();
    //     let image_id = $("input#mainimg").val();
    //     pushDataToChart3(image_id, year, 0, 0);
    // });
    //
    // $("#ch3_mo").change(function (e) {
    //     $("#ch3_da").val("all");
    //     if ($("#ch3_y").val() == "all") {
    //         $("#ch3_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch3_y").val();
    //     let month = $("#ch3_mo").val();
    //     let image_id = $("input#mainimg").val();
    //
    //     pushDataToChart3(image_id, year, month, 0);
    // });
    //
    // $("#ch3_da").change(function (e) {
    //     if ($("#ch3_y").val() == "all") {
    //         $("#ch3_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch3_y").val();
    //     let month = $("#ch3_mo").val();
    //     let day = $("#ch3_da").val();
    //
    //     let image_id = $("input#mainimg").val();
    //
    //     pushDataToChart3(image_id, year, month, day);
    // });
    //
    // $("#ch7_y").change(function (e) {
    //     $("#ch7_mo").val("all");
    //     $("#ch7_da").val("all");
    //
    //     let year = $(this).val();
    //     let image_id = $("input#mainimg-filter").val();
    //     let data = $("input#activity").val();
    //     pushDataToChart7(image_id, "year", year, 0, 0, "Months", data);
    // });
    //
    // $("#ch7_mo").change(function (e) {
    //     $("#ch7_da").val("all");
    //     if ($("#ch7_y").val() == "all") {
    //         $("#ch7_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch7_y").val();
    //     let month = $("#ch7_mo").val();
    //     let image_id = $("input#mainimg-filter").val();
    //     let data = $("input#activity").val();
    //
    //     pushDataToChart7(image_id, "month", year, month, 0, "Days", data);
    // });
    //
    // $("#ch7_da").change(function (e) {
    //     if ($("#ch7_y").val() == "all") {
    //         $("#ch7_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch7_y").val();
    //     let month = $("#ch7_mo").val();
    //     let day = $("#ch7_da").val();
    //
    //     let image_id = $("input#mainimg-filter").val();
    //     let data = $("input#activity").val();
    //
    //     pushDataToChart7(image_id, "day", year, month, day, "Hours", data);
    // });
    //
    // $("#ch8_y").change(function (e) {
    //     $("#ch8_mo").val("all");
    //     $("#ch8_da").val("all");
    //     let year = $(this).val();
    //
    //     if (year == "all") {
    //         pushDataToChart8("year", "all", 0, 0, "years");
    //     } else {
    //         pushDataToChart8("year", year, 0, 0, "Months");
    //     }
    // });
    //
    // $("#ch8_mo").change(function (e) {
    //     $("#ch8_da").val("all");
    //     if ($("#ch8_y").val() == "all") {
    //         $("#ch8_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch8_y").val();
    //     let month = $("#ch8_mo").val();
    //     pushDataToChart8("month", year, month, 0, "Days");
    // });
    //
    // $("#ch8_da").change(function (e) {
    //     if ($("#ch8_y").val() == "all") {
    //         $("#ch8_y").prop("selectedIndex", 1);
    //     }
    //     let year = $("#ch8_y").val();
    //     let month = $("#ch8_mo").val();
    //     let day = $("#ch8_da").val();
    //     pushDataToChart8("day", year, month, day, "Hours");
    // });

    // $("#ch3filter").change(function (e) {
    //     let image_id = $("#ch3filter").val();
    //     $.ajax({
    //         url: app_url + "/api/charts/getFilterImage/" + image_id,
    //         type: "GET",
    //         dataType: "json",
    //         success: function (res) {
    //             $("#ch3_y").val("none");
    //             $("#heatmapContainer").empty();
    //             $("#heatmapContainer").append(
    //                 '<img id="theImg" style="width:100%;height:100%;" src="' +
    //                     app_url +
    //                     "/assets/images/" +
    //                     res.data.name +
    //                     '" />'
    //             );
    //             $("#mainimg").val(res.data.id);
    //         },
    //     });
    // });

    setTimeout(function () {
        // $("#ch3_y").val("all");
        // $("#ch3_y").trigger("change");
    }, 7000);
});
