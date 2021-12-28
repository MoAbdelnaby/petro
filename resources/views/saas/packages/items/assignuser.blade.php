@extends('layouts.dashboard.index')
@section('page_title')
    Assign User
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
                                <h4 class="card-title">{{ __('app.Assign_User') }}</h4>
                            </div>
                        </div>



                        <div class="iq-card-body">
                             id="user-list-table" class="table dataTable table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                                <thead>
                                <tr>
                                    <th>{{__('app.users.table.name')}}</th>
                                    <th>{{__('app.users.table.email')}}</th>
                                    <th>{{__('app.users.table.Parent')}}</th>
                                    <th>{{__('app.saas.packages.package_name')}}</th>
                                    <th>{{__('app.saas.packages.items.active')}}</th>
                                    <th>{{__('app.saas.packages.table.created_at')}}</th>
                                </tr>
                                </thead>
                                <tbody id="searchpackageresult">
                                @foreach($history as $item)
                                    <tr id="row{{$item->id}}">
                                        <td>{{$item->user->name}}</td>
                                        <td>{{$item->user->email}}</td>
                                        <td>{{$item->user->user != null ?$item->user->user->name:''}}</td>
                                        <td>{{$item->package->name}}</td>
                                        <td>{{$item->active ? 'True':'False'}}</td>
                                        <td>{{$item->created_at}}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="row justify-content-between mt-3">
                                <div id="user-list-page-info" class="col-md-6">
                                    <span>{{ __('app.Showing') }} 1 {{ __('app.to') }} {{count($history)}} {{ __('app.of') }} {{count($history)}} {{ __('app.entries') }}</span>
                                </div>

                                <div class="col-md-6">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end mb-0">

                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <br>
                            <br>
                            <div class="new-user-info">
                                <form  method="POST" action="{{ route('packages.assignuserpost',[$id]) }}">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{$id}}">
                                    <div class="row">

                                        <div class="form-group col-md-6 col-lg-4">
                                            <label>{{ __('app.User') }}</label>
                                            <select class="form-control" id="user_id" name="user_id">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="start_date">{{__('app.saas.packages.table.start_date')}} *</label>
                                            <input required type="date" min="{{date('Y-m-d')}}" name="start_date" class="form-control mindate" id="start_date" placeholder="{{__('app.saas.packages.table.start_date')}}" value="{{ old('start_date') }}">
                                            @error('start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="end_date">{{__('app.saas.packages.table.end_date')}} *</label>
                                            <input required type="date" min="{{date('Y-m-d')}}" name="end_date" class="form-control mindate" id="end_date" placeholder="{{__('app.saas.packages.table.end_date')}}" value="{{ old('end_date') }}">
                                            @error('end_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                    </div>

                                    <div class="col-12 clearfix my-3 border-bottom"></div>


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
