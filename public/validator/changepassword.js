$(document).ready(function () {

    $('#change_form').validate({ // initialize the plugin

        rules: {
            oldpassword: {
                required: true,
                minlength: 8
            },
            password: {
                required:true,
                minlength: 8
            },
            password_confirmation: {
                equalTo: "#password"
            }

        },

        messages: {
            oldpassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            password_confirmation: "password confirm should be equal to password "
            },
        invalidHandler: function (event, validator) { //display error alert on form submit
            $(this).closest('.form-group').removeClass("has-success").addClass('has-error');
            },



            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight

            },

            success: function (label, element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group

            },

    });

});
