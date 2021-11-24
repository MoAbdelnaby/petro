@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.customers.speed.registerBranch.page_title')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@push('css')
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h3>{{__('app.customers.speed.registerBranch.title')}}</h3>
            <hr />
            <div class="md-form col-md-4">
                <select id="branch" name="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                    <option value="">select branch</option>
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
@endsection

@section('scripts')
    <script>
        var imageAddr = "/images/to-download.jpg";
        var downloadSize = 2936012.8; //bytes

        function ShowProgressMessage(msg) {
            if (console) {
                if (typeof msg == "string") {
                    console.log(msg);
                } else {
                    for (var i = 0; i < msg.length; i++) {
                        console.log(msg[i]);
                    }
                }
            }

            // var oProgress = document.getElementById("progress");
            // if (oProgress) {
            //     var actualHTML = (typeof msg == "string") ? msg : msg.join("<br />");
            //     oProgress.innerHTML = actualHTML;
            // }
        }

        function InitiateSpeedDetection() {
            console.log('InitiateSpeedDetection')
            ShowProgressMessage("Loading the image, please wait...");
            window.setTimeout(MeasureConnectionSpeed, 1);
        };

        // if (window.addEventListener) {
        //     window.addEventListener('load', InitiateSpeedDetection, false);
        // } else if (window.attachEvent) {
        //     window.attachEvent('onload', InitiateSpeedDetection);
        // }

        function MeasureConnectionSpeed() {
            var startTime, endTime;
            var download = new Image();
            download.onload = function () {
                endTime = (new Date()).getTime();
                showResults();
            }

            download.onerror = function (err, msg) {
                ShowProgressMessage("Invalid image, or error downloading");
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
                ShowProgressMessage([
                    "Your connection speed is:",
                    speedBps + " bps",
                    speedKbps + " kbps",
                    speedMbps + " Mbps"
                ]);

                axios.post('/connection-speed', {
                    internet_speed: speedMbps,
                    branch_id: $('#branch').val()
                })
            }
        }

        $(document).ready(function () {
            $('#branch').change(function () {
                InitiateSpeedDetection();
            })

            setInterval(function(){
                const branch = $('#branch').val();
                if (branch) {
                    InitiateSpeedDetection();
                }
            }, 3600000);
        });
    </script>
@endsection
