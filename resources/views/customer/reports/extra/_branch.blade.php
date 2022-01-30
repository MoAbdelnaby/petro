<div class="row">
    <div class="col-md-12 mt-4">
        <label>{{ __('app.branch_type') }}:</label>
        <select name="branch_type" class="form-control nice-select" id="branch_type">
            <option value="comparison" @if(request('branch_type') == 'comparison') selected @endif >
                {{ __('app.Comparison_Branch_data') }}
            </option>
{{--            <option value="area" @if(request('branch_type') == 'area') selected @endif >--}}
{{--                {{ __('app.compare_branch_area') }}--}}
{{--            </option>--}}
            <option value="branch" @if(request('branch_type') == 'branch') selected @endif >
                {{ __('app.specific_branch_data') }}
            </option>
        </select>
    </div>

    <div class="mt-4 col-md-12 " id="branch_comparison"
         @if(in_array(request('branch_type') ,['branch','area'])) style="display: none"
         @else style="display: block" @endif >
        <lebel>{{ __('app.Select_branches') }}:</lebel>
        <select class="form-control select_2" multiple name="branch_comparison[]">
            @foreach($branches as $branch)
                <option value="{{$branch->id}}"
                        @if(in_array($branch->id,request('branch_comparison')??[])) selected @endif>{{$branch->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mt-4" id="specific_branch"
         @if(request('branch_type') == 'branch') style="display: block" @else style="display: none" @endif>
        <lebel>{{ __('app.Select_branch') }}:</lebel>
        <select class="form-control nice-select" name="branch_data">
            <option value="">{{ __('app.Select_Branch') }}</option>
            @foreach($branches as $branch)
                <option value="{{$branch->id}}" @if(request('branch_data') == $branch->id) selected @endif>{{$branch->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mt-4" id="branch_area"
         @if(request('branch_type') == 'area') style="display: block" @else style="display: none" @endif>
        <lebel>{{ __('app.select_branch_area') }}:</lebel>
        <select class="form-control select_2" multiple name="branch_areas[]">
            <option value="">{{ __('app.select_branch_area') }}</option>
            @foreach($branches as $branch)
                @foreach($branch->areas as $area)
                    <option value="{{$branch->id.'_'.$area->area}}">
                        {{$branch->name}}::@lang('app.Area') {{$area->area}}
                    </option>
                @endforeach
            @endforeach
        </select>
    </div>
</div>

@push('js')
    <script>
        $(function () {
            $('#branch_type').change(function () {
                let branch_type = $(this).val();
                if (branch_type === 'comparison') {
                    $("#specific_branch").hide();
                    $("#branch_area").hide();
                    $("#branch_comparison").show();
                } else if (branch_type === 'branch') {
                    $("#specific_branch").show();
                    $("#branch_area").hide();
                    $("#branch_comparison").hide();
                } else if (branch_type === 'area') {
                    $("#specific_branch").hide();
                    $("#branch_area").show();
                    $("#branch_comparison").hide();
                } else {
                    $("#specific_branch").hide();
                    $("#branch_area").hide();
                    $("#branch_comparison").hide();
                }
            });
        });
    </script>
@endpush
