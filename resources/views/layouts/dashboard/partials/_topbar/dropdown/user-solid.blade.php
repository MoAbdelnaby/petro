<div class="kt-user-card kt-margin-b-40 kt-margin-b-30-tablet-and-mobile" style="background-image: url({{url('/temp')}}/assets/media/misc/head_bg_sm.jpg)">
	<div class="kt-user-card__wrapper">
		<div class="kt-user-card__pic">

			<!--use "kt-rounded" class for rounded avatar style-->
			<img alt="Pic" src="{{url('/temp')}}/assets/media/users/300_21.jpg" class="kt-rounded-" />
		</div>
		<div class="kt-user-card__details">
			<div class="kt-user-card__name">{{auth()->user()->name}}</div>
			<div class="kt-user-card__position">{{ __('app.CTO') }}, {{ __('app.Loop_Inc') }}.</div>
		</div>
	</div>
</div>
<ul class="kt-nav kt-margin-b-10">
	<li class="kt-nav__item">
		<a href="custom/profile/personal-information.html" class="kt-nav__link">
			<span class="kt-nav__link-icon"><i class="flaticon2-calendar-3"></i></span>
			<span class="kt-nav__link-text">{{ __('app.profile') }}</span>
		</a>
	</li>
	<li class="kt-nav__item">
		<a href="custom/profile/overview-1.html" class="kt-nav__link">
			<span class="kt-nav__link-icon"><i class="flaticon2-browser-2"></i></span>
			<span class="kt-nav__link-text">{{ __('app.My_Tasks') }}</span>
		</a>
	</li>
	<li class="kt-nav__item">
		<a href="custom/profile/overview-2.html" class="kt-nav__link">
			<span class="kt-nav__link-icon"><i class="flaticon2-mail"></i></span>
			<span class="kt-nav__link-text">{{ __('app.Messages') }}</span>
		</a>
	</li>
	<li class="kt-nav__item">
		<a href="custom/profile/account-settings.html" class="kt-nav__link">
			<span class="kt-nav__link-icon"><i class="flaticon2-gear"></i></span>
			<span class="kt-nav__link-text">{{ __('app.Settings') }}</span>
		</a>
	</li>
	<li class="kt-nav__separator kt-nav__separator--fit"></li>
	<li class="kt-nav__custom kt-space-between">
		<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-label-brand btn-upper btn-sm btn-bold border-0">{{ __('app.Sign_Out') }}</a>
		<i class="flaticon2-information kt-label-font-color-2" data-toggle="kt-tooltip" data-placement="right" title="" data-original-title="{{ __('app.Click_to_learn_more') }}..."></i>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>
