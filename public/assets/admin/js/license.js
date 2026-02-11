$("#add_license_form").validate({
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
                url: base_url + "/admin/check_category_is_exist",
                type: "POST",
                data: {
                    category_name: function () {
                        return $("#category_name").val();
                    },
                    id: function () {
                        return $("#category_id").val();
                    },
                },
            },
        },
    },
    messages: {
        category_name: {
            required: "Please enter category name",
            remote: "This category already exists",
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