@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.branch_status')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@push('css')
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="menu-and-filter menu-and-filter--custom related-heading">
                                <h2>
                                    <img src="{{resolveDark()}}/img/icon_menu/building.svg" width="24"
                                         class="tab_icon-img" alt="">
                                    {{ __('app.Branch_Status_Header') }}: {{$branch->name}}
                                </h2>
                            </div>
                            <div class="container-fluid">
                                <div class="card-body">
                                    <div class="related-product-block position-relative col-12">
                                        <div class="product_table table-responsive row p-0 m-0 col-12">
                                            <table class="table dataTable ui celled table-bordered text-center">
                                                <thead class="">
                                                <th>#</th>
                                                <th>{{ __('app.branch_status') }}</th>
                                                <th>{{ __('app.gym.Start_Date') }}</th>
                                                <th>{{ __('app.gym.End_Date') }}</th>
                                                <th>{{ __('app.duration') }}</th>
                                                </thead>
                                                <tbody class="trashbody">
                                                @foreach($steps as $k => $stable)
                                                    <tr>
                                                        <td>{{ $k+1 }}</td>
                                                        <td>
                                                            @if ($stable['status'] == 'stable')
                                                                <i class="fas fa-circle" style="color: green"></i>
                                                                <strong
                                                                    style="color: green">{{ __('app.stable')  }}</strong>
                                                            @else
                                                                <i class="fas fa-circle" style="color: red"></i>
                                                                <strong
                                                                    style="color: red">{{ __('app.not_staple') }}</strong>
                                                            @endif
                                                        </td>
                                                        <td>{{$stable['start_date']}}</td>
                                                        <td>{{$stable['end_date']}}</td>
                                                        <td>{{$stable['stability']}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{--  {{ $branches->links() }}--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('js/report/report.js')}}"></script>

@push('js')
    <script>
        $(function () {
            let steps = @json($steps);
            let info = @json($info);
            @if(count($steps))
            lineChart('chartLine', steps, info);
            @endif
        });
    </script>
@endpush

