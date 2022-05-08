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

            @if (session('status'))
                <img src="{{url('/images')}}/login/mail.png" width="80"  alt="email has been send">
                <h1 class="mt-3 mb-0">{{ __('Success') }}</h1>
                <p>{{ __('app.auth.emailhasbeensend') }}</p>
                <div class="d-inline-block w-100">

                    <a href="{{Url('/')}}" class="btn btn-primary mt-3">{{ __('app.auth.BacktoHome') }}</a>
                </div>
            @else
            <!-- Form -->
                <form method="POST" id="submited_form"  class="text-center" style="color: #757575;" action="{{ route('password.email') }}">
                    @csrf

                    <div class="md-form mt-3 @error('email') has-error @enderror">
                        <input type="email" id="email" class="form-control " placeholder="{{__('app.auth.email')}}"  name="email" value="{{ old('email') }}">
                        @error('email')
                        <span class="text-danger
                        invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                               </span>
                        @enderror
                    </div>




                    <!-- Sign in button -->
                    <button  class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect mt-2" type="submit" >{{__('app.auth.ResetPassword')}}</button>

                </form>
                <!-- Form -->
            @endif
        </div>


    </div>

@endsection
@push('js')
    <script src="{{url('/validator')}}/email.js"></script>
@endpush
