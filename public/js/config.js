/***** Config function for settigs *****/
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function setUserSetting(col, val) {
    $.ajax({
        url: app_url + '/user_settings/' + col,
        type: 'POST',
        data: {
            value: val,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        dataType: "JSON",
        success: function (result) {
            console.log(result);
        }
    });

}

function updateConfigSetting(data) {

    $.ajax({
        url: app_url + '/customer/config/update',
        type: 'POST',
        data: {
            key: data.key??'chart',
            value: data.value??'bar',
            view: data.view,
            model_type: data.model_type,
            active: data.active,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        dataType: "JSON",
        success: function (result) {
            console.log(result);
        }
    });

}
