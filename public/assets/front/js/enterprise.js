$("#quoteRequestForm").validate({
  rules: {
    first_name: {
      required: true,

    },
    last_name: {
      required: true,

    },
    phone: {
      required: true,

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
   
    product_interest: {
      required: true,

    },
  },

  messages: {
    first_name: {
      required: "Please enter first name",

    },
    last_name: {
      required: "Please enter last name",

    },
    phone: {
      required: "Please enter phone number",

    },
    email: {
      required: "Please enter email",
      email: "Enter a valid email",
    },
    company: {
      required: "Please enter company",

    },
    job_role: {
      required: "Please select job role",

    },
    job_function: {
      required: "Please select job function",

    },
    company_size: {
      required: "Please select company size",

    },
    country: {
      required: "Please select country",

    },
    
    product_interest: {
      required: "Please select product of interest",

    },
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