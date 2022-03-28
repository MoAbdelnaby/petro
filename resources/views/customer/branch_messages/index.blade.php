@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.branch_message')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(Session::has('branch_file'))
        <meta http-equiv="refresh" content="5;url={{ Session::get('branch_file') }}">
    @endif
@endsection

@push('css')
    <style>
        .select2-container {
            width: 100% !important;
        }


        .select2-selection.select2-selection--multiple {
            min-height: 40px !important;
        }

        /*.plates-car-cont .select2-container--default .select2-selection--single .select2-selection__arrow b {*/
        /*    left: auto;*/
        /*    right: 15px;*/
        /*    top: 50%;*/
        /*}*/
        /*.plates-car-cont #select_branch + .select2-container--default .select2-selection--single .select2-selection__arrow b {*/
        /*    left: 93%;*/
        /*    top: 60%;*/
        /*}*/


        .select-model h3 {
            width: 230px;
        }

        div.dataTables_wrapper div.dataTables_paginate, div.dataTables_wrapper div.dataTables_info {
            display: none !important;
        }

        ul.pagination {
            /* padding-left: 50%; */
            margin-bottom: 15px;
        }
    </style>
@endpush

@push('js')
    <script>
        $(".submit_form").on('click', function (e) {
            var type = $(this).data('type');
            $("#form").submit(function (eventObj) {
                $("<input />").attr("type", "hidden")
                    .attr("name", "type")
                    .attr("value", type)
                    .appendTo("#form");
                return true;
            });
        })
    </script>
@endpush

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12" style="margin-top: -35px">
                    <div class="iq-card mt-4 mb-4">
                        <div class="iq-card-body">
                            <div class="plates-car-cont">
                                <div class="c-flex related-heading mb-4">
                                    <h2 class="border-bottom-0 mx-2 mt-0 mb-2" style="text-transform: capitalize;">
                                        <img src="{{resolveDark()}}/img/icon_menu/envelope.svg" width="24"
                                             class="tab_icon-img" alt="">
                                        {{ __('app.branch_message') }}

                                    </h2>
                                    <div class="actions-cont c-flex">
                                        <a href="{{route('branch.exported_file')}}" target="_blank"
                                           class=" btn btn-info waves-effect waves-light">
                                            <i class="fas fa-file-archive-o"></i> {{ __('app.prepared_files') }}
                                        </a>
                                        <div class="filter-dropdown position-relative">
                                            <a class="btn-filter btn btn-primary waves-effect waves-light"
                                               data-toggle="dropdown" href="#">
                                                <i class="fas fa-sort-alt"></i> Filter
                                            </a>
                                            <div class="filter-content ">
                                                <form method="get" id="form" class="filter-form"
                                                      action="{{route('branch.message_log')}}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="w-100">@lang('app.Select_branch')
                                                                    * </label>
                                                                <div class="select-cont position-relative">
                                                                    <select class="form-control" id="select_branch"
                                                                            name="branch_id">
                                                                        <option value=""
                                                                                selected>{{ __('app.Select_branch') }}</option>
                                                                        @foreach($branches as $branch)
                                                                            <option value="{{$branch->id}}"
                                                                            @if(request('branch_id') != null) {{request('branch_id') == $branch->id ? 'selected' : ''}} @endif>{{$branch->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="invalid-feedback name-feedback">
                                                                    <strong>{{$errors->has('branch_id')?$errors->first('branch_id'):''}}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <label>{{__('app.type')}}</label>
                                                            <div class="select-cont">
                                                                <select class="form-control nice-select"
                                                                        name='message_type'>
                                                                    <option value="">@lang('app.all')</option>
                                                                    <option
                                                                        value="welcome" {{ request('message_type') == 'welcome' ? 'selected' : '' }}>@lang('app.Welcome')</option>
                                                                    <option
                                                                        value="invoice" {{ request('message_type') == 'invoice' ? 'selected' : '' }}>@lang('app.Invoice')</option>
                                                                </select>
                                                            </div>
                                                            <div class="invalid-feedback name-feedback">
                                                                <strong>{{$errors->has('message_type')?$errors->first('message_type'):''}}</strong>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mb-2">
                                                            <label>{{__('app.status')}}</label>
                                                            <div class="select-cont">
                                                                <select class="form-control nice-select"
                                                                        name='status'>
                                                                    <option value="">@lang('app.all')</option>
                                                                    <option
                                                                        value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>@lang('app.sent')</option>
                                                                    <option
                                                                        value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>@lang('app.failed')</option>
                                                                </select>
                                                            </div>
                                                            <div class="invalid-feedback name-feedback">
                                                                <strong>{{$errors->has('status')?$errors->first('status'):''}}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <label>{{__('app.start')}}</label>
                                                            <input type="date" name="start_date" class="form-control"
                                                                   value="{{old('start_date') ?? request('start_date')}}"/>
                                                            <div class="invalid-feedback name-feedback">
                                                                <strong>{{$errors->has('start_date')?$errors->first('start_date'):''}}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label>{{__('app.end')}}</label>
                                                            <input type="date" name="end_date" class="form-control"
                                                                   value="{{old('end_date') ?? request('end_date')}}"/>
                                                            <div class="invalid-feedback name-feedback">
                                                                <strong>{{$errors->has('end_date')?$errors->first('end_date'):''}}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between form-actions-cont mt-4">
                                                        <button type="submit" id="export_excel" data-type="xls"
                                                                class="btn btn-primary submit_form waves-effect waves-light">
                                                            <i class="fas fa-file-excel-o"></i> {{ __('app.ExportExcel') }}
                                                        </button>
                                                        <button type="submit" id="export_excel" data-type="pdf"
                                                                class="btn btn-primary submit_form waves-effect waves-light">
                                                            <i class="fas fa-file-pdf-o"></i> {{ __('app.ExportPdf') }}
                                                        </button>
                                                        <button type="submit" id="search" data-type="search"
                                                                class="btn btn-secondary waves-effect waves-light px-4 py-2 submit-btn">
                                                            <i class="fas fa-search"></i> {{ __('app.Search') }}
                                                        </button>
                                                    </div>
                                                </form>


                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown">
                                                <i class="fas fa-bars" style=""></i>
                                            </a>
                                            <ul class="dropdown-menu main-dropdown chart-type tables-type tables-types-d">
                                                <li>
                                                    <a tabindex="-1" href="#"
                                                       class="dropdown-item table-1 {{ $userSettings ? ($userSettings->table_type == "1" ? 'selected' : '') :'selected' }}">
                                                        <img src="{{ asset('assets/images/tables-type/table-1.png')}}"
                                                             alt="{{ __('app.Pie_Chart') }}"
                                                             title="{{ __('app.Pie_Chart') }}">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a tabindex="-1"
                                                       class="dropdown-item table-2 {{ $userSettings ? ($userSettings->table_type == "2" ? 'selected' : '') :'' }}"
                                                       href="#">
                                                        <img src="{{ asset('assets/images/tables-type/table-2.png')}}"
                                                             alt="{{ __('app.Bar_Chart') }}"
                                                             title="{{ __('app.Bar_Chart') }}">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a tabindex="-1"
                                                       class="dropdown-item table-3 {{ $userSettings ? ($userSettings->table_type == "3" ? 'selected' : '') :'' }}"
                                                       href="#">
                                                        <img src="{{ asset('assets/images/tables-type/table-3.png')}}"
                                                             alt="{{ __('app.Line_Chart') }}"
                                                             title="{{ __('app.Line_Chart') }}">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a tabindex="-1"
                                                       class="dropdown-item table-4 {{ $userSettings ? ($userSettings->table_type == "4" ? 'selected' : '') :'' }}"
                                                       href="#">
                                                        <img src="{{ asset('assets/images/tables-type/table-4.png')}}"
                                                             alt="{{ __('app.Pyramid_Chart') }}"
                                                             title="{{ __('app.Pyramid_Chart') }}">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                {{--                                <div class=" my-4">--}}
                                {{--                                    <form method="get" id="form" action="{{route('branch.message_log')}}">--}}
                                {{--                                        @csrf--}}
                                {{--                                        <div class="row">--}}
                                {{--                                            <div class="col-3">--}}
                                {{--                                                <div class="form-group">--}}
                                {{--                                                    <label class="w-100">@lang('app.Select_branch') * </label>--}}
                                {{--                                                    <select class="form-control" id="select_branch" name="branch_id">--}}
                                {{--                                                        <option value="" selected>{{ __('app.Select_branch') }}</option>--}}
                                {{--                                                        @foreach($branches as $branch)--}}
                                {{--                                                            <option value="{{$branch->id}}"--}}
                                {{--                                                            @if(request('branch_id') != null) {{request('branch_id') == $branch->id ? 'selected' : ''}} @endif>{{$branch->name}}</option>--}}
                                {{--                                                        @endforeach--}}
                                {{--                                                    </select>--}}
                                {{--                                                    <div class="invalid-feedback name-feedback">--}}
                                {{--                                                        <strong>{{$errors->has('branch_id')?$errors->first('branch_id'):''}}</strong>--}}
                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="col-3">--}}
                                {{--                                                <label>{{__('app.start')}}</label>--}}
                                {{--                                                <input type="date" name="start_date" class="form-control"--}}
                                {{--                                                       value="{{old('start_date')}}"/>--}}
                                {{--                                                <div class="invalid-feedback name-feedback">--}}
                                {{--                                                    <strong>{{$errors->has('start_date')?$errors->first('start_date'):''}}</strong>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="col-3">--}}
                                {{--                                                <label>{{__('app.end')}}</label>--}}
                                {{--                                                <input type="date" name="end_date" class="form-control"--}}
                                {{--                                                       value="{{old('end_date')}}"/>--}}
                                {{--                                                <div class="invalid-feedback name-feedback">--}}
                                {{--                                                    <strong>{{$errors->has('end_date')?$errors->first('end_date'):''}}</strong>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="col-3">--}}
                                {{--                                                <label>{{__('app.type')}}</label>--}}
                                {{--                                                <select class="form-control"  name='message_type'>--}}
                                {{--                                                    <option value="">@lang('app.all')</option>--}}
                                {{--                                                    <option--}}
                                {{--                                                        value="welcome" {{ request('message_type') == 'welcome' ? 'selected' : '' }}>@lang('app.Welcome')</option>--}}
                                {{--                                                    <option--}}
                                {{--                                                        value="invoice" {{ request('message_type') == 'invoice' ? 'selected' : '' }}>@lang('app.Invoice')</option>--}}
                                {{--                                                </select>--}}
                                {{--                                                <div class="invalid-feedback name-feedback">--}}
                                {{--                                                    <strong>{{$errors->has('message_type')?$errors->first('message_type'):''}}</strong>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="col-4" style="padding-top: 34px">--}}
                                {{--                                                <label for=""></label>--}}
                                {{--                                                <button type="submit" id="export_excel" data-type="xls"--}}
                                {{--                                                        class="btn btn-primary submit_form waves-effect waves-light">--}}
                                {{--                                                    <i class="fas fa-file-excel-o"></i> {{ __('app.ExportExcel') }}--}}
                                {{--                                                </button>--}}
                                {{--                                                <button type="submit" id="export_excel" data-type="pdf"--}}
                                {{--                                                        class="btn btn-primary submit_form waves-effect waves-light">--}}
                                {{--                                                    <i class="fas fa-file-pdf-o"></i> {{ __('app.ExportPdf') }}--}}
                                {{--                                                </button>--}}
                                {{--                                                <button type="submit" id="search" data-type="search"--}}
                                {{--                                                        class="btn btn-info submit_form waves-effect waves-light">--}}
                                {{--                                                    <i class="fas fa-search"></i> {{ __('app.Search') }}--}}
                                {{--                                                </button>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </form>--}}
                                {{--                                </div>--}}

                            </div>
                            <div class="tables text-center">
                                <div class="custom-table error-mg-table">

                                    <table id="paginationSimpleNumbers" class="table dataTable mt-4 table-striped"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="th-sm">#</th>
                                            <th class="th-sm">{{__('app.type')}}</th>
                                            <th class="th-sm">{{__('app.status')}}</th>
                                            <th class="th-sm">{{__('app.branch')}}</th>
                                            {{--                                            <th class="th-sm">{{__('app.message')}}</th>--}}
                                            <th class="th-sm">{{__('app.gym.plate_no')}}</th>
                                            <th class="th-sm">{{__('app.auth.phone')}}</th>
                                            <th class="th-sm">{{__('app.Invoice')}}</th>
                                            <th class="th-sm">{{__('app.createdIn')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($data) > 0)
                                            @foreach($data as $index=>$item)
                                                <tr>
                                                    <td>{{++$index}}</td>
                                                    <td>{{$item->type}}</td>
                                                    <td>{{$item->status}}</td>
                                                    <td>{{$item->branch ? $item->branch->name :''}}</td>
                                                    {{--                                                <td>{{$item->message}}</td>--}}
                                                    <td>{{$item->plateNumber}}</td>
                                                    <td>{{str_replace('whatsapp:+','',$item->phone)}}</td>
                                                    <td>
                                                        @if($item->invoiceUrl)
                                                            <a target="_blank" style="padding: 0 5px 0 5px"
                                                               href="{{config('app.azure_storage').config('app.azure_container').$item->invoiceUrl}}"
                                                               class="btn btn-info">
                                                                @lang('app.View')
                                                            </a>
                                                        @else --- @endif
                                                    </td>
                                                    <td>{{optional($item->created_at)->format('d-M-Y')}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-md-6">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-end mb-0">
                                                {!! $data->appends(request()->query())->links() !!}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Edit Modal -->
    @include("customer.errorsManagement.editModal")
    <!-- End Edit Modal -->
@endsection

@push("js")
    <script>
        $(document).ready(function () {

            var totalcount = "{{ __('app.Count') }}" + " " +"[ {{$totalcount}} ]";

            $('#paginationSimpleNumbers_wrapper').delegate().prepend('<div class="dataTables_length btn btn-info waves-effect waves-light">'+totalcount+ '</div>');

            /***** Tables Show ******/
            $('.tables-types-d .dropdown-item').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();

                $(this).closest('.tables-type ').find('.dropdown-item').removeClass('selected');
                $(this).addClass('selected');

                $('.error-mg-table table').removeClass().addClass('table');

                if ($(this).hasClass('table-1')) {
                    $('.error-mg-table table').addClass('theme-1');
                    setUserSetting('table_type', 1);
                } else if ($(this).hasClass('table-2')) {
                    $('.error-mg-table table').addClass('table-bordered');
                    setUserSetting('table_type', 2);
                } else if ($(this).hasClass('table-3')) {
                    $('.error-mg-table table').addClass('table-striped');
                    setUserSetting('table_type', 3);
                } else if ($(this).hasClass('table-4')) {
                    $('.error-mg-table table').addClass('table-striped table-dark');
                    setUserSetting('table_type', 4);
                }
            });
        });

        $("#select_branch").select2();


        $(window).scroll(function () {
            var aTop = $('.ad').height();
            if ($(this).scrollTop() >= 500) {
            }
        });


        $(".update-plate-btn").on("click", function (e) {
            var plate_ar = $(`#errorMangamentModal input[name=plate_ar]`).val();
            var plate_en = $(`#errorMangamentModal input[name=plate_en]`).val();
            var number_ar = $(`#errorMangamentModal input[name=number_ar]`).val();
            var number_en = $(`#errorMangamentModal input[name=number_en]`).val();
            var item_id = $(`#errorMangamentModal input[name=item_id]`).val();

            var errorTextMessage = "Sorry, looks like there are some errors detected, please try again.";
            var ConfirmButtonText = "Ok, got it!";
            var successTextMessage = "You have updated plate successfully.";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: $("#ErrorForm").serialize(),
                url: `${app_url}/customer/error-mangment/${item_id}/updatePlate`,
                dataType: "JSON",
                type: "POST",
                success: function (data) {
                    Swal.fire({
                        text: successTextMessage,
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: ConfirmButtonText,
                        customClass: {confirmButton: "btn fw-bold btn-primary"}
                    }).then((function () {
                        $("#errorMangamentModal").hide();
                        location.reload();
                    }))
                },
                error: function (data) {
                    console.log(data)
                    Swal.fire({
                        text: data.responseJSON ? data.responseJSON.message : errorTextMessage,
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: ConfirmButtonText,
                        customClass: {confirmButton: "btn btn-primary"}
                    })
                }
            })
        });


        function openEditModal(data) {
            var data = JSON.parse(data);
            $(`#errorMangamentModal input[name=plate_ar]`).val(data.char_ar);
            $(`#errorMangamentModal input[name=plate_en]`).val(data.char_en);
            $(`#errorMangamentModal input[name=number_ar]`).val(data.number_ar);
            $(`#errorMangamentModal input[name=number_en]`).val(data.number_en);
            $(`#errorMangamentModal input[name=item_id]`).val(data.id);
            $(`#errorMangamentModal #ErrorForm`).attr('action', `${app_url}/customer/error-mangment/${data.id}/updatePlate`);
            document.getElementById('screenshot_modal').src = data.path_screenshot ?? app_url + '/images/blank.png';
            $('#errorMangamentModal').modal('show');
        }

        $('.btn-filter').on('click', function () {
            $(this).closest('.filter-dropdown').find('.filter-content').toggleClass('open');
        })
        $(".filter-form").on("submit", function (e) {
            let select = $('#select_branch');
            if (!select.val()) {
                e.preventDefault();
                select.closest('.form-group').find('.invalid-feedback').show()
                select.closest('.form-group').find('.invalid-feedback').html('<strong>Please select branch</strog>')
            }
        })
        $('#select_branch').on('change', function () {
            $(this).closest('.form-group').find(".invalid-feedback").hide();
        });

    </script>
@endpush






