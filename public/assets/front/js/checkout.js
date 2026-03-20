$(document).on("click", "#processPaymentBtn", function () {
  alert(Stripe(window.STRIPE_KEY));
  return;
  let button = $(this);
  let email = $("#checkout_email").val();

  if (!email) {
    toastr.error("Please enter your email");
    return;
  }

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
        let stripe = Stripe(window.STRIPE_KEY);
        stripe.redirectToCheckout({ sessionId: response.id });
        return;
      }

      // ── Pure subscription ──
      if (response.status === "subscription") {
        toastr.success("All items downloaded via your subscription!");
        triggerDownloads(response.img_paths, null, function () {
          window.location.href = base_url + "/home";
        });
        return;
      }

      // ── Mixed — some subscription, some need payment ──
      if (response.status === "mixed") {
        toastr.success(
          response.covered_count + " item(s) downloaded via your subscription!",
          "Download Started",
          { timeOut: 5000 }
        );

        setTimeout(function () {
          toastr.warning(
            '"' +
              response.paid_item_titles +
              '" require payment. Redirecting to checkout...',
            "Payment Required for " + response.paid_count + " item(s)",
            { timeOut: 6000 }
          );
        }, 1500);

        // ✅ Pass stripe session ID so zip download can redirect after
        triggerDownloads(response.img_paths, response.id, null);
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

// ─────────────────────────────────────────────────────────────
// triggerDownloads(files, stripeSessionId, callback)
//   stripeSessionId — if set, redirect to Stripe after download
//   callback        — if set, call after download (for home redirect)
// ─────────────────────────────────────────────────────────────
function triggerDownloads(files, stripeSessionId, callback) {
  if (!files || files.length === 0) {
    if (stripeSessionId) {
      redirectToStripe(stripeSessionId);
    } else if (callback) {
      callback();
    }
    return;
  }

  if (files.length === 1) {
    // ── Single file — direct download ──
    const a = document.createElement("a");
    a.href =
      base_url +
      "/download/file?path=" +
      encodeURIComponent(files[0].file_path) +
      "&name=" +
      encodeURIComponent(files[0].file_name);
    a.download = files[0].file_name;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    setTimeout(function () {
      if (stripeSessionId) {
        redirectToStripe(stripeSessionId);
      } else if (callback) {
        callback();
      }
    }, 1500);
  } else {
    // ── Multiple files — download as zip via AJAX, then redirect ──
    // ✅ Use AJAX instead of form.submit() so we can redirect after
    let formData = new FormData();
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

    files.forEach(function (file) {
      formData.append(
        "files[]",
        JSON.stringify({
          path: file.file_path,
          name: file.file_name,
        })
      );
    });

    fetch(base_url + "/download/zip", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.blob())
      .then((blob) => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "downloads_" + Date.now() + ".zip";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);

        setTimeout(function () {
          if (stripeSessionId) {
            redirectToStripe(stripeSessionId);
          } else if (callback) {
            callback();
          }
        }, 1500);
      })
      .catch(function (err) {
        console.error("Zip download failed", err);
        toastr.error("Zip download failed.");
        if (stripeSessionId) redirectToStripe(stripeSessionId);
      });
  }
}

function redirectToStripe(sessionId) {
  let stripe = Stripe(window.STRIPE_KEY);
  stripe.redirectToCheckout({ sessionId: sessionId });
}
