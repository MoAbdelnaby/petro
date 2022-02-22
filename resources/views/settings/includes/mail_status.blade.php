<div class="tab-pane fade py-3   {{ $errors->has('branch_type') || count($errors) == 0 ? 'show active':'' }}" id="v-pills-branch">
    <div class="">
        <form id="branchMailsetting" method="post" novalidate
              action="{{route('setting.branchmail')}}"
              class="reminder-form">
            @csrf
            <div class="row p-0 m-0">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('app.selectType') }}</label>
                        <select name="branch_type" class="form-control"
                                id="picType">
                            <option value=""></option>
                            <option value="hours">Hours</option>
                            <option value="minute">Minute</option>
                        </select>
                        @if($errors->has('branch_type'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('branch_type')[0] }}</strong>
                            </small>
                        @endif
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 ">
                    <div class="form-group">
                        <div id="durationDiv">
                            <label style="display: none" for="">{{ __('app.duration') }}</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row p-0 m-0">
                <div class="col-12 mt-3">
                    <button type="submit"
                            class="btn btn-primary submitmail-btn waves-effect waves-light px-4 py-2"
                            style="width: 200px;">{{ __('app.Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
