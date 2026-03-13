$("#contactForm").validate({
  rules: {
    name: {
      required: true,
      minlength: 3,
    },
    email: {
      required: true,
      email: true,
    },
    subject: {
      required: true,
      minlength: 5,
    },
    message: {
      required: true,
      minlength: 10,
    },
  },

  messages: {
    name: {
      required: "Please enter Your Name",
      minlength: "Name must be at least 3 characters",
    },
    email: {
      required: "Please enter Your Email",
      email: "Enter a Valid Email",
    },
    subject: {
      required: "Please enter Subject",
      minlength: "Subject must be at least 5 characters",
    },
    message: {
      required: "Please enter Message",
      minlength: "Message must be at least 10 characters",
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



