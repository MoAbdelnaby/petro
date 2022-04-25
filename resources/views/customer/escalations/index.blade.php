@extends('layouts.dashboard.index')

@section('page_title') {{__('app.escalation')}} @endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            
            <div class="treeItems">
                

                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{__('app.escalation')}}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body p-2">

                            <div class="row pb-5 px-2">
                                <div class="endRowTree left">
                                    {{-- <div class="endrowItem"></div> --}}
                                </div>
            
                                <div class="row col p-0 mx-auto">
                                  
                                </div>
            
                                <div class="endRowTree right">
                                    {{-- <div class="endrowItem"></div> --}}
                                </div>
            
                            </div>

                            <div class="col-12 text-center">
                                <span id="SaveChanges">Save</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(".deleteEscalation").on('click', function (e) {
            e.preventDefault();
            let url = $(this).data("url");
            let token = '{{csrf_token()}}';

            let inputs = `<input name="_token" value=${token}>`;
            inputs += `<input type="hidden" name="_method" value="DELETE">`;

            $(`<form method="post" action=${url}>${inputs}</form>`).appendTo('body').submit().remove();
        });



        $(document).ready(function(){
            // treeItems
        let positions = @json($positions); 

            var escalations=[];
            escalations= [
                {position: 0,time: 60}
            ];

            function drowTree(escalations){
                $('.row.col .row.col-12').remove();
                let countRows1 = escalations.length/4;
                var i;
                // console.log(Math.ceil(countRows1));
                for(var r=1;r <= Math.ceil(countRows1); r++){
                    if(r % 2 == 0){
                        var clas = "even-row";
                    }
                    else{
                        var clas = "odd-row";
                    }

                    $('.row.col').append(`<div class="col-12 `+ clas +` row p-0 m-0 2020"></div>`);
                }
                for(var i=1;i <= escalations.length; i++){
                    var ItemHtml = `<div data-array="`+(i-1)+`" class="treeItem col-3">`+
                        `<span class="delete-item">`+
                            `<i class="fa fa-trash"></i>`+
                        `</span>`+
                        `<h4>`+
                            `<select class="position" name="" id="">`;
                            for (let j = 0; j < positions.length; j++) {
                                ItemHtml += `<option `+ (escalations[i-1].position == positions[j].id ? 'selected' : ''  ) +` value="`+ positions[j].id +`">`+ positions[j].name +`</option>`;
                            } ;
                                
                    ItemHtml +=
                            `</select>`+
                            `<span class="time">`+
                                `<i class="fa fa-stopwatch"></i>`+
                                `<span>`+
                                    `<select class="min" name="" id="">`+
                                        `<option `+ (escalations[i-1].time == 15 ? 'selected':'') + ` value="15">15 Min</option>`+
                                        `<option `+ (escalations[i-1].time == 30 ? 'selected':'') + ` value="30">30 Min</option>`+
                                        `<option `+ (escalations[i-1].time == 60 ? 'selected':'') + ` value="60">1 hour</option>`+
                                        `<option `+ (escalations[i-1].time == 90 ? 'selected':'') + ` value="90">Hour & half</option>`+
                                        `<option `+ (escalations[i-1].time == 120 ? 'selected':'') + ` value="120">2 Hours</option>`+
                                    `</select>`+
                                `</span>`+
                            `</span>`+
                        `</h4>`+
                        `<span class="AddNew">`+
                            `<i class="fa fa-layer-plus"></i>`+
                        `</span>`+
                    `</div>`;
                    $('.row.col .row.col-12:nth-child('+Math.ceil(i/4)+')').append(ItemHtml);
                }

            }
            drowTree(escalations);
            // remove item 
            $('.row.col').delegate('.delete-item','click',function(){
                var index = $(this).parents('.treeItem').attr('data-array');
                escalations.splice(index);
                drowEndRow(escalations);
            });

            // AddNew item 
            $('.row.col').delegate('.AddNew','click',function(){
                escalations.push({position:0, time:60});
                drowEndRow(escalations);
                console.log(escalations);

                drowTree(escalations);
            });
            // console.log(escalations.slice(1));
            $('.treeItems').delegate('.treeItem select.position', 'change', function(){
                let index = $(this).parents('.treeItem').attr('data-array');
                escalations[index].position = $(this).val();
                drowTree(escalations);
            });
            $('.treeItems').delegate('.treeItem select.min', 'change', function(){
                let index = $(this).parents('.treeItem').attr('data-array');
                escalations[index].time = $(this).val();
                console.log(escalations);
                drowTree(escalations);
            });



            function drowEndRow(escalations){
                let countRows1 = escalations.length / 4;
                if(escalations.length % 4 == 0){
                    for(let r=1;r <= Math.ceil(countRows1); r++){
                    if(r % 2 == 0){
                        $('.endRowTree.left').append('<div class="endrowItem" style="top:'+((r-1)*155)+'px"></div>');
                    }
                    else{
                    $('.endRowTree.right').append('<div class="endrowItem" style="top:'+((r-1)*155)+'px"></div>');
                    }

                }
                }
                
            }

        })

    </script>
@endpush
