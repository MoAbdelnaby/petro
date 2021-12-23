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

            <div class="row">

                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="card-header">
                            <h5>{{ __('app.Branch_Status_Header') }}</h5>
                        </div>
                        <div class="container-fluid">
                            <div class="row mb-3 mt-3 justify-content-center">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            <h5><b><i class="fas fa-circle" style="color: red"></i> {{ __('app.branch_offline') }}</b></h5>
                                            <h3><b>{{ $off }}</b></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            <h5><b><i class="fas fa-circle" style="color: green"></i> {{ __('app.branch_online')  }}</b></h5>
                                            <h3><b>{{ $on }}</b></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="card-body">

                            <div class="related-product-block position-relative col-12">
                                <div class="product_table table-responsive row p-0 m-0 col-12">
                                    <table class="table dataTable ui celled table-bordered text-center">
                                        <thead class="bg-primary">
                                        <th>#</th>
                                        <th>{{__('app.branch_name')}}</th>
                                        <th>{{ __('app.branch_status') }}</th>
                                        <th>{{ __('app.last_connected') }}</th>

                                        </thead>
                                        <tbody class="trashbody">
                                        @foreach($branches as $k => $branch)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td><a href="branches-log/{{$branch->branch_code}}" target="_blank">{{ $branch->branch->name }}</a></td>
                                                <td>
                                                    @if ($branch->status == 'online')
                                                        <i class="fas fa-circle" style="color: green"></i> {{ __('app.branch_online')  }}
                                                    @else
                                                        <i class="fas fa-circle" style="color: red"></i> {{ __('app.branch_offline') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($branch->last_connected)
                                                        {{ $branch->last_connected }}
                                                    @else
                                                        {{ __('app.branch_lessThan15') }}
                                                    @endif
                                                </td>
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
    </div>
@endsection
