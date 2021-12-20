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
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="related-heading mb-5">
                                <h2>

                                    <img src="{{resolveDark()}}/img/icon_menu/work-time.svg" width="20" alt="">

                                    {{ __('app.gym.Notifications') }}

                                </h2>
                            </div>
                            <div class="related-product-block position-relative col-12">
                                <div class="product_table table-responsive row p-0 m-0 col-12">
                                    <table class="table table-bordered text-center">

                                        <thead class="bg-primary">
                                        <th>#</th>
                                        <th>{{__('app.Models')}}</th>
                                        <th>{{ __('app.data') }}</th>
                                        <th>{{ __('app.createdIn') }}</th>
                                        </thead>
                                        <tbody class="trashbody">
                                        @foreach($notfications as $k => $notfication)
                                            @php
                                                $notis = explode(',', $notfication->data);
                                            @endphp
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $notfication->notifiable_type }}</td>
                                                <td>
                                                    @foreach($notis as $noti)
                                                        @php
                                                            $key = explode(':', $noti) ;
                                                        @endphp
                                                        <span class="btn btn-sm btn-info waves-effect waves-light">{{ str_replace(['_','"','{','}'], [' ', ''],$key[0]) }} : {{ str_replace(['_','"','{','}'], [' ', ''],$key[1]) }}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{$notfication->created_at }}</td>
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
    </div>
@endsection
