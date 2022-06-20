@extends('layouts.auth.auth')
@section('page_title')
    {{__('app.auth.register')}}
@endsection
@section('content')
    <div class="card">

        <h5 class="card-login-header info-color  pt-4">
            <strong>{{__('app.auth.register')}}</strong>
        </h5>

        <!--Card content-->

        <div class="card-body px-lg-5">
                            <!-- Form -->
                            <form method="POST" id="submited_form"  class="text-center" style="color: #757575;" action="{{ route('register') }}">
                                @csrf
                            <div class="md-form mt-3">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('app.auth.name')}}"  name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                               </span>
                                @enderror
                            </div>

                                <div class="md-form mt-3">
                                    <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="{{__('app.auth.phone')}}"  name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                    <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                   </span>
                                    @enderror
                                </div>


                                <div class="md-form mt-3">
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('app.auth.email')}}"  name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                               </span>
                                    @enderror
                                </div>

                            <div class="md-form">
                                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="{{__('app.auth.password')}}"  name="password" value="{{ old('password') }}">
                                 @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                               </span>
                                @enderror
                            </div>

                                <div class="md-form">
                                    <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" placeholder="{{__('app.auth.password_confirmation')}}"  name="password_confirmation" value="{{ old('password_confirmation') }}">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                               </span>
                                    @enderror
                                </div>

                                <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                    <input type="checkbox" name="accept" class="custom-control-input" id="registercheckbox">
                                    <label class="custom-control-label" for="registercheckbox">{{__('app.auth.accept')}}<a href="/terms">{{__('app.auth.termsConditions')}}</a></label>
                                </div>

                            <!-- Sign in button -->
                            <button  class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect mt-2" type="submit"  id="registerbtn">{{__('app.auth.register')}}</button>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">{{__('app.auth.alreadyhaveaccount')}}<a href="{{ route('login') }}">{{__('app.auth.login')}}</a></span>

                                </div>
                            </form>
                        <!-- Form -->

        </div>


    </div>

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
