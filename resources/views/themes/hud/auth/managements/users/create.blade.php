@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.users.create_new')}}
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
                                <h4 class="card-title">{{__('app.users.create_new')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST"  id="createuser"  action="{{ route('users.store') }}">
                                    @csrf
                                    <input type="hidden" id="form_type" name="form_type" value="add">
                                    <div class="row">

                                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                                            <label for="name">{{__('app.auth.name')}} *</label>
                                            <input required type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" placeholder="{{__('app.auth.name')}}" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                                            <label for="email">{{__('app.auth.email')}} *</label>
                                            <input required type="email" autocomplete="off"  name="email" class="form-control  @error('email') is-invalid @enderror" id="email" placeholder="{{__('app.auth.email')}}" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                                            <label for="phone">{{__('app.auth.phone')}}</label>
                                            <input type="phone"  name="phone" class="form-control  @error('phone') is-invalid @enderror" id="phone" placeholder="{{__('app.auth.phone')}}" value="{{ old('phone') }}">
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                        </div>

                                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                                            <label for="password">{{__('app.auth.password')}} *</label>
                                            <input required type="password"  name="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="{{__('app.auth.password')}}">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                                            <label for="password_confirmation">{{__('app.auth.password_confirmation')}}</label>
                                            <input required type="password" class="form-control mb-0  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="{{__('app.auth.password_confirmation')}}"  name="password_confirmation" >
                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                            <label>{{__('app.users.table.Type')}}</label>
                                            <select class="form-control" id="usertype" name="type">
                                                <option value="customer">{{__('app.users.table.customer')}}</option>
                                                <option value="subcustomer">{{__('app.users.table.subcustomer')}}</option>
                                                <option value="admin">{{__('app.users.table.admin')}}</option>
                                                <option value="subadmin">{{__('app.users.table.subadmin')}}</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                                            <label class="w-100" for="package">&nbsp;&nbsp;</label>
                                            <div class="custom-control  custom-checkbox">
                                                <input type="checkbox" id="package" class="form-control  @error('package') is-invalid @enderror custom-control-input" name="package" >
                                                <label class="custom-control-label" for="package"> {{__('app.auth.package')}}</label>
                                                @error('package')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-group col-sm-6 col-lg-4 col-xl-3" id="userroles">
                                            <label>{{__('app.users.table.roles')}}</label>
                                            <select class="form-control userroles"  name="roles[]" multiple="multiple">
                                                @foreach($roles as $role)
                                                    <option value="{{$role->name}}">{{$role->display_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>

                                    <div class="col-12 clearfix my-3 border-bottom"></div>

                                    <button type="submit" class="btn btn-primary">{{__('app.users.save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{url('/validator')}}/user.js"></script>
@endpush
