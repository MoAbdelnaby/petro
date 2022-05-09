@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.users.users')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .search-model {
            display: none
        }

        .search-model .col-md-6 {
            display: none;
        }

        div.dataTables_wrapper div.dataTables_paginate, div.dataTables_wrapper div.dataTables_info {
            display: none !important;
        }

    </style>
@endpush

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row col-12 p-0 m-0 text-right d-block mb-2">

                @can('create-CustomerUsers')
                    @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin"  && count($trashs))
                        <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                                data-target="#RecycleBin">
                            <i class="fas fa-recycle"></i> {{ __('app.Recycle_Bin') }}
                        </button>
                    @endif
                @endcan

            <!-- Modal -->
                <div class="modal fade" id="RecycleBin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('app.Actions_in_Users') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="trash_form">
                                    @csrf
                                    <div class="col-12 mb-2">
                                        <button type="submit" style=" display: none"
                                                class="restore_all btn btn-sm btn-primary mr-2"><i
                                                class="fas fa-recycle"></i> {{__('app.restore_all')}}</button>
                                        <button type="submit" style="display: none"
                                                class="remove_all btn btn-sm btn-danger"><i
                                                class="fas fa-trash"> </i>{{__('app.delete_all')}}</button>
                                    </div>

                                    <table style="width: 100%;" class="table table-bordered text-center">
                                        <thead class="bg-primary">
                                        <td>
                                            <label for="selectall" class="custom-checkbox pl-1">
                                                <input type="checkbox" id="selectall" class="selectall"/>
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <th>{{__('app.users.table.name')}}</th>
                                        <th>{{__('app.users.table.position')}}</th>
                                        <th>{{__('app.users.table.email')}}</th>
                                        <th>{{ __('app.Settings') }}</th>

                                        </thead>
                                        <tbody class="trashbody">
                                        @foreach($trashs as $trash)
                                            <tr>
                                                <td>
                                                    <label for="{{$trash->id}}" class="custom-checkbox pl-1">
                                                        <input class="trashselect" type="checkbox" name="trashs[]"
                                                               id="{{$trash->id}}" value="{{$trash->id}}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>

                                                <td>{{$trash->name}}</td>
                                                <td>{{$trash->position??'--'}}</td>
                                                <td>{{$trash->email}}</td>

                                                <td style='white-space: nowrap'>
                                                    <button style="display: inline-block" type="submit"
                                                            class="trash_restore btn btn-sm btn-primary"
                                                            style="color: white;"><i
                                                            class="fas fa-recycle"></i> {{__('app.Restore')}}</button>
                                                    <button style="display: inline-block" type="submit"
                                                            class="trash_delete btn btn-sm btn-danger"><i
                                                            class="fas fa-trash"></i> {{__('app.customers.branches.delete')}}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-md-6">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-end mb-0">
                                                {!! $users->appends(request()->query())->links() !!}
                                            </ul>
                                        </nav>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                        data-dismiss="modal">{{ __('app.Cancel') }}</button>
                                <button type="button" class="btn btn-primary">{{ __('app.Apply') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                @can('create-CustomerUsers')
                    @if(in_array(auth()->user()->type,['customer','subadmin']))
                        <a class="btn btn-primary" href="{{route('customerUsers.create')}}">
                            <i class="fas fa-plus"></i> &nbsp;{{__('app.new')}}
                        </a>
                    @endif
                @endcan
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="related-heading c-flex mb-5">
                                <h2 class="pb-2">
                                    <img src="{{resolveDark()}}/img/icon_menu/users.svg" class="tab_icon-img" width="20"
                                         alt=""> {{__('app.users.users')}}
                                </h2>
                                <span class="position-static pb-2">
                                    <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="value" value="table">
                                        <button type="submit"><i
                                                class="fas fa-table {{ $userSettings ? ($userSettings->show_items == "table" ? 'active' : '') :'' }}"></i></button>
                                    </form>
                                    <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="value" value="large">
                                        <button type="submit"><i
                                                class="fas fa-th-large {{ $userSettings ? ($userSettings->show_items == "large" ? 'active' : '') :'' }}"></i></button>
                                    </form>
                                     <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="value" value="small">
                                        <button type="submit"><i
                                                class="fas fa-th {{ $userSettings ? ($userSettings->show_items == "small" ? 'active' : '') :'' }}"></i></button>
                                    </form>


                                </span>
                            </div>
                            <div class="related-product-block position-relative col-12">

                                @if($userSettings and $userSettings->show_items == "table")
                                    <div class="product_table table-responsive row p-0 m-0 col-12">
                                        <table class="table dataTable ui celled table-bordered text-center">
                                            <thead>
                                            <th>{{__('app.users.table.image')}}</th>
                                            <th>{{__('app.users.table.name')}}</th>
                                            <th>{{__('app.users.table.Type')}}</th>
                                            <th>{{__('app.position')}}</th>
                                            <th>{{__('app.users.table.email')}}</th>
                                            <th>{{__('app.users.table.Phone')}}</th>
                                            <th>{{__('app.saas.packages.items.active_branches')}}</th>
                                            <th>{{ __('app.Settings') }}</th>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr class="item{{$user->id}}">
                                                    <td>
                                                        <img
                                                            src="{{ session()->has('darkMode') ? url('/gym_dark/img'):url('/gym/img') }}/users.svg"
                                                            alt="product-image" class="img-fluid">
                                                    </td>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->type}}</td>
                                                    <td>{{$user->position?$user->position->name:'---'}}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone??'---' }}</td>
                                                    <td>

                                                        @if($user->branches->count())
                                                            @foreach($user->branches as $brn)
                                                                <span class="nav-item li-btn-sm btn-info"><i
                                                                        class="far fa-sitemap"></i> {{$brn->name}}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="nav-item li-btn-sm "> {{ __('----') }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="width: max-content;display: inline-block">
                                                        @if(in_array(auth()->user()->type,['customer','subadmin']))
                                                            @php
                                                                $user_branches = [];
                                                                    foreach ($user->branches as $brn)
                                                                    $user_branches[] = $brn->id;
                                                                    $user_brs = json_encode(implode(",",$user_branches));
                                                            @endphp
                                                            @if($user->type != 'subadmin')
                                                                <a class="btn btn-sm btn-info" data-toggle="tooltip"
                                                                   data-placement="top" title=""
                                                                   data-original-title="Assign to Branch"
                                                                   onclick="assign_user_to_branch_model_alert({{ $user->id }},{{ $user_brs }},{{ $branches }},{{ $regions }});"
                                                                   style="color: white;">{{__('app.saas.packages.items.Assign_model')}}</a>
                                                            @endif
                                                            <a class="btn btn-sm btn-primary"
                                                               href="{{ route('customerUsers.edit',$user->id) }}"
                                                               style="color: white;">{{__('app.customers.branches.edit')}}</a>
                                                            <a class="btn btn-sm btn-danger" rel="{{ $user->id }}"
                                                               data-toggle="tooltip" data-placement="top"
                                                               data-original-title="Delete"
                                                               onclick="delete_alert({{ $user->id }});">{{__('app.customers.branches.delete')}}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div id="PACKAGEITEMS"
                                         class="product_list row p-0 m-0 col-12 {{ $userSettings ? ($userSettings->show_items == "large" ? 'large' : '') :'' }}">
                                        @foreach($users as $user)
                                            <div
                                                class="product_item col-sm-6 col-mg-3 mb-4  {{ $userSettings ? ($userSettings->show_items == "large" ? 'col-lg-6' : 'col-lg-3') :'' }} item{{$user->id}}">
                                                <div class=" iq-card secondary-custom-card h-100">
                                                    <div class="product-miniature"
                                                         style="align-content: center;margin: auto;">
                                                        <div
                                                            class="thumbnail-container text-center py-3 justify-content-center">
                                                            <img
                                                                src="{{ session()->has('darkMode') ? url('/gym_dark/img'):url('/gym/img') }}/users.svg"
                                                                alt="product-image" class="img-fluid">
                                                        </div>

                                                        <div class="product-description">
                                                            <h5>
                                                                <small>
                                                                    <span>
                                                                        <i class="fas fa-user"></i>
                                                                        {{__('app.users.table.name')}}
                                                                    </span>: {{$user->name}}
                                                                </small>
                                                            </h5>
                                                            <h5>
                                                                <small>
                                                                    <span>
                                                                        <i class="fas fa-paper-plane"></i>
                                                                        {{__('app.users.table.email')}}
                                                                    </span>: {{$user->email}}</small>
                                                            </h5>
                                                            <h5>
                                                                <small>
                                                                    <span>
                                                                        {{__('app.position')}}
                                                                    </span>: {{$user->position?$user->position->name:'---'}}
                                                                </small>
                                                            </h5>
                                                            <h5>
                                                                <small>
                                                                    <span>
                                                                        <i class="fas fa-phone-alt"></i>
                                                                        {{__('app.users.table.Phone')}}
                                                                    </span>: {{$user->phone??'---'}}
                                                                </small>
                                                            </h5>

                                                            <div class="border-bottom my-1"></div>
                                                            <h5 class="d-block position-relative">
                                                                <small><i
                                                                        class="far fa-sitemap"></i> {{__('app.saas.packages.items.active_branches')}}
                                                                </small>
                                                                <span class="float-right showbranchesAll"><i
                                                                        class="fas fa-info"></i></span>
                                                                {{--                                                                                @if(!empty($item->itembranches) and count($item->itembranches) > 5 )--}}
                                                                <div class="branchesAll">

                                                                    <div class="content-branches">
                                                                        @foreach($user->branches as $brn)
                                                                            <h6>
                                                                                <i class="far fa-sitemap"></i> {{$brn->name}}
                                                                            </h6>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                                {{--                                                                                @endif--}}

                                                            </h5>
                                                            <div class="position-relative">
                                                                <ul class="ratting-item scroll-vertical-custom d-flex p-0 m-0">
                                                                    <div class="scroll-vertical-custom-div">
                                                                        @if($user->branches->count())
                                                                            @foreach($user->branches as $brn)
                                                                                <li class="nav-item li-btn-sm btn-info">
                                                                                    <i class="far fa-sitemap"></i> {{$brn->name}}
                                                                                </li>
                                                                            @endforeach
                                                                        @else
                                                                            <span
                                                                                class="nav-item li-btn-sm "> {{ __('----') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="border-bottom my-2"></div>
                                                    <div class="col-12">
                                                        <div class="text-center px-0 pb-2">
                                                            @if(in_array(auth()->user()->type,['customer','subadmin']))
                                                                @php
                                                                    $user_branches = [];
                                                                        foreach ($user->branches as $brn)
                                                                        $user_branches[] = $brn->id;
                                                                        $user_brs = json_encode(implode(",",$user_branches));

                                                                @endphp
                                                                @if($user->type != 'subadmin')
                                                                    <a class="btn btn-info" data-toggle="tooltip"
                                                                       data-placement="top" title=""
                                                                       data-original-title="{{ __('app.Assign_to_Branch') }}"
                                                                       onclick="assign_user_to_branch_model_alert({{ $user->id }},{{$user_brs}},{{$branches}},{{$regions}});"
                                                                       style="color: white;">{{__('app.saas.packages.items.Assign_model')}}</a>
                                                                @endif
                                                                <a class="btn btn-primary"
                                                                   href="{{ route('customerUsers.edit',$user->id) }}"
                                                                   style="color: white;">{{__('app.customers.branches.edit')}}</a>
                                                                <a class="btn btn-danger" data-toggle="tooltip"
                                                                   data-placement="top" title=""
                                                                   data-original-title="Delete"
                                                                   onclick="delete_alert({{ $user->id }});">{{__('app.customers.branches.delete')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="row justify-content-between mt-3">
                                <div class="col-md-12">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end mb-0">
                                            {!! $users->appends(request()->query())->links() !!}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- myModalDelete -->
    <div id="myModalDelete" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-danger"><i class="far fa-question-circle"></i> {{ __('app.Confirmation') }}</h3>
                    <h5>{{__('app.users.delete_message')}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{__('app.users.close')}}</button>
                    <button type="button" class="btn btn-danger"
                            onclick="delete_option('customer/customerUsers');">{{__('app.users.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- myModalAssign -->
    <div id="myModalAssign" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="margin-top: 100px">
            <div class="modal-content">
                <div class="modal-header row px-0 mx-0">
                    <h5 class="modal-title col"><i
                            class="fas fa-sitemap"></i> {{__('app.customers.branchmodels.page_title.create')}}</h5>
                    <div class="col">
                        <input type="search" id="searchBranch" class="float-right form-control"
                               placeholder="{{ __('app.search_in_branches_or_regions') }}">
                    </div>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('customerUsers.assignUserToBranch') }}" id="assignform">
                        @csrf

                        <input type="hidden" name="user_id" id="user_id">

                        <div class="tab-content assign_body" id="myTabContent">
                            <div class="overflowx-auto">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach($regions as $key=>$reg)
                                        @if(count($reg->branches))
                                            @foreach($reg->branches as $branche)
                                                @php
                                                    $Branches[] = ["name" => $branche->name, "id" => $branche->id];
                                                @endphp
                                            @endforeach
                                        @endif

                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{$key == 0 ? 'active' : '' }}" id="home-tab"
                                               data-toggle="tab" href="#home-{{$reg->id}}" rel="home-{{$reg->id}}"
                                               role="tab" aria-controls="home" aria-selected="true">{{$reg->name}}
                                                <small>5</small></a>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>

                        <div class="tab-content search-model">
                            @foreach($regions as $key=>$reg)
                                @if(count($reg->branches))
                                    @foreach($reg->branches as $branche)
                                        <div class="col-md-12">
                                            <label class="custom-checkbox" rel="{{$branche->id}}"> {{ $branche->name }}
                                                <input type="checkbox" rel2="{{ $branche->name }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                            data-dismiss="modal">{{__('app.customers.branches.close')}}</button>
                    <button type="button" class="btn btn-primary"
                            onclick="assign_option();">{{__('app.customers.branchmodels.save')}}</button>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('.assignusertobranch').select2({
                placeholder: 'assign branches',
                tags: false,
                tokenSeparators: [',', ' ']
            });
            $('.delete').click(function () {
                var rel = $(this).attr('rel');
                $('#myModalDelete form').attr('action', "customer/customerUsers/" + rel);
            });
            $('.assign_body').delegate(".checkall", "click", function () {
                $(this).closest('.tab-pane').find('.branchselect').prop('checked', $(this).prop('checked'));
            });

            let regions = <?= json_encode($Branches ?? []) ?>;
            // searchBranch function
            $('#searchBranch').keyup(function () {
                var text = $(this).val();
                // console.log(text.length)
                if (text.length > 0) {
                    var search_result = 0;
                    for (var i = 0; i < regions.length; i++) {
                        if (regions[i].name.search(text) >= 0) {
                            $('#assignform .search-model').find('input[rel2="' + regions[i].name + '"]').closest('.col-md-6').css({'display': 'block'});
                            search_result = search_result + 1;
                        } else {
                            $('#assignform .search-model').find('input[rel2="' + regions[i].name + '"]').closest('.col-md-6').css({'display': 'none'});
                        }
                        $('#assignform .assign_body').hide();
                        $('#assignform .search-model').show();
                    }
                    if (search_result <= 0) {
                        $('#assignform .search-model img.no-results').remove();
                        $('#assignform .search-model').append("<img src='/images/no-results.webp' style='margin: 25px auto;display: block;' class='col-6 img-fluid no-results' />")
                    } else {
                        $('#assignform .search-model img.no-results').remove();
                    }
                } else {
                    $('#assignform .assign_body').show();
                    $('#assignform .search-model').hide();
                }

            });


            $('#myModalAssign .search-model input:checkbox').click(function () {
                // console.log($(this))
                let rel = $(this).parent('.custom-checkbox').attr('rel'),
                    input = $('#myModalAssign .assign_body').find('#' + rel).find('input[type="checkbox"]');
                if (input) {
                    $(input).trigger('click');
                }
            });


            $('.selectall').on('click', function () {
                $(this).closest('.table').find('.trashbody .trashselect').prop('checked', $(this).prop('checked'));
                $('.restore_all').toggle();
                $('.remove_all').toggle();
            });

            $('.trashbody .trashselect').on('click', function () {
                var checked = $(".trashbody input[type=checkbox]:checked").length;
                if (checked > 1) {
                    $('.restore_all').show();
                    $('.remove_all').show();
                } else {
                    $('.restore_all').hide();
                    $('.remove_all').hide();
                }
            });
            $('.restore_all').on('click', function () {
                $("#trash_form").attr('action', app_url + "/customer/customerUsers/bulkRestore");
            });
            $('.trash_restore').on('click', function (e) {
                e.preventDefault();
                $(this).parent('td').siblings().find('.trashselect').prop('checked', 'checked');
                $("#trash_form").attr('action', app_url + "/customer/customerUsers/bulkRestore");
                $("#trash_form").submit();
            });
            $('.remove_all').on('click', function () {
                $("#trash_form").attr('action', app_url + "/customer/customerUsers/bulkDelete");
            });
            $('.trash_delete').on('click', function (e) {
                e.preventDefault();
                $(this).parent('td').siblings().find('.trashselect').prop('checked', 'checked');
                $(this).closest('.trashselect').prop('checked', 'checked');
                $("#trash_form").attr('action', app_url + "/customer/customerUsers/bulkDelete");
                $("#trash_form").submit();
            });
        });
    </script>

@endpush

