@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.customers.branches.page_title.index') }}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection




@section('content')
    <div id="content-page" class="content-page">


        <div class="container-fluid">
            <div class="row col-12 p-0 m-0 text-right d-block mb-2 ">
                <a href="{{ route('service.create') }}" class=" ml-3 btn btn-primary">
                    <i class="fas fa-plus"></i> &nbsp;{{ __('app.service.create') }}
                </a>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="related-heading mb-5">
                                <h2>
                                    <img src="{{resolveDark()}}/img/icon_menu/servicestack.svg"  width="24" class="tab_icon-img" alt="">
                                     {{ __('app.service.service') }}
                                </h2>
                            </div>
                            <div class="related-product-block position-relative col-12">
                                <div class="product_table table-responsive row p-0 m-0 col-12">
                                    <table class="table dataTable ui celled table-bordered text-center no-footer"
                                        id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr role="row">
                                                <th>{{ __('app.branch') }}</th>
                                                <th>{{ __('app.service.arabic_name') }}</th>
                                                <th>{{ __('app.service.english_name') }}</th>
                                                <th>{{ __('app.service.arabic_description') }}</th>
                                                <th>{{ __('app.service.english_description') }}</th>
                                                <th>{{ __('app.service.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($services as $item)
                                                <tr class="item{{ $item->id }}">
                                                    <td>
                                                        @php
                                                            $lastKey = 0;
                                                        @endphp
                                                        @foreach ($item->branches as $key => $branch)
                                                            @if ($key <= 4)
                                                                @php
                                                                    $lastKey = $key;
                                                                @endphp
                                                                <span class="badge"> {{ $branch->name }} </span>
                                                            @endif
                                                        @endforeach
                                                        @if ($lastKey >= 4)
                                                            <button class="btn btn-sm" data-toggle="modal"
                                                                data-target="#show-branches-{{ $item->id }}">Show
                                                                More {{ count($item->branches) - $key + 2 }}
                                                                branches</button>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->name_ar }}</td>
                                                    <td>{{ $item->name_en }}</td>
                                                    <td>{{ $item->description_ar }}</td>
                                                    <td>{{ $item->description_en }}</td>
                                                    <td style="min-width:200px">
                                                        <a href="{{ route('service.edit', $item->id) }}" class="btn btn-primary m-1">{{ __('app.Edit') }}</a>
                                                        <a class="btn btn-danger"   onclick="delete_alert({{ $item->id }});" >{{ __('app.Delete') }}</a>
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


    @foreach ($services as $item)

        <div class="modal fade" id="show-branches-{{ $item->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $item->name_en }} branches</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($item->branches as $item)
                            <div class="row">
                                <div class="col-md-12">{{ $item->name }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <!-- myModalDelete -->
    <div id="myModalDelete" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-danger"> <i class="far fa-question-circle"></i>  {{ __('app.Confirmation') }}</h3>
                    <h5>{{__('app.users.delete_message')}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.users.close')}}</button>
                    <button type="button" class="btn btn-danger" onclick="delete_option('customer/customerUsers');">{{__('app.users.delete')}}</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $('.delete').click(function (){
                var rel = $(this).attr('rel');
                $('#myModalDelete form').attr('action',"customer/customerUsers/"+rel);
            });


        });
    </script>

@endpush
