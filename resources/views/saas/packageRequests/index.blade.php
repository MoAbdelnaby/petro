@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.side_bar.saas_control.packageRequests')}}
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
                    @if (session()->has('danger'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('danger') }}
                        </div>
                    @endif
                    @if (session()->has('start_date'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('start_date') }}
                        </div>
                    @endif
                    @if (session()->has('end_date'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('end_date') }}
                        </div>
                    @endif
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.side_bar.saas_control.packageRequests')}}</h4>
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


                                </div>
                                <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                                    <thead>
                                    <tr>
                                        <th>{{__('app.saas.packages.user')}}</th>
                                        <th>{{__('app.saas.packages.package_name')}}</th>
                                        <th>{{__('app.saas.models.table.is_active')}}</th>
                                        <th>{{__('app.saas.models.table.created_at')}}</th>
                                        <th>{{__('app.saas.models.table.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr id="row{{$item->id}}">
                                            <td>{{$item->user->name}}</td>
                                            <td>{{$item->package->name}}</td>
                                            <td>{{$item->active==1 ? 'True':'False'}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">

                                                        <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assign user" onclick="assign_customer_to_package({{ $item->package_id}},{{$item->user_id }},{{$item->id }});"><i class="ri-user-add-line"></i></a>


                                                    <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="delete_alert({{ $item->id }});" ><i class="ri-delete-bin-line"></i></a>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                            <div class="row justify-content-between mt-3">
                                <div id="user-list-page-info" class="col-md-6">
{{--                                    <span>Showing 1 to {{count($items)}} of {{count($items)}} entries</span>--}}
                                    <span>{{ __('app.Showing') }} 1 {{ __('app.to') }} {{count($items)}} {{ __('app.of') }} {{count($items)}} {{ __('app.entries') }}</span>

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
    <div id="myModalDelete" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.saas.models.delete')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('app.saas.models.delete_message')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.saas.models.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="delete_option('saas/packageRequests');">{{__('app.saas.models.delete')}}</button>
                </div>
            </div>
        </div>
    </div>




    <!-- myModalAssign -->
    <div id="myModalAssign" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.customers.branchmodels.page_title.create')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{ route('packageRequests.assignUser') }}" id="assignForm">
                        @csrf
                        <div class="row">



                            <input type="hidden" name="request_id" id="request_id">
                            <input type="hidden" name="package_id" id="package_id">
                            <input type="hidden" name="user_id" id="user_id">

                            <div class="form-group col-md-12">
                                <label for="start_date">{{__('app.saas.packages.table.start_date')}} *</label>
                                <input required type="date" min="{{date('Y-m-d')}}" name="start_date" class="form-control mindate" id="start_date" placeholder="{{__('app.saas.packages.table.start_date')}}" value="{{ old('start_date') }}">
                                @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="end_date">{{__('app.saas.packages.table.end_date')}} *</label>
                                <input required type="date" min="{{date('Y-m-d')}}" name="end_date" class="form-control mindate" id="end_date" placeholder="{{__('app.saas.packages.table.end_date')}}" value="{{ old('end_date') }}">
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>











                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.customers.branches.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="submit_form('assignForm');">{{__('app.customers.branchmodels.save')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

