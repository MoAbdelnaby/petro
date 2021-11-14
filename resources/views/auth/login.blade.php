@extends('layouts.auth.auth')
@section('page_title')
    {{__('app.auth.login')}}
@endsection
@section('content')
    <div class="card">

        <h5 class="card-login-header info-color  pt-4">
            <strong>{{__('app.auth.login')}}</strong>
        </h5>

        <!--Card content-->

        <div class="card-body px-lg-5">
            <!-- Form -->
            <form method="POST" id="submited_form"  class="text-center" style="color: #757575;" action="{{ route('login') }}">
                @csrf
                <div class="md-form mt-3">
                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('app.auth.email')}}"  name="email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                               </span>
                    @enderror
                </div>

                <div class="md-form">
                    <a href="{{Url('/password/reset')}}" class="float-right">{{__('app.auth.Forgot')}}</a>
                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="{{__('app.auth.password')}}"  name="password" value="{{ old('password') }}">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                               </span>
                    @enderror
                </div>
                <div class="md-form">
                    <select id="branch" name="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                        @foreach($branches as $branch)
                            <option value="">select branch</option>
                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                    <span class="invalid-feedback my-2" role="alert">
                                         <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <!-- Sign in button -->
                <button  id="loginButton" onclick="submitLoginForm()"  class="btn btn-outline-info btn-rounded btn-block  z-depth-0 my-4 waves-effect mt-2" type="submit">{{__('app.auth.login')}}
                    <span style="display: none;"
                          class=" mt-1 mr-1 spinner-border spinner-border-sm login-spiner" role="status"
                          aria-hidden="true"></span>
                </button>
                <div class="sign-info">
                    <span class="dark-color d-inline-block line-height-2">{{__('app.auth.donothaveaccount')}}<a href="{{ route('register') }}">{{__('app.auth.register')}}</a></span>

                </div>
            </form>
            <!-- Form -->

        </div>


    </div>

@endsection
@push('js')

    <script>
        function submitLoginForm () {
            // Disable the button
            document.getElementById("loginButton").disabled = true;
            $(".login-spiner").show();
            $("#submited_form").submit();

        }
    </script>

    {{--    <script src="{{url('/validator')}}/login.js"></script>--}}
@endpush
