@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.customers.branches.page_title.create')}}
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

                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class=" menu-and-filter menu-and-filter--custom related-heading">
                                <h2>
                                    <img src="{{resolveDark()}}/img/icon_menu/building.svg" width="24"
                                         class="tab_icon-img" alt="">
                                    {{ __('app.Branch_Status_Header') }}
                                </h2>
                            </div>
                            <div class="container-fluid">
                                <div class="row mb-3 mt-3 justify-content-center">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="card text-center">
                                            <div class="card-header row online mx-0 px-0">
                                                <div class="col-4">
                                                    <img width="100" src="{{ asset("images/online-svgrepo-com.svg") }}"
                                                         alt=""></div>
                                                <div class="col-8">
                                                    <h5><b><i class="fas fa-circle"
                                                              style="color: green"></i> {{ __('app.branch_online')  }}
                                                        </b></h5>
                                                    <h3><b>{{ $on }}</b></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="card text-center col-12">
                                            <div class="card-header row offline">
                                                <div class="col-4">
                                                    <img width="100" fill="#f14336"
                                                         src="{{ asset("images/offline-svgrepo-com.svg") }}" alt="">
                                                </div>
                                                <div class="col-8">
                                                    <h5><b><i class="fas fa-circle"
                                                              style="color: #f14336"></i> {{ __('app.branch_offline') }}
                                                        </b>
                                                    </h5>
                                                    <h3><b>{{ $off }}</b></h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="card text-center col-12">
                                            <div class="card-header row offline"
                                                 style=" border-bottom: 5px solid #fed329 !important;">
                                                <div class="col-4">
                                                    <img width="100" fill="#fed329"
                                                         src="{{ asset("assets/images/not_installed.png") }}"
                                                         style="width: 70px; margin-top: 25px"
                                                         alt="">
                                                </div>
                                                <div class="col-8">
                                                    <h5>
                                                        <b>
                                                            <i class="fas fa-circle" style="color: #fed329"></i>
                                                            {{ __('app.no_linked') }}
                                                        </b>
                                                    </h5>
                                                    <h3>
                                                        <b style="color: #fed329">{{ max($installed - ($on+$off),0) }}</b>
                                                    </h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="related-product-block position-relative col-12">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <select class="form-control nice-select" name="online_status"
                                                            id="online_status">
                                                        <option value="">@lang('app.all_status')</option>
                                                        <option value="online"
                                                            {{request('online_status') == 'online' ? 'selected' : ''}}>
                                                            @lang('app.branch_online')
                                                        </option>
                                                        <option
                                                            value="offline" {{request('online_status') == 'offline' ? 'selected' : ''}}>
                                                            @lang('app.branch_offline')
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input class="form-control" name="from_day" min="0"
                                                                   placeholder="Day" type="number" max="365"
                                                                   id="from_day" value="{{request('from_day')}}"
                                                                   oninput="javascript: if (this.value > this.max) this.value = this.value.slice(0, this.maxLength);"
                                                                   maxlength="3">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input class="form-control" name="from_hour" min="0"
                                                                   placeholder="Hour" type="number" max="60"
                                                                   id="from_hour" value="{{request('from_hour')}}"
                                                                   oninput="javascript: if (this.value > this.max) this.value = this.value.slice(0, this.maxLength);"
                                                                   maxlength="2">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input class="form-control" name="from_minute" min="0"
                                                                   placeholder="Minute" type="number" max="60"
                                                                   id="from_minute" value="{{request('from_minute')}}"
                                                                   oninput="javascript: if (this.value > this.max) this.value = this.value.slice(0, this.maxLength);"
                                                                   maxlength="2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="badge badge-primary">
                                                    {{trans('app.last_stability_range')}}
                                                </span>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input class="form-control" name="to_day" placeholder="Day"
                                                                   min="0"
                                                                   id="to_day" value="{{request('to_day')}}"
                                                                   type="number" max="365"
                                                                   oninput="javascript: if (this.value > this.max) this.value = this.value.slice(0, this.maxLength);"
                                                                   maxlength="3">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input class="form-control" name="to_hour" min="0"
                                                                   placeholder="Hour" type="number" max="60"
                                                                   oninput="javascript: if (this.value > this.max) this.value = this.value.slice(0, this.maxLength);"
                                                                   maxlength="2"
                                                                   id="to_hour" value="{{request('to_hour')}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input class="form-control" name="to_minute" min="0"
                                                                   placeholder="Minute" type="number" max="60"
                                                                   oninput="javascript: if (this.value > this.max) this.value = this.value.slice(0, this.maxLength);"
                                                                   maxlength="2"
                                                                   id="to_minute" value="{{request('to_minute')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="submit" class="btn btn-primary"
                                                            id="apply_filter">@lang('app.Apply')</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="product_table table-responsive row p-0 m-0 col-12">
                                            <table class="table dataTable ui celled table-borde#f14336 text-center"
                                                   id="BranchStatusTable">
                                                <thead class="">
                                                <th>#</th>
                                                <th>{{__('app.branch_name')}}</th>
                                                <th>{{ __('app.branch_status') }}</th>
                                                <th>{{ __('app.last_stability') }}</th>
                                                <th>{{ __('app.last_connected') }}</th>
                                                @if(auth()->user()->wakeb_user)
                                                    <th>{{ __('app.installed_status') }}</th>
                                                @endif
                                                <th>{{ __('app.Actions') }}</th>
                                                </thead>
                                                <tbody class="trashbody">
                                                @foreach($branches as $k => $branch)

                                                    <tr>
                                                        <td>{{ $k+1 }}</td>
                                                        <td>
                                                            {{  $branch->name ?? ''}}
                                                        </td>
                                                        <td>
                                                            @if (\Carbon\Carbon::now()->diffInMinutes($branch->created_at) <= 15)
                                                                <i class="fas fa-circle"
                                                                   style="color: green"></i>
                                                                {{ __('app.branch_online')  }}
                                                            @else
                                                                <i class="fas fa-circle" style="color: #f14336"></i>
                                                                {{ __('app.branch_offline') }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (\Carbon\Carbon::now()->diffInMinutes($branch->created_at) <= 15)
                                                                {{$last_stability[$branch->branch_code]['stability']??"0 ". __('app.minute')}}
                                                            @else
                                                                {{"0 ". __('app.minute')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php($diff = \Carbon\Carbon::now()->diff($branch->created_at))
                                                            @if($diff->y)
                                                                {{ __('app.not_connected_yet') }}
                                                            @else
                                                                @if($diff->d)
                                                                    {{ $diff->d }} {{ __('Day'.($diff->d > 1 ? 's' : '')) }}
                                                                @endif
                                                                @if($diff->d || $diff->h)
                                                                    {{ $diff->h }} {{ __('Hour'.($diff->h > 1 ? 's' : '')) }}
                                                                @endif
                                                                {{ $diff->i }} {{ __('Minute'.($diff->i > 1 ? 's' : '')) }}
                                                            @endif
                                                        </td>
                                                        @if(auth()->user()->wakeb_user)
                                                            @if(isset($branch->installed))
                                                                <td>
                                                                    <div
                                                                        class="custom-control custom-switch custom-switch-icon custom-switch-color custom-control-inline"
                                                                        style="cursor: pointer">
                                                                        <input type="checkbox"
                                                                               class="custom-control-input bg-success installed_switch"
                                                                               id="switch{{$branch->id}}"
                                                                               style="width: 1.6rem; height: 1.4rem; cursor: pointer"
                                                                               {{$branch->installed?'checked':''}} data-url="{{ route('branches.change_installed', [$branch->id]) }}">
                                                                        <label class="custom-control-label"
                                                                               for="switch{{$branch->id}}"
                                                                               style="width: 1.6rem; height: 1.4rem; cursor: pointer">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>---</td>
                                                            @endif
                                                        @endif
                                                        <td>
                                                            <a class="btn btn-primary"
                                                               href="branches-log/{{$branch->branch_code}}"
                                                               target="_blank">{{ __('app.Show') }}</a>
                                                            <a class="btn btn-info"
                                                               href="branches-stability/{{$branch->branch_code}}"
                                                               target="_blank">{{ __('app.stability') }}</a>
                                                        </td>
                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{--                            {{ $branches->links() }}--}}
                                </div>
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
        $("#online_status").on('change', function () {
            let filter = $(this).val();
            let url = `${app_url}/customer/branches-status`;
            let inputs = `<input name='online_status' value='${filter}'>`;

            $(`<form action=${url} method="get">${inputs}</form>`).appendTo('body').submit().remove();
        });

        $(document).ready(function () {
            $(document).on('change', '.installed_switch', function () {
                let item = $(this);

                $.ajax({
                    url: $(this).data('url'),
                    dataType: "JSON",
                    type: "POST",
                    success: function (data) {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        }).fire({
                            icon: 'success',
                            title: data.message
                        })
                    },
                    error: function (data) {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        }).fire({
                            icon: 'error',
                            title: "Failed to update status"
                        })
                        item.prop('checked', false);
                    }
                });
            });
        });
    </script>
@endpush
