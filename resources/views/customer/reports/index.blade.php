@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.Reports')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-selection.select2-selection--multiple {
            min-height: 40px !important;
        }

        .select-model h3 {
            width: 230px;
        }

        .branches-cont ul {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 0;
            padding-left: 0;
        }

        .branches-cont ul li {
            margin-left: 2rem;
            list-style: disc inside;
            line-height: 3.6;
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
                            <div>
                                <div class="row col-12 p-0 m-0 mb-3  menu-and-filter menu-and-filter--custom">
                                    <div class="col">
                                        <ul class="nav nav-tabs nav-tabs--custom" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active"
                                                   href="{{ route('reports.index')}}">{{ __('app.most_statistics') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.show',array_merge(['type'=>'place'], request()->toArray()))}} @else {{ route('reports.show','place')}} @endif">{{ __('app.Bay_Area') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.show',array_merge(['type'=>'plate'], request()->toArray()))}} @else {{ route('reports.show','plate')}} @endif">{{ __('app.Car_Plate') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.show',array_merge(['type'=>'invoice'], request()->toArray()))}} @else {{ route('reports.show','invoice')}} @endif">{{ __('app.Invoice') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.show',array_merge(['type'=>'welcome'], request()->toArray()))}} @else {{ route('reports.show','welcome')}} @endif">{{ __('app.Welcome_Message') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.show',array_merge(['type'=>'backout'], request()->toArray()))}} @else {{ route('reports.show','backout')}} @endif">{{ __('app.backout') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@if(request('filter_type') != null) {{route('report.show',array_merge(['type'=>'stayingAverage'], request()->toArray()))}} @else {{ route('reports.show','stayingAverage')}} @endif">{{ __('app.staying_car_average') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mb-2 filter-pills-cont">
                                        <div class="filter-dropdown">
                                            <a class="btn btn-info waves-effect waves-light px-2 py-2 btn-sm"
                                               href="{{route('reports.index')}}">
                                                <i class="fas fa-bookmark"></i> &nbsp;{{ __('app.Default_report') }}
                                            </a>
                                            <a class="btn btn-info waves-effect waves-light px-2 py-2 btn-sm static_download">
                                                <i class="fas fa-download"></i> &nbsp;{{ __('app.Download') }}
                                            </a>
                                            <a class="btn-filter btn btn-primary waves-effect waves-light px-2 py-2"
                                               data-toggle="dropdown" href="#">
                                                <i class="fa-solid fa-filter"></i> &nbsp;{{ __('app.Filter') }}
                                            </a>
                                            <div class="filter-content" aria-labelledby="dropdownMenuButton">
                                                <form action="{{route('reports.filter')}}" method="post"
                                                      class="filter-form">
                                                    @csrf
                                                    <div class="row">
                                                        <div id="branch_container" class="col-md-12">
                                                            <div class="row">
                                                                <div class=" col-md-10" id="branch_selection">
                                                                    <lebel>{{ __('app.Select_branches') }}:</lebel>

                                                                    <select class="form-control select_2 required"
                                                                            multiple id="select_branch" name="lists[]">
                                                                        @foreach($branches as $branch)
                                                                            <option value="{{$branch->id}}"
                                                                                    @if(in_array($branch->id,request('lists')??[])) selected @endif>{{$branch->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Please select branch.
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2"
                                                                     style="margin-left: -25px; padding-top: 5px">
                                                                    <label for="selectallbranches"
                                                                           class="custom-checkbox pl-4 mt-4">
                                                                        <input class="trashselect" type="checkbox"
                                                                               name="trashs[]" id="selectallbranches"
                                                                               value="1">
                                                                        <span class="checkmark"></span>
                                                                        <strong>All</strong>

                                                                    </label>
                                                                    {{-- <input type="checkbox" id="selectallbranches" > Select All --}}
                                                                    {{--                                                                    <input type="button" id="checkValButton" value="check Selected">--}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group input-group input-daterange">
                                                        <div class="d-flex align-items-end row">
                                                            <div class="col-md-12 mt-2">
                                                                <label
                                                                    class="mb-0  p-0">{{__('app.gym.Start_Date')}}</label>
                                                                <input type="datetime-local"
                                                                       value="{{request('start')}}" name="start"
                                                                       class="form-control"
                                                                       max="{{\Carbon\Carbon::now()->addDay()->format('Y-m-d')}}"
                                                                       oninput="if (this.value >= this.max) this.value = this.max;"
                                                                />
                                                            </div>

                                                            <div class="col-md-12 mt-2">
                                                                <label class="mb-0 ">{{__('app.gym.End_Date')}}</label>
                                                                <input type="datetime-local" value="{{request('end')}}"
                                                                       name="end"
                                                                       class="form-control"
                                                                       max="{{\Carbon\Carbon::now()->addDay()->format('Y-m-d')}}"
                                                                       oninput="if (this.value >= this.max) this.value = this.max;"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center mt-4">
                                                        <button type="submit"
                                                                class="btn btn-secondary waves-effect waves-light px-4 py-2 submit-btn">
                                                            {{ __('app.Filter') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="related-heading mb-3 m-0 row col-12 related-heading--custom branches-cont"
                                     style="padding: 15px">
                                    <h2>{{ __("app.Branches")}} : </h2>
                                    @if($list_report)
                                        <ul>
                                            @foreach($list_report as $index => $elemnt)
                                                <li>{{$elemnt}}</li>
                                                @if($index == 4)
                                                    <li>.....</li>
                                                    @break
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        <h4 class="ml-4" style="line-height: 2.5">All Branches </h4>
                                    @endif

                                    <div class="duration-cont col py-0">
                                        <div class="duration">
                                            <i>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <defs></defs>
                                                    <g id="Stockholm-icons-/-Home-/-Timer" stroke="none"
                                                       stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                        <path
                                                            d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                            id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                                        <path
                                                            d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                            id="Combined-Shape" fill="#000000"></path>
                                                        <path
                                                            d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                            id="Combined-Shape" fill="#000000"></path>
                                                        <path
                                                            d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                            id="Path-107" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                            </i>
                                            <p>
                                                <b>{{ __('app.from') }} : </b>
                                                {{request('start')??now()->startOfYear()->toDateString()}}
                                            </p>
                                            <i>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <defs></defs>
                                                    <g id="Stockholm-icons-/-Home-/-Timer" stroke="none"
                                                       stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                        <path
                                                            d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z"
                                                            id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                                        <path
                                                            d="M13,5.06189375 C12.6724058,5.02104333 12.3386603,5 12,5 C11.6613397,5 11.3275942,5.02104333 11,5.06189375 L11,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C14.5522847,2 15,2.44771525 15,3 C15,3.55228475 14.5522847,4 14,4 L13,4 L13,5.06189375 Z"
                                                            id="Combined-Shape" fill="#000000"></path>
                                                        <path
                                                            d="M16.7099142,6.53272645 L17.5355339,5.70710678 C17.9260582,5.31658249 18.5592232,5.31658249 18.9497475,5.70710678 C19.3402718,6.09763107 19.3402718,6.73079605 18.9497475,7.12132034 L18.1671361,7.90393167 C17.7407802,7.38854954 17.251061,6.92750259 16.7099142,6.53272645 Z"
                                                            id="Combined-Shape" fill="#000000"></path>
                                                        <path
                                                            d="M11.9630156,7.5 L12.0369844,7.5 C12.2982526,7.5 12.5154733,7.70115317 12.5355117,7.96165175 L12.9585886,13.4616518 C12.9797677,13.7369807 12.7737386,13.9773481 12.4984096,13.9985272 C12.4856504,13.9995087 12.4728582,14 12.4600614,14 L11.5399386,14 C11.2637963,14 11.0399386,13.7761424 11.0399386,13.5 C11.0399386,13.4872031 11.0404299,13.4744109 11.0414114,13.4616518 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z"
                                                            id="Path-107" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                            </i>
                                            <p>
                                                <b>{{ __('app.to') }} : </b>
                                                {{request('end')??now()->toDateString()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active">
                                        <div class="row" id="statistic">
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('customerRegions.index')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Regions') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-primary  mr-2">
                                                                    <i class="fa-solid fa-location-dot"></i></div>
                                                                <h3>{{$statistics['regions']}}</h3>
                                                            </div>
                                                            <div
                                                                class="iq-map text-primary font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('customerBranches.index')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Branches') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-danger mr-2">
                                                                    <i class="fa-solid fa-code-branch"></i></div>
                                                                <h3>{{$statistics['active_branches']}}</h3>
                                                                <h4>&nbsp;({{$statistics['branches']??0}})</h4>
                                                            </div>
                                                            <div
                                                                class="iq-map text-danger font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{url('customer/customerPackages')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Models') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-warning mr-2">
                                                                    <i class="fa-solid fa-server"></i></div>
                                                                <h3>2</h3>
                                                            </div>
                                                            <div
                                                                class="iq-map text-warning font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('customerUsers.index')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Users') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-info mr-2">
                                                                    <i class="fa fa-users"></i></div>
                                                                <h3>{{$statistics['users']}}</h3></div>
                                                            <div class="iq-map text-info font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','place')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.area_count') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-primary  mr-2">
                                                                    <i class="fa fa-bars"></i></div>
                                                                <h3>{{$statistics['areas']}}</h3>
                                                            </div>
                                                            <div
                                                                class="iq-map text-primary font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','plate')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Car_Count') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-info mr-2">
                                                                    <i class="fa fa-car"></i></div>
                                                                <h3>{{$statistics['cars']}}</h3></div>
                                                            <div class="iq-map text-info font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','invoice')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Invoice') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon  mr-2"
                                                                    style="background: #00ff9e29">
                                                                    <i class="fa fa-file-text text-success"></i>
                                                                </div>
                                                                <h3>{{$statistics['invoice']}}</h3>
                                                            </div>
                                                            <div
                                                                class="iq-map text-warning font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','backout')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.backout') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-danger mr-2">
                                                                    <i class="fas fa-file-excel text-danger"></i></div>
                                                                <h3>{{$statistics['backout']}}</h3></div>
                                                            <div
                                                                class="iq-map text-danger font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','serving')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.staying_car_average') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-primary  mr-2">
                                                                    <i class="fa fa-clock-o"></i></div>
                                                                <h3>{{$statistics['serving']}}</h3>&nbsp;<h4>@lang('app.minute')</h4>
                                                            </div>
                                                            <div
                                                                class="iq-map text-primary font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','place')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Duration_Work') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-info mr-2">
                                                                    <i class="fa fa-clock-o"></i></div>
                                                                <h3>{{round($statistics['work'] / 60)}}</h3>&nbsp;<h4>@lang('app.Hours')</h4>
                                                            </div>
                                                            <div class="iq-map text-info font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','place')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Duration_Empty') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-danger mr-2">
                                                                    <i class="fa fa-clock-o"></i></div>
                                                                <h3>{{round($statistics['empty'] / 60)}}</h3>&nbsp;<h4>@lang('app.Hours')</h4>
                                                            </div>
                                                            <div
                                                                class="iq-map text-danger font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <a href="{{route('reports.show','welcome')}}" class="iq-card-body"
                                                       style="padding: 25px 20px !important;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h6 class='iq-card-title'>{{ __('app.Welcome') }}</h6>
                                                        </div>
                                                        <div
                                                            class="iq-customer-box d-flex align-items-center justify-content-between mt-3 position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="rounded-circle iq-card-icon iq-bg-warning mr-2">
                                                                    <i class="fa fa-comment"></i>
                                                                </div>
                                                                <h3>{{$statistics['welcome']}}</h3>
                                                            </div>
                                                            <div
                                                                class="iq-map text-warning font-size-32">
                                                                <i class="ri-bar-chart-grouped-line"></i></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        $(document).ready(function () {
            $("#selectallbranches").click(function () {
                if ($("#selectallbranches").is(':checked')) {
                    $("#select_branch > option").prop("selected", "selected");
                    $("#select_branch").trigger("change");
                } else {
                    $("#select_branch").val(null);
                    $("#select_branch").trigger("change");
                }
            });

            $("#checkValButton").click(function () {
                alert($("#select_branch").val());
            });

            $('.btn-filter').on('click', function () {
                $(this).closest('.filter-dropdown').find('.filter-content').toggleClass('open');
            })
            $('.filter-form').on('submit', function (e) {
                if (!$(this).find('#branch_selection select').val().length) {
                    e.preventDefault();
                    $(this).find('.invalid-feedback').show()
                }
            });

            $("#select_branch").select2();

            $(".static_download").on('click', function (e) {
                e.preventDefault();

                let currentForm = @json(request()->query());
                let url = '{{route('report.downloadStatistics')}}';
                let token = $('meta[name="csrf-token"]').attr("content");
                let inputs = `<input name="_token" value="${token}">`;

                for (var key of Object.keys(currentForm)) {
                    inputs += `<input name=${key} value=${currentForm[key] ?? ''} >`;
                }

                $(`<form action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
            });
        })
    </script>
@endpush

