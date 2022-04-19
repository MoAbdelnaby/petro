    @extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.regions.page_title.index')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="text-center alert-cont">

            </div>

            <div class="row col-12 p-0 m-0 text-right d-block mb-2">
                @can('create-CustomerBranches')
                    @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin" && count($trashs))
                        <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#RecycleBin">
                            <i class="fas fa-recycle"></i> {{ __('app.Recycle_Bin') }}
                        </button>
                    @endif
                @endcan
            <!-- Modal -->
                <div class="modal fade" id="RecycleBin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('app.Actions_in_Users') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form  method="POST" action="" id="trash_form">
                                    @csrf
                                    <div class="col-12 mb-2">
                                        <button type="submit" style="display: none" class="restore_all btn btn-sm btn-primary mr-1"><i class="fas fa-recycle"></i> {{__('app.restore_all')}}</button>
                                        <button type="submit" style="display: none" class="remove_all btn btn-sm btn-danger" ><i class="fas fa-trash"> </i>{{__('app.delete_all')}}</button>
                                    </div>
                               <table style="width: 100%;" class="table dataTable table-bordered text-center">

                                   <thead class="bg-primary">
                                    <td>
                                        <label for="selectall" class="custom-checkbox pl-1">
                                            <input type="checkbox" id="selectall" class="selectall" />
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <th>{{__('app.Image')}}</th>
                                    <th>{{__('app.users.table.name')}}</th>
                                    <th>{{ __('app.Settings') }}</th>
                                    </thead>
                                    <tbody class="trashbody">

                                    @foreach($trashs as $trash)
                                        <tr>
                                            <td>
                                                <label for="{{$trash->id}}" class="custom-checkbox pl-1">
                                                    <input class="trashselect"  type="checkbox" name="trashs[]" id="{{$trash->id}}" value="{{$trash->id}}">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                        <td>
                                            <img src="{{ $trash->photo ? url('storage/'.$trash->photo): ( session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') )}}" width="auto" height="50"  alt="product-image" >
                                        </td>
                                        <td>{{$trash->name}}</td>

                                        <td style='white-space: nowrap'>
                                            <button style="display: inline-block" type="submit"  class="trash_restore btn btn-sm btn-primary" style="color: white;"><i class="fas fa-recycle"></i> {{__('app.Restore')}}</button>
                                            <button style="display: inline-block" type="submit" class="trash_delete btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" ><i class="fas fa-trash"></i> {{__('app.customers.branches.delete')}}</button>
                                        </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('app.Cancel') }}</button>
                                <button type="button" class="btn btn-primary">{{ __('app.Apply') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

            @can('create-CustomerBranches')
                @if(in_array(auth()->user()->type,['customer','subadmin']))
                    <a class="btn btn-primary" href="{{route('customerRegions.create')}}" >
                        <i class="fa fa-plus"></i> {{__('app.customers.regions.new')}}
                    </a>
                @endif
            @endcan
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body Regions">

                            <div class="row">
                                <div class="col-sm-12 mt-3 related-product">
                                    <div class="related-heading mb-5">
                                        <h2>
                                            <img src="{{   session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') }}" width="20" alt="product-image" class="img-fluid">
                                            {{__('app.customers.regions.page_title.index')}}
                                        </h2>
                                        <span>
                                            <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="value" value="table">
                                                <button type="submit"><i class="fas fa-table {{ $userSettings ? ($userSettings->show_items == "table" ? 'active' : '') :'' }}"></i></button>
                                            </form>
                                            <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="value" value="large">
                                                <button type="submit"><i class="fas fa-th-large {{ $userSettings ? ($userSettings->show_items == "large" ? 'active' : '') :'' }}"></i></button>
                                            </form>
                                             <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="value" value="small">
                                                <button type="submit"><i class="fas fa-th {{ $userSettings ? ($userSettings->show_items == "small" ? 'active' : '') :'' }}"></i></button>
                                            </form>


                                        </span>
                                    </div>
                                    <div class="related-product-block position-relative">
                                        @if($userSettings and $userSettings->show_items == "table")
                                            <div class="product_table table-responsive row p-0 m-0 col-12">
                                                <table class="table dataTable ui celled table-bordered text-center">
                                                    <thead>
                                                    <th>{{ __('app.Image') }}</th>
                                                    <th>{{ __('app.Name') }}</th>
                                                    <th>{{ __('app.users.table.Parent') }}</th>
                                                    <th>{{ __('app.Status') }}</th>
                                                    <th>{{ __('app.Settings') }}</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($items as $item)
                                                        <tr class="item{{$item->id}}">
                                                            <td>
                                                                <img width="auto" height="50" alt="product-image"
                                                                     src="@if($item->photo)
                                                                         {{url('storage/'.$item->photo)}}
                                                                        @elseif($item->parent != null)
                                                                            {{url('storage/'.optional($item->parent)->photo)}}
                                                                        @else
                                                                          {{ session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') }}"
                                                                        @endif"
                                                                />
                                                            </td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{optional($item->parent)->name??'----'}}</td>
                                                            <td>
                                                                <a href="{{ url(route('regions.change_active',[$item->id])) }}">
                                                                    @if($item->active==1)
                                                                        <i class="fas fa-check-square {{$item->active==1 ? 'True':'False'}}"></i>
                                                                        {{__('app.active')}}
                                                                    @else
                                                                        <i class="fas fa-window-close {{$item->active==1 ? 'True':'False'}}"></i>
                                                                        {{__('app.deactivate')}}
                                                                    @endif
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @if(in_array(auth()->user()->type,['customer','subadmin']))
                                                                    <a class="btn btn-sm btn-info"  href="{{ route('customerRegions.edit',[$item->id]) }}"> <i class="fas fa-edit"></i> {{__('app.customers.regions.edit')}}</a>
                                                                    <a class="btn btn-sm btn-danger" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="delete_alert({{ $item->id }});" ><i class="fas fa-trash-alt"></i> {{__('app.customers.regions.delete')}}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div id="PACKAGEITEMS" class="product_list row p-0 m-0 col-12 {{ $userSettings ? ($userSettings->show_items == "large" ? 'large' : '') :'' }}">
                                                @foreach($items as $item)

                                                    <div class="product_item col-xs-12 col-sm-6 col-md-6 {{ $userSettings ? ($userSettings->show_items == "large" ? 'col-lg-6' : 'col-lg-3') :'' }} item{{$item->id}}">
                                                        <div class="iq-card">
                                                            <div class="product-miniature">
                                                                <div class="thumbnail-container text-center pb-0">
                                                                    <a class="d-block" href="http://rased.test/models/branch/home">
                                                                        <img src="{{ $item->photo ? url('storage/'.$item->photo): ( session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') )}}" width="auto" height="100"  alt="product-image" >
                                                                    </a>
                                                                </div>
                                                                <div class="product-description text-center">
                                                                    <h5><small>{{$item->name}}</small></h5>
                                                                    <h5 class="d-block">
                                                                        <a style="cursor: pointer" href="{{ url(route('regions.change_active',[$item->id])) }}">
                                                                            @if($item->active==1)
                                                                                <i class="fas fa-check-square {{$item->active==1 ? 'True':'False'}}"></i>
                                                                                {{__('app.active')}}
                                                                            @else
                                                                                <i class="fas fa-window-close {{$item->active==1 ? 'True':'False'}}"></i>
                                                                                {{__('app.deactivate')}}
                                                                            @endif
                                                                        </a>

                                                                    </h5>
                                                                </div>
                                                            </div>

                                                            <div class="ratting-item-div">
                                                                <div class="clearfix border-bottom mt-1 mb-1"></div>
                                                                <div class="ratting-item d-flex align-items-center justify-content-center p-0 m-0 pb-2">
                                                                    @if(in_array(auth()->user()->type,['customer','subadmin']))
                                                                        <div class="text-center mr-1">
                                                                            <a class="btn  btn-info"  href="{{ route('customerRegions.edit',[$item->id]) }}"> <i class="fas fa-edit"></i> {{__('app.customers.regions.edit')}}</a>
                                                                        </div>
                                                                        <div class="text-center " >
                                                                            <a class="btn  btn-danger" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="delete_alert({{ $item->id }});" ><i class="fas fa-trash-alt"></i> {{__('app.customers.regions.delete')}}</a>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>







        </div>
    </div>





    <!-- myModalDelete -->
    <div id="myModalDelete" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-danger"> <i class="far fa-question-circle"></i> {{__('app.Confirmation')}}</h3>
                    <h5> {{__('app.customers.regions.delete_message')}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.customers.regions.close')}}</button>
                    <button type="button" class="btn btn-danger" onclick="delete_option('customer/customerRegions');">{{__('app.customers.regions.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.selectall').on('click', function() {
                $(this).closest('.table').find('.trashbody .trashselect').prop('checked',$(this).prop('checked'));
                $('.restore_all').toggle();
                $('.remove_all').toggle();
            });

            $('.trashbody .trashselect').on('click', function() {
                var checked = $(".trashbody input[type=checkbox]:checked").length;
                if (checked > 1) {
                    $('.restore_all').show();
                    $('.remove_all').show();
                }else {
                    $('.restore_all').hide();
                    $('.remove_all').hide();
                }
            });

            $('.restore_all').on('click',function () {
                $("#trash_form").attr('action', app_url+"/customer/customerRegions/bulkRestore");
            });
            $('.trash_restore').on('click',function (e) {
                e.preventDefault();
                $(this).parent('td').siblings().find('.trashselect').prop('checked','checked');
                $("#trash_form").attr('action', app_url+"/customer/customerRegions/bulkRestore");
                $("#trash_form").submit();
            });
            $('.remove_all').on('click',function () {
                $("#trash_form").attr('action', app_url+"/customer/customerRegions/bulkDelete");
            });
            $('.trash_delete').on('click',function (e) {
                e.preventDefault();
                $(this).parent('td').siblings().find('.trashselect').prop('checked','checked');
                $(this).closest('.trashselect').prop('checked','checked');
                $("#trash_form").attr('action', app_url+"/customer/customerRegions/bulkDelete");
                $("#trash_form").submit();
            });
        });
    </script>

@endpush
