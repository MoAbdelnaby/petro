<div class="mt-4 {{(in_array(request('branch_type') ,['branch','area'])) ? "" : "show"}}"
     @if(in_array(request('branch_type') ,['branch','area'])) style="display: none"
     @else style="display: block" @endif >
    <lebel>{{ __('app.Select_branches') }}:</lebel>
    <select class="form-control select_2 required" multiple name="region_branch_comparison[]">
        @foreach($branches as $branch)
            <option value="{{$branch->id}}"
                    @if(in_array($branch->id,request('region_branch_comparison')??[])) selected @endif>{{$branch->name}}</option>
        @endforeach
    </select>
</div>
