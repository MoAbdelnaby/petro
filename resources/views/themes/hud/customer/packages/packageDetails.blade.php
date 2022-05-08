@extends('layouts.dashboard.index')
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-md-6 iq-item-product-left">
                                    <div class="iq-image-container">
                                        <div class="iq-product-cover d-flex justify-content-center">
                                            <img src="{{ session()->has('darkMode') ? url('/images/package.png'):url('/images/package.svg')}}"  alt="product-image" class="img-fluid">
                                        </div>
                                        <div class="iq-additional_slider">
                                            <ul id="product-additional-slider" class="d-flex m-0 p-0">
                                                @foreach($items as $item)
                                                    <li><img src="{{ session()->has('darkMode') ? url('/images/models/dark'):url('/images/models/default') }}/{{$item->model->model->id}}.svg" alt="product-image" class="img-fluid"></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 iq-item-product-right">
                                    <div class="product-additional-details">
                                        <h3 class="productpage_title"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.package')}}</span> : {{$package->name}}</h3>
                                        <div class="ratting">
                                            <ul class="ratting-item d-flex p-0 m-0">
                                                <h5><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.type')}}</span> : {{$package->type}}</h5>
                                            </ul>
                                        </div>
                                        <div class="product-descriptio">
                                            <p> <span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.desc')}}</span> : {{$package->desc}}.</p>
                                        </div>
                                        <div class="product-price">
                                            <div class="regular-price"><b>  ${{$package->type== 'monthly' ? $package->price_monthly:$package->price_yearly}}</b> </div>
                                        </div>
                                        <div class="stock">
                                            <p><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.start_date')}}</span>: <span>{{$package->start_date}}</span></p>
                                        </div>
                                        <div class="stock">
                                            <p><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.customers.packages.table.end_date')}}</span>: <span>{{$package->start_date}}</span></p>
                                        </div>

                                        <div class="stock">
                                            <ul class="ratting-item d-flex p-0 m-0">
                                                @foreach($items as $item)
                                                    <li class="" style="background-color: #1F9FD8;margin-right:5px;padding: 0px 5px;border-radius: 3px;color: white;font-size: 12px;"> {{$item->model->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <br>
                                        <div class="additional-product-action">


                                            <div class="product-action ml-2">
                                                @if(auth()->user()->type=="customer")
                                                <form  method="POST" action="{{ route('customerPackages.requestPackage') }}" id="package_request_form">
                                                    @csrf
                                                    <input type="hidden" name="package_id" id="package_id" value="{{$package->id}}">
                                                <div class="add-to-cart"><a  href=""  onclick="submit_form('package_request_form');" > {{__('app.customers.packages.table.upgrade')}} <i class="fa fa-plus"></i> </a></div>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-5 related-product">
                        <div class="related-heading text-center mb-5">
                            <h2>{{__('app.customers.packages.itemslist')}}</h2>
                        </div>
                        <div class="related-product-block">
                            <ul id="related-slider" class="product_list row p-0">
                                @foreach($items as $item)
                                    <li class="product_item col-xs-12 col-sm-6 col-md-6 col-lg-4" >
                                        <a href="{{ route('branchmodelpreview.index') }}">
                                            <div class="iq-card" style="height: 400px !important;">
                                            <div class="product-miniature">
                                                <div class="thumbnail-container" style="padding-top: 3px;">
                                                    <a href="{{ route('branchmodelpreview.index') }}"> <img src="{{ session()->has('darkMode') ? url('/images/models/dark'):url('/images/models/default') }}/{{$item->model->model->id}}.svg" alt="product-image"  width="120px" height="120px" class="img-fluid m-auto" /></a>
                                                </div>
                                                <hr>
                                                <div class="product-description">
                                                    <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.saas.packages.items.model')}}</span> : {{$item->model->name}}</h5>
                                                    <h5 style="line-height: 2;"><span style="{{ session()->has('darkMode') ? 'color:#ffffff' : 'color:#000' }}" >{{__('app.saas.packages.items.count')}}</span> : {{$item->count}}</h5>


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

                                            </div></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>





@endsection
