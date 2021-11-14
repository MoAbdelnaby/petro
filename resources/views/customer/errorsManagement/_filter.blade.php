<div class="filter-dropdown">
    <a class="btn-filter btn btn-primary waves-effect waves-light px-4 py-2" data-toggle="dropdown" href="#">
        <i class="fas fa-sort-alt"></i> &nbsp;{{ __('app.Filter') }}
    </a>
    <div class="filter-content" aria-labelledby="dropdownMenuButton">
        <form action="{{route('report.filter',$type)}}" method="Get">
            @csrf
            <label>{{ __('app.type') }}:</label>
            <select name="filter_type" class="form-control filter-select">
                <option value="comparison" @if(request('filter_type') == 'comparison') selected @endif >{{ __('app.Comparison_Branch_data') }}</option>
                <option value="branch" @if(request('filter_type') == 'branch') selected @endif >{{ __('app.Branch_data') }}</option>
            </select>
            <div class="mt-4" id="filter_comparison" @if(request('filter_type') == 'branch') style="display: none" @else style="display: block" @endif >
                <lebel>{{ __('app.Select_branches') }}:</lebel>
                <select class="form-control" id="select_comparison" multiple name="branch_comparison[]">
                    @foreach($branches as $id => $name)
                        <option value="{{$id}}"
                                @if(in_array($id,request('branch_comparison')??[])) selected @endif>{{$name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4" id="filter_branch"  @if(request('filter_type') == 'branch') style="display: block" @else style="display: none" @endif>
                <lebel>{{ __('app.Select_branch') }}:</lebel>
                <select class="form-control" id="select_branch"  name="branch_data">
                    <option value="">{{ __('app.Select_branch') }}</option>
                    @foreach($branches as $id => $name)
                        <option value="{{$id}}" @if(request('branch_data') == $id) selected @endif>{{$name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group input-group input-daterange">
                <div class="d-flex align-items-end mt-4">
                    <div>
                        <label class="mb-0  p-0">{{__('app.gym.Start_Date')}}</label>
                        <input type="date" value="{{request('start_date')}}" name="start_date" class="form-control"
                               x-webkit-speech max="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                               oninput="javascript: if (this.value > this.max) this.value = this.max;">
                    </div>
                    <div class="input-group-addon">
                        <small>{{ __('app.TO') }}</small>
                        <i class="fas fa-long-arrow-alt-right"></i>
                    </div>
                    <div>
                        <label class="mb-0 ">{{__('app.gym.End_Date')}}</label>
                        <input type="date" value="{{request('end_date')}}" name="end_date" class="form-control"
                               x-webkit-speech max="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                               oninput="javascript: if (this.value > this.max) this.value = this.max;">
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-secondary waves-effect waves-light px-4 py-2">{{ __('app.Filter') }}</button>
            </div>
        </form>
    </div>
</div>
@push('js')

    <script>
        $(document).ready(function () {
            $('.btn-filter').on('click', function () {
                $(this).closest('.filter-dropdown').find('.filter-content').toggleClass('open');
            })
            $('.filter-select').change(function () {
                if ($(this).val() == 'comparison') {
                    $("#filter_branch").hide();
                    $("#filter_comparison").show();
                } else {
                    $("#filter_comparison").hide();
                    $("#filter_branch").show();
                }
            });

            $("#select_comparison, #select_branch").select2();

        });
        $(function () {
            $(window).scroll(function () {
                var aTop = $('.ad').height();
                if ($(this).scrollTop() >= 500) {

                }
            });
        });

    </script>
@endpush
