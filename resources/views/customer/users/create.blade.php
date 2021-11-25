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
                                <form method="POST" id="createuser" action="{{ route('customerUsers.store') }}">
                                    @csrf
                                    <input type="hidden" id="form_type" name="form_type" value="add">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <label for="name"><i class="fas fa-user"></i> {{__('app.auth.name')}}
                                                *</label>
                                            <input required type="text" name="name"
                                                   class="form-control  @error('name') is-invalid @enderror" id="name"
                                                   placeholder="{{__('app.auth.name')}}" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <label for="email"><i
                                                    class="fas fa-paper-plane"></i> {{__('app.auth.email')}} *</label>
                                            <input required type="email" name="email"
                                                   class="form-control  @error('email') is-invalid @enderror" id="email"
                                                   placeholder="{{__('app.auth.email')}}" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <label for="phone"><i class="fas fa-phone-alt"></i> {{__('app.auth.phone')}}
                                            </label>
                                            <input name="phone" type="number"
                                                   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                   min=11 maxlength=13
                                                   class="form-control  @error('phone') is-invalid @enderror"
                                                   @error('phone') is-invalid @enderror id="phone"
                                                   placeholder="{{__('app.auth.phone')}}" value="{{ old('phone') }}">
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <label for="password"><i class="fas fa-key"></i> {{__('app.auth.password')}}
                                                *</label>
                                            <input required type="password" name="password"
                                                   class="form-control  @error('password') is-invalid @enderror"
                                                   id="password" placeholder="{{__('app.auth.password')}}">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <label for="password_confirmation"><i
                                                    class="fas fa-key"></i> {{__('app.auth.password_confirmation')}}
                                            </label>
                                            <input required type="password"
                                                   class="form-control mb-0  @error('password_confirmation') is-invalid @enderror"
                                                   id="password_confirmation"
                                                   placeholder="{{__('app.auth.password_confirmation')}}"
                                                   name="password_confirmation">
                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <label for="package">{{__('app.test_speed')}}</label>
                                            <input type="checkbox" style="display: block; width: 46px;" name="speedtest"
                                                   checked="checked"
                                                   class="form-control  @error('speedtest') is-invalid @enderror">
                                            @error('speedtest')
                                             <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror

                                        </div>

                                    </div>
                                    <div class="border-bottom my-2"></div>
                                    <button type="submit" class="btn btn-primary">{{__('app.users.save')}}</button>
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
@push('js')
    <script src="{{url('/validator')}}/user.js"></script>
@endpush
