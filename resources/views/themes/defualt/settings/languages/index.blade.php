@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.languages.page_title.index')}}
@endsection
@section('breadcrumbs')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{route('languages.index')}}" class="kt-subheader__breadcrumbs-link">
        {{__('app.languages.permission_title')}} </a>
@endsection
@section('content')
    @push('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    @include('settings.languages.create_modal')
    @include('settings.languages.update_modal')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('app.languages.permission_title')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">

                    <a href="{{route('home')}}" class="btn btn-clean btn-bold btn-upper btn-font-sm">
                        <i class="la la-long-arrow-left"></i>
                        {{__('app.languages.back')}}
                    </a>
                    <button data-toggle="modal" data-target=".create-language"  class="btn btn-default btn-bold btn-upper btn-font-sm create-language-btn">
                        <i class="flaticon2-add-1"></i>
                        {{__('app.languages.create_new')}}
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
                                    <input type="text" class="form-control form-control-md" placeholder="{{__('app.languages.search')}}"
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
                                <label class="kt--font-bold kt--font-danger-"> {{__('app.languages.table.selected')}}
                                    <span id="kt_datatable_selected_number">0</span> {{__('app.languages.table.records')}}:</label>
                            </div>
                            <div class="kt-form__control">
                                <div class="btn-toolbar">
                                    <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target=".delete-all" id="kt_datatable_delete_all">
                                        {{__('app.languages.table.delete_selected')}}</button>
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
                            <h5 class="modal-title">{{__('app.languages.delete_title')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{__('app.languages.delete_message')}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-brand" data-dismiss="modal">{{__('app.languages.close')}}</button>
                            <button class="btn btn-outline-brand" id="delete-items">{{__('app.languages.delete')}}</button>
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
        var trans = {
             "id"         : "{{__('app.languages.table.id')}}",
             "name"       : "{{__('app.languages.table.name')}}",
             "code"       : "{{__('app.languages.table.code')}}",
             "direction"      : "{{__('app.languages.table.direction')}}",
             "flag"      : "{{__('app.languages.table.flag')}}",
             "created_at" : "{{__('app.languages.table.created_at')}}",
             "save"         : "{{__('app.languages.save')}}",
             "actions"         : "{{__('app.languages.table.actions')}}",
             "storing"      : "{{__('app.languages.storing')}}",
             "delete"      : "{{__('app.languages.delete')}}",
             "close"      : "{{__('app.languages.close')}}",
             "delete_message"      : "{{__('app.languages.delete_message')}}",
             "delete_title"      : "{{__('app.languages.delete_title')}}",
        }

    </script>
    <script src="{{url('/')}}/js/datatables/languages.js" type="text/javascript"></script>
    <script>

    </script>
@endpush
@endsection
