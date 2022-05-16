<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}">

<!-- Mirrored from seantheme.com/hud/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 13 Mar 2022 12:22:56 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>

    <link rel="shortcut icon" href="{{url('/images')}}/petromin.png"/>
    <!-- Bootstrap CSS -->
    {{-- @if(app()->getLocale() =='en')
        <link rel="stylesheet" href="{{resolveLang()}}/css/bootstrap.min.css">
    @else
        <link href="https://bootstrap.rtlcss.com/docs/4.4/dist/css/rtl/bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
    @endif --}}


    <link href="{{ asset('/themed/hud/assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/themed/hud/assets/css/app.min.css') }}" rel="stylesheet" />


    <link href="{{ asset('/themed/hud/assets/plugins/jvectormap-next/jquery-jvectormap.css') }}" rel="stylesheet" />


    @stack('css')



</head>

<body data-mode="{{session()->has('darkMode') ? 'dark' : ''}}">
    <div id="app" class="app">

            @include('themes.hud.layouts.dashboard.layout')

    </div>




<script data-cfasync="false" src="{{ asset('/themed/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
    <script src="{{ asset('/themed/hud/assets/js/vendor.min.js') }}" type="283841832c82ceaf15000b90-text/javascript"></script>
    <script src="{{ asset('/themed/hud/assets/js/app.min.js') }}" type="283841832c82ceaf15000b90-text/javascript"></script>


    <script src="{{ asset('/themed/hud/assets/plugins/jvectormap-next/jquery-jvectormap.min.js') }}" type="283841832c82ceaf15000b90-text/javascript"></script>
    <script src="{{ asset('/themed/hud/assets/plugins/jvectormap-content/world-mill.js') }}" type="283841832c82ceaf15000b90-text/javascript"></script>
    <script src="{{ asset('/themed/hud/assets/plugins/apexcharts/dist/apexcharts.min.js') }}" type="283841832c82ceaf15000b90-text/javascript"></script>
    <script src="{{ asset('/themed/hud/assets/js/demo/dashboard.demo.js') }}" type="283841832c82ceaf15000b90-text/javascript"></script>
    @stack('js')

    <script src="{{ asset('/themed/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}" data-cf-settings="283841832c82ceaf15000b90-|49" defer=""></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194" integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw==" data-cf-beacon='{"rayId":"6eb4bd1daf3c59fb","version":"2021.12.0","r":1,"token":"4db8c6ef997743fda032d4f73cfeff63","si":100}'
        crossorigin="anonymous"></script>
        <script type="283841832c82ceaf15000b90-text/javascript">
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '../../www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-53034621-1', 'auto');
            ga('send', 'pageview');
        </script>
</body>

<!-- Mirrored from seantheme.com/hud/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 13 Mar 2022 12:23:21 GMT -->

</html>
