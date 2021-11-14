$(document).ready(function () {

    $('#profile').validate({ // initialize the plugin

        rules: {
            email: {
                required: true,
                 email: true
            },
            name: {
                required: true,
                minlength:2
            }

        },

        messages: {

            email: "Please enter a valid email address",
            name: "Please enter a valid name "
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
