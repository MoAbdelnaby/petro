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
                        <div class="card-header">
                            <h5>{{ __('app.Branch_Status_Header') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered text-center">

                                    <thead class="bg-primary">
                                    <th>#</th>
                                    <th>{{__('app.branch_name')}}</th>
{{--                                    <th>{{ __('app.lastError') }}</th>--}}
                                    <th>{{ __('app.last_connected') }}</th>

                                    </thead>
                                    <tbody class="trashbody">
                                    @foreach($branches as $k => $branch)
                                        <tr>
                                            <td>{{ $k+1 }}</td>
                                            <td><a href="branches-log/{{$branch->branch_code}}" target="_blank">{{ $branch->branch->name }}</a></td>
{{--                                            <td>{{ $branch->last_error }}</td>--}}
                                            <td>
                                                @if ($branch->status == 'online')
                                                    {{ $branch->status }}
                                                @else
                                                    {{ $branch->last_connected }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $branches->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
