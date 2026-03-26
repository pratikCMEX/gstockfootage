var base_url = $("#base_url").val();
var iti;

$.validator.addMethod("validPhone", function (value, element) {
    if (!value || value.trim() === '') return true;
    return iti && iti.isValidNumber();
}, "Please enter a valid phone number for selected country");
$(document).ready(function () {

    // ─── intlTelInput Init ───────────────────────────────
    var input = $("#phone")[0];

    iti = window.intlTelInput(input, {
        initialCountry: "us",
        preferredCountries: ["us"],
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    });

    //  Pre-fill after utilsScript loads
    input.addEventListener("loadUtils", function () {
        var savedCountryCode = $("#country_code").val();
        var savedPhone = $("#full_phone").val();

        if (savedCountryCode && savedPhone) {
            iti.setNumber(savedCountryCode + savedPhone);
        }
    });

    // Fallback pre-fill (if utils already loaded)
    var savedCountryCode = $("#country_code").val();
    var savedPhone = $("#full_phone").val();
    if (savedCountryCode && savedPhone) {
        iti.setNumber(savedCountryCode + savedPhone);
    }

    // ─── Update Hidden Fields ────────────────────────────
    function updateHiddenFields() {
        var countryData = iti.getSelectedCountryData();
        var dialCode = '+' + countryData.dialCode;
        var phoneOnly = $("#phone").val().replace(/[^0-9]/g, '');

        $("#full_phone").val(phoneOnly);
        $("#country_code").val(dialCode);
    }

    //  Re-validate using name attribute not id
    function reValidatePhone() {
        var validator = $('#profile_form').data('validator');
        if (validator) {
            validator.element('[name="phone_number"]'); //  name not id
        }
    }

    $("#phone").on("input change", function () {
        updateHiddenFields();
        reValidatePhone(); // 
    });

    //  Country change event
    input.addEventListener("countrychange", function () {
        updateHiddenFields();
        reValidatePhone(); //  Re-validate after country changes
    });

    $("#profile_form").on("submit", function () {
        updateHiddenFields();
    });

    // ─── Profile Form Validation ─────────────────────────
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
                validPhone: true,
            },
          
        },
        messages: {
            first_name: {
                required: "Please enter First Name",
                maxlength: "First Name cannot exceed 50 characters"
            },
            last_name: {
                required: "Please enter Last Name",
                maxlength: "Last Name cannot exceed 50 characters"
            },
            email: {
                required: "Please enter Email",
                email: "Please enter a valid Email"
            },
            phone_number: {
                validPhone: "Please enter a valid phone number for selected country",
            },
            
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "phone_number") { //  name not id
                error.insertAfter(".phone-input .iti");
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $('.save').prop('disabled', true);
            form.submit();
        },
        invalidHandler: function () {
            $('.save').prop('disabled', false);
        }
    });

    // ─── Password Form Validation ────────────────────────
    $('#password_form').validate({
        errorClass: 'text-danger',
        rules: {
            current_password: {
                required: true,
                minlength: 6,
                remote: {
                    url: base_url + "/affiliate/check_affiliate_password",
                    type: "post",
                    data: {
                        id: function () {
                            return $("input[name='id']").val();
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
                required: "Please enter Current Password",
                minlength: "Current Password must be at least 6 characters",
                remote: "Entered Password is incorrect"
            },
            new_password: {
                required: "Please enter New Password",
                minlength: "New Password must be at least 6 characters",
                notEqualTo: "New Password and Current Password cannot be same"
            },
            confirm_password: {
                required: "Please enter Confirm Password",
                minlength: "Confirm Password must be at least 6 characters",
                equalTo: "New Password and Confirm Password does not match"
            },
        },
        submitHandler: function (form) {
            $('.save').prop('disabled', true);
            form.submit();
        },
        invalidHandler: function () {
            $('.save').prop('disabled', false);
        }
    });

});