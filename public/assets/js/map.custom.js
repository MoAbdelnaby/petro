var data = [
  ['sa-4293', 0],
  ['sa-tb', 1],
  ['sa-jz', 2],
  ['sa-nj', 3],
  ['sa-ri', 4],
  ['sa-md', 5],
  ['sa-ha', 6],
  ['sa-qs', 7],
  ['sa-hs', 8],
  ['sa-jf', 9],
  ['sa-sh', 10],
  ['sa-ba', 11],
  ['sa-as', 12],
  ['sa-mk', 250]
];
var name;
var className;
var secondMap = '';
var clicked = false;
// Create the chart
Highcharts.mapChart('suadiaMap', {
  chart: {
    map: 'countries/sa/sa-all',
    backgroundColor: '#36465b',
    borderColor: '#36465b',
    borderRadius: 10,
    events: {
      load: function (e) {
        // console.log(this);
        // console.log(e.point)
        // this.mapZoom(0.5);
        secondMap = this;

      }
    },

  },
  tooltip:{
    backgroundColor:'#242f3e',
    borderColor:'#242f3e',
    borderRadius:0,
    borderWidth:0,
    footerFormat: '',
    headerFormat:'',
    padding:0,
    pointFormat:'<div class="saudi__tooltip"><span class="one">{point.name} </span><span class="two">{point.value} Projects</span></div>',
    pointFormatter:'',
    style:{
    color:'#fff',
    fontSize:'1.1rem',
    whiteSpace:'nowrap',
    textAlign: 'center'
    },
    useHTML:true
    },
  title: {text: ''},
  mapNavigation: {
      enabled: false,
      // buttonOptions: {
      //     verticalAlign: 'bottom'
      // }
  },
  plotOptions:{
  series:{
      point:{
          events:{
              click: function(e){
                name = this.name;
                className = name.toLowerCase().replace(/ /g,'_') ;

                // if(name === 'Makkah') {

                  if(!clicked) {
                    $('#overlayLoading').addClass('loading');

                    // $('#homeCircles').fadeOut();

                    setTimeout(function () {
                      // console.log(this);
                      $('tspan').addClass('hide');
                      secondMap.mapZoom(0.5);
                      $('#suadiaMap svg path').css('display', 'none')
                      $( "tspan.hide:contains("+name+"), .highcharts-label.highcharts-tooltip path" ).css('display',"block");

                      $('path.highcharts-name-'+className).addClass('move')
                      // $('#suadiaMap').fadeOut();

                      $('#overlayLoading').removeClass('loading');
                      $('.projects__container').addClass('show');
                      // $('.side__card').addClass('show');

                      clicked = true;
                    }, 1500);
                  } else {
                    $('#overlayLoading').addClass('loading');

                    setTimeout(function () {
                      // console.log(this);
                      $('tspan').removeClass('hide');
                      secondMap.mapZoom(13);
                      $('#suadiaMap svg path').css('display', 'block')
                      // $( "tspan.hide:contains('Makkah'), .highcharts-label.highcharts-tooltip path" ).css('display',"block");

                      $('path.highcharts-name-'+className).removeClass('move')
                      // $('#suadiaMap').fadeOut();

                      $('#overlayLoading').removeClass('loading');
                      $('.projects__container').removeClass('show');
                      $('#project').removeClass('show');
                      // $('.side__card').addClass('show');
                      clicked = false;
                    }, 1500);
                  }
                // }

              }
          }
      }
    }
  },
  series: [{
      data: data,
      name: 'هيئة تطوير منطقة مكة المكرمة',
      states: {
          hover: {
            color :'#6B4B32'
          }
      },
      dataLabels: {
          enabled: true,
          format: '{point.name}'
      }
  }],
  colorAxis: {
    min: 1,
    type: '',
    minColor: '#242f3e',
    maxColor: '#6C747E',
    stops: [
            [0, '#242f3e'],
            // [0.67, '#6C747E'],
            [1, '#6C747E']
    ]
  }
});


$('.side__card.cat').on('click', function () {
  var category = $(this).attr('data-cat');
  console.log(category);

  $('#project .project-cat').text(category);

  $('#projectsContainer').removeClass('show');
  $('#project').addClass('show');
  $( "tspan.hide:contains('"+name+"'), .highcharts-label.highcharts-tooltip path" ).css('display',"block");
  $('path.highcharts-name-'+className).addClass('move');
});

$('#projectsContainer .close').on('click', function () {
  $('#projectsContainer').removeClass('show');
  $( "tspan.hide:contains('"+name+"'), .highcharts-label.highcharts-tooltip path" ).css('display',"block");
  $('path.highcharts-name-'+className).addClass('move');
});

$('.side__card.proj').on('click', function () {
  $('#overlayLoading').addClass('loading');

  mapInstall = true;

  setTimeout(function () {
    $('.home').fadeOut();
    $('#overlayLoading').removeClass('loading');

  }, 1500);
})

$('#project .project__marker').on('click', function () {
  $('#overlayLoading').addClass('loading');
  $('.project__details').addClass('show');
  setTimeout(function () {
    $('.home').fadeOut();
    $('#overlayLoading').removeClass('loading');

  }, 1500);
});

$('.project__details .close').on('click', function () {
  $('.home').fadeIn();
  $('.project__details').removeClass('show');
});

//Circles
var colors = [
  ['#3A3D4C', '#707070'],
  ['#3A3D4C', '#707070'],
  ['#3A3D4C', '#707070'],
  ['#3A3D4C', '#707070'],
  ['#3A3D4C', '#D59563'],
  ['#3A3D4C', '#D59563'],
  ['#3A3D4C', '#D59563']
]
percentages = [87, 80, 65, 45, 85, 60, 75];

// Every Circle Related to the Spasific Data

for (var i = 1; i <= 7 ; i++) {
var child = document.getElementById('circles-' + i),
  percentage = 30 + (i * 10),
  text = '%';

  if( i === 5) text = '$'

  else if (i === 6 ) text = 'h'

  else if (i === 7 ) text = ''

  Circles.create({
    id:         child.id,
    percentage: percentages[i - 1],
    radius:     50,
    width:      6,
    number:     percentages[i - 1],
    text:       text,
    colors:     colors[i -1]
  });


}


// Chart
var chart2 = Highcharts.chart('container', {
  title: {text: ''},
  subtitle: {text: ''},
  xAxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  series: [{
      type: 'column',
      colorByPoint: true,
      data: [25, 35, 95, 80, 25, 85, 45, 30, 60, 75, 35, 20],
      showInLegend: false,
  }],
  tooltip:{
    backgroundColor:'#707070',
    borderColor:'#fff',
    borderRadius:0,
    borderWidth:0,
    footerFormat: '',
    headerFormat:'',
    padding: 5,
    pointFormat:'<span>{point.y} Project</span>',
    pointFormatter:'',
    style:{
    color:'#fff',
    whiteSpace:'wrap',
    textAlign: 'center'
    }
  }
});

// Chart 2
Highcharts.chart('container2', {
  chart: {
      type: 'areaspline'
  },
  xAxis: {
      categories: [
          'Week 1',
          'Week 2',
          'Week 3',
          'Week 4',
          'Week 5',
          'Week 6',
          'Week 7'
      ],
      plotBands: [{ // visualize the weekend
          from: 4.5,
          to: 6.5,
          color: 'rgba(68, 170, 213, .2)'
      }]
  },
  tooltip: {
      shared: true,
      valueSuffix: ' days'
  },
  credits: {
      enabled: false
  },
  plotOptions: {
      areaspline: {
          fillOpacity: 0.5
      }
  },
  series: [{
      name: '',
      data: [3, 4, 3, 5, 4, 6, 7]
  }, {
      name: '',
      data: [1, 3, 4, 3, 3, 5, 6]
  }]
});

