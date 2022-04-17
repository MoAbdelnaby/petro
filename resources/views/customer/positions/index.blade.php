@extends('layouts.dashboard.index')

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
                @if(auth()->user()->type=="customer" || auth()->user()->type==" subadmin" && count($trashs))
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
                                        <th>{{__('app.table')}}</th>
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
                                                <td>{{$trash->users_count}}</td>
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

                @can('create-CustomerBranches')
                    @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin")
                        <a class="btn btn-primary" href="{{route('positions.create')}}">
                            <i class="fa fa-plus"></i> {{__('app.new_position')}}
                        </a>
                    @endif
                @endcan
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body Regions">

                            <div class="row">
                                <div class="col-sm-12 mt-3 related-product">
                                    <div class="related-product-block position-relative">
                                        <div class="product_table table-responsive row p-0 m-0 col-12">
                                            <table class="table dataTable ui celled table-bordered text-center">
                                                <thead>
                                                <th>{{ __('app.Name') }}</th>
                                                <th>{{ __('app.description') }}</th>
                                                <th>{{ __('app.users_count') }}</th>
                                                <th>{{ __('app.parent') }}</th>
                                                <th>{{ __('app.Settings') }}</th>
                                                </thead>
                                                <tbody>
                                                @foreach($items as $item)
                                                    <tr class="item{{$item->id}}">
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->description}}</td>
                                                        <td>{{$item->users_count}}</td>
                                                        <td>{{optional($item->parentPosition)->name??'----'}}</td>
                                                        <td>
                                                            @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin")
                                                                <a class="btn btn-sm btn-info"
                                                                   href="{{ route('positions.edit',[$item->id]) }}">
                                                                    <i class="fas fa-edit"></i> {{__('app.edit')}}
                                                                </a>
                                                                <a class="btn btn-sm btn-danger"
                                                                   style="cursor: pointer;" data-toggle="tooltip"
                                                                   data-placement="top" title=""
                                                                   data-original-title="Delete"
                                                                   onclick="delete_alert({{ $item->id }});"><i
                                                                        class="fas fa-trash-alt"></i> {{__('app.delete')}}
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
