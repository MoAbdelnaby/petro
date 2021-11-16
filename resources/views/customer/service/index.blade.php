@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.customers.branches.page_title.index') }}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection




@section('content')
    <div id="content-page" class="content-page">
        <a href="{{ route('service.create') }}" class="pull-right m-5 btn btn-primary">
            {{ __('app.service.create') }}
        </a>
        <div class="container-fluid">
            <div class="related-product-block position-relative table">
                <div class="product_table table-responsive row p-0 m-0 col-12">
                    <table class="table dataTable ui celled table-bordered text-center no-footer" id="DataTables_Table_0"
                        role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr role="row">
                                <th>{{ __('app.service.arabic_name') }}</th>
                                <th>{{ __('app.service.english_name') }}</th>
                                <th>{{ __('app.service.arabic_description') }}</th>
                                <th>{{ __('app.service.english_description') }}</th>
                                <th>{{ __('app.service.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $item)
                                <tr class="item{{ $item->id }}">
                                    <td>{{ $item->name_ar }}</td>
                                    <td>{{ $item->name_en }}</td>
                                    <td>{{ $item->description_ar }}</td>
                                    <td>{{ $item->description_en }}</td>
                                    <td>
                                        <a href="{{ route('service.edit', $item->id) }}"
                                            class="btn btn-primary m-1">Edit</a>
                                        <form onsubmit="return confirm('Are you sure ?')" class="m-1"
                                            action="{{ route('service.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger ">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- @foreach ($logs as $log) --}}
                            {{-- <tr class="item{{ $log->id }}"> --}}
                            {{-- <td>{{ $log->branch->name }}</td>
                                    <td>{{ $log->internet_speed }} {{ __('app.customers.speed.unit') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('branch.connection-speeds', $log->branch->id) }}">{{ __('app.customers.speed.show.action') }}</a>
                                    </td> --}}
                            {{-- </tr> --}}
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
