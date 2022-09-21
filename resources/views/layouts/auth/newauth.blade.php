<!DOCTYPE html>
<html lang="en">

<head>


    <title>Petromin | Login</title>
{{--    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>--}}
    <meta charset="utf-8" />
    <meta name="description" content="Login Page" />
    <meta name="keywords" content="Petromin Login Page" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Petromin | Login " />
    <meta property="og:url" content="petromin.wakeb.tech" />
    <meta property="og:site_name" content="Wakeb | Petromin" />
    <link rel="canonical" href="petromin.wakeb.tech" />
    <link rel="shortcut icon" href="{{asset('/new-login')}}/petromin.png" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <link href="{{asset('/new-login')}}/style.bundle.css" rel="stylesheet" type="text/css" />


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')
    @stack('css')
</head>

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">

      <!-- loader END -->
      @yield('content')
      @stack('js')
   </body>
</html>
