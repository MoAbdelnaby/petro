@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branches.page_title.update')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@push('css')
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
@endpush

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
                                <form id="branchForm" method="POST"
                                      action="{{ route('customerBranches.update',[$id]) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="row">
                                        <div class="col-md-6 row">
                                            <div class="form-group col-md-12" style="text-align: center">
                                                <div class="kt-avatar" id="kt_profile_avatar_2">
                                                    <div class="kt-avatar__holder"
                                                         style="width: 90%;background-image: url({{ session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg')}})"></div>
                                                    <label class="kt-avatar__upload" data-toggle="kt-tooltip"
                                                           title="{{__('app.settings.changebranch')}}">
                                                        <i class="ri-pencil-line"></i>
                                                        <input type='file' name="photo"
                                                               accept="image/png, image/gif, image/jpeg"/>
                                                    </label>
                                                    <span
                                                        class="form-text text-muted">{{__('app.settings.changebranch_desc')}}</span>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip"
                                                          title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                                </div>
                                                @error('image')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="border-bottom my-2"></div>
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="name">{{__('app.customers.branches.table.name')}} *</label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                       placeholder="{{__('app.customers.branches.table.name')}}"
                                                       value="{{ old('name')? old('name') :$item->name }}">
                                                @error('name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="code">{{__('app.customers.branches.table.code')}} *</label>
                                                <input type="number" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"   name="code" class="form-control" id="code"
                                                       placeholder="{{__('app.customers.branches.table.code')}}"
                                                       value="{{ old('code')? old('code') : $item->code }}">
                                                @error('code')
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="lat">{{__('app.customers.branches.table.lat')}} </label>
                                                <input type="text" name="lat" class="form-control" id="lat" placeholder="{{__('app.customers.branches.table.lat')}}" value="{{ old('lat')? old('lat') : $item->lat }}">
                                                @if($errors->has('lat'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('lat') }}</strong>
                                                    </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="lng">{{__('app.customers.branches.table.lng')}} </label>
                                                <input type="text" name="lng" class="form-control" id="lng" placeholder="{{__('app.customers.branches.table.lng')}}" value="{{ old('lng')? old('lng') : $item->lng }}">
                                                @if($errors->has('lng'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('lng') }}</strong>
                                                    </span>
                                                    @enderror
                                            </div>


                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label
                                                    for="area_count">{{__('app.customers.branches.table.area_count')}}
                                                    *</label>
                                                <input type="number" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"
                                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                       maxlength="1" name="area_count" class="form-control"
                                                       id="area_count"
                                                       placeholder="{{__('app.customers.branches.table.area_count')}}"
                                                       value="{{ old('area_count')? old('area_count') : $item->area_count }}">
                                                @error('area_count')
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 row p-0 m-0">
                                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                    <label for="top">{{__('app.customers.branches.table.top')}}
                                                        *</label>
                                                    <div class="input-group">
                                                        <input type="number" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"   name="top" class="top form-control"
                                                               disabled="disabled" id="top" step=".1" min="0" max="100"
                                                               value="{{ $item->top }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>

                                                    @error('top')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                    <label for="left">{{__('app.customers.branches.table.left')}}
                                                        *</label>
                                                    <div class="input-group">
                                                        <input type="number" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"   name="left" class="top form-control"
                                                               disabled="disabled" id="left" step=".1" min="0" max="100"
                                                               value="{{ $item->left }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    @error('left')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="code">{{__('app.customers.branches.table.region')}}
                                                    *</label>
                                                <select class="form-control branch-reg" required name='region_id'>
                                                    <option value="">Select</option>
                                                    @foreach ($regions as $reg)
                                                        <option data-reg="{{$reg->branches}}"
                                                                data-img="{{ $reg->full_photo?? '' }}"
                                                                value="{{ $reg->id }}" {{ $item->region_id == $reg->id ? 'selected' : '' }}>{{ $reg->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('region')
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="code">{{ __('app.Models') }} *</label>
                                                <select class="form-control select_models" disabled name='models[]'
                                                        multiple>
                                                    <option value="">{{ __('select') }}</option>
                                                    <option value="3" selected>{{ __('app.PlaceMaintenance') }}</option>
                                                    <option value="4" selected>{{ __('app.CarPlates') }}</option>
                                                </select>
                                                @error('models')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="reg-img form-group col-sm-12 col-md-6 col-lg-6">
                                            <img
                                                src="{{ $item->region ? url("storage/".$item->region->full_photo ) : asset('/images/select-region.svg') }}"
                                                class="regionImage" style="display: block">
                                            <img src="{{ asset('images/mark_blue.png')}}" width="20" class="draggable"
                                                 style="left: {{$item->left}}%; top: {{$item->top}}%;" alt="">
                                            @if($item->region)
                                                @foreach($item->region->branches as $branch)
                                                    @if($branch->name != $item->name)
                                                        <img src="{{ asset('images/mark_black.png')}}" width="20"
                                                             class="mark_black" title="{{ $branch->name }}"
                                                             style="position: absolute;left: {{$branch->left}}%; top: {{$branch->top}}%;"
                                                             alt="">
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="border-bottom my-2"></div>
                                    <button type="submit"
                                            class="btn btn-primary">{{__('app.customers.branches.save')}}</button>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function () {
            $('.draggable').draggable({containment: ".reg-img", scroll: false});
            var width = $('.reg-img').innerWidth();
            var height = $('.reg-img').innerHeight();
            $('body').delegate('.reg-img img.draggable', 'mouseleave', function () {
                var left = Number.parseFloat($(this).position().left / width * 100).toFixed(1);
                var top = Number.parseFloat($(this).position().top / height * 100).toFixed(1);
                $('#left').val(left)
                $('#top').val(top)
            });

            $('.branch-reg').select2({
                placeholder: 'Assign To Existing Region Or Type New Region Name',
                tags: true,
                allowClear: true,
                tokenSeparators: [',', ' ']
            });
        });

        $(document).on('change', '.branch-reg-edit', function (e) {
            $('.reg-img img.mark_black').remove()
            var selected = $(this).find('option:selected');
            var handler = selected.data('img');


            if (selected.attr('data-reg')) {
                var branchesReg = JSON.parse(selected.attr('data-reg'));
                for (var q = 0; q < branchesReg.length; q++) {
                    $('.reg-img').append('<img src="/images/mark_black.png" width="20" class="mark_black" title="' + branchesReg[q].name + '" style="position: absolute; left: ' + branchesReg[q].left + '%; top: ' + branchesReg[q].top + '%;" alt="">')
                }
            }

            if (selected.data('img') != undefined) {
                $('.reg-img img').show();
                $('.reg-img img.regionImage').attr('src', app_url + '/storage/' + handler).show();
            } else {
                $('.reg-img img').hide();
                $('.reg-img img.regionImage').attr('src', '/images/select-region.svg').show();
            }

        });
        $('#branchForm').on('submit', function () {
            $('input, select').prop('disabled', false);
        });
        $('.select_models').select2();
    </script>



@endpush
