@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branchmodels.page_title.index')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="text-center">
                @if (session()->has('success'))
                    <div class="alert alert-success row" role="alert">
                        <div class="alert-head col-12">
                            <h3>{{ __('app.success') }} <small class="float-right"><i class="far fa-times-circle"></i></small></h3>
                        </div>
                        <div class="alert-body col-12" >
                            <p>{{ session('success') }}</p>
                        </div>

                    </div>
                @endif
                @if (session()->has('danger'))
                    <div class="alert alert-danger" role="alert" style="height: 65px; min-width: 350px">
                        <div class="alert-head col-12">
                            <h3 class="pt-3 pl-1">{{ session('danger') }} <small class="float-right"><i class="far fa-times-circle"></i></small></h3>
                        </div>
                        <div class="alert-body col-12" >
                            <p>{{ session('fail') }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.customers.branchmodels.page_title.index')}}</h4>
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

                                    </div>
                                    @can('create-branchmodels')
                                        @if(auth()->user()->type=="customer")
                                    <div class="col-sm-12 col-md-6">
                                        <div class="user-list-files d-flex float-right">
                                            <a class="iq-bg-primary" href="{{route('branchmodels.create')}}" >
                                                <i class="ri-user-add-line"></i> &nbsp;{{__('app.customers.branchmodels.create_new')}}
                                            </a>

                                        </div>
                                    </div>
                                        @endif
                                    @endcan
                                </div>
                                <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                                    <thead>
                                    <tr>
                                        <th>{{__('app.customers.branchmodels.table.model')}}</th>
                                        <th>{{__('app.customers.branchmodels.table.branch')}}</th>
                                        <th>{{__('app.customers.branchmodels.table.active')}}</th>
                                        <th>{{__('app.customers.branchmodels.table.created_at')}}</th>
                                        <th>{{__('app.customers.branchmodels.table.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="searchfeatureresult">
                                    @foreach($items as $item)
                                        <tr id="row{{$item->id}}">
                                            <td>{{$item->mname}}</td>
                                            <td>{{$item->bname}}</td>
                                            <td>{{$item->active==1 ? 'True':'False'}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    @if(auth()->user()->type=="customer")
                                                    <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show Model"   href="{{ route('branchmodels.show',[$item->id]) }}"><i class="fa fa-eye"></i></a>
                                                    @can('edit-branchmodels')
                                                    <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ route('branchmodels.edit',[$item->id]) }}"><i class="ri-pencil-line"></i></a>
                                                    @endcan
                                                        @can('delete-branchmodels')
                                                    <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="delete_alert({{ $item->id }});" ><i class="ri-delete-bin-line"></i></a>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                            <div class="row justify-content-between mt-3">
                                <div id="user-list-page-info" class="col-md-6">
                                    <span>{{ __('app.Showing') }} 1 {{ __('app.to') }} {{count($items)}} of {{count($items)}} {{ __('app.entries') }}</span>
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
                    <h5 class="modal-title">{{__('app.customers.branchmodels.delete')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('app.customers.branchmodels.delete_message')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.customers.branchmodels.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="delete_option('customer/branchmodels');">{{__('app.customers.branchmodels.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
