<div class="tab-pane fade py-3 {{ $errors->has('env.*') ? 'show active':'' }}" id="v-pills-mail">
    <div class="">

        <form id="Mailsettings" method="post" novalidate
              action="{{route('setting.mailsettings')}}"
              class="reminder-form">
            @csrf
            <div class="row p-0 m-0">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="text">{{ __('MAIL DRIVER') }}</label>
                        <input type="text"
                               name="env[MAIL_MAILER]"
                               class="form-control"
                               placeholder="smtp"
                               value="{{$mail ? $mail['driver'] : ''}}">


                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_DRIVER'][0] }}</strong>
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="text">{{ __('MAIL HOST') }}</label>
                        <input type="text"
                               name="env[MAIL_HOST]"
                               class="form-control"
                               placeholder="smtp.googlemail.com"
                               value="{{$mail ? $mail['host'] : ''}}"
                        >
                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_HOST'][0] }}</strong>
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="text">{{ __('MAIL PORT') }}</label>
                        <input type="text"
                               name="env[MAIL_PORT]"
                               class="form-control"
                               placeholder="465"
                               value="{{$mail ? $mail['port'] : ''}}">
                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_PORT'][0] }}</strong>
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="form-group">
                        <label for="text">{{ __('MAIL USERNAME') }}</label>
                        <input type="text"
                               name="env[MAIL_USERNAME]"
                               class="form-control"
                               placeholder="username"
                               value="{{$mail ? $mail['username'] : ''}}">

                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_USERNAME'][0] }}</strong>
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="form-group">
                        <label for="text">{{ __('MAIL PASSWORD') }}</label>
                        <input type="text"
                               name="env[MAIL_PASSWORD]"
                               class="form-control"
                               placeholder="password"
                               value="{{$mail ? $mail['password'] : ''}}">
                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_PASSWORD'][0] }}</strong>
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="form-group">
                        <label for="text">{{ __('MAIL ENCRYPTION') }}</label>
                        <select name="env[MAIL_ENCRYPTION]" class="form-control">
                            <option value=""></option>
                            <option value="tls" {{$mail && $mail['encryption'] == 'tls' ? 'selected' : ''}}>tls</option>
                            <option value="ssl" {{$mail && $mail['encryption'] == 'ssl' ? 'selected' : ''}}>ssl</option>
                        </select>
                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_ENCRYPTION'][0] }}</strong>
                            </small>
                        @endif
                    </div>
                </div>



            </div>
            <div class="row p-0 m-0">
                <div class="col-12 mt-3">
                    <button type="submit"
                            class="btn btn-primary submitmailsettings-btn waves-effect waves-light px-4 py-2"
                            style="width: 200px;">{{ __('app.Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
