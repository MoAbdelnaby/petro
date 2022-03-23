




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
    let checkInDate = $(this).find('.checkin-date').text();
      let checkOutDate = $(this).find('.checkout-date').text();
      let period = $(this).find('.period').text();
      let area = $(this).find('.area').text();
      let arPlate = $(this).find('.ar-plate').text();
      let enPlate = $(this).find('.en-plate').text();
      let status = $(this).find('.status > span').clone();


      // modal elements
      let modal = $('#basicExampleModal0');

      let checkInDateElm = modal.find('.checkin-date .info');
      let checkOutDateElm = modal.find('.checkout-date .info');
      let periodElm = modal.find('.period .info');
      let areaElm = modal.find('.area .info');
      let arPlateElm = modal.find('.ar-plate .info');
      let enPlateElm = modal.find('.en-plate .info');
      let statusElm = modal.find('.status .info');
      let slides = modal.find('.slide img');
      let thumbs = modal.find('.thumb img');


      $('#image_to_show').attr('src', trid);
      slides[0].setAttribute('src', trid);
      slides[1].setAttribute('src', img2);
      thumbs[0].setAttribute('src', trid);
      thumbs[1].setAttribute('src', img2);
      checkInDateElm.text(checkInDate);
      checkOutDateElm.text(checkOutDate);
      periodElm.text(period);
      areaElm.text(area)
      arPlateElm.text(arPlate)
      enPlateElm.text(enPlate);

      statusElm.html(status)
      // if(img2){
      //     console.log($('#images-cont'))
      //      $('#car_image').remove();
      //     $('#images-cont').prepend(`<img src="${img2}" id="car_image" alt="car" />`)
      //
      // }

  })



  });



$('#basicExampleModal0').on('shown.bs.modal', function (e) {
    let slideIndex = 1;
    displaySlide(slideIndex);

    function moveSlides(n) {
        displaySlide(slideIndex += n);
    }
    function setSlide(n){
        if(!n || n === slideIndex) return;
        slideIndex = n;
        let totalslides =
            document.querySelectorAll("#images-cont .slide");
        let totalthumbs =
            document.querySelectorAll("#images-cont .thumb");
        for (let i = 0; i < totalslides.length; i++) {
            totalslides[i].style.display = "none";
            totalthumbs[i].classList.remove('active')
        }

        totalslides[slideIndex - 1].style.display = "flex";
        totalthumbs[slideIndex - 1].classList.add('active')

    }

    $("#images-cont .next").on('click', () => moveSlides(1))
    $("#images-cont .previous").on('click', () => moveSlides(-1))
    $("#images-cont .thumb").on('click', function() {
        let i = $(this).data('thumb');
        console.log(i)
        setSlide(+i);
    })
    /* Main function */
    function displaySlide(n) {
        let i;
        let totalslides =
            document.querySelectorAll("#images-cont .slide");
        let totalthumbs =
            document.querySelectorAll("#images-cont .thumb");
        if (n > totalslides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = totalslides.length;
        }
        for (i = 0; i < totalslides.length; i++) {
            totalslides[i].style.display = "none";
            totalthumbs[i].classList.remove('active')
        }

        totalslides[slideIndex - 1].style.display = "flex";
        totalthumbs[slideIndex - 1].classList.add('active')
    }
})

$('#basicExampleModal0').on('hidden.bs.modal', function (e) {
    $("#images-cont .next").off();
    $("#images-cont .previous").off();
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

