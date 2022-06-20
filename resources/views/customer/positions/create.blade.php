@extends('layouts.dashboard.index')

@section('page_title') {{__('app.new_position')}} @endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.new_position')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form method="POST" action="{{ route('positions.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label for="name">{{__('app.Name')}} *</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                   placeholder="{{__('app.Name')}}" value="{{ old('name') }}">
                                            @error('name')
                                                <span style="display: block" class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label for="code">{{__('app.position')}}</label>
                                            <select class="form-control nice-select position_select" name='parent_id'>
                                                <option value="">@lang('app.no_parent')</option>
                                                @foreach ($positions as $reg)
                                                    <option value="{{ $reg->id }}" {{ old('parent_id') == $reg->id ? 'selected' : '' }}>{{ $reg->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <span  style="display: block" class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="description">{{ __('app.description') }}</label>
                                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                                @error('description')
                                                <span style="display: block" class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom col-12 mb-2 mt-2 clearfix"></div>
                                    <button type="submit" class="btn btn-primary">{{__('app.save')}}</button>
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

