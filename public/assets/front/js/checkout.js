// ─────────────────────────────────────────────────────────────────────────────
// CORE DOWNLOAD HELPER
// Handles: single file, multiple files (zip), with optional post-download action
// ─────────────────────────────────────────────────────────────────────────────

/**
 * smartDownload(files, label, afterCallback)
 *
 * files        — array of { file_path, file_name }
 * label        — zip filename prefix e.g. "subscription" or "payment"
 * afterCallback — function to call after download completes (or null)
 */
function smartDownload(files, label, afterCallback) {
  if (!files || files.length === 0) {
    if (afterCallback) afterCallback();
    return;
  }

  if (files.length === 1) {
    // ── Single file — direct download ──
    _triggerDirectDownload(
      base_url +
        "/download/file?path=" +
        encodeURIComponent(files[0].file_path) +
        "&name=" +
        encodeURIComponent(files[0].file_name),
      files[0].file_name
    );

    if (afterCallback) setTimeout(afterCallback, 1500);
  } else {
    // ── Multiple files — zip ──
    const formData = new FormData();
    formData.append(
      "_token",
      document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    );

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
      .then(function (res) {
        const contentType = res.headers.get("content-type") || "";
        if (!res.ok || contentType.includes("application/json")) {
          return res.json().then(function (err) {
            throw new Error(err.error || "Zip failed");
          });
        }
        return res.blob();
      })
      .then(function (blob) {
        const url = window.URL.createObjectURL(blob);
        _triggerDirectDownload(
          url,
          label + "_downloads_" + Date.now() + ".zip"
        );
        window.URL.revokeObjectURL(url);

        if (afterCallback) setTimeout(afterCallback, 2000);
      })
      .catch(function (err) {
        console.error("Zip download failed:", err);
        toastr.error(err.message || "Zip download failed.");
        if (afterCallback) afterCallback();
      });
  }
}

function _triggerDirectDownload(url, filename) {
  const a = document.createElement("a");
  a.href = url;
  a.download = filename;
  a.style.display = "none";
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
}

// ─────────────────────────────────────────────────────────────────────────────
// CHECKOUT BUTTON
// ─────────────────────────────────────────────────────────────────────────────

$(document).on("click", "#processPaymentBtn", function () {
  const button = $(this);
  const email = $("#checkout_email").val();

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
      // ── Scenario 1: Pure Stripe (no subscription or 0 clips) ──
      if (response.id && !response.status) {
        Stripe(window.STRIPE_KEY).redirectToCheckout({
          sessionId: response.id,
        });
        return;
      }

      // ── Scenario 2: All covered by subscription ──
      if (response.status === "subscription") {
        const count = response.img_paths.length;
        toastr.success(
          count +
            " file" +
            (count > 1 ? "s" : "") +
            " downloaded via your subscription!",
          "Download Started"
        );

        // Single = direct, Multiple = zip
        smartDownload(response.img_paths, "subscription", function () {
          window.location.href = base_url + "/home";
        });
        return;
      }

      // ── Scenario 3: Mixed — some subscription, rest need payment ──
      if (response.status === "mixed") {
        const subCount = response.covered_count;
        const paidCount = response.paid_count;

        // Toast for subscription downloads
        toastr.success(
          subCount +
            " file" +
            (subCount > 1 ? "s" : "") +
            " downloading via subscription.",
          "Subscription Download",
          { timeOut: 5000 }
        );

        // Toast for items needing payment
        setTimeout(function () {
          toastr.warning(
            paidCount +
              " item" +
              (paidCount > 1 ? "s" : "") +
              ' ("' +
              response.paid_item_titles +
              '") require payment. Redirecting...',
            "Payment Required",
            { timeOut: 6000 }
          );
        }, 1500);

        // Download subscription items (single or zip)
        // Then redirect to Stripe for remaining
        smartDownload(response.img_paths, "subscription", function () {
          setTimeout(function () {
            Stripe(window.STRIPE_KEY).redirectToCheckout({
              sessionId: response.id,
            });
          }, 1000);
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
