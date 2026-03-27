$(document).ready(function () {
  var base_url = $("#base_url").val();
  var searchTimeout;
  var selectedType = "all"; // for top dropdown search
  var helpSelectedType = "all"; // for help section pill search

  // ══════════════════════════════════════════════════════
  // TOP SEARCH (dropdown + .home_search)
  // ══════════════════════════════════════════════════════

  // ── Pre-fill top search on listing pages ────────────────────────

  // ── Dropdown selection ──────────────────────────────────────────
  $(document).on("click", ".content-list-menu .dropdown-item", function (e) {
    e.preventDefault();

    selectedType = $(this).data("type");
    var icon = $(this).data("icon");
    var label = $(this).data("label");

    $(".btn-icon").attr("class", icon + " btn-icon");
    $(".btn-text").text(label);

    var currentVal = $(".home_search").val().trim();
    if (currentVal.length > 0) {
      $(".home_search").trigger("keyup");
    }
  });

  // ── Top search keyup ────────────────────────────────────────────
  $(document).on("keyup", ".home_search", function () {
    var $suggestion = $(this).closest(".inp-search").find(".suggetion-search");
    $suggestion.find("ul").html("");
    var value = $(this).val().trim();

    clearTimeout(searchTimeout);

    if (value === "") {
      $suggestion.removeClass("show");
      return;
    }

    searchTimeout = setTimeout(function () {
      $.ajax({
        url: base_url + "/home_search",
        type: "GET",
        data: { search: value, type: selectedType },
        success: function (res) {
          renderSuggestions(res, $suggestion, selectedType);
        },
      });
    }, 300);
  });

  // ── Top search button ───────────────────────────────────────────
  $(document).on("click", ".search-btn", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var keyword = $(".home_search").val().trim();
    if (keyword === "") return;
    redirectToListing(keyword, selectedType);
  });

  // ── Top search Enter key ────────────────────────────────────────
  $(document).on("keydown", ".home_search", function (e) {
    if (e.key === "Enter") {
      var keyword = $(this).val().trim();
      if (keyword === "") return;
      redirectToListing(keyword, selectedType);
    }
  });

  // ── Pre-fill top search on listing pages ────────────────────────
  var params = new URLSearchParams(window.location.search);
  var q = params.get("q") || "";
  var type = params.get("type") || "all";

  if (q) {
    $(".home_search").val(q);
    selectedType = type;

    var labelMap = {
      all: { text: "All content", icon: "bi bi-grid" },
      video: { text: "Videos", icon: "bi bi-camera-video" },
      image: { text: "Photos", icon: "bi bi-image" },
    };

    if (labelMap[type]) {
      $(".btn-icon").attr("class", labelMap[type].icon + " btn-icon");
      $(".btn-text").text(labelMap[type].text);
    }
  }

  // if (window.location.search) {
  //   const cleanUrl = window.location.origin + window.location.pathname;
  //   window.history.replaceState({}, document.title, cleanUrl);
  // }
  // ══════════════════════════════════════════════════════
  // HELP SECTION SEARCH (pills + .help-search)
  // ══════════════════════════════════════════════════════

  // ── Pill selection ──────────────────────────────────────────────
  $(document).on("click", ".search-btn-filter", function () {
    $(".search-btn-filter").removeClass("active");
    $(this).addClass("active");
    helpSelectedType = $(this).data("type");

    var currentVal = $(".help-search").val().trim();
    if (currentVal.length > 0) {
      $(".help-search").trigger("keyup");
    }
  });

  // ── Help search keyup ───────────────────────────────────────────
  $(document).on("keyup", ".help-search", function () {
    var $suggestion = $(this)
      .closest(".col-lg-8, .col-md-10")
      .find(".suggetion-search");
    $suggestion.find("ul").html("");
    var value = $(this).val().trim();

    clearTimeout(searchTimeout);

    if (value === "") {
      $suggestion.removeClass("show");
      return;
    }

    searchTimeout = setTimeout(function () {
      $.ajax({
        url: base_url + "/home_search",
        type: "GET",
        data: { search: value, type: helpSelectedType },
        success: function (res) {
          renderSuggestions(res, $suggestion, helpSelectedType);
        },
      });
    }, 300);
  });

  // ── Help search button ──────────────────────────────────────────
  $(document).on("click", ".help-search-btn", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var keyword = $(".help-search").val().trim();
    if (keyword === "") return;
    redirectToListing(keyword, helpSelectedType);
  });

  // ── Help Enter key ──────────────────────────────────────────────
  $(document).on("keydown", ".help-search", function (e) {
    if (e.key === "Enter") {
      var keyword = $(this).val().trim();
      if (keyword === "") return;
      redirectToListing(keyword, helpSelectedType);
    }
  });

  // ══════════════════════════════════════════════════════
  // SHARED
  // ══════════════════════════════════════════════════════

  // ── Suggestion click → redirect ─────────────────────────────────
  $(document).on("click", ".suggetion-search li", function () {
    var keyword = $(this).data("keyword");
    var type = $(this).data("type");
    redirectToListing(keyword, type);
  });

  // ── Hide suggestions on outside click ──────────────────────────
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".inp-search, .search-container").length) {
      $(".suggetion-search").removeClass("show");
    }
  });

  // ── Shared: render suggestions into a given container ──────────
  function renderSuggestions(res, $suggestion, type) {
    let html = "";
    if (res.length > 0) {
      res.forEach(function (keyword) {
        html += `<li data-keyword="${keyword}" data-type="${type}">
                   <a href="#">${keyword}</a>
                 </li>`;
      });
      $suggestion.find("ul").html(html);
      $suggestion.addClass("show");
    } else {
      $suggestion
        .find("ul")
        .html("<div class='no-suggetion-search'><p>No Suggestion</p></div>");
      $suggestion.addClass("show");
    }
  }

  // ── Shared: redirect function ───────────────────────────────────
  function redirectToListing(keyword, type) {
    var routeMap = {
      all: base_url + "/all-media",
      video: base_url + "/videos",
      image: base_url + "/allPhotos",
      artwork: base_url + "/artwork",
    };
    var baseRoute = routeMap[type] || base_url + "/allPhotos";
    var url =
      baseRoute +
      "?q=" +
      encodeURIComponent(keyword) +
      "&type=" +
      encodeURIComponent(type);
    window.location.href = url;
  }
});

(function ($) {
  "use strict";

  // File selected via click
  $(document).on("change", "#search-image", function () {
    handleFile(this.files[0]);
  });

  // Drag & Drop
  var dropZone = document.getElementById("imageDropZone");
  if (dropZone) {
    dropZone.addEventListener("dragover", function (e) {
      e.preventDefault();
      dropZone.classList.add("drag-over");
    });
    dropZone.addEventListener("dragleave", function () {
      dropZone.classList.remove("drag-over");
    });
    dropZone.addEventListener("drop", function (e) {
      e.preventDefault();
      dropZone.classList.remove("drag-over");
      var file = e.dataTransfer.files[0];
      if (file) {
        // Assign to actual file input so form submits it
        var dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById("search-image").files = dt.files;
        handleFile(file);
      }
    });
  }

  function handleFile(file) {
    if (!file || !file.type.startsWith("image/")) return;

    // Show preview
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#imagePreview").attr("src", e.target.result).show();
      $("#uploadIcon").hide();
      $("#uploadLabel").text(file.name);
    };
    reader.readAsDataURL(file);

    // Enable search button
    $("#searchByImageBtn").prop("disabled", false);
  }

  // Reset modal on close
  $("#exampleModal").on("hidden.bs.modal", function () {
    $("#search-image").val("");
    $("#imagePreview").hide().attr("src", "");
    $("#uploadIcon").show();
    $("#uploadLabel").text("Click to upload an image or drag and drop");
    $("#searchByImageBtn").prop("disabled", true);
  });

  $(document).on("click", "#searchByImageBtn", function () {
    $(this).closest("form").submit();
    $(this).prop("disabled", true);
    $(".cancel-btn").prop("disabled", true);
    $("#ai_loader").css("display", "flex");
  });
})(jQuery);
(function () {
  // ── Build share URLs ──
  function getShareUrl() {
    return encodeURIComponent(window.location.href);
  }

  function getShareTitle() {
    return encodeURIComponent(document.title || "Check this out!");
  }

  // ── Toggle dropdown ──
  $(document).on("click", ".share-trigger-btn", function (e) {
    e.stopPropagation();
    const dropdown = $(this).siblings("#shareDropdown");

    // Close all other open dropdowns first
    $(".share-dropdown").not(dropdown).hide();
    dropdown.toggle();
  });

  // ── Close on outside click ──
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".share-wrapper").length) {
      $(".share-dropdown").hide();
    }
  });

  // ── Set share links on open ──
  // ── Set share links on open ──
  $(document).on("click", ".share-trigger-btn", function () {
    const pageUrl = $(this).data("url") || window.location.href; // ✅ use data-url
    const url = encodeURIComponent(pageUrl);
    const title = getShareTitle();

    // WhatsApp
    $(this)
      .siblings("#shareDropdown")
      .find("#shareWhatsapp")
      .attr(
        "href",
        "https://api.whatsapp.com/send?text=" + title + "%20" + url
      );

    // X (Twitter)
    $(this)
      .siblings("#shareDropdown")
      .find("#shareX")
      .attr(
        "href",
        "https://twitter.com/intent/tweet?text=" + title + "&url=" + url
      );

    // Instagram
    $(this)
      .siblings("#shareDropdown")
      .find("#shareInstagram")
      .attr("href", "https://www.instagram.com/")
      .off("click")
      .on("click", function () {
        navigator.clipboard.writeText(pageUrl).then(function () {
          toastr
            ? toastr.info("Link copied! Paste it in Instagram.")
            : alert("Link copied! Paste it in Instagram.");
        });
      });

    // Facebook
    $(this)
      .siblings("#shareDropdown")
      .find("#shareFacebook")
      .attr("href", "https://www.facebook.com/sharer/sharer.php?u=" + url);

    // Store pageUrl on copy button for this specific share
    $(this)
      .siblings("#shareDropdown")
      .find("#copyLinkBtn")
      .data("copy-url", pageUrl);
  });

  // ── Copy link — use stored url from button ──
  $(document).on("click", ".copy-link-btn", function () {
    const btn = $(this);
    const copyUrl = btn.attr("data-copy-url") || window.location.href;
    const $textElement = $("#copyLinkText");

    // Helper to handle the UI feedback
    const showSuccess = () => {
      $textElement.text("Copied!");
      setTimeout(() => $textElement.text("Copy Link"), 2000);
      if (typeof toastr !== "undefined") toastr.success("Link copied!");
    };

    // 1. Try modern Clipboard API (Requires HTTPS/Localhost)
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard
        .writeText(copyUrl)
        .then(showSuccess)
        .catch((err) => console.error("Clipboard API error:", err));
    } else {
      // 2. Fallback for HTTP or older browsers
      const el = document.createElement("textarea");
      el.value = copyUrl;
      el.setAttribute("readonly", ""); // Prevent keyboard from popping up on mobile
      el.style.position = "absolute";
      el.style.left = "-9999px";
      document.body.appendChild(el);

      el.select();
      const success = document.execCommand("copy");
      document.body.removeChild(el);

      if (success) {
        showSuccess();
      } else {
        console.error("Fallback copy failed");
      }
    }
  });
})();

$(document).on("mouseenter", ".product-img", function () {
  if (this.play) {
    this.play().catch(() => {});
  }
});

$(document).on("mouseleave", ".product-img", function () {
  if (this.pause) {
    this.pause();
  }
  if (this) {
    this.currentTime = 0;
  }
});
