<div class="filter-dropdown filter-section">
    <a class="btn btn-info waves-effect waves-light px-2 py-2 btn-sm" href="{{ route('reports.show', $type) }}">
        <i class="fas fa-bookmark"></i> &nbsp;{{ __('app.Default_report') }}
    </a>
    <a class="btn btn-info waves-effect waves-light px-2 py-2 btn-sm btn_download">
        <i class="fas fa-download"></i> &nbsp;{{ __('app.Download') }}
    </a>
    <a class="btn-filter btn btn-primary waves-effect waves-light px-2 py-2" data-toggle="dropdown" href="#">
        <i class="fas fa-sort-alt"></i> &nbsp;{{ __('app.Filter') }}
    </a>

    <div class="filter-content" aria-labelledby="dropdownMenuButton">
        <form action="{{route('reports.show',$type)}}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <label>{{ __('app.show_by') }}:</label>
                    <select name="show_by" id="show_by" class="form-control nice-select">
                        <option value="">{{ __('app.select_type') }}</option>
                        <option value="city" @if(request('show_by') == 'city') selected @endif >
                            {{ __('app.city') }}
                        </option>
                        <option value="region" @if(request('show_by') == 'region') selected @endif>
                            {{ __('app.region') }}
                        </option>
                        <option value="branch" @if(request('show_by') == 'branch') selected @endif >
                            {{ __('app.branch') }}
                        </option>
                    </select>
                </div>

                <div id="city_container" class="col-md-12"  @if(request('show_by') == 'city') style="display: block" @else style="display: none" @endif >
                    @include('customer.reports.extra._city')
                </div>

                <div id="region_container" class="col-md-12"  @if(request('show_by') == 'region') style="display: block" @else style="display: none" @endif >
                    @include('customer.reports.extra._region')
                </div>

                <div id="branch_container" class="col-md-12"  @if(request('show_by') == 'branch') style="display: block" @else style="display: none" @endif >
                    @include('customer.reports.extra._branch')
                </div>
            </div>


            <div class="form-group input-group input-daterange">
                <div class="d-flex align-items-end mt-4 row">
                    <div class="col-md-12">
                        <label class="mb-0  p-0">{{__('app.gym.Start_Date')}}</label>
                        <input type="datetime-local" value="{{request('start')}}" name="start"
                               class="form-control" max="{{\Carbon\Carbon::now()->addDay()->format('Y-m-d')}}"
                               oninput="if (this.value >= this.max) this.value = this.max;"
                        />
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="mb-0 ">{{__('app.gym.End_Date')}}</label>
                        <input type="datetime-local" value="{{request('end')}}" name="end"
                               class="form-control" max="{{\Carbon\Carbon::now()->addDay()->format('Y-m-d')}}"
                               oninput="if (this.value >= this.max) this.value = this.max;"
                        />
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-secondary waves-effect waves-light px-4 py-2">
                    {{ __('app.Filter') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            let type = "{{$type}}";

            $('.btn-filter').on('click', function () {
                $(this).closest('.filter-dropdown').find('.filter-content').toggleClass('open');
            })

            $("#show_by").on('change', function (e) {
                let show_by = $(this).val();

                if (show_by === 'city') {
                    $("#region_container").hide();
                    $("#branch_container").hide();
                    $("#city_container").show();
                } else if (show_by === 'region') {
                    $("#region_container").show();
                    $("#branch_container").hide();
                    $("#city_container").hide();
                } else if (show_by === 'branch') {
                    $("#region_container").hide();
                    $("#branch_container").show();
                    $("#city_container").hide();
                } else {
                    $("#region_container").hide();
                    $("#branch_container").hide();
                    $("#city_container").hide();
                }
            });

            $(".btn_download").on('click', function (e) {
                e.preventDefault();

                let currentForm = @json(request()->query());
                let url = `${app_url}/customer/reports/${type}/download`;
                let token = $('meta[name="csrf-token"]').attr("content");
                let inputs = `<input name="_token" value="${token}">`;

                for (var key of Object.keys(currentForm)) {
                    inputs += `<input name=${key} value=${currentForm[key] ?? ''} >`;
                }

                $(`<form action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
            });
        });
    </script>
@endpush
