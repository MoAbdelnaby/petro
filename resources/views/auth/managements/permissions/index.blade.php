@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.permissions.permission_title')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="text-center" style="width:400px; margin:0 auto;">
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.permissions.permission_title')}}</h4>
                            </div>
                        </div>
                        <div class="text-center" style="width:400px; margin:0 auto;">

                            <div class="alert text-white bg-danger errdiv" role="alert" style="display: none;">
                                <div class="iq-alert-icon">
                                    <i class="ri-information-line"></i>
                                </div>
                                <div class="iq-alert-text err"></div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>

                        </div>

                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <div class="row justify-content-between">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="user_list_datatable_info" class="dataTables_filter">
                                            <form class="mr-3 position-relative">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" id="generalpermissionSearch" placeholder="{{__('app.permissions.search')}}" aria-controls="user-list-table">
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
{{--                                        <div class="user-list-files d-flex float-right">--}}
{{--                                            <a class="iq-bg-primary" href="{{route('permissions.create')}}" >--}}
{{--                                                <i class="ri-user-add-line"></i> &nbsp;{{__('app.permissions.create_new')}}--}}
{{--                                            </a>--}}

{{--                                        </div>--}}
                                    </div>
                                </div>
                                <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                                    <thead>
                                    <tr>
                                        <th>{{__('app.permissions.table.name')}}</th>
                                        <th>{{__('app.permissions.table.guard')}}</th>
                                        <th>{{__('app.permissions.table.display_name')}}</th>
                                        <th>{{__('app.permissions.table.group')}}</th>
                                        <th>{{__('app.permissions.table.created_at')}}</th>
                                        <th>{{__('app.permissions.table.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="searchpermissionresult">
                                    @foreach($items as $item)
                                        <tr id="row{{$item->id}}">
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->guard_name}}</td>
                                            <td>{{$item->display_name}}</td>
                                            <td>{{$item->group }}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    @can('edit-permissions')
                                                         <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ route('permissions.edit',[$item->id]) }}"><i class="ri-pencil-line"></i></a>
                                                    @endcan
                                                    @can('delete-permissions')
                                                          <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="delete_alert({{ $item->id }});" ><i class="ri-delete-bin-line"></i></a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                            <div class="row justify-content-between mt-3">
                                <div id="user-list-page-info" class="col-md-6">
                                    <span>Showing 1 to {{count($items)}} of {{count($items)}} entries</span>
                                </div>

                                <div class="col-md-6">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end mb-0">
                                            {{ $items->links() }}
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





    <!-- myModalDelete -->
    <div id="myModalDelete" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.permissions.delete')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('app.permissions.delete_message')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.permissions.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="delete_option('auth/permissions');">{{__('app.permissions.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
