<div class="tab-pane fade py-3 {{ $errors->has('value') ? 'show active':'' }}" id="v-pills-branchOnlineMailtemplate">
    <div class="">
        <!-- Create the editor container -->
        <div class="infoForm pl-2 mb-3">
            <p class="mb-0 text-primary"> <i class="fas fa-info-circle mr-1"></i>{{ __('app.Manger_Name_to') }}</p>
            <p class="mb-0 text-primary"> <i class="fas fa-info-circle mr-1"></i>{{ __('app.Branch_Name_branch') }}</p>
            <p class="mb-0 text-primary"> <i class="fas fa-info-circle mr-1"></i>{{ __('app.Branch_Code_code') }}</p>

            @error('value')
                <small class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
        <div id="online-editor"></div>


    </div>
    <form id="branchOnlineMailTemplate" method="post" novalidate action="{{route('setting.mailTemplate')}}" class="reminder-form">
        @csrf
        <input type="hidden"  name="key" value="branchOnline">
        <input type="hidden" id="htmlEle" name="value">
        <div class="row p-0 m-0">
            <div class="col-12 mt-3">
                <input  class="btn branch-online-template-btn btn-primary waves-effect waves-light px-4 py-2 " style="width: 200px;"  value="{{ __('app.Save') }}" >
            </div>
        </div>
    </form>


</div>
