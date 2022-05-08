<div class="tab-pane fade  py-3" id="v-pills-reminder"
     role="tabpanel"
     aria-labelledby="v-pills-reminder-tab">
    <form id="reminderForm" method="post" novalidate
          action="{{route('setting.reminder_post')}}"
          class="reminder-form">
    @csrf
    <!-- @include('settings.reminder-tab) -->
        <div class="">
            <div class="row m-0 p-0">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="days">{{ __('app.Days') }}</label>
                        <input type="number" class="form-control"
                               id="days"
                               min="1" max="365" name="day"
                               value="{{$reminder ? $reminder->day : ''}}"
                               aria-describedby="number of days"
                               placeholder="(1  - 365)">
                        <div class="invalid-feedback day">
                            {{ __('app.enter_a_valid_number_of_days') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12  mt-3">
            <button type="submit"
                    class="btn btn-primary submit-btn waves-effect waves-light px-4 py-2"
                    style="width: 200px;">{{ __('app.Save') }}
            </button>
        </div>
    </form>
</div>
