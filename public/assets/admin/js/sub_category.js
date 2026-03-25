var loadFile = function (event) {
    var output = document.getElementById("preview_image");
    output.src = URL.createObjectURL(event.target.files[0]);
    $(".gift_image_validation").text("");
    $(".banner_image_validation").text("");
};
var base_url = $("#base_url").val();
// alert(base_url);

$("#add_sub_category_form").validate({
    ignore: [],
    onkeyup: function (element) {
        clearTimeout($.data(element, "timer"));
        var wait = setTimeout(function () {
            $(element).valid();
        }, 800);
        $(element).data("timer", wait);
    },

    rules: {
        category: {
            required: true,
        },
        name: {
            required: true,
            remote: {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: base_url + "/admin/check_sub_category_is_exist",
                type: "POST",
                data: {
                    name: function () {
                        return $("input[name='name']").val();
                    },
                    id: function () {
                        return $('#subcategory_id').val();
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
        category: {
            required: "Please select Category",
        },
        name: {
            required: "Please enter Subcategory Name",
            remote: "This Subcategory Name already exists",
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
    validClass: "is-valid",

    highlight: function (element) {
        if ($(element).attr("data-role") === "tagsinput") {
            $(element)
                .closest(".mb-3")
                .find(".bootstrap-tagsinput")
                .addClass("form-control is-invalid");
        }else if ($(element).hasClass("searchable")) {
        // For Select2 or searchable dropdown
        $(element)
            .next('.select2-container')
            .find('.select2-selection')
            .addClass('is-invalid');
    } 
      
        else {
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
        }
        if (element.hasClass('searchable')) {
            error.insertAfter(element.next('.select2'));
        }
        else {
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

$("#edit_sub_category_form").validate({
    ignore: [],
    onkeyup: function (element) {
        clearTimeout($.data(element, "timer"));
        var wait = setTimeout(function () {
            $(element).valid();
        }, 800);
        $(element).data("timer", wait);
    },

    rules: {
        category: {
            required: true,
        },
        name: {
            required: true,
            remote: {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: base_url + "/admin/check_sub_category_is_exist",
                type: "POST",
                data: {
                    name: function () {
                        return $("input[name='name']").val();
                    },
                    id: function () {
                        return $('#subcategory_id').val();
                    },
                },
            },
        },
        image: {
           
            extension: "jpg|jpeg|png|webp",
        },
    },
    messages: {
        category: {
            required: "Please select Category",
        },
        name: {
            required: "Please enter Subcategory Name",
            remote: "This Subcategory Name already exists",
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
    validClass: "is-valid",

    highlight: function (element) {
        if ($(element).attr("data-role") === "tagsinput") {
            $(element)
                .closest(".mb-3")
                .find(".bootstrap-tagsinput")
                .addClass("form-control is-invalid");
        }else if ($(element).hasClass("searchable")) {
        // For Select2 or searchable dropdown
        $(element)
            .next('.select2-container')
            .find('.select2-selection')
            .addClass('is-invalid');
    } 
      
        else {
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
        }
        if (element.hasClass('searchable')) {
            error.insertAfter(element.next('.select2'));
        }
        else {
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

$(document).on("click", ".deleteSubCategory", function () {

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
                url: base_url + "/admin/delete_sub_category",
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

                        $('#subcategory-table').DataTable().ajax.reload(null, false);
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

$(document).on("click", ".preview-image", function () {
    const src = $(this).data("src");
    const img = $("#previewImage");

    img.attr("src", src);
    new bootstrap.Modal(document.getElementById("imagePreviewModal")).show();

    $("#imagePreviewModal").on("hidden.bs.modal", function () {
        document.activeElement?.blur();
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

$("#delete-selected").on("click", function () {
    let ids = [];

    $(".row-checkbox:checked").each(function () {
        ids.push($(this).val());
    });

    if (ids.length === 0) {
        toastr.success("Please select at least one subcategory");
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
                url: base_url + "/admin/delete_multiple_sub_category",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.success == false) {
                        toastr.error(response.message);
                    }
                    else {
                        toastr.success(response.message);
                    }
                    $("#select-all").prop("checked", false);
                    $("#delete-selected").css("display", "none");
                    $("#subcategory-table").DataTable().ajax.reload();
                },
            });
        }
    });
});
$(document).on('change', '#category', function () {
    $('#subcategory-table').DataTable().ajax.reload();
});
