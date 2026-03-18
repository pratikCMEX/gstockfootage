$(document).ready(function () {
CKEDITOR.replace('description');

CKEDITOR.on('instanceReady', function (event) {
    if (event.editor.name === 'description') {
        event.editor.on('change', function () {
            event.editor.updateElement();
        });
    }
});
    // About Us Form Validation
    $("#about_us_form").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                maxlength: 255
            },
            heading: {
                required: true,
                maxlength: 255
            },
            description: {
               checkDescription: true,
                minlength: 10
            },
            image: {
                required: function (element) {
                    // Only required if no existing image
                    return $("#id").val() === '';
                },
                accept: "image/jpeg,image/png,image/jpg,image/gif,image/webp",
                filesize: 5 // 5MB max
            }
        },
        messages: {
            title: {
                required: "Please enter title",
                maxlength: "Title cannot exceed 255 characters"
            },
            heading: {
                required: "Please enter heading",
                maxlength: "Heading cannot exceed 255 characters"
            },
            description: {
                required: "Please enter description",
                minlength: "Description must be at least 10 characters"
            },
            image: {
                required: "Please select an image",
                accept: "Please select a valid image file (jpg, jpeg, png, gif, webp)",
                filesize: "Image size must be less than 5MB"
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
        ignore: [],
        submitHandler: function (form) {
            // Update CKEditor textarea before submission
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }



            // Submit the form normally
            form.submit();
        }
    });

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
});
