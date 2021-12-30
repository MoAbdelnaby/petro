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
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="related-heading mb-5">
                                <h2>
                                   <i class="fas fa-wifi"></i> {{__('app.connection_speed')}}
                                </h2>
                            </div>
                            <div class="related-product-block position-relative col-12">
                                <div class="product_table table-responsive row p-0 m-0 col-12">
                                    <table class="table dataTable ui celled table-bordered text-center">
                                        <thead>
                                        <tr role="row">
                                            <th>{{ __('app.customers.speed.index.branchName') }}</th>
                                            <th>{{ __('app.customers.speed.index.downloadSpeed') }}</th>
                                            <th>{{ __('app.customers.speed.index.uploadSpeed') }}</th>
                                            <th>{{ __('app.customers.speed.index.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($logs as $log)
                                            @continue (!$log->branch)

                                            <tr class="item{{$loop->index}}">
                                                <td>{{$log->branch->name}}</td>
                                                <td>{{ number_format($log->internet_speed, 2) }} {{ __('app.customers.speed.unit') }}</td>
                                                <td>{{ number_format($log->upload_speed, 2) }} {{ __('app.customers.speed.unit') }}</td>
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
                </div>
            </div>
        </div>
    </div>

@endsection
