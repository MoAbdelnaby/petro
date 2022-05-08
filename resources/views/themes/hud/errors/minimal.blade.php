
<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="description" content="Page not found page examples">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{url('/temp')}}/assets/css/pages/error/404-v1.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{url('/temp')}}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/temp')}}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{url('/temp')}}/assets/css/skins/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/temp')}}/assets/css/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/temp')}}/assets/css/skins/brand/navy.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/temp')}}/assets/css/skins/aside/navy.css" rel="stylesheet" type="text/css" />

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{url('/temp')}}/assets/media/logos/favicon.ico" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-bg-light kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-error404-v1">
        <div class="kt-error404-v1__content">
            <div class="kt-error404-v1__title">@yield('code')</div>
            <div class="kt-error404-v1__desc"><strong>{{ __('app.Oops') }}! </strong> @yield('message')</div>
        </div>
        <div class="kt-error404-v1__image">
            <img src="{{url('/temp')}}/assets/media/misc/404-bg1.jpg" class="kt-error404-v1__image-content" alt="" title="" />
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "metal": "#c4c5d6",
                "light": "#ffffff",
                "accent": "#00c5dc",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995",
                "focus": "#9816f4"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{url('/temp')}}/assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="{{url('/temp')}}/assets/js/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->
</body>

<!-- end::Body -->
</html>
