// alert();
function changeType(type) {
  let fileInput = document.getElementById("fileInput");

  if (type === "image") {
    fileInput.accept = "image/*";
  } else {
    fileInput.accept = "video/mp4,video/x-m4v,video/*";
  }
}
$(document).on("change", "#fileInput", function (e) {
  let file = this.files[0];
  if (!file) return;

  let url = URL.createObjectURL(file);

  if (file.type.startsWith("image")) {
    $("#preview_image").attr("src", url).show();

    $("#preview_video").hide().attr("src", "");
  } else {
    $("#preview_video").attr("src", url).show()[0].load(); // reload video player

    $("#preview_image").hide().attr("src", "");
  }
});

var loadFile = function (event) {
  var output = document.getElementById("preview_image");
  output.src = URL.createObjectURL(event.target.files[0]);
  $(".gift_image_validation").text("");
  $(".banner_image_validation").text("");
};

$(document).on("click", ".preview-image", function () {
  const src = $(this).data("src");
  const img = $("#previewImage");

  img.attr("src", src);
  new bootstrap.Modal(document.getElementById("imagePreviewModal")).show();

  $("#imagePreviewModal").on("hidden.bs.modal", function () {
    document.activeElement?.blur();
  });
});

$(document).on("change", "#category", function () {
  let categoryId = $(this).val();

  $("#subcategory").html("<option>Loading...</option>");

  if (categoryId != "") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: base_url + "/get-subcategories/" + categoryId,
      type: "GET",
      success: function (data) {
        let html = '<option value="">Choose SubCategory...</option>';
        console.log(data);

        $.each(data, function (key, subcat) {
          html += `<option value="${subcat.id}">${subcat.name}</option>`;
        });

        $("#subcategory").html(html);
      },
    });
  } else {
    $("#subcategory").html('<option value="">Choose SubCategory...</option>');
  }
});

function initProductValidation(formId, isFileRequired = true) {
  $(formId).validate({
    ignore: [],
    rules: {
      category: { required: true },
      name: { required: true },
      price: { required: true, number: true },
      description: { required: true },

      file: {
        required: isFileRequired,
        // fileTypeByProductType: true,
      },
    },

    messages: {
      category: "Please select category",
      name: "Please enter product name",
      price: "Please enter price",
      description: "Please enter description",
      file: {
        required: "Please upload a file",
      },
    },

    normalizer: function (value) {
      return $.trim(value);
    },

    errorClass: "text-danger",
    errorElement: "span",
    validClass: "is-valid",

    highlight: function (element) {
      if ($(element).attr("data-role") === "tagsinput") {
        $(element)
          .closest(".mb-3")
          .find(".bootstrap-tagsinput")
          .addClass("form-control is-invalid");
      } else {
        $(element).addClass("is-invalid");
      }
    },

    unhighlight: function (element) {
      if ($(element).attr("data-role") === "tagsinput") {
        $(element)
          .closest(".mb-3")
          .find(".bootstrap-tagsinput")
          .removeClass("form-control is-invalid");
      } else {
        $(element).removeClass("is-invalid");
      }
    },

    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");

      if (element.attr("data-role") === "tagsinput") {
        error.insertAfter(element.siblings(".bootstrap-tagsinput"));
      } else {
        error.insertAfter(element);
      }
    },

    submitHandler: function (form) {
      $(form)
        .find('button[type="submit"]')
        .prop("disabled", true)
        .text("Please wait...");

      $("#loader").css("display", "flex");
      form.submit();
    },
  });
}

// ADD PRODUCT → file required
initProductValidation("#add_product_form", true);

// EDIT PRODUCT → file optional
initProductValidation("#edit_product_form", false);

$(document).on("click", ".video-thumbnail", function () {
  const videoUrl = $(this).data("video");
  const modal = new bootstrap.Modal(document.getElementById("videoModal"));

  const videoElement = $("#modalVideo")[0];
  const sourceElement = $("#modalVideo source");

  sourceElement.attr("src", videoUrl);

  videoElement.load();
  videoElement.play();

  modal.show();

  $("#videoModal").on("hidden.bs.modal", function () {
    videoElement.pause();
    sourceElement.attr("src", "");
    videoElement.load();
  });
});

function previewVideo(event) {
  const file = event.target.files[0];
  if (!file) return;

  if (!file.type.startsWith("video/")) {
    event.target.value = "";
    return;
  }

  const videoPreview = document.getElementById("preview_video");
  videoPreview.style.display = "block";
  videoPreview.src = URL.createObjectURL(file);
  videoPreview.load();
}
