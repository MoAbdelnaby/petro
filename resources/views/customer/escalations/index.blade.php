@extends('layouts.dashboard.index')

@push('css')
    <style>
        .treeItem {
            width: 350px;
            height: 135px;
            border: 1px solid #ccc;
            padding: 0 10px;
            border-radius: 5px;
            background: #1b075c;
            position: relative;
            margin-bottom: 20px;
        }

        .treeItem h4 {
            line-height: 40px;
            color: #fff;
            font-size: 18px;
            text-align: center;
            font-weight: bold;
        }

        .treeItem h4 span {
            display: block;
            font-size: 14px;
        }

        .treeItem h4 span i {
            font-size: 45px;
        }

        .odd-row .treeItem .AddNew {
            width: 60px;
            height: 60px;
            border: 3px solid #ad2cca;
            display: none;
            position: absolute;
            top: 35px;
            right: -30px;
            z-index: 10;
            text-align: center;
            line-height: 60px;
            background: #fff;
            font-size: 32px;
            color: #ad2cca;
            transform: rotate(-45deg);
            transition: all ease-in-out .4s;
            cursor: pointer;
        }

        .even-row .treeItem .AddNew {
            width: 60px;
            height: 60px;
            border: 3px solid #ad2cca;
            display: none;
            position: absolute;
            top: 35px;
            left: -30px;
            z-index: 10;
            text-align: center;
            line-height: 60px;
            background: #fff;
            font-size: 32px;
            color: #ad2cca;
            transform: rotate(-45deg);
            transition: all ease-in-out .4s;
            cursor: pointer;
        }

        .AddNew i {
            border: 0px solid #ad2cca;
            display: block;
            height: 100%;
            line-height: 50px;
            transform: rotate(45deg);

        }

        .treeItems .AddNew {
            display: none;
        }

        .treeItems .col-12.row:last-child .AddNew:last-child {
            display: block;
        }

        .odd-row .delete-item {
            border-radius: 34px;
            font-size: 14px;
            position: absolute;
            left: 10px;
            top: 10px;
            width: 37px;
            height: 37px;
            text-align: center;
            line-height: 34px;
            color: #fff;
            background: #8e0000;
            cursor: pointer;
            box-shadow: 0 0 5px #ffffff;
            display: none;
        }

        .even-row .delete-item {
            border-radius: 34px;
            font-size: 14px;
            position: absolute;
            right: 10px;
            top: 10px;
            width: 37px;
            height: 37px;
            text-align: center;
            line-height: 34px;
            color: #fff;
            background: #8e0000;
            cursor: pointer;
            box-shadow: 0 0 5px #ffffff;
            display: none;
        }

        .treeItem:hover .delete-item {
            display: block;
        }

        .odd-row .treeItem:after {
            content: "";
            width: 40px;
            height: 40px;
            position: absolute;
            display: block;
            z-index: 1;
            background: #1b075c;
            top: 47px;
            right: -21px;
            border: 1px solid #fff;
            transform: rotate(45deg);
        }

        .even-row .treeItem:after {
            content: "";
            width: 40px;
            height: 40px;
            position: absolute;
            display: block;
            z-index: 1;
            background: #1b075c;
            top: 47px;
            left: -21px;
            border: 1px solid #fff;
            transform: rotate(45deg);
        }

        .pr-100px {
            padding-right: 100px;
        }

        .endRowTree {
            width: 145px;
            position: relative;
        }

        .endRowTree .endrowItem {
            content: '';
            width: 100%;
            height: 290px;
            border: 1px solid #ccc;
            padding: 0 10px;
            background: #1b075c;
            position: absolute;
            border-radius: 0 145px 145px 0;
        }

        .endRowTree:nth-child(1) .endrowItem {
            border-radius: 145px 0 0 145px;
            /* margin-top: 155px; */
        }

        .endRowTree .endrowItem::after {
            content: '';
            width: 20px;
            height: 22px;
            background: #fff;
            z-index: 11;
            display: block;
            border-radius: 50%;
            position: absolute;
            top: 133px;
            left: -10px;
        }

        .endRowTree:nth-child(1) .endrowItem::after {
            content: '';
            width: 20px;
            height: 22px;
            background: #fff;
            z-index: 11;
            display: block;
            border-radius: 50%;
            position: absolute;
            top: 133px;
            right: -10px;
            left: auto
        }

        .treeItems .row.col-12 {
            /* margin-top: -135px!important; */
        }

        .treeItems .row.col-12:first-child {
            margin-top: 0 !important;
        }

        .even-row {
            direction: rtl;
        }

        .treeItem select {
            word-wrap: normal;
            background: none;
            color: #fff;
            border: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .treeItem select option {
            color: #1b075c
        }

        .treeItem select option::selection {
            background-color: #1b075c;
        }

        .rowTree:nth-child(1) .treeItem:first-child:hover .delete-item {
            display: none;
        }

        #saveEscalation {
            display: inline-block;
            line-height: 40px;
            padding: 0 15px;
            background: #1b075c;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>
@endpush
@section('page_title') {{__('app.escalation')}} @endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="treeItems">


                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.escalation')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body p-2">
                            @if(count($positions))
                                <div class="row pb-5 px-2">
                                    <div class="endRowTree left">
                                        {{-- <div class="endrowItem"></div> --}}
                                    </div>

                                    <div class="row col p-0 mx-auto">

                                    </div>

                                    <div class="endRowTree right">
                                        {{-- <div class="endrowItem"></div> --}}
                                    </div>
                                    <div class="col-12 text-center mt-5">
                                        <span id="saveEscalation">@lang('app.save')</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-center col-12 p-5">
                                    <h3 class="mb-5">
                                        <i class="fa fa-sitemap"></i>
                                        @lang('app.no_position_found')
                                    </h3>
                                    <a class="btn btn-info" href="{{route('positions.create')}}">
                                        <i class="fa fa-plus"></i> {{__('app.add_new_position')}}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModalDelete" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-danger"><i class="far fa-question-circle"></i> {{__('app.Confirmation')}}</h3>
                    <h5> {{__('app.delete_message')}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{__('app.close')}}</button>
                    <button type="button" class="btn btn-danger"
                            onclick="delete_option('customer/escalations');">{{__('app.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var escalations = [];
            @if(count($escalations))
                escalations = @json($escalations);
            @else
                escalations = [{position: 0, time: 60}];
            @endif

            drawTree(escalations);

            // remove item
            $('.row.col').delegate('.delete-item', 'click', function () {
                var index = $(this).parents('.treeItem').attr('data-array');
                escalations.splice(index,1);
                drawTree(escalations);
            });

            // AddNew item
            $('.row.col').delegate('.AddNew', 'click', function () {
                escalations.push({position: 0, time: 60});
                drawTree(escalations);
            });

            $('.treeItems').delegate('.treeItem select.position', 'change', function () {
                let index = $(this).parents('.treeItem').attr('data-array');
                escalations[index].position = $(this).val();
                drawTree(escalations);
            });

            $('.treeItems').delegate('.treeItem select.min', 'change', function () {
                let index = $(this).parents('.treeItem').attr('data-array');
                escalations[index].time = $(this).val();
                drawTree(escalations);
            });

            

            $("#saveEscalation").on('click', function (e) {
                e.preventDefault();
                let url = "{{route('escalations.store')}}";
                let token = "{{csrf_token()}}";
                let items = JSON.stringify(escalations);

                let inputs = `<input name="_token" value=${token}>`;
                inputs += `<input name="items" value=${items}>`;

                $(`<form method="post" action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
            });
        });

        function drawTree(escalations) {
            let positions = @json($positions);

            $('.rowTree').remove();
            $('.endRowTree .endrowItem').remove();

            let countRows1 = escalations.length / 4;
            var i;
            // console.log(Math.ceil(countRows1));
            for (var r = 1; r <= Math.ceil(countRows1); r++) {
                if (r % 2 == 0) {
                    var clas = "even-row";
                } else {
                    var clas = "odd-row";
                }

                $('.row.col').append(`<div class="col-12 ` + clas + ` rowTree row p-0 m-0 2020"></div>`);
            }
            for (var i = 1; i <= escalations.length; i++) {
                var ItemHtml = `<div data-array="` + (i - 1) + `" class="treeItem col-3">` +
                    `<span class="delete-item">` +
                    `<i class="fa fa-trash"></i>` +
                    `</span>` +
                    `<h4>` +
                    `<select class="position" name="" id="">` +
                    `<option value="" selected>Select Position</option>`;
                for (let j = 0; j < positions.length; j++) {
                    ItemHtml += `<option ` + (escalations[i - 1].position == positions[j].id ? 'selected' : '') + ` value="` + positions[j].id + `">` + positions[j].name + `</option>`;
                }

                ItemHtml +=
                    `</select>` +
                    `<span class="time">` +
                    `<i class="fa fa-stopwatch"></i>` +
                    `<span>` +
                    `<select class="min" name="" id="">` +
                    `<option ` + (escalations[i - 1].time == 15 ? 'selected' : '') + ` value="15">15 Min</option>` +
                    `<option ` + (escalations[i - 1].time == 30 ? 'selected' : '') + ` value="30">30 Min</option>` +
                    `<option ` + (escalations[i - 1].time == 60 ? 'selected' : '') + ` value="60">1 hour</option>` +
                    `<option ` + (escalations[i - 1].time == 90 ? 'selected' : '') + ` value="90">Hour & half</option>` +
                    `<option ` + (escalations[i - 1].time == 120 ? 'selected' : '') + ` value="120">2 Hours</option>` +
                    `</select>` +
                    `</span>` +
                    `</span>` +
                    `</h4>` +
                    `</div>`;
                $('.row.col .row.col-12:nth-child(' + Math.ceil(i / 4) + ')').append(ItemHtml);

                if (i % 4 == 0)
                if ((i/4) % 2 == 0) {
                    var clas = "even-row";
                    $('.endRowTree.left').append('<div class="endrowItem" style="top:' + (((i/4) - 1) * 155) + 'px"></div>');                    
                } else {
                    var clas = "odd-row";
                    $('.endRowTree.right').append('<div class="endrowItem" style="top:' + (((i/4) - 1) * 155) + 'px"></div>');                    
                }

            }

            var addNew = `<span class="AddNew">` +
                `<i class="fa fa-layer-plus"></i>` +
                `</span>`;

            $('.treeItem .AddNew').remove();
            $('.treeItem:last-child').append(addNew);
        }

        // function drawEndRow(escalations) {
            
        //     $('.endRowTree .endrowItem').remove();
        //     let countRows1 = escalations.length / 4;
        //     console.log(countRows1 % 1);
        //     if (escalations.length % 4 == 0 && countRows1 % 1 == 0) {
        //         for (let r = 1; r <= Math.ceil(countRows1); r++) {
        //             if (r % 2 == 0) {
        //                 $('.endRowTree.left').append('<div class="endrowItem" style="top:' + ((r - 1) * 155) + 'px"></div>');
        //             } else {
        //                 $('.endRowTree.right').append('<div class="endrowItem" style="top:' + ((r - 1) * 155) + 'px"></div>');
        //             }
        //         }
        //     }
        // }
    </script>
@endpush
