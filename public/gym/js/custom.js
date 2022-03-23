"use strict";

jQuery(document).ready(function () {
    $(".toast").toast("show");
    store();

    var wind = $(window),
        sticky = $(".model.nav-pills"),
        stickyOffset = $(".model.nav-pills").offset().top;

    wind.on("scroll", function () {
        var scroll = wind.scrollTop();
        if (scroll < stickyOffset) {
            sticky.removeClass("nav-fixed");
        } else {
            sticky.addClass("nav-fixed");
        }
    });

    // var chartsHeight = $('.charts-sec > .row').height() +'px';
    // $(".charts-sec").css("height", chartsHeight);
    //
    // $( window ).resize(function() {
    //     var chartsHeight = $('.charts-sec > .row').height() +'px';
    //     $(".charts-sec").css("height", chartsHeight);
    // });

    $(".area-section.slider").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
        nextArrow:
            '<span class="arrow-prev"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><g id="arrow-next" transform="translate(-1775 -1632)"><g id="Ellipse_936" data-name="Ellipse 936" transform="translate(1776 1633)" fill="#fff" stroke="#707070" stroke-width="1"><circle cx="17" cy="17" r="17" stroke="none"/><circle cx="17" cy="17" r="16.5" fill="none"/></g><g id="arrow-right-circle-fill" transform="translate(1775 1632)"><path id="Path_49673" data-name="Path 49673" d="M36,18A18,18,0,1,1,18,0,18,18,0,0,1,36,18ZM17.2,23.954A1.126,1.126,0,1,0,18.8,25.547l6.75-6.75a1.125,1.125,0,0,0,0-1.593l-6.75-6.75A1.126,1.126,0,1,0,17.2,12.047l4.83,4.828H11.25a1.125,1.125,0,0,0,0,2.25H22.034L17.2,23.954Z" fill="#11044c" fill-rule="evenodd"/></g></g></svg></span>',
        prevArrow:
            '<span class="arrow-next"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><g id="arrow-next" transform="translate(-1775 -1632)"><g id="Ellipse_936" data-name="Ellipse 936" transform="translate(1776 1633)" fill="#fff" stroke="#707070" stroke-width="1"><circle cx="17" cy="17" r="17" stroke="none"/><circle cx="17" cy="17" r="16.5" fill="none"/></g><g id="arrow-right-circle-fill" transform="translate(1775 1632)"><path id="Path_49673" data-name="Path 49673" d="M36,18A18,18,0,1,1,18,0,18,18,0,0,1,36,18ZM17.2,23.954A1.126,1.126,0,1,0,18.8,25.547l6.75-6.75a1.125,1.125,0,0,0,0-1.593l-6.75-6.75A1.126,1.126,0,1,0,17.2,12.047l4.83,4.828H11.25a1.125,1.125,0,0,0,0,2.25H22.034L17.2,23.954Z" fill="#11044c" fill-rule="evenodd"/></g></g></svg></span>',
        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    $(".show-image-icon-sho, .setting-icon-sho ").on("click", function () {
        $(".area-section.slider").slick("refresh");
        cr = true;
    });
});
var cr = false;

function store() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#logout").on("click", function (e) {
        $("#logout")
            .children()
            .bind("click", function () {
                return false;
            });
        document.getElementById("logout-form").submit();
    });

    $(".export").on("click", function (e) {
        $("input[name=submittype]").val(2);
        $("#doorform").submit();
    });
    $("#searchRecord").on("click", function (e) {
        $("input[name=submittype]").val(1);
        $("#doorform").submit();
    });

    $("#notifytime").hide();
    if ($("#notification").is(":checked")) {
        $("#notifytime").show();
    } else {
        $("#notifytime").hide();
    }

    $("#notification").on("change", function (e) {
        e.stopPropagation();
        if ($("#notification").is(":checked")) {
            $("#notifytime").show();
            setScreenHeight();
        } else {
            $("#notifytime").hide();
            setScreenHeight();
        }
    });

    function setScreenHeight(e) {
        var height =
            $(".setting").height() -
            $(".header .tab-content .screenshoot .card h6").height() -
            65;
        if ($("#myTabJust").length != 0) {
            height = height - $("#myTabJust").height();
        }
        $(".screenshoot-content").height(height);
        $(".screenshoot-content-door").height(height);
        console.log(height);
    }

    setScreenHeight();

    $(".setting").on("click", function () {
        setScreenHeight();
    });
}

//  toggle search
$(".search-cont").on("show.bs.dropdown", function (event) {
    $(".search_branch-ul").addClass("seacrh-open");
    $(this).find("[autofocus]").focus();
});
$(".search-cont").on("shown.bs.dropdown", function (event) {
    $(this).find("[autofocus]").focus();
});
$(".search-cont").on("hide.bs.dropdown", function (event) {
    $(".search_branch-ul").removeClass("seacrh-open");
});
//  search in branhc
let branchesElm = document.querySelectorAll(
    "#li-branches .nav-item:not(.no_data)"
);
document
    .querySelector("#branch_search")
    .addEventListener("keyup", function (e) {
        let filterText = e.target.value;
        let filterReg = new RegExp(filterText, "i");
        let flag = 0;
        $("#li-branches .no_data").addClass("hide");
        branchesElm.forEach((elm) => {
            if (elm.dataset.bname.trim().match(filterReg)) {
                elm.style.display = "inline-block";
                elm.classList.remove("hidden")
                flag++;
            } else {
                elm.style.display = "none";
                elm.classList.add("hidden")
            }
        });
        if (!flag) {
            $("#li-branches .no_data").removeClass("hide");
        }
    });

function slickCarouselCardEvents(fn) {
    $(".setting-card-cont .custom-dropdown").on("click", function (e) {

        if (!e.target.classList.contains("close-1")) e.stopPropagation();
    });
    $(".custom-dropdown input[type=radio]").click(function (e) {
        e.preventDefault;
        e.stopPropagation;
        let btn_id = e.target.dataset.key;
        $(`.div-hours-btn-${btn_id}`).each(function () {
            if ($(this).css("display") == "none") {
                $(this).show();
                $(`.div-minutes-btn-${btn_id}`).hide();
            } else {
                $(this).hide();
                $(`.div-minutes-btn-${btn_id}`).show();
            }
        });
    });

    $(".filter_date").on("change", fn);
}

function reviewPdf(plate, itemid, e) {
    e.preventDefault();
    e.stopPropagation();
    var plateNumber = plate;
    var carprofile_id = itemid;
    $.ajax({
        url: `${app_url}/api/invoices/download`,
        method: "POST",
        data: {
            plateNumber: plateNumber,
            carprofile_id: carprofile_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            var tmpLink = document.createElement('a');
            tmpLink.download = response.name; // set the name of the download file
            tmpLink.href = response.invoice;
            // temporarily add link to body and initiate the download
            document.body.appendChild(tmpLink);
            $(tmpLink).attr('target', '_plank')
            tmpLink.click();
            document.body.removeChild(tmpLink);

            // Toast.fire({
            //     icon: 'success',
            //     title: 'file downloaded successfully'
            // })
        },
        error: function (data) {
            var message = data.responseJSON.message;

            Toast.fire({
                icon: 'error',
                title: message
            })
        }

    });
}
