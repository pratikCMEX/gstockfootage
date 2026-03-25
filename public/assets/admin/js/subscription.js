
var base_url = $("#base_url").val();

$("#subscription_form").validate({
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
                url: base_url + "/admin/check_subscription_plan_is_exist",
                type: "POST",
                data: {
                    name: function () {
                        return $("#name").val();
                    },
                    id: function () {
                        return $("#subscription_plan_id").val();
                    },
                },
            },
        },

        duration_type: {
            required: true,
        },
        duration_value: {
            required: true,

        },
        total_clips: {
            required: true,
        },
        // discount: {
        //     required: true,
        // },
        price: {
            required: true,
        }
    },
    messages: {
        name: {
            required: "Please enter Subscription Plan Name",
            maxlength: 'Please enter Subscription Plan Name less than 30 characters',
            remote: "This subscription plan already exists",
        },
        duration_type: {
            required: "Please select Duration Type",
        },
        duration_value: {
            required: "Please enter Duration Value",
        },
        total_clips: {
            required: "Please enter Total Clips",
        },
        // discount: {
        //     required: "Please enter discount",
        // },
        price: {
            required: "Please enter Price",
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
// $("#duration_value").on("input", function () {
//     this.value = this.value.replace(/[^0-9.]/g, '');
// });

$(document).on("click", ".deleteSubscriptionPlan", function () {

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
                url: base_url + "/admin/delete_subscription",
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
                        $('#subscriptionplan-table').DataTable().ajax.reload(null, false);
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

$(document).on('change', '.toggle_is_active', function () {

    var id = $(this).data('id');
    var status = $(this).is(':checked') ? '1' : '0';

    $.ajax({
        url: base_url + "/admin/change_is_active",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id,
            status: status
        },
        success: function (response) {
            if (response.success) {
                if (status == 1) {
                    toastr.success('Plan Active Successfully');
                } else {
                    toastr.success('Plan Inactive Successfully');
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
                url: base_url + "/admin/delete_multiple_subscription_plan",
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
                    $("#subscriptionplan-table").DataTable().ajax.reload();
                },
            });
        }
    });
});