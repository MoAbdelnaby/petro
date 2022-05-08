@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.branchmodels.page_title.create')}}
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
                                <h4 class="card-title">{{__('app.customers.branchmodels.page_title.create')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('branchmodels.store') }}">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="name">{{__('app.customers.branchmodels.table.model')}} *</label>
                                            <select class="form-control" id="user_model_id" name="user_model_id">
                                                @foreach($models as $model)
                                                    <option value="{{$model->id}}">{{$model->model->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="price">{{__('app.customers.branchmodels.table.branch')}}</label>
                                            <select class="form-control" id="branch_id" name="branch_id">
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{__('app.customers.branchmodels.save')}}</button>
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
