@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.customers.branches.page_title.index') }}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="text-center alert-cont">

            </div>
            <div class="clearfix col-12"></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-sm-12 mt-3 related-product">
                                    <div class="related-heading mb-5">
                                        <h2>
                                            <img src="{{ resolveDark() }}/img/branch.svg" width="30" alt="product-image"
                                                 class="img-fluid"></a>
                                            {{ __('app.customers.branches.page_title.index') }}
                                        </h2>
                                        <span>
                                            <form action="{{ route('user_settings', ['show_items']) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="value" value="table">
                                                <button type="submit"><i
                                                        class="fas fa-table {{ $userSettings ? ($userSettings->show_items == 'table' ? 'active' : '') : '' }}"></i></button>
                                            </form>
                                            <form action="{{ route('user_settings', ['show_items']) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="value" value="large">
                                                <button type="submit"><i
                                                        class="fas fa-th-large {{ $userSettings ? ($userSettings->show_items == 'large' ? 'active' : '') : '' }}"></i></button>
                                            </form>
                                            <form action="{{ route('user_settings', ['show_items']) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="value" value="small">
                                                <button type="submit"><i
                                                        class="fas fa-th {{ $userSettings ? ($userSettings->show_items == 'small' ? 'active' : '') : '' }}"></i></button>
                                            </form>


                                        </span>
                                    </div>
                                    <div class="related-product-block position-relative table">
                                        <div class="product_table table-responsive row p-0 m-0 col-12">
                                            <table
                                                class="table dataTable ui celled table-bordered text-center no-footer"
                                                id="DataTables_Table_0" role="grid"
                                                aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                <tr role="row">
                                                    <th>{{ __('app.Image') }}</th>
                                                    <th>{{ __('app.Name') }}</th>
                                                    <th>{{ __('app.customers.branches.table.code') }}</th>
                                                    <th>{{ __('app.customers.branches.table.area_count') }}</th>
                                                    <th>{{ __('app.region') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($items as $item)
                                                    <tr class="item{{ $item->id }}">
                                                        <td>
                                                            <img
                                                                src="{{ $item->photo ? url('storage/' . $item->photo) : (session()->has('darkMode') ? url('/images/models/dark/branch.svg') : url('/images/models/default/branch.svg')) }}"
                                                                width="auto" height="30px" alt="product-image"
                                                                class="img-fluid">
                                                        </td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->code }}</td>
                                                        <td>{{ $item->area_count }}</td>
                                                        <td>{{ $item->region->name ?? '' }}</td>
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


            <!-- myModalDelete -->
            <div id="myModalDelete" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="text-danger"><i class="far fa-question-circle"></i>
                                {{ __('app.Confirmation') }}
                            </h3>
                            <h5> {{ __('app.customers.branches.delete_message') }}</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('app.customers.branches.close') }}</button>
                            <button type="button" class="btn btn-danger"
                                    onclick="delete_option('customer/customerBranches');">{{ __('app.customers.branches.delete') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
