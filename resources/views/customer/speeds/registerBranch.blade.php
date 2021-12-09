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
        #chartdiv {
            width: 100%;
            height: 300px;
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
            background: #158ccf3b;
            padding: 40px;
            min-height: 50vh;
        }

        .miters .miter-download b,
        .miters .miter-download h1,
        .miters .miter-download h3 {
            color: #158ccf;
        }

        .miters .miter-upload {
            padding: 15px;
            min-height: 50vh;
            background: #db69ac36;
        }

        .miters .miter-upload b,
        .miters .miter-upload h1,
        .miters .miter-upload h3 {
            color: #db3381;
        }

        .miters-details .download {
            background: #158ccf29;
            padding: 15px;
            border-bottom: 5px solid #158ccf;
        }

        .miters-details .download h3,
        .miters-details .download h3 i,
        .miters-details .download h2 {
            color: #158ccf;
        }

        .miters-details .upload {
            background: #db338130;
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
            background: #3a76b994;
            color: #ccc;
            border: 0;
            border-radius: 0;
        }

        .content-page h5 {
            color: #ccc;
            font-size: 16px;
        }

        .btn-primary:hover, .btn-primary {
            color: #ccc;
            background-color: #023d5f;
            border-color: #2f48c5;
            border: 0;
        }

        p {
            color: #ccc;
        }

        body {
            background: #050606;
        }

        @media (max-width: 768px) {
            .miters  {
                width: 100%;
                position: relative;
                display: block;
                max-width: 100%;
                flex: 0 0 100%!important;
            }
            .miters .miter-download {
                background: #158ccf3b;
                padding: 20px;
                min-height: 50vh;
                height: 180px;
                width: 50%;
                float: left;
            }
            .miters .miter-upload {
                padding: 20px;
                min-height: 50vh;
                background: #db69ac36;
                height: 180px;
                width: 50%;
                float: left;
            }
            .col-8{
                flex: 0 0 100%;
                max-width: 100%;
            }
            #downloadSpeed,
            #uploadSpeed{
                width: 100%;
                height: auto;
            }
            .miters .miter-upload b, .miters .miter-upload h1, .miters .miter-upload h3,
            .miters .miter-download b, .miters .miter-download h1, .miters .miter-download h3{
                font-size: 18px;
            }
        }

        @media (max-width: 400px) {
            .miters .miter-upload,
            .miters .miter-download{
                min-height: auto;
                height: 150px;
            }
            .miters .miter-upload b, .miters .miter-upload h1, .miters .miter-upload h3, .miters .miter-download b, .miters .miter-download h1, .miters .miter-download h3{
                font-size: 14px;
            }
            .miters-details .download h3, .miters-details .download h3 i, .miters-details .download h2,
            .miters-details .upload h3, .miters-details .upload h3 i, .miters-details .upload h2{
                color: #158ccf;
                font-size: 18px;
            }
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
                        <canvas id="downloadSpeed"></canvas>
                        <h3>Dowload Speed</h3>
                    </div>
                    <div class="col-12 miter-upload">
                        <h1 id="uploadVal"><b></b></h1>
                        <canvas id="uploadSpeed"></canvas>
                        <h3>Upload Speed</h3>
                    </div>
                </div>
                <div class="col-8">
                    <div class="col-12 py-5">
                        <h5><i class="fas fa-check"></i> Select Branch</h5>
                        <div class="input-group">
                            <input list="brow" id="branch" name="branch_id"
                                   class="form-control @error('branch_id') is-invalid @enderror">
                            <datalist id="brow">
                                <option value="">{{ __('app.Select_Branch') }}</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </datalist>
                            <div class="input-group-append border-radius-0">
                                <button class="btn btn-primary " style="width: 100px"
                                        onclick="MeasureConnectionSpeed()">Start
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{--    new   --}}
    <script src="//www.amcharts.com/lib/4/core.js"></script>
    <script src="//www.amcharts.com/lib/4/charts.js"></script>
    <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="//www.amcharts.com/lib/4/themes/dark.js"></script>

    <script>
        data = [];
        am4core.useTheme(am4themes_animated);
        am4core.useTheme(am4themes_dark);

        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.hiddenState.properties.opacity = 0;

        chart.padding(0, 0, 0, 0);

        chart.zoomOutButton.disabled = true;

        chart.data = data;

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.grid.template.location = 0;
        dateAxis.renderer.minGridDistance = 30;
        dateAxis.dateFormats.setKey("second", "ss");
        dateAxis.periodChangeDateFormats.setKey("second", "[bold]h:mm a");
        dateAxis.periodChangeDateFormats.setKey("minute", "[bold]h:mm a");
        dateAxis.periodChangeDateFormats.setKey("hour", "[bold]h:mm a");
        dateAxis.renderer.inside = true;
        dateAxis.renderer.axisFills.template.disabled = true;
        dateAxis.renderer.ticks.template.disabled = true;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.tooltip.disabled = true;
        valueAxis.interpolationDuration = 500;
        valueAxis.rangeChangeDuration = 500;
        valueAxis.renderer.inside = true;
        valueAxis.renderer.minLabelPosition = 0.05;
        valueAxis.renderer.maxLabelPosition = 0.95;
        valueAxis.renderer.axisFills.template.disabled = true;
        valueAxis.renderer.ticks.template.disabled = true;

        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.dateX = "date";
        series.dataFields.valueY = "value";
        series.interpolationDuration = 500;
        series.defaultState.transitionDuration = 0;
        series.tensionX = 0.8;

        chart.events.on("datavalidated", function () {
            dateAxis.zoom({ start: 1 / 15, end: 1.2 }, false, true);
        });

        dateAxis.interpolationDuration = 500;
        dateAxis.rangeChangeDuration = 500;

        // all the below is optional, makes some fancy effects
        // gradient fill of the series
        series.fillOpacity = 1;
        var gradient = new am4core.LinearGradient();
        gradient.addColor(chart.colors.getIndex(0), 0.2);
        gradient.addColor(chart.colors.getIndex(0), 0);
        series.fill = gradient;

        // this makes date axis labels to fade out
        dateAxis.renderer.labels.template.adapter.add("fillOpacity", function (fillOpacity, target) {
            var dataItem = target.dataItem;
            return dataItem.position;
        })

        // need to set this, otherwise fillOpacity is not changed and not set
        dateAxis.events.on("validated", function () {
            am4core.iter.each(dateAxis.renderer.labels.iterator(), function (label) {
                label.fillOpacity = label.fillOpacity;
            })
        })

        // this makes date axis labels which are at equal minutes to be rotated
        dateAxis.renderer.labels.template.adapter.add("rotation", function (rotation, target) {
            var dataItem = target.dataItem;
            if (dataItem.date.getTime() == am4core.time.round(new Date(dataItem.date.getTime()), "minute").getTime()) {

                target.verticalCenter = "middle";
                target.horizontalCenter = "left";
                return -90;
            }
            else {
                target.verticalCenter = "bottom";
                target.horizontalCenter = "middle";
                return 0;
            }
        })

        // bullet at the front of the line
        var bullet = series.createChild(am4charts.CircleBullet);
        bullet.circle.radius = 5;
        bullet.fillOpacity = 1;
        bullet.fill = chart.colors.getIndex(0);
        bullet.isMeasured = false;

        series.events.on("validated", function() {
            bullet.moveTo(series.dataItems.last.point);
            bullet.validatePosition();
        });


        for (let i=0; i<60; i++)
            data.push({ date: new Date().setSeconds(i - 60), value: 0 });

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
            strokeColor: '#fff',  // to see which ones work best for you
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
        gaugeDownload.maxValue = 3000; // set max gauge value
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
                color: '#db3381' // Fill color
            },
            limitMax: false,     // If false, max value increases automatically if value > maxValue
            limitMin: false,     // If true, the min value of the gauge will be fixed
            colorStart: '#ffffff',   // Colors
            colorStop: '#db3381',    // just experiment with them
            strokeColor: '#ffffff',  // to see which ones work best for you
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

        var dataDownload=[140, 150, 160, 140, 130, 150, 130, 140, 160, 165];
        function MeasureConnectionSpeed() {
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
                            duration: 5000,
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
                    $('.miters-details .download p').html("Test Time: " +duration +"/s");

                    gaugeDownload.set(speedMbps); // set actual value

                    startTime =  new Date();
                    let uploadSpeedMbps = 0;

                    //////////////////////////////////////
                    uploadSpeedMbps = 0;

                    current = parseInt($('#uploadVal b').text());
                    for (var i = current; i <= parseInt(uploadSpeedMbps); i++) {
                        $('#uploadVal b').html(0 + " Mbps");
                    }
                    gaugeUpload.set(uploadSpeedMbps);

                    axios.post('/connection-speed', {
                        internet_speed: speedMbps,
                        upload_speed: 0,
                        branch_id: $('#branch').val()
                    })
                        .then(() => {
                            var lastdataItem = series.dataItems.getIndex(series.dataItems.length - 1);
                            chart.addData(
                                { date: new Date(lastdataItem.dateX.getTime() + 1000), value: speedMbps },
                                1
                            );
                        });
                    ////////////////////////////

                    // axios.post('upload', getRandomString(1))
                    //     .then(res => {
                    //
                    //     })
                    //     .catch(err => {
                    //     });
                }
            }

        }

        function getRandomString( sizeInMb ) {
            var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~!@#$%^&*()_+`-=[]\{}|;':,./<>?", //random data prevents gzip effect
                iterations = sizeInMb * 1024 * 1024, //get byte count
                result = '';
            for( var index = 0; index < iterations; index++ ) {
                result += chars.charAt( Math.floor( Math.random() * chars.length ) );
            };
            return result;
        };

        $(document).ready(function () {
            // $('#branch').change(function () {
            //     MeasureConnectionSpeed();
            // })

            setInterval(function () {
                const branch = $('#branch').val();
                if (branch) {
                    MeasureConnectionSpeed();
                }
            }, 60 * 1000);
        });



    </script>

@endsection
