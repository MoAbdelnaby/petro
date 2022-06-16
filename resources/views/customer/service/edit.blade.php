@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.edit_service') }}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@php
$branchIds = $service->branches->pluck('id')->toArray();
@endphp

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"> {{ __('app.edit_service') }}</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="new-user-info">
                        <form enctype="multipart/form-data" action="{{ route('service.update', $service->id) }}"
                            method="post">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label for="branch_id" class="col-md-2 col-form-label text-capitalize">
                                            {{ __('app.branch') }}
                                        </label>

                                        <select name="branch_id[]" class="form-control" id="service_branch_id_edit" multiple >
                                            @foreach ($branches as $item)
                                                <option value="{{ $item->id }}" {{ in_array($item->id,$branchIds) ? 'selected' : '' }}> {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label for="name_ar" class="text-capitalize">
                                            {{ __('app.service.arabic_name') }}
                                        </label>
                                        <input type="text" placeholder="{{ __('app.service.arabic_name') }}"
                                            name="name_ar" id="name_ar" value="{{ old('name_ar') ?? $service->name_ar }}"
                                            class="form-control" />

                                        @error('name_ar')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label for="name_en" class="text-capitalize">
                                            {{ __('app.service.english_name') }}
                                        </label>
                                        <input type="text" placeholder="{{ __('app.service.english_name') }}"
                                            name="name_en" id="name_en" value="{{ old('name_en') ?? $service->name_en }}"
                                            class="form-control" />

                                        @error('name_en')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group" style="text-align: center">
                                        <div class="kt-avatar" id="kt_profile_avatar_2">
                                            <div class="kt-avatar__holder"
                                                style="background-image: url('https://image.shutterstock.com/image-vector/robot-icon-bot-sign-design-260nw-715962319.jpg')">
                                            </div>
                                            <label class="kt-avatar__upload" data-toggle="kt-tooltip"
                                                title="{{ __('app.Image') }}">
                                                <i class="ri-pencil-line"></i>
                                                <input type='file' name="image" accept="image/png, image/gif, image/jpeg" />
                                            </label>
                                            <span class="form-text text-muted">{{ __('app.Image') }}</span>
                                            <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label for="description_ar" class="text-capitalize">
                                            {{ __('app.service.arabic_description') }}
                                        </label>
                                        <textarea name="description_ar" id="description_ar"
                                            placeholder="{{ __('app.service.arabic_description') }}"
                                            class="form-control">{{ old('description_ar') ?? $service->description_ar }}</textarea>
                                        @error('description_ar')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label for="description_en" class="text-capitalize">
                                            {{ __('app.service.english_description') }}
                                        </label>
                                        <textarea name="description_en" id="description_en"
                                            placeholder="{{ __('app.service.english_description') }}"
                                            class="form-control">{{ old('description_en') ?? $service->description_en }}</textarea>
                                        @error('description_en')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 border-bottom my-2"></div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ __('app.Save') }}</button>
                                    <a href="#" onclick="history.go(-1)" type="button"
                                        class="btn btn-danger text-white">{{ __('app.back') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script rel="stylesheet" src="{{asset('assets/js/select2.min.js')}}"></script>
    <script>
        $(function () {
            $("#service_branch_id_edit").select2({
                placeholder: "Select a Branch",
                allowClear: true
            });
        });
    </script>
@endpush
