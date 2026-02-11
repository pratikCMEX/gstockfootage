$(document).on("click", ".preview-image", function () {
    const src = $(this).data("src");
    const img = $("#previewImage");

    img.attr("src", src);
    new bootstrap.Modal(document.getElementById("imagePreviewModal")).show();

    $("#imagePreviewModal").on("hidden.bs.modal", function () {
        document.activeElement?.blur();
    });
});
var base_url = $("#base_url").val();
var loadFile = function (event) {
    var output = document.getElementById("preview_image");
    output.src = URL.createObjectURL(event.target.files[0]);
    $(".gift_image_validation").text("");
    $(".banner_image_validation").text("");
};

$("#add_collection_form").validate({
    onkeyup: false,
    rules: {
        name: {
            required: true,
            remote: {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: base_url + "/admin/check_collection_is_exist",
                type: "POST",
                data: {
                    name: function () {
                        return $("input[name='name']").val();
                    },
                    id: function () {
                        return null;
                    },
                },
            },
        },
        image: {
            required: true,
            extension: "jpg|jpeg|png|webp",
        },
    },
    messages: {
        name: {
            required: "Please enter collection name",
            remote: "This collection already exists",
        },
        image: {
            required: "Please select a image",
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

$(document).on("click", ".delete_collection", function () {
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
            // alert();
            $("#delete_collection_form" + id).submit();
        }
    });
});
