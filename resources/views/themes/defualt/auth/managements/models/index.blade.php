@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.models.page_title.index')}}
@endsection
@section('breadcrumbs')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{route('models.index')}}" class="kt-subheader__breadcrumbs-link">
        {{__('app.models.models_title')}} </a>
@endsection
@section('content')
    @push('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{url('/gym')}}/css/select2.min.css" rel="stylesheet" type="text/css"/>
    @endpush

    @include('auth.managements.models.assign_modal')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('app.models.models_title')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">

                    <a href="{{route('home')}}" class="btn btn-clean btn-bold btn-upper btn-font-sm">
                        <i class="la la-long-arrow-left"></i>
                        {{__('app.models.back')}}
                    </a>
                    <button data-toggle="modal" data-target=".create-model"  class="btn btn-default btn-bold btn-upper btn-font-sm create-model-btn">
                        <i class="flaticon2-add-1"></i>
                        {{__('app.models.assign')}}
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
                                    <input type="text" class="form-control form-control-md" placeholder="{{__('app.permissions.search')}}"
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
                                <label class="kt--font-bold kt--font-danger-"> {{__('app.models.table.selected')}}
                                    <span id="kt_datatable_selected_number">0</span> {{__('app.models.table.records')}}:</label>
                            </div>
                            <div class="kt-form__control">
                                <div class="btn-toolbar">
                                    <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target=".delete-all" id="kt_datatable_delete_all">
                                        {{__('app.models.table.delete_selected')}}</button>
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
                            <h5 class="modal-title">{{__('app.models.delete_title')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{__('app.models.delete_message')}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-brand" data-dismiss="modal">{{__('app.models.close')}}</button>
                            <button class="btn btn-outline-brand" id="delete-items">{{__('app.models.delete')}}</button>
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
<script src="{{url('/gym')}}/js/select2.min.js"></script>
    <script>
        var trans = {
             "id"         : "{{__('app.models.table.id')}}",
             "name"       : "{{__('app.models.table.name')}}",
             "description"      : "{{__('app.models.table.description')}}",
             "active"      : "{{__('app.models.table.active')}}",
             "guard"      : "{{__('app.models.table.guard')}}",
             "created_at" : "{{__('app.models.table.created_at')}}",
             "display_name" : "{{__('app.models.table.display_name')}}",
             "save"         : "{{__('app.models.save')}}",
             "actions"         : "{{__('app.models.table.actions')}}",
             "storing"      : "{{__('app.models.storing')}}",
             "delete"      : "{{__('app.models.delete')}}",
             "close"      : "{{__('app.models.close')}}",
             "delete_message"      : "{{__('app.models.delete_message')}}",
             "delete_title"      : "{{__('app.models.delete_title')}}",
        }

    </script>
    <script src="{{url('/')}}/js/datatables/models.js" type="text/javascript"></script>
    <script>

    </script>
@endpush
@endsection
