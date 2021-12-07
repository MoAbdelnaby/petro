<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>

    <link rel="shortcut icon" href="{{url('/images')}}/Logo.svg" />
    <!-- Bootstrap CSS -->
    @if(app()->getLocale() =='en')
        <link rel="stylesheet" href="{{resolveLang()}}/css/bootstrap.min.css">
    @else
        <link href="https://bootstrap.rtlcss.com/docs/4.4/dist/css/rtl/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    @endif
<!-- Typography CSS -->
    <link rel="stylesheet" href="{{resolveLang()}}/css/typography.css">
    <link rel="stylesheet" href="{{resolveLang()}}/css/style.css">
    <link rel="stylesheet" href="{{resolveLang()}}/css/responsive.css">
    <link rel="stylesheet" href="{{url('/css')}}/avatar.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{resolveLang()}}/css/view.css">

    @if(app()->getLocale() =='ar')
        <link href="https://bootstrap.rtlcss.com/docs/4.4/dist/css/rtl/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/gym/css/style-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{resolveDark()}}/css/style-rtl.css" rel="stylesheet" type="text/css"/>
    @endif

    @stack('css')

    <link rel="stylesheet" href=" {{url('/assets')}}/noty/noty.css ">
    <script src=" {{url('/assets')}}/noty/noty.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body class="sidebar-main">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var app_url = "{{url('/')}}";
    $(document).ready(function (){
        // data table function any div has class="dataTable"
        var PrevP= "{{ __('app.PrevP') }}";
        var NextP= "{{ __('app.NextP') }}";
        $('.dataTable').dataTable( {
            "language": {
                "paginate": {
                    "previous": PrevP,
                    "Next": NextP,
                }
            }
        } );

        // toggle icon menu
        $('.wrapper-menu').click(function (){
            $(this).find('i').toggle();
        });

        // set width div scroll vertical
        var countScrollDiv = $('.scroll-vertical-custom-div').length;
        for (var d=0;d<countScrollDiv;d++){
            var parentDiv = $($('.scroll-vertical-custom-div')[d]);
            var lis = $(parentDiv).find('li');
            var width=0;
            for (var a=0; a< lis.length;a++){
                width += parseInt($($(lis)[a]).innerWidth()+10);
            }
            parentDiv.width(width+lis.length+'px');
        }
        // $('.scroll-vertical-custom-div').width(function () {
        //     var cou = $(this).find('li').length;
        //     var wi = $(this).find('li').width();
        //     console.log((cou * wi + 30) + "px");
        //     return ((cou * (wi + 50)) + "px");
        // });
        // show branches in small popup
        $('.showbranchesAll').click(function(){
            $(this).parent('h5').find('.branchesAll').toggle();
            $(this).find('i').toggleClass('fa-times-circle fa-info');
        });
        // close branches in small popup
        $('.closebranchesAll').click(function(){
            $(this).closest('.branchesAll').toggle();
            $(this).closest('.product-miniature').find('.showbranchesAll i').toggleClass('fa-times-circle fa-info');
        });
        // change viwe [ small columns ]
        $('.fa-th').click(function (){
            $('.related-product-block').removeClass('large');
            $(this).addClass('active').siblings().removeClass('active');
            $('.related-product-block .product_item').addClass('col-lg-3').removeClass('col-lg-6');
            $('.product_list').show();
            $('.product_table').hide();
            loadding();

        });
        // change viwe [ large columns ]
        $('.fa-th-large').click(function (){
            $('.related-product-block').addClass('large');
            $('.related-product-block .product_item').addClass('col-lg-6').removeClass('col-lg-3');
            $(this).addClass('active').siblings().removeClass('active');

            $('.product_list').show();
            $('.product_table').hide();
            loadding();
        });
        // change viwe [ table ]
        $('.fa-table').click(function (){
            $('.related-product-block').addClass('table').removeClass('large');
            $('.product_list').hide();
            $('.product_table').show();
            $(this).addClass('active').siblings().removeClass('active');
            loadding();
        });

        // loading function to change viwe [ columns, table]
        function loadding(){
            $('.related-product-block').append('<div class="loading-view"><span></span></div>');
            setTimeout(function (){
                $('.loading-view').fadeOut();
                setTimeout(function (){
                    $('.loading-view').remove();
                }, 500);
            },1000);
        };

        // close alert [ 'Success' , 'error' ]
        $('.alert-head i').click(function (){
            $(this).parents('.alert').fadeOut();
            setTimeout(function (){
                $('.alert').remove();
            },500);
        });
        // close alert by set time out function limit 4 sec
        setTimeout(function (){
            $('.alert').fadeOut();
            setTimeout(function (){
                $('.alert').remove();
            },500);
        }, 4000);

        // go to back button in pages [ create, edit ]
        $('.back').click(function (){
            goBack();
        });
        function goBack() {
            window.history.back();
        }

    });
</script>

@yield('scripts')
@stack('js')
</body>

<!-- end::Body -->
</html>
