var base_url = $("#base_url").val();

/* ---------------- LICENSE FORM VALIDATION ---------------- */

var base_url = $("#base_url").val();

/* ---------------- FORM VALIDATION ---------------- */

var validator = $("#license_form").validate({
    onkeyup: false,
    ignore: [],

    rules: {
        name: {
            required: true,
            maxlength: 30,
            remote: {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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
        title: { required: true },
        product_quality_id: { required: true },
        price: { required: true },
        plan_price: { required: true },
        quality: { required: true },
        "description[]": { required: true },
    },

    messages: {
        name: {
            required: "Please enter License name",
            maxlength: "Please enter License name less than 30 characters",
            remote: "This License already exists",
        },
        title: { required: "Please enter License title" },
        product_quality_id: { required: "Please select product quality" },
        price: { required: "Please enter License price" },
        plan_price: { required: "Please enter Plan price" },
        quality: { required: "Please enter Quality" },
        "description[]": { required: "Please enter Description" },
    },

    errorClass: "text-danger",
    errorElement: "span",

    errorPlacement: function (error, element) {
        if (element.hasClass("description-field")) {
            error.insertAfter(element);
        } else {
            error.insertAfter(element);
        }
    },

    highlight: function (element) {
        $(element).addClass("is-invalid");
    },

    unhighlight: function (element) {
        $(element).removeClass("is-invalid");
    }
});



$('#add').on('click', function () {

    var html = $('.newRow').html();
    var newRow = $(html);

    $("#addHtml").append(newRow);

    newRow.find(".description-field").rules("add", {
        required: true,
        messages: {
            required: "Please enter Description"
        }
    });

});

/* ---------------- REMOVE DESCRIPTION ---------------- */

$(document).on('click', '.remove', function () {
    $(this).closest('.newhtml').remove();
});

/* ---------------- DELETE LICENSE ---------------- */

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

/* ---------------- MOST POPULAR TOGGLE ---------------- */

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

/* ---------------- MULTIPLE DELETE ---------------- */

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
                    $("#delete-selected").hide();

                    $("#license-table").DataTable().ajax.reload();
                },
            });

        }

    });

});