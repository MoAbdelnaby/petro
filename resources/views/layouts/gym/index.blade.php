<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
          dir="{{str_replace('_', '-', app()->getLocale())=='ar'?'rtl':'ltr'}}">
    <head>
        <base href="">
        <meta charset="utf-8"/>
        @yield('meta')
        <title>{{__('app.website_name')}} | @yield('page_title',__('app.gym.dashboard'))</title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
        <link href="{{resolveDark()}}/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{resolveDark()}}/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
        <script src="{{resolveDark()}}/js/slick.css"></script>
        <link href="{{resolveDark()}}/css/mdb.min.css" rel="stylesheet" type="text/css"/>
        <link href="/gym/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="{{resolveDark()}}/css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="{{asset("/gym")}}/css/view.css">

        @if(app()->getLocale() =='ar')
            <link href="{{resolveDark()}}/css/style.css" rel="stylesheet" type="text/css"/>
            <link href="/gym/css/style-rtl.css" rel="stylesheet" type="text/css"/>
            <link href="{{resolveDark()}}/css/style-rtl.css" rel="stylesheet" type="text/css"/>
        @endif

{{--        @if(session()->has('darkMode'))--}}
{{--            <link rel="stylesheet" href="{{asset("/gym")}}/css/view.css">--}}
{{--        @endif--}}
        <link href="{{resolveDark()}}/css/style.css" rel="stylesheet" type="text/css"/>
        @stack('css')
        <link rel="shortcut icon" href="{{url('/images')}}/petromin.png"/>
    </head>

    <body>

    <div id="wrap">
        @include('layouts.dashboard.partials._page-loader')
        @include('layouts.dashboard.partials._alert')

        @yield('content')

        <div class="footer row justify-content-center">
            <div class=" text-center copyright pt-4 pb-3  px-3 col-md-9">
                <img src="{{url('/gym')}}/img/Group 6876.png" alt="">
                <div>{{__('app.gym.copyrights')}}</div>
            </div>
        </div>
    </div>


{{--    row modals--}}
    <div class="modal fade row-modal" id="basicExampleModal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h4 class="modal-title">{{ __('app.plate_modal_title') }}</h4>
                    <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class=" row">
                            <div class=" col-12 col-md-6" id="images-cont">
                               <div class="active-image-cont position-relative">
                                   <div class="slide">
                                       <img src="" alt="">
                                   </div>
                                   <div class="slide">
                                       <img src="" alt="">
                                   </div>

                                   <a class="next" ><i class="fas fa-chevron-right"></i></a>
                                   <a class="previous" ><i class="fas fa-chevron-left"></i></a>
                               </div>
                                <div class="thumbnails">
                                    <a class="thumb" data-thumb="1">
                                        <img src="" alt="">
                                    </a>
                                    <a class="thumb" data-thumb="2">
                                        <img src="" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 row-info">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row-info__item checkin-date">
                                            <div class="title">CheckIn Date</div>
                                            <div class="info">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 checkout-date">
                                        <div class="row-info__item">
                                            <div class="title">CheckOut Date</div>
                                            <div class="info">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row-info__item period">
                                            <div class="title">Period</div>
                                            <div class="info">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row-info__item area">
                                            <div class="title">Area</div>
                                            <div class="info">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row-info__item ar-plate">
                                            <div class="title">Arabic Plate</div>
                                            <div class="info">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row-info__item en-plate">
                                            <div class="title">English Plate</div>
                                            <div class="info">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row-info__item status">
                                            <div class="title">
                                                Plate Detection
                                            </div>
                                            <div class="info">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade show-image-models" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0"></div>
                <div class="modal-body">
                    <div class="position-relative d-block w-100 text-center">
                        <div class="position-relative d-flex aaa" id="images-cont">
{{--                            <img src="" id="car_image" alt="car" style="display: none">--}}
                            <img src="" id="image_to_show" alt="">
                            <button type="button" class="close" id="basicExampleClose" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
{{--                        <span id="indexImage">1</span>--}}
                        <span class="next-arrow"><i class="fas fa-chevron-right"></i></span>
                        <span class="prev-arrow"><i class="fas fa-chevron-left"></i></span>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade show-image-models" id="basicExampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0"></div>
                <div class="modal-body">
                    <div class="position-relative d-block w-100 text-center">
                        <img src="" class="col-5" alt="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
{{--                        <span id="indexImage">1</span>--}}
                        <span class="next-arrow"><i class="fas fa-chevron-right"></i></span>
                        <span class="prev-arrow"><i class="fas fa-chevron-left"></i></span>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>var app_url = "{{url('/')}}";</script>

    <script src="{{asset("/gym")}}/js/jquery-3.4.1.min.js"></script>
{{--    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>--}}
{{--    <script src="{{resolveDark()}}/js/popper.min.js"></script>--}}

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{asset("/gym")}}/js/bootstrap.min.js"></script>
    <script src="{{resolveDark()}}/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.ar.js" charset="UTF-8"></script>
    <script src="{{resolveDark()}}/js/mdb.min.js"></script>
    <script src="{{resolveDark()}}/js/slick.min.js"></script>
    <script src="{{resolveDark()}}/js/font.main.js"></script>
    <script src="{{resolveDark()}}/js/min.js"></script>
    <script src="{{resolveDark()}}/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- amcharts scripts -->
    <script src="{{ asset('chartjs/amcharts4/core.js') }}"></script>
    <script src="{{ asset('chartjs/amcharts4/charts.js') }}"></script>
    <script src="{{ asset('chartjs/amcharts4/animated.js') }}"></script>
    <script src="{{ asset('chartjs/heatmap.js') }}"></script>

    <!-- Face API JS -->
    <script src="{{ asset('chartjs/jquery.facedetection.min.js') }}"></script>
    <script src="{{ asset('chartjs/less.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('chartjs/webcam.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('chartjs/functions.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
    <script src="{{ asset('chartjs/chart-script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        var Disable_regions = "{{ __('app.Disable_regions') }}"
        $(".disable-reg").select2({
            placeholder: Disable_regions,
            tags: false,
            tokenSeparators: [',', ' ']
        })
    </script>

    @yield('scripts')

    @stack('js')
    <script>
        $(document).ready(function () {
            // $('.scroll-vertical-custom-div').width(function () {
            //     var cou = $(this).find('li').length;
            //     var wi = $(this).find('li').width();
            //     console.log((cou * wi + 30) + "px");
            //     return ((cou * (wi + 20)) + "px");
            // });
            jQuery("#loading").delay().fadeOut("");
            var images,
                index = 0;
            $('.screenshot-img').click(function(){
                images = $(this).closest('.screenshoot-content').find('img');
                index = $(this).index();
                $('#indexImage').html(index+1)
                if(images.length > 1){
                    $('.next-arrow, .prev-arrow,#indexImage').show();
                }
                else {
                    $('.next-arrow, .prev-arrow,#indexImage').hide();
                }
            });

            $('.next-arrow').click(function(){
                if(index+1 < images.length){
                    index += 1;
                    var src = images[index].src;
                    $('#image_to_show').attr('src',src);

                    // $('#image_to_show').remove();
                    // $('.show-image-models .position-relative').append('<img src="'+src+'" id="image_to_show" alt="">');
                    $('#indexImage').html(index+1)
                }else {
                    index = 0;
                    var src = images[index].src;
                    $('#indexImage').html(index+1)
                    $('#image_to_show').attr('src',src);
                    // $('#image_to_show').remove();
                    // $('.show-image-models .position-relative').append('<img src="'+src+'" id="image_to_show" alt="">');
                }

            });
            $('.prev-arrow').click(function(){
                if(index > 0 && index <= images.length){
                    index -= 1;
                    var src = images[index].src;
                    $('#image_to_show').attr('src',src);
                    // $('#image_to_show').remove();
                    // $('.show-image-models .position-relative').append('<img src="'+src+'" id="image_to_show" alt="">');
                    $('#indexImage').html(index+1)
                }else {

                    index = images.length-1;
                    var src = images[index].src;
                    console.log(index)

                    $('#indexImage').html(index+1)
                    $('#image_to_show').attr('src',src);

                    // $('#image_to_show').remove();
                    // $('.show-image-models .position-relative').append('<img src="'+src+'" id="image_to_show" alt="">');
                }

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

            $('.setting-icon-sho').click(function () {
                $(this).find('i').toggleClass('fa-spin');
                $(this).closest('.row').toggleClass('left-100');
            });

            $('.show-image-icon-sho').click(function () {
                // $(this).find('i').toggleClass('fa-long-arrow-alt-left fa-long-arrow-alt-right');
                $(this).closest('.row').toggleClass('right-100');
            });


            // close alert [ 'Success' , 'error' ]
            $('.alert-head i').click(function () {
                $(this).parents('.alert').fadeOut();
                setTimeout(function () {
                    $('.alert').remove();
                }, 500);
            });
            // close alert by set time out function limit 4 sec
            setTimeout(function () {
                $('.alert').fadeOut();
                setTimeout(function () {
                    $('.alert').remove();
                }, 500);
            }, 4000);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var lazyloadImages = document.querySelectorAll("img.lazy");
            var lazyloadThrottleTimeout;

            function lazyload() {
                if (lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }

                lazyloadThrottleTimeout = setTimeout(function () {
                    var scrollTop = window.pageYOffset;
                    lazyloadImages.forEach(function (img) {
                        if (img.offsetTop < (window.innerHeight + scrollTop)) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                        }
                    });
                    if (lazyloadImages.length == 0) {
                        document.removeEventListener("scroll", lazyload);
                        window.removeEventListener("resize", lazyload);
                        window.removeEventListener("orientationChange", lazyload);
                    }
                }, 20);
            }

            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
        });

    </script>

</body>

</html>
