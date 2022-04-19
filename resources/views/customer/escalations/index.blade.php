@extends('layouts.dashboard.index')

@section('page_title') {{__('app.escalation')}} @endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.escalation')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            @foreach($escalations as $index => $escalation)
                                <form method="POST" action="{{ route('escalations.update',$escalation->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="code">{{__('app.position')}}</label>
                                            <select class="form-control nice-select" required name='position_id'>
                                                <option value="">@lang('app.select_position')</option>
                                                @foreach ($positions as $reg)
                                                    <option
                                                        value="{{ $reg->id }}" {{$escalation->position_id == $reg->id ? 'selected' : '' }}>
                                                        {{ $reg->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label>{{__('app.time_by_minute')}} *</label>
                                            <input type="number" name="time_minute" required class="form-control" placeholder="{{__('app.time_by_minute')}}"
                                                   value="{{ $escalation->time_minute }}">
                                        </div>
                                        <div class="col-md-12 col-lg-4" style="margin-top: 30px">
                                            <button class="btn btn-info">@lang('app.update_position')</button>
                                            <button type="button" class="deleteEscalation btn btn-danger"
                                                    data-url="{{route('escalations.destroy',$escalation->id)}}">
                                                {{__('app.delete')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                            <hr>
                            <div class="new-user-info">
                                <form method="POST" action="{{ route('escalations.store') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="code">{{__('app.position')}}</label>
                                            <select class="form-control nice-select" required name='position_id'>
                                                <option value="">@lang('app.select_position')</option>
                                                @foreach ($positions as $reg)
                                                    <option
                                                        value="{{ $reg->id }}" {{ old('position_id') == $reg->id ? 'selected' : '' }}>{{ $reg->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="time_minute">{{__('app.time_by_minute')}} *</label>
                                            <input type="number" name="time_minute" class="form-control"
                                                   id="time_minute" required
                                                   placeholder="{{__('app.time_by_minute')}}"
                                                   value="{{ old('time_minute') }}">
                                        </div>
                                        <div class="col-md-12 col-lg-4" style="margin-top: 30px">
                                            <button class="btn btn-primary">@lang('app.add_this_position')</button>
                                        </div>
                                    </div>
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
        $(".deleteEscalation").on('click', function (e) {
            e.preventDefault();
            let url = $(this).data("url");
            let token = '{{csrf_token()}}';

            let inputs = `<input name="_token" value=${token}>`;
            inputs += `<input type="hidden" name="_method" value="DELETE">`;

            $(`<form method="post" action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
        });
    </script>
@endpush
