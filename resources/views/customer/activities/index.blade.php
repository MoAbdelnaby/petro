@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.users.users')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@push('css')
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row col-12 p-0 m-0 text-right d-block mb-2">
                {{--                @can('create-CustomerUsers')--}}
                {{--                    @if(auth()->user()->type=="customer")--}}
                {{--                    <a class="btn btn-primary" href="{{route('customerUsers.create')}}" >--}}
                {{--                        <i class="fas fa-plus"></i> &nbsp;{{__('app.new')}}--}}
                {{--                    </a>--}}
                {{--                    @endif--}}
                {{--                @endcan--}}
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="related-heading mb-5">
                                <h2>

                                    <img src="{{resolveDark()}}/img/icon_menu/work-time.svg" width="20" alt="">

                                        {{ __('app.activities.activities') }}

                                </h2>
                            </div>
                            <div class="related-product-block position-relative col-12">
                                <div class="product_table table-responsive row p-0 m-0 col-12">
                                    <table class="table dataTable ui celled table-bordered text-center">
                                        <thead>
                                        <th>{{ __('app.Image') }}</th>
                                        <th>{{__('app.users.table.table')}}</th>
                                        <th>{{__('app.users.table.description')}}</th>
                                        <th>{{__('app.users.table.causer')}}</th>
                                        <th>{{__('app.users.table.subject_id')}}</th>
                                        <th>{{__('app.users.table.changes')}}</th>

                                        </thead>
                                        <tbody>


                                        @foreach($activities as $row)

                                            <tr>
                                                <td>
                                                    @if($row->log_name == 'user')
                                                        <img src="{{ session()->has('darkMode') ? url('/gym_dark/img'):url('/gym/img') }}/users.svg" alt="user-image" title="user-image" class="img-fluid">
                                                    @elseif($row->log_name == 'branch')
                                                        <img src="{{ session()->has('darkMode') ? url('/gym_dark/img'):url('/gym/img') }}/branch.svg" alt="branch-image" title="branch-image" class="img-fluid">
                                                    @elseif($row->log_name == 'region')
                                                        <img src="{{   session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') }}" alt="region-image" title="region-image" class="img-fluid">
                                                    @endif
                                                </td>
                                                <td>{{ $row->log_name}}</td>
                                                <td>{{ $row->description }}</td>
                                                <td>{{ $row->causer->name }}</td>
                                                <td>{{ $row->subject_id}}</td>
                                                <td>
                                                    @foreach($row->properties as $key => $prop)
                                                        <span class="badge badge-pill badge-dark">{{ $key }} : {{ $prop }}</span>
                                                    @endforeach
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            {{--                            <div class="row justify-content-between mt-3">--}}
                            {{--                                <div id="user-list-page-info" class="col-md-6">--}}
                            {{--                                    <span>Showing 1 to {{count($activities)}} of {{count($activities)}} entries</span>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="col-md-6">--}}
                            {{--                                    <nav aria-label="Page navigation example">--}}
                            {{--                                        <ul class="pagination justify-content-end mb-0">--}}
                            {{--                                            {{ $activities->links() }}--}}
                            {{--                                        </ul>--}}
                            {{--                                    </nav>--}}
                            {{--                                </div>--}}

                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
