@extends('layouts.auth.auth')
@section('page_title')
    {{__('app.auth.login')}}
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
                            <h1 class="mb-0">{{__('app.auth.login')}}</h1>
                            <p>{{__('app.auth.loginmessage')}}</p>
                            <form method="POST" class="mt-4" id="submited_form"  action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{__('app.auth.email')}}</label>
                                    <input required type="email"  class="form-control mb-0 @error('email') is-invalid @enderror" id="email" placeholder="{{__('app.auth.email')}}"  name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('app.auth.password')}}</label>
                                <a href="{{Url('/password/reset')}}" class="float-right">{{__('app.auth.Forgot')}}</a>
                                    <input required type="password" class="form-control mb-0 @error('password') is-invalid @enderror" id="password" placeholder="{{__('app.auth.password')}}"  name="password" value="{{ old('password') }}">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">{{__('app.auth.Remember')}}</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">{{__('app.auth.login')}}</button>
                                </div>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">{{__('app.auth.donothaveaccount')}}<a href="{{ route('register') }}">{{__('app.auth.register')}}</a></span>
{{--                                    <ul class="iq-social-media">--}}
{{--                                        <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>--}}
{{--                                        <li><a href="#"><i class="ri-twitter-line"></i></a></li>--}}
{{--                                        <li><a href="#"><i class="ri-instagram-line"></i></a></li>--}}
{{--                                    </ul>--}}
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div class="sign-in-detail text-white">
                            <a class="sign-in-logo mb-5" href="{{Url('/')}}"><img src="{{url('/images')}}/wakeball/wakebwhitetext.png" class="img-fluid" alt="logo"></a>
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
    <script src="{{url('/validator')}}/login.js"></script>
@endpush
