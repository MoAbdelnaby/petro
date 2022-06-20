<div class="mt-4 {{ (request('region_type') == 'branch') ? '' : 'show'}}"
     @if(request('region_type') == 'branch') style="display: none" @else style="display: block" @endif >
    <lebel>{{ __('app.select_regions') }}:</lebel>
    <select class="form-control select_2 required" multiple name="city_region_comparison[]">
        @foreach($regions as $region)
            <option value="{{$region->id}}" @if(in_array($region->id,request('city_region_comparison')??[])) selected @endif>
                {{$region->name}}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback d-block">
        Please select region.
    </div>
</div>
