@extends('layouts.dashboard.index')

@section('page_title') {{__('app.escalation')}} @endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            
            <div class="treeItems">
                

                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.escalation')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body p-2">

                            <div class="row pb-5 px-2">
                                <div class="endRowTree left">
                                    {{-- <div class="endrowItem"></div> --}}
                                </div>
            
                                <div class="row col p-0 mx-auto">
                                  
                                </div>
            
                                <div class="endRowTree right">
                                    {{-- <div class="endrowItem"></div> --}}
                                </div>
            
                            </div>

                            <div class="col-12 text-center">
                                <span id="SaveChanges">Save</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(".deleteEscalation").on('click', function (e) {
            e.preventDefault();
            let url = $(this).data("url");
            let token = '{{csrf_token()}}';

            let inputs = `<input name="_token" value=${token}>`;
            inputs += `<input type="hidden" name="_method" value="DELETE">`;

            $(`<form method="post" action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
        });
    </script>
@endpush
