var FormValidation = function () {
    var handleCreateValidation = function () {
     $('#createuser').validate({ // initialize the plugin
        rules: {

            name: {
                required: true,
                minlength:2
            },


        },

        messages: {

            name: "Please enter a valid name ",
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
    };
    var handleEditValidation = function () {
        $('#createuser').validate({ // initialize the plugin
            rules: {

                name: {
                    required: true,
                    minlength:2
                }

            },

            messages: {

                name: "Please enter a valid name ",

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

    };





    return {
        //main function to initiate the module
        init: function () {

           var form_type = $("#form_type").val();
            if (form_type == "add") {
                handleCreateValidation();
            } else {
                handleEditValidation();
            }
        }

    };

}();

jQuery(document).ready(function () {
    FormValidation.init();
});
