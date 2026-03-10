

var base_url = $("#base_url").val();

// Custom validation method for individual description fields
jQuery.validator.addMethod("descriptionRequired", function(value, element) {
    // Check if any description field has a value
    var descriptionFields = $('input[name="description[]"]');
    var hasValue = false;
    
    descriptionFields.each(function() {
        if ($(this).val().trim() !== '') {
            hasValue = true;
            return false; // break the loop
        }
    });
    
    // If no fields have value, all fields should show error
    return hasValue;
}, "Please enter description");

$("#license_form").validate({
    onkeyup: false,
    rules: {
        name: {
            required: true,
            maxlength: 30,
            remote: {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: base_url + "/admin/check_license_is_exist",
                type: "POST",
                data: {
                    name: function () {
                        return $("#name").val();
                    },
                    id: function () {
                        return $("#license_id").val();
                    },
                },
            },
        },

        title: {
            required: true,

        },
        product_quality_id: {
            required: true,

        },
        price: {
            required: true,
        },
        plan_price: {
            required: true,
        },
        quality: {
            required: true,
        },
        "description[]": {
            descriptionRequired: true
        },


    },
    messages: {
        name: {
            required: "Please enter License name",
            maxlength: 'Please enter License name less than 30 characters',
            remote: "This License already exists",
        },
        title: {
            required: "Please enter License title",

        },
        product_quality_id: {
            required: "Please select product quality",

        },
        price: {
            required: "Please enter License price",
        },
        plan_price: {
            required: "Please enter Plan price",
        },
        quality: {
            required: "Please enter Quality",
        },
        "description[]": {
            descriptionRequired: "Please enter description"
        },

    },
    normalizer: function (value) {
        return $.trim(value);
    },

    errorClass: "text-danger",
    errorElement: "span",
    errorPlacement: function(error, element) {
        if (element.attr("name") == "description[]") {
            error.insertAfter(element.closest('.description-item'));
        } else {
            error.insertAfter(element);
        }
    },
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

$(document).on("click", ".deleteLicense", function () {

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
                url: base_url + "/admin/delete_license",
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


                        $('#license-table').DataTable().ajax.reload(null, false);
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

$(document).on('change', '.toggle-popular', function () {

    var id = $(this).data('id');
    var status = $(this).is(':checked') ? '1' : '0';

    $.ajax({
        url: base_url + "/admin/change_most_popular",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id,
            status: status
        },
        success: function (response) {
            if (response.success) {
                if (status == 1) {
                    toastr.success('Added to Most Popular Successfully');
                } else {
                    toastr.success('Removed from Most Popular Successfully');
                }
            }
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
                url: base_url + "/admin/delete_multiple_license",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.success == false) {
                        toastr.error(response.message);
                    } else {
                        toastr.success(response.message);
                    }
                    $("#select-all").prop("checked", false);
                    $("#delete-selected").css("display", "none");
                    $("#license-table").DataTable().ajax.reload();
                },
            });
        }
    });
});

// Description field management functions
function addDescriptionField() {
    var newField = $('<div class="description-item mb-2">' +
        '<div class="d-flex">' +
        '<input type="text" name="description[]" class="form-control" placeholder="Enter description point">' +
        '<button type="button" class="btn btn-lg btn-danger ms-2" onclick="removeDescriptionField(this)" style="width: 120px;">' +
        '<i class="fas fa-times"></i>' +
        '</button>' +
        '</div>' +
        '</div>');
    
    $('#description-container').append(newField);
    
    // Trigger validation on all description fields
    var validator = $("#license_form").validate();
    $('input[name="description[]"]').each(function() {
        validator.element(this);
    });
}

function removeDescriptionField(button) {
    $(button).closest('.description-item').remove();
    
    // Trigger validation on all description fields
    var validator = $("#license_form").validate();
    $('input[name="description[]"]').each(function() {
        validator.element(this);
    });
}

// Initialize add description button click handler
$(document).ready(function() {
    $('#add-description-btn').on('click', function() {
        addDescriptionField();
    });
    
    // Add keyup event handler for description fields
    $(document).on('keyup', 'input[name="description[]"]', function() {
        var validator = $("#license_form").validate();
        $('input[name="description[]"]').each(function() {
            validator.element(this);
        });
    });
});
