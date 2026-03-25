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
            required: "Please enter Collection Name",
            remote: "This Collection Name already exists",
        },
        image: {
            required: "Please select Image",
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
$("#edit_collection_form").validate({
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
                        return $('#collection_id').val();
                    },
                },
            },
        },
        image: {
          
            extension: "jpg|jpeg|png|webp",
        },
    },
    messages: {
        name: {
            required: "Please enter Collection Name",
            remote: "This Collection  Name already exists",
        },
        image: {
            
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

$(document).on("click", ".deleteCollection", function () {

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
                url: base_url + "/admin/delete_collection",
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

                        $('#collection-table').DataTable().ajax.reload(null, false);
                    }else{
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
function toggleDeleteButton() {
    let totalCheckboxes = $(".row-checkbox").length;
    let checkedCheckboxes = $(".row-checkbox:checked").length;

    if (checkedCheckboxes > 0) {
        $("#delete-selected").show();
    } else {
        $("#delete-selected").hide();
    }

    $("#select-all").prop("checked", totalCheckboxes === checkedCheckboxes);
}

$(document).on("change", ".row-checkbox", function () {
    toggleDeleteButton();
});

$(document).on("change", "#select-all", function () {
    $(".row-checkbox").prop("checked", this.checked);
    toggleDeleteButton();
});

// $("#select-all").on("click", function () {
//     $(".row-checkbox").prop("checked", this.checked);
// });

$("#delete-selected").on("click", function () {
    let ids = [];

    $(".row-checkbox:checked").each(function () {
        ids.push($(this).val());
    });

    if (ids.length === 0) {
        toastr.success("Please select at least one user");
        return;
    }

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
                url: base_url + "/admin/delete_multiple_collection",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.success == false) {
                        toastr.error(response.message);
                    }else{
                         toastr.success(response.message);
                    }
                    $("#select-all").prop("checked", false);
                    $("#delete-selected").css("display", "none");
                    $("#collection-table").DataTable().ajax.reload();
                },
            });
        }
    });
});
