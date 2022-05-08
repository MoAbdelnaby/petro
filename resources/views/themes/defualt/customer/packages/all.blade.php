@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.packages.table.upgrade')}}
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
                                <h4 class="card-title">{{__('app.customers.packages.table.upgrade')}}</h4>
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
                                <div class="row justify-content-between" style="margin: 20px;">
                                    <div class="col-sm-12 col-md-6">

                                    </div>

                                </div>
                                <div class="row">
                                @foreach($items as $item)
                                        @if(!$active || $item->name!=$active->name)
                                                <div class="col-sm-6 col-mg-3 col-lg-4 item{{$item->id}}">
                                                    <div class=" iq-card"  style="height: 430px !important;" >

                                                                    <div class="product-miniature" style="align-content: center;margin: auto;">
                                                                        <div class="d-flex justify-content-center">
                                                                            <img src="{{ session()->has('darkMode') ? url('/images/package.png'):url('/images/package.svg')}}"  style=" margin: 18px 0"   alt="product-image" height="100px" class="img-fluid">
                                                                        </div>
                                                                        <hr>
                                                                        <div class="product-description">
                                                                            <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.package')}}</span> : {{$item->name}}</h5>
                                                                            <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.type')}}</span> : {{$item->type}}</h5>
                                                                            <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.price')}}</span> :  ${{$item->type== 'monthly' ? $item->price_monthly:$item->price_yearly}}</h5>
                                                                            <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.branches.table.active')}}</span> : {{$item->active==1 ? 'True':'False'}}</h5>



                                                                        </div>
                                                                    </div>
                                                                    <div style="position:absolute;bottom:0;left:0;width:100%;margin-bottom:0px">
                                                                        <form  method="POST" action="{{ route('customerPackages.requestPackage') }}" id="package_request_form">
                                                                            @csrf
                                                                            <input type="hidden" name="package_id" id="package_id" value="{{$item->id}}">

                                                                            <ul class="ratting-item d-flex align-items-center justify-content-center p-0 m-0">


                                                                                @if(auth()->user()->type=="customer")
                                                                                <li class="text-center" style="background-color: var(--iq-primary);margin:auto;padding: 3px 0;border-right:1px solid #eee;border-radius:0 0 0 10px;color: white;width:50%;font-size: 16px;"> <a  href="{{ route('customerPackages.packageDetails',[$item->id]) }}" style="color: white;">{{__('app.saas.packages.items.Show')}}</a></li>
                                                                               <li class="text-center" style="background-color: var(--iq-primary);margin:auto;padding: 3px 0;border-radius:0 0 10px 0; width:50%;color: white;font-size: 16px;"> <a  href=""  onclick="submit_form('package_request_form');"  style="color: white;">{{__('app.customers.packages.table.upgrade')}}</a></li>
@endif
                                                                        </ul>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                </div>
                                        @endif
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
    <div id="myModalDelete" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.customers.branches.delete')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('app.customers.branches.delete_message')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.customers.branches.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="delete_option('customer/customerBranches');">{{__('app.customers.branches.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
