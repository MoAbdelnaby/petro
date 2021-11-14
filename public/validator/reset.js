
$(document).ready(function () {

    $('#submited_form').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                 email: true
            },
            password: {
                required:true,
                minlength: 8,
            },
            password_confirmation: {
                equalTo: "#password"
            }
        },

        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            email: "Please enter a valid email address",
            password_confirmation: "password confirm should be equal to password ",
            },
        invalidHandler: function (event, validator) { //display error alert on form submit
            $(this).closest('.form-group').removeClass("has-success").addClass('has-error');
            $(this).removeClass("has-success").addClass('is-invalid');
            },



            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                $(element).removeClass("has-success").addClass('is-invalid');
            },

            unhighlight: function (element) { // revert the change done by hightlight

            },

            success: function (label, element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                $(element).removeClass('is-invalid').addClass('has-success');
            },

    });

});
