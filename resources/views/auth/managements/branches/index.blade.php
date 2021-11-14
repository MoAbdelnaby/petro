@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.branches.page_title.index')}}
@endsection
@section('breadcrumbs')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{route('branches.index',[$user_id])}}" class="kt-subheader__breadcrumbs-link">
        {{__('app.branches.permission_title')}} </a>
@endsection
@section('content')
    @push('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    @include('auth.managements.branches.create_modal')
    @include('auth.managements.branches.update_modal')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('app.branches.permission_title')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">

                    <a href="{{route('home')}}" class="btn btn-clean btn-bold btn-upper btn-font-sm">
                        <i class="la la-long-arrow-left"></i>
                        {{__('app.branches.back')}}
                    </a>
                    <button data-toggle="modal" data-target=".create-language"  class="btn btn-default btn-bold btn-upper btn-font-sm create-language-btn">
                        <i class="flaticon2-add-1"></i>
                        {{__('app.branches.create_new')}}
                    </button>
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="g-errors">
            </div>
            <!--begin: Search Form -->
            <div class="kt-form kt-fork--label-right kt-margin-t-20 kt-margin-b-10">
                <div class="row">
                    <div class="col-xl-4 order-2 order-xl-1">
                        <div class="row">
                            <div class="col-md-12 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-input-icon kt-input-icon--left">
                                    <input type="text" class="form-control form-control-md" placeholder="{{__('app.branches.search')}}"
                                           id="generalSearch">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        <!--end: Search Form -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Selected Rows Group Action Form -->
            <div class="kt-form kt-fork--label-align-right collapse" id="kt_datatable_group_action_form" style="margin: 20px">
                <div class="row align-items-center">
                    <div class="col-xl-12" style="text-align: center">
                        <div class="kt-form__group kt-form__group--inline">
                            <div class="kt-form__label kt-form__label-no-wrap">
                                <label class="kt--font-bold kt--font-danger-"> {{__('app.branches.table.selected')}}
                                    <span id="kt_datatable_selected_number">0</span> {{__('app.branches.table.records')}}:</label>
                            </div>
                            <div class="kt-form__control">
                                <div class="btn-toolbar">
                                    <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target=".delete-all" id="kt_datatable_delete_all">
                                        {{__('app.branches.table.delete_selected')}}</button>
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade delete-all" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{__('app.branches.delete_title')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{__('app.branches.delete_message')}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-brand" data-dismiss="modal">{{__('app.branches.close')}}</button>
                            <button class="btn btn-outline-brand" id="delete-items">{{__('app.branches.delete')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Selected Rows Group Action Form -->
            <!--begin: Datatable -->
            <div class="kt_datatable" id="child_data_ajax"></div>
            <!--end: Datatable -->
        </div>
    </div>

@push('js')
<script>
            var user_id = "{{$user_id}}";
        </script>
    <script>
        var trans = {
             "id"         : "{{__('app.branches.table.id')}}",
             "name"       : "{{__('app.branches.table.name')}}",
             "active"       : "{{__('app.branches.table.active')}}",
             "description"       : "{{__('app.branches.table.description')}}",
             "code"       : "{{__('app.branches.table.code')}}",
             "direction"      : "{{__('app.branches.table.direction')}}",
             "flag"      : "{{__('app.branches.table.flag')}}",
             "created_at" : "{{__('app.branches.table.created_at')}}",
             "save"         : "{{__('app.branches.save')}}",
             "actions"         : "{{__('app.branches.table.actions')}}",
             "storing"      : "{{__('app.branches.storing')}}",
             "delete"      : "{{__('app.branches.delete')}}",
             "close"      : "{{__('app.branches.close')}}",
             "delete_message"      : "{{__('app.branches.delete_message')}}",
             "delete_title"      : "{{__('app.branches.delete_title')}}",
        }

    </script>
    <script src="{{url('/')}}/js/datatables/branches.js" type="text/javascript"></script>
    <script>

    </script>
@endpush
@endsection
