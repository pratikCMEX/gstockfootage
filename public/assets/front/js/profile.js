

var base_url = $("#base_url").val();

$(document).ready(function () {
    $('#profile_form').validate({
        errorClass: 'text-danger',
        rules: {
            first_name: {
                required: true,
                maxlength: 50,
            },
            last_name: {
                required: true,
                maxlength: 50,

            },
            email: {
                required: true,
                email: true,

            },
            phone_number: {
                required: true,
                minlength: 10,
                maxlength: 15,
                
            },
            address: {
                required: true,
            },


        },
        messages: {
            first_name: {
                required: "Please enter  First Name",
                maxlength: "First Name cannot exceed 50 characters"
            },
            last_name: {
                required: "Please enter Last Name",
                maxlength: "Last Name cannot exceed 50 characters"
            },
            email: {
                required: "Please enter Email",
                email: "Plase Enter a valid Email"

            }, phone_number: {
                required: "Please enter phone number",
                minlength: "Phone number must be at least 10 digits",
                maxlength: "Phone number cannot exceed 15 digits",
                // digits: "Please enter valid phone number (digits only)",
            },
            address: {
                required: "Please enter address",
            },

        },

        //  THIS IS THE KEY PART
        submitHandler: function (form) {

            $('.save')
                .prop('disabled', true);

            form.submit();
        },

        //  If validation fails, button stays enabled
        invalidHandler: function () {
            $('.save').prop('disabled', false);
        }
    });
});
$.validator.addMethod("notEqualTo", function (value, element, param) {
    return value !== $(param).val();
}, "Values must be different.");


$('#password_form').validate({
    errorClass: 'text-danger',
    rules: {
        current_password: {
            required: true,
            minlength: 6,
            remote: {
                url: base_url + "/check_password",
                type: "post",
                data: {
                    id: function () {
                        return $("input[name='id']").val();   // hidden user id
                    },
                    current_password: function () {
                        return $("#current_password").val();
                    },
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            }

        },
        new_password: {
            required: true,
            minlength: 6,
            notEqualTo: "#current_password"

        },
        confirm_password: {
            required: true,
            minlength: 6,
            equalTo: '#new_password',

        },

    },
    messages: {
        current_password: {
            required: "Please enter  current password",
            minlength: "current password number must be atleast 6 characters",
            remote: "Entered password is incorrect"
        },
        new_password: {
            required: "Please enter new password",
            minlength: "new password number must be atleast 6 characters",
            notEqualTo: "New password and current password cannot be same"

        },
        confirm_password: {
            required: "Please enter confirm password",
            minlength: "confirm password number must be atleast 6 characters",
            equalTo: " new password And Confirm Password Does not Match"
        },

    },

    // THIS IS THE KEY PART
    submitHandler: function (form) {

        $('.save')
            .prop('disabled', true);

        form.submit();
    },

    // If validation fails, button stays enabled
    invalidHandler: function () {
        $('.save').prop('disabled', false);
    }
});



$(document).on('click', '.cancel', function (e) {
    window.close();
})

 document.addEventListener("DOMContentLoaded", function () {

        var input = document.querySelector("#phone");

        var iti = window.intlTelInput(input, {
            initialCountry: "us",
            preferredCountries: ["us"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        document.querySelector("#profile_form").addEventListener("submit", function () {

            var fullPhone = iti.getNumber();

            document.querySelector("#full_phone").value = fullPhone;

        });

    });