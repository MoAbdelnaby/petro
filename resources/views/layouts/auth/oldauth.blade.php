<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="{{session()->has('darkMode') ?'ltr':(str_replace('_', '-', app()->getLocale())=='ar'?'rtl':'ltr')}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>

     <link rel="shortcut icon" href="{{url('/images')}}/Logo.svg" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{resolveLang()}}/css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="{{resolveLang()}}/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="{{resolveLang()}}/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="{{resolveLang()}}/css/responsive.css">
      @stack('css')
</head>
<body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      @yield('content')
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
      <!-- Chart Custom JavaScript -->
      <script src="{{resolveLang()}}/js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="{{resolveLang()}}/js/custom.js"></script>
      @stack('js')
   </body>
</html>
