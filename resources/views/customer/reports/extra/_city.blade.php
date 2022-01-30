<div class="row">
    <div class="col-md-12 mt-4">
        <label>{{ __('app.city_type') }}:</label>
        <select name="city_type" class="form-control nice-select" id="city_type">
            <option value="comparison" @if(request('city_type') == 'comparison') selected @endif >
                {{ __('app.comparison_city_data') }}
            </option>
            <option value="region" @if(request('city_type') == 'region') selected @endif >
                {{ __('app.region_by_city') }}
            </option>
        </select>
    </div>

    <div class="mt-4 col-md-12 " id="city_comparison"
         @if(request('city_type') == 'region') style="display: none" @else style="display: block" @endif >
        <lebel>{{ __('app.select_cities') }}:</lebel>
        <select class="form-control select_2" multiple name="city_comparison[]">
            @foreach($cities as $city)
                <option value="{{$city->id}}" @if(in_array($city->id,request('city_comparison')??[])) selected @endif>
                    {{$city->name}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mt-4" id="specific_city"
         @if(request('city_type') == 'region') style="display: block" @else style="display: none" @endif>
        <lebel>{{ __('app.select_city') }}:</lebel>
        <select class="form-control nice-select" name="city_data" id="region_city">
            <option value="">{{ __('app.select_city') }}</option>
            @foreach($cities as $city)
                <option value="{{$city->id}}">{{$city->name}}</option>
            @endforeach
        </select>
    </div>

        <div id="region_section" class="col-md-12">

    </div>
</div>

@push('js')
    <script>
        $(function () {
            $('#city_type').change(function () {
                let city_type = $(this).val();
                if (city_type === 'comparison') {
                    $("#specific_city").hide();
                    $("#city_comparison").show();
                    $("#region_section").html('');
                } else if (city_type === 'region') {
                    $('#specific_city option[value=""]').prop("selected", true).trigger("change");
                    $("#specific_city").show();
                    $("#city_comparison").hide();
                    $("#region_section").html('');
                } else {
                    $("#specific_city").hide();
                    $("#city_comparison").hide();
                    $("#region_section").html('');
                    $('#specific_city option[value=""]').prop("selected", true).trigger("change");
                }
            });

            $("#region_city").on('change', function (e) {
                let city = $(this).val();
                if(city === ''){
                    $("#region_section").html('');
                    return;
                }
                $.get(`${app_url}/customer/report/city/${city}/show-regions`, function (data) {
                    $("#region_section").html(data);
                    $(".select_2").select2({});
                });
            });
        });
    </script>
@endpush
