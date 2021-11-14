@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.customers.branches.page_title.create')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <style>
        .invalid-feedback{
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
                                <h4 class="card-title">{{__('app.customers.branches.page_title.create')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form id="branchForm"   method="POST" action="{{ route('customerBranches.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 row">
                                            <div class="form-group col-md-12" style="text-align: center">
                                                <div class="kt-avatar" id="kt_profile_avatar_2">
                                                    <div class="kt-avatar__holder" style="width: 90%;background-image: url({{ session()->has('darkMode') ? url('/images/models/dark/branch.svg'):url('/images/models/default/branch.svg')}})"></div>
                                                    <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.changebranch')}}">
                                                        <i class="ri-pencil-line"></i>
                                                        <input type='file' name="photo" accept="image/png, image/gif, image/jpeg" />
                                                    </label>
                                                    <span class="form-text text-muted">{{__('app.settings.changebranch_desc')}}</span>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                                </div>
                                            </div>

                                            <div class="border-bottom my-2"></div>
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="name">{{__('app.customers.branches.table.name')}} *</label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="{{__('app.customers.branches.table.name')}}" value="{{ old('name') }}">
                                               @if($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="code">{{__('app.customers.branches.table.code')}} *</label>
                                                <input  type="number" name="code" class="form-control" id="code" placeholder="{{__('app.customers.branches.table.code')}}" value="{{ old('code') }}">
                                                @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="area_count">{{__('app.customers.branches.table.area_count')}} *</label>
                                                <input  type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                       maxlength="1" name="area_count" class="form-control" id="area_count" placeholder="{{__('app.customers.branches.table.area_count')}}" value="{{ old('area_count') }}">
                                                @error('area_count')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6   row p-0 m-0">
                                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                    <label for="top">{{__('app.customers.branches.table.top')}} *</label>
                                                    <div class="input-group">
                                                        <input type="number" name="top" class="top form-control" disabled id="top" step=".1" min="0" max="100" value="0.0">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>

                                                    @error('top')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group  col-sm-12 col-md-6 col-lg-6">
                                                    <label for="left">{{__('app.customers.branches.table.left')}} *</label>
                                                    <div class="input-group">
                                                        <input type="number" name="left" class="top form-control" disabled id="left" step=".1" min="0" max="100" value="0.0">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    @error('left')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="code">{{__('app.customers.branches.table.region')}} *</label>
                                                <select class="form-control branch-reg" required name='region_id' >
                                                    <option value=""  >select</option>

                                                    @foreach ($regions as $reg)
                                                        <option data-reg="{{$reg->branches}}" data-img="{{ $reg->photo ?? '' }}" value="{{ $reg->id }}" {{ old('region_id') == $reg->id ? 'selected' : '' }}>{{ $reg->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('region')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label for="code">{{ __('app.Models') }} *</label>
                                                <select class="form-control select_models" disabled name='models[]' multiple>
                                                    <option value="">{{ __('app.select') }}</option>
                                                    <option value="3" selected>{{ __('app.PlaceMaintenance') }}</option>
                                                    <option value="4" selected>{{ __('app.CarPlates') }}</option>
                                                </select>
                                                @error('models.*')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class=" reg-img form-group col-sm-12 col-md-6">
                                            <img src="{{ asset('/images/mark_blue.png')}}" width="20" class="draggable" style="position:absolute ;left: 50%; top: 50%; display: none" alt="">
                                            <img src="{{resolveLang()}}/images/select-region.svg" class="regionImage">
                                        </div>


                                    </div>
                                    <div class="border-bottom my-2"></div>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
                $('.draggable').draggable({containment: ".reg-img", scroll: false});
                var width = $('.reg-img').innerWidth();
                var height = $('.reg-img').innerHeight();
            $('body').delegate('.reg-img img.draggable','mouseleave',function (){
                console.log($(this).position().left);
                var left = Number.parseFloat($(this).position().left/width*100).toFixed(1);
                var top = Number.parseFloat($(this).position().top/height*100).toFixed(1);
                $('#left').val(left);
                $('#top').val(top);
                console.log( $('#left').val())
                console.log( $('#top').val())
            });


            $('.branch-reg').select2({
                placeholder: 'Assign To Existing Region Or Type New Region Name',
                tags: true,
                allowClear: true,
                tokenSeparators: [',', ' ']
            });
        });

        $('.select_models').select2();

        $(document).on('change', '.branch-reg', function(e) {
            var lang = "{{ app()->getLocale() }}";
            var directionImage = "asset_en";
            if(lang == "ar"){
                directionImage = "asset_ar";
            }
            else {
                directionImage = "asset_en";
            }

            $('.reg-img img.mark_black').remove()
            var selected = $(this).find('option:selected');
            var handler = selected.data('img');
            if(selected.attr('data-reg')){
                var branchesReg = JSON.parse(selected.attr('data-reg'));
                for (var q=0; q < branchesReg.length;q++){
                    $('.reg-img').append('<img src="/images/mark_black.png" width="20" class="mark_black" title="'+branchesReg[q].name+'" style="position: absolute; left: '+branchesReg[q].left+'%; top:'+branchesReg[q].top+'% ;" alt="">')
                }
            }

            if(selected.data('img') != undefined){
                $('.reg-img img').show();
                $('.reg-img img.regionImage').attr('src',app_url+'/storage/'+handler).show();
            }
            else {
                $('.reg-img img').hide();
                $('.reg-img img.regionImage').show();
                $('.reg-img img.regionImage').attr('src',app_url+'/'+directionImage+'/images/select-region.svg');
            }

        });

        $('#branchForm').on('submit', function() {
            $('input, select').prop('disabled', false);
        });

    </script>


@endpush
