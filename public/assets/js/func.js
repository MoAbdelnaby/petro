$(document).ready(function () {
    "use strict";

    $(".ch4_export").click(function (e) {
        console.log("sdfdf");
        let year = $("#ch4_y").val();
        let month = $("#ch4_mo").val();
        let day = $("#ch4_da").val();
        pushTopeopleData(year, month, day);
    });
    function pushTopeopleData(year, month, day) {
        let form_data = new FormData();
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);

        axios
            .post(app_url + "/api/api/exports/people_count", form_data, {
                responseType: "blob",
                headers: {
                    "Content-Type": "application/json;charset=UTF-8",
                    "Access-Control-Allow-Origin": "*",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
            .then(function (response) {
                console.log(response);
                const url = URL.createObjectURL(
                    new Blob([response.data], {
                        type:
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    })
                );
                const link = document.createElement("a");
                link.href = url;
                let date = new Date();
                link.setAttribute(
                    "download",
                    name + "-" + date.toDateString() + ".xlsx"
                );
                document.body.appendChild(link);
                link.click();
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    $(".ch5_export").click(function (e) {
        let year = $("#ch5_y").val();
        let month = $("#ch5_mo").val();
        let day = $("#ch5_da").val();
        pushToEmotionsData(year, month, day);
    });
    function pushToEmotionsData(year, month, day) {
        let form_data = new FormData();
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);

        axios
            .post(app_url + "/api/api/exports/emotions_count", form_data, {
                responseType: "blob",
                headers: {
                    "Content-Type": "application/json;charset=UTF-8",
                    "Access-Control-Allow-Origin": "*",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
            .then(function (response) {
                console.log(response);
                const url = URL.createObjectURL(
                    new Blob([response.data], {
                        type:
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    })
                );
                const link = document.createElement("a");
                link.href = url;
                let date = new Date();
                link.setAttribute(
                    "download",
                    name + "-" + date.toDateString() + ".xlsx"
                );
                document.body.appendChild(link);
                link.click();
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    $(".ch6_export").click(function (e) {
        let year = $("#ch6_y").val();
        let month = $("#ch6_mo").val();
        let day = $("#ch6_da").val();

        pushToMasksData(year, month, day);
    });
    function pushToMasksData(year, month, day) {
        let form_data = new FormData();
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);

        axios
            .post(app_url + "/api/api/exports/masks_count", form_data, {
                responseType: "blob",
                headers: {
                    "Content-Type": "application/json;charset=UTF-8",
                    "Access-Control-Allow-Origin": "*",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
            .then(function (response) {
                console.log(response);
                const url = URL.createObjectURL(
                    new Blob([response.data], {
                        type:
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    })
                );
                const link = document.createElement("a");
                link.href = url;
                let date = new Date();
                link.setAttribute(
                    "download",
                    name + "-" + date.toDateString() + ".xlsx"
                );
                document.body.appendChild(link);
                link.click();
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    $(".ch8_export").click(function (e) {
        let year = $("#ch8_y").val();
        let month = $("#ch8_mo").val();
        let day = $("#ch8_da").val();

        pushToMainEmotionsData(year, month, day);
    });
    function pushToMainEmotionsData(year, month, day) {
        let form_data = new FormData();
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);

        axios
            .post(app_url + "/api/api/exports/top_emotions_count", form_data, {
                responseType: "blob",
                headers: {
                    "Content-Type": "application/json;charset=UTF-8",
                    "Access-Control-Allow-Origin": "*",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
            .then(function (response) {
                console.log(response);
                const url = URL.createObjectURL(
                    new Blob([response.data], {
                        type:
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    })
                );
                const link = document.createElement("a");
                link.href = url;
                let date = new Date();
                link.setAttribute(
                    "download",
                    name + "-" + date.toDateString() + ".xlsx"
                );
                document.body.appendChild(link);
                link.click();
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    $(".ch7_export").click(function (e) {
        let year = $("#ch7_y").val();
        let month = $("#ch7_mo").val();
        let day = $("#ch7_da").val();
        let image_id=0;
        if($("#cam1-tab" ).hasClass( "active" )){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }

        pushToTopLowHeatData(year, month, day, image_id);
    });
    function pushToTopLowHeatData(year, month, day, image_id) {
        let form_data = new FormData();
        form_data.append("usermodelbranchid", $('#usermodelbranchid').val());
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);
        form_data.append("image_id", image_id);

        axios
            .post(app_url + "/api/api/exports/heatmap_count", form_data, {
                responseType: "blob",
                headers: {
                    "Content-Type": "application/json;charset=UTF-8",
                    "Access-Control-Allow-Origin": "*",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
            .then(function (response) {
                console.log(response);
                const url = URL.createObjectURL(
                    new Blob([response.data], {
                        type:
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    })
                );
                const link = document.createElement("a");
                link.href = url;
                let date = new Date();
                link.setAttribute(
                    "download",
                    name + "-" + date.toDateString() + ".xlsx"
                );
                document.body.appendChild(link);
                link.click();
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    $(".ch3_export").click(function (e) {
        let year = $("#ch3_y").val();
        let month = $("#ch3_mo").val();
        let day = $("#ch3_da").val();
        let image_id=0;
        if($("#cam1-tab" ).hasClass( "active" )){
            image_id = $("input#mainimg1").val();
        }else{
            image_id = $("input#mainimg2").val();
        }
        pushToHeatData(year, month, day, image_id);
    });
    function pushToHeatData(year, month, day, image_id) {
        let form_data = new FormData();
        form_data.append("usermodelbranchid", $('#usermodelbranchid').val());
        form_data.append("year", year);
        form_data.append("month", month);
        form_data.append("day", day);
        form_data.append("image_id", image_id);

        axios
            .post(app_url + "/api/api/exports/heatmap_rate", form_data, {
                responseType: "blob",
                headers: {
                    "Content-Type": "application/json;charset=UTF-8",
                    "Access-Control-Allow-Origin": "*",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
            .then(function (response) {
                console.log(response);

                const url = URL.createObjectURL(
                    new Blob([response.data], {
                        type:
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    })
                );
                const link = document.createElement("a");
                link.href = url;
                let date = new Date();
                link.setAttribute(
                    "download",
                    name + "-" + date.toDateString() + ".xlsx"
                );
                document.body.appendChild(link);
                link.click();
            })
            .catch(function (error) {
                console.log(error);
            });
    }
});
