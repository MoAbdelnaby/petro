<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>

    <link rel="shortcut icon" href="{{url('/images')}}/Logo.svg"/>
    <!-- Bootstrap CSS -->
    @if(app()->getLocale() =='en')
        <link rel="stylesheet" href="{{resolveLang()}}/css/bootstrap.min.css">
    @else
        <link href="https://bootstrap.rtlcss.com/docs/4.4/dist/css/rtl/bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
    @endif
<!-- Typography CSS -->
    <link rel="stylesheet" href="{{resolveLang()}}/css/typography.css">
    <link rel="stylesheet" href="{{ asset("/asset_en/css/style.css") }}">
    <link rel="stylesheet" href="{{resolveLang()}}/css/style.css">
    <link rel="stylesheet" href="{{resolveLang()}}/css/responsive.css">
    <link rel="stylesheet" href="{{url('/css')}}/avatar.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{url('/')}}/assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{resolveLang()}}/css/view.css">

    @if(app()->getLocale() =='ar')
        <link href="https://bootstrap.rtlcss.com/docs/4.4/dist/css/rtl/bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="/gym/css/style-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{resolveDark()}}/css/style-rtl.css" rel="stylesheet" type="text/css"/>
    @endif

    @stack('css')

    <link rel="stylesheet" href=" {{url('/assets')}}/noty/noty.css ">
    <script src=" {{url('/assets')}}/noty/noty.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>





    <style>
        .treeItem{
            width: 350px;
            height: 135px;
            border: 1px solid #ccc;
            padding: 0 10px;
            border-radius: 5px;
            background: #1b075c;
            position: relative;
            margin-bottom: 20px;
        }
    
        .treeItem h4 {
            line-height: 40px;
            color: #fff;
            font-size: 18px;
            text-align: center;
            font-weight: bold;
        }
        .treeItem h4 span {
            display: block;
            font-size: 14px;
        }
        .treeItem h4 span i {
            font-size: 45px;
        }

        .odd-row .treeItem .AddNew {
            width: 60px;
            height: 60px;
            border: 3px solid #fff;
            display: block;
            position: absolute;
            top: 35px;
            right: -30px;
            z-index: 10;
            text-align: center;
            line-height: 60px;
            background: #fff;
            font-size: 32px;
            color: #ad2cca;
            transform: rotate(-45deg) rotateX(90deg);
            transition: all ease-in-out .4s;
            cursor: pointer;
        }
        .even-row .treeItem .AddNew {
            width: 60px;
            height: 60px;
            border: 3px solid #fff;
            display: block;
            position: absolute;
            top: 35px;
            left: -30px;
            z-index: 10;
            text-align: center;
            line-height: 60px;
            background: #fff;
            font-size: 32px;
            color: #ad2cca;
            transform: rotate(-45deg) rotateX(90deg);
            transition: all ease-in-out .4s;
            cursor: pointer;
        }
        .AddNew i {
            transition: all ease-in-out .4s;
            transform: rotate(135deg);
            border: 2px solid #fff;
            display: block;
            height: 100%;
            line-height: 50px;
        }
        .treeItem:hover .AddNew{
            transform: rotate(45deg) rotateX(0deg);
            transition: all ease-in-out .4s;

        }
        .treeItem:hover .AddNew i{
            transform: rotate(-45deg);
            transition: all ease-in-out .4s;
        }
        .odd-row .delete-item {
            border-radius: 34px;
            font-size: 14px;
            position: absolute;
            left: 10px;
            top: 10px;
            width: 37px;
            height: 37px;
            text-align: center;
            line-height: 34px;
            color: #fff;
            background: #8e0000;
            cursor: pointer;
            box-shadow: 0 0 5px #ffffff;
            display: none;
        }
        .even-row .delete-item {
            border-radius: 34px;
            font-size: 14px;
            position: absolute;
            right: 10px;
            top: 10px;
            width: 37px;
            height: 37px;
            text-align: center;
            line-height: 34px;
            color: #fff;
            background: #8e0000;
            cursor: pointer;
            box-shadow: 0 0 5px #ffffff;
            display: none;
        }
        .treeItem:hover .delete-item{
            display: block;
        }
        .odd-row .treeItem:after {
            content: "";
            width: 40px;
            height: 40px;
            position: absolute;
            display: block;
            z-index: 1;
            background: #1b075c;
            top: 47px;
            right: -21px;
            border: 1px solid #fff;
            transform: rotate(45deg);
        }

        .even-row .treeItem:after {
            content: "";
            width: 40px;
            height: 40px;
            position: absolute;
            display: block;
            z-index: 1;
            background: #1b075c;
            top: 47px;
            left: -21px;
            border: 1px solid #fff;
            transform: rotate(45deg);
        }
        .pr-100px{
            padding-right: 100px;
        }
        .endRowTree{
            width: 145px;
            position: relative;
        }
        .endRowTree .endrowItem {
            content: '';
            width: 100%;
            height: 290px;
            border: 1px solid #ccc;
            padding: 0 10px;
            background: #1b075c;
            position: absolute;
            border-radius: 0 145px 145px 0;
        }
        .endRowTree:nth-child(1) .endrowItem {
            border-radius: 145px 0 0 145px;
            /* margin-top: 155px; */
        }
        .endRowTree .endrowItem::after {
            content: '';
            width: 20px;
            height: 22px;
            background: #fff;
            z-index: 11;
            display: block;
            border-radius: 50%;
            position: absolute;
            top: 133px;
            left: -10px;
        }
        .endRowTree:nth-child(1) .endrowItem::after {
            content: '';
            width: 20px;
            height: 22px;
            background: #fff;
            z-index: 11;
            display: block;
            border-radius: 50%;
            position: absolute;
            top: 133px;
            right: -10px;
            left: auto
        }
        .treeItems .row.col-12{
            /* margin-top: -135px!important; */
        }
        .treeItems .row.col-12:first-child{
            margin-top: 0!important;
        }
        .even-row{
            direction: rtl;
        }

        .treeItem select {
            word-wrap: normal;
            background: none;
            color: #fff;
            border: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .treeItem select option{
            color: #1b075c
        }
        .treeItem select option::selection{
            background-color: #1b075c;
        }
        .treeItem:first-child:hover .delete-item{
            display: none;
        }
        #SaveChanges{
            display: inline-block;
            line-height: 40px;
            padding: 0 15px;
            background: #1b075c;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>
</head>
<body class="sidebar-main " data-mode="{{session()->has('darkMode') ? 'dark' : ''}}">

@include('layouts.dashboard.partials._page-loader')

@include('layouts.dashboard.layout')

<script>var app_url = "{{url('/')}}";</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{resolveLang()}}/js/jquery.min.js"></script>
<script src="{{url('/js')}}/jquery.validate.min.js"></script>
<script src="{{resolveLang()}}/js/popper.min.js"></script>
<script src="{{resolveLang()}}/js/bootstrap.min.js"></script>
<!-- Appear JavaScript -->
<script src="{{resolveLang()}}/js/jquery.appear.js"></script>
<!-- Countdown JavaScript -->
<script src="{{resolveLang()}}/js/countdown.min.js"></script>
<!-- Counterup JavaScript -->
<script src="{{resolveLang()}}/js/waypoints.min.js"></script>
<script src="{{resolveLang()}}/js/jquery.counterup.min.js"></script>
<!-- Wow JavaScript -->
<script src="{{resolveLang()}}/js/wow.min.js"></script>
<!-- Apexcharts JavaScript -->
<script src="{{resolveLang()}}/js/apexcharts.js"></script>
<!-- Slick JavaScript -->
<script src="{{resolveLang()}}/js/slick.min.js"></script>
<!-- Select2 JavaScript -->
<script src="{{resolveLang()}}/js/select2.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="{{resolveLang()}}/js/owl.carousel.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="{{resolveLang()}}/js/jquery.magnific-popup.min.js"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="{{resolveLang()}}/js/smooth-scrollbar.js"></script>
<!-- lottie JavaScript -->
<script src="{{resolveLang()}}/js/lottie.js"></script>
<!-- Chart Custom JavaScript -->
<script src="{{resolveLang()}}/js/chart-custom.js"></script>
<!-- Custom JavaScript -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>

<script src="{{resolveLang()}}/js/custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
        crossorigin="anonymous"></script>
<script src="{{url('/js')}}/scripts.js"></script>
<script src="{{url('/js')}}/avatar.js"></script>
<script src="{{resolveDark()}}/js/mdb.min.js"></script>

<!-- amcharts scripts -->
<script src="{{ asset('chartjs/amcharts4/core.js') }}"></script>
<script src="{{ asset('chartjs/amcharts4/charts.js') }}"></script>
<script src="{{ asset('chartjs/amcharts4/animated.js') }}"></script>

<script src="{{ asset('chartjs/heatmap.js') }}"></script>
<script src="{{ asset('assets/js/gauge.min.js') }}"></script>

<script src="{{ asset('js/custom.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
        integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>


    var mode = "{{session()->has('darkMode')}}";

    if (mode == 1) {
        var chart1Colrs = ["#68a8c7", "#68a153"];
        var chart2Colrs = ["#68a8c7", "#68a153"];
        var chart3Colrs = ["#68a8c7", "#68a153"];
        var chart4Colrs = ["#68a8c7", "#68a153"];
        var chart5Colrs = ["#68a8c7", "#68a153"];
        var chart6Colrs = ["#68a8c7", "#68a153"];
        var chart7Colrs = ["#68a8c7", "#68a153"];
        var chart8Colrs = ["#68a8c7", "#68a153"];
    } else {
        var chart1Colrs = ["#1a739f", "#348117"];
        var chart2Colrs = ["#1a739f", "#348117"];
        var chart3Colrs = ["#1a739f", "#348117"];
        var chart4Colrs = ["#1a739f", "#348117"];
        var chart5Colrs = ["#1a739f", "#348117"];
        var chart6Colrs = ["#1a739f", "#348117"];
        var chart7Colrs = ["#1a739f", "#348117"];
        var chart8Colrs = ["#1a739f", "#348117"];

    }

    var app_url = "{{url('/')}}";
    $(document).ready(function () {
        $(".digitsSpan").delegate('p.removeSpan', 'click', function () {
            $(this).parent('span').remove();
        });
        // data table function any div has class="dataTable"
        var PrevP = "{{ __('app.PrevP') }}";
        var NextP = "{{ __('app.NextP') }}";
        $('.dataTable').dataTable({
            language: {
                paginate: {
                    "previous": PrevP,
                    "Next": NextP,
                }
            },
            "bLengthChange" : false,
        });

        // toggle icon menu
        $('.wrapper-menu').click(function () {
            $(this).find('i').toggle();
        });

        // set width div scroll vertical
        var countScrollDiv = $('.scroll-vertical-custom-div').length;
        for (var d = 0; d < countScrollDiv; d++) {
            var parentDiv = $($('.scroll-vertical-custom-div')[d]);
            var lis = $(parentDiv).find('li');
            var width = 0;
            for (var a = 0; a < lis.length; a++) {
                width += parseInt($($(lis)[a]).innerWidth() + 10);
            }
            parentDiv.width(width + lis.length + 'px');
        }
        // $('.scroll-vertical-custom-div').width(function () {
        //     var cou = $(this).find('li').length;
        //     var wi = $(this).find('li').width();
        //     console.log((cou * wi + 30) + "px");
        //     return ((cou * (wi + 50)) + "px");
        // });
        // show branches in small popup
        $('.showbranchesAll').click(function () {
            $(this).parent('h5').find('.branchesAll').toggle();
            $(this).find('i').toggleClass('fa-times-circle fa-info');
        });
        // close branches in small popup
        $('.closebranchesAll').click(function () {
            $(this).closest('.branchesAll').toggle();
            $(this).closest('.product-miniature').find('.showbranchesAll i').toggleClass('fa-times-circle fa-info');
        });
        // change viwe [ small columns ]
        $('.fa-th').click(function () {
            $('.related-product-block').removeClass('large');
            $(this).addClass('active').siblings().removeClass('active');
            $('.related-product-block .product_item').addClass('col-lg-3').removeClass('col-lg-6');
            $('.product_list').show();
            $('.product_table').hide();
            loadding();

        });
        // change viwe [ large columns ]
        $('.fa-th-large').click(function () {
            $('.related-product-block').addClass('large');
            $('.related-product-block .product_item').addClass('col-lg-6').removeClass('col-lg-3');
            $(this).addClass('active').siblings().removeClass('active');

            $('.product_list').show();
            $('.product_table').hide();
            loadding();
        });
        // change viwe [ table ]
        $('.fa-table').click(function () {
            $('.related-product-block').addClass('table').removeClass('large');
            $('.product_list').hide();
            $('.product_table').show();
            $(this).addClass('active').siblings().removeClass('active');
            loadding();
        });

        // loading function to change viwe [ columns, table]
        function loadding() {
            $('.related-product-block').append('<div class="loading-view"><span></span></div>');
            setTimeout(function () {
                $('.loading-view').fadeOut();
                setTimeout(function () {
                    $('.loading-view').remove();
                }, 500);
            }, 1000);
        };

        // close alert [ 'Success' , 'error' ]
        $('.alert-head i').click(function () {
            $(this).parents('.alert').fadeOut();
            setTimeout(function () {
                $('.alert').remove();
            }, 500);
        });
        // close alert by set time out function limit 4 sec
        setTimeout(function () {
            $('.alert').fadeOut();
            setTimeout(function () {
                $('.alert').remove();
            }, 500);
        }, 4000);

        // go to back button in pages [ create, edit ]
        $('.back').click(function () {
            goBack();
        });

        function goBack() {
            window.history.back();
        }


        // .digits events
        $('.digits label i.fa-plus-square').on('click', function () {
            console.log("0000")
            var digitsInputs = $(this).closest('.digits').find('.digitsSpan .digit');
            // console.log(digitsInputs.length)
            if (digitsInputs.length < 4) {
                $(this).closest('.digits').find('.digitsSpan').append("<span><input class='digit' maxlength='1' minlength='1'><p class='removeSpan'><i class='fas fa-minus-square'></i></p></span>");
            } else {
                $(this).hide();
            }
        });
        // treeItems
        let positions = @json($positions); 

        var escalations=[];
        escalations= [
            {position: 0,time: 60}
        ];
   
        function drowTree(escalations){
            $('.row.col .row.col-12').remove();
            let countRows1 = escalations.length/4;
            var i;
            // console.log(Math.ceil(countRows1));
            for(var r=1;r <= Math.ceil(countRows1); r++){
                if(r % 2 == 0){
                    var clas = "even-row";
                }
                else{
                    var clas = "odd-row";
                }

                $('.row.col').append(`<div class="col-12 `+ clas +` row p-0 m-0 2020"></div>`);
            }
            for(var i=1;i <= escalations.length; i++){
                var ItemHtml = `<div data-array="`+(i-1)+`" class="treeItem col-3">`+
                    `<span class="delete-item">`+
                        `<i class="fa fa-trash"></i>`+
                    `</span>`+
                    `<h4>`+
                        `<select class="position" name="" id="">`;
                           for (let j = 0; j < positions.length; j++) {
                               ItemHtml += `<option `+ (escalations[i-1].position == positions[j].id ? 'selected' : ''  ) +` value="`+ positions[j].id +`">`+ positions[j].name +`</option>`;
                           } ;
                            
                ItemHtml +=
                        `</select>`+
                        `<span class="time">`+
                            `<i class="fa fa-stopwatch"></i>`+
                            `<span>`+
                                `<select class="min" name="" id="">`+
                                    `<option `+ (escalations[i-1].time == 15 ? 'selected':'') + ` value="15">15 Min</option>`+
                                    `<option `+ (escalations[i-1].time == 30 ? 'selected':'') + ` value="30">30 Min</option>`+
                                    `<option `+ (escalations[i-1].time == 60 ? 'selected':'') + ` value="60">1 hour</option>`+
                                    `<option `+ (escalations[i-1].time == 90 ? 'selected':'') + ` value="90">Hour & half</option>`+
                                    `<option `+ (escalations[i-1].time == 120 ? 'selected':'') + ` value="120">2 Hours</option>`+
                                `</select>`+
                            `</span>`+
                        `</span>`+
                    `</h4>`+
                    `<span class="AddNew">`+
                        `<i class="fa fa-layer-plus"></i>`+
                    `</span>`+
                `</div>`;
                $('.row.col .row.col-12:nth-child('+Math.ceil(i/4)+')').append(ItemHtml);
            }

        }
        drowTree(escalations);
          // remove item 
          $('.row.col').delegate('.delete-item','click',function(){
            var index = $(this).parents('.treeItem').attr('data-array');
             escalations.splice(index);
            drowEndRow(escalations);
        });

        // AddNew item 
        $('.row.col').delegate('.AddNew','click',function(){
            escalations.push({position:0, time:60});
            drowEndRow(escalations);
            console.log(escalations);

            drowTree(escalations);
        });
        // console.log(escalations.slice(1));
        $('.treeItems').delegate('.treeItem select.position', 'change', function(){
            let index = $(this).parents('.treeItem').attr('data-array');
            escalations[index].position = $(this).val();
            drowTree(escalations);
        });
        $('.treeItems').delegate('.treeItem select.min', 'change', function(){
            let index = $(this).parents('.treeItem').attr('data-array');
            escalations[index].time = $(this).val();
            console.log(escalations);
            drowTree(escalations);
        });



        function drowEndRow(escalations){
            let countRows1 = escalations.length / 4;
            if(escalations.length % 4 == 0){
                for(let r=1;r <= Math.ceil(countRows1); r++){
                if(r % 2 == 0){
                    $('.endRowTree.left').append('<div class="endrowItem" style="top:'+((r-1)*155)+'px"></div>');
                }
                else{
                   $('.endRowTree.right').append('<div class="endrowItem" style="top:'+((r-1)*155)+'px"></div>');
                }

            }
            }
            
        }




    });


    // $(window).load(function(){
    //     console.log("loades")
    //     setTimeout(function (){
    //
    //         document.body.innerHTML = document.body.innerHTML.replace('ALAMAL', 'الامل');
    //
    //     },1000);
    // });


</script>

@yield('scripts')
@stack('js')

</body>

<!-- end::Body -->
</html>
