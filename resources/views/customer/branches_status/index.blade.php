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
                        <div class="card-header related-heading">

                            <h2>
                                <img src="{{resolveDark()}}/img/icon_menu/building.svg"  width="24" class="tab_icon-img" alt="">
                                {{ __('app.Branch_Status_Header') }}</h2>
                        </div>
                        <div class="container-fluid">
                            <div class="row mb-3 mt-3 justify-content-center">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card text-center">
                                        <div class="card-header row online mx-0 px-0">
                                            <div class="col-4"><img width="100" src="{{ asset("images/online-svgrepo-com.svg") }}" alt=""></div>
                                            <div class="col-8">
                                                <h5><b><i class="fas fa-circle" style="color: green"></i> {{ __('app.branch_online')  }}</b></h5>
                                                <h3><b>{{ $on }}</b></h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="card text-center col-12  ">
                                        <div class="card-header row offline ">
                                            <div class="col-4"><img width="100" fill="red" src="{{ asset("images/offline-svgrepo-com.svg") }}" alt=""></div>
                                            <div class="col-8">
                                                <h5><b><i class="fas fa-circle" style="color: red"></i> {{ __('app.branch_offline') }}</b></h5>
                                                <h3><b>{{ $off }}</b></h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        <div class="card-body">

                            <div class="related-product-block position-relative col-12">
                                <div class="product_table table-responsive row p-0 m-0 col-12">
                                    <table class="table dataTable ui celled table-bordered text-center">
                                        <thead class="">
                                        <th>#</th>
                                        <th>{{__('app.branch_name')}}</th>
                                        <th>{{ __('app.branch_status') }}</th>
                                        <th>{{ __('app.last_connected') }}</th>
                                        <th>{{ __('app.Actions') }}</th>

                                        </thead>
                                        <tbody class="trashbody">
                                        @foreach($branches as $k => $branch)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>
                                                    {{ \App\Models\Branch::where('code', $branch->branch_code)->first()->name }}
                                                </td>
                                                <td>
                                                    @if (\Carbon\Carbon::now()->diffInMinutes($branch->created_at) <= 15)
                                                        <i class="fas fa-circle" style="color: green"></i> {{ __('app.branch_online')  }}
                                                    @else
                                                        <i class="fas fa-circle" style="color: red"></i> {{ __('app.branch_offline') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php($diff = \Carbon\Carbon::now()->diff($branch->created_at))
                                                    @if($diff->y)
                                                        {{ __('app.not_connected_yet') }}
                                                    @else
                                                        @if($diff->d)
                                                            {{ $diff->d }} {{ __('Day'.($diff->d > 1 ? 's' : '')) }}
                                                        @endif
                                                        @if($diff->d || $diff->h)
                                                            {{ $diff->h }} {{ __('Hour'.($diff->h > 1 ? 's' : '')) }}
                                                        @endif
                                                        {{ $diff->i }} {{ __('Minute'.($diff->i > 1 ? 's' : '')) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="branches-log/{{$branch->branch_code}}" target="_blank">{{ __('app.Show') }}</a>
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
