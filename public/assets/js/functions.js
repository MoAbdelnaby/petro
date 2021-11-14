//Loading
$(window).on("load", function () {
    $(".loader-effect").fadeOut();
    $("#layout-loading").delay(150).fadeOut("slow");
});

$(document).on("click", function (e) {
    if ($(e.target).closest(".user-identify").length === 0) {
        $(".user-identify ul").removeClass("open");
    }
});

$(document).ready(function () {
    "use strict";

    /*-----------------------------
		HEADER FIXED JS
	-------------------------------*/
    var wind = $(window);
    var sticky = $(".navigation");
    wind.on("scroll", function () {
        var scroll = wind.scrollTop();
        if (scroll < 1) {
            sticky.removeClass("nav-fixed");
        } else {
            sticky.addClass("nav-fixed");
        }
    });

    $(".navbar-collapse a").on("click", function () {
        $(".navbar-collapse").collapse("hide");
        $(".hamburger").removeClass("is-active collapsed");
    });

    /* Toggle menu button*/
    $(".hamburger").on("click", function () {
        $(this).toggleClass("is-active", "fast");
    });

    $(document).on("click", ".to-home", function (e) {
        if ($(".user-identify ul").hasClass("open")) {
            $(".content-body").removeClass("active");
            $(".user-identify ul").removeClass("open");
        }
    });

    $(".user-identify-cont").click(function () {
        $(this).next().toggleClass("open");
    });

    $(".button.r").on("click", function (e) {
        if ($("#ch3_y").val() != "none") {
            $("#heatmapContainer span").toggleClass("show");
        }
    });
});
