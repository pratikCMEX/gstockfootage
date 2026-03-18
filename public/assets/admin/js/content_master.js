$(document).ready(function () {

    $("#content_master_form").validate({
        ignore: [],

        rules: {
            title: {
                required: true,
                maxlength: 255
            }
        },

        messages: {
            title: {
                required: "Please enter title",
                maxlength: "Max 255 characters allowed"
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
            form.submit();
        }
    });

    // ✅ Section validation loop
    for (let i = 0; i < 4; i++) {

        // Title required
        $(`[name="sections[${i}][title]"]`).rules("add", {
            required: true,
            messages: {
                required: "Enter section title"
            }
        });

        // Subtitle required
        $(`[name="sections[${i}][sub_title]"]`).rules("add", {
            required: true,
            messages: {
                required: "Enter section subtitle"
            }
        });

        // Image validation
        $(`[name="sections[${i}][image]"]`).rules("add", {
            required: function () {
                // Only required if no old image exists
                let hasOldImage = $(`[name="sections[${i}][image]"]`)
                    .closest('.card')
                    .find('img').length > 0;

                return !hasOldImage;
            },
            extension: "jpg|jpeg|png|gif|webp",
            messages: {
                required: "Please select image",
                extension: "Only JPG, PNG, GIF, WEBP allowed"
            }
        });
    }

});