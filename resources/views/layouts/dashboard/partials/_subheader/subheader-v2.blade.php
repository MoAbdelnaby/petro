
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">@yield('page_title')</h3>
			<span class="kt-subheader__separator kt-subheader__separator--v"></span>
			<div class="kt-subheader__breadcrumbs">
				<a href="#" class="kt-subheader__breadcrumbs-link">{{__('app.home')}}</a>
				@yield('breadcrumbs')
			</div>
		</div>
		<div class="kt-subheader__toolbar">
			<div class="kt-subheader__wrapper">
                @yield('toolbar')
			</div>
		</div>
	</div>
</div>

<!-- end:: Subheader -->
