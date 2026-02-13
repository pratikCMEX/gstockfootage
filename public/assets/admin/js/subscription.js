
$("#subscription_form").validate({
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
            //     url: base_url + "/admin/check_license_is_exist",
            //     type: "POST",
            //     data: {
            //         name: function () {
            //             return $("#name").val();
            //         },
            //         id: function () {
            //             return $("#license_id").val();
            //         },
            //     },
            // },
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
        discount: {
            required: true,
        },
         price: {
            required: true,
        }
    },
    messages: {
        name: {
            required: "Please enter Subscription Plan name",
            // remote: "This License already exists",
        },
        duration_type: {
            required: "Please enter Duration type",
        },
        duration_value: {
            required: "Please enter Duration value",
        },
        total_clips: {
            required: "Please enter Total clips",
        },
        discount: {
            required: "Please enter discount",
        },
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
var base_url = $("#base_url").val();

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
                url: base_url +"/admin/delete_subscription",
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