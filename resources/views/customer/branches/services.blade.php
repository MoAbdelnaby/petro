@extends('layouts.dashboard.index')
@section('page_title')
    {{ __('app.customers.branches.page_title.index') }}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')

    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="text-center alert-cont">
            </div>

            <div class="row col-12 p-0 m-0 text-right d-block mb-2 clearfix">
                @if (auth()->user()->type == 'customer')
                    <a class="btn btn-primary float-right" href="{{ route('customerBranches.services.create', $id) }}">
                        <i class="fa fa-plus"></i> {{ __('app.service.create') }}
                    </a>
                @endif
            </div>

            <div class="clearfix col-12"></div>
            <div class="related-product-block position-relative table">

                <div id="PACKAGEITEMS"
                    class="product_list row p-0 m-0 col-12 {{ $userSettings ? ($userSettings->show_items == 'large' ? 'large' : '') : '' }}">

                    @foreach ($services as $item)

                        <div
                            class="product_item col-xs-12 col-sm-6 col-md-6 {{ $userSettings ? ($userSettings->show_items == 'large' ? 'col-lg-6' : 'col-lg-3') : '' }} item{{ $item->id }}">
                            <div class="iq-card">
                                <div class="product-miniature">
                                    <div class="thumbnail-container text-center pb-0">
                                        <img src="{{ $item->image ? url(Storage::disk('uploads')->url($item->image)) : (session()->has('darkMode') ? url('/images/models/dark/branch.svg') : url('/images/models/default/branch.svg')) }}"
                                            width="auto" height="100" alt="product-image" class="img-fluid">

                                    </div>
                                    <div class="product-description text-center">
                                        <h5>
                                            <small>{{ $item->name_ar }}</small>
                                        </h5>
                                        <h5>
                                            <small>
                                                <span>
                                                    <i class="fas fa-key"></i>
                                                </span>
                                                {{ $item->description_ar }}
                                            </small>
                                        </h5>
                                    </div>
                                </div>


                                <div class="ratting-item-div">
                                    <div class="clearfix border-bottom mt-1 mb-1"></div>
                                    <div class="ratting-item d-flex align-items-center justify-content-center p-0 m-0 pb-2">
                                        @if (auth()->user()->type == 'customer')
                                            <a class="btn btn-primary mx-1"
                                                href="{{ route('service.edit', [$item->id]) }}">{{ __('app.customers.branches.edit') }}</a>
                                            <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Delete"
                                                onclick="document.getElementById('delete-item-{{ $item->id }}').submit()">{{ __('app.customers.branches.delete') }}</a>
                                            <form action="{{ route('service.destroy', $item->id) }}"
                                                id="delete-item-{{ $item->id }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif


                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
@endsection
