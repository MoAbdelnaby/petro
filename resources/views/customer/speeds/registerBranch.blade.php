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
    </style>
    <style>
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
        .miters .miter-download h3{
            color: #158ccf;
        }
        .miters .miter-upload {
            padding: 15px;
            min-height: 50vh;
            background: #db69ac36;
        }
        .miters .miter-upload b,
        .miters .miter-upload h1,
        .miters .miter-upload h3{
            color: #db3381;
        }
        .miters-details .download{
            background: #158ccf29;
            padding: 15px;
            border-bottom: 5px solid #158ccf;
        }
        .miters-details .download h3,
        .miters-details .download h3 i,
        .miters-details .download h2{
            color: #158ccf;
        }
        .miters-details .upload {
            background: #db338130;
            padding: 15px;
            border-bottom: 5px solid #db3381;
        }
        .miters-details .upload h3,
        .miters-details .upload h3 i,
        .miters-details .upload h2{
            color: #db3381;
        }
        .btn{
            border-radius: 0;
        }
        #branch{
            background: #3a76b994;
            color: #ccc;
            border: 0;
            border-radius: 0;
        }
        .content-page h5 {
            color: #ccc;
            font-size: 16px;
        }
        .btn-primary:hover,.btn-primary {
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
                            <select id="branch" name="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                                <option value="">{{ __('app.Select_Branch') }}</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append border-radius-0">
                                <button class="btn btn-primary " style="width: 100px" onclick="MeasureConnectionSpeed()">Start</button>
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
                                <h2><b>125</b> <small>/ MB.S</small></h2>
                                <p>Test Time: 60s</p>
                            </div>
                            <div class="col text-center upload">
                                <h3><i class="fas fa-upload"></i> <b>Upload</b></h3>
                                <h2><b>125</b> <small>/ MB.S</small></h2>
                                <p>Test Time: 60s</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <canvas id="myChart" style="width:100%;max-width:100%; height: 300px"></canvas>
{{--                        <div id="myPlot" style="width:100%;max-width:100%;height: 300px"></div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
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

        function MeasureConnectionSpeed() {
            gaugeDownload.set(0);
            gaugeUpload.set(0);
            $('#downloadVal b').html(0+" Mbps");
            if($('#branch').val()){

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
                    var bitsLoaded = downloadSize*8;
                    var speedBps = (bitsLoaded / duration).toFixed(2);
                    var speedKbps = (speedBps / 1024).toFixed(2);
                    var speedMbps = (speedKbps / 1024).toFixed(2);
                    console.log([
                        "Your connection speed is:",
                        speedBps + " bps",
                        speedKbps + " kbps",
                        speedMbps + " Mbps"
                    ]);

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
                    var current = parseInt($('#downloadVal b').text());
                    for (var i = current; i <= parseInt(speedMbps); i++) {
                        $('#downloadVal b').html(parseInt(i)+" Mbps");
                    }
                    gaugeDownload.set(speedMbps); // set actual value

                    setInterval(function (){
                        gaugeUpload.set(speedMbps);
                    },5000)
                    // $('#downloadVal b').text(speedMbps);

                    axios.post('/connection-speed', {
                        internet_speed: speedMbps,
                        branch_id: $('#branch').val()
                    });
                }
            }

        }
        $(document).ready(function () {
            // $('#branch').change(function () {
            //     MeasureConnectionSpeed();
            // })

            setInterval(function () {
                const branch = $('#branch').val();
                if (branch) {
                    MeasureConnectionSpeed();
                }
            }, 60*1000);
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <script>

        var xValues = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50];

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    data: [140,150,160,140,130,150,130,140,160,165],
                    borderColor: "#158ccf",
                    fill: false
                },{
                    data: [60,55,65,75,60,80,55,60,70,75],
                    borderColor: "#db3381",
                    label:'Upload',
                    fill: false
                }]
            },
            options: {
                legend: {display: false}
            }
        });


        var exp1 = "x";
        var exp2 = "1.5*x";
        // Generate values

        var x1Values = [];
        var x2Values = [];
        var x3Values = [];
        var y1Values = [];
        var y2Values = [];
        var y3Values = [];

        for (var x = 0; x <= 10; x += 1) {
            x1Values.push(x);
            x2Values.push(x);
            x3Values.push(x);
            y1Values.push(eval(exp1));
            y2Values.push(eval(exp2));
        }

        // Define Data
        var data = [
            {x: x1Values, y: y1Values, mode:"lines"},
            {x: x2Values, y: y2Values, mode:"lines"}
        ];

        //Define Layout
        var layout = {title: "[y=" + exp1 + "]  [y=" + exp2 + "]"};

        // Display using Plotly
        Plotly.newPlot("myPlot", data, layout);


    </script>

    <!-- HTML -->



@endsection
