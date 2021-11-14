@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.home')}}
@endsection
@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>{{ __('app.Invoice_Sent') }}</h6>
                                <span class="iq-icon"><i class="ri-information-fill"></i></span>
                            </div>
                            <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle iq-card-icon iq-bg-primary mr-2"><i
                                            class="ri-inbox-fill"></i></div>
                                    <h3>352</h3>
                                </div>
                                <div class="iq-map text-primary font-size-32"><i class="ri-bar-chart-grouped-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>{{ __('app.Credited_From_Accounts') }}</h6>
                                <span class="iq-icon"><i class="ri-information-fill"></i></span>
                            </div>
                            <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle iq-card-icon iq-bg-danger mr-2"><i
                                            class="ri-radar-line"></i></div>
                                    <h3>$37k</h3></div>
                                <div class="iq-map text-danger font-size-32"><i class="ri-bar-chart-grouped-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>{{ __('app.AVG_Employee_Costs') }}</h6>
                                <span class="iq-icon"><i class="ri-information-fill"></i></span>
                            </div>
                            <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle iq-card-icon iq-bg-warning mr-2"><i
                                            class="ri-price-tag-3-line"></i></div>
                                    <h3>32%</h3></div>
                                <div class="iq-map text-warning font-size-32"><i class="ri-bar-chart-grouped-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>{{ __('app.Average_payment_delay') }}</h6>
                                <span class="iq-icon"><i class="ri-information-fill"></i></span>
                            </div>
                            <div class="iq-customer-box d-flex align-items-center justify-content-between mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle iq-card-icon iq-bg-info mr-2"><i
                                            class="ri-refund-line"></i></div>
                                    <h3>27h</h3></div>
                                <div class="iq-map text-info font-size-32"><i class="ri-bar-chart-grouped-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-7">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('app.Invoice_Stats') }}</h4>
                            </div>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                 <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                                 <i class="ri-more-fill"></i>
                                 </span>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"
                                         style="">
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-eye-fill mr-2"></i>{{ __('app.View') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-delete-bin-6-fill mr-2"></i>{{ __('app.Delete') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-pencil-fill mr-2"></i>{{ __('app.Edit') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-printer-fill mr-2"></i>{{ __('app.Print') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-file-download-fill mr-2"></i>{{ __('app.Download') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="home-chart-02"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height" style="background: transparent;">
                        <div class="iq-card-body rounded p-0"
                             style="background: url('images/page-img/01.png') no-repeat;    background-size: 150% 100%; height: 423px;">
                            <div class="iq-caption">
                                <h1>450</h1>
                                <p>{{ __('app.Invoice') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('app.Open_Invoices') }}</h4>
                            </div>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                 <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                       data-toggle="dropdown">
                                 <i class="ri-more-fill"></i>
                                 </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropdownMenuButton5">
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-eye-fill mr-2"></i>{{ __('app.View') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-delete-bin-6-fill mr-2"></i>{{ __('app.Delete') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-pencil-fill mr-2"></i>{{ __('app.Edit') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-printer-fill mr-2"></i>{{ __('app.Print') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-file-download-fill mr-2"></i>{{ __('app.Download') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('app.Client') }}</th>
                                        <th scope="col">{{ __('app.Date') }}</th>
                                        <th scope="col">{{ __('app.Invoice') }}</th>
                                        <th scope="col">{{ __('app.Amount') }}</th>
                                        <th scope="col">{{ __('app.Status') }}</th>
                                        <th scope="col">{{ __('app.action') }}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Ira Membrit</td>
                                        <td>18/10/2019</td>
                                        <td>20156</td>
                                        <td>$1500</td>
                                        <td>
                                            <div class="badge badge-pill badge-success">Paid</div>
                                        </td>
                                        <td>Copy</td>
                                    </tr>
                                    <tr>
                                        <td>Pete Sariya</td>
                                        <td>26/10/2019</td>
                                        <td>7859</td>
                                        <td>$2000</td>
                                        <td>
                                            <div class="badge badge-pill badge-success">Paid</div>
                                        </td>
                                        <td>Send Email</td>
                                    </tr>
                                    <tr>
                                        <td>Cliff Hanger</td>
                                        <td>18/11/2019</td>
                                        <td>6396</td>
                                        <td>$2500</td>
                                        <td>
                                            <div class="badge badge-pill badge-danger">Past Due</div>
                                        </td>
                                        <td>Before Due</td>
                                    </tr>
                                    <tr>
                                        <td>Terry Aki</td>
                                        <td>14/12/2019</td>
                                        <td>7854</td>
                                        <td>$5000</td>
                                        <td>
                                            <div class="badge badge-pill badge-success">Paid</div>
                                        </td>
                                        <td>Copy</td>
                                    </tr>
                                    <tr>
                                        <td>Anna Mull</td>
                                        <td>24/12/2019</td>
                                        <td>568569</td>
                                        <td>$10000</td>
                                        <td>
                                            <div class="badge badge-pill badge-success">Paid</div>
                                        </td>
                                        <td>Send Email</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('app.Monthly_Invoices') }}</h4>
                            </div>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                 <span class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown">
                                 <i class="ri-more-fill"></i>
                                 </span>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1"
                                         style="">
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-eye-fill mr-2"></i>{{ __('app.View') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-delete-bin-6-fill mr-2"></i>{{ __('app.Delete') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-pencil-fill mr-2"></i>{{ __('app.Edit') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-printer-fill mr-2"></i>{{ __('app.Print') }}</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-file-download-fill mr-2"></i>{{ __('app.Download') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                    <div class="profile-icon iq-bg-success"><span><i class="ri-check-fill"></i></span>
                                    </div>
                                    <div class="media-support-info ml-3">
                                        <h6>Camelun ios</h6>
                                        <p class="mb-0"><span class="text-success">17 paid</span> month out of 23</p>
                                    </div>
                                    <div class="media-support-amount ml-3">
                                        <h6><span class="text-secondary">$</span><b> 12,434.00</b></h6>
                                        <p class="mb-0">{{ __('app.per_month') }}</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                    <div class="profile-icon iq-bg-warning"><span><i class="ri-check-fill"></i></span>
                                    </div>
                                    <div class="media-support-info ml-3">
                                        <h6>React</h6>
                                        <p class="mb-0"><span class="text-warning">Late payment 12 week</span> - pay
                                            invoice</p>
                                    </div>
                                    <div class="media-support-amount ml-3">
                                        <h6><span class="text-secondary">$</span><b> 12,434.00</b></h6>
                                        <p class="mb-0">{{ __('app.per_month') }}</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                    <div class="profile-icon iq-bg-success"><span><i class="ri-check-fill"></i></span>
                                    </div>
                                    <div class="media-support-info ml-3">
                                        <h6>Camelun ios</h6>
                                        <p class="mb-0"><span class="text-success">17 paid</span> month out of 23</p>
                                    </div>
                                    <div class="media-support-amount ml-3">
                                        <h6><span class="text-secondary">$</span><b> 12,434.00</b></h6>
                                        <p class="mb-0">{{ __('app.per_month') }}</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                    <div class="profile-icon iq-bg-danger"><span><i class="ri-check-fill"></i></span>
                                    </div>
                                    <div class="media-support-info ml-3">
                                        <h6>Camelun ios</h6>
                                        <p class="mb-0"><span class="text-danger">17 paid</span> month out of 23</p>
                                    </div>
                                    <div class="media-support-amount ml-3">
                                        <h6><span class="text-secondary">$</span><b> 12,434.00</b></h6>
                                        <p class="mb-0">{{ __('app.per_month') }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
