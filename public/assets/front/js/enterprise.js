$("#quoteRequestForm").validate({
  rules: {
    first_name: {
      required: true,
    },
    last_name: {
      required: true,
    },
    phone_number: {
      required: true,
      minlength: 10,
      maxlength: 15,
    },
    email: {
      required: true,
      email: true,
    },
    company: {
      required: true,
    },
    job_role: {
      required: true,
    },
    job_function: {
      required: true,
    },
    company_size: {
      required: true,
    },
    country: {
      required: true,
    },
    state: {
      required: true,
    },
    product_interest: {
      required: true,
    },
  },

  messages: {
    first_name: {
      required: "Please enter First Name",
    },
    last_name: {
      required: "Please enter Last Name",
    },
    phone_number: {
      required: "Please enter Phone Number",
      minlength: "Phone Number Must Be At Least 10 Digits",
      maxlength: "Phone Number Cannot Exceed 15 Digits",
    },
    email: {
      required: "Please enter Business  Email Address",
      email: "Enter a valid Business  Email Address",
    },
    company: {
      required: "Please enter Company",
    },
    job_role: {
      required: "Please select Job Role",
    },
    job_function: {
      required: "Please select Job Function",
    },
    company_size: {
      required: "Please select Company Size",
    },
    country: {
      required: "Please select Country",
    },
    state: {
      required: "Please enter State or province",
    },
    product_interest: {
      required: "Please select Product of Interest",
    },
  },
  errorPlacement: function (error, element) {
    if (element.attr("name") == "phone_number") {
      error.insertAfter(".enterprice_phone_input");
    } else {
      error.insertAfter(element);
    }
  },
  errorElement: "span",
  errorClass: "text-danger",

  highlight: function (element) {
    $(element).addClass("is-invalid");
  },

  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
});

$(document).ready(function () {
  var input = $("#phone")[0]; // get DOM element from jQuery

  var iti = window.intlTelInput(input, {
    initialCountry: "us",
    preferredCountries: ["us"],
    separateDialCode: true,
    utilsScript:
      "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
  });

  $("#quoteRequestForm").on("submit", function () {
    var fullPhone = iti.getNumber();

    $("#full_phone").val(fullPhone);
  });
});
