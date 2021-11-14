<div class="modal fade assign-branch" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="branchForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.customers.packages.AssignBranch')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="create-error">

                    </div>
                    <div class="form-group">
                        <label>{{__('app.customers.packages.SelectBranch')}} *</label>
                        <input required type="text" name="name" class="form-control name" aria-describedby="emailHelp" placeholder="{{__('app.roles.table.name')}}">
                        <div class="invalid-feedback name-feedback"></div>
                    </div>

                    <hr>

                    <div class="kt-portlet__body">


                        <div class="tab-content">



                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-brand close-form" data-dismiss="modal">{{__('app.roles.close')}}</button>
                    <button type="submit" class="btn btn-primary" id="store_roles">{{__('app.roles.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
