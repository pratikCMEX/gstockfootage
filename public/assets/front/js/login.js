$("#login").validate({
  rules: {
    email: {
      required: true,
      email: true,
    },
    password: {
      required: true,
      minlength: 6,
    },
  },
  messages: {
    email: {
      required: "Please enter Your Email",
      email: "Enter a Valid Email Address",
    },
    password: {
      required: "Please enter Your Password",
      minlength: "Password Must Be At Least 6 Characters",
    },
  },
  normalizer: function (value) {
    return $.trim(value);
  },

  errorClass: "text-danger",
  errorElement: "label",
  highlight: function (element) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
});

$("#resend_mail_varification").validate({
  rules: {
    email: {
      required: true,
      email: true,
    },

  },
  messages: {
    email: {
      required: "Please enter your email",
      email: "Enter a valid email address",
    },

  },
  normalizer: function (value) {
    return $.trim(value);
  },

  errorClass: "text-danger",
  errorElement: "label",
  highlight: function (element) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
});

$("#signup").validate({
  rules: {
    first_name: {
      required: true,
    },
    last_name: {
      required: true,
    },
    email: {
      required: true,
      email: true,
      remote: {
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/check_user_is_exist",
        type: "POST",
        data: {
          category_name: function () {
            return $("input[name='email']").val();
          },
          id: function () {
            return null;
          },
        },
      },
    },
    phone_number: {

      minlength: 10,
      maxlength: 15,
      digits: true,
    },

    password: {
      required: true,
      minlength: 6,
    },
  },
  messages: {
    first_name: {
      required: "Please enter First Name",
    },
    last_name: {
      required: "Please enter Last Name",
    },
    email: {
      required: "Please enter Email",
      email: "Please enter a Valid Email",
      remote: "This Email Already Exists",
    },
    phone: {

      minlength: "Phone Number Must Be At Least 10 Digits",
      maxlength: "Phone Number Cannot Exceed 15 Digits",
      digits: "Please Enter Valid Phone Number (Digits Only)",
    },

    password: {
      required: "Please enter Your Password",
      minlength: "Password Must Be At Least 6 Characters",
    },
  },

  normalizer: function (value) {
    return $.trim(value);
  },

  errorClass: "text-danger",
  errorElement: "label",
  highlight: function (element) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
});

$("#send_forget_link").validate({
  rules: {
    email: {
      required: true,
      email: true,
      remote: {
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/check_user_is_valid",
        type: "POST",
        data: {
          email: function () {
            return $("input[name='email']").val();
          },
        },
      },
    },
  },
  messages: {
    email: {
      required: "Please enter email",
      email: "Please enter a valid email",
      remote: "User doesn't exist with this email",
    },
  },

  normalizer: function (value) {
    return $.trim(value);
  },

  errorClass: "text-danger",
  errorElement: "label",
  highlight: function (element) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
});

// Handle tab switching and show/hide resend verification section
$(document).ready(function () {

  // Tab switching functionality
  $('.tab-btn').click(function () {
    const tab = $(this).data('tab');

    // Remove active class from all tabs and forms
    $('.tab-btn').removeClass('active');
    $('.auth-form').removeClass('active');

    // Add active class to clicked tab and corresponding form
    $(this).addClass('active');
    $('#' + tab).addClass('active');

    // Show/hide resend verification section
    if (tab === 'login') {
      $('#resend-verification-section').show();
    } else {
      $('#resend-verification-section').hide();
    }
  });

  // Initialize: show resend verification section only if login tab is active
  if ($('#login').hasClass('active')) {
    $('#resend-verification-section').show();
  } else {
    $('#resend-verification-section').hide();
  }
});

$("#change_forget_pass").validate({
  rules: {
    password: {
      required: true,
      minlength: 6,
    },
    password_confirmation: {
      required: true,
      equalTo: "#password",
    },
  },
  messages: {
    password: {
      required: "Please enter your password",
      minlength: "Password must be at least 6 characters long",
    },
    password_confirmation: {
      required: "Please confirm your password",
      equalTo: "Passwords do not match",
    },
  },
  errorElement: "label",
  errorClass: "text-danger",
  highlight: function (element) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
});

 document.addEventListener("DOMContentLoaded", function () {

        var input = document.querySelector("#phone");

        var iti = window.intlTelInput(input, {
            initialCountry: "us",
            preferredCountries: ["us"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        document.querySelector("#signup").addEventListener("submit", function () {

            var fullPhone = iti.getNumber();

            document.querySelector("#full_phone").value = fullPhone;

        });

    });
