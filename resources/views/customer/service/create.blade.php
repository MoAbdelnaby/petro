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
                    <label for="name_ar" class="col-md-2 col-form-label text-capitalize">
                        {{ __('app.service.arabic_name') }}
                    </label>
                    <div class="col-md-8">
                        <input type="text" placeholder="{{ __('app.service.arabic_name') }}" name="name_ar" id="name_ar"
                            value="{{ old('name_ar') }}" class="form-control" />

                        @error('name_ar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name_en" class="col-md-2 col-form-label text-capitalize">
                        {{ __('app.service.english_name') }}
                    </label>
                    <div class="col-md-8">
                        <input type="text" placeholder="{{ __('app.service.english_name') }}" name="name_en" id="name_en"
                            value="{{ old('name_en') }}" class="form-control" />

                        @error('name_en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="image" class="col-md-2 col-form-label text-capitalize">
                        {{ __('app.service.image') }}
                    </label>
                    <div class="col-md-8">
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" />

                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
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

                <div class="form-group row">
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
