@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.saas.features.page_title.create')}}
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
                                <h4 class="card-title">{{__('app.saas.features.page_title.create')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('features.store') }}">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="name">{{__('app.saas.features.table.name')}} *</label>
                                            <input required type="text" name="name" class="form-control" id="name" placeholder="{{__('app.saas.features.table.name')}}" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>






                                        <div class="form-group col-md-12">
                                            <label for="price">{{__('app.saas.features.table.price')}}</label>
                                            <input  min="0" type="number"  name="price" class="form-control" id="price" placeholder="{{__('app.saas.features.table.price')}}" value="{{ old('price') }}">
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror

                                        </div>








                                    </div>

                                    <button type="submit" class="btn btn-primary">{{__('app.saas.features.save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
