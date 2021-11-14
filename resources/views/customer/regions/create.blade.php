@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branches.page_title.create')}}
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
                                <h4 class="card-title">{{__('app.customers.regions.page_title.create')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('customerRegions.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12" style="text-align: center">
                                            <div class="kt-avatar" id="kt_profile_avatar_2">
                                                <div class="kt-avatar__holder" style="width: 90%;background-image: url({{ session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg')}})"></div>
                                                <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.changeregion')}}">
                                                    <i class="ri-pencil-line"></i>
                                                    <input type='file' name="photo" accept="image/png, image/gif, image/jpeg" />
                                                </label>
                                                <span class="form-text text-muted">{{__('app.settings.changeregion_desc')}}</span>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="border-bottom col-12 mb-2 mt-2 clearfix"></div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="name">{{__('app.customers.branches.table.name')}} *</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="{{__('app.customers.branches.table.name')}}" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


{{--                                        <div class="form-group col-md-12">--}}
{{--                                            <label for="code">{{__('app.customers.branches.table.code')}} *</label>--}}
{{--                                            <input required type="number" name="code" class="form-control" id="code" placeholder="{{__('app.customers.branches.table.code')}}" value="{{ old('code') }}">--}}
{{--                                            @error('code')--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                                <strong>{{ $message }}</strong>--}}
{{--                                            </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}






{{--                                        <div class="form-group col-md-12">--}}
{{--                                            <label for="price">{{__('app.customers.branches.table.description')}}</label>--}}
{{--                                            <input   type="text"  name="description" class="form-control" id="description" placeholder="{{__('app.customers.branches.table.description')}}" value="{{ old('description') }}">--}}
{{--                                            @error('description')--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                                 <strong>{{ $message }}</strong>--}}
{{--                                             </span>--}}
{{--                                            @enderror--}}

{{--                                        </div>--}}








                                    </div>
                                    <div class="border-bottom col-12 mb-2 mt-2 clearfix"></div>
                                    <button type="submit" class="btn btn-primary">{{__('app.customers.branches.save')}}</button>
                                    <button type="button" class="btn btn-danger back">{{__('app.back')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
