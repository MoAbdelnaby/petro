@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.gym.car_plates')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-selection.select2-selection--multiple {
            min-height: 40px !important;
        }

        .select-model h3 {
            width: 230px;
        }
    </style>
@endpush
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="text-center">

                </div>
                <div class="col-sm-12">
                    <div class="iq-card mt-4 mb-4">
                        <div class="iq-card-body">
                            <div class="related-heading plates-car-cont border-0">
                                <div
                                    class="d-flex justify-content-between align-items-center setting-heading border-bottom">
                                    <h2 class="border-bottom-0" style="text-transform: capitalize;">
                                        <img
                                            src="{{ resolveDark() }}/img/icon_menu/settings.svg" alt="Settings"
                                            class="tab_icon-img">
                                        {{ __('app.Settings') }}
                                    </h2>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
{{--                                        <li class="nav-item">--}}
{{--                                            <a class="nav-link {{ !$errors->has('env.*') ? 'show active':'' }}" id="v-pills-reminder-tab" data-toggle="pill"--}}
{{--                                               href="#v-pills-reminder"--}}
{{--                                               role="tab" aria-controls="v-pills-reminder"--}}
{{--                                               aria-selected="true">{{ __('app.Reminder') }}</a>--}}
{{--                                        </li>--}}
                                        <li class="nav-item">
                                            <a class="nav-link {{$errors->has('branch_type') || count($errors) == 0 ? 'show active':'' }}" id="v-pills-branch-tab" data-toggle="pill"
                                               href="#v-pills-branch"
                                               role="tab" aria-controls="v-pills-reminder"
                                               aria-selected="true">{{ __('app.branchSetting') }}</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link {{ $errors->has('env.*') ? 'active':'' }}" id="v-pills-branch-tab" data-toggle="pill"
                                               href="#v-pills-mail"
                                               role="tab" aria-controls="v-pills-reminder"
                                               aria-selected="true">{{ __('app.mailSetting') }}</a>
                                        </li>
                                    </ul>

                                </div>
                                <div class=" my-4">
                                    <div class="row">
                                        <div class="col-12 ">
                                            <div class="tab-content" id="v-pills-tabContent">
{{--                                                <div class="tab-pane fade  py-3" id="v-pills-reminder"--}}
{{--                                                     role="tabpanel"--}}
{{--                                                     aria-labelledby="v-pills-reminder-tab">--}}
{{--                                                    <form id="reminderForm" method="post" novalidate--}}
{{--                                                          action="{{route('setting.reminder_post')}}"--}}
{{--                                                          class="reminder-form">--}}
{{--                                                    @csrf--}}
{{--                                                    <!-- --}}{{--@include('settings.reminder-tab)--}}{{-- -->--}}
{{--                                                        <div class="">--}}
{{--                                                            <div class="row m-0 p-0">--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <div class="form-group">--}}
{{--                                                                        <label for="days">{{ __('app.Days') }}</label>--}}
{{--                                                                        <input type="number" class="form-control"--}}
{{--                                                                               id="days"--}}
{{--                                                                               min="1" max="365" name="day"--}}
{{--                                                                               value="{{$reminder ? $reminder->day : ''}}"--}}
{{--                                                                               aria-describedby="number of days"--}}
{{--                                                                               placeholder="(1  - 365)">--}}
{{--                                                                        <div class="invalid-feedback day">--}}
{{--                                                                            {{ __('app.enter_a_valid_number_of_days') }}--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}

{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-12  mt-3">--}}
{{--                                                            <button type="submit"--}}
{{--                                                                    class="btn btn-primary submit-btn waves-effect waves-light px-4 py-2"--}}
{{--                                                                    style="width: 200px;">{{ __('app.Save') }}--}}
{{--                                                            </button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
                                                <div class="tab-pane fade py-3   {{ $errors->has('branch_type') || count($errors) == 0 ? 'show active':'' }}" id="v-pills-branch">
                                                    <div class="">
                                                        <form id="branchMailsetting" method="post" novalidate
                                                              action="{{route('setting.branchmail')}}"
                                                              class="reminder-form">
                                                            @csrf
                                                            <div class="row p-0 m-0">
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{ __('app.selectType') }}</label>
                                                                        <select name="branch_type" class="form-control"
                                                                                id="picType">
                                                                            <option value=""></option>
                                                                            <option value="hours">Hours</option>
                                                                            <option value="minute">Minute</option>
                                                                        </select>
                                                                             @if($errors->has('branch_type'))
                                                                            <small class="text-danger" role="alert">
                                                                                <strong>{{ $errors->get('branch_type')[0] }}</strong>
                                                                            </small>
                                                                            @endif
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-4 col-md-6 ">
                                                                    <div class="form-group">
                                                                        <div id="durationDiv">
                                                                            <label style="display: none"
                                                                                   for="">{{ __('app.duration') }}</label>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row p-0 m-0">
                                                                <div class="col-12 mt-3">
                                                                    <button type="submit"
                                                                            class="btn btn-primary submitmail-btn waves-effect waves-light px-4 py-2"
                                                                            style="width: 200px;">{{ __('app.Save') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                                <div class="tab-pane fade py-3 {{ $errors->has('env.*') ? 'show active':'' }}" id="v-pills-mail">
                                                    <div class="">

                                                        <form id="Mailsettings" method="post" novalidate
                                                              action="{{route('setting.mailsettings')}}"
                                                              class="reminder-form">
                                                            @csrf
                                                            <div class="row p-0 m-0">
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="text">{{ __('MAIL DRIVER') }}</label>
                                                                        <input type="text"
                                                                               name="env[MAIL_DRIVER]"
                                                                               class="form-control"
                                                                               placeholder="smtp"
                                                                               value="">


                                                                            @if($errors->has('env.*'))
                                                                            <small class="text-danger" role="alert">
                                                                                 <strong>{{ $errors->get('env.*')['env.MAIL_DRIVER'][0] }}</strong>
                                                                            </small>
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="text">{{ __('MAIL HOST') }}</label>
                                                                        <input type="text"
                                                                               name="env[MAIL_HOST]"
                                                                               class="form-control"
                                                                               placeholder="smtp.googlemail.com"
                                                                               value=""
                                                                        >
                                                                        @if($errors->has('env.*'))
                                                                            <small class="text-danger" role="alert">
                                                                                 <strong>{{ $errors->get('env.*')['env.MAIL_HOST'][0] }}</strong>
                                                                            </small>
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="text">{{ __('MAIL PORT') }}</label>
                                                                        <input type="text"
                                                                               name="env[MAIL_PORT]"
                                                                               class="form-control"
                                                                               placeholder="465"
                                                                               value="">
                                                                        @if($errors->has('env.*'))
                                                                            <small class="text-danger" role="alert">
                                                                                 <strong>{{ $errors->get('env.*')['env.MAIL_PORT'][0] }}</strong>
                                                                            </small>
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">

                                                                    <div class="form-group">
                                                                        <label for="text">{{ __('MAIL USERNAME') }}</label>
                                                                        <input type="text"
                                                                               name="env[MAIL_USERNAME]"
                                                                               class="form-control"
                                                                               placeholder="username"
                                                                               value="">
                                                                        @if($errors->has('env.*'))
                                                                            <small class="text-danger" role="alert">
                                                                                 <strong>{{ $errors->get('env.*')['env.MAIL_USERNAME'][0] }}</strong>
                                                                            </small>
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">

                                                                    <div class="form-group">
                                                                        <label for="text">{{ __('MAIL PASSWORD') }}</label>
                                                                        <input type="text"
                                                                               name="env[MAIL_PASSWORD]"
                                                                               class="form-control"
                                                                               placeholder="password"
                                                                               value="">
                                                                        @if($errors->has('env.*'))
                                                                            <small class="text-danger" role="alert">
                                                                                 <strong>{{ $errors->get('env.*')['env.MAIL_PASSWORD'][0] }}</strong>
                                                                            </small>
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">

                                                                    <div class="form-group">
                                                                        <label for="text">{{ __('MAIL ENCRYPTION') }}</label>
                                                                        <select name="env[MAIL_ENCRYPTION]" class="form-control">
                                                                            <option value=""></option>
                                                                            <option value="tls">tls</option>
                                                                            <option value="ssl">ssl</option>
                                                                        </select>
                                                                        @if($errors->has('env.*'))
                                                                            <small class="text-danger" role="alert">
                                                                                 <strong>{{ $errors->get('env.*')['env.MAIL_ENCRYPTION'][0] }}</strong>
                                                                            </small>
                                                                            @endif
                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="row p-0 m-0">
                                                                <div class="col-12 mt-3">
                                                                    <button type="submit"
                                                                            class="btn btn-primary submitmailsettings-btn waves-effect waves-light px-4 py-2"
                                                                            style="width: 200px;">{{ __('app.Save') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
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
        </div>
    </div>


@endsection

@push("js")
    <script>
        $(document).on("change", "#picType", function () {
            if ($('#picType').val()) {
                $('#durationSelect').remove();
                let values = []
                if ($(this).val() == 'minute') {
                    for (let i = 1; i <= 60; i++) {
                        values.push(i)
                    }
                } else {
                    for (let i = 1; i <= 24; i++) {
                        values.push(i)
                    }
                }
                var selection = "";
                selection = "<select class='form-control' id='durationSelect' name='branch_duration'>";
                for (var j = 1; j <= values.length; j++) {
                    selection += "<option value='" + j + "'>" + j + "<option>"
                }
                selection += "</select>";

                $("#durationDiv").append(selection);
                $("#durationDiv label").show();
            } else {
                $("#durationDiv #durationSelect").remove();
                $("#durationDiv label").hide();
            }

        })
        $(document).ready(function () {
            // $("#kilometer").on("focus", function () {
            //     if ($("#kilometer.is-invalid")[0]) {
            //         $("#kilometer").removeClass("is-invalid")
            //         $(".km").removeClass("show")
            //     }
            // })
            // $("#kilometer").on("blur", function (e) {
            //     let km = Number($("#kilometer").val().trim());
            //     if (Number.isNaN(km) || km <= 0) {
            //         $("#kilometer").addClass("is-invalid")
            //         $(".km").addClass("show")
            //         return false
            //     }
            //
            // })
            $("#days").on("focus", function () {
                if ($("#days.is-invalid")[0]) {
                    $("#days").removeClass("is-invalid")
                    $(".day").removeClass("show")
                }
            })
            $("#days").on("blur", function (e) {
                let days = Number($("#days").val().trim());

                if (Number.isNaN(days) || (days <= 0 || days > 365)) {
                    $("#days").addClass("is-invalid")
                    $(".day").addClass("show")
                    return false
                }

            })
            $(".submit-btn").on("click", (e) => {

                e.preventDefault();

                let invalid = false;
                let days = Number($("#days").val().trim());

                if (Number.isNaN(days)) {
                    $(".day").addClass("show")
                    return false
                }

                if (days <= 0 || days > 365) {
                    $(".day").addClass("show");
                    $("#days").addClass("is-invalid")
                    invalid = true
                }

                if (invalid) return false

                $("#reminderForm").submit();

            })

            $(".submitmail-btn").on("click", (e) => {
                $("#branchMailsetting").submit();
            });

            $(".submitmailsettings-btn").on("click", (e) => {
                $("#branchMailsetting").submit();
            });

        });


        $(window).scroll(function () {
            var aT
            op = $('.ad').height();
            if ($(this).scrollTop() >= 500) {
            }
        });
    </script>
@endpush
