var base_url = $("#base_url").val();

$("#add_testimonials_form").validate({
    onkeyup: false,
    rules: {
        name: {
            required: true,
            // remote: {
            //     headers: {
            //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
            //             "content"
            //         ),
            //     },
            //     url: base_url + "/admin/check_subscription_plan_is_exist",
            //     type: "POST",
            //     data: {
            //         name: function () {
            //             return $("#name").val();
            //         },
            //         id: function () {
            //             return $("#subscription_plan_id").val();
            //         },
            //     },
            // },
        },

        // designation: {
        //     required: true,
        // },
        message: {
            required: true,
        },
        image:{
              accept: "image/jpeg,image/png,image/jpg,image/gif,image/webp",
        }
       
    },
    messages: {
        name: {
            required: "Please enter Name",
            // remote: "This Subscription Plan already exists",
        },
        message: {
            required: "Please enter Message",
        },
        image:{
          accept: "Only JPG, PNG, GIF, WEBP images are allowed",
        }
        

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

$("#edit_testimonials_form").validate({
    onkeyup: false,
    rules: {
        name: {
            required: true,
           
        },     
        message: {
            required: true,
        },
       
    },
    messages: {
        name: {
            required: "Please enter Name",
        },
        message: {
            required: "Please enter Message",
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
$(document).on("click", ".deleteTestimonial", function () {

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
                url: base_url + "/admin/delete_testimonial",
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

                        $('#testimonials-table').DataTable().ajax.reload(null, false);
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
        toastr.success("Please select at least one testimonial");
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
                url: base_url + "/admin/delete_multiple_testimonials",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.success == false) {
                        toastr.error(response.message);
                    }
                    else{
                         toastr.success(response.message);
                    }
                    $("#select-all").prop("checked", false);
                    $("#delete-selected").css("display", "none");
                    $("#testimonials-table").DataTable().ajax.reload();
                },
            });
        }
    });
});
$(document).on('change', '.toggle-active-status', function () {

    var id = $(this).data('id');
    var status = $(this).is(':checked') ? '1' : '0';
        
    $.ajax({
        url: base_url + "/admin/change_active_status",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id,
            status: status
        },
        success: function (response) {
            if (response.success) {
                if (status == 1) {
                    toastr.success('Change Status Active Successfully');
                } else {
                    toastr.success('Change Status Inactive Successfully');
                }
            }
        }
    });

});