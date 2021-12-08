@extends('layouts.dashboard.speedTest')
@section('page_title')
    {{__('app.customers.speed.registerBranch.page_title')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@push('css')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <h3>{{__('app.customers.speed.registerBranch.title')}}</h3>

        <div class="container-fluid text-center" style="padding-top: 100px;">

            <div class="row text-center">
                <div class="col-6">
                    <h1 id="fooVal"><b></b></h1>
                    <canvas id="foo"></canvas>
                </div>
                <div class="col-6">
                    <select id="branch" name="branch_id" class="form-control col-8 m-auto @error('branch_id') is-invalid @enderror">
                        <option value="">{{ __('app.Select_Branch') }}</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                    <span class="invalid-feedback my-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // start meter
        var opts = {
            angle: 0, // The span of the gauge arc
            lineWidth: 0.44, // The line thickness
            radiusScale: 1, // Relative radius
            pointer: {
                length: 0.6, // // Relative to gauge radius
                strokeWidth: 0.035, // The thickness
                color: '#000000' // Fill color
            },
            limitMax: false,     // If false, max value increases automatically if value > maxValue
            limitMin: false,     // If true, the min value of the gauge will be fixed
            colorStart: '#6FADCF',   // Colors
            colorStop: '#8FC0DA',    // just experiment with them
            strokeColor: '#E0E0E0',  // to see which ones work best for you
            generateGradient: true,
            highDpiSupport: true,     // High resolution support
            staticLabels: {
                font: "10px sans-serif",  // Specifies font
                labels: [0, 25, 50, 75],  // Print labels at these values
                color: "#1F9FD8",  // Optional: Label text color
                fractionDigits: 0  // Optional: Numerical precision. 0=round off.
            },

        };

        var target = document.getElementById('foo'); // your canvas element
        var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
        gauge.maxValue = 75; // set max gauge value
        gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
        gauge.animationSpeed = 32; // set animation speed (32 is default value)

        // end meter


        var imageAddr = '{{ asset('images/to-download.jpg') }}';
        var downloadSize = 41026764; //bytes

        // if (window.addEventListener) {
        //     window.addEventListener('load', InitiateSpeedDetection, false);
        // } else if (window.attachEvent) {
        //     window.attachEvent('onload', InitiateSpeedDetection);
        // }
        $('#fooVal b').html("0  <small>/ Mbps</small>");

        function MeasureConnectionSpeed() {
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

                $('#fooVal b').each(function () {
                    var $this = $(this);
                    jQuery({Counter: this.Counter}).animate({Counter: speedMbps}, {
                        duration: 5000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.ceil(this.Counter) + " Mbps");
                        }
                    });
                });
                var current = parseInt($('#fooVal b').text());
                for (var i = current; i <= parseInt(speedMbps); i++) {
                    $('#fooVal b').html(parseInt(i)+" Mbps");
                }


                console.log("value => " + +"speedMbps => " + speedMbps);


                gauge.set(speedMbps); // set actual value

                // $('#fooVal b').text(speedMbps);

                axios.post('/connection-speed', {
                    internet_speed: speedMbps,
                    branch_id: $('#branch').val()
                });
            }
        }

        $(document).ready(function () {
            $('#branch').change(function () {
                MeasureConnectionSpeed();
            })

            setInterval(function () {
                const branch = $('#branch').val();
                if (branch) {
                    MeasureConnectionSpeed();
                }
            }, 60*1000);
        });
    </script>
@endsection
