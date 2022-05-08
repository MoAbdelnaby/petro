<div class="modal fade create-language" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="languagesForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.languages.create_new')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="create-error">

                    </div>
                    <div class="form-group">
                        <label>{{__('app.languages.table.name')}} *</label>
                        <input type="text" name="name" class="form-control name" aria-describedby="emailHelp" placeholder="{{__('app.languages.table.name')}}">
                        <div class="invalid-feedback name-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>{{__('app.languages.table.code')}} *</label>
                        <input type="text" name="code" class="form-control code" aria-describedby="emailHelp" placeholder="{{__('app.languages.table.code')}}">
                        <div class="invalid-feedback code-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>{{__('app.languages.table.flag')}} *</label>
                        <input type="text" name="flag" class="form-control flag" aria-describedby="emailHelp" placeholder="{{__('app.languages.table.flag')}}">
                        <div class="invalid-feedback flag-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label>{{__('app.languages.table.direction')}} *</label>
                        <select name="direction" class="form-control direction" aria-describedby="emailHelp">
                            <option value="">{{ __('app.select') }}</option>
                            <option value="ltr">{{ __('app.Left_To_Right_Direction') }}</option>
                            <option value="rtl">{{ __('app.Right_To_Left_Direction') }}</option>
                        </select>
                        <div class="invalid-feedback direction-feedback"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-brand close-form" data-dismiss="modal">{{__('app.languages.close')}}</button>
                    <button type="submit" class="btn btn-outline-brand" id="store_languages">{{__('app.languages.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
