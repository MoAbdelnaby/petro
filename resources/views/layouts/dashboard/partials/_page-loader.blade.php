
<!-- loader Start -->
<div id="loading">
{{--    <div id="loading-center" class="d-flex align-items-center justify-content-center">--}}
{{--        <div class="text-center">--}}
{{--            <img src="{{asset('images/loader.gif')}}" alt="" class="mb-2" width="120px">--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="loading-view">
        @if(session('darkMode') =="on")
            <img src="{{asset('images/wakebwhite.ico')}}" alt="" class="mb-2" width="120px">

        @else
            <img src="{{asset('images/wakebdark.ico')}}" alt="" class="mb-2" width="120px">
        @endif
        <span></span>
    </div>
</div>
<!-- loader END -->
<style>
    #loading{
        background: #fff;
    }


</style>
