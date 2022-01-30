<div class="row">
    <div class="col-md-12 mt-4">
        <label>{{ __('app.region_type') }}:</label>
        <select name="region_type" class="form-control nice-select" id="region_type">
            <option value="comparison" @if(request('region_type') == 'comparison') selected @endif >
                {{ __('app.comparison_region_data') }}
            </option>
            <option value="branch" @if(request('region_type') == 'branch') selected @endif >
                {{ __('app.branch_by_region') }}
            </option>
        </select>
    </div>

    <div class="mt-4 col-md-12 " id="region_comparison"
         @if(request('region_type') == 'branch') style="display: none" @else style="display: block" @endif >
        <lebel>{{ __('app.select_regions') }}:</lebel>
        <select class="form-control select_2" multiple name="region_comparison[]">
            @foreach($regions as $region)
                <option value="{{$region->id}}"
                        @if(in_array($region->id,request('region_comparison')??[])) selected @endif>{{$region->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mt-4" id="specific_region"
         @if(request('region_type') == 'branch') style="display: block" @else style="display: none" @endif>
        <lebel>{{ __('app.select_region') }}:</lebel>
        <select class="form-control nice-select" name="region_data" id="branch_region">
            <option value="">{{ __('app.select_region') }}</option>
            @foreach($regions as $region)
                <option value="{{$region->id}}">{{$region->name}}</option>
            @endforeach
        </select>
    </div>

    <div id="branch_section" class="col-md-12">

    </div>
</div>

@push('js')
    <script>
        $(function () {
            $('#region_type').change(function () {
                let region_type = $(this).val();
                if (region_type === 'comparison') {
                    $("#specific_region").hide();
                    $("#region_comparison").show();
                    $("#branch_section").html('');
                } else if (region_type === 'branch') {
                    $('#specific_region option[value=""]').prop("selected", true).trigger("change");
                    $("#specific_region").show();
                    $("#region_comparison").hide();
                    $("#branch_section").html('');
                } else {
                    $("#specific_region").hide();
                    $("#region_comparison").hide();
                    $("#branch_section").html('');
                    $('#specific_region option[value=""]').prop("selected", true).trigger("change");
                }
            });

            $("#branch_region").on('change', function (e) {
                let region = $(this).val();
                if(region === ''){
                    $("#branch_section").html('');
                    return;
                }
                $.get(`${app_url}/customer/report/region/${region}/show-branches`, function (data) {
                    $("#branch_section").html(data);
                    $(".select_2").select2({});
                });
            });
        });
    </script>
@endpush
