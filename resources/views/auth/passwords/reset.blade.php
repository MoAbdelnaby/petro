@extends('layouts.auth.auth')
@section('page_title')
    {{__('app.auth.ResetPassword')}}
@endsection
@section('content')
    <div class="card">

        <h5 class="card-login-header info-color  pt-4">
            <strong>{{__('app.auth.ResetPassword')}}</strong>
        </h5>

        <!--Card content-->

        <div class="card-body px-lg-5">
            <!-- Form -->
            <form method="POST" id="submited_form"  class="text-center" style="color: #757575;" action="{{ route('user_reset_password')  }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="md-form mt-3 @error('email') has-error @enderror">
                    <input type="email" id="email" class="form-control " placeholder="{{__('app.auth.email')}}"  name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="text-danger invalid-feedback" role="alert">
                      {{ $message }}
                   </span>
                    @enderror
                </div>

                <div class="md-form @error('password') has-error @enderror">
                    <input id="password" class="form-control " type="password" placeholder="{{__('app.auth.password')}}"  name="password" value="{{ old('password') }}">
                     @error('password')
                    <span class="text-danger invalid-feedback" role="alert">
                         {{ $message }}
                   </span>
                    @enderror
                </div>

                <div class="md-form @error('password_confirmation') has-error @enderror">
                    <input id="password_confirmation" class="form-control " type="password" placeholder="{{__('app.auth.password_confirmation')}}"  name="password_confirmation" value="{{ old('password_confirmation') }}">
                    @error('password_confirmation')
                    <span class="text-danger invalid-feedback" role="alert">
                        {{ $message }}
                   </span>
                    @enderror
                </div>
                <!-- Sign in button -->
                <button  class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect mt-2" type="submit" >{{__('app.auth.ResetPassword')}}</button>

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
