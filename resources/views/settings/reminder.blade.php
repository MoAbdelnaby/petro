@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.gym.car_plates')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('css')
 <!-- Include stylesheet -->
 <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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

        .ql-toolbar.ql-snow + .ql-container.ql-snow {
            border-top: 0px;
            min-height: 400px;
        }
        .ql-toolbar.ql-snow {
            padding: 24px;
        }
        .ql-snow .ql-picker {
            position: relative!important;
            z-index: 999;
        }

        .ql-snow .ql-picker.ql-header {
            width: 200px;
            height: 34px;
            line-height: 34px;
        }
        .ql-snow .ql-picker.ql-size {
            width: 200px;
            position: relative!important;
        }
        .ql-toolbar .ql-picker .ql-picker-label {
            border-color: #ccc;
            width: 100%;
            position: relative!important;
            height: 34px;
            display: inline-block;
        }
        .ql-snow .ql-picker.ql-expanded .ql-picker-options{
            overflow: hidden;
            margin-top: 34px;
            top: 100%;
            z-index: 999999999;
            position: absolute!important;
            display: block;
        }
        .ql-editor p{
            margin: 0;
            padding: 0;
            counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
            min-height: 100%;
            display: block;
            position: relative;
            min-height: 50px;
            padding: 10px;
            z-index: ;
        }
        .ql-toolbar.ql-snow .ql-formats{
            height: 34px
        }
        .related-heading span{
            top: 0px!important;
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

                                        <li class="nav-item">
                                            <a class="nav-link " id="v-pills-branch-tab" data-toggle="pill"
                                               href="#v-pills-branchErrorMailtemplate"
                                               role="tab" aria-controls="v-pills-reminder"
                                               aria-selected="true">{{ __('app.brancheErrorTemplate') }}</a>
                                        </li>
                                    </ul>

                                </div>
                                <div class=" my-4">
                                    <div class="row">
                                        <div class="col-12 ">
                                            <div class="tab-content" id="v-pills-tabContent">
{{--                                                @include('settings.includes.reminder_message')--}}
                                                @include('settings.includes.mail_status')
                                                @include('settings.includes.mailsetting')
                                                @include('settings.includes.branchErrorTempleat')
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
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<!-- Initialize Quill editor -->
<script>
var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],

  ['clean']                                         // remove formatting button
];

var quill = new Quill('#editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});
</script>
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
            $('#saveEditor').on('click',function(){
                let html = $('#editor').html();
                $('input#htmlEle').val(html);
                $('#Submit').trigger('click');

            });

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
