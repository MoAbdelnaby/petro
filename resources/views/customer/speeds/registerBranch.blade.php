@extends('layouts.dashboard.speedTest')
@section('page_title')
    {{__('app.customers.speed.registerBranch.page_title')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@push('css')
    <!-- Styles -->
    <style>
        #loading {
            background: #fff url(../../images/loader.gif) no-repeat scroll center center;
            height: 100%;
            width: 100%;
            background-size: 10%;
            position: fixed;
            margin-top: 0px;
            top: 0px;
            left: 0px;
            bottom: 0px;
            overflow: hidden !important;
            right: 0px;
            z-index: 999999;
        }
        .loading-view span {
            border: 3px solid #f3f3f3; /* Light grey */
            border-top: 3px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            position: absolute;
            left: calc(50% - 60px);
            top: calc(50% - 60px);
        }
        .loading-view img {
            width: 90px;
            height: auto;
            left: calc(50% - 45px);
            top: calc(50% - 40px);
            position: absolute;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-view::before{
            content: '';
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
            background: #d6d6d6;
        }
        @-webkit-keyframes load {

            to {
                transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
            }
        }
        @keyframes load {

            to {
                transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
            }
        }
        @-webkit-keyframes load2 {

            to {
                transform: rotate(-360deg);
                -webkit-transform: rotate(-360deg);
                -moz-transform: rotate(-360deg);
                -ms-transform: rotate(-360deg);
                -o-transform: rotate(-360deg);
            }

        }

        @keyframes load2 {

            to {
                transform: rotate(-360deg);
                -webkit-transform: rotate(-360deg);
                -moz-transform: rotate(-360deg);
                -ms-transform: rotate(-360deg);
                -o-transform: rotate(-360deg);
            }

        }

        #chartdiv {
            width: 100%;
            height: calc(100vh - 370px);
        }

        .select2-container {
            width: 100% !important;
        }

        #contentPage {
            width: 100%;
            background: url(http://petromin-v2.test/images/logo.svg) no-repeat;
            background-attachment: fixed;
            background-position: left bottom;
            background-size: 7%;
            min-height: 100vh;
        }

        .miters .miter-download {
            background: #f6f6f6;
            padding: 40px 0px;
            min-height: 50vh;
            max-height: 50vh;
        }

        .miters .miter-download b,
        .miters .miter-download h1,
        .miters .miter-download h3 {
            color: #158ccf;
        }

        .miters .miter-upload {
            padding: 40px 0px;
            min-height: 50vh;
            background: #eaeaea;
            max-height: 50vh;
        }

        .miters .miter-upload b,
        .miters .miter-upload h1,
        .miters .miter-upload h3 {
            color: #db3381;
        }

        .miters-details .download {
            background: #f6f6f6;
            padding: 15px;
            border-bottom: 5px solid #158ccf;
        }

        .miters-details .download h3,
        .miters-details .download h3 i,
        .miters-details .download h2 {
            color: #158ccf;
        }

        .miters-details .upload {
            background: #eaeaea;
            padding: 15px;
            border-bottom: 5px solid #db3381;
        }

        .miters-details .upload h3,
        .miters-details .upload h3 i,
        .miters-details .upload h2 {
            color: #db3381;
        }

        .btn {
            border-radius: 0;
        }

        #branch {
            border-radius: 0;
        }

        .content-page h5 {
            color: #03334b;
            font-size: 16px;
        }

        .btn-primary:hover, .btn-primary {
            color: #fff;
            background-color: #023d5f;
            border-color: #2f48c5;
            border: 0;
        }

        p {
            color: #504f4f;
        }

        body {
            background: #fff;
        }

        .miter-download::before{
            content: "";
            width: 30px;
            height: 30px;
            display: block;
            z-index: 9;
            top: 90px;
            left: 0;
            position: absolute;
            background: #f6f6f6;
        }
        .miter-upload::before{
            content: "";
            width: 30px;
            height: 30px;
            display: block;
            z-index: 9;
            top: 90px;
            left: 0;
            position: absolute;
            background: #eaeaea;
        }
        @media (max-width: 768px) {
            .miters {
                width: 100%;
                position: relative;
                display: block;
                max-width: 100%;
                flex: 0 0 100% !important;
            }

            .miters .miter-download {
                padding: 20px;
                min-height: 180px;
                width: 50%;
                float: left;
            }

            .miters .miter-upload {
                padding: 20px;
                min-height: 180px;
                width: 50%;
                float: left;
            }

            .col-8 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            #downloadSpeed,
            #uploadSpeed {
                width: 100%!important;
                height: auto;
            }

            .miter-download::before{
                content: "";
                width: 40px;
                height: 40px;
                display: block;
                z-index: 9;
                top: 40px;
                left: 0;
                position: absolute;
                background: #f6f6f6;
            }
            .miter-upload::before{
                content: "";
                width: 40px;
                height: 40px;
                display: block;
                z-index: 9;
                top: 40px;
                left: 0;
                position: absolute;
                background: #eaeaea;
            }

            .miters .miter-upload b, .miters .miter-upload h1, .miters .miter-upload h3,
            .miters .miter-download b, .miters .miter-download h1, .miters .miter-download h3 {
                font-size: 18px;
            }
        }

        @media (max-width: 400px) {
            .miters .miter-upload,
            .miters .miter-download {
                min-height: auto;
                height: 150px;
            }

            .miters .miter-upload b, .miters .miter-upload h1, .miters .miter-upload h3, .miters .miter-download b, .miters .miter-download h1, .miters .miter-download h3 {
                font-size: 14px;
            }

            .miters-details .download h3, .miters-details .download h3 i, .miters-details .download h2,
            .miters-details .upload h3, .miters-details .upload h3 i, .miters-details .upload h2 {
                color: #158ccf;
                font-size: 18px;
            }
        }

        .select2-container .select2-selection--single,
        .select2-container--default .select2-selection--single .select2-selection__rendered,
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px !important;
            line-height: 35px !important;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0 !important;
        }

        .select2-container--default .select2-selection--single {
            /*background-color: #023d5f !important;*/
            border: 1px solid #03293f !important;
            /*color: #cacbcb !important;*/
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #cacbcb !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #cacbcb transparent transparent transparent;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content  -->
    <div id="contentPage" class="content-page">
        {{--        <h3>{{__('app.customers.speed.registerBranch.title')}}</h3>--}}
        <div class="container-fluid">

            <div class="row">
                <div class="col-4 miters px-0 text-center">
                    <div class="col-12 miter-download">
                        <h1 id="downloadVal"><b></b></h1>
                        <canvas id="downloadSpeed" style="width:100%!important"></canvas>
                        <h3>Download Speed</h3>
                    </div>
                    <div class="col-12 miter-upload">
                        <h1 id="uploadVal"><b></b></h1>
                        <canvas id="uploadSpeed" style="width:100%!important"></canvas>
                        <h3>Upload Speed</h3>
                    </div>
                </div>
                <div class="col-8">
                    <div class="col-12 py-5">
                        <h5><i class="fas fa-check"></i> Select Branch</h5>
                        <div class="input-group">
                            <siv class="col">
                                <select class="js-example-basic-single form-control" id="branch" name="branch_id"
                                        class="form-control @error('branch_id') is-invalid @enderror">
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </siv>
                            <div class="input-group-append border-radius-0">
                                <button id="startTest" class="btn btn-primary " style="width: 100px"><i
                                        class="fas fa-spinner fa-pulse" style="display: none"></i>
                                    <span class="btn-text">Start</span>
                                </button>
                            </div>
                            @error('branch_id')
                            <span class="invalid-feedback my-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 miters-details mb-5">
                        <div class="row">
                            <div class="col text-center download border-right border-dashed">
                                <h3><i class="fas fa-download"></i> <b>Download</b></h3>
                                <h2><b>0</b> <small>/ MB.S</small></h2>
                                <p>Test Time: 0s</p>
                            </div>
                            <div class="col text-center upload">
                                <h3><i class="fas fa-upload"></i> <b>Upload</b></h3>
                                <h2><b>0</b> <small>/ MB.S</small></h2>
                                <p>Test Time: 0s</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        {{--                        <canvas id="myChart" style="width:100%;max-width:100%; height: 300px"></canvas>--}}
                        <div id="chartdiv"></div>
                        {{--                        <div id="myPlot" style="width:100%;max-width:100%;height: 300px"></div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
{{--    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plotly.js/2.8.0/plotly.min.js" integrity="sha512-f3qLqdhI7wNaQjMmD8wj7NiBqolsL1Xi+9ZTvojVvhcXjzDePVtdzHhO+DwD2QM2OAlRF8LCoxMr+zQLeirBGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
            integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{--    new   --}}
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        jQuery("#load").fadeOut();
        jQuery("#loading").delay().fadeOut("");
        am5.ready(function () {
            var root = am5.Root.new("chartdiv");

            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                focusable: true,
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX"
            }));

            var easing = am5.ease.linear;

            var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
                maxDeviation: 0.5,
                extraMin: -0.1,
                extraMax: 15,
                groupData: false,
                baseInterval: {
                    timeUnit: "min",
                    count: 1
                },
                renderer: am5xy.AxisRendererX.new(root, {
                    minGridDistance: 100
                }),
                tooltip: am5.Tooltip.new(root, {})
            }));

            // var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            //     renderer: am5xy.AxisRendererY.new(root, {})
            // }));
            let yAxis = chart.yAxes.push(
                am5xy.ValueAxis.new(root, {
                    min: 0,
                    max: 70,
                    renderer: am5xy.AxisRendererY.new(root, {}),
                })
            );

            var series = chart.series.push(am5xy.LineSeries.new(root, {
                minBulletDistance: 1,
                name: "Download",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                valueXField: "date",
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "horizontal",
                    labelText: "{valueY}"
                })
            }));
            series.set({"fill": am5.color("#158ccf"), "stroke": am5.color("#5ca1c7")}); // set Series color to green

            series.data.setAll([]);

            series.bullets.push(function () {
                return am5.Bullet.new(root, {
                    locationX: undefined,
                    sprite: am5.Circle.new(root, {
                        radius: 4,
                        fill: series.get("fill")
                    })
                })
            });

            var series2 = chart.series.push(am5xy.LineSeries.new(root, {
                minBulletDistance: 1,
                name: "Upload",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value2",
                valueXField: "date",
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "horizontal",
                    labelText: "{value2Y}"
                })
            }));
            series2.data.setAll([]);
            series2.set("fill", am5.color("#db3381")); // set Series color to green
            series2.set("stroke", am5.color("#ee579c")); // set Series color to green

            series2.bullets.push(function () {
                return am5.Bullet.new(root, {
                    locationX: undefined,
                    sprite: am5.Circle.new(root, {
                        radius: 4,
                        fill: series2.get("fill")
                    })
                })
            });

            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                xAxis: xAxis
            }));
            cursor.lineY.set("visible", false);

            /////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////
            $('.js-example-basic-single').select2();
            $('#startTest').on('click', function () {
                MeasureConnectionSpeed();
                $('#startTest i.fa-spinner').show();
            });
            $('#branch').on('change', function (){
                $('#startTest i.fa-spinner').hide();

            })

            // download start meter
            var optsDowload = {
                angle: -0.11, // The span of the gauge arc
                lineWidth: 0.04, // The line thickness
                radiusScale: 0.85, // Relative radius
                pointer: {
                    length: 0.4, // // Relative to gauge radius
                    strokeWidth: 0.071, // The thickness
                    color: '#158ccf' // Fill color
                },
                limitMax: false,     // If false, max value increases automatically if value > maxValue
                limitMin: false,     // If true, the min value of the gauge will be fixed
                colorStart: '#fff',   // Colors
                colorStop: '#158ccf',    // just experiment with them
                strokeColor: '#6bb2da',  // to see which ones work best for you
                generateGradient: true,
                highDpiSupport: true,     // High resolution support
                // renderTicks is Optional
                renderTicks: {
                    divisions: 19,
                    divWidth: 0.1,
                    divLength: 1,
                    divColor: '#030733',
                    subDivisions: 4,
                    subLength: 0.53,
                    subWidth: 0.1,
                    subColor: '#160266'
                }

            };
            var target = document.getElementById('downloadSpeed'); // your canvas element
            var gaugeDownload = new Gauge(target).setOptions(optsDowload); // create sexy gauge!
            gaugeDownload.maxValue = 150; // set max gauge value
            gaugeDownload.setMinValue(0);  // Prefer setter over gauge.minValue = 0
            gaugeDownload.animationSpeed = 32; // set animation speed (32 is default value)
            // end meter
            var optsUpload = {
                angle: -0.11, // The span of the gauge arc
                lineWidth: 0.04, // The line thickness
                radiusScale: 0.85, // Relative radius
                pointer: {
                    length: 0.4, // // Relative to gauge radius
                    strokeWidth: 0.071, // The thickness
                    color: '#db3381', // Fill color
                    font_size: 55,
                },
                limitMax: false,     // If false, max value increases automatically if value > maxValue
                limitMin: false,     // If true, the min value of the gauge will be fixed
                colorStart: '#ffffff',   // Colors
                colorStop: '#db3381',    // just experiment with them
                strokeColor: '#f679b4',  // to see which ones work best for you
                generateGradient: true,
                highDpiSupport: true,     // High resolution support
                // renderTicks is Optional
                renderTicks: {
                    divisions: 19,
                    divWidth: 0.1,
                    divLength: 1,
                    divColor: '#db3381',
                    subDivisions: 4,
                    subLength: 0.53,
                    subWidth: 0.1,
                    subColor: '#db3381'
                }
            };
            var targetUpload = document.getElementById('uploadSpeed'); // your canvas element
            var gaugeUpload = new Gauge(targetUpload).setOptions(optsUpload); // create sexy gauge!
            gaugeUpload.maxValue = 75; // set max gauge value
            gaugeUpload.setMinValue(0);  // Prefer setter over gauge.minValue = 0
            gaugeUpload.animationSpeed = 32; // set animation speed (32 is default value)
            // end meter
            var imageAddr = '{{ asset('images/to-download.jpg') }}';
            var downloadSize = 41026764; //bytes

            // if (window.addEventListener) {
            //     window.addEventListener('load', InitiateSpeedDetection, false);
            // } else if (window.attachEvent) {
            //     window.attachEvent('onload', InitiateSpeedDetection);
            // }
            $('#downloadVal b').html("0  <small>/ Mbps</small>");
            $('#uploadVal b').html("0  <small>/ Mbps</small>");

            var dataDownload = [0, 0];
            var dataUpload = [0, 0];

            function MeasureConnectionSpeed() {
                const branch = $('#branch').val();
                if (branch < 0) {
                    return;
                }
                gaugeDownload.set(0);
                gaugeUpload.set(0);
                $('#downloadVal b').html(0 + " Mbps");
                if ($('#branch').val()) {
                    var startTime, endTime;
                    var download = new Image();
                    download.onload = function () {
                        endTime = (new Date()).getTime();
                        showResults();
                    }
                    download.onerror = function (err, msg) {
                        console.log("Invalid image, or error downloading");
                    }
                    startTime = (new Date()).getTime();
                    var cacheBuster = "?nnn=" + startTime;
                    download.src = imageAddr + cacheBuster;

                    function showResults() {
                        var duration = (endTime - startTime) / 1000;
                        var bitsLoaded = downloadSize * 8;
                        var speedBps = (bitsLoaded / duration).toFixed(2);
                        var speedKbps = (speedBps / 1024).toFixed(2);
                        var speedMbps = (speedKbps / 1024).toFixed(2);

                        $('#downloadVal b').each(function () {
                            var $this = $(this);
                            jQuery({Counter: this.Counter}).animate({Counter: speedMbps}, {
                                duration: 1000,
                                easing: 'swing',
                                step: function () {
                                    $this.text(Math.ceil(this.Counter) + " Mbps");
                                }
                            });
                        });
                        dataDownload.push(speedMbps);

                        var current = parseInt($('#downloadVal b').text());
                        for (var i = current; i <= parseInt(speedMbps); i++) {
                            $('#downloadVal b').html(parseInt(i) + " Mbps");
                        }
                        $('.miters-details .download h2 b').html(speedMbps);
                        $('.miters-details .download p').html("Test Time: " + duration + "/s");

                        gaugeDownload.set(speedMbps); // set actual value


                        startTime = new Date();
                        let uploadSpeedMbps = 0;
                        let uploadSize = 10 * 1024 * 1024;
                        let base64 = `{{ file_get_contents(url('assets/base64.txt')) }}`;

                        axios.post('/uploadSpeed', {
                            base64: base64
                        })
                            .then(res => {
                                endTime = (new Date()).getTime();
                                var duration2 = (endTime - startTime) / 1000;
                                bitsLoaded = uploadSize * 8;
                                speedBps = (bitsLoaded / duration2).toFixed(2);
                                speedKbps = (speedBps / 1024).toFixed(2);
                                uploadSpeedMbps = (speedKbps / 1024).toFixed(2);

                                $('#uploadVal b').each(function () {
                                    var $this = $(this);
                                    jQuery({Counter: this.Counter}).animate({Counter: uploadSpeedMbps}, {
                                        duration: 1000,
                                        easing: 'swing',
                                        step: function () {
                                            $this.text(Math.ceil(this.Counter) + " Mbps");
                                        }
                                    });
                                });

                                current = parseInt($('#uploadVal b').text());
                                for (var i = current; i <= parseInt(uploadSpeedMbps); i++) {
                                    $('#uploadVal b').html(i + " Mbps");
                                }
                                dataUpload.push(uploadSpeedMbps);
                                gaugeUpload.set(uploadSpeedMbps);

                                $('.miters-details .upload h2 b').html(uploadSpeedMbps);
                                $('.miters-details .upload p').html("Test Time: " + duration + "/s");

                                axios.post('/connection-speed', {
                                    internet_speed: speedMbps,
                                    load_time: duration,
                                    upload_speed: uploadSpeedMbps,
                                    uploaded_time: duration2,
                                    branch_id: $('#branch').val()
                                })
                                    .then(() => {
                                        addData(speedMbps, uploadSpeedMbps);

                                        setTimeout(() => {
                                            MeasureConnectionSpeed();
                                        }, 60*1000);
                                    });
                            })
                            .catch(err => {
                            });
                    }
                }

            }

            /////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////


            function addData(download, upload) {
                var lastDataItem = series.dataItems[series.dataItems.length - 1];
                var lastValue = lastDataItem ? lastDataItem.get("valueY") : 0;
                var newValue = download;
                var lastDate = lastDataItem ? new Date(lastDataItem.get("valueX")) : new Date();
                var time = am5.time.add(new Date(lastDate), "minute", 1).getTime();
                if (series.data.length > 30)
                    series.data.removeIndex(0);
                    series.data.push({
                        date: time,
                        value: newValue,
                    })

                var newDataItem = series.dataItems[series.dataItems.length - 1];
                    newDataItem.animate({
                        key: "valueYWorking",
                        to: newValue,
                        from: lastValue,
                        duration: 600,
                        easing: easing
                    });

                var lastDataItem2 = series2.dataItems[series2.dataItems.length - 1];
                var lastValue2 = lastDataItem2 ? lastDataItem2.get("value2Y") : 0;
                if (series2.data.length > 30)
                    series2.data.removeIndex(0);
                series2.data.push({
                    date: time,
                    value2: upload,
                })

                var newDataItem2 = series2.dataItems[series2.dataItems.length - 1];
                newDataItem2.animate({
                    key: "value2YWorking",
                    to: upload,
                    from: lastValue2,
                    duration: 600,
                    easing: easing
                });

                var animation = newDataItem.animate({
                    key: "locationX",
                    to: 0.5,
                    from: -0.5,
                    duration: 600
                });
                if (animation) {
                    var tooltip = xAxis.get("tooltip");
                    if (tooltip && !tooltip.isHidden()) {
                        animation.events.on("stopped", function () {
                            xAxis.updateTooltip();
                        })
                    }
                }
            }

            chart.appear(1000, 100);

            $(document).ready(function () {

                $('.js-example-basic-single').select2();
                $('#startTest').on('click', function () {
                    MeasureConnectionSpeed();
                    $('#startTest i.fa-spinner').show();
                });
            });

        }); // end am5.ready()



    </script>

@endsection
