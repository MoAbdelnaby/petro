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
                                <h4 class="card-title">{{__('app.saas.packages.items.active_branches')}}</h4>
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
                            <div class="">
                                <div class="row justify-content-between">
                                    <div class="col-sm-12 col-md-6">

                                    </div>

                                </div>
                                <div class="row">

                                    @foreach($items as $item)
                                        <div class="col-sm-6 col-md-4 col-lg-3 item{{$item->id}}">
                                            <div class=" iq-card"   >

                                                <div class="product-miniature" style="align-content: center;margin: auto;">
                                                    <div class="d-flex justify-content-center">
                                                        <img src="{{ $item->photo ? url('storage/'.$item->photo): ( session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') )}}"  style="width: 90px; margin: 18px 0"   alt="product-image" class="img-fluid">
                                                    </div>
                                                    <hr>
                                                    <div class="product-description">
                                                        <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.branches.table.name')}}</span> : {{$item->name}}</h5>
                                                        {{--                                                                            <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.branches.table.description')}}</span> : {{$item->description}}</h5>--}}
                                                        <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.branches.table.active')}}</span> : {{$item->active==1 ? 'True':'False'}}</h5>



                                                    </div>
                                                </div>
                                                <div >
                                                    <ul class="ratting-item d-flex align-items-center justify-content-center py-3">
                                                        @if(auth()->user()->type=="subcustomer")
                                                            <li class="text-center" style="background-color: var(--iq-primary);margin:auto;padding:6px 0;border-right:1px solid #eee;border-radius:5px;color: white;min-width:130px;font-size: 16px;"> <a   href="{{ route('customerBranches.show',[$item->id]) }}" style="color: white;">{{__('app.customers.branches.show')}}</a></li>
{{--                                                            <li class="text-center" style="background-color: var(--iq-primary);margin:auto;padding:10px 0;border-right:1px solid #eee;border-radius:0 0 0 0px;color: white;width:33%;font-size: 16px;"> <a   href="{{ route('customerBranches.edit',[$item->id]) }}" style="color: white;">{{__('app.customers.branches.edit')}}</a></li>--}}
{{--                                                            <li class="text-center" style="background-color: var(--iq-primary);margin:auto;padding:10px 0;border-radius:0 0 10px 0; width:33%;color: white;font-size: 16px;"> <a style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="delete_alert({{ $item->id }});" >{{__('app.customers.branches.delete')}}</a></li>--}}
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
    <div id="myModalDelete" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
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
