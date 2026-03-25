var base_url = $("#base_url").val();



$("#add_term_condition_form").validate({
    ignore: [],
    rules: {
        title: {
            required: true,
        },
        description: {
            required: true,
        },
    },
    messages: {
        title: {
            required: "Please enter Title",
        },
        description: {
            required: "Please enter Description",
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
    errorPlacement: function (error, element) {
        if (element.attr('name') === 'description') {
            // CKEditor wraps itself in a div with id="cke_FIELDNAME"
            error.insertAfter('#cke_' + element.attr('id'));
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function (form) {
        if (CKEDITOR.instances.description) {
            CKEDITOR.instances.description.updateElement();
        }
        $(form)
            .find('button[type="submit"]')
            .prop("disabled", true)
            .text("Please wait...");

        form.submit();
    },
});
if (typeof CKEDITOR !== "undefined") {
    CKEDITOR.on("instanceReady", function (e) {
        if (e.editor.name === "description") {
            e.editor.on("change", function () {
                // Sync CKEditor content back to textarea
                e.editor.updateElement();

                // Re-validate only the description field to clear error instantly
                $("#add_term_condition_form").validate().element("#description");
            });
        }
    });
}

if (typeof CKEDITOR !== "undefined") {
    CKEDITOR.on("instanceReady", function (e) {
        if (e.editor.name === "description") {
            e.editor.on("change", function () {
                // Sync CKEditor content back to textarea
                e.editor.updateElement();

                // Re-validate only the description field to clear error instantly
                $("#add_privacy_policy_form").validate().element("#description");
            });
        }
    });
}



$("#add_privacy_policy_form").validate({
   ignore: [],
    rules: {
        title: {
            required: true,
        },
        description: {
            required: true,
        },
    },
    messages: {
        title: {
            required: "Please enter Title",
        },
        description: {
            required: "Please enter Description",
        },
    },
    normalizer: function (value) {
        return $.trim(value);
    },

    errorClass: "text-danger",
    errorElement: "span",
     errorPlacement: function (error, element) {
        if (element.attr('name') === 'description') {
            // CKEditor wraps itself in a div with id="cke_FIELDNAME"
            error.insertAfter('#cke_' + element.attr('id'));
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function (element) {
        $(element).addClass("is-invalid");
    },
    unhighlight: function (element) {
        $(element).removeClass("is-invalid");
    },
    submitHandler: function (form) {
        if (CKEDITOR.instances.description) {
            CKEDITOR.instances.description.updateElement();
        }
        $(form)
            .find('button[type="submit"]')
            .prop("disabled", true)
            .text("Please wait...");

        form.submit();
    },
});
document.querySelectorAll(".ckeditor").forEach((el) => {
    CKEDITOR.replace(el);
});
