<div id="wrap">



  <!-- Header -->
  <div id="header">
    <div style="padding: 0" class="navigation fixed-top background scroll">
      <div class="container">
        <nav id="navbar-example" class="navbar navbar-expand-lg navbar-light">
{{--          <a class="navbar-brand brand-logo" target="-blank" href="{{url('/')}}">--}}
{{--            <img style=" margin-top: 4px;" src="{{ asset('assets/images/maj.png') }}" class="mr-2 inner-logo">--}}
{{--          </a>--}}
            <a class="navbar-brand brand-logo" target="-blank" href="{{url('/')}}">
                <img src="{{ asset('assets/images/wakeb.png') }}" alt="Wakeb" title="Wakeb">
            </a>

{{--          <button class="navbar-toggler hamburger " style=" visibility: visible;" type="button" data-toggle="collapse"--}}
{{--            data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--            <span class="hamburger-box">--}}
{{--              <span class="hamburger-label"></span>--}}
{{--              <span class="hamburger-inner"></span>--}}
{{--            </span>--}}
{{--          </button>--}}

{{--          <div class="top-nav collapse navbar-collapse" id="nav-content">--}}
{{--            <ul class="navbar-nav ml-auto">--}}

{{--              <a class="navbar-brand brand-logo" target="-blank" href="{{url('/')}}">--}}
{{--                <img src="{{ asset('assets/images/wakeb.png') }}" alt="Wakeb" title="Wakeb">--}}
{{--              </a>--}}

{{--            </ul>--}}
{{--          </div>--}}
        </nav>
      </div>
    </div>
  </div>
  <!--/. Header -->

  <!-- Page intro -->
  <div id="hero-bg" class="scroll top">
    <div>
      <div class="container">
        <div class="hero-inner row">
          <div class="col-lg-6 col-xl-5 col-md-7">
            <div class="hero-content">
              <div class="powered-by">
                <div class="media">
                  <img src="{{ asset('assets/images/robot.png') }}" class="mr-2" class="testim">
                  <div class="media-body">
                    <h5 class="my-0">{{ __('app.product_powered_by') }}</h5>
                    <h3 class="my-0">MASBAR</h3>
                  </div>
                </div>
              </div>
              <h1>Welcome to Al majdouie</h1>
              <p>Our solution can accurately identify and classify objects, Using Artificial intelligence (AI)
                techniques
                for Analyzing video streaming.</p>
              <ul>
                <li>
                  <a href="{{url('login')}}">
                    <div class="btn link">{{ __('app.Login') }}</div>
                  </a>

                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-5 offset-lg-1  col-md-5 hide-small">
            <div class="here-side-img">
              <img src="{{ asset('assets/images/main.svg') }}" width="400px">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /. Page intro -->

  <!--Footer-->
  <div class="dark-footer">
    <div class="container">
      <div class="row">
        <div class="logo col-md-4 ">
          <a target="_blank" href="http://wakeb.tech/"><img src="{{ asset('assets/images/light-wakeb.png') }}"
              alt="wakeb" title="wakeb"></a>
        </div>
        <div class="col-md-8 cpr">
          {{ __('app.gym.copyrights') }}
        </div>
      </div>
    </div>
  </div>
  <!-- /. Footer -->



</div>

<div id="THE_RESPONCE_DIV"></div>
<div id="THE_RESPONCE_DIV2"></div>
