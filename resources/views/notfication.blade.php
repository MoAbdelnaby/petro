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
                            <h5>{{ __('app.gym.Notifications') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered text-center">

                                    <thead class="bg-primary">
                                    <th>#</th>
                                    <th>{{__('app.Models')}}</th>
                                    <th>{{ __('app.data') }}</th>
                                    <th>{{ __('app.createdIn') }}</th>
                                    </thead>
                                    <tbody class="trashbody">
                                    @foreach($notfications as $k => $notfication)
                                        <tr>
                                            <td>{{ $k+1 }}</td>
                                            <td>{{ $notfication->notifiable_type }}</td>
                                            <td>{{ $notfication->data }}</td>
                                            <td>{{$notfication->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $notfications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
