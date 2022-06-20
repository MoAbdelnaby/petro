@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.change_password')}}
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
                                <h4 class="card-title">{{__('app.change_password')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" id="change_form" action="{{ route('users.editchangepassword') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="oldpassword">{{__('app.auth.oldpassword')}}</label>
                                            <input required type="password" class="form-control mb-0  @error('oldpassword') is-invalid @enderror" id="oldpassword" placeholder="{{__('app.auth.oldpassword')}}"  name="oldpassword" value="{{ old('oldpassword') }}">
                                            @error('oldpassword')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="password">{{__('app.auth.password')}}</label>
                                            <input required type="password" class="form-control mb-0  @error('password') is-invalid @enderror" id="password" placeholder="{{__('app.auth.password')}}"  name="password" value="{{ old('password') }}">
                                            @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="password_confirmation">{{__('app.auth.password_confirmation')}}</label>
                                            <input required type="password" class="form-control mb-0  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="{{__('app.auth.password_confirmation')}}"  name="password_confirmation" value="{{ old('password_confirmation') }}">
                                            @error('password_confirmation')
                                            <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="clearfix border-bottom mb-2 mt-2"></div>

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
    <script src="{{url('/validator')}}/changepassword.js"></script>
@endpush
