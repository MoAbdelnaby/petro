@extends('layouts.auth.newauth')
@section('page_title')
    {{__('app.auth.login')}}
@endsection
@section('content')

    @include('layouts.dashboard.partials._alert')

    <div class="text-center" style="width:400px; margin:0 auto;">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url("{{ asset('new-login/bg4-dark.jpg') }}")
            }

            [data-theme="dark"] body {
                background-image: url("{{ asset('new-login/bg4-dark.jpg') }}")
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!--begin::Aside-->
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <!--begin::Aside-->
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <!--begin::Logo-->
                    <a href="{{route('login')}}" class="mb-7">
                        <img alt="Logo" src="{{asset('/new-login')}}/petromin.png" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h2 class="text-white fw-normal m-0">Delivering Quality Automotive Care</h2>
                    <!--end::Title-->
                </div>
                <!--begin::Aside-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-center w-lg-50 p-10">
                <!--begin::Card-->
                <div class="card rounded-3 w-md-550px">
                    <!--begin::Card body-->
                    <div class="card-body p-10 p-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                              data-kt-redirect-url="#"
                              method="POST"    action="{{ route('login') }}">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Welcome to petromin</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Login options-->

                            <!--end::Login options-->
                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">With email</span>
                            </div>
                            <!--end::Separator-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="email" id="email"  class="form-control bg-transparent @error('email') is-invalid @enderror" placeholder="{{__('app.auth.email')}}"  name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                               </span>
                                @enderror


                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->

                                <input id="password"  autocomplete="off" class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="{{__('app.auth.password')}}"  name="password" value="{{ old('password') }}">
                                @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                               </span>
                                @enderror
                                <!--end::Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <!--begin::Link-->
                                <a href="{{Url('/password/reset')}}"
                                   class="link-primary">Forgot Password ?</a>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button  id="kt_sign_in_submit" onclick="submitLoginForm()" type="submit"  class="btn btn-primary">
                                    <!--begin::Indicator label-->


                                    <span class="indicator-label">Sign In</span>

                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span style="display: none;" class="indicator-progress ">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
{{--                            <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?--}}
{{--                                <a href="#"--}}
{{--                                   class="link-primary">Sign up</a>--}}
{{--                            </div>--}}
                            <!--end::Sign up-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>


@endsection
@push('js')

    <script
        src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous"></script>

    <script>
        function submitLoginForm () {
        event.preventDefault();
            // Disable the button
            document.getElementById("kt_sign_in_submit").disabled = true;
            $(".login-spiner").show();
            $(".indicator-progress").show();
            $("#kt_sign_in_form").submit();

        }
    </script>

@endpush
