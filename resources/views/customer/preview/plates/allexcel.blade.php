<table>
    <thead>
    <tr>
        <th>{{ __('Branch Id') }}</th>
        <th>{{ __('Branch Name') }}</th>
        <th>{{ __('Branch Code') }}</th>
        <th>{{ __('app.checkInDate') }}</th>
        <th>{{ __('app.checkOutDate') }}</th>
        <th>{{ __('app.Area') }}</th>
        <th>{{ __('app.Arabic_Plate') }}</th>
        <th>{{ __('app.English_Plate') }}</th>
        <th>{{ __('Invoice') }}</th>
        <th>{{ __('Duration') }}</th>
    </tr>
    </thead>
    @foreach($list as $item)
        @if(is_array($item))
        <tr>
            <td>{{$item['branch_id']}}</td>
            <td>{{$item['branch_code']}}</td>
            <td>{{$item['branch_name']}}</td>
            <td>{{$item['checkInDate']}}</td>
            <td>{{$item['checkOutDate']}}</td>
            <td>{{$item['BayCode']=='1' ? __('app.gym.Area').' 1':($item['BayCode']=='2' ?__('app.gym.Area').' 2':($item['BayCode']=='3' ?__('app.gym.Area').' 3':__('app.gym.Area').' 4'))}}</td>
            <td>{{$item['plate_ar']}}</td>
            <td>{{$item['plate_en']}}</td>
            <td>{{isset($item['invoice']) ? 'true' : 'false'}}</td>
            <td>{{ str_replace('before','',\Carbon\Carbon::parse($item['checkInDate'])->diffForHumans($item['checkOutDate'])) }}</td>
        </tr>
        @endif
    @endforeach
</table>
