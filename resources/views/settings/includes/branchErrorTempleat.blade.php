<div class="tab-pane fade py-3 {{ $errors->has('env.*') ? 'show active':'' }}" id="v-pills-branchErrorMailtemplate">
    <div class="">
        <!-- Create the editor container -->
        <div class="infoForm pl-2 mb-3">
            <p class="mb-0 text-primary"> <i class="fas fa-info-circle mr-1"></i>{{ __('app.Manger_Name_to') }}</p>
            <p class="mb-0 text-primary"> <i class="fas fa-info-circle mr-1"></i>{{ __('app.Branch_Name_branch') }}</p>
            <p class="mb-0 text-primary"> <i class="fas fa-info-circle mr-1"></i>{{ __('app.Branch_Code_code') }}</p>
            <p class="mb-0 text-primary"> <i class="fas fa-info-circle mr-1"></i>{{ __('app.Branch_Down_Time_downtime') }}</p>
            @if($errors->has('env.*'))
                <small class="text-danger" role="alert">
                    <strong>{{ $errors->get('env.*')['env.brancherror'][0] }}</strong>
                </small>
            @endif
        </div>
        <div id="editor"></div>


    </div>
    <form id="branchMailsetting" method="post" novalidate action="{{route('setting.mailTemplate')}}" class="reminder-form">
        @csrf
        <input type="hidden"  name="key" value="branchError">
        <input type="hidden" id="htmlEle" name="value">
        <input type="submit" id="Submit" value="Save" >
    </form>
    <div class="row p-0 m-0">
        <div class="col-12 mt-3">
            <button type="" id="saveEditor"
                    class="btn btn-primary waves-effect waves-light px-4 py-2"
                    style="width: 200px;">{{ __('app.Save') }}
            </button>
        </div>
    </div>

</div>
