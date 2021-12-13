<table>
    <thead>
    <tr>
        <th>#</th>
        <th>{{__('app.type')}}</th>
        <th>{{__('app.branch')}}</th>
        <th>{{__('app.message')}}</th>
        <th>{{__('app.gym.plate_no')}}</th>
        <th>{{__('app.auth.phone')}}</th>
        <th>{{__('app.Invoice')}}</th>
        <th>{{__('app.createdIn')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $index=>$item)
        <tr>
            <td>{{++$index}}</td>
            <td>{{$item->type}}</td>
            <td>{{$item->branch_name}}</td>
            <td>{{$item->message}}</td>
            <td>{{$item->plateNumber}}</td>
            <td>{{str_replace('whatsapp:+','',$item->phone)}}</td>
            <td>{{ $item->invoiceUrl ? config('app.azure_storage').config('app.azure_container').$item->invoiceUrl : '---'}}</td>
            <td>{{$item->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
