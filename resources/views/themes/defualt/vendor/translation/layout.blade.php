<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="{{session()->has('darkMode') ?'ltr':(str_replace('_', '-', app()->getLocale())=='ar'?'rtl':'ltr')}}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>

    <link rel="shortcut icon" href="{{url('/images')}}/Logo.svg" />


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{resolveLang()}}/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="{{resolveLang()}}/css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{resolveLang()}}/css/style.css">
    <link rel="stylesheet" href="{{resolveLang()}}/css/view.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{resolveLang()}}/css/responsive.css">
{{--    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>--}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css"/>

    <link rel="stylesheet" href="{{url('/css')}}/avatar.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    @if(app()->getLocale()=='ar')

{{--    <link rel="stylesheet" href="{{ asset('/asset_ar/css/style.css') }}">--}}
{{--        <link href="{{resolveDark()}}/css/style-rtl.css" rel="stylesheet" type="text/css"/>--}}
{{--    <link rel="stylesheet" href="{{ asset('/asset_dark/css/style.css') }}">--}}
        <link href="/gym/css/style-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{resolveDark()}}/css/style-rtl.css" rel="stylesheet" type="text/css"/>
    @endif

    <style>

        .navdark {
            display: flex;
            justify-content: flex-end;
            padding: 20px 0;
        }
        .whitetext {
            color: white !important;
            background-color: transparent !important;
        }
        .whiteback {
            background-color: white !important;
        }
        /*slider switch css */
        .theme-switch-wrapper {
            display: flex;
            align-items: center;
        }
        em {
            margin-right: 10px;
            font-size: 1rem;
            color: #11044c;
        }

        .theme-switch {
            display: inline-block;
            height: 34px;
            position: relative;
            width: 60px;
        }

        .theme-switch input {
            display:none;
        }

        .slider {
            background-color: #d1d1d1;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 3px;
            transition: .4s;
        }

        .slider:before {
            background-color: #fff;
            bottom: 2px;
            content: "";
            height: 26px;
            left: 4px;
            border-radius: 50px;
            position: absolute;
            transition: .4s;
            width: 26px;
        }

        input:checked + .slider {
            background-color: #11044c;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            height: 30px;
            border-radius: 34px;
        }
        .flex textarea{
            display: none;
        }

        .flex textarea.active{
            display: block
        }
        .flex svg{
            width: 20px;
            float: left;
        }
        .select-group .caret {
            display: none!important;
        }
        input,
        select{
            width: 100%;
            height: 40px;
            padding: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /*.filter .search{*/
        /*    width: 50%;*/
        /*    float: left;*/
        /*    padding: 0 15px;*/
        /*}*/
        /*.filter .select-group{*/
        /*    width: 25%;*/
        /*    float: left;*/
        /*    padding: 0 15px;*/
        /*}*/
        /*.filter .col-3{*/
        /*     width: 25%;*/
        /*     float: left;*/
        /*     padding: 0 15px;*/
        /* }*/
        /*.filter .col-3 .select-group{*/
        /*    width: 100%;*/
        /*}*/
        .input-group{
            margin-bottom: 15px;
        }
        .showAdvancedOptions {
            display: block;
            width: 100%;
        }

        .creatLanguage  .input-group button.text-blue {
            width: 100%;
            height: 40px;
            padding: 0;
            margin-top: 30px;
            background: #2196f3;
            color: #fff;
            border: 0;
            border-radius: 5px;
        }
        .error-text{
            color: #ca0416;
            font-size: 80%;
        }
        .creatLanguage input.error {
            border: 1px solid #ca0416;
            color: #ca0416;
            background: #ffeaed;
        }
        .creatLanguage input.error::placeholder{
            color: #e75461;
        }
        .table .flex{
            cursor: pointer;
        }
        .flex textarea {
            width: 100%;
            background: #4caf5021;
        }
        .fill-current.text-green{
            fill: #12ae07;
        }
    </style>
    @stack('css')
    {{--noty--}}

    <link rel="stylesheet" href=" {{url('/assets')}}/noty/noty.css ">
    <script src=" {{url('/assets')}}/noty/noty.min.js "></script>
</head>
<body>

<!-- Wrapper Start -->
<div class="wrapper" id="app">
    @include('translation::notifications')
    @include('layouts.dashboard.partials._aside.base')

    @include('layouts.dashboard.partials._header.base')

    @yield('body')




</div>
@include('layouts.dashboard.partials._footer.base')


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
<script src="{{url('/js')}}/scripts.js"></script>
<script src="{{url('/js')}}/avatar.js"></script>
<script src="{{url('/js')}}/custom.js"></script>
<script src="{{resolveDark()}}/js/mdb.min.js"></script>

<script>
    var app_url = "{{url('/')}}";
    $(document).ready(function (){


        // toggle icon menu
        $('.wrapper-menu').click(function (){
            $(this).find('i').toggle();
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

        $('.table .flex').click(function (){
            $(this).find('textarea').focus();
            $(this).parent('td').find('span').hide();
        });
        $('.table .flex textarea').keyup(function (){
            $(this).closest('td').find('span').html($(this).val());
        });
        $('.table .flex textarea').focusout(function (){
            $(this).closest('td').find('span').show();
        });
    });
</script>
<!--begin::Page Scripts(used by this page) -->
@stack('js')

@yield('scripts')
<!--end::Page Scripts -->

<script src="{{ asset('/vendor/translation/js/app.js') }}"></script>
</body>
</html>
