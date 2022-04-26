@extends('layouts.dashboard.index')
@push('css')
    <style>

        /* It's supposed to look like a tree diagram */
        .tree, .tree ul, .tree li {
            list-style: none;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .tree {
            margin: 0 0 1em;
            text-align: center;
            width: 100%;
        }

        .tree, .tree ul {
            display: table;

        }

        .tree ul {
            width: 100%;
        }

        .tree li {
            display: table-cell;
            padding: .5em 0;
            vertical-align: top;
        }

        /* _________ */
        .tree li:before {
            outline: solid 1px #666;
            content: "";
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
        }

        .tree li:first-child:before {
            left: 50%;
        }

        .tree li:last-child:before {
            right: 50%;
        }

        .tree code, .tree span {
            border: solid .1em #666;
            border-radius: .2em;
            display: inline-block;
            margin: 0 .2em .5em;
            padding: .2em .5em;
            position: relative;
        }

        /* If the tree represents DOM structure */
        .tree code {
            font-family: monaco, Consolas, 'Lucida Console', monospace;
        }

        /* | */
        .tree ul:before,
        .tree code:before,
        .tree span:before {
            outline: solid 1px #666;
            content: "";
            height: .5em;
            left: 50%;
            position: absolute;
        }

        .tree ul:before {
            top: -.5em;
        }

        .tree code:before,
        .tree span:before {
            top: -.55em;
        }

        /* The root node doesn't connect upwards */
        .tree > li {
            margin-top: 0;
        }

        .tree > li:before,
        .tree > li:after,
        .tree > li > code:before,
        .tree > li > span:before {
            outline: none;
        }
    </style>

@endpush
@section('page_title')
    {{__('app.positions')}}
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="text-center alert-cont">
            </div>
            <div class="row col-12 p-0 m-0 text-right d-block mb-2">
                @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin" && count($trashs))
                    <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                            data-target="#RecycleBin">
                        <i class="fas fa-recycle"></i> {{ __('app.Recycle_Bin') }}
                    </button>
                @endif

            <!-- Modal -->
                <div class="modal fade" id="RecycleBin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('app.Actions_in_Users') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="trash_form">
                                    @csrf
                                    <div class="col-12 mb-2">
                                        <button type="submit" style="display: none"
                                                class="restore_all btn btn-sm btn-primary mr-1"><i
                                                class="fas fa-recycle"></i> {{__('app.restore_all')}}</button>
                                        <button type="submit" style="display: none"
                                                class="remove_all btn btn-sm btn-danger"><i
                                                class="fas fa-trash"> </i>{{__('app.delete_all')}}</button>
                                    </div>

                                    <table style="width: 100%;" class="table dataTable table-bordered text-center">

                                        <thead class="bg-primary">
                                        <td>
                                            <label for="selectall" class="custom-checkbox pl-1">
                                                <input type="checkbox" id="selectall" class="selectall"/>
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <th>{{__('app.Name')}}</th>
                                        <th>{{__('app.description')}}</th>
                                        <th>{{__('app.users_count')}}</th>
                                        <th>{{ __('app.Settings') }}</th>
                                        </thead>
                                        <tbody class="trashbody">

                                        @foreach($trashs as $trash)
                                            <tr>
                                                <td>
                                                    <label for="{{$trash->id}}" class="custom-checkbox pl-1">
                                                        <input class="trashselect" type="checkbox" name="trashs[]"
                                                               id="{{$trash->id}}" value="{{$trash->id}}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>{{$trash->name}}</td>
                                                <td>{{$trash->description}}</td>
                                                <td>{{$trash->users_count??'---'}}</td>
                                                <td style='white-space: nowrap'>
                                                    <button style="display: inline-block" type="submit"
                                                            class="trash_restore btn btn-sm btn-primary"
                                                            style="color: white;"><i
                                                            class="fas fa-recycle"></i> {{__('app.Restore')}}</button>
                                                    <button style="display: inline-block" type="submit"
                                                            class="trash_delete btn btn-sm btn-danger"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Delete"><i
                                                            class="fas fa-trash"></i> {{__('app.customers.branches.delete')}}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                        data-dismiss="modal">{{ __('app.Cancel') }}</button>
                                <button type="button" class="btn btn-primary">{{ __('app.Apply') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                @if(in_array(auth()->user()->type,['customer','subadmin']))
                    <a class="btn btn-primary" href="{{route('positions.create')}}">
                        <i class="fa fa-plus"></i> {{__('app.add_new_position')}}
                    </a>
                @endif
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body Regions">
                            @if(count($positions))
                                <figure>{!! $tree !!}</figure>
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

    <!-- myModalDelete -->
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
                            onclick="delete_option('customer/positions');">{{__('app.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('.selectall').on('click', function () {
                $(this).closest('.table').find('.trashbody .trashselect').prop('checked', $(this).prop('checked'));
                $('.restore_all').toggle();
                $('.remove_all').toggle();
            });

            $('.trashbody .trashselect').on('click', function () {
                var checked = $(".trashbody input[type=checkbox]:checked").length;
                if (checked > 1) {
                    $('.restore_all').show();
                    $('.remove_all').show();
                } else {
                    $('.restore_all').hide();
                    $('.remove_all').hide();
                }
            });

            $('.restore_all').on('click', function () {
                $("#trash_form").attr('action', app_url + "/customer/positions/bulkRestore");
            });
            $('.trash_restore').on('click', function (e) {
                e.preventDefault();
                $(this).parent('td').siblings().find('.trashselect').prop('checked', 'checked');
                $("#trash_form").attr('action', app_url + "/customer/positions/bulkRestore");
                $("#trash_form").submit();
            });
            $('.remove_all').on('click', function () {
                $("#trash_form").attr('action', app_url + "/customer/positions/bulkDelete");
            });
            $('.trash_delete').on('click', function (e) {
                e.preventDefault();
                $(this).parent('td').siblings().find('.trashselect').prop('checked', 'checked');
                $(this).closest('.trashselect').prop('checked', 'checked');
                $("#trash_form").attr('action', app_url + "/customer/positions/bulkDelete");
                $("#trash_form").submit();
            });
        });
    </script>

@endpush
