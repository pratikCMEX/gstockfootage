var base_url = $("#base_url").val();

/* ---------------- LICENSE FORM VALIDATION ---------------- */

$(document).ready(function () {


    /* ---------------- FORM VALIDATION ---------------- */


    var validator = $("#license_form").validate({

        onkeyup: false,
        onfocusout: false,
        ignore: [],

        rules: {
            name: {
                required: true,
                maxlength: 30
            },
            title: {
                required: true
            },
            product_quality_id: {
                required: true
            },
            price: {
                required: true
            },
            plan_price: {
                required: true
            },
            quality: {
                required: true
            }
        },

        messages: {
            name: {
                required: "Please enter License name",
                maxlength: "Max 30 characters allowed"
            },
            title: {
                required: "Please enter License title"
            },
            product_quality_id: {
                required: "Please select product quality"
            },
            price: {
                required: "Please enter License price"
            },
            plan_price: {
                required: "Please enter Plan price"
            },
            quality: {
                required: "Please enter quality"
            }
        },

        errorElement: "span",
        errorClass: "text-danger",

        highlight: function (element) {
            $(element).addClass("is-invalid");
        },

        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },

        /*************  ✨ Windsurf Command ⭐  *************/
        /**
         * Error placement function for validation
         * 
         * @param {jQuery} error - The error element
         * @param {jQuery} element - The element that triggered the error
         */
        /*******  6c6a7098-1097-48e5-a914-4a5a88279470  *******/
        errorPlacement: function (error, element) {

            element.next("span.text-danger").remove();
            error.insertAfter(element);

        },
        submitHandler: function (form) {
            var valid = true;

            $(".description:visible").each(function () {
                if ($(this).val().trim() === "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                    if (!$(this).next("span.text-danger").length) {
                        $(this).after('<span class="text-danger">Please enter Description</span>');
                    }
                } else {
                    $(this).removeClass("is-invalid");
                    $(this).next("span.text-danger").remove();
                }
            });

            if (valid) {
                form.submit(); // ✅ only submit if all description[] fields have data
            }
        }

    });

    $(document).on("keyup", ".description", function () {

        var element = $(this);

        if (element.val().trim() !== "") {

            element.removeClass("is-invalid");

            element.next("span.text-danger").remove();

        } else {

            validator.element(this);

        }

    });
    $(document).on("blur", ".description", function () {

        var element = $(this);

        if (element.val().trim() === "") {

            if (!element.next("span.text-danger").length) {

                element.addClass("is-invalid");
                element.after('<span class="text-danger">Please enter Description</span>');

            }

        }

    });

    /* -------- DESCRIPTION VALIDATION -------- */

    function addDescriptionValidation(element) {

        if (!$(element).data('rulesAdded')) {

            $(element).rules("add", {
                required: true,
                messages: {
                    required: "Please enter Description"
                }
            });

            $(element).data('rulesAdded', true);
        }

    }

    // First field validation
    $(".description").each(function () {
        addDescriptionValidation(this);
    });


    /* -------- ADD MORE -------- */

    $(document).on("click", "#add", function () {

        var html = $(".newRow").html();

        $("#addHtml").append(html);

        var newField = $("#addHtml .description").last();

        addDescriptionValidation(newField);

    });


    /* -------- REMOVE -------- */

    $(document).on("click", ".remove", function () {

        $(this).closest('.description-item').remove();

    });


    /* -------- FORM SUBMIT -------- */
    $("#license_form").on("submit", function (e) {

        var valid = true;

        $(".description").each(function () {

            if (!validator.element(this)) {
                valid = false;
            }

        });

        if (!valid) {
            e.preventDefault();
            return false;
        }

    });
    // $("#license_form").on("submit", function (e) {

    //     var valid = true;

    //     $(".description").each(function () {

    //         if ($(this).val().trim() == "") {

    //             valid = false;

    //             if (!$(this).next("span.text-danger").length) {
    //                 $(this).after('<span class="text-danger">Please enter Description</span>');
    //             }

    //             $(this).addClass("is-invalid");

    //         } else {

    //             $(this).removeClass("is-invalid");
    //             $(this).next("span.text-danger").remove();
    //         }

    //     });

    //     if (!valid) {
    //         e.preventDefault();
    //         return false;
    //     }

    // });


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

});