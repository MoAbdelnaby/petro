




$(document).ready(function () {
    //Pagination numbers
    // $('#paginationSimpleNumbers').DataTable({
    //   "pagingType": "simple_numbers"
    // });
    function count(){
      $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 2500,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
    }
    count();


  $('.header .nav-pills .nav-link').on('click',function (e) {
    count();
  })
  /**/

  $('.screenshot-img img').on('click',function (e) {
    var src = $(this).attr("src");
    $('#image_to_show').attr('src', src);
  })
  $('#paginationSimpleNumbers tr').on('click',function (e) {
    // var screenshot = $(this).closest('div').attr('id');
    trid = $(this).attr('id');
    let img2 = $(this).data('screen2');
      console.log('img2',img2);

    console.log(trid);

   // trid = $('tr').attr('id');
    //var src = $(this).attr("src");
      $('#image_to_show').attr('src', trid);
      if(img2){
          console.log($('#images-cont'))
           $('#car_image').remove();
          $('#images-cont').prepend(`<img src="${img2}" id="car_image" alt="car" />`)
          // let carImgElm = $('#car_image');
          // carImgElm.attr('src', img2);
          // carImgElm.css('display','inline-block');
      }

  })


  });
$('#basicExampleModal').on('hidden.bs.modal', function (e) {
    $('#car_image').remove();
    $('.next-arrow, .prev-arrow').hide();
})



  $('.main-logo span').on('click',function () {
  	// body...
  	$('.tab-pane.active .setting-col').toggleClass('open');
  })
  $('.close-setting').on('click',function () {
  	// body...
  	$('.tab-pane.active .setting-col').removeClass('open');
  })


// Data Picker///////////////////////////////////////////////////////////////////////////////////



  $(document).ready(function () {
    // Data Picker Initialization
    $('.datepicker').pickadate();
    });



    // Extend the default picker options for all instances.
$.extend($.fn.datepicker.defaults, {
  monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre',
  'Novembre', 'Décembre'],
  weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
  today: 'aujourd\'hui',
  clear: 'effacer',
  formatSubmit: 'yyyy-mm-dd'
  })

  // Or, pass the months and weekdays as an array for each invocation.
  $('.datepicker').datepicker({
  monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre',
  'Novembre', 'Décembre'],
  weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
  clear: 'effacer',
  formatSubmit: 'yyyy/mm/dd'
  })

