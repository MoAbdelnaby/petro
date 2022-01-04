<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.General_Dash_Plates_Maintenance') }}</title>
    <script src="https://www.google.com/jsapi"></script>
</head>
<body>
<style>

    body {
        margin: 0;
        padding: 0;
    }

    .door-open {
        width: 650px;
        margin: 0 auto;
        border: 1px solid #eee;
        padding: 20px 20px;
    }

    .door-open h3 {
        text-align: center;
        padding-top: 30px;
        margin-bottom: 45px;
    }

    table {
        width: 100%;
        border: 1px solid #ddd;
    }

    table, th, td {
        border-collapse: collapse;
    }

    th, td {
        padding: 15px;
        text-align: center;
    }

    #t01 tr:nth-child(even) {
        background-color: #fff;
        height: 60px;
        color: #11044C;
        font-size: 16px;
        font-weight: 600;
    }

    #t01 tr:nth-child(odd) {
        background-color: #eee;
        height: 60px;
        color: #11044C;
        font-size: 16px;
        font-weight: 600;
        border-top: 1px solid #e0dcdc;
        border-bottom: 1px solid #e0dcdc;
    }

    #t01 th {
        background-color: #11044C;
        color: white;
        height: 30px;
    }

    .tab {
        display: flex;
        position: absolute;
        z-index: 100;
        left: 30%;
        transform: translateX(-30%);
        width: fit-content;
        top: 0;
    }

    .tab .one {
        background-color: #11044C;
        min-width: 260px;
        width: 260px;
        text-align: center;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        color: #fff;
        border-bottom-left-radius: 20px 20px;
        padding-top: 10px;
        height: 33px;
        cursor: pointer;
        font-size: 17px;
    }

    .tab .two {
        background-color: #fff;
        width: 260px;
        min-width: 260px;
        text-align: center;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        color: #29ABE2;
        border-bottom-right-radius: 20px 20px;
        padding-top: 10px;
        height: 33px;
        cursor: pointer;
        font-size: 17px;
    }

    .tab .one span {
        display: block;
    }

    .chartjs-render-monitor {
        width: 600px !important;
        height: 380px !important;
        margin: 0 auto;
    }

</style>
<div class="door-open">
    <h3>{{ __('app.Plates_Maintenance_records') }}</h3>
    <table id="t01">
        <tr>
            <th>{{ __('app.checkInDate') }}</th>
            <th>{{ __('app.checkOutDate') }}</th>
            <th>{{ __('app.Area') }}</th>
            <th>{{ __('app.Arabic_Plate') }}</th>
            <th>{{ __('app.English_Plate') }}</th>
{{--            <th>{{ __('app.screenshot') }}</th>--}}
            <th>{{ __('app.status') }}</th>
            <th>{{ __('app.Welcome_Message') }}</th>
        </tr>
        @foreach($list as $item)
            <tr>
                <td>{{$item['checkInDate']}}</td>
                <td>{{$item['checkOutDate']}}</td>
                <td>{{$item['BayCode']=='1' ? __('app.gym.Area').' 1':($item['BayCode']=='2' ?__('app.gym.Area').' 2':($item['BayCode']=='3' ?__('app.gym.Area').' 3':__('app.gym.Area').' 4'))}}</td>
                <td>
                    {{$item['plate_ar']}}
                </td>
                <td>
                    {{$item['plate_en']}}
                </td>
{{--                <td> @if($item['path_screenshot'])--}}
{{--                        <a href="{{$item['path_screenshot']}}"> <img src="{{$item['path_screenshot']}}" height="50" width="50" alt="">--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                </td>--}}
                <td>{{$item['plate_status']}}</td>
                <td>{{isset($item['welcome']) ? 'sent' : 'failed'}}</td>

            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
