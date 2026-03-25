var base_url = $("#base_url").val();
var iti;

$('#affiliate_setting_form').validate({
    rules: {
        commission_amount: {
            required: true,
            number: true,
            min: 0
        }
    },
    messages: {
        commission_amount: {
            required: 'Please enter commission amount',
            number: 'Please enter a valid number',
            min: 'Amount must be 0 or greater'
        }
    },
    errorClass: 'text-danger',
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('text-danger d-block mt-1');

        if (element.closest('.input-group').length) {
            error.insertAfter(element.closest('.input-group'));
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function (element) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element) {
        $(element).removeClass('is-invalid');
    },
    submitHandler: function (form) {
        form.submit();
    }
});

$.validator.addMethod("validPhone", function (value, element) {
    if (!value || value.trim() === '') return true;
    return iti && iti.isValidNumber();
}, "Please enter a valid phone number for selected country");

$(document).ready(function () {

    if ($("#phone").length) {
        var input = $("#phone")[0];

        iti = window.intlTelInput(input, {
            initialCountry: "us",
            preferredCountries: ["us"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
        });

        // ✅ Pre-fill after utilsScript loads
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

        $("#affiliate_form").on("submit", function () {
            updateHiddenFields();
        });
    }

    // ─── Profile Form Validation ─────────────────────────

    $('#affiliate_form').validate({
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
                remote: {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: base_url + "/admin/check_affiliate_is_exist",
                    type: "POST",
                    data: {

                        email: function () {
                            return $("input[name='email']").val();
                        },
                        id: function () {
                            return $("input[name='user_id']").val() ?? null;
                        },
                    },
                },
            },

            password: {
                required: $('#affiliate_form input[name="user_id"]').length === 0,
                minlength: 6
            },
            phone_number: {
                validPhone: "Please enter a valid phone number for selected country",
            },
            address: {

                minlength: 10
            },
            commission_type: {
                required: true,

            },
            commission_value: {
                required: true,
                

            },


        },

        messages: {
            first_name: {
                required: 'Please enter First Name',
                maxlength: 'First Name must be less than 50 characters'
            },
            last_name: {
                required: 'Please enter Last Name',
                maxlength: 'Last Name must be less than 50 characters'
            },
            email: {
                required: 'Please enter Email',
                email: 'Please enter valid Email',
                remote: "This Email already exists",
            },
            password: { required: 'Please enter Password', 
                minlength: 'Minimum 6 characters' },
            phone_number: {
                validPhone: "Please enter a valid Phone Number for selected country",
            },
            address: {

                minlength: "Address must be at least 10 characters"
            },
            commission_type: {
                required: 'Please select Commission Type',
            },
            commission_value: {
                required: 'Please enter Commission Value',
            },
        },
        errorClass: 'text-danger',
        errorElement: 'span',
        highlight: function (element) { $(element).addClass('is-invalid'); },
        unhighlight: function (element) { $(element).removeClass('is-invalid'); },
        submitHandler: function (form) { form.submit(); }
    });

    $(document).on('change', '.toggle_is_active', function () {


        var id = $(this).data('id');

        var status = $(this).is(':checked') ? 'active' : 'inactive';

        $.ajax({
            url: base_url + "/admin/affiliates/toggle-status",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    if (status == 'active') {
                        toastr.success('Affiliate User Active Successfully');
                    } else {
                        toastr.success('Affiliate User Inactive Successfully');
                    }
                }
            }
        });

    });
    //  Copy referral link
    // $(document).on('click', '.copy-btn', function () {
    //     let link = $(this).data('link');
    //     navigator.clipboard.writeText(link).then(function () {
    //         toastr.success('Referral link copied!');
    //     });
    // });
    $(document).on('click', '.copy-btn', function () {
        let link = $(this).data('link');

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(link)
                .then(() => toastr.success('Referral link copied!'))
                .catch(() => fallbackCopy(link));
        } else {
            fallbackCopy(link);
        }
    });

    function fallbackCopy(text) {
        let input = document.createElement("input");
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand("copy");
        document.body.removeChild(input);

        toastr.success('Referral link copied!');
    }

    $(document).on("click", ".deleteAffiliateUser", function () {

        var id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: base_url + "/admin/affiliates/delete",
                    type: "post",
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                "Deleted!",
                                response.message,
                                "success"
                            );

                            $('#affiliate-table').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire(
                                "Error!",
                                response.message,
                                "error"
                            );
                        }
                    },
                    error: function () {
                        Swal.fire(
                            "Error!",
                            "Something went wrong.",
                            "error"
                        );
                    }
                });

            }
        });
    });

});