@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.customers.branches.page_title.index') }}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection




@section('content')
    <div id="content-page" class="content-page">


        <div class="container-fluid">
            <div class="row col-12 p-0 m-0 text-right d-block mb-2 ">
                <a href="{{ route('service.create') }}" class=" ml-3 btn btn-primary">
                    <i class="fas fa-plus"></i> &nbsp;{{ __('app.service.create') }}
                </a>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="related-heading mb-5">
                                <h2>
                                   <i class="fab fa-servicestack fa-1x"></i> {{__('app.service.service')}}
                                </h2>
                            </div>
                            <div class="related-product-block position-relative col-12">
                                    <div class="product_table table-responsive row p-0 m-0 col-12">
                                        <table class="table dataTable ui celled table-bordered text-center no-footer" id="DataTables_Table_0"
                                               role="grid" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr role="row">
                                                <th>{{ __('app.branch') }}</th>
                                                <th>{{ __('app.service.arabic_name') }}</th>
                                                <th>{{ __('app.service.english_name') }}</th>
                                                <th>{{ __('app.service.arabic_description') }}</th>
                                                <th>{{ __('app.service.english_description') }}</th>
                                                <th>{{ __('app.service.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($services as $item)
                                                <tr class="item{{ $item->id }}">
                                                    <td>{{ $item->branch->name }}</td>
                                                    <td>{{ $item->name_ar }}</td>
                                                    <td>{{ $item->name_en }}</td>
                                                    <td>{{ $item->description_ar }}</td>
                                                    <td>{{ $item->description_en }}</td>
                                                    <td style="min-width:200px">
                                                        <a href="{{ route('service.edit', $item->id) }}"
                                                           class="btn btn-primary m-1">{{ __('app.Edit') }}</a>
                                                        <form onsubmit="return confirm('Are you sure ?')" class="d-inline"
                                                              action="{{ route('service.destroy', $item->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger ">{{ __('app.Delete') }}</button>
                                                        </form>
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
@endsection
