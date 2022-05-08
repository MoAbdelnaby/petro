@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.saas.modelstatus.page_title.update')}}
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
                                <h4 class="card-title">{{__('app.saas.modelstatus.page_title.update')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('modelstatus.update',[$id]) }}">
                                    @csrf
                                    <input type="hidden" id="form_type" name="form_type" value="edit">
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="name">{{__('app.saas.modelstatus.table.name')}} *</label>
                                            <input required type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" placeholder="{{__('app.saas.modelstatus.table.name')}}" value="{{ old('name')? old('name') :$item->name }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="desc">{{__('app.saas.modelstatus.table.desc')}}</label>
                                            <textarea rows="2"  name="desc" class="form-control @error('desc') is-invalid @enderror" id="desc" placeholder="{{__('app.saas.modelstatus.table.desc')}}">{{ old('desc')? old('desc') :$item->desc }}</textarea>
                                            @error('desc')
                                            <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror
                                        </div>
                                            <div class="form-group col-sm-12">
                                                <label>{{__('app.saas.modelstatus.table.model')}}</label>
                                                <select class="form-control" id="model_id" name="model_id">
                                                    @foreach($models as $model)
                                                        <option {{$item->model_id==$model->id ? 'selected':''}} value="{{$model->id}}">{{$model->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>




                                    </div>

                                    <button type="submit" class="btn btn-primary">{{__('app.saas.modelstatus.save')}}</button>
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
    <script src="{{url('/validator')}}/modelstatus.js"></script>
@endpush
