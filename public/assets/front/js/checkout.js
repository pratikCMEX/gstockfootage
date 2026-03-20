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
      // ── All via Stripe (no subscription) ──
      if (response.id && !response.status) {
        let stripe = Stripe(
          "pk_test_51SDJ0XPFNEui4O6lYW0lfpMqX8CuqElafy5JYngSpTY9lHeBZuAA1NIjhJJLlW5mY3TA9CBBq1y8xCvO1BymumuX00RirZPC2S"
        );
        stripe.redirectToCheckout({ sessionId: response.id });
        return;
      }

      // ── All via subscription ──
      if (response.status === "subscription") {
        toastr.success("Purchase successful! Downloads starting...");
        triggerDownloads(response.img_paths, function () {
          window.location.href = base_url + "/home";
        });
        return;
      }

      // ── Mixed — some subscription, some need payment ──
      if (response.status === "mixed") {
        toastr.info(response.message);

        // ✅ Download subscription items first
        // triggerDownloads(response.img_paths, function () {
        //   // ✅ Then redirect to Stripe for remaining items
        //   toastr.info("Redirecting to payment for remaining items...");
        //   setTimeout(function () {
        //     let stripe = Stripe(
        //       "pk_test_51SDJ0XPFNEui4O6lYW0lfpMqX8CuqElafy5JYngSpTY9lHeBZuAA1NIjhJJLlW5mY3TA9CBBq1y8xCvO1BymumuX00RirZPC2S"
        //     );
        //     stripe.redirectToCheckout({ sessionId: response.id });
        //   }, 1000);
        // });
        return;
      }

      toastr.error("Unable to initiate payment.");
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
