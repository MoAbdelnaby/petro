<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="{{str_replace('_', '-', app()->getLocale())=='ar'?'rtl':'ltr'}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @yield('meta')
    <title>{{__('app.website_name')}} | @yield('page_title',__('app.dashboard'))</title>

     <link rel="shortcut icon" href="{{url('/images')}}/Logo.svg" />
      <!-- Bootstrap CSS -->
    <link href="{{url('/gym')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/gym')}}/css/mdb.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/gym')}}/css/style.css" rel="stylesheet" type="text/css"/>
      <!-- Typography CSS -->

    @stack('css')
</head>
<body>

<!-- Start Login-up -->

<section class="login-header">
    <div class="container">
        <div class="logo">
            <div class="row">
                <div class="col-md-2 text-center">
                    <a href="{{Url('/')}}" ><img src="{{url('/gym')}}/img/Group 5928.png" width="170px" alt=""></a>
                </div>

                <div class="col-md-10">
                    <img src="{{url('/gym')}}/img/Path 50464.png" width="100%" class="border">
                </div>
            </div>
        </div>

        <div class="login-content pt-3 pb-3">
            <div>
                <div class="text-center ">
                    <h2>{{ __('app.Welcome') }} <span>{{ __('app.to') }}</span></h2>
                    <p> {{__('app.website_name')}}</p>
                    <ul>
                        <li class="part-1"></li>
                        <li class="part-2"></li>
                        <li class="part-3"></li>
                        <li class="part-4"></li>
                        <li class="part-5"></li>
                        <li class="part-6"></li>
                    </ul>
                </div>
                <div class="back">

                    <div class="text-center" style="width:400px; margin:0 auto;">

                        @if(session('danger'))
                            <div class="alert alert-danger" role="alert">
                                {!! session('danger') !!}
                            </div>
                        @endif

                    </div>
                    <div class="image">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1276.359" height="283.001" viewBox="0 0 1276.359 283.001">
                            <g id="Group_23069" data-name="Group 23069" transform="translate(-335.722 -423.814)">
                                <g id="Group_23067" data-name="Group 23067" transform="translate(335.722 423.814)" style="isolation: isolate">
                                    <g id="Group_4367" data-name="Group 4367" transform="translate(0 0)">
                                        <g id="Group_4340" data-name="Group 4340" transform="translate(153.242 14.704)">
                                            <path id="Path_8409" class="draw" data-name="Path 8409" d="M344.5,163.021a3,3,0,0,1-.087.734H403.4l45.491-36.74H564.535v-1.474H448.357l-45.491,36.743H344.409A3.012,3.012,0,0,1,344.5,163.021Z" transform="translate(-335.628 -125.541)" />
                                            <g id="Group_4339" data-name="Group 4339" transform="translate(0 32.47)">
                                                <path id="Path_8410" class="head" data-name="Path 8410" d="M417.441,135.633a5.04,5.04,0,0,1,4.977,4.273,4.449,4.449,0,0,1,0,1.47,5.02,5.02,0,1,1-4.977-5.743Zm0,8.867a3.855,3.855,0,0,0,3.771-3.124,3.155,3.155,0,0,0,0-1.47,3.839,3.839,0,1,0-3.771,4.594Z" transform="translate(-412.432 -135.633)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4342" data-name="Group 4342" transform="translate(0 104.273)">
                                            <path id="Path_8411" class="draw" data-name="Path 8411" d="M344.116,156.191H534.749l21.567,17.384H718.429V172.1H556.817l-21.538-17.384H344.116Z" transform="translate(-335.336 -150.414)" fill="#29abe2"/>
                                            <g id="Group_4341" data-name="Group 4341" transform="translate(0)">
                                                <path id="Path_8412" class="head" data-name="Path 8412" d="M465.071,153.38a5.042,5.042,0,0,1,4.977,4.3,5.9,5.9,0,0,1,.061.737,5.8,5.8,0,0,1-.061.737,5.022,5.022,0,1,1-4.977-5.775Zm0,8.87a3.829,3.829,0,0,0,3.771-3.1,3.012,3.012,0,0,0,.087-.737,3.05,3.05,0,0,0-.087-.737,3.837,3.837,0,1,0-3.771,4.569Z" transform="translate(-460.061 -153.38)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4344" data-name="Group 4344" transform="translate(91.928 139.484)">
                                            <path id="Path_8413" class="draw" data-name="Path 8413" d="M344.116,188.691h85.3l28.05-22.658,2.122-1.709H626.5V165.8H460.116l-29.17,23.571-1,.8H344.116Z" transform="translate(-335.336 -164.324)" fill="#29abe2"/>
                                            <g id="Group_4343" data-name="Group 4343" transform="translate(0 20.064)">
                                                <path id="Path_8414" class="head" data-name="Path 8414" d="M436.528,170.56a5.035,5.035,0,0,1,4.948,4.3,5.877,5.877,0,0,1,.061.737,5.774,5.774,0,0,1-.061.737,5.022,5.022,0,1,1-4.948-5.775Zm0,8.871a3.822,3.822,0,0,0,3.742-3.1,3,3,0,0,0,.087-.737,3.038,3.038,0,0,0-.087-.737,3.837,3.837,0,1,0-3.742,4.569Z" transform="translate(-431.489 -170.56)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4346" data-name="Group 4346" transform="translate(122.571 145.289)">
                                            <path id="Path_8415" class="draw" data-name="Path 8415" d="M344.2,198.952a3.038,3.038,0,0,1-.087.737h60.932L444.8,167.6H595.857v-1.474H444.265l-39.748,32.087h-60.4A3,3,0,0,1,344.2,198.952Z" transform="translate(-335.336 -166.128)" fill="#29abe2"/>
                                            <g id="Group_4345" data-name="Group 4345" transform="translate(0 27.815)">
                                                <path id="Path_8416" class="head" data-name="Path 8416" d="M427,174.773a5.035,5.035,0,0,1,4.948,4.273,5.774,5.774,0,0,1,.061.737,5.876,5.876,0,0,1-.061.737A5.02,5.02,0,1,1,427,174.773Zm0,8.838a3.822,3.822,0,0,0,3.742-3.092,3.038,3.038,0,0,0,.087-.737,3,3,0,0,0-.087-.737A3.836,3.836,0,1,0,427,183.611Z" transform="translate(-421.965 -174.773)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4348" data-name="Group 4348" transform="translate(58.19 63.377)">
                                            <path id="Path_8417" class="draw" data-name="Path 8417" d="M344.407,168.956a2.871,2.871,0,0,1-.09.737H561.409l.206-.148,33.944-27.4h64.233v-1.474H595.057L560.878,168.22H344.317A2.853,2.853,0,0,1,344.407,168.956Z" transform="translate(-335.537 -140.669)" fill="#29abe2"/>
                                            <g id="Group_4347" data-name="Group 4347" transform="translate(0 23.278)">
                                                <path id="Path_8418" class="head" data-name="Path 8418" d="M446.985,147.9a5.045,5.045,0,0,1,4.98,4.273,4.716,4.716,0,0,1,0,1.474,5.021,5.021,0,1,1-4.98-5.746Zm0,8.867a3.855,3.855,0,0,0,3.771-3.121,3.06,3.06,0,0,0,0-1.474,3.838,3.838,0,1,0-3.771,4.595Z" transform="translate(-441.975 -147.904)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4350" data-name="Group 4350" transform="translate(214.528 202.009)">
                                            <path id="Path_8419" class="draw" data-name="Path 8419" d="M343.722,186.567h66.943l26.813,21.656h67.3V206.75H438.007l-26.842-21.656H343.722Z" transform="translate(-334.942 -180.793)" fill="#29abe2"/>
                                            <g id="Group_4349" data-name="Group 4349" transform="translate(0)">
                                                <path id="Path_8420" class="head" data-name="Path 8420" d="M398.394,183.757a5.048,5.048,0,0,1,4.981,4.3,5.8,5.8,0,0,1,.058.7,6.3,6.3,0,0,1-.058.766,5.023,5.023,0,1,1-4.981-5.772Zm0,8.867a3.853,3.853,0,0,0,3.771-3.1,3.24,3.24,0,0,0,.09-.766,2.936,2.936,0,0,0-.09-.7,3.836,3.836,0,1,0-3.771,4.566Z" transform="translate(-393.384 -183.757)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4352" data-name="Group 4352" transform="translate(100.914 48.026)">
                                            <path id="Path_8421" class="draw" data-name="Path 8421" d="M343.809,170.167a3.038,3.038,0,0,1-.087.737H494.815l15.527-12.551,25.987-20.981h82.086V135.9H535.8l-.206.177L494.284,169.43H343.722A3,3,0,0,1,343.809,170.167Z" transform="translate(-334.971 -135.898)" fill="#29abe2"/>
                                            <g id="Group_4351" data-name="Group 4351" transform="translate(0 29.259)">
                                                <path id="Path_8422" class="head" data-name="Path 8422" d="M433.715,144.992a5.013,5.013,0,0,1,4.948,4.273,5.775,5.775,0,0,1,.061.737,5.878,5.878,0,0,1-.061.737,5.006,5.006,0,1,1-4.948-5.746Zm0,8.838a3.8,3.8,0,0,0,3.742-3.092,3.039,3.039,0,0,0,.087-.737,3,3,0,0,0-.087-.737,3.823,3.823,0,1,0-3.742,4.565Z" transform="translate(-428.705 -144.992)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4354" data-name="Group 4354" transform="translate(229.849 99.443)">
                                            <path id="Path_8423" class="draw" data-name="Path 8423" d="M343.914,162.721h95.67l13.406-10.842h36.034v1.473h-35.5l-13.406,10.843h-96.2Z" transform="translate(-335.134 -151.879)" fill="#29abe2"/>
                                            <g id="Group_4353" data-name="Group 4353" transform="translate(0 6.542)">
                                                <path id="Path_8424" class="head" data-name="Path 8424" d="M393.632,153.912a5.045,5.045,0,0,1,4.98,4.3,4.73,4.73,0,0,1,0,1.477,5.023,5.023,0,1,1-4.98-5.775Zm0,8.867a3.83,3.83,0,0,0,3.771-3.092,3.077,3.077,0,0,0,0-1.477,3.837,3.837,0,1,0-3.771,4.569Z" transform="translate(-388.622 -153.912)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4356" data-name="Group 4356" transform="translate(183.885 152.567)">
                                            <path id="Path_8425" class="draw" data-name="Path 8425" d="M344,205.986a3.006,3.006,0,0,1-.087.737h50.53l2.448-1.975,43.194-34.883h94.9V168.39H439.584l-12.992,10.46-32.647,26.4H343.914A3.025,3.025,0,0,1,344,205.986Z" transform="translate(-335.134 -168.39)" fill="#29abe2"/>
                                            <g id="Group_4355" data-name="Group 4355" transform="translate(0 32.557)">
                                                <path id="Path_8426" class="head" data-name="Path 8426" d="M407.917,178.509a5.045,5.045,0,0,1,4.981,4.3,4.72,4.72,0,0,1,0,1.474,5.023,5.023,0,1,1-4.981-5.775Zm0,8.87a3.829,3.829,0,0,0,3.771-3.1,3.169,3.169,0,0,0,0-1.474,3.837,3.837,0,1,0-3.771,4.569Z" transform="translate(-402.908 -178.509)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4358" data-name="Group 4358" transform="translate(122.571 36.125)">
                                            <path id="Path_8427" class="draw" data-name="Path 8427" d="M343.91,170.679a3.038,3.038,0,0,1-.087.737H459.676l46.759-37.743h90.072V132.2H505.9l-46.759,37.743H343.823A3,3,0,0,1,343.91,170.679Z" transform="translate(-335.043 -132.199)" fill="#29abe2"/>
                                            <g id="Group_4357" data-name="Group 4357" transform="translate(0 33.471)">
                                                <path id="Path_8428" class="head" data-name="Path 8428" d="M427,142.6a5.035,5.035,0,0,1,4.948,4.273,5.777,5.777,0,0,1,.061.737,5.878,5.878,0,0,1-.061.737A5.02,5.02,0,1,1,427,142.6Zm0,8.838a3.822,3.822,0,0,0,3.742-3.092,3.039,3.039,0,0,0,.087-.737,3,3,0,0,0-.087-.737A3.836,3.836,0,1,0,427,151.44Z" transform="translate(-421.965 -142.602)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4360" data-name="Group 4360" transform="translate(309.168 180.291)">
                                            <path id="Path_8429" class="draw" data-name="Path 8429" d="M344,177.744a3,3,0,0,1-.087.737h74.573v-1.474H343.914A3.037,3.037,0,0,1,344,177.744Z" transform="translate(-343.914 -177.007)" fill="#29abe2"/>
                                        </g>
                                        <g id="Group_4362" data-name="Group 4362" transform="translate(288.602 193.904)">
                                            <path id="Path_8431" class="draw" data-name="Path 8431" d="M344,183.3a3.019,3.019,0,0,1-.087.737h46.492l9.578,7.748h30.289v-1.47H400.515l-9.578-7.751H343.914A3,3,0,0,1,344,183.3Z" transform="translate(-335.134 -178.293)" fill="#29abe2"/>
                                            <g id="Group_4361" data-name="Group 4361" transform="translate(0)">
                                                <path id="Path_8432" class="head" data-name="Path 8432" d="M375.368,181.238a5.043,5.043,0,0,1,4.981,4.273,4.705,4.705,0,0,1,0,1.474,5.02,5.02,0,1,1-4.981-5.746Zm0,8.838a3.833,3.833,0,0,0,3.774-3.092,3.169,3.169,0,0,0,0-1.474,3.836,3.836,0,1,0-3.774,4.566Z" transform="translate(-370.362 -181.238)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4364" data-name="Group 4364" transform="translate(271.839 237.864)">
                                            <path id="Path_8433" class="draw" data-name="Path 8433" d="M343.969,232.117a2.7,2.7,0,0,1,.531.5c.148.206.293.415.412.621l.914-.737,44.7-36.125h57.691V194.9H390.02l-.206.177-44.9,36.273Z" transform="translate(-336.488 -194.901)" fill="#29abe2"/>
                                            <g id="Group_4363" data-name="Group 4363" transform="translate(0 35.101)">
                                                <path id="Path_8434" class="head" data-name="Path 8434" d="M377.43,206.922a5.017,5.017,0,0,1,6.57.238,2.81,2.81,0,0,1,.5.528c.145.209.293.415.412.621a4.992,4.992,0,0,1-.737,6.039c-.058.029-.09.09-.148.148-.087.058-.177.148-.293.235a5.019,5.019,0,0,1-6.306-7.809Zm.177,6.335a3.834,3.834,0,0,0,5.392.56,3.874,3.874,0,0,0,1-4.771c-.119-.206-.264-.415-.412-.621a2.694,2.694,0,0,0-.531-.5,3.853,3.853,0,0,0-4.656-.267c-.09.061-.148.119-.235.177-.061.061-.119.09-.148.148A3.847,3.847,0,0,0,377.607,213.257Z" transform="translate(-375.576 -205.811)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4366" data-name="Group 4366" transform="translate(286.537 0)">
                                            <path id="Path_8435" class="draw" data-name="Path 8435" d="M343.913,123.036a2.871,2.871,0,0,1-.09.737H432.54V122.3H343.823A2.87,2.87,0,0,1,343.913,123.036Z" transform="translate(-335.043 -118.026)" fill="#29abe2"/>
                                            <g id="Group_4365" data-name="Group 4365" transform="translate(0)">
                                                <path id="Path_8436" class="head" data-name="Path 8436" d="M376.013,120.971a5.043,5.043,0,0,1,4.98,4.273,4.71,4.71,0,0,1,0,1.474,5.021,5.021,0,1,1-4.98-5.746Zm0,8.841a3.83,3.83,0,0,0,3.771-3.1,3.056,3.056,0,0,0,0-1.474,3.835,3.835,0,1,0-3.771,4.569Z" transform="translate(-371.003 -120.971)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="Group_23066" data-name="Group 23066" transform="translate(-1241 643.56)" style="isolation: isolate">
                                    <g id="Group_4367-2" data-name="Group 4367" transform="translate(2468.722 -219.746)">
                                        <g id="Group_4340-2" data-name="Group 4340" transform="translate(2.211 14.704)">
                                            <path id="Path_8409-2" class="draw" data-name="Path 8409" d="M564.448,163.021a3,3,0,0,0,.087.734H505.547l-45.491-36.74H344.409v-1.474H460.587l45.491,36.743h58.457A3.012,3.012,0,0,0,564.448,163.021Z" transform="translate(-344.409 -125.541)" fill="#29abe2"/>
                                            <g id="Group_4339-2" data-name="Group 4339" transform="translate(218.858 32.47)">
                                                <path id="Path_8410-2" class="head" data-name="Path 8410" d="M417.471,135.633a5.04,5.04,0,0,0-4.977,4.273,4.449,4.449,0,0,0,0,1.47,5.02,5.02,0,1,0,4.977-5.743Zm0,8.867a3.855,3.855,0,0,1-3.771-3.124,3.155,3.155,0,0,1,0-1.47,3.839,3.839,0,1,1,3.771,4.594Z" transform="translate(-412.432 -135.633)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4342-2" data-name="Group 4342" transform="translate(1.267 104.273)">
                                            <path id="Path_8411-2" class="draw" data-name="Path 8411" d="M718.428,156.191H527.8l-21.567,17.384H344.116V172.1H505.727l21.538-17.384H718.428Z" transform="translate(-344.116 -150.414)" fill="#29abe2"/>
                                            <g id="Group_4341-2" data-name="Group 4341" transform="translate(373.044)">
                                                <path id="Path_8412-2" class="head" data-name="Path 8412" d="M465.1,153.38a5.042,5.042,0,0,0-4.977,4.3,5.9,5.9,0,0,0-.061.737,5.8,5.8,0,0,0,.061.737,5.022,5.022,0,1,0,4.977-5.775Zm0,8.87a3.829,3.829,0,0,1-3.771-3.1,3.012,3.012,0,0,1-.087-.737,3.05,3.05,0,0,1,.087-.737,3.837,3.837,0,1,1,3.771,4.569Z" transform="translate(-460.061 -153.38)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4344-2" data-name="Group 4344" transform="translate(1.267 139.484)">
                                            <path id="Path_8413-2" class="draw" data-name="Path 8413" d="M626.5,188.691H541.2l-28.05-22.658-2.122-1.709H344.116V165.8H510.5l29.17,23.571,1,.8H626.5Z" transform="translate(-344.116 -164.324)" fill="#29abe2"/>
                                            <g id="Group_4343-2" data-name="Group 4343" transform="translate(281.116 20.064)">
                                                <path id="Path_8414-2" class="head" data-name="Path 8414" d="M436.5,170.56a5.035,5.035,0,0,0-4.948,4.3,5.877,5.877,0,0,0-.061.737,5.774,5.774,0,0,0,.061.737,5.022,5.022,0,1,0,4.948-5.775Zm0,8.871a3.822,3.822,0,0,1-3.742-3.1,3,3,0,0,1-.087-.737,3.038,3.038,0,0,1,.087-.737,3.837,3.837,0,1,1,3.742,4.569Z" transform="translate(-431.489 -170.56)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4346-2" data-name="Group 4346" transform="translate(1.268 145.289)">
                                            <path id="Path_8415-2" class="draw" data-name="Path 8415" d="M595.769,198.952a3.038,3.038,0,0,0,.087.737H534.925L495.177,167.6H344.116v-1.474H495.708l39.748,32.087h60.4A3,3,0,0,0,595.769,198.952Z" transform="translate(-344.116 -166.128)" fill="#29abe2"/>
                                            <g id="Group_4345-2" data-name="Group 4345" transform="translate(250.473 27.815)">
                                                <path id="Path_8416-2" class="head" data-name="Path 8416" d="M426.975,174.773a5.035,5.035,0,0,0-4.948,4.273,5.774,5.774,0,0,0-.061.737,5.876,5.876,0,0,0,.061.737,5.02,5.02,0,1,0,4.948-5.746Zm0,8.838a3.822,3.822,0,0,1-3.742-3.092,3.038,3.038,0,0,1-.087-.737,3,3,0,0,1,.087-.737,3.836,3.836,0,1,1,3.742,4.565Z" transform="translate(-421.965 -174.773)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4348-2" data-name="Group 4348" transform="translate(1.915 63.377)">
                                            <path id="Path_8417-2" class="draw" data-name="Path 8417" d="M659.7,168.956a2.871,2.871,0,0,0,.09.737H442.7l-.206-.148-33.944-27.4H344.317v-1.474h64.734L443.23,168.22H659.791A2.853,2.853,0,0,0,659.7,168.956Z" transform="translate(-344.317 -140.669)" fill="#29abe2"/>
                                            <g id="Group_4347-2" data-name="Group 4347" transform="translate(314.206 23.278)">
                                                <path id="Path_8418-2" class="head" data-name="Path 8418" d="M447.013,147.9a5.045,5.045,0,0,0-4.98,4.273,4.716,4.716,0,0,0,0,1.474,5.021,5.021,0,1,0,4.98-5.746Zm0,8.867a3.855,3.855,0,0,1-3.771-3.121,3.06,3.06,0,0,1,0-1.474,3.838,3.838,0,1,1,3.771,4.595Z" transform="translate(-441.975 -147.904)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4350-2" data-name="Group 4350" transform="translate(0 202.009)">
                                            <path id="Path_8419-2" class="draw" data-name="Path 8419" d="M504.773,186.567H437.831l-26.813,21.656h-67.3V206.75h66.766l26.842-21.656h67.443Z" transform="translate(-343.722 -180.793)" fill="#29abe2"/>
                                            <g id="Group_4349-2" data-name="Group 4349" transform="translate(159.784)">
                                                <path id="Path_8420-2" class="head" data-name="Path 8420" d="M398.422,183.757a5.048,5.048,0,0,0-4.981,4.3,5.8,5.8,0,0,0-.058.7,6.3,6.3,0,0,0,.058.766,5.023,5.023,0,1,0,4.981-5.772Zm0,8.867a3.853,3.853,0,0,1-3.771-3.1,3.24,3.24,0,0,1-.09-.766,2.936,2.936,0,0,1,.09-.7,3.836,3.836,0,1,1,3.771,4.566Z" transform="translate(-393.384 -183.757)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4352-2" data-name="Group 4352" transform="translate(0 48.026)">
                                            <path id="Path_8421-2" class="draw" data-name="Path 8421" d="M618.328,170.167a3.038,3.038,0,0,0,.087.737H467.322l-15.527-12.551-25.987-20.981H343.722V135.9h82.617l.206.177,41.308,33.355H618.415A3,3,0,0,0,618.328,170.167Z" transform="translate(-343.722 -135.898)" fill="#29abe2"/>
                                            <g id="Group_4351-2" data-name="Group 4351" transform="translate(273.426 29.259)">
                                                <path id="Path_8422-2" class="head" data-name="Path 8422" d="M433.714,144.992a5.013,5.013,0,0,0-4.948,4.273,5.775,5.775,0,0,0-.061.737,5.878,5.878,0,0,0,.061.737,5.006,5.006,0,1,0,4.948-5.746Zm0,8.838a3.8,3.8,0,0,1-3.742-3.092,3.039,3.039,0,0,1-.087-.737,3,3,0,0,1,.087-.737,3.823,3.823,0,1,1,3.742,4.565Z" transform="translate(-428.705 -144.992)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4354-2" data-name="Group 4354" transform="translate(0.619 99.443)">
                                            <path id="Path_8423-2" class="draw" data-name="Path 8423" d="M489.025,162.721h-95.67l-13.406-10.842H343.914v1.473h35.5l13.406,10.843h96.2Z" transform="translate(-343.914 -151.879)" fill="#29abe2"/>
                                            <g id="Group_4353-2" data-name="Group 4353" transform="translate(143.843 6.542)">
                                                <path id="Path_8424-2" class="head" data-name="Path 8424" d="M393.66,153.912a5.045,5.045,0,0,0-4.98,4.3,4.73,4.73,0,0,0,0,1.477,5.023,5.023,0,1,0,4.98-5.775Zm0,8.867a3.83,3.83,0,0,1-3.771-3.092,3.077,3.077,0,0,1,0-1.477,3.837,3.837,0,1,1,3.771,4.569Z" transform="translate(-388.622 -153.912)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4356-2" data-name="Group 4356" transform="translate(0.618 152.567)">
                                            <path id="Path_8425-2" class="draw" data-name="Path 8425" d="M534.9,205.986a3.006,3.006,0,0,0,.087.737H484.46l-2.448-1.975-43.194-34.883h-94.9V168.39H439.32l12.992,10.46,32.647,26.4H534.99A3.025,3.025,0,0,0,534.9,205.986Z" transform="translate(-343.914 -168.39)" fill="#29abe2"/>
                                            <g id="Group_4355-2" data-name="Group 4355" transform="translate(189.808 32.557)">
                                                <path id="Path_8426-2" class="head" data-name="Path 8426" d="M407.946,178.509a5.045,5.045,0,0,0-4.981,4.3,4.72,4.72,0,0,0,0,1.474,5.023,5.023,0,1,0,4.981-5.775Zm0,8.87a3.829,3.829,0,0,1-3.771-3.1,3.169,3.169,0,0,1,0-1.474,3.837,3.837,0,1,1,3.771,4.569Z" transform="translate(-402.908 -178.509)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4358-2" data-name="Group 4358" transform="translate(0.325 36.125)">
                                            <path id="Path_8427-2" class="draw" data-name="Path 8427" d="M596.419,170.679a3.038,3.038,0,0,0,.087.737H480.653l-46.759-37.743H343.823V132.2h90.6l46.759,37.743H596.506A3,3,0,0,0,596.419,170.679Z" transform="translate(-343.823 -132.199)" fill="#29abe2"/>
                                            <g id="Group_4357-2" data-name="Group 4357" transform="translate(251.415 33.471)">
                                                <path id="Path_8428-2" class="head" data-name="Path 8428" d="M426.975,142.6a5.035,5.035,0,0,0-4.948,4.273,5.777,5.777,0,0,0-.061.737,5.878,5.878,0,0,0,.061.737,5.02,5.02,0,1,0,4.948-5.746Zm0,8.838a3.822,3.822,0,0,1-3.742-3.092,3.039,3.039,0,0,1-.087-.737,3,3,0,0,1,.087-.737,3.836,3.836,0,1,1,3.742,4.566Z" transform="translate(-421.965 -142.602)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4360-2" data-name="Group 4360" transform="translate(0.618 180.291)">
                                            <path id="Path_8429-2" class="draw" data-name="Path 8429" d="M418.4,177.744a3,3,0,0,0,.087.737H343.914v-1.474h74.573A3.037,3.037,0,0,0,418.4,177.744Z" transform="translate(-343.914 -177.007)" fill="#29abe2"/>
                                        </g>
                                        <g id="Group_4362-2" data-name="Group 4362" transform="translate(0.618 193.904)">
                                            <path id="Path_8431-2" class="draw" data-name="Path 8431" d="M430.186,183.3a3.019,3.019,0,0,0,.087.737H383.781l-9.578,7.748H343.914v-1.47h29.758l9.578-7.751h47.022A3,3,0,0,0,430.186,183.3Z" transform="translate(-343.914 -178.293)" fill="#29abe2"/>
                                            <g id="Group_4361-2" data-name="Group 4361" transform="translate(85.094)">
                                                <path id="Path_8432-2" class="head" data-name="Path 8432" d="M375.4,181.238a5.043,5.043,0,0,0-4.981,4.273,4.705,4.705,0,0,0,0,1.474,5.02,5.02,0,1,0,4.981-5.746Zm0,8.838a3.833,3.833,0,0,1-3.774-3.092,3.169,3.169,0,0,1,0-1.474,3.836,3.836,0,1,1,3.774,4.566Z" transform="translate(-370.362 -181.238)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4364-2" data-name="Group 4364" transform="translate(0.795 237.864)">
                                            <path id="Path_8433-2" class="draw" data-name="Path 8433" d="M448.213,232.117a2.7,2.7,0,0,0-.531.5c-.148.206-.293.415-.412.621l-.914-.737-44.7-36.125H343.969V194.9h58.193l.206.177,44.9,36.273Z" transform="translate(-343.969 -194.901)" fill="#29abe2"/>
                                            <g id="Group_4363-2" data-name="Group 4363" transform="translate(101.693 35.101)">
                                                <path id="Path_8434-2" class="head" data-name="Path 8434" d="M383.755,206.922a5.017,5.017,0,0,0-6.57.238,2.81,2.81,0,0,0-.5.528c-.145.209-.293.415-.412.621a4.992,4.992,0,0,0,.737,6.039c.058.029.09.09.148.148.087.058.177.148.293.235a5.019,5.019,0,0,0,6.306-7.809Zm-.177,6.335a3.834,3.834,0,0,1-5.392.56,3.874,3.874,0,0,1-1-4.771c.119-.206.264-.415.412-.621a2.694,2.694,0,0,1,.531-.5,3.853,3.853,0,0,1,4.656-.267c.09.061.148.119.235.177.061.061.119.09.148.148A3.847,3.847,0,0,1,383.578,213.257Z" transform="translate(-375.576 -205.811)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                        <g id="Group_4366-2" data-name="Group 4366" transform="translate(0.325 0)">
                                            <path id="Path_8435-2" class="draw" data-name="Path 8435" d="M432.45,123.036a2.871,2.871,0,0,0,.09.737H343.823V122.3H432.54A2.87,2.87,0,0,0,432.45,123.036Z" transform="translate(-343.823 -118.026)" fill="#29abe2"/>
                                            <g id="Group_4365-2" data-name="Group 4365" transform="translate(87.449)">
                                                <path id="Path_8436-2" class="head" data-name="Path 8436" d="M376.041,120.971a5.043,5.043,0,0,0-4.98,4.273,4.71,4.71,0,0,0,0,1.474,5.021,5.021,0,1,0,4.98-5.746Zm0,8.841a3.83,3.83,0,0,1-3.771-3.1,3.056,3.056,0,0,1,0-1.474,3.835,3.835,0,1,1,3.771,4.569Z" transform="translate(-371.003 -120.971)" fill="#29abe2"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>

                    </div>



                        @yield('content')


      </div>
      </div>
      </div>
      </div>
      <div class="login-footer">
          <div class="text"></div>
          <div class="image">
              <div class="left"><img src="{{url('/gym')}}/img/Group 23116.png" width="105px" alt=""></div>
              <div class="right"><img src="{{url('/gym')}}/img/Group 23115.png" width="105px" alt=""></div>
              <div class="container">
{{--                  <marquee width="100%" direction="left" height="100px" behavior="scroll">--}}
{{--                      <table class="table">--}}
{{--                          <thead>--}}
{{--                          <tr>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 4025.png" width="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Path 50461.png" width="45px" height="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23076.png" width="33px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Icon_view.png" width="30px" height="28px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Path 50462.png" width="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23081.png" width="29px" height="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23080.png" width="28px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23079.png" width="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23082.png" width="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23097.png" width="30px" height="27" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23103.png" width="38px" height="27px" alt=""> <span></span><span></span></th>--}}


{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 4025.png" width="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Path 50461.png" width="45px" height="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23076.png" width="33px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Icon_view.png" width="44px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Path 50462.png" width="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23081.png" width="29px" height="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23080.png" width="28px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23079.png" width="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23082.png" width="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23097.png" width="43px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23103.png" width="50px" alt=""> <span></span><span></span></th>--}}


{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 4025.png" width="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Path 50461.png" width="45px" height="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23076.png" width="33px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Icon_view.png" width="30px" height="28px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Path 50462.png" width="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23081.png" width="29px" height="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23080.png" width="28px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23079.png" width="27px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23082.png" width="30px" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23097.png" width="30px" height="27" alt=""> <span></span><span></span></th>--}}
{{--                              <th scope=""><img src="{{url('/gym')}}/img/Group 23103.png" width="38px" height="27px" alt=""> <span></span><span></span></th>--}}

{{--                          </tr>--}}


{{--                          </thead>--}}

{{--                      </table>--}}
{{--                  </marquee>--}}
                  <div class="table-responsive text-nowrap">

                      <table class="table">
                          <thead>
                          <tr>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 4025.png" width="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Path 50461.png" width="45px" height="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23076.png" width="33px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Icon_view.png" width="30px" height="28px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Path 50462.png" width="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23081.png" width="29px" height="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23080.png" width="28px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23079.png" width="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23082.png" width="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23097.png" width="30px" height="27" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23103.png" width="38px" height="27px" alt=""> <span></span><span></span></th>


                              <th scope=""><img src="{{url('/gym')}}/img/Group 4025.png" width="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Path 50461.png" width="45px" height="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23076.png" width="33px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Icon_view.png" width="44px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Path 50462.png" width="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23081.png" width="29px" height="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23080.png" width="28px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23079.png" width="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23082.png" width="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23097.png" width="43px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23103.png" width="50px" alt=""> <span></span><span></span></th>


                              <th scope=""><img src="{{url('/gym')}}/img/Group 4025.png" width="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Path 50461.png" width="45px" height="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23076.png" width="33px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Icon_view.png" width="30px" height="28px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Path 50462.png" width="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23081.png" width="29px" height="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23080.png" width="28px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23079.png" width="27px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23082.png" width="30px" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23097.png" width="30px" height="27" alt=""> <span></span><span></span></th>
                              <th scope=""><img src="{{url('/gym')}}/img/Group 23103.png" width="38px" height="27px" alt=""> <span></span><span></span></th>

                          </tr>


                          </thead>

                      </table>
                  </div>
              </div>
              <div class="copyright text-center">
                  <p>{{__('app.copyrights')}}</p>
              </div>
          </div>
      </div>

      </section>


      <script src="{{url('/gym')}}/js/jquery-3.4.1.min.js"></script>
      <script src="{{url('/js')}}/jquery.validate.min.js"></script>
      <script src="{{url('/gym')}}/js/bootstrap.min.js"></script>
      <script src="{{url('/gym')}}/js/mdb.min.js"></script>
      <script src="{{url('/gym')}}/js/font.main.js"></script>
      <script src="{{url('/gym')}}/js/min.js"></script>
@stack('js')

</body>
<!-- end::Body -->
</html>
