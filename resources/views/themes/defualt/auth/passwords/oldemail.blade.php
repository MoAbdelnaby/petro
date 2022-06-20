@extends('layouts.auth.auth')
@section('page_title')
    {{__('app.auth.ResetPassword')}}
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
                        @if (session('status'))
                            <img src="{{url('/images')}}/login/mail.png" width="80"  alt="email has been send">
                            <h1 class="mt-3 mb-0">{{ __('Success') }}</h1>
                            <p>{{ __('app.auth.emailhasbeensend') }}</p>
                            <div class="d-inline-block w-100">

                                <a href="{{Url('/')}}" class="btn btn-primary mt-3">{{ __('app.auth.BacktoHome') }}</a>
                            </div>
                        @else
                            <h1 class="mb-0">{{ __('app.auth.ResetPassword') }}</h1>
                            <p>{{__('app.auth.resetMessage')}}</p>
                            <form  id="submited_form" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('app.auth.email')}}</label>
                                    <input required type="email"  class="form-control mb-0  @error('email') is-invalid @enderror" id="email" placeholder="{{__('app.auth.email')}}"  name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>

                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">{{ __('app.auth.ResetPassword') }}</button>
                                </div>

                            </form>
                        @endif

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
    <script src="{{url('/validator')}}/email.js"></script>
@endpush
