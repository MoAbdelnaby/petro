<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Station Code</th>
        <th>Latest PlateNumber</th>
        <th>Bay Code</th>
        <th>Customer Name</th>
        <th>Customer Phone</th>
        <th>Make</th>
        <th>Model</th>
        <th>Reason1</th>
        <th>Reason2</th>
        <th>Reason3</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $index=>$item)
        <tr>
            <td>{{++$index}}</td>
            <td>{{$item->station_code}}</td>
            <td>{{$item->LatestPlateNumber}}</td>
            <td>{{$item->BayCode}}</td>
            <td>{{$item->CustomerName}}</td>
            <td>{{$item->CustomerPhone}}</td>
            <td>{{$item->make}}</td>
            <td>{{$item->model}}</td>
            <td>{{$item->reason1}}</td>
            <td>{{$item->reason2}}</td>
            <td>{{$item->reason3}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
