@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.saas.packages.items.active_models')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.saas.packages.items.active_models')}}</h4>
                            </div>
                        </div>
                        <div class="text-center" style="width:400px; margin:0 auto;">

                            <div class="alert text-white bg-danger errdiv" role="alert" style="display: none;">
                                <div class="iq-alert-icon">
                                    <i class="ri-information-line"></i>
                                </div>
                                <div class="iq-alert-text err"></div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>

                        </div>

                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <div class="row justify-content-between">
                                    <div class="col-sm-12 col-md-6">

                                    </div>

                                </div>
                                <div class="row">
                                    @foreach($userWatchModels as $item)
                                        <div class="col-sm-6 col-mg-3 col-lg-4 item{{$item->id}}">
                                            <div class=" iq-card"  style="height: 430px !important;" >

                                                <div class="product-miniature" style="align-content: center;margin: auto;">
                                                    <div class="d-flex justify-content-center">
                                                        <img src="{{ session()->has('darkMode') ? url('/images/models/dark'):url('/images/models/default') }}/{{$item->usermodelbranch->usermodel->model->id}}.svg" alt="product-image"  width="120px" height="120px" class="img-fluid m-auto"/>
                                                    </div>
                                                    <hr>
                                                    <div class="product-description">
                                                        <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.saas.packages.items.model')}}</span> : {{$item->usermodelbranch->usermodel->model->name}}</h5>
                                                        <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.branchmodels.table.branch')}}</span> : {{$item->usermodelbranch->branch->name}}</h5>
                                                        <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.saas.packages.items.feature')}}</span> : </h5>
                                                        <div class="">
                                                            <ul class="ratting-item d-flex p-0 m-0">
                                                                @foreach($item->featurenames as $feat)
                                                                    <li class="" style="background-color: #1F9FD8;margin-right:5px;padding: 0px 5px;border-radius: 3px;color: white;font-size: 12px;"> {{$feat}}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>




                                                    </div>
                                                </div>
                                                <div style="position:absolute;bottom:0;left:0;width:100%;margin-bottom:0px">
                                                    <ul class="ratting-item d-flex align-items-center justify-content-center p-0 m-0">
                                                        @if(auth()->user()->type=="subcustomer")
                                                            <li class="text-center" style="background-color: var(--iq-primary);margin:auto;padding:10px 0;border-right:1px solid #eee;border-radius:0 0 10px 10px;color: white;width:100%;font-size: 16px;"> <a   href="{{ route('branchmodels.show',[$item->usermodelbranch->id]) }}" style="color: white;">{{__('app.saas.packages.items.Show')}}</a></li>
                                                        @endif
                                                    </ul>


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- myModalDelete -->
    <div id="myModalDelete" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.users.delete')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('app.users.delete_message')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.users.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="delete_option('customer/customerUsers');">{{__('app.users.delete')}}</button>
                </div>
            </div>
        </div>
    </div>




@endsection
