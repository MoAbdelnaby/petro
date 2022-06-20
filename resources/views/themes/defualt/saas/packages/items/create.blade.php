@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.saas.packages.items.create')}}
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
                                <h4 class="card-title">{{__('app.saas.packages.items.create')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('packages.createitempost',[$id]) }}">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{$id}}">
                                    <div class="row">

                                        <div class="form-group col-sm-12">
                                            <label>{{__('app.saas.modelfeatures.table.model')}}</label>
                                            <select class="form-control" id="packagemodelitem" name="model_id">
                                                <option value="0">{{__('app.saas.modelfeatures.table.model')}}</option>
                                                @foreach($models as $model)
                                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group col-md-12">
                                            <label for="desc">{{__('app.saas.packages.items.count')}}</label>
                                            <input min="0"  type="number"  name="count" class="form-control" id="count" placeholder="{{__('app.saas.packages.items.count')}}" value="{{ old('count') }}">
                                            @error('count')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror

                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label>{{__('app.saas.modelfeatures.table.feature')}}</label>
                                            <select class="form-control packagefeature" id="packagefeature" name="features[]" multiple="multiple">

                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{__('app.saas.packages.save')}}</button>
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

@endpush
