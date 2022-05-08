@extends('translation::layout')

@section('body')

    <div class="content-page">
        <div class="container-fluid">
            <div class="row col-12 d-block">
{{--                <div class="col-12 text-right">--}}

{{--                    <a href="{{ route('languages.create') }}" class="btn btn-primary mt-2 mb-2">--}}
{{--                        {{ __('translation::translation.add') }}--}}
{{--                    </a>--}}

{{--                </div>--}}
                <div class="iq-card settings-custom-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> {{ __('translation::translation.languages') }}</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        @if(count($languages))

                            <div class="panel">
                                <div class="panel-body">

                                    <table class="table dataTable table-striped table-bordered mt-4">

                                        <thead>
                                        <tr>
                                            <th>{{ __('translation::translation.language_name') }}</th>
                                            <th>{{ __('translation::translation.locale') }}</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($languages as $language => $name)
                                            <tr>
                                                <td>
                                                    {{ $name }}
                                                </td>
                                                <td>
                                                    <a class="d-block" href="{{ route('languages.translations.index', $language) }}">
                                                        {{ $language }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>

                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
