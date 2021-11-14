@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branches.page_title.index')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(Session::has('branch_file') && Session::get('branch_file') != null)
        <meta http-equiv="refresh" content="5;url={{ Session::get('branch_file') }}">
    @endif
@endsection
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            {{----}}
                            <div class="row">
                                <div class="col-sm-12 mt-3 related-product">
                                    <div class="related-heading mb-5">
                                        <h2>
                                            <img src="{{resolveDark()}}/img/branch.svg" width="30" alt="product-image"
                                                 class="img-fluid"/>
                                            {{__('app.customers.branches.files')}}
                                        </h2>
                                        <span>
                                            <form action="{{ route('user_settings',['show_items']) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="value" value="table">
                                                <button type="submit"><i
                                                        class="fas fa-table {{ $userSettings ? ($userSettings->show_items == "table" ? 'active' : '') :''}}"></i></button>
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
                                    <div class="related-product-block position-relative table">
                                        @if($userSettings and $userSettings->show_items == "table")
                                            <div class="product_table table-responsive row p-0 m-0 col-12">
                                                <table
                                                    class="table dataTable ui celled table-bordered text-center no-footer"
                                                    id="DataTables_Table_0" role="grid"
                                                    aria-describedby="DataTables_Table_0_info">
                                                    <thead>
                                                    <tr role="row">
                                                        <th>{{__('app.logo')}}</th>
                                                        <th>{{__('app.Name')}}</th>
                                                        <th>{{__('app.size')}}</th>
                                                        <th>{{__('app.start')}}</th>
                                                        <th>{{__('app.end')}}</th>
                                                        <th>{{__('app.branch')}}</th>
                                                        <th>{{__('app.Status')}}</th>
                                                        <th>{{__('app.type')}}</th>
                                                        <th>{{__('app.Settings')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($items as $item)
                                                        <tr class="item{{$item->id}}">
                                                            <td>
                                                                <img src="{{resolveDark()}}/img/{{$item->type}}.png"
                                                                     style="max-height: 80px !important;" width="auto"
                                                                     alt="product-image" class="img-fluid">
                                                            </td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->size ? round($item->size / 1000,0) : 0}}KB
                                                            </td>
                                                            <td>{{$item->start??'--'}}</td>
                                                            <td>{{$item->end??'--'}}</td>
                                                            <td>{{$item->branch->name ?? ''}}</td>
                                                            <td>{{((bool)$item->status)?'Ready' : 'Not Ready Yet' }}</td>
                                                            <td>{{$item->type }}</td>
                                                            <td>
                                                                @if(auth()->user()->type=="customer")
                                                                    @if($item->status)
                                                                        <a class="btn btn-sm btn-primary"
                                                                           href="{{ route('branchmodelpreview.files.download',[$item->id]) }}">{{__('app.customers.branches.download')}}</a>
                                                                    @endif
                                                                    <a class="btn btn-sm btn-danger"
                                                                       data-toggle="tooltip" data-placement="top"
                                                                       title="" data-original-title="Delete"
                                                                       onclick="delete_alert({{ $item->id }});">{{__('app.customers.branches.delete')}}</a>
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
                                                @foreach($items as $item)
                                                    <div
                                                        class="product_item col-xs-12 col-sm-6 col-md-6 {{ $userSettings ? ($userSettings->show_items == "large" ? 'col-lg-6' : 'col-lg-3') : '' }} item{{$item->id}}">
                                                        <div class="iq-card">
                                                            <div class="product-miniature">
                                                                <div class="thumbnail-container text-center pb-0">
                                                                    <img src="{{resolveDark()}}/img/{{$item->type}}.png"
                                                                         style="max-height: 120px !important;"
                                                                         width="auto" height="100"
                                                                         alt="product-image" class="img-fluid">
                                                                </div>

                                                                <div class="product-description text-center">
                                                                    <h5>
                                                                        <small>{{$item->name}}</small>
                                                                    </h5>
                                                                    <h5>
                                                                        <small>
                                                                            <span>{{__('app.start')}}</span>: {{$item->start??'--'}}
                                                                        </small>
                                                                    </h5>
                                                                    <h5>
                                                                        <small>
                                                                            <span>{{__('app.end')}}</span>: {{$item->end??'--'}}
                                                                        </small>
                                                                    </h5>
                                                                    <h5>
                                                                        <small>
                                                                            <span>
                                                                                {{__('app.size')}} </span>: {{round($item->size / 1000,0)}}
                                                                            KB
                                                                        </small>
                                                                    </h5>
                                                                    <h5>
                                                                        <small>
                                                                            <span>
                                                                                <i class="fas fa-map-marker-alt"></i>
                                                                                {{__('app.branch')}}</span>
                                                                            : {{$item->branch->name ?? ''}}
                                                                        </small>
                                                                    </h5>
                                                                    <h5 class="d-block">
                                                                        <small>{{($item->status)?'Ready' : 'Not Ready'}}</small>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div class="ratting-item-div">
                                                                <div class="clearfix border-bottom mt-1 mb-1"></div>
                                                                <div
                                                                    class="ratting-item d-flex align-items-center justify-content-center p-0 m-0 pb-2">
                                                                    @if(auth()->user()->type=="customer")
                                                                        @if($item->status)
                                                                            <a class="btn btn-primary mx-1"
                                                                               href="{{ route('branchmodelpreview.files.download',[$item->id]) }}">{{__('app.customers.branches.download')}}</a>
                                                                        @endif
                                                                        <a class="btn btn-danger" data-toggle="tooltip"
                                                                           data-placement="top" title="Delete"
                                                                           data-original-title="Delete"
                                                                           onclick="delete_alert({{ $item->id }});">{{__('app.customers.branches.delete')}}</a>
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


            <!-- myModalDelete -->
            <div id="myModalDelete" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="text-danger"><i class="far fa-question-circle"></i> {{__('app.Confirmation')}}
                            </h3>
                            <h5> {{__('app.customers.branches.delete_message')}}</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{__('app.customers.branches.close')}}</button>
                            <button type="button" class="btn btn-danger"
                                    onclick="delete_option('models/branch/files/destroy');">{{__('app.customers.branches.delete')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

