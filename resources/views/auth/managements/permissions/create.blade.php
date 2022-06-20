@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.permissions.create_new')}}
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
                                <h4 class="card-title">{{__('app.permissions.create_new')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('permissions.store') }}">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="name">{{__('app.permissions.table.name')}} *</label>
                                            <input required type="text" name="name" class="form-control" id="name" placeholder="{{__('app.permissions.table.name')}}" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="display_name">{{__('app.permissions.table.display_name')}}</label>
                                            <input required type="text"  name="display_name" class="form-control" id="display_name" placeholder="{{__('app.permissions.table.display_name')}}" value="{{ old('display_name') }}">
                                            @error('display_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror

                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="group">{{__('app.permissions.table.group')}}</label>
                                            <input required type="text"  name="group" class="form-control" id="group" placeholder="{{__('app.permissions.table.group')}}" value="{{ old('group') }}">
                                            @error('group')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror

                                        </div>


                                    </div>

                                    <button type="submit" class="btn btn-primary">{{__('app.permissions.save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
