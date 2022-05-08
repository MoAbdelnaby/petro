@extends('translation::layout')

@section('body')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row col-12 d-block">
                <div class="col-12 text-right mb-2 p-0">
                    <a href="{{ route('languages.translations.create', $language) }}" class="btn btn-primary">
                        {{ __('translation::translation.add') }}
                    </a>
                </div>
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">{{ __('translation::translation.translations') }}</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form action="{{ route('languages.translations.index', ['language' => $language]) }}" method="get">

                            <div class="panel">

                                <div class="panel-header">
                                    <div class="flex flex-grow justify-end items-center filter col-12 row p-0 m-0 mb-3">
                                        <cdiv class="col-md-6">
                                            @include('translation::forms.search', ['name' => 'filter', 'value' => Request::get('filter')])
                                        </cdiv>
                                        <div class="col-md-2">
                                            @include('translation::forms.select', ['name' => 'language', 'items' => $languages, 'submit' => true, 'selected' => $language])
                                        </div>
                                        <div class="sm:hidden lg:flex items-center col-md-4">
                                            @include('translation::forms.select', ['name' => 'group', 'items' => $groups, 'submit' => true, 'selected' => Request::get('group'), 'optional' => true])
                                        </div>

                                    </div>

                                </div>

                                <div class="panel-body" style="max-height: 450px;overflow: auto">

                                    @if(count($translations))
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="w-1/5 uppercase font-thin">{{ __('translation::translation.group_single') }}</th>
                                                <th class="w-1/5 uppercase font-thin">{{ __('translation::translation.key') }}</th>
                                                <th class="uppercase font-thin">{{ config('app.locale') }}</th>
                                                <th class="uppercase font-thin">{{ $language }}</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($translations as $type => $items)

                                                @foreach($items as $group => $translations)

                                                    @foreach($translations as $key => $value)

                                                        @if(!is_array($value[config('app.locale')]))
                                                            <tr>
                                                                <td>{{ $group }}</td>
                                                                <td>{{ $key }}</td>
                                                                <td>{{ $value[config('app.locale')] }}</td>
                                                                <td>

                                                                    <translation-input
                                                                        initial-translation="{{ $value[$language] }}"
                                                                        language="{{ $language }}"
                                                                        group="{{ $group }}"
                                                                        translation-key="{{ $key }}"
                                                                        route="{{ config('translation.ui_url') }}">
                                                                    </translation-input>
                                                                    <span>{{ $value[$language] }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                    @endforeach

                                                @endforeach

                                            @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                    @endif

                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
