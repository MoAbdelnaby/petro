@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.gym.car_Plates')}}
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

                <div class="col-sm-12">
                    <div class="iq-card mt-4 mb-4">
                        <div class="iq-card-body">
                            <div class="related-heading plates-car-cont">
                                <div class="d-flex justify-content-between align-items-center border-bottom">
                                    <h2 class="border-bottom-0" style="text-transform: capitalize;">
                                        {{ __('app.Plates_Car_Errors') }}
                                    </h2>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="fas fa-bars" style=""></i>
                                        </a>
                                        <ul class="dropdown-menu main-dropdown chart-type tables-type tables-types-d">
                                            <li>
                                                <a tabindex="-1"
                                                   class="dropdown-item table-1
                                                                  {{ $userSettings ? ($userSettings->table_type == "1" ? 'selected' : '') :'selected' }}"
                                                   href="#">
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
                                <div class=" my-4">
                                    <form method="get" action="{{route('error_mangment.index',9)}}" class="d-flex">
                                        @csrf
                                        <div class=" col-12 col-md-4" id="filter_branch" >
                                            <!-- <lebel class="">Select branches:</lebel> -->
                                            <select class="form-control" id="select_branch" name="branch_id">
                                                <option value="" selected>{{ __('app.All_Branches') }}</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}"
                                                     @if(request('branch_id') != null) {{request('branch_id') == $branch->id ? 'selected' : ''}} @endif>{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light px-4 py-2">{{ __('app.Search') }}</button>

                                    </form>


                                    {{--@include('customer.errorsManagement._filter',['type' => 'plate'])--}}
                                </div>

                            </div>
                            <div class="tables text-center">
                                <div class="custom-table error-mg-table">
                                    <table id="paginationSimpleNumbers"
                                           class="table mt-4 table-striped dataTable"
                                           width="100%">
                                        <thead>
                                        <tr>

                                            <th class="th-sm">{{__('app.branch')}}</th>
                                            <th class="th-sm">{{__('app.gym.check_in_date')}}
                                            </th>
                                            <th class="th-sm">{{__('app.gym.check_out_date')}}
                                            </th>
                                            <th class="th-sm">{{__('app.gym.Area')}}
                                            </th>
                                            <th class="th-sm">{{__('app.gym.plate_no_ar')}}
                                            </th>
                                            <th class="th-sm">{{__('app.gym.plate_no_en')}}
                                            </th>
                                            <th class="th-sm">{{ __('app.Status') }}
                                            </th>
                                            <th class="th-sm">{{ __('app.Actions') }}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $item)
                                            <tr class="record" id="{{$item->path_screenshot}}">
                                                <td>{{$item->branch}}</td>
                                                <td>{{$item->checkInDate}}</td>
                                                <td>{{$item->checkOutDate}}</td>
                                                <td class="open">{{ __('app.gym.Area').' '.$item->BayCode}}</td>
                                                <td class="open">{{$item->plate_ar}}</td>
                                                <td class="open">{{$item->plate_en}}</td>
                                                <td class="open">
                                                    @if($item->plate_status == 'error')
                                                        <span class="badge badge-pill badge-danger">{{ __('app.Error') }}</span>
                                                    @elseif($item->plate_status == 'reported')
                                                        <span class="badge badge-pill badge-warning">{{ __('app.Reported') }}</span>
                                                    @elseif($item->plate_status == 'modified')
                                                        <span class="badge badge-pill badge-success">{{ __('app.Modified') }}</span>
                                                    @endif
                                                </td>
                                                <td class="open">
                                                    <a title="Edit" class="btn btn-info"
                                                       onclick="openEditModal('{{json_encode($item)}}')">
                                                        <i class="fas fa-edit mr-0"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>

                                    </table>
                                </div>

{{--                                <nav aria-label="Page navigation example">--}}
{{--                                    <ul class="pagination pg-blue">--}}
{{--                                        @if($data != [])--}}
{{--                                            {!! $data->appends(request()->query())->links() !!}--}}

{{--                                        @endif--}}
{{--                                    </ul>--}}
{{--                                </nav>--}}
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


                var errorTextMessage    = "Sorry, looks like there are some errors detected, please try again.";
                var ConfirmButtonText   = "Ok, got it!";
                var successTextMessage  = "You have updated plate successfully.";

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
                        // console.log(data)
                        Swal.fire({
                            text: data.responseJSON?data.responseJSON.message:errorTextMessage,
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
            console.log(data)
            $(`#errorMangamentModal input[name=plate_ar]`).val(data.char_ar);
            $(`#errorMangamentModal input[name=plate_en]`).val(data.char_en);
            $(`#errorMangamentModal input[name=number_ar]`).val(data.number_ar);
            $(`#errorMangamentModal input[name=number_en]`).val(data.number_en);
            $(`#errorMangamentModal input[name=item_id]`).val(data.id);
            $(`#errorMangamentModal #ErrorForm`).attr('action', `${app_url}/customer/error-mangment/${data.id}/updatePlate`);
            document.getElementById('screenshot_modal').src = data.path_screenshot ?? app_url + '/images/blank.png';
            $('#errorMangamentModal').modal('show');

            console.log(data.char_ar.length, data.char_ar)
            var tempCharAR = data.char_ar.replace(/ /g,'');
            var tempCharEN = data.char_en.replace(/ /g,'');
            var tempNumAR = data.number_ar.replace(/ /g,'');
            var tempNumEn = data.number_en.replace(/ /g,'');

            console.log(tempCharAR, tempCharEN, tempNumAR, tempNumEn)
            for (var i=0; i<5; i++){
                $($('.digits[data-info="number_ar"] .input-group input')[i]).val(tempNumAR[i]);
                $($('.digits[data-info="plate_ar"] .input-group input')[i]).val(tempCharAR[i]);
                $($('.digits[data-info="number_en"] .input-group input')[i]).val(tempNumEn[i]);
                $($('.digits[data-info="plate_en"] .input-group input')[i]).val(tempCharEN[i]);
            }
        }

        function replaceFarsiNumber(input) {
            const english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const farsi = ['۰', '۱', '۲', '۳', '٤', '۵', '٦', '۷', '۸', '۹'];

            for (var i = 0; i < english.length; i++) {
                input = input.replaceAll(english[i], farsi[i]);
            }

            return input;
        }

        $('.digit').on('keyup',function (){

            var ennumbers = "0123456789";
            var arnumbers = "۰۱۲۳٤۵٦۷۸۹";
            // $(this).next().focus();
            var val = $(this).val();
            var parent = $(this).closest('.form-group').attr('data-info');

            if(parent == "number_ar"){
                if (arnumbers.search(val) > -1){
                    $(this).next().focus();
                    // $('#number_ar').val += val;
                    setInputValue($(this), '#number_ar');

                }
                else if(ennumbers.search(val) > -1) {
                    $(this).val(replaceFarsiNumber(val));
                    $(this).next().focus();
                    setInputValue($(this), '#number_ar');
                }
                else {
                    $('span.info-patter').fadeOut();
                    $(this).closest('.digits').find('span.info-patter').fadeIn();
                    $(this).val('');
                }
            }
            else if(parent == "plate_ar"){

                var isArabic = /[\u0600-\u06FF\u0750-\u077F]/;
                if (isArabic.test(val)){
                    $(this).next().focus();
                    setInputValue($(this), '#plate_ar');

                }
                else {
                    $('span.info-patter').fadeOut();
                    $(this).closest('div.digits').find('span.info-patter').fadeIn();
                    $(this).val('');
                }

            }
            else if(parent == "plate_en"){
                const regex = /[A-Za-z]/;
                if(regex.test(val)){
                    $(this).next().focus();
                    setInputValue($(this), '#plate_en');

                }
                else{
                    $('span.info-patter').fadeOut();
                    $(this).closest('div.digits').find('span.info-patter').fadeIn();
                    $(this).val('');
                }
            }
            else if(parent == "number_en"){
                if (ennumbers.search(val) > -1){
                    $(this).next().focus();
                    setInputValue($(this), '#number_en');

                }
                else {
                    $('span.info-patter').fadeOut();
                    $(this).closest('.digits').find('span.info-patter').fadeIn();
                    $(this).val('');
                }

            }
        });

        info();
        function info (){
            $('.digits label i.fa-info-circle').on('click', function (){
                $('span.info-patter').fadeOut();
                $(this).closest('.digits').find('span.info-patter').fadeIn();
                setTimeout(function(){
                    $('span.info-patter').fadeOut()
                }, 3000)
            })
        }

        function setInputValue(ele, input){
            var text="";
            inputs = ele.closest('.digits').find('input.digit');
            for(var i=0; i < inputs.length; i++){
                text = text + $(inputs[i]).val();
            }
            $(input).val(text);
        }


    </script>
@endpush






