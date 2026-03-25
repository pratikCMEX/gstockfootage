var base_url = $("#base_url").val();

$("#add_user_form").validate({
  // onkeyup: false,
  rules: {
    first_name: {
      required: true,
    },
    last_name: {
      required: true,
    },
    email: {
      required: true,
      email: true,
      remote: {
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/admin/check_user_is_exist",
        type: "POST",
        data: {
          category_name: function () {
            return $("input[name='email']").val();
          },
          id: function () {
            return null;
          },
        },
      },
    },
    password: {
      required: true,
    },
  },
  messages: {
    first_name: {
      required: "Please enter First Name",
    },
    last_name: {
      required: "Please enter Last Name",
    },
    email: {
      required: "Please enter Email",
      email: "Please enter  valid Email",
      remote: "This email already exists",
    },
    password: {
      required: "Please enter  Password",
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

// let typingTimer;
// const doneTypingInterval = 1000;

// $(document).on("keyup", "input[name='name']", function () {
//     clearTimeout(typingTimer);
//     typingTimer = setTimeout(function () {
//         $("input[name='name']").valid();
//     }, doneTypingInterval);
// });

$(document).on("click", ".deleteUser", function () {
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
        url: base_url + "/admin/delete_user",
        type: "post",
        data: {
          id: id,
          _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
          if (response.success) {
            Swal.fire("Deleted!", response.message, "success");

            $("#users-table").DataTable().ajax.reload(null, false);
          } else {
            Swal.fire("Error!", response.message, "error");
          }
        },
        error: function () {
          Swal.fire("Error!", "Something went wrong.", "error");
        },
      });
    }
  });
});

$(document).on("click", ".delete_userplan", function () {
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
      $("#delete_userplan_form" + id).submit();
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
        url: base_url + "/admin/delete_multiple_user",
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
          $("#users-table").DataTable().ajax.reload();
        },
      });
    }
  });
});
