<table>
    <thead>
    <tr>
        <th>{{ __('app.checkInDate') }}</th>
        <th>{{ __('app.checkOutDate') }}</th>
        <th>{{ __('app.Area') }}</th>
        <th>{{ __('app.Arabic_Plate') }}</th>
        <th>{{ __('app.English_Plate') }}</th>
    </tr>
    </thead>
    @foreach($list as $item)
        <tr>
            <td>{{$item['checkInDate']}}</td>
            <td>{{$item['checkOutDate']}}</td>
            <td>{{$item['BayCode']=='1' ? __('app.gym.Area').' 1':($item['BayCode']=='2' ?__('app.gym.Area').' 2':($item['BayCode']=='3' ?__('app.gym.Area').' 3':__('app.gym.Area').' 4'))}}</td>
            <td>{{$item['plate_ar']}}</td>
            <td>{{$item['plate_en']}}</td>
        </tr>
    @endforeach
</table>
