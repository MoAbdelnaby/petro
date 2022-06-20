@extends('layouts.auth.auth')
@section('page_title')
    {{__('app.auth.register')}}
@endsection
@section('content')
<!-- Sign in Start -->
<section class="sign-in-page">
    <div class="container bg-white mt-5 p-0">
        <div class="row no-gutters">
            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <div class="text-center" style="width:400px; margin:0 auto;">

                          @if(session('danger'))
                        <div class="alert alert-danger" role="alert">
                        {!! session('danger') !!}
                              </div>
                              @endif

                        </div>
                    <h1 class="mb-0">{{__('app.auth.register')}}</h1>
                    <p>{{__('app.auth.loginmessage')}}</p>
                    <form method="POST" class="mt-4" id="submited_form" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__('app.auth.name')}}</label>
                            <input required type="text"  class="form-control mb-0  @error('name') is-invalid @enderror" id="name" placeholder="{{__('app.auth.name')}}"  name="name" value="{{ old('name') }}">
                            @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{__('app.auth.phone')}}</label>
                            <input type="text"  class="form-control mb-0   @error('phone') is-invalid @enderror" id="phone" placeholder="{{__('app.auth.phone')}}"  name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{__('app.auth.email')}}</label>
                            <input required type="email"  class="form-control mb-0  @error('email') is-invalid @enderror" id="email" placeholder="{{__('app.auth.email')}}"  name="email" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{__('app.auth.password')}}</label>
                            <input required type="password" class="form-control mb-0  @error('password') is-invalid @enderror" id="password" placeholder="{{__('app.auth.password')}}"  name="password" value="{{ old('password') }}">
                            @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">{{__('app.auth.password_confirmation')}}</label>
                            <input required type="password" class="form-control mb-0  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="{{__('app.auth.password_confirmation')}}"  name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                <input type="checkbox" name="accept" class="custom-control-input" id="registercheckbox">
                                <label class="custom-control-label" for="registercheckbox">{{__('app.auth.accept')}}<a href="/terms">{{__('app.auth.termsConditions')}}</a></label>
                            </div>
                            <button type="submit" class="btn btn-primary float-right"  id="registerbtn">{{__('app.auth.register')}}</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">{{__('app.auth.alreadyhaveaccount')}}<a href="{{ route('login') }}">{{__('app.auth.login')}}</a></span>
{{--                            <ul class="iq-social-media">--}}
{{--                                <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>--}}
{{--                                <li><a href="#"><i class="ri-twitter-line"></i></a></li>--}}
{{--                                <li><a href="#"><i class="ri-instagram-line"></i></a></li>--}}
{{--                            </ul>--}}
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 text-center">
                <div class="sign-in-detail text-white">
                    <a class="sign-in-logo mb-5" href="{{Url('/')}}"><img src="{{url('/images')}}/wakeball/petrominwhitetext.png"  class="img-fluid" alt="logo"></a>
                    <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                        <div class="item">
                            <img src="{{url('/images')}}/login/1.png" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                        </div>
                        <div class="item">
                            <img src="{{url('/images')}}/login/1.png" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                        </div>
                        <div class="item">
                            <img src="{{url('/images')}}/login/1.png" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sign in END -->
@endsection
@push('js')
    <script src="{{url('/validator')}}/register.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('#registerbtn').attr('disabled','disabled');
        $('#registercheckbox').on('change',function() {

            if (this.checked) {
                $('#registerbtn').removeAttr('disabled');
            } else {
                $('#registerbtn').attr('disabled','disabled');
            }
        });
        });
    </script>
@endpush
