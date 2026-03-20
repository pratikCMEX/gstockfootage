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
      // ── Pure Stripe ──
      if (response.id && !response.status) {
        let stripe = Stripe(
          "pk_test_51SDJ0XPFNEui4O6lYW0lfpMqX8CuqElafy5JYngSpTY9lHeBZuAA1NIjhJJLlW5mY3TA9CBBq1y8xCvO1BymumuX00RirZPC2S"
        );
        stripe.redirectToCheckout({ sessionId: response.id });
        return;
      }

      // ── Pure subscription ──
      if (response.status === "subscription") {
        toastr.success("All items downloaded via your subscription!");
        triggerDownloads(response.img_paths, function () {
          window.location.href = base_url + "/home";
        });
        return;
      }

      // ── Mixed ──
      if (response.status === "mixed") {
        // ✅ Show success for subscription items
        toastr.success(
          response.covered_count + " item(s) downloaded via your subscription!",
          "Download Started",
          { timeOut: 5000 }
        );

        // ✅ Show warning for items that need payment
        setTimeout(function () {
          toastr.warning(
            '"' +
              response.paid_item_titles +
              '" require payment. Redirecting to checkout...',
            "Payment Required for " + response.paid_count + " item(s)",
            { timeOut: 6000 }
          );
        }, 1500);

        // ✅ Trigger downloads for subscription items
        triggerDownloads(response.img_paths, function () {
          // ✅ After downloads start, redirect to Stripe for remaining
          setTimeout(function () {
            let stripe = Stripe(
              "pk_test_51SDJ0XPFNEui4O6lYW0lfpMqX8CuqElafy5JYngSpTY9lHeBZuAA1NIjhJJLlW5mY3TA9CBBq1y8xCvO1BymumuX00RirZPC2S"
            );
            stripe.redirectToCheckout({ sessionId: response.id });
          }, 2000);
        });

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

// ── Trigger sequential downloads, then call callback when done ──
function triggerDownloads(files, callback) {
  if (!files || files.length === 0) {
    if (callback) callback();
    return;
  }

  files.forEach(function (file, index) {
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

      // ── Call callback after last file ──
      if (index === files.length - 1 && callback) {
        setTimeout(callback, 1500);
      }
    }, index * 2000);
  });
}
