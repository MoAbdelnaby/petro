@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.saas.modelfeatures.page_title.update')}}
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
                                <h4 class="card-title">{{__('app.saas.modelfeatures.page_title.update')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('modelfeatures.update',[$id]) }}">
                                    @csrf
                                    <input type="hidden" id="form_type" name="form_type" value="edit">
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="row">



                                            <div class="form-group col-sm-12">
                                                <label>{{__('app.saas.modelfeatures.table.model')}}</label>
                                                <select class="form-control" id="model_id" name="model_id">
                                                    @foreach($models as $model)
                                                        <option {{$item->model_id==$model->id ? 'selected':''}} value="{{$model->id}}">{{$model->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label>{{__('app.saas.modelfeatures.table.feature')}}</label>
                                                <select class="form-control" id="feature_id" name="feature_id">
                                                    @foreach($features as $feature)
                                                        <option {{$item->feature_id==$feature->id ? 'selected':''}} value="{{$feature->id}}">{{$feature->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        <div class="form-group col-md-12">
                                            <label for="price">{{__('app.saas.modelfeatures.table.price')}}</label>
                                            <input  min="0" type="number"  name="price" class="form-control" id="price" placeholder="{{__('app.saas.modelfeatures.table.price')}}" value="{{ old('price')?old('price'):$item->price }}">
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror

                                        </div>


                                    </div>

                                    <button type="submit" class="btn btn-primary">{{__('app.saas.modelfeatures.save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
