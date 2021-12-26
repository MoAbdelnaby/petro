<div class="tab-pane fade show active" id="model1" role="tabpanel" aria-labelledby="model1-tab">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="iq-card secondary-custom-card mb-4">
                <div class="iq-card-body">
                    <div class="related-heading mb-5">
                        <div class="d-flex justify-content-between align-items-center border-bottom config_key_parent">
                            <h2 class="border-bottom-0">{{ __('app.Chart_Type') }} 1</h2>
                            <div class="dropdown config_key" data-type="chart">
                                <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="fas fa-bars" style=""></i>
                                </a>
                                <ul class="dropdown-menu main-dropdown chart-type charts dropped">
                                    <li class="dropdown-submenu config_value_parent">
                                        <a tabindex="-1" class=" test chart-1 selected" href="#">
                                            <img src="{{ asset('assets/images/chart-type/Bar-Chart.svg')}}"
                                                 alt="Bar Chart" title="Bar Chart">

                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="bar">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="home"
                                                   href="#">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',array_values($config['chart']['bar']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="report" href="#">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',array_values($config['chart']['bar']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu config_value_parent">
                                        <a tabindex="-1" class=" test chart-2" href="#">
                                            <img src="{{ asset('assets/images/chart-type/Pie-Chart.png')}}"
                                                 alt="Pie Chart" title="Pie Chart">

                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="circle">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="home"
                                                   href="#">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',array_values($config['chart']['circle']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="report" href="#">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',array_values($config['chart']['circle']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu config_value_parent">
                                        <a tabindex="-1" class=" test chart-3" href="#">
                                            <img src="{{ asset('assets/images/chart-type/Line-Chart.svg')}}"
                                                 alt="Line Chart" title="Line Chart">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="side_bar">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="home"
                                                   href="#">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',array_values($config['chart']['side_bar']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="report" href="#">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',array_values($config['chart']['side_bar']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu config_value_parent">
                                        <a tabindex="-1" class=" test chart-4" href="#">
                                            <img src="{{ asset('assets/images/chart-type/Line-Chart-2.svg')}}"
                                                 alt="Line Chart" title="Line Chart">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="dynamic_bar">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="home"
                                                   href="#">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',array_values($config['chart']['dynamic_bar']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="report" href="#">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',array_values($config['chart']['dynamic_bar']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu config_value_parent">
                                        <a tabindex="-1" class=" test chart-5" href="#">
                                            <img src="{{ asset('assets/images/chart-type/Line-Chart-3.svg')}}"
                                                 alt="Line Chart" title="Line Chart">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="line">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="home"
                                                   href="#">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',array_values($config['chart']['line']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="report" href="#">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',array_values($config['chart']['line']))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-submenu config_value_parent">
                                        <a tabindex="-1" class=" test chart-6" href="#">
                                            <img src="{{ asset('assets/images/chart-type/Pyramid-Chart.svg')}}"
                                                 alt="Line Chart" title="Line Chart">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="trend_line">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="home"
                                                   href="#">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',array_values($config['chart']['trend_line']??[]))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="report" href="#">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',array_values($config['chart']['trend_line']??[]))) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

{{--                                    <li class="dropdown-submenu config_value_parent">--}}
{{--                                        <a tabindex="-1" class=" test chart-7" href="#">--}}
{{--                                            <img src="{{ asset('assets/images/chart-type/Pyramid-Chart.svg')}}"--}}
{{--                                                 alt="Line Chart" title="Line Chart">--}}
{{--                                        </a>--}}
{{--                                        <small class="drop-icon dropdown-item"></small>--}}
{{--                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="smooth_line">--}}
{{--                                            <li>--}}
{{--                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="home"--}}
{{--                                                   href="#">--}}
{{--                                                    {{ __('app.Show_in_home_page') }}--}}
{{--                                                    <i class="fal fa-check show-icon"--}}
{{--                                                       @if(in_array('home',array_values($config['chart']['smooth_line']??[]))) style="display: inline"--}}
{{--                                                       data-active="1" @else data-active="0" @endif></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                            <li>--}}
{{--                                                <a tabindex="-1" class="dropdown-item removeDefault" data-type="report" href="#">--}}
{{--                                                    {{ __('app.Show_in_Report') }}--}}
{{--                                                    <i class="fal fa-check show-icon"--}}
{{--                                                       @if(in_array('report',array_values($config['chart']['smooth_line']??[]))) style="display: inline"--}}
{{--                                                       data-active="1" @else data-active="0" @endif></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div id="chart1" class="chartDiv" style="min-height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="iq-card secondary-custom-card mb-4">
                <div class="iq-card-body">
                    <div class="related-heading mb-4">
                        <div class="d-flex justify-content-between align-items-center border-bottom config_key_parent">
                            <h2 class="border-bottom-0">{{ __('app.Tables') }}</h2>
                            <div class="dropdown config_key" data-type="table">
                                <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="fas fa-bars" style=""></i>
                                </a>
                                <ul class="dropdown-menu main-dropdown chart-type tables-type dropped">
                                    <li class="dropdown-submenu config_value_parent">
                                            {{ __('app.Show_in_report') }}
                                        <a tabindex="-1" class="dropdown-item test table-1 selected" href="#">
                                            <img src="{{ asset('assets/images/tables-type/table-1.png')}}" alt="Theme 1"
                                                 title="Theme 1">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="1">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="home">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',isset($config['table']['1'])?(array_values($config['table']['1'])):[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="report">

                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',isset($config['table']['1'])?($config['table']['1']):[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu config_value_parent">
                                        {{ __('app.Show_in_Report') }}
                                        <a tabindex="-1" class="dropdown-item test table-2" href="#">
                                            <img src="{{ asset('assets/images/tables-type/table-2.png')}}" alt="Theme 2"
                                                 title="Theme 2">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="2">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="home">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',isset($config['table']['2'])?array_values($config['table']['2']):[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="report">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',isset($config['table']['2'])?$config['table']['2']:[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu config_value_parent">
                                            {{ __('app.Show_in_Report') }}
                                        <a tabindex="-1" class="dropdown-item test table-3" href="#">
                                            <img src="{{ asset('assets/images/tables-type/table-3.png')}}" alt="Theme 3"
                                                 title="Theme 3">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="3">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="home">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',isset($config['table']['3'])?array_values($config['table']['3']):[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="report">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',isset($config['table']['3'])?array_values($config['table']['3']):[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu config_value_parent">
                                        {{ __('app.Show_in_Report') }}
                                        <a tabindex="-1" class="dropdown-item test table-4" href="#">
                                            <img src="{{ asset('assets/images/tables-type/table-4.png')}}" alt="Theme 4"
                                                 title="Theme 4">
                                        </a>
                                        <small class="drop-icon dropdown-item"></small>
                                        <ul class="dropdown-menu main-dropdown child config_value" data-type="4">
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="home">
                                                    {{ __('app.Show_in_home_page') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('home',isset($config['table']['4'])?array_values($config['table']['4']):[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="report">
                                                    {{ __('app.Show_in_Report') }}
                                                    <i class="fal fa-check show-icon"
                                                       @if(in_array('report',isset($config['table']['4'])?$config['table']['4']:[])) style="display: inline"
                                                       data-active="1" @else data-active="0" @endif></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="custom-table mt-5">
                        <table class="table {{handleTableConfig($config['table'])}}" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">
                                    {{ __('app.Date') }}
                                </th>
                                <th class="th-sm">
                                    {{ __('app.Timing') }}
                                </th>
                                <th class="th-sm">
                                    {{ __('app.Area') }}
                                </th>
                                <th class="th-sm">
                                    {{ __('app.Status') }}
                                </th>
                                <th class="th-sm">{{ __('app.Id_Camera') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>14:32</td>
                                <td class="open">{{ __('app.Area') }} 2</td>
                                <td class="open warning ">{{ __('app.Available') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>14:27</td>
                                <td class="open">{{ __('app.Area') }} 3</td>
                                <td class="open danger ">{{ __('app.Busy') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>14:16</td>
                                <td class="open">{{ __('app.Area') }} 3</td>
                                <td class="open warning ">{{ __('app.Available') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>14:14</td>
                                <td class="open">{{ __('app.Area') }} 1</td>
                                <td class="open danger ">{{ __('app.Busy') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>14:13</td>
                                <td class="open">{{ __('app.Area') }} 2</td>
                                <td class="open danger ">{{ __('app.Busy') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>13:59</td>
                                <td class="open">{{ __('app.Area') }} 3</td>
                                <td class="open danger ">{{ __('app.Busy') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>13:46</td>
                                <td class="open">{{ __('app.Area') }} 3</td>
                                <td class="open warning ">{{ __('app.Available') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>13:45</td>
                                <td class="open">{{ __('app.Area') }} 3</td>
                                <td class="open danger ">{{ __('app.Busy') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>13:29</td>
                                <td class="open">{{ __('app.Area') }} 4</td>
                                <td class="open warning ">{{ __('app.Available') }}</td>
                                <td>1</td>
                            </tr>
                            <tr style="cursor: pointer;" class="record" data-toggle="modal"
                                data-target="#basicExampleModal">
                                <td>2021-06-10</td>
                                <td>13:29</td>
                                <td class="open">{{ __('app.Area') }} 3</td>
                                <td class="open warning ">{{ __('app.Available') }}</td>
                                <td>1</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 Statistics">
            <div class="iq-card secondary-custom-card mb-4 mb-3">
                <div class="iq-card-body">
                    <div class="related-heading mb-4">
                        <div class="d-flex justify-content-between align-items-center border-bottom config_key_parent">
                            <h2 class="border-bottom-0">{{ __('app.gym.Statistics') }}</h2>
                            <div class="dropdown config_key" data-type="statistics">
                                <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="fas fa-bars" style=""></i>
                                </a>
                                <ul class="dropdown-menu main-dropdown config_value" data-type="1">
                                    <li>
                                        <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="home">
                                            {{ __('app.Show_in_home_page') }}
                                            <i class="fal fa-check show-icon"
                                               @if(in_array('home',isset($config['statistics']['1'])?array_values($config['statistics']['1']):[])) style="display: inline"
                                               data-active="1" @else data-active="0" @endif></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="report">
                                            {{ __('app.Show_in_Report') }}
                                            <i class="fal fa-check show-icon"
                                               @if(in_array('report',isset($config['statistics']['1'])?array_values($config['statistics']['1']):[])) style="display: inline"
                                               data-active="1" @else data-active="0" @endif></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3" id="sortable" data-sortable-id="0" aria-dropeffect="move">
                        <div class="col-md-4 col-lg-6 " data-id="13" data-item-sortable-id="0" draggable="true"
                             role="option" aria-grabbed="false" style="">
                            <div class="iq-card mb-4">
                                <div class="iq-card-body">
                                    <div class="rounded-circle iq-card-icon iq-bg-danger mr-1 float-left">
                                        <i class="fa fa-subway"></i>
                                    </div>
                                    <h5 class="border-bottom-0 text-center" >{{ __('app.region') }}</h5>
                                    <h4 class="text-center">5</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-6 column" data-id="9" data-item-sortable-id="0" draggable="true"
                             role="option" aria-grabbed="false" style="">
                            <div class="iq-card mb-4">
                                <div class="iq-card-body">
                                    <div class="rounded-circle iq-card-icon bg-primary mr-1 float-left"><i
                                            class="fa fa-id-card"></i>
                                    </div>
                                    <h5 class="border-bottom-0 text-center">{{ __('app.Branches') }}</h5>
                                    <h4 class="text-center">6</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-6 column" data-id="8" data-item-sortable-id="0" draggable="true"
                             role="option" aria-grabbed="false" style="">
                            <div class="iq-card mb-4">
                                <div class="iq-card-body">
                                    <div class="rounded-circle iq-card-icon iq-bg-info mr-1 float-left"><i
                                            class="fa fa-users"></i>
                                    </div>
                                    <h5 class="border-bottom-0 text-center">{{ __('app.Users') }}</h5>
                                    <h4 class="text-center">1</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-6 column" data-id="17" data-item-sortable-id="0" draggable="true"
                             role="option" aria-grabbed="false" style="">
                            <div class="iq-card mb-4">
                                <div class="iq-card-body">
                                    <div class="rounded-circle iq-card-icon iq-bg-warning mr-1 float-left"><i
                                            class="fa fa-bars"></i>
                                    </div>
                                    <h5 class="border-bottom-0 text-center">{{ __('app.Models') }}</h5>
                                    <h4 class="text-center">2</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card secondary-custom-card mb-4">
                <div class="iq-card-body">
                    <div class="related-heading mb-4">
                        <div class="d-flex justify-content-between align-items-center border-bottom config_key_parent">
                            <h2 class="border-bottom-0">{{ __('app.gym.Statistics') }}</h2>
                            <div class="dropdown config_key" data-type="statistics">
                                <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="fas fa-bars" style=""></i>
                                </a>
                                <ul class="dropdown-menu main-dropdown config_value" data-type="1">
                                    <li>
                                        <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="home">
                                            {{ __('app.Show_in_home_page') }}
                                            <i class="fal fa-check show-icon"
                                               @if(in_array('home',isset($config['InternetStatus']['1'])?array_values($config['InternetStatus']['1']):[])) style="display: inline"
                                               data-active="1" @else data-active="0" @endif></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" class="dropdown-item removeDefault" href="#" data-type="report">
                                            {{ __('app.Show_in_Report') }}
                                            <i class="fal fa-check show-icon"
                                               @if(in_array('report',isset($config['InternetStatus']['1'])?array_values($config['InternetStatus']['1']):[])) style="display: inline"
                                               data-active="1" @else data-active="0" @endif></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3" id="sortable" data-sortable-id="0" aria-dropeffect="move">
                        <div class="col-md-4 col-lg-6 " data-id="13" data-item-sortable-id="0" draggable="true"
                             role="option" aria-grabbed="false" style="">
                            <div class="iq-card mb-4">
                                <div class="iq-card-body">
                                    <div class="rounded-circle iq-card-icon iq-bg-danger mr-1 float-left">
                                        <i class="fa fa-subway"></i>
                                    </div>
                                    <h5 class="border-bottom-0 text-center" >{{ __('app.region') }}</h5>
                                    <h4 class="text-center">5</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-6 column" data-id="9" data-item-sortable-id="0" draggable="true"
                             role="option" aria-grabbed="false" style="">
                            <div class="iq-card mb-4">
                                <div class="iq-card-body">
                                    <div class="rounded-circle iq-card-icon bg-primary mr-1 float-left"><i
                                            class="fa fa-id-card"></i>
                                    </div>
                                    <h5 class="border-bottom-0 text-center">{{ __('app.Branches') }}</h5>
                                    <h4 class="text-center">6</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{asset('js/config.js')}}"></script>
    <script>
        $(function () {
            $('.dropdown-item.removeDefault').on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();

                let old_active, new_active;

                let type = $(this).data('type');

                old_active = (old_active) ?? $(this).find('.show-icon').data('active');

                new_active = (parseInt(old_active) ? 0 : 1);

                old_active = new_active;

                $(this).find('.show-icon').data('active', new_active);

                var data = {
                    'key': $(this).parent().parent().parent().parent().parent().parent().find('.config_key').data('type'),
                    'value': $(this).parent().parent().parent().find('.config_value').data('type'),
                    'view': type,
                    'model_type': 'place',
                    'active': new_active,
                }

                updateConfigSetting(data);

            });
        })
    </script>
@endpush
