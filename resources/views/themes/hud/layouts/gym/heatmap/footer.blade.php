<!--Js-->
<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>

<!-- amcharts scripts -->
<script src="{{ asset('assets/amcharts4/core.js') }}"></script>
<script src="{{ asset('assets/amcharts4/charts.js') }}"></script>
<script src="{{ asset('assets/amcharts4/animated.js') }}"></script>




<!-- Bootstrap JS -->
<script src="{{ asset('assets/roots/js/bootstrap.min.js') }}"></script>

<!-- Face API JS -->
<script src="{{ asset('assets/js/jquery.facedetection.min.js') }}"></script>

<script src="{{ asset('assets/js/less.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/webcam.min.js') }}"></script>

<script>
	var app_url = "{{url('/')}}";
</script>

<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/functions.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"
	integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ=="
	crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/func.js') }}"></script>

<script src="{{ asset('assets/js/chart-script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    var Disable_regions = "{{ __('app.Disable_regions') }}";
	$(".disable-reg").select2({
		placeholder: Disable_regions,
		tags: false,
		tokenSeparators: [',', ' ']
	})
    $(".disable-reg2").select2({
        placeholder: Disable_regions,
        tags: false,
        tokenSeparators: [',', ' ']
    })
</script>

@stack('js')

</body>

</html>
