

var base_url = $("#base_url").val();
$("#license_form").validate({
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
        price: {
            required: true,
        },
        quality: {
            required: true,
        },
        description: {
            required: true,
        },


    },
    messages: {
        name: {
            required: "Please enter License name",
            remote: "This License already exists",
        },
        title: {
            required: "Please enter License title",
        },
        price: {
            required: "Please enter License price",
        },
        quality: {
            required: "Please enter Quality",
        },
        description: {
            required: "Please enter License description",
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

