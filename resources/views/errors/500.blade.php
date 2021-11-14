<!DOCTYPE html>
<html lang="ar">
<head>
    <base href="">
    <meta charset="utf-8"/>
    <title>{{ __('app.website_name') }} | {{ __('app.Error') }}</title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <link href="{{asset('assets/errors/css/style.css')}}" rel="stylesheet" type="text/css"/>
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled sidebar-enabled page-loading">
<div class="d-flex flex-column flex-root">
    <div class="error error-5 d-flex flex-row-fluid bgi-size-cover bgi-position-center"
         style="background-image: url({{asset('assets/errors/media/bg5.jpg')}});">
        <div class="container d-flex flex-row-fluid flex-column justify-content-md-center p-12">
            <h1 class="error-title font-weight-boldest text-info mt-10 mt-md-0 mb-5" style="font-size: 180px">{{ __('app.Oops') }}!</h1>
            <p style="font-size: 23px">{{ __('app.Looks_like_something_went_wrong_Were_working_on_it_go_to') }} <a
                    href="{{url('/')}}">{{ __('app.Home_Page') }}</a>
            </p>
        </div>
    </div>
</div>
</body>

</html>
