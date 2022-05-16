<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>

    <link rel="shortcut icon" href="{{url('/images')}}/petromin.png" />
    <!-- Bootstrap CSS -->
    @if(app()->getLocale() =='en')
        <link rel="stylesheet" href="{{resolveLang()}}/css/bootstrap.min.css">
    @else
        <link href="https://bootstrap.rtlcss.com/docs/4.4/dist/css/rtl/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    @endif

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    @stack('css')
</head>
<body class="sidebar-main">
@include('layouts.dashboard.partials._page-loader')

@yield('content')


<script>var app_url = "{{url('/')}}";</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{resolveLang()}}/js/jquery.min.js"></script>
<script src="{{url('/js')}}/jquery.validate.min.js"></script>
<script src="{{resolveLang()}}/js/popper.min.js"></script>
<script src="{{resolveLang()}}/js/bootstrap.min.js"></script>
<!-- Appear JavaScript -->
<script src="{{resolveLang()}}/js/jquery.appear.js"></script>
<script src="{{ asset('assets/js/gauge.min.js') }}"></script>



@yield('scripts')
@stack('js')
</body>

<!-- end::Body -->
</html>
