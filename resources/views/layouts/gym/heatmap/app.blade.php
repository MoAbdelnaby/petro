<!DOCTYPE html>
<html lang="">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.gym.dashboard'))</title>
    <meta name="description" content="Latest updates and statistic charts">
   <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- cairo font CSS-->
  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="{{resolveDark()}}/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
{{--    <link href="{{resolveDark()}}/css/mdb.min.css" rel="stylesheet" type="text/css"/>--}}
    <link href="{{resolveDark()}}/css/style.css" rel="stylesheet" type="text/css"/>

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('assets/roots/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet/less" href="{{ asset('assets/css/styles.less') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />






  @stack('css')

  <style>
    body,
    html {
      margin: 0;
      padding: 0;

    }

    #heatmapContainerWrapper {
      width: 1024px;
      height: 576px;
      margin: auto;
      background: rgba(0, 0, 0, .1);
    }

    #heatmapContainer {
      width: 100%;
      height: 100%;
    }



     .content-body {
         position: fixed;
         z-index: 9999;
         top: -101%;
         left: 0%;
         width: 100%;
         height: 100%;
         overflow: hidden;
         background: #15202B;
         color: white;
         transition: 0.2s;
     }
  </style>
  <script src="{{ asset('assets/build/heatmap.js') }}"></script>


</head>

<body>
  <!-- loader-->
  @include('layouts.gym.heatmap.loader')
  <!-- Navbar-->


  <div id="wrap">
      @yield('content')
{{--      <div class="footer row justify-content-center">--}}
{{--          <div class=" text-center copyright pt-4 pb-3  px-3 col-md-9">--}}
{{--              <img src="{{url('/gym')}}/img/Group 6876.png" alt="">--}}
{{--              <div>{{__('app.gym.copyrights')}}</div>--}}

{{--          </div>--}}
{{--      </div>--}}
      @include('layouts.gym.heatmap.footer')
  </div>

{{--  @yield('content')--}}

  <!-- Footer-->

