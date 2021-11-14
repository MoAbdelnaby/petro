<!-- Wrapper Start -->
<div class="wrapper">
    @include('layouts.dashboard.partials._aside.base')

    @include('layouts.dashboard.partials._header.base')

    @include('layouts.dashboard.partials._alert')

    @yield('content')

</div>
@include('layouts.dashboard.partials._footer.base')
