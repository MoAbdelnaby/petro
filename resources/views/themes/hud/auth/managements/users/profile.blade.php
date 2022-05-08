@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.profile') }}
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
                                <h4 class="card-title">{{ __('app.profile') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form method="POST" id="profile" action="{{ route('users.updateprofile') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12" style="text-align: center">
                                            <div class="kt-avatar" id="kt_profile_avatar_2">
                                                <div class="kt-avatar__holder"
                                                    style="background-image: url({{ $user->avatar ? url('storage/' . $user->avatar) : 'https://image.shutterstock.com/image-vector/robot-icon-bot-sign-design-260nw-715962319.jpg' }})">
                                                </div>
                                                <label class="kt-avatar__upload" data-toggle="kt-tooltip"
                                                    title="{{ __('app.settings.changeprofile') }}">
                                                    <i class="ri-pencil-line"></i>
                                                    <input type='file' name="avatar"
                                                        accept="image/png, image/gif, image/jpeg" />
                                                </label>
                                                <span
                                                    class="form-text text-muted">{{ __('app.settings.changeprofile_desc') }}</span>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip"
                                                    title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4 col-sm-6 col-lg-4">
                                            <label for="name">{{ __('app.auth.name') }} *</label>
                                            <input required type="text" name="name"
                                                class="form-control  @error('name') is-invalid @enderror" id="name"
                                                placeholder="{{ __('app.auth.name') }}"
                                                value="{{ old('name') ? old('name') : $user->name }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 col-sm-6 col-lg-4">
                                            <label for="email">{{ __('app.auth.email') }} *</label>
                                            <input required type="email" name="email"
                                                class="form-control  @error('email') is-invalid @enderror" id="email"
                                                placeholder="{{ __('app.auth.email') }}"
                                                value="{{ old('email') ? old('email') : $user->email }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 col-sm-6 col-lg-4">
                                            <label for="phone">{{ __('app.auth.phone') }}</label>
                                            <input name="phone" type="number"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                min=11 maxlength=13
                                                class="form-control  @error('phone') is-invalid @enderror" id="phone"
                                                placeholder="{{ __('app.auth.phone') }}"
                                                value="{{ old('phone') ? old('phone') : $user->phone }}">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="border-bottom col-12 my-2"></div>
                                    <button type="submit" class="btn btn-primary">{{ __('app.users.save') }}</button>
                                    <button type="button" class="btn btn-danger back">{{ __('app.back') }}</button>
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
    <script src="{{ url('/validator') }}/profile.js"></script>
@endpush
