<table>
    <thead>
    <tr>
        <th>{{ __('app.Date') }}</th>
        <th>{{ __('app.Timing') }}</th>
        <th>{{ __('app.Area') }}</th>
        <th>{{ __('app.Status') }}</th>
        <th>{{ __('app.Camera_Id') }}</th>
    </tr>
    </thead>
    @foreach($list as $item)
        <tr>
            <td>{{ $item['date'] }}</td>
            <td>{{ $item['time'] }}</td>
            <td>{{$item['area']==1 ? 'Area 1':($item['area']==2 ?'Area 2':($item['area']==3 ?'Area 3':'Area 4'))}}</td>
            <td>{{$item['status']==0 ? 'Available':'Busy'}}</td>
            <td>{{ $item['camera_id'] }}</td>
        </tr>
    @endforeach
</table>
