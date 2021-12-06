<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$list['title']}}</title>
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }

        .styled-table th
        {
            padding: 12px 15px
        ;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .styled-table tbody tr.active-row {
            font-weight:    bold;
            color: #009879;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #17a2b8;
            border: 1px solid #17a2b8;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
        }
    </style>
</head>

<body>
<div class="container mt-2">
    <h2 style='text-align: center; padding-bottom: 5px; text-decoration: underline'>{{$list['title']}}</h2>
    <h3 style='text-align: center; padding-bottom: 5px;'>
        Start : {{$list['start']}} <span style='margin-left: 15px'>End : {{$list['end']}}</span>
    </h3>

    <table class="styled-table">
        <thead>
        <tr>
            <th class="th-sm">#</th>
            <th class="th-sm">{{__('app.type')}}</th>
            <th class="th-sm">{{__('app.branch')}}</th>
            <th class="th-sm">{{__('app.gym.plate_no')}}</th>
            <th class="th-sm">{{__('app.auth.phone')}}</th>
            <th class="th-sm">{{__('app.Invoice')}}</th>
            <th class="th-sm">{{__('app.createdIn')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list['data'] as $index=>$item)
            <tr>
                <th scope="row">{{++$index}}</th>
                <th scope="row">{{$item->type}}</th>
                <th scope="row">{{$item->branch_name}}</th>
                <th scope="row">{{$item->plateNumber}}</th>
                <th scope="row">{{$item->phone}}</th>
                <th scope="row">
                    @if($item->invoiceUrl && Storage::disk('public')->exists($item->invoiceUrl))
                        <a href="{{Storage::disk('public')->url($item->invoiceUrl)}}" class="btn">
                            View
                        </a>
                    @else
                        ---
                    @endif
                </th>
                <th scope="row" style='min-width: 70px'>{{$item->created_at}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
