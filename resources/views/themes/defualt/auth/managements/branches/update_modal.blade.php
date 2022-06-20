<div class="modal fade update-language" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="updateLanguagesForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.branches.update_item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="create-error">

                    </div>
                    <div class="form-group">
                        <label>{{__('app.branches.table.name')}} *</label>
                        <input type="text" name="name" class="form-control name" aria-describedby="" placeholder="{{__('app.branches.table.name')}}">
                        <input type="text" name="id" class="form-control id" aria-describedby="" hidden >
                        <div class="invalid-feedback d-block name-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>{{__('app.branches.table.description')}}</label>
                        <input type="text" name="description" class="form-control description" aria-describedby="" placeholder="{{__('app.branches.table.description')}}">
                        <div class="invalid-feedback d-block description-feedback"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-brand close-form" data-dismiss="modal">{{__('app.branches.close')}}</button>
                    <button type="submit" class="btn btn-outline-brand" id="update_language">{{__('app.branches.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
