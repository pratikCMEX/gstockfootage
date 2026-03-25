var base_url = $("#base_url").val();

var loadFile = function (event) {
  var output = document.getElementById("preview_image");
  output.src = URL.createObjectURL(event.target.files[0]);
  $(".gift_image_validation").text("");
  $(".banner_image_validation").text("");
};

$("#add_banner_form").validate({
  onkeyup: false,
  rules: {
    title: {
      required: true,
    },
    image: {
      required: true,
      extension: "jpg|jpeg|png|webp",
    },
  },
  messages: {
    title: {
      required: "Please enter title",
    },
    image: {
      required: "Please select  image",
      extension: "Please upload only png/jpg/jpeg",
    },
  },
  normalizer: function (value) {
    return $.trim(value);
  },

  errorClass: "text-danger",
  errorElement: "span",
  highlight: function (element) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
  submitHandler: function (form) {
    $(form)
      .find('button[type="submit"]')
      .prop("disabled", true)
      .text("Please wait...");

    form.submit();
  },
});
