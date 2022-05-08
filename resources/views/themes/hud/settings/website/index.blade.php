@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.settings.page_title.index')}}
@endsection
@section('breadcrumbs')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{route('settings.index')}}" class="kt-subheader__breadcrumbs-link">
        {{__('app.settings.page_title.index')}} </a>
@endsection
@section('content')
    @push('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--begin::Page Custom Styles(used by this page) -->
        <link href="{{url('/temp')}}/assets/css/pages/wizards/wizard-v1.css" rel="stylesheet" type="text/css"/>
    @endpush

    <div class="kt-portlet">
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid kt-grid--desktop-xl kt-grid--ver-desktop-xl  kt-wizard-v1"
                 id="kt_wizard_v1" data-ktwizard-state="step-first">
                <div class="kt-grid__item kt-wizard-v1__aside">

                    <!--begin: Form Wizard Nav -->
                    <div class="kt-wizard-v1__nav">
                        <!--doc: Remove "kt-wizard-v1__nav-items--clickable" class and also set 'clickableSteps: false' in the JS init to disable manually clicking step titles -->
                        <div class="kt-wizard-v1__nav-items kt-wizard-v1__nav-items--clickable">
                            <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step"
                                 data-ktwizard-state="current">
                                <span>1</span>
                            </div>
                            <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step">
                                <span>2</span>
                            </div>
                            <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step">
                                <span>3</span>
                            </div>
                        </div>
                        <div class="kt-wizard-v1__nav-details">
                            <div class="kt-wizard-v1__nav-item-wrapper" data-ktwizard-type="step-info"
                                 data-ktwizard-state="current">
                                <div class="kt-wizard-v1__nav-item-title">

                                    {{__('app.settings.website_setup')}}
                                </div>
                                <div class="kt-wizard-v1__nav-item-desc">
                                    {{__('app.settings.website_setup_info')}}

                                </div>
                            </div>
                            <div class="kt-wizard-v1__nav-item-wrapper" data-ktwizard-type="step-info">
                                <div class="kt-wizard-v1__nav-item-title">
                                    {{__('app.settings.website_social')}}

                                </div>
                                <div class="kt-wizard-v1__nav-item-desc">
                                    {{__('app.settings.website_social_info')}}

                                </div>
                            </div>
                            <div class="kt-wizard-v1__nav-item-wrapper" data-ktwizard-type="step-info">
                                <div class="kt-wizard-v1__nav-item-title">
                                    {{__('app.settings.website_media')}}

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Nav -->

                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                    <!--begin: Form Wizard Form-->
                    <form class="kt-form" id="kt_form" method="post" action="{{url('/settings/setting_save')}}"   enctype="multipart/form-data">
                         @csrf

                        <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content"
                             data-ktwizard-state="current">
                            <div class="kt-heading kt-heading--md">{{__('app.settings.website_setup')}}</div>
                            <div class="kt-separator kt-separator--height-xs"></div>
                            <div class="kt-form__section kt-form__section--first">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.website_name')}}</label>
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="{{__('app.settings.form.website_name_desc')}}" value="{{ old('name', setting()->name  ) }}">
                                            <span class="form-text text-muted">{{__('app.settings.form.website_name_desc')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.whatsapp')}}</label>
                                            <input type="text" class="form-control" name="whats_num"
                                                   placeholder="{{__('app.settings.form.whatsapp_desc')}}" value="{{ old('whats_num', setting()->whats_num  ) }}">
                                            <span class="form-text text-muted">{{__('app.settings.form.whatsapp_desc')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.email')}}</label>
                                            <input type="email" class="form-control" name="email"
                                                   placeholder="{{__('app.settings.form.email_holder')}}" value="{{ old('email', setting()->email  ) }}">
                                            <span class="form-text text-muted">{{__('app.settings.form.email_desc')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label>{{__('app.settings.form.lang')}}</label>
                                            <select name="lang_id" class="select2 form-control">
                                                <option value="">{{__('app.settings.form.select')}}</option>
                                                  @foreach ( languages() as  $lang)
                                                      <option value="{{$lang->id}}" {{ old('lang_id', setting()->lang_id ) == $lang->id ? 'selected' : '' }}>{{ $lang->name }}</option>
                                                    @endforeach
                                            </select>
                                            @can('create-languages')
                                            <span class="form-text text-muted"> <a style="color: red" href="{{url('settings/languages')}}"> {{__('app.settings.form.lang_create')}}</a> </span>
                                            @endcan
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Step 1-->

                        <!--begin: Form Wizard Step 2-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-heading kt-heading--md">{{__('app.settings.setcon')}}</div>
                            <div class="kt-separator kt-separator--height-sm"></div>
                            <div class="kt-form__section kt-form__section--first">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.facebook')}}</label>
                                            <input type="text" class="form-control" name="fb_link"
                                                   placeholder="{{__('app.settings.form.facebook_desc')}}" value="{{ old('fb_link', setting()->fb_link  ) }}">
                                            <span class="form-text text-muted">{{__('app.settings.form.facebook_desc')}} </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> {{__('app.settings.form.twitter')}} </label>
                                            <input type="text" class="form-control" name="tw_link"
                                                   placeholder="{{__('app.settings.form.twitter_desc')}}" value="{{ old('tw_link', setting()->tw_link  ) }}">
                                            <span class="form-text text-muted">{{__('app.settings.form.twitter_desc')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.linkedIn')}}</label>
                                            <input type="text" class="form-control" name="in_link"
                                                   placeholder="{{__('app.settings.form.linkedIn_desc')}}" value="{{ old('in_link', setting()->in_link  ) }}">
                                            <span class="form-text text-muted"> {{__('app.settings.form.linkedIn_desc')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.insta')}}</label>
                                            <input type="text" class="form-control" name="insta_link"
                                                   placeholder="{{__('app.settings.form.insta_desc')}}" value="{{ old('insta_link', setting()->insta_link  ) }}">
                                            <span class="form-text text-muted"> {{__('app.settings.form.insta_desc')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.websit_link')}}</label>
                                            <input type="text" class="form-control" name="website_link"
                                                   placeholder="{{__('app.settings.form.websit_link_desc')}}" value="{{ old('website_link', setting()->website_link  ) }}">
                                            <span class="form-text text-muted"> {{__('app.settings.form.websit_link_desc')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.contact')}}</label>
                                            <input type="number" class="form-control" name="contact_phone"
                                                   placeholder="{{__('app.settings.form.contact_desc')}}"
                                                   value="{{ old('contact_phone', setting()->contact_phone  ) }}">
                                            <span class="form-text text-muted">{{__('app.settings.form.contact_desc')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-heading kt-heading--md"> {{__('app.settings.mail_addres')}}</div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.address_desc')}}</label>
                                            <input type="text" class="form-control" name="address"
                                                   placeholder="{{__('app.settings.form.address_desc')}}"
                                                   value="{{ old('address', setting()->address  ) }}">
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label>{{__('app.settings.form.country')}}</label>
                                            <select name="country" class="select2 form-control">
                                                <option value="">{{__('app.settings.form.select')}}</option>
                                                  @foreach ( COUNTRY_CODE as $key => $country)
                                                      <option value="{{$key}}" {{ old('country', setting()->country ) == $key ? 'selected' : '' }}>{{$country}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Step 2-->

                        <!--begin: Form Wizard Step 3-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-heading kt-heading--md">{{__('app.settings.webSite_Media')}}</div>
                            <div class="kt-separator kt-separator--height-sm"></div>
                            <div class="kt-form__section kt-form__section--first">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group" style="text-align: center">
                                                <div class="kt-avatar" id="kt_profile_avatar_2">
                                                    <div class="kt-avatar__holder" style="margin-left: 35px;background-image: url({{setting()->imageUrl('logo') ??  'https://image.shutterstock.com/image-vector/robot-icon-bot-sign-design-260nw-715962319.jpg'}})"></div>
                                                    <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.change_logo')}}">
                                                        <i class="fa fa-pen"></i>
                                                        <input type='file' name="logo" />
                                                    </label>
                                                    <span class="form-text text-muted">{{__('app.settings.change_logo_desc')}}</span>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-group" style="text-align: center">
                                                <div class="kt-avatar" id="kt_profile_avatar_1">
                                                    <div class="kt-avatar__holder" style="margin-left: 35px;background-image: url({{setting()->imageUrl('icon') ?? 'https://image.shutterstock.com/image-vector/robot-icon-bot-sign-design-260nw-715962319.jpg'}})"></div>
                                                    <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.change_icon')}}">
                                                        <i class="fa fa-pen"></i>
                                                        <input type='file' name="icon"/>
                                                    </label>
                                                    <span class="form-text text-muted">{{__('app.settings.change_icon_desc')}}</span>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Step 3-->

                        <!--begin: Form Actions -->
                        <div class="kt-form__actions">
                            <div class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper"
                                 data-ktwizard-type="action-prev">
                                {{__('app.settings.previous_page')}}
                            </div>
                            <div class="btn btn-brand btn-md btn-tall btn-wide btn-bold btn-upper"
                                 data-ktwizard-type="action-submit">
                                {{__('app.settings.submit_page')}}
                            </div>
                            <div class="btn btn-brand btn-md btn-tall btn-wide btn-bold btn-upper"
                                 data-ktwizard-type="action-next">
                                {{__('app.settings.next_page')}}
                            </div>
                        </div>
                        <!--end: Form Actions -->
                    </form>
                    <!--end: Form Wizard Form-->
                </div>
            </div>
        </div>
    </div>

@push('js')
    <script src="{{url('/temp')}}/assets/js/pages/custom/wizards/wizard-v1.js" type="text/javascript"></script>
    <script src="{{url('/temp')}}/assets/js/select2.min.js" type="text/javascript"></script>
    <script src="{{url('/temp')}}/assets/js/pages/components/forms/controls/avatar.js" type="text/javascript"></script>
    <script type="text/javascript">

          //select2
    $('.select2').select2({
        'width': '100%',
        tags : false
    });

    </script>

@endpush
@endsection
