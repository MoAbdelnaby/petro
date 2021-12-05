@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.customers.branches.page_title.index') }}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <form enctype="multipart/form-data" action="{{ route('service.store') }}" method="post">
                @csrf

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="name_ar" class="col-md-2 col-form-label text-capitalize">
                                {{ __('app.service.arabic_name') }}
                            </label>
                            <div class="col-md-8">
                                <input type="text" placeholder="{{ __('app.service.arabic_name') }}" name="name_ar"
                                    id="name_ar" value="{{ old('name_ar') }}" class="form-control" />

                                @error('name_ar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="row">
                            <label for="name_en" class="col-md-2 col-form-label text-capitalize">
                                {{ __('app.service.english_name') }}
                            </label>
                            <div class="col-md-8">
                                <input type="text" placeholder="{{ __('app.service.english_name') }}" name="name_en"
                                    id="name_en" value="{{ old('name_en') }}" class="form-control" />

                                @error('name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    @if (!$id)
                        <div class="col-md-6">
                            <div class="row">
                                <label for="branch_id" class="col-md-2 col-form-label text-capitalize">
                                    {{ __('app.branch') }}
                                </label>
                                <div class="col-md-8">

                                    <select name="branch_id" class="form-control" id="branch_id">
                                        <option value="" selected disabled> -Please select branch-</option>

                                        @foreach ($branches as $item)
                                            <option {{ old('branch_id') == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="branch_id" value="{{ $id }}">
                        <input type="hidden" name="redirect" value="{{ $_SERVER['HTTP_REFERER'] }}">
                    @endif


                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group col-md-12" style="text-align: center">
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
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="description_ar" class="col-md-2 col-form-label text-capitalize">
                                {{ __('app.service.arabic_description') }}
                            </label>
                            <div class="col-md-8">
                                <textarea name="description_ar" id="description_ar"
                                    placeholder="{{ __('app.service.arabic_description') }}"
                                    class="form-control">{{ old('description_ar') }}</textarea>
                                @error('description_ar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="description_en" class="col-md-2 col-form-label text-capitalize">
                                {{ __('app.service.english_description') }}
                            </label>
                            <div class="col-md-8">
                                <textarea name="description_en" id="description_en"
                                    placeholder="{{ __('app.service.english_description') }}"
                                    class="form-control">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="history.go(-1)" type="button" class="btn btn-default text-white">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
