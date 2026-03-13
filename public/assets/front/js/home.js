$(document).ready(function () {
  var base_url = $("#base_url").val();
  var searchTimeout;
  var selectedType = "all"; // for top dropdown search
  var helpSelectedType = "all"; // for help section pill search

  // ══════════════════════════════════════════════════════
  // TOP SEARCH (dropdown + .home_search)
  // ══════════════════════════════════════════════════════

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
      all: base_url + "/allPhotos",
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
