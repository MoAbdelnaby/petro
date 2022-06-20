@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branches.page_title.update')}}
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
                                <h4 class="card-title">{{__('app.customers.branches.page_title.update')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('customerRegions.update',[$id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="row">
                                        <div class="form-group col-md-12" style="text-align: center">
                                            <div class="kt-avatar" id="kt_profile_avatar_2">
                                                <div class="kt-avatar__holder" style="width: 90%;@if($item->photo)
                                                    background-image:url({{url('storage/'.$item->photo)}})
                                                @elseif($item->parent != null)
                                                    background-image:url({{url('storage/'.optional($item->parent)->photo)}})
                                                @else
                                                    background-image:url({{ session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg') }} )
                                                @endif">
                                            </div>
                                                <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.changebranch')}}">
                                                    <i class="ri-pencil-line"></i>
                                                    <input type='file' name="photo" disabled accept="image/png, image/gif, image/jpeg" />
                                                </label>
                                                <span class="form-text text-muted">{{__('app.settings.changebranch_desc')}}</span>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="{{ __('app.Cancel_avatar') }}">
                                                       <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                            @error('image')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="border-bottom col-12 mb-2 mt-2 clearfix"></div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="name">{{__('app.customers.branches.table.name')}} *</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="{{__('app.customers.branches.table.name')}}" value="{{ old('name')? old('name') :$item->name }}">
                                            @error('name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
{{--                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">--}}
{{--                                            <label for="code">{{__('app.customers.branches.table.region')}} *</label>--}}
{{--                                            <select class="form-control region_select"  name='parent_id'>--}}
{{--                                                <option value="">Select Parent</option>--}}
{{--                                                @foreach ($regions as $reg)--}}
{{--                                                    <option data-img="{{ $reg->photo ?? '' }}"--}}
{{--                                                            value="{{ $reg->id }}" {{ $item->parent_id == $reg->id ? 'selected' : '' }}>{{ $reg->name}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                            @error('parent_id')--}}
{{--                                            <span class="invalid-feedback d-block" role="alert">--}}
{{--                                                    <strong>{{ $message }}</strong>--}}
{{--                                                </span>--}}
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

@push('js')
    <script>
        $(function () {
            $(".region_select").on('change', function (e) {
                let image = $(this).find(':selected').attr('data-img');
                if (image != undefined) {
                    image = `${app_url}/storage/${image}`;
                    $("#kt_profile_avatar_2 .kt-avatar__holder").attr('style', `background-image: url(${image}) !important;`);
                } else {
                    image = `${app_url}/images/models/default/branch.svg`;
                    $("#kt_profile_avatar_2 .kt-avatar__holder").attr('style', `background-image: url(${image}) !important; width:90%`);
                }
            })
        });
    </script>
@endpush
