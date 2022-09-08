@extends('layouts.dashboard.index')

@section('page_title')
    {{__('app.branch_status')}}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <style>
        #BranchStatusTable_filter label {
            display: none !important;
        }

        .invalid-feedback {
            display: block;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #4285f4;
            width: 30px;
            height: 30px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            position: absolute;
            top: 9px;
            left: -14%;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
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
                                    {{ __('app.Branch_Status_Header'). " ( " . $installed ." ) " }}
                                </h2>
                            </div>
                            <div class="container-fluid">
                                <div class="row mb-3 mt-3 justify-content-center">
                                    <div class="col-lg-4 col-md-4">
                                        <a href="{{route('branches_status',['online_status' => 'online'])}}">
                                            <div class="card text-center">
                                                <div class="card-header row online mx-0 px-0">
                                                    <div class="col-4">
                                                        <img width="100"
                                                             src="{{ asset("images/online-svgrepo-com.svg") }}"
                                                             alt=""></div>
                                                    <div class="col-8">
                                                        <h5><b><i class="fas fa-circle"
                                                                  style="color: green"></i> {{ __('app.branch_online')  }}
                                                            </b></h5>
                                                        <h3><b class="online_num">{{ $on }}</b></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <a href="{{route('branches_status',['online_status' => 'offline'])}}">
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
                                                        <h3><b class="offline_num">{{ $off }}</b></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <a style="cursor: pointer" id="not_linked_branch"
                                           data-url="{{route('branches.not_linked')}}">
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
                                                            <b class="notLinked_num"
                                                               style="color: #fed329">{{ max($installed - ($on+$off),0) }}</b>
                                                        </h3>
                                                    </div>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="related-product-block position-relative col-12">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-2  d-flex flex-column">
                                                    <label class="d-block" for="">Regions</label>
                                                    <select class="form-control nice-select" name="branch_regions"
                                                            id="branch_regions">
                                                        <option value="">@lang('app.all_regions')</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 d-flex flex-column">
                                                    <label class="d-block" for="">Status</label>
                                                    <div>
                                                        <select class="form-control nice-select" name="online_status"
                                                                id="online_status">
                                                            <option value="">@lang('app.all_status')</option>
                                                            <option value="Online"
                                                                {{request('online_status') == 'online' ? 'selected' : ''}}
                                                            >
                                                                @lang('app.branch_online')
                                                            </option>
                                                            <option
                                                                value="Offline" {{request('online_status') == 'offline' ? 'selected' : ''}}>
                                                                @lang('app.branch_offline')
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">

                                                    <div class="row">
                                                        <label class="col-12" for="">Last Stability Range</label>
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
                                                <div class="col-2"></div>
                                                <div class="col-md-3 d-flex flex-column">
                                                    <label class="d-block" for="">Search</label>
                                                    <input class="form-control" id="table_search" type="search">
                                                </div>
                                                {{-- <span class="badge badge-primary">
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
                                                </div> --}}
                                            </div>
                                        </form>
                                        <div class="product_table table-responsive row p-0 m-0 col-12 mt-3">
                                            <table class="table  ui celled table-borde#f14336 text-center"
                                                   id="BranchStatusTable">
                                                <thead class="">
                                                <th>#</th>
                                                <th>{{__('app.branch_name')}}</th>
                                                <th>{{__('app.region')}}</th>
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
                                                            {{  $branch->region->name ?? ''}}
                                                        </td>
                                                        <td>
                                                            @if (\Carbon\Carbon::now()->diffInMinutes($branch->last_connected) <= 15)
                                                                <span class="branch_status" data-value="1">
                                                                    <i class="fas fa-circle" style="color: green"></i>
                                                                    {{ __('app.branch_online')  }}
                                                                </span>
                                                            @else
                                                                <span class="branch_status" data-value="0">
                                                                    <i class="fas fa-circle" style="color: #f14336"></i>
                                                                    {{ __('app.branch_offline') }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td style="position: relative"
                                                            id="stability_{{$branch->code}}">
                                                            <span class="loader"></span>
                                                        </td>
                                                        <td>

                                                            @php($diff = \Carbon\Carbon::now()->diff($branch->last_connected))
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
                                                            <a class="btn btn-dark skew-dark mr-18"
                                                               href="branches-log/{{$branch->code}}"
                                                               target="_blank">{{ __('app.Show') }}</a>
                                                            <a class="btn btn-primary mr-18"
                                                               href="{{ route('customerBranches.show', [$branch->id]) }}"
                                                               target="_blank">{{ __('app.show_bracnh') }}</a>
                                                            <a class="btn btn-info skew-warning  mr-18"
                                                               href="branches-stability/{{$branch->code}}"
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

    <div class="modal fade" id="notLinkedModel" tabindex="-1"
         aria-labelledby="notLinkedModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('app.not_link_branches')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="not_linked_data">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">{{__('app.close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            let branchesData = [];
            let regionsObj = {};

            //Get last stability for each branch
            $.ajax({
                url: "{{route('branch.last_stability')}}",
                dataType: "JSON",
                type: "GET",
                success: function (data) {
                    let rows = $('#BranchStatusTable tr');
                    for (let i = 0; i < rows.length; i++) {
                        let stabilityId = $($(rows)[i]).find('td:nth-child(5)').attr('id');
                        let code = stabilityId?.replace('stability_', '');

                        if (code != undefined) {
                            $(`#stability_${code}`).html(data.stabiliteis[code]?.stability ?? "0 Minute");
                        }

                        let branchName = $($(rows)[i]).find('td:nth-child(2)').text()?.trim();
                        let region = $($(rows)[i]).find('td:nth-child(3)').text()?.trim();
                        let status = $($(rows)[i]).find('.branch_status').text()?.trim();

                        branchesData.push({
                            name: branchName,
                            region,
                            status
                        });

                        if (!(region in regionsObj) && region !== '') {
                            regionsObj[region] = 1
                        }
                    }
                    let regionSelect = $('#branch_regions');

                    Object.keys(regionsObj).forEach(key => {
                        let newOpt = new Option(key, key, false, false);
                        regionSelect.append(newOpt).trigger('change')
                    });

                    // region search
                    let filterRegionFn = function (settings, data, dataIndex) {
                        let selectedRegion = $('#branch_regions').val();
                        var region = data[2] || '' // use data for the age column
                        if (selectedRegion === '') {
                            return true
                        }
                        if (
                            selectedRegion === region
                        ) {
                            return true;
                        }
                        return false;
                    }


                    // status search
                    let statusFilterfn = function (settings, data, dataIndex) {
                        let selectedStatus = $('#online_status').val();
                        var status = data[3].trim() || '' // use data for the age column

                        if (selectedStatus === '') {
                            return true
                        }
                        if (
                            selectedStatus.toUpperCase() === status.toUpperCase()
                        ) {
                            return true;
                        }
                        return false;
                    }

                    // stability search
                    let stabilityFilterfn = function (settings, data, dataIndex) {
                        let fromDayInput = $('#from_day').val()
                        let fromHourInput = $('#from_hour').val()
                        let fromMinuteInput = $('#from_minute').val()
                        let fromDateArr = [];
                        if (fromDayInput) {
                            fromDateArr.push(fromDayInput + ` Day${fromDayInput > 1 ? 's' : ''}`)
                        }
                        if (fromHourInput) {
                            fromDateArr.push(fromHourInput + ` Hour${fromHourInput > 1 ? 's' : ''}`)
                        }
                        if (fromMinuteInput) {
                            fromDateArr.push(fromMinuteInput + ` Minute${fromMinuteInput > 1 ? 's' : ''}`)
                        }

                        let fromDate = fromDateArr.join(' ');

                        let filter = new RegExp(fromDate, 'i');

                        var date = data[4].trim() || '' // use data for the age column

                        if (fromDate === '') {
                            return true
                        }
                        if (
                            date.match(filter)
                        ) {
                            return true;
                        }
                        return false;
                    }


                    $.fn.dataTable.ext.search.push(filterRegionFn);
                    $.fn.dataTable.ext.search.push(statusFilterfn);
                    $.fn.dataTable.ext.search.push(stabilityFilterfn);

                    let table = $('#BranchStatusTable').on('init.dt', function () {
                        let searchInput = $('#table_search');
                        let dataTableSearchInput = $('#BranchStatusTable_filter label input');
                        searchInput.on('keyup', function () {
                            dataTableSearchInput.val(searchInput.val());
                            dataTableSearchInput.trigger('input')
                        })
                    }).dataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4,5]
                                },
                                text: '<i class="fa fa-file-excel-o"></i> Excel',
                                className: 'btn btn-dark skew-dark mr-18 waves-effect waves-light border-0'
                            },
                            {
                                extend: 'pdfHtml5',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4,5]
                                },
                                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                                className: 'btn btn-primaryskew-dark mr-18 waves-effect waves-light'
                            },
                            'colvis'
                        ],

                    });


                    regionSelect.on('select2:select', function (e) {
                        let selectedValue = e.params.data.id;
                        table.fnDraw()
                    });

                    $('#from_day').on('keyup', function () {
                        table.fnDraw()
                    })
                    $('#from_hour').on('keyup', function () {
                        table.fnDraw()
                    })
                    $('#from_minute').on('keyup', function () {
                        table.fnDraw()
                    })

                    $("#online_status").on('select2:select', function () {
                        let filter = $(this).val();
                        table.fnDraw()
                    });
                },
                error: function (data) {
                    let rows = $('#BranchStatusTable tr');
                    for (let i = 0; i < rows.length; i++) {
                        $($(rows)[i]).find('td:nth-child(5)').html("0 Minute");
                    }
                }
            });

            //get Not Linked Branch
            $("#not_linked_branch").on('click', function () {
                $.ajax({
                    url: $(this).data('url'),
                    dataType: "JSON",
                    type: "GET",
                    success: function (data) {
                        $("#not_linked_data").html('');

                        data.not_linked.forEach(function (el) {
                            $("#not_linked_data").append(`<div class="row">
                                <div class="col-md-12">
                                    <a href="{{url('/')}}/{{app()->getLocale()}}/customer/customerBranches/${el.id}">${el.name}</a>
                                </div>
                            </div>`);
                        });

                        $("#notLinkedModel").modal('show');
                    },
                    error: function (data) {
                        $("#notLinkedModel").modal('hide')
                    }
                });
            });

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
