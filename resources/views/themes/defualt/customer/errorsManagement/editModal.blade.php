<div class="modal fade" id="errorMangamentModal" tabindex="-1" role="dialog" aria-labelledby="errorMangamentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div id="messages" class="d-none" role="alert" data-dismiss="alert">
            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
            <div id="messages_content"></div>
        </div>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorMangamentModalLabel">{{ __('app.Edit_Information') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 col-lg-6">
                            <img src="" id="screenshot_modal" style="width: 100%;" alt="" data-toggle="modal"
                                 data-target="#errorMangamentModal">
                        </div>
                        <div class="col-6 col-lg-6">
                            <form id="ErrorForm" method="post">
                                @csrf
                                <input type="hidden" value="" name="item_id">
                                <div class="row">


                                    <div class="form-group col-md-6 digits px-2 " data-info="number_ar">
                                        <span class="info-patter">{{ __('app.numArExample') }}</span>

                                        <label for="en-plate" class="col-form-label">{{__('app.gym.plate_number_ar')}} <i class="fas float-right fa-info-circle"></i></label>
                                        <input type="text" class="form-control" name="number_ar" id="number_ar" value="">
                                        <div class="input-group mb-3 zindex-4">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 digits px-2 " data-info="plate_ar">
                                        <span class="info-patter"> {{ __('app.charArExample') }}</span>

                                        <label for="ar-plate" class="col-form-label">{{__('app.gym.plate_char_ar')}}  <i class="fas float-right fa-info-circle"></i></label>
                                        <input type="text" class="form-control" name="plate_ar" id="plate_ar" value="">

                                        <div class="input-group mb-3 zindex-4">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 digits px-2 " data-info="number_en">
                                        <span class="info-patter">{{ __('app.numEnExample') }}</span>

                                        <label for="en-plate" class="col-form-label">{{__('app.gym.plate_number_en')}} <i class="fas float-right fa-info-circle"></i></label>
                                        <input type="text" class="form-control"  name="number_en" id="number_en" value="">

                                        <div class="input-group mb-3 zindex-4">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                            <input class="digit" maxlength="1" minlength="1">
                                        </div>

                                    </div>
                                    <div class="form-group col-md-6 digits px-2 " data-info="plate_en">
                                        <span class="info-patter">{{ __('app.charEnExample') }}</span>

                                        <label for="ar-plate" class="col-form-label">{{__('app.gym.plate_char_en')}} <i class="fas float-right fa-info-circle"></i></label>
                                        <input type="text" class="form-control" name="plate_en" id="plate_en" value="">

                                        <div class="input-group mb-3 zindex-4">
                                            <input class="digit" maxlength="1" minlength="1" pattern = “[A-Za-z]”>
                                            <input class="digit" maxlength="1" minlength="1" pattern = “[A-Za-z]”>
                                            <input class="digit" maxlength="1" minlength="1" pattern = “[A-Za-z]”>
                                            <input class="digit" maxlength="1" minlength="1" pattern = “[A-Za-z]”>
                                            <input class="digit" maxlength="1" minlength="1" pattern = “[A-Za-z]”>
                                        </div>

                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('app.Close') }}</button>
                <button type="button" class="btn btn-primary update-plate-btn">{{ __('app.Update') }}</button>
            </div>
        </div>
    </div>
</div>
