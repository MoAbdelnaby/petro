'use strict';

jQuery(document).ready(function () {
  $('.toast').toast('show');
    store();

    var wind = $(window),
    sticky = $(".model.nav-pills"),
     stickyOffset = $(".model.nav-pills").offset().top;

    wind.on("scroll", function() {
        var scroll = wind.scrollTop();
        if (scroll < stickyOffset) {
            sticky.removeClass("nav-fixed");
        } else {
            sticky.addClass("nav-fixed");
        }
    });

    // var chartsHeight = $('.charts-sec > .row').height() +'px';
    // $(".charts-sec").css("height", chartsHeight);
    //
    // $( window ).resize(function() {
    //     var chartsHeight = $('.charts-sec > .row').height() +'px';
    //     $(".charts-sec").css("height", chartsHeight);
    // });

});



 function store() {

     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });


     $('#logout').on('click',function (e) {
            console.log("ddd");
            document.getElementById('logout-form').submit();

     });

     $('.export').on('click',function (e) {
      $('input[name=submittype]').val(2);
      $("#doorform").submit();

   });
   $('#searchRecord').on('click',function (e) {
    $('input[name=submittype]').val(1);
    $("#doorform").submit();

    });

     $('#notifytime').hide();
     if ($('#notification').is(":checked"))
     {
         $('#notifytime').show();

     }else{
         $('#notifytime').hide();

     }

     $("#notification").on('change',function(e){
         e.stopPropagation()
         if ($('#notification').is(":checked"))
         {
             $('#notifytime').show();
             setScreenHeight();
         }else{

             $('#notifytime').hide();
             setScreenHeight();
         }
     });

     function setScreenHeight(e){

         var height= $('.setting').height()
             - $('.header .tab-content .screenshoot .card h6').height()
             - 65;
         if($('#myTabJust').length != 0){
             height = height - $('#myTabJust').height();
         }
         $('.screenshoot-content').height(height)
         $('.screenshoot-content-door').height(height)
         console.log(height)
     }

     setScreenHeight();

     $(".setting").on('click',function(){
         setScreenHeight();
     })

 }


