<div class="modal fade create-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" >
            <form id="modelForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.models.assign')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="create-error">

                    </div>

                      <div class="form-group">
                        <label>{{__('app.models.searchForUser')}}</label>
                        <select name="name" id='user_search' class="form-control name">
                            <option value='0'>{{__('app.models.searchForUser')}}</option>
                            </select>
                        <div class="invalid-feedback d-block name-feedback"></div>
                       </div>

                       <div class="form-group">
                        <label>{{__('app.models.searchForBranch')}}</label>
                        <select name="branch" id='branch_search' class="form-control branch">
                            <option value='0'>{{__('app.models.searchForBranch')}}</option>
                            </select>
                        <div class="invalid-feedback d-block branch-feedback"></div>
                        </div>
                       <input type="hidden" name="userid" value="0" id="userid">
                       <input type="hidden" name="branchid" value="0" id="branchid">
                    <hr>

                    <div class="kt-portlet__body">


                        <div class="tab-content">

                            <div class=""></div>
                                    <div class="tab-pane active show" id="kt_tabs_update_" role="tabpanel">
                                        <div class="form-group row">
                                                    <label class="col-3 col-form-label">{{__('app.models.DoorModel')}}</label>
                                                    <div class="col-3">
                                                            <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                            <label>
                                                            <input type="checkbox" class="door" name="door" value="1" id="door">
                                                            <span></span>
                                                            </label>
                                                            </span>
                                                    </div>

                                                    </div>

                                                    <div class="form-group row">
                                                    <label class="col-3 col-form-label">{{__('app.models.RecieptionModel')}}</label>
                                                    <div class="col-3">
                                                            <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                            <label>
                                                            <input type="checkbox" class="recieption" name="recieption" value="1" id="recieption">
                                                            <span></span>
                                                            </label>
                                                            </span>
                                                    </div>

                                                    </div>
                                    </div>


                                    <!-- ///////////////////////// -->



                                    <!-- ////////////////////////////// -->

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-brand close-form" data-dismiss="modal">{{__('app.models.close')}}</button>
                    <button type="submit" class="btn btn-outline-brand" id="store_model">{{__('app.models.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
