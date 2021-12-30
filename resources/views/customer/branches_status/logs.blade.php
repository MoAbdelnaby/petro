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
            <div class="iq-card">
                <div class="card-header">
                    <h2>{{ __('app.Branch_Status_Header') }} : {{ $branchName }}</h2>
                </div>
                <div class="container-fluid">
                    <div class="card-body">

                        <div class="related-product-block position-relative col-12">
                            <div class="product_table table-responsive row p-0 m-0 col-12">
                                <table class="table dataTable ui celled table-bordered text-center">
                                    <thead class="">
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
                                            <td>
{{--                                                {{ $log->status }}--}}
                                                @if ($log->status == "connected")
                                                    <i class="fas fa-circle" style="color: green"></i> {{ $log->status }}
                                                @else
                                                    <i class="fas fa-circle" style="color: red"></i> {{ $log->status }}
                                                @endif

                                            </td>
                                            <td>{{ $log->error }}</td>
                                            <td>{{ \Carbon\Carbon::parse($log->created_at)->isoFormat("LLL") }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{--                            {{ $branches->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

