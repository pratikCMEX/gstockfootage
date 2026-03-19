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
        $(`[name="sections[${i}][svg]"]`).rules("add", {
            required: true,
            svgFormat: true,        // custom rule below
            messages: {
                required: "Please paste SVG code",
                svgFormat:  "Invalid SVG &mdash; must start with &lt;svg&gt; and end with &lt;/svg&gt;"
            }
        });
    }

    // Custom SVG validation rule
    // $.validator.addMethod("svgFormat", function(value, element) {
    //     if (!value) return true; // optional if not required
    //     let trimmed = value.trim();
    //     return trimmed.startsWith('<svg') && trimmed.endsWith('</svg>');
    // }, "Invalid SVG — must start with <svg and end with </svg>");

    $.validator.addMethod("svgFormat", function (value) {
        const trimmed = value.trim();
        return trimmed.startsWith("<svg") && trimmed.endsWith("</svg>");
    }, "Invalid SVG format");

});