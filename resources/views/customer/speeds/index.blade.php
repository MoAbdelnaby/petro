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
            <div class="related-product-block position-relative table">
                <div class="product_table table-responsive row p-0 m-0 col-12">
                    <table class="table dataTable ui celled table-bordered text-center no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th>{{ __('app.customers.speed.index.branchName') }}</th>
                            <th>{{ __('app.customers.speed.index.speed') }}</th>
                            <th>{{ __('app.customers.speed.index.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            @continue (!$log->branch)

                            <tr class="item{{$log->id}}">
                                <td>{{$log->branch->name}}</td>
                                <td>{{$log->internet_speed}} {{ __('app.customers.speed.unit') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{ route('branch.connection-speeds', $log->branch->id) }}">{{__('app.customers.speed.show.action')}}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
