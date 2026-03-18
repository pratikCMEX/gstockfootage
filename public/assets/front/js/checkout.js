$(document).on("click", "#processPaymentBtn", function () {
  let button = $(this);
  let email = $("#checkout_email").val();

  if (!email) {
    toastr.error("Please enter your email");
    return;
  }

  //   console.log(base_url);
  //   console.log(Stripe("{{ config('services.stripe.key') }}"));
  //   return;
  $.ajax({
    url: base_url + "/checkout/process",
    type: "POST",
    data: {
      email: email,
      _token: $('meta[name="csrf-token"]').attr("content"),
    },

    beforeSend: function () {
      button.prop("disabled", true);
      button.html(
        '<span class="spinner-border spinner-border-sm"></span> Processing...'
      );
    },

    success: function (response) {
      if (response.id) {
        // let stripe = Stripe("{{ config('services.stripe.key') }}");
        let stripe = Stripe(
          "pk_test_51SDJ0XPFNEui4O6lYW0lfpMqX8CuqElafy5JYngSpTY9lHeBZuAA1NIjhJJLlW5mY3TA9CBBq1y8xCvO1BymumuX00RirZPC2S"
        );
        stripe.redirectToCheckout({
          sessionId: response.id,
        });
      } else if (response.status == "subscription") {
        toastr.success(
          "Purchase successful! Your downloads will start shortly."
        );

        // Download all files one by one with a small delay
        if (response.img_paths && response.img_paths.length > 0) {
          console.log(response.img_paths);
          // return;

          response.img_paths.forEach(function (file, index) {
            setTimeout(function () {
              const a = document.createElement("a");
              a.href =
                base_url +
                "/download/file?path=" +
                encodeURIComponent(file.file_path) +
                "&name=" +
                encodeURIComponent(file.file_name);
              a.download = file.file_name;
              document.body.appendChild(a);
              a.click();
              document.body.removeChild(a);
            }, index * 2000);
          });
        }

        // Redirect to home after all downloads triggered
        setTimeout(function () {
          window.location.href = base_url + "/home";
        }, response.img_paths.length * 1500 + 2000);
      } else {
        toastr.error("Unable to initiate payment.");
      }
    },

    error: function (xhr) {
      toastr.error(xhr.responseJSON?.error || "Something went wrong.");
    },

    complete: function () {
      button.prop("disabled", false);
      button.html("Process to payment");
    },
  });
});
