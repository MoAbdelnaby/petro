@extends('translation::layout')

@push('css')
    <style>
        .flex textarea{
            display: none;
        }
        .flex textarea.active{
            display: block
        }
        .createTrans .col-md-2 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
            display: inline-block;
        }
    </style>
@endpush
@section('body')

    <div class="content-page">
        <div class="container-fluid">
            <div class="row col-12 d-block">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> {{ __('translation::translation.add_translation') }}</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="panel">
                            <form action="{{ route('languages.translations.store', $language) }}" method="POST">

                                <fieldset>

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="panel-body row creatLanguage createTrans col-12 m-0 p-0">

                                        @include('translation::forms.text', ['field' => 'group', 'label' => __('translation::translation.group_label'), 'placeholder' => __('translation::translation.group_placeholder')])

                                        @include('translation::forms.text', ['field' => 'key', 'label' => __('translation::translation.key_label'), 'placeholder' => __('translation::translation.key_placeholder')])

                                        @include('translation::forms.text', ['field' => 'value', 'label' => __('translation::translation.value_label'), 'placeholder' => __('translation::translation.value_placeholder')])

                                        <div class="input-group col-md-3 showAdvancedOptions">

                                            <button v-on:click="toggleAdvancedOptions" class="text-blue">{{ __('translation::translation.advanced_options') }}</button>

                                        </div>

                                        <div class="col-md-12 row m-0 p-0 " v-show="showAdvancedOptions">

                                            @include('translation::forms.text', ['field' => 'namespace', 'label' => __('translation::translation.namespace_label'), 'placeholder' => __('translation::translation.namespace_placeholder')])
                                        </div>


                                    </div>

                                </fieldset>
                                <div class="border-bottom clearfix mb-2 mt-2"></div>
                                <div class="col-12">

                                    <button class="btn btn-primary">
                                        {{ __('translation::translation.save') }}
                                    </button>
                                    <button type="button" class="btn btn-danger back">{{__('app.back')}}</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
