@extends('layouts.dashboard.index')
@push('css')
    <style>
        .select2-container {
            min-width: 400px;
        }

        .select2-selection.select2-selection--multiple {
            min-height: 40px !important;
        }
    </style>
@endpush
@section('page_title')
    {{__('app.customers.packages.page_title.index')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    {{--    @include('customer.packages.create_modal')--}}
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row custom-container">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-md-12 pb-3">
                                    <div class="iq-image-container">
                                        <div class="iq-product-cover d-flex justify-content-center">
                                            <img
                                                src="{{ session()->has('darkMode') ? url('/images/package-light.png'):url('/images/package.svg')}}"
                                                alt="product-image" class="img-fluid">

                                        </div>
                                        <div class="row justify-content-center">
                                            <ul id="" class="d-flex m-0 p-0">
                                                @foreach($items as $item)
                                                    <li class="mx-1 d-flex"><img
                                                            src="{{ session()->has('darkMode') ? url('/images/models/dark'):url('/images/models/default') }}/{{$item->model->model->id}}.svg"
                                                            width="80px" height="80px" alt="product-image"
                                                            class="img-fluid"></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin")
                                            <div class="additional-product-action row justify-content-center mt-3">
                                                @if($package)
                                                    <div class="product-action ml-2">
                                                        <div class="add-to-cart">
                                                            <a class="btn btn-primary"
                                                               href="{{ route('branchmodelpreview.index') }}">
                                                                <i class="fa fa-eye"></i> {{__('app.customers.packages.table.ShowModels')}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(auth()->user()->id != 3)
                                                    <div class="product-action ml-2">
                                                        <div class="add-to-cart">
                                                            <a class="btn btn-default"
                                                               href="{{ route('customerPackages.allpackages') }}">
                                                                {{__('app.customers.packages.table.upgrade')}}
                                                                <i class="fa fa-plus"></i> </a></div>
                                                    </div>
                                                @endif

                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row custom-container">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-sm-12  related-product">
                                    <div class="related-heading mb-5 c-flex">
                                        <h2 class="pb-2">
                                            <img src="{{resolveDark()}}/img/icon_menu/package.svg" alt="product-image"
                                                 width="20" class="img-fluid">
                                            {{__('app.customers.packages.itemslist')}}
                                        </h2>
                                        <span class="position-static pb-2">
                                            <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                              @csrf
                                              <input type="hidden" name="value" value="table">
                                              <button type="submit">
                                                  <i class="fas fa-table {{ $userSettings ? ($userSettings->show_items == "table" ? 'active' : '') :'' }}"></i>
                                              </button>
                                            </form>
                                            <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                              @csrf
                                              <input type="hidden" name="value" value="large">
                                              <button type="submit">
                                                  <i class="fas fa-th-large {{ $userSettings ? ($userSettings->show_items == "large" ? 'active' : '') :'' }}"></i>
                                              </button>
                                            </form>
                                            <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                              @csrf
                                              <input type="hidden" name="value" value="small">
                                              <button type="submit">
                                                  <i class="fas fa-th {{ $userSettings ? ($userSettings->show_items == "small" ? 'active' : '') :'' }}"></i>
                                              </button>
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
                                                    <th>{{ __('app.Active_branches') }}</th>
                                                    <th>{{ __('app.Feature') }}</th>
                                                    <th>{{ __('app.Settings') }}</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($items as $item)
                                                        <tr>
                                                            <td>
                                                                <img
                                                                    src="{{ session()->has('darkMode') ? url('/images/models/dark'):url('/images/models/default') }}/{{$item->model->model->id}}.svg"
                                                                    alt="product-image" width="50px" height="50px"
                                                                    class="img-fluid mx-auto mb-2"/>
                                                            </td>
                                                            <td>
                                                                {{$item->model->name}}
                                                                <small class="d-block"><i
                                                                        class="far fa-sitemap"></i> {{$item->count}}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                @if(!empty($item->itembranches) and $item->itembranches[0] !== null)
                                                                    @foreach($item->itembranches as $key => $branch)
                                                                        <span class="nav-item li-btn-sm btn-info">
                                                                            <i class="far fa-sitemap"></i>
                                                                            {{$branch->name}}
                                                                        </span>
                                                                        @if($key == 2) ..... @break @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @foreach($item->featurenames as $feat)
                                                                    <span
                                                                        class="li-btn-sm btn-success"> {{$feat}}</span>
                                                                @endforeach
                                                            </td>
                                                            <td class="col-3">
                                                                @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin")

                                                                    <span class="text-center  border-0 border-radius-0">
                                                                        <a class="btn btn-info waves-effect waves-light"
                                                                           data-container="body" data-trigger="hover"
                                                                           data-toggle="popover" data-placement="top"
                                                                           data-content="{{__('app.saas.packages.items.Assign_Branch')}}"
                                                                           onclick=assign_alert({{ $item->id }},@json($item->branches()->pluck('branch_id')))>
                                                                            <i class="fas fa-sitemap m-0"></i>
                                                                        </a>
                                                                    </span>
                                                                    @if(!empty($item->itembranches) and $item->itembranches[0] !== null)
                                                                        <span
                                                                            class="text-center  border-0 border-radius-0 "
                                                                            style="">
                                                                        <a class="btn btn-primary waves-effect waves-light"
                                                                           href="{{ route('branchmodels.show',[$item->id]) }}"
                                                                           data-container="body" data-trigger="hover"
                                                                           data-toggle="popover" data-placement="top"
                                                                           data-content="{{__('app.saas.packages.items.Show')}}">
                                                                            <i class="fas fa-eye m-0"></i>
                                                                        </a>
                                                                    </span>
                                                                    @endif
                                                                    <span class="text-center  border-0 border-radius-0">
                                                                      <a class="btn btn-danger waves-effect waves-light"
                                                                         data-container="body" data-trigger="hover"
                                                                         data-toggle="popover" data-placement="top"
                                                                         data-content="{{ __('app.Error_Manageent') }}"
                                                                         href="{{route('error_mangment.index',9)}}">
                                                                          <i class="fas fa-exclamation-triangle m-0"></i>
                                                                      </a>
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                        @else
                                            <div id="PACKAGEITEMS"
                                                 class="product_list row p-0 m-0 col-12 justify-content-center {{ $userSettings ? ($userSettings->show_items == "large" ? 'large':'') :'' }}">
                                                @foreach($items as $item)
                                                    <div
                                                        class="product_item col-xs-12 col-sm-6 col-md-6  {{ $userSettings ? ($userSettings->show_items == "large" ? 'col-lg-6':'col-lg-4') :'' }}">
                                                        <div class="iq-card secondary-custom-card">
                                                            <div class="product-miniature">
                                                                <div class="thumbnail-container text-center pb-0">
                                                                    <a class="d-block"
                                                                       href="{{ route('branchmodelpreview.index') }}">
                                                                        <img
                                                                            src="{{ session()->has('darkMode') ? url('/images/models/dark'):url('/images/models/default') }}/{{$item->model->model->id}}.svg"
                                                                            alt="product-image" width="80px"
                                                                            height="80px"
                                                                            class="img-fluid mx-auto mb-2"/>
                                                                        <h5>{{$item->model->name}}</h5>
                                                                        <h5><small><i
                                                                                    class="far fa-sitemap"></i> {{$item->count}}
                                                                            </small></h5>
                                                                    </a>
                                                                </div>
                                                                <div class="clearfix border-bottom my-2"></div>
                                                                <div class="product-description position-relative">
                                                                    {{--                                                    <h5><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}"
                                                                    >{{__('app.saas.packages.items.model')}}</span> : {{$item->model->name}}</h5>--}}
                                                                    {{--                                                                    <h5><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}"
                                                                    >{{__('app.saas.packages.items.count')}}</span> : {{$item->count}}</h5>--}}
                                                                    {{--                                                                    <div class="clearfix border-bottom my-2"></div>--}}
                                                                    <h5>
                                                                      <span class="float-left"
                                                                            style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}">
                                                                          <i class="far fa-sitemap"></i>
                                                                          {{__('app.saas.packages.items.active_branches')}}
                                                                      </span>
                                                                        {{--                                                                        @if(!empty($item->itembranches) and count($item->itembranches) > 5 )--}}
                                                                        <span class="float-right showbranchesAll">
                                                                            <i class="fas fa-info"></i>
                                                                        </span>
                                                                        <div class="branchesAll" style="display: none;">
                                                                            <div class="content-branches">
                                                                                @foreach($item->itembranches as $key=>$branch)
                                                                                    <h6>
                                                                                        <i class="far fa-sitemap"></i> {{$branch->name}}
                                                                                    </h6>
                                                                                    @if($key == 2) ..... @break @endif
                                                                                @endforeach
                                                                            </div>

                                                                        </div>
                                                                    </h5>
                                                                    <div class="clearfix mt-1 mb-1"></div>

                                                                    <div class="position-relative">
                                                                        <ul class="ratting-item scroll-vertical-custom d-flex p-0 m-0">
                                                                            <div class="scroll-vertical-custom-div">
                                                                                @if(!empty($item->itembranches) and $item->itembranches[0] !== null)
                                                                                    @foreach($item->itembranches as $key=>$branch)
                                                                                        <li class="nav-item li-btn-sm btn-info">
                                                                                            <i class="far fa-sitemap"></i> {{$branch->name}}
                                                                                        </li>
                                                                                        @if($key == 8) ..... @break @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="clearfix border-bottom mt-1 mb-1"></div>
                                                                    <h5><span
                                                                            style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}">{{__('app.saas.packages.items.feature')}}</span>
                                                                        : </h5>
                                                                    <div class="features-div">
                                                                        <ul class="ratting-item d-flex p-0 m-0">
                                                                            @foreach($item->featurenames as $feat)
                                                                                <li class="li-btn-sm btn-success"> {{$feat}}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="ratting-item-div">
                                                                <div class="clearfix border-bottom mt-1 mb-1"></div>
                                                                <ul class="ratting-item d-flex align-items-center justify-content-center p-0 m-0 pb-2">
                                                                    @if(auth()->user()->type=="customer" || auth()->user()->type=="subadmin")
                                                                        <li class="text-center  border-0 border-radius-0 mr-1"
                                                                            style="">
                                                                            <a class="btn btn-info waves-effect waves-light"
                                                                               onclick=assign_alert({{ $item->id }},@json($item->branches()->pluck('branch_id')))>
                                                                                {{__('app.saas.packages.items.Assign_Branch')}}</a>
                                                                        </li>
                                                                        @if(!empty($item->itembranches) and $item->itembranches[0] !== null)
                                                                            <li class="text-center  border-0 border-radius-0 mr-1"
                                                                                style="">
                                                                                <a class="btn btn-primary waves-effect waves-light"
                                                                                   href="{{ route('branchmodels.show',[$item->id]) }}">{{__('app.saas.packages.items.Show')}}</a>
                                                                            </li>
                                                                        @endif
                                                                        <li class="text-center  border-0 border-radius-0">
                                                                            <a class="btn btn-danger waves-effect waves-light"
                                                                               href="{{route('error_mangment.index',$item->model->model->id)}}">{{ __('app.Error_Manageent') }}</a>
                                                                        </li>
                                                                    @endif

                                                                </ul>


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

    <!-- myModalAssign -->
    <div id="myModalAssign" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-sitemap"></i>
                        {{__('app.customers.branchmodels.page_title.index')}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('branchmodels.store') }}" id="assignform">
                        @csrf
                        <div class="col-12 p-0">
                            <input type="hidden" name="user_model_id" id="user_model_id">
                            <div class="form-group col-md-12">
                                <label for="price">
                                    <i class="fas fa-sitemap"></i>
                                    {{__('app.customers.branchmodels.table.branch')}}
                                </label>

                                <select class="form-control" id="branch_id" multiple name="branch_id[]">
                                    @foreach($allbranches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        {{__('app.customers.branches.close')}}
                    </button>
                    <button type="button" class="btn btn-primary"
                            onclick="assign_option();">{{__('app.customers.branchmodels.save')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script rel="stylesheet" src="{{asset('assets/js/select2.min.js')}}"></script>
    <script>
        $(function () {
            $("#branch_id").select2();
        });
    </script>
@endpush
