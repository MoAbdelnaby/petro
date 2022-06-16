@push('css')
    <style>
        .related-heading span i {
            border: none !important;
        }
    </style>
    @endpush
<div class="tab-pane fade py-3 {{ $errors->has('env.*') || count($errors) == 0 ? 'show active':'' }}" id="v-pills-mail">
    <div class="">

        <form id="Mailsettings" method="post" novalidate
              action="{{route('setting.mailsettings')}}"
              class="reminder-form">
            @csrf
            <div class="row p-0 m-0">
                <div class="col-lg-4 col-md-6">
                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="text">{{ __('MAIL DRIVER') }}</label>--}}
                    {{--                        <input type="text"--}}
                    {{--                               name="env[MAIL_MAILER]"--}}
                    {{--                               class="form-control"--}}
                    {{--                               placeholder="smtp"--}}
                    {{--                               value="{{$mail ? $mail['driver'] : ''}}">--}}


                    {{--                        @if($errors->has('env.*'))--}}
                    {{--                            <small class="text-danger" role="alert">--}}
                    {{--                                <strong>{{ $errors->get('env.*')['env.MAIL_MAILER'][0] ?? '' }}</strong>--}}
                    {{--                            </small>--}}
                    {{--                        @endif--}}
                    {{--                    </div>--}}

                    <div class="form-group">
                        <label>{{ __('MAIL DRIVER') }}</label>
                        <select name="env[MAIL_MAILER]" class="form-control">
                            <option value="smtp" {{$mail && $mail['driver'] == 'smtp' ? 'selected' : ''}}>smtp</option>
                            <option value="mail" {{$mail && $mail['driver'] == 'mail' ? 'selected' : ''}}>mail</option>
                            <option value="sendmail" {{$mail && $mail['driver'] == 'sendmail' ? 'selected' : ''}}>
                                sendmail
                            </option>
                        </select>
                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_MAILER'][0] ?? '' }}</strong>
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
                                <strong>{{ $errors->get('env.*')['env.MAIL_HOST'][0] ?? '' }}</strong>
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
                                <strong>{{ $errors->get('env.*')['env.MAIL_PORT'][0] ?? '' }}</strong>
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
                                <strong>{{ $errors->get('env.*')['env.MAIL_USERNAME'][0] ?? '' }}</strong>
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="form-group ">
                            <label for="text">{{ __('MAIL PASSWORD') }}</label>
                        <div class="input-group">
                            <input style="display: inline-block" type="password"
                                   name="env[MAIL_PASSWORD]"
                                   id="password"
                                   class="password form-control"
                                   placeholder="password"
                                   required
                                   value="{{$mail ? $mail['password'] : ''}}">
                            <div class="input-group-append">
                             <span id="togglePassword" style="display: inline-block" class="input-group-text">
                            <i class="far fa-eye-slash"
                               style="cursor: pointer"></i>
                        </span>
                            </div>
                        </div>


                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_PASSWORD'][0] ?? '' }}</strong>
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="form-group">
                        <label for="text">{{ __('MAIL ENCRYPTION') }}</label>
                        <select name="env[MAIL_ENCRYPTION]" class="form-control">
                            <option value="tls" {{$mail && $mail['encryption'] == 'tls' ? 'selected' : ''}}>tls</option>
                            <option value="ssl" {{$mail && $mail['encryption'] == 'ssl' ? 'selected' : ''}}>ssl</option>
                        </select>
                        @if($errors->has('env.*'))
                            <small class="text-danger" role="alert">
                                <strong>{{ $errors->get('env.*')['env.MAIL_ENCRYPTION'][0] ?? '' }}</strong>
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

                    @if($mail)
                        <button id="testMail"
                                class="btn btn-info  waves-effect waves-light px-4 py-2"
                                style="width: 200px;">
                            <span style="display: none" class="testmail-spinner spinner-grow spinner-grow-sm"
                                  role="status" aria-hidden="true"></span>
                            <span class="sr-only"> </span>
                            {{ __('app.TestMail') }}

                        </button>


                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="recipientEmailModal" tabindex="-1" role="dialog" aria-labelledby="recipientEmailModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('app.TestMail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div

</div>

@push('js')
    <script>
        $(document).ready(function () {

            $("#togglePassword").click(function (e) {

                e.preventDefault();
                var type = $(this).parent().parent().find(".password").attr("type");
                console.log(type);
                if (type == "password") {
                    $(this).find('i').removeClass("fa-eye-slash");
                    $(this).find('i').addClass("fa-eye");
                    $(this).parent().parent().find(".password").attr("type", "text");
                } else if (type == "text") {
                    $(this).find('i').removeClass("fa-eye");
                    $(this).find('i').addClass("fa-eye-slash");
                    $(this).parent().parent().find(".password").attr("type", "password");
                }
            });


            $('#testMail').on('click', function (e) {
                e.preventDefault()

                $('.testmail-spinner').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('#Mailsettings').serialize(),
                    url: `${app_url}/settings/mail`,
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `${app_url}/testmailsetting`,
                            method: "GET",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                var message = data.message;
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 4000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: message
                                })
                                $('.testmail-spinner').hide();
                            },
                            error: function (data) {
                                var message = data.responseJSON.message;
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 4000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'error',
                                    title: message
                                })
                                $('.testmail-spinner').hide();
                            }

                        });


                        // var message = data.message;
                        // const Toast = Swal.mixin({
                        //     toast: true,
                        //     position: 'top-end',
                        //     showConfirmButton: false,
                        //     timer: 4000,
                        //     timerProgressBar: true,
                        //     didOpen: (toast) => {
                        //         toast.addEventListener('mouseenter', Swal.stopTimer)
                        //         toast.addEventListener('mouseleave', Swal.resumeTimer)
                        //     }
                        // })
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: message
                        // })
                        // $('.testmail-spinner').hide();
                    },
                    error: function (data) {
                        var message = data.responseJSON.message;
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'error',
                            title: message
                        })
                        $('.testmail-spinner').hide();
                    }
                });

            })

        })

    </script>

@endpush
