'use strict';

var customFunction = function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    return {
        // Public functions
        init: function () {
            store();
            update();
            searchuser();
            searchrole();
            searchpermission();
            searchpackage();
            searchmodel();
            searchfeature();
            getmodelfeatures();
            darkmode();
        },
    };
}();

jQuery(document).ready(function () {
    customFunction.init();
    var today = new Date();
    $('.userroles').select2();
    $('.packagefeature').select2();
    var logoW = 1;
    // jQuery(document).on('mouseenter', '.sidebar-main .iq-sidebar', function() {
    //     if($('#checkbox:checked').length > 0){
    //         jQuery('.sidebar-main .mainlogo').attr("src",app_url+"/images/wakeball/wakebwhitetext.png").height(30).width(140);
    //     }else{
    //         jQuery('.sidebar-main .mainlogo').attr("src",app_url+"/images/wakeball/wakebdarktext.png").height(30).width(140);
    //     }
    //     $(".menutext").show();
    //
    // });

    // jQuery(document).on('mouseleave', '.sidebar-main .iq-sidebar', function() {
    //     if($('#checkbox:checked').length > 0){
    //         jQuery('.sidebar-main .mainlogo').attr("src",app_url+"/images/wakeball/wakebwhite.png").height(30).width(50);
    //     }else{
    //         jQuery('.sidebar-main .mainlogo').attr("src",app_url+"/images/wakeball/wakebdark.png").height(30).width(50);
    //     }
    //
    //     $(".menutext").hide();
    //
    // });

    // jQuery(document).on('click', '.wrapper-menu', function() {
    //         if ( jQuery( this ).hasClass( "open" ) ) {
    //             if($('#checkbox:checked').length > 0){
    //                 if(logoW == 0){
    //                     jQuery('.mainlogo').attr("src", app_url+"/images/wakeball/wakebwhite.png").height(30).width(50);
    //                 }
    //                 else{
    //                     jQuery('.mainlogo').attr("src", app_url+"/images/wakeball/wakebwhitetext.png").height(30).width(140);
    //                 }
    //
    //             }else{
    //                 if(logoW == 0){
    //                     jQuery('.mainlogo').attr("src", app_url+"/images/wakeball/wakebdark.png").height(30).width(50);
    //                 }
    //                 else{
    //                     jQuery('.mainlogo').attr("src", app_url+"/images/wakeball/wakebdarktext.png").height(30).width(140);
    //                 }
    //
    //             }
    //             $(".menutext").hide();
    //         }
    //         else {
    //             if($('#checkbox:checked').length > 0){
    //                 jQuery('.mainlogo').attr("src",app_url+"/images/wakeball/wakebwhitetext.png").height(30).width(140);
    //             }else{
    //                 jQuery('.mainlogo').attr("src",app_url+"/images/wakeball/wakebdarktext.png").height(30).width(140);
    //             }
    //
    //             $(".menutext").show();
    //         }
    //
    //
    //     logoW = !logoW;
    //
    // });


    var currenttype = $('#usertype').val();
    if (currenttype == 'customer' || currenttype == 'subcustomer') {
        $('#userroles').hide();
    } else {
        $('#userroles').show();
    }

    $('#usertype').on('change', function () {
        let value = $('#usertype').val();

        if (value == 'customer' || value == 'subcustomer') {
            $('#userroles').hide();
        } else {
            $('#userroles').show();
        }
    });

});


function darkmode() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#checkbox").on('change', function () {
        let url = app_url;
        if (this.checked) {
            window.location.replace(app_url + "/dark/on");
        } else {
            window.location.replace(app_url + "/dark/off");
        }


    });
}

function getmodelfeatures() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#packagemodelitem").on('change', function () {
        let model_id = $("#packagemodelitem").val();
        if (model_id == '0') {
            $('#packagefeature').find('option')
                .remove()
                .end();
        } else {
            $.ajax({
                data: {
                    'model_id': model_id,

                },
                url: app_url + "/saas/packages/items/modelfeatures",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $("#packagefeature").empty();
                    response.forEach(function (item, index) {
                        $("#packagefeature").append(`
                          <option value="` + item.id + `">` + item.feature.name + `</option>
                        `);
                    });


                },
                error: function (data) {
                    $('#packagefeature').find('option')
                        .remove()
                        .end();
                }
            });
        }
    });
}

function update() {
    $("input[name='permissions']").click(function () {
        $('.' + $(this).val())[0].click();
    });
    var id = -1;
    $(document).on('click', '.update-item', function () {
        id = $(this).attr('rel');
        $.ajax({
            data: {'id': id},
            url: app_url + "/api/roles/edit/item",
            dataType: "JSON",
            type: "GET",
            success: function (data) {
                $('.update-role').modal({backdrop: 'static', keyboard: false})
                $('.name').val(data.name)
                $('.id').val(id)
                $('.display_name').val(data.display_name)
                if (data.permissions) {
                    data.permissions.forEach(function (item) {
                        $('.' + item.name)[0].checked = true
                    })
                }
            },
            error: function (data) {
                $('.update-role').modal('hide');
                if (data.responseJSON.message) {
                    $('.g-errors').html(`
                            <div class="alert alert-danger fade error-message" role="alert">
                        <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                        <div class="alert-text"></div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>
                        `);
                    $('.error-message').addClass("show");
                    $('.alert-text').text(data.responseJSON.message)
                }
            }
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.close-form').on('click', function () {

        $(".display_name,.name").removeClass("is-invalid");
        $(".display_name,.name").val("");
        $('#rolesForm')[0].reset();
        $('.error-message').removeClass("show");
    })
    $('#update_roles').click(function (e) {
        $(".display_name,.name").removeClass("is-invalid");
        $('.error-message').removeClass("show");
        e.preventDefault();
        $(this).html(trans['storing']);
        $.ajax({
            data: $('#updateRolesForm').serialize(),
            url: app_url + "/api/roles/update",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $(".display_name,.name").val("");
                $('#rolesForm')[0].reset();
                /**
                 * Notification show
                 */

                $('#kt_toast_2').toast('show');
                $('.update-role').modal('toggle');
                $('#store_role').html(trans['save']);
                $('#updateRolesForm').trigger("reset");
                $('.update-role').modal('hide');
                $(".display_name,.name").removeClass("is-invalid");
                $('.error-message').removeClass("show");
                window.location.href = app_url + "/auth/roles";
            },
            error: function (data) {
                if (data.responseJSON.message) {
                    $('.create-error').html(`
                            <div class="alert alert-danger fade error-message" role="alert">
                        <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                        <div class="alert-text"></div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>
                        `);
                    $('.error-message').addClass("show");

                    $('.alert-text').text(data.responseJSON.message)
                }
                $('#store_permission').html(trans['save']);
                if (data.responseJSON.errors.display_name) {
                    $(".display_name").addClass("is-invalid");
                    $(".display_name-feedback").text(data.responseJSON.errors.display_name);
                }
                if (data.responseJSON.errors.name) {
                    $(".name").addClass("is-invalid");
                    $(".name-feedback").text(data.responseJSON.errors.name);
                }
            }
        });
    });
}

function store() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.close-form').on('click', function () {
        $(".display_name,.name").removeClass("is-invalid");
        $('.error-message').removeClass("show");
        $('#rolesForm')[0].reset();
    })
    $('#store_roles').click(function (e) {
        $(".display_name,.name").removeClass("is-invalid");
        $('.error-message').removeClass("show");
        e.preventDefault();
        $(this).html(trans['storing']);
        $.ajax({
            data: $('#rolesForm').serialize(),
            url: app_url + "/api/roles/store",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#rolesForm')[0].reset();
                /**
                 * Notification show
                 */

                window.location.href = app_url + "/auth/roles";
                $('#store_roles').html(trans['save']);
                $('#rolesForm').trigger("reset");
                $('.create-role').modal('hide');
                $(".display_name,.name,.group").removeClass("is-invalid");
                $('.error-message').removeClass("show");
            },
            error: function (data) {
                if (data.responseJSON.message) {
                    $('.create-error').html(`
                            <div class="alert alert-danger fade error-message" role="alert">
                        <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                        <div class="alert-text"></div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>
                        `);
                    $('.error-message').addClass("show");

                    $('.alert-text').text(data.responseJSON.message)
                }
                $('#store_roles').html(trans['save']);
                if (data.responseJSON.errors.display_name) {
                    $(".display_name").addClass("is-invalid");
                    $(".display_name-feedback").text(data.responseJSON.errors.display_name);
                }
                if (data.responseJSON.errors.name) {
                    $(".name").addClass("is-invalid");
                    $(".name-feedback").text(data.responseJSON.errors.name);
                }
            }
        });
    });
}

function searchuser() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#generalSearch').on('keyup', function (e) {
        let search = $('#generalSearch').val();
        $.ajax({
            data: {
                'search': search,

            },
            url: app_url + "/auth/users/search",
            type: "POST",
            dataType: 'json',
            success: function (response) {
                $("#searchresult").empty();
                response.data.forEach(function (item, index) {
                    // console.log(item, index);
                    var ht = `<tr id="row` + item.id + `">
                                        <td>` + item.name + `</td>
                                        <td>` + item.email + `</td>
                                        <td>` + item.phone + `</td>
                                        <td><span class="badge">` + item.type + `</span></td>
                                        `;
                    if (item.user) {
                        ht += `<td>` + item.user.name + `</td>
                                        <td>` + item.created_at + `</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a>
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="/auth/users/` + item.id + `/edit"><i class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-primary"  onclick="delete_alert(` + item.id + `);" ><i class="ri-delete-bin-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            `;
                    } else {
                        ht += `<td></td>
                                        <td>` + item.created_at + `</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a>
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="/auth/users/` + item.id + `/edit"><i class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-primary" onclick="delete_alert(` + item.id + `);" ><i class="ri-delete-bin-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            `;
                    }
                    $('#searchresult').append(ht);
                });


            },
            error: function (data) {

            }
        });
    });
}

function searchrole() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#generalroleSearch').on('keyup', function (e) {
        let search = $('#generalroleSearch').val();
        console.log(search);
        $.ajax({
            data: {
                'search': search,

            },
            url: app_url + "/auth/roles/search",
            type: "POST",
            dataType: 'json',
            success: function (response) {
                $("#searchroleresult").empty();
                response.data.forEach(function (item, index) {
                    // console.log(item, index);
                    var ht = `<tr id="row` + item.id + `">
                                        <td>` + item.name + `</td>
                                        <td>` + item.guard_name + `</td>
                                        <td>` + item.display_name + `</td>
                                        <td>` + item.created_at + `</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a>
                                                <a class="iq-bg-primary update-item" data-toggle="modal" data-target=".update-role" rel="` + item.id + `" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-primary"   onclick="delete_alert(` + item.id + `);" ><i class="ri-delete-bin-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            `;
                    $('#searchroleresult').append(ht);
                });


            },
            error: function (data) {

            }
        });
    });
}

function searchpermission() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#generalpermissionSearch').on('keyup', function (e) {
        let search = $('#generalpermissionSearch').val();
        console.log(search);
        $.ajax({
            data: {
                'search': search,

            },
            url: app_url + "/auth/permissions/search",
            type: "POST",
            dataType: 'json',
            success: function (response) {
                $("#searchpermissionresult").empty();
                response.data.forEach(function (item, index) {
                    // console.log(item, index);
                    var ht = `<tr id="row` + item.id + `">
                                        <td>` + item.name + `</td>
                                        <td>` + item.guard_name + `</td>
                                        <td>` + item.display_name + `</td>
                                        <td>` + item.group + `</td>
                                        <td>` + item.created_at + `</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a>
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="/auth/permissions/` + item.id + `/edit"><i class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-primary"  onclick="delete_alert(` + item.id + `);" ><i class="ri-delete-bin-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            `;
                    $('#searchpermissionresult').append(ht);
                });


            },
            error: function (data) {

            }
        });
    });
}


function searchpackage() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#generalpackageSearch').on('keyup', function (e) {
        let search = $('#generalpackageSearch').val();
        console.log(search);
        $.ajax({
            data: {
                'search': search,

            },
            url: app_url + "/auth/packages/search",
            type: "POST",
            dataType: 'json',
            success: function (response) {
                $("#searchpackageresult").empty();
                response.data.forEach(function (item, index) {
                    // console.log(item, index);
                    var ht = `<tr id="row` + item.id + `">
                                        <td>` + item.name + `</td>
                                        <td>` + item.type + `</td>
                                        <td>` + item.desc + `</td>
                                        <td>` + item.price_monthly + `</td>
                                        <td>` + item.price_yearly + `</td>
                                        <td>`;
                    if (item.is_offer == 1) {
                        ht += 'True';
                    } else {
                        ht += 'False';
                    }
                    ht += `</td>
                                        <td>` + item.start_date + `</td>
                                        <td>` + item.end_date + `</td>
                                        <td>` + item.created_at + `</td>

                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Item" href="/saas/packages/items/` + item.id + `"><i class="ri-user-add-line"></i></a>
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="/saas/packages/` + item.id + `/edit"><i class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-primary"  onclick="delete_alert(` + item.id + `);" ><i class="ri-delete-bin-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            `;
                    $('#searchpackageresult').append(ht);
                });


            },
            error: function (data) {

            }
        });
    });
}


function searchfeature() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#generalfeatureSearch').on('keyup', function (e) {
        let search = $('#generalfeatureSearch').val();
        console.log(search);
        $.ajax({
            data: {
                'search': search,

            },
            url: app_url + "/auth/features/search",
            type: "POST",
            dataType: 'json',
            success: function (response) {
                $("#searchfeatureresult").empty();
                response.data.forEach(function (item, index) {
                    // console.log(item, index);
                    var ht = `<tr id="row` + item.id + `">
                                        <td>` + item.name + `</td>
                                        <td>` + item.price + `</td>
                                         <td>`;
                    if (item.active == 1) {
                        ht += 'True';
                    } else {
                        ht += 'False';
                    }
                    ht += `</td>
                                        <td>` + item.created_at + `</td>

                                    </tr>
                            `;
                    $('#searchfeatureresult').append(ht);
                });


            },
            error: function (data) {

            }
        });
    });
}

function searchmodel() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#generalmodelSearch').on('keyup', function (e) {
        let search = $('#generalmodelSearch').val();
        // console.log(search);
        $.ajax({
            data: {
                'search': search,
            },
            url: app_url + "/auth/models/search",
            type: "POST",
            dataType: 'json',
            success: function (response) {
                $("#searchmodelresult").empty();
                response.data.forEach(function (item, index) {
                    // console.log(item, index);
                    var ht = `<tr id="row` + item.id + `">
                            <td>` + item.name + `</td>
                            <td>` + item.price + `</td>
                            <td>` + item.description + `</td>
                            <td>` + item.model.name + `</td>
                             <td>`;
                    if (item.active == 1) {
                        ht += 'True';
                    } else {
                        ht += 'False';
                    }
                    ht += `</td>
                        <td>` + item.created_at + `</td>
                        <td>
                            <div class="flex align-items-center list-user-action">
                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="/saas/models/` + item.id + `/edit"><i class="ri-pencil-line"></i></a>
                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="delete_alert(` + item.id + `);" ><i class="ri-delete-bin-line"></i></a>
                            </div>
                        </td>
                    </tr>
                    `;
                    $('#searchmodelresult').append(ht);
                });


            },
            error: function (data) {

            }
        });
    });
}


//==================== Delete Option ===================================//
var Delete_Key = 0;

function delete_alert(val) {
    $('#myModalDelete').modal('show');
    Delete_Key = val;
}


function assign_alert(val, branches) {
    $('#myModalAssign').modal('show');
    $('#branch_id').val(branches);
    $('#user_model_id').val(val);
    $("#branch_id").select2();

}

// function assign_user_to_branch_model_alert(val,u_brs,branches,regions) {
//
//     $('#myModalAssign').modal('show');
//     $('#user_id').val(val);
//     var user_branches = u_brs.split(',');
//     $.each(regions, function( index, value ) {
//         $.each(branches, function( index, value ) {
//             if(user_branches.includes(value.id.toString())){
//             $('.assign_select_body').append(`<option value="`+ value.id +`"  selected >`+value.name+` </option>`)
//             }else{
//                 $('.assign_select_body').append(`<option value="`+ value.id +`" >`+value.name+` </option>`)
//             }
//         });
//     });
//
//
// }

function assign_user_to_branch_model_alert(val, u_brs, branches, regions) {
    var direction= $('html').attr('dir');
    var trans_Check_All;
    if(direction == "rtl"){
        trans_Check_All = "تحديد الكل";
    }
    else{
        trans_Check_All = "Check All";
    }
    $('#myModalAssign .assign_body .tab-pane').remove();
    $('#myModalAssign').modal('show');
    $('#user_id').val(val);
    var user_branches = u_brs.split(',');
    $.each(regions, function (index, value) {
        var $element = $('<div class="tab-pane fade' + (index == 0 ? 'show active' : '') + '" id="home-' + value.id + '" role="tabpanel" aria-labelledby="home-tab">' +
            '<div class="row join">' +
            '<div class="col-md-12 mx-0 px-0 my-3 border-bottom">' +
            '<div class="col-md-6 col-lg-4">' +
            '<label class="custom-checkbox">'+trans_Check_All+' <input type="checkbox"  class="checkall" /> <span class="checkmark"></span></label>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>');

        $.each(value.branches, function (i, br) {
            console.log(value.branches.length)
            if (user_branches.includes(br.id.toString())) {
                $element.find('.join').append(`<div class="col-md-6 col-lg-4">
                <label class="custom-checkbox" id="` + br.id + `" >` + br.name + `
                <input class="branchselect" checked="checked"  type="checkbox" name="branches[]" id="` + br.name + `" value="` + br.id + `">
                <span class="checkmark"></span>
              </label><div>`);
                $('#myModalAssign .search-model').find('.custom-checkbox[rel="' + br.id + '"]').find('input[type="checkbox"]').trigger('click');
            } else {
                $element.find('.join').append(`<div class="col-md-6 col-lg-4">
                <label class="custom-checkbox" id="` + br.id + `" >` + br.name + `
                <input class="branchselect"  type="checkbox" name="branches[]" id="` + br.name + `" value="` + br.id + `">
              <span class="checkmark"></span>
              </label><div>`);
            }

        });

        $('#myModalAssign .assign_body').append($element);


    });
    set_counts_branches();
}

// set counts branches
function set_counts_branches() {
    var c = $('#myModalAssign .assign_body .tab-pane').length;
    if (c > 0) {
        for (var i = 2; i <= (c + 1); i++) {
            var co = $('.assign_body .tab-pane:nth-child(' + i + ') input[type="checkbox"]:checked').length;
            $(".assign_body .nav-tabs li:nth-child(" + (i - 1) + ") a small").html(co);
        }
    }
}


function assign_customer_to_package(package_id, user_id, request_id) {
    $('#myModalAssign').modal('show');
    $('#package_id').val(package_id);
    $('#user_id').val(user_id);
    $('#request_id').val(request_id);
}

function assign_option() {
    $("#assignform").submit();
}

function submit_form(form_id) {
    event.preventDefault();
    $("#" + form_id).submit();
}

function delete_option(url) {
    if (Delete_Key != 0) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: app_url + "/" + url + "/" + Delete_Key,
            type: 'Delete',
            async: false,
            data: {
                'id': Delete_Key
            },
            success: function (data) {
                $('#myModalDelete').modal('hide');

                var session = 'Item Deleted Successfully';
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                if (data) {

                    location.reload();

                    $('#row' + Delete_Key).css('background', '#FF4D4D');
                    $('#row' + Delete_Key).fadeOut(1200);
                    $('.item' + Delete_Key).fadeOut(1200);
                    Delete_Key = 0;
                } else {
                    $('.errdiv').show();
                    $('.err').html(data);
                    $('.errdiv').fadeOut(5000);
                }

                    var session = 'Item Deleted Successfully';
                    const Toast1 = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast1.fire({
                    icon: 'success',
                    title: session
                })

                setTimeout(function () {
                    $('.alert-cont').find('.bigo').remove();
                }, 3000);

            },
            error: function (request, status, error) {
                $('#myModalDelete').modal('hide');
                $('.errdiv').css('display', 'block');
                $('.err').text(request.responseText);

                var session = 'Item Deleted Successfully';
                const Toast2 = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast2.fire({
                    icon: 'success',
                    title: session
                });
                setTimeout(function () {
                    $('.alert-cont').find('.bigo').remove();
                }, 3000);
            }

        });
    }
}


function delete_oldrequest(url, id) {
    // alert(id);
    if (id != 0) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: app_url + "/" + url + "/" + id,
            type: 'Delete',
            async: false,
            data: {
                'id': id
            },
            success: function (data) {
                if (data == 1) {
                    $('#row' + id).css('background', '#17be9c');
                    $('#row' + id).fadeOut(1200);
                    $('.notify' + id).fadeOut(1200);
                } else {
                    $('.errdiv').show();
                    $('.err').html(data);
                    $('.errdiv').fadeOut(5000);
                }
            },
            error: function (request, status, error) {
                $('#myModalDelete').modal('hide');
                $('.errdiv').css('display', 'block');
                $('.err').text(request.responseText);
            }

        });
    }
}

//========================= End Delete Option ============================//


$('#myModalAssign .nav-tabs .nav-link').on('click',function (){
    var chekedInputs = $($(this).attr('href')).find('.col-md-6.col-lg-4 input:checked').length;
    var length = $($(this).attr('href')).find('.col-md-6.col-lg-4').length;
   if(length <= 1){
       console.log(length)
       $($(this).attr('href')).html('<div class="noBrache"><i class="fas fa-code-branch"></i> <h2> No Branch available <small>No Branch available No Branch available</small></h2></div>');
   }
});

