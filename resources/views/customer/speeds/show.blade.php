@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branches.page_title.index')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h4>{{  __('app.customers.speed.show.title', ['branch' => $branch->name]) }}</h4>
            <hr />
            <div class="related-product-block position-relative table">
                <div class="product_table table-responsive row p-0 m-0 col-12">
                    <table class="table dataTable ui celled table-bordered text-center no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th>{{ __('app.customers.speed.index.speed') }}</th>
                            <th>{{ __('app.customers.speed.index.date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr class="item{{$log->id}}">
                                <td>{{$log->internet_speed}} {{ __('app.customers.speed.unit') }}</td>
                                <td>{{$log->created_at->format('d-m-Y h:i A')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
