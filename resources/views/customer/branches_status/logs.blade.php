@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.customers.branches.page_title.create')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <style>
        .invalid-feedback{
            display: block;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h3>{{ $branchName }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered text-center">

                                    <thead class="bg-primary">
                                    <th>#</th>
                                    <th>{{ __('app.user_name') }}</th>
                                    <th>{{ __('app.branch_status') }}</th>
                                    <th>{{ __('app.lastError') }}</th>
                                    <th>{{ __('app.createdIn') }}</th>
                                    </thead>
                                    <tbody class="trashbody">
                                    @foreach($logs as $k => $log)
                                        <tr>
                                            <td>{{ $k+1 }}</td>
                                            <td>{{ $log->user->name }}</td>
                                            <td>{{ $log->status }}</td>
                                            <td>{{ $log->error }}</td>
                                            <td>{{ \Carbon\Carbon::parse($log->created_at)->isoFormat("LLL") }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
