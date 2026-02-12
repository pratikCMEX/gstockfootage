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
      required: "Please enter your name",
      minlength: "Name must be at least 3 characters",
    },
    email: {
      required: "Please enter your email",
      email: "Enter a valid email",
    },
    subject: {
      required: "Please enter subject",
      minlength: "Subject must be at least 5 characters",
    },
    message: {
      required: "Please enter message",
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
