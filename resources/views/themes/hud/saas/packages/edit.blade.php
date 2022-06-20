@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.saas.packages.page_title.update')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">

                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.saas.packages.page_title.update')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('packages.update',[$id]) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="row p-0 m-0">

                                        <div class="col-lg-9 row">
                                            <div class="form-group col-md-6 col-lg-4">
                                                <label for="name">{{__('app.saas.packages.table.name')}} *</label>
                                                <input required type="text" name="name" class="form-control" id="name" placeholder="{{__('app.saas.packages.table.name')}}" value="{{ old('name')? old('name') :$item->name }}">
                                                @error('name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 col-lg-4">
                                                <label>{{__('app.saas.packages.table.type')}}</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option  {{$item->type=='monthly' ?'selected':''}} value="monthly">{{__('app.saas.packages.table.monthly')}}</option>
                                                    <option  {{$item->type=='annual' ?'selected':''}} value="annual">{{__('app.saas.packages.table.yearly')}}</option>
                                                </select>
                                            </div>
                                            <div id="price_monthly" class="form-group col-md-6 col-lg-4">
                                                <label for="price_monthly">{{__('app.saas.packages.table.price_monthly')}}</label>
                                                <input  min="0" type="number"  name="price_monthly" class="form-control" id="price_monthly" placeholder="{{__('app.saas.packages.table.price_monthly')}}" value="{{ old('price_monthly')? old('price_monthly') :$item->price_monthly }}">
                                                @error('price_monthly')
                                                <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                                @enderror

                                            </div>
                                            <div id="price_yearly" class="form-group col-md-6 col-lg-4">
                                                <label for="desc">{{__('app.saas.packages.table.price_yearly')}}</label>
                                                <input min="0"  type="number"  name="price_yearly" class="form-control" id="price_yearly" placeholder="{{__('app.saas.packages.table.price_yearly')}}" value="{{ old('price_yearly')? old('price_yearly') :$item->price_yearly }}">
                                                @error('price_yearly')
                                                <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                                @enderror

                                            </div>
                                            <div class="form-group col-md-6 col-lg-4">
                                                <label>{{__('app.saas.packages.table.is_offer')}}</label>
                                                <select class="form-control" id="is_offer" name="is_offer">
                                                    <option {{$item->is_offer=='0' ?'selected':''}} value="0">{{__('app.saas.packages.table.No')}}</option>
                                                    <option {{$item->is_offer=='1' ?'selected':''}} value="1">{{__('app.saas.packages.table.Yes')}}</option>
                                                </select>
                                            </div>
                                            <div id="start_date" class="form-group col-md-6 col-lg-4">
                                                <label for="start_date">{{__('app.saas.packages.table.start_date')}} *</label>
                                                <input required type="date" min="{{date('Y-m-d')}}" name="start_date" class="form-control mindate" id="start_date" placeholder="{{__('app.saas.packages.table.start_date')}}" value="{{ old('start_date')? old('start_date') :$item->start_date }}">
                                                @error('start_date')
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div  id="end_date" class="form-group col-md-6 col-lg-4">
                                                <label for="end_date">{{__('app.saas.packages.table.end_date')}} *</label>
                                                <input required type="date" min="{{date('Y-m-d')}}" name="end_date" class="form-control mindate" id="end_date" placeholder="{{__('app.saas.packages.table.end_date')}}" value="{{ old('end_date')? old('end_date') :$item->end_date }}">
                                                @error('end_date')
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="desc">{{__('app.saas.packages.table.desc')}}</label>
                                                <textarea rows="2"  name="desc" class="form-control" id="desc" placeholder="{{__('app.saas.packages.table.desc')}}">{{ old('desc')? old('desc') :$item->desc }}</textarea>
                                                @error('desc')
                                                <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                                @enderror

                                            </div>
                                        </div>



                                    </div>

                                    <div class="col-12 clearfix my-3 border-bottom"></div>


                                    <button type="submit" class="btn btn-primary">{{__('app.saas.packages.save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#price_yearly").hide();
            $("#type").on('change',function (){
                if ($("#type").val()=="annual"){
                    $("#price_monthly").hide();
                    $("#price_yearly").show();
                }else{
                    $("#price_monthly").show();
                    $("#price_yearly").hide();
                }
            });




            // $("#start_date").hide();
            // $("#end_date").hide();
            // $("#is_offer").on('change',function (){
            //     if ($("#is_offer").val()=="0"){
            //         $("#start_date").hide();
            //         $("#end_date").hide();
            //     }else{
            //         $("#start_date").show();
            //         $("#end_date").show();
            //     }
            // });

        });
    </script>
@endsection
