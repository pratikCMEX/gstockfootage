$(document).ready(function () {
    CKEDITOR.replace('description');

    CKEDITOR.on('instanceReady', function (event) {
        if (event.editor.name === 'description') {
            event.editor.on('change', function () {
                event.editor.updateElement();
            });
        }
    });

    // Blog Form Validation
    $("#blog_form").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                maxlength: 255
            },
            author_name: {

                maxlength: 255
            },
            author_tag: {

                maxlength: 100
            },
            publish_date: {
                required: true
            },
            image: {
                required: true,
                accept: "image/jpeg,image/png,image/jpg,image/gif,image/webp",
                filesize: 5 // 5MB max
            },
            description: {
                checkDescription: true,
                minlength: 10
            }
        },
        messages: {
            title: {
                required: "Please enter blog title",
                maxlength: "Title cannot exceed 255 characters"
            },
            author_name: {

                maxlength: "Author name cannot exceed 255 characters"
            },
            author_tag: {

                maxlength: "Author tag cannot exceed 100 characters"
            },
            publish_date: {
                required: "Please select publish date"
            },
            image: {
                required: "Please select blog image",
                accept: "Only JPG, PNG, GIF, WEBP files are allowed",
                filesize: "Image size must be less than 5MB"
            },
            description: {
                minlength: "Description must be at least 10 characters long"
            }
        },
        errorClass: "text-danger",
        errorElement: "label",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function (form) {
            // Update CKEditor textarea before submission
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            // Submit the form normally
            form.submit();
        }
    });

    $("#blog_edit_form").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                maxlength: 255
            },
            author_name: {

                maxlength: 255
            },
            author_tag: {

                maxlength: 100
            },
            publish_date: {
                required: true
            },
            image: {
                required: function () {
                    return $("#old_image").val() === "";
                },
                accept: "image/jpeg,image/png,image/jpg,image/gif,image/webp",
                filesize: 5
            },
            description: {
                checkDescription: true,
                minlength: 10
            }
        },
        messages: {
            title: {
                required: "Please enter blog title",
                maxlength: "Title cannot exceed 255 characters"
            },
            author_name: {

                maxlength: "Author name cannot exceed 255 characters"
            },
            author_tag: {

                maxlength: "Author tag cannot exceed 100 characters"
            },
            publish_date: {
                required: "Please select publish date"
            },
            image: {
                required: "Please select blog image",
                accept: "Only JPG, PNG, GIF, WEBP files are allowed",
                filesize: "Image size must be less than 5MB"
            },
            description: {
                minlength: "Description must be at least 10 characters long"
            }
        },
        errorClass: "text-danger",
        errorElement: "label",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function (form) {
            // Update CKEditor textarea before submission
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            // Submit the form normally
            form.submit();
        }
    });


    // Custom validation method for CKEditor description
    $.validator.addMethod("checkDescription", function (value, element) {
        let data = CKEDITOR.instances.description.getData()
            .replace(/<[^>]*>/gi, '') // remove HTML
            .trim();

        return data.length > 0;
    }, "Please enter description");

    // Custom file size validation
    $.validator.addMethod('filesize', function (value, element, param) {
        if (element.files.length === 0) {
            return true;
        }
        return element.files[0].size <= param * 1024 * 1024; // Convert MB to bytes
    }, 'File size must be less than {0} MB');

    // Image preview on file selection
    $('#image').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                // Remove existing preview if any
                $('.image-preview').remove();

                // Add new preview
                var preview = '<img src="' + e.target.result + '" class="image-preview" style="max-width: 200px; margin-top: 10px; border-radius: 5px; border: 1px solid #ddd;">';
                $('#image').after(preview);
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove image preview if file is cleared
    $('#image').on('click', function () {
        if ($(this).val() === '') {
            $('.image-preview').remove();
        }
    });


    $(document).on("click", ".deleteBlog", function () {

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
                    url: base_url + "/admin/delete_blog",
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

                            $('#blog-table').DataTable().ajax.reload(null, false);
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
                    url: base_url + "/admin/delete_multiple_blog",
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
                        $("#blog-table").DataTable().ajax.reload();
                    },
                });
            }
        });
    });

});