/**
 * video-filter.js
 * FILE: public/assets/front/js/video-filter.js
 *
 * Full jQuery AJAX filter system for the videos listing page.
 * Requires: jQuery (already loaded via Bootstrap stack)
 * Depends on: window.VIDEO_FILTER_CONFIG = { ajaxUrl, csrfToken }
 *             injected in the blade template via:
 *             <script>window.VIDEO_FILTER_CONFIG = { ajaxUrl: '{{ route("front.videos") }}', csrfToken: '{{ csrf_token() }}' };</script>
 */

/**
 * video-filter.js
 * FILE: public/assets/front/js/video-filter.js
 *
 * jQuery AJAX filter system for the videos section.
 * Requires: jQuery (loaded via Bootstrap stack)
 * Requires: window.VIDEO_FILTER_CONFIG = { ajaxUrl, csrfToken }
 *           — injected by the blade just before this script loads:
 *             <script>
 *               window.VIDEO_FILTER_CONFIG = {
 *                 ajaxUrl:   '{{ route("front.videos") }}',
 *                 csrfToken: '{{ csrf_token() }}'
 *               };
 *             </script>
 */

(function ($) {
  "use strict";

  // Clear query params immediately on page load

  /* GUARD */
  //   if ($("#videoGrid").length === 0) return;
  /* -------------------------------------------------------------------------
       GUARD — only run on pages that have #videoGrid
    -------------------------------------------------------------------------- */
  if ($("#videoGrid").length === 0) return;

  window.history.replaceState({}, "", window.location.pathname);

  /* -------------------------------------------------------------------------
       CONFIG
    -------------------------------------------------------------------------- */
  var CONFIG = window.VIDEO_FILTER_CONFIG || {};
  var AJAX_URL = CONFIG.ajaxUrl || window.location.pathname;
  var CSRF =
    CONFIG.csrfToken || $('meta[name="csrf-token"]').attr("content") || "";
  var MAX_PRICE = parseInt($("#priceRangeMax").attr("max")) || 0;
  var MAX_DURATION = parseInt($("#durationRangeMax").attr("max")) || 0;
  var isResetting = false;

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": CSRF,
      "X-Requested-With": "XMLHttpRequest",
      Accept: "application/json",
    },
  });

  /* -------------------------------------------------------------------------
       STATE
    -------------------------------------------------------------------------- */
  var state = {
    q: "",
    price_min: 0,
    price_max: MAX_PRICE,
    duration_min: 0,
    duration_max: MAX_DURATION,
    resolution: [],
    frame_rate: [],
    orientation: [],
    license: "",
    camera_movement: [],
    content_filters: [], // ✅ ADD THIS
    with_people: "",
    sort: "relevant",
  };

  var sortLabels = {
    relevant: "Most Relevant",
    newest: "Newest First",
    popular: "Most Popular",
    price_asc: "Price: Low to High",
    price_desc: "Price: High to Low",
    duration_asc: "Duration: Shortest",
    duration_desc: "Duration: Longest",
  };

  /* -------------------------------------------------------------------------
       DEBOUNCE
    -------------------------------------------------------------------------- */
  var debounceTimer = null;

  function triggerFetch(delay) {
    if (delay === undefined) {
      delay = 350;
    }
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(doFetch, delay);
  }

  /* -------------------------------------------------------------------------
       BUILD PARAMS
    -------------------------------------------------------------------------- */
  function buildParams() {
    var params = {};
    if (state.q) params.q = state.q;
    if (state.price_min > 0) params.price_min = state.price_min;
    if (state.price_max < MAX_PRICE) params.price_max = state.price_max;
    if (state.duration_min > 0) params.duration_min = state.duration_min;
    if (state.duration_max < MAX_DURATION)
      params.duration_max = state.duration_max;
    if (state.resolution.length) params["resolution[]"] = state.resolution;
    if (state.frame_rate.length) params["frame_rate[]"] = state.frame_rate;
    if (state.orientation.length) params["orientation[]"] = state.orientation;
    if (state.camera_movement.length)
      params["camera_movement[]"] = state.camera_movement;
    if (state.license) params.license = state.license;
    if (state.with_people) params.with_people = state.with_people;
    if (state.sort !== "relevant") params.sort = state.sort;
    if (state.content_filters.length)
      params["content_filters[]"] = state.content_filters;
    return params;
  }

  /* -------------------------------------------------------------------------
       AJAX FETCH
    -------------------------------------------------------------------------- */
  function doFetch() {
    var params = buildParams();
    var qs = $.param(params);

    // Update browser URL without reload
    window.history.replaceState({}, "", AJAX_URL + (qs ? "?" + qs : ""));

    $("#videoGrid").addClass("loading");
    $("#videoLoader").removeClass("d-none");

    $.ajax({
      url: AJAX_URL,
      type: "GET",
      data: params,
      dataType: "json",

      success: function (data) {
        $("#videoGrid").html(data.html);
        $("#videoResultCount").text(data.count + " result(s)");
        renderChips();
        reBindFavorites();
      },

      error: function () {
        $("#videoGrid").html(
          '<div style="grid-column:1/-1;">' +
            '<div class="alert alert-danger text-center m-3">' +
            "Something went wrong. Please try again." +
            "</div></div>"
        );
      },

      complete: function () {
        $("#videoGrid").removeClass("loading");
        $("#videoLoader").addClass("d-none");
      },
    });
  }

  /* -------------------------------------------------------------------------
       ACTIVE FILTER CHIPS
    -------------------------------------------------------------------------- */
  function renderChips() {
    var $container = $("#activeFilterChips").empty();

    function addChip(label, removeFn) {
      var $chip = $('<span class="filter-chip"></span>').html(
        label + ' <i class="fa-solid fa-xmark"></i>'
      );
      $chip.on("click", function () {
        removeFn();
        triggerFetch(0);
      });
      $container.append($chip);
    }

    if (state.q) {
      addChip('"' + state.q + '"', function () {
        state.q = "";
        $(".trending-tag-btn").removeClass("active");
        $(".trending-tag-btn .tag-close").addClass("d-none");
      });
    }

    if (state.price_min > 0 || state.price_max < MAX_PRICE) {
      addChip(
        "$" + state.price_min + " \u2013 $" + state.price_max,
        function () {
          state.price_min = 0;
          state.price_max = MAX_PRICE;
          syncAllPriceUI();
        }
      );
    }

    if (state.duration_min > 0 || state.duration_max < MAX_DURATION) {
      addChip(
        state.duration_min + "s \u2013 " + state.duration_max + "s",
        function () {
          state.duration_min = 0;
          state.duration_max = MAX_DURATION;
          syncAllDurationUI();
        }
      );
    }

    $.each(state.resolution, function (i, v) {
      addChip("Res: " + v, function () {
        state.resolution = $.grep(state.resolution, function (x) {
          return x !== v;
        });
        syncCheckboxes("resolution[]", state.resolution);
      });
    });

    $.each(state.frame_rate, function (i, v) {
      addChip(v + " fps", function () {
        state.frame_rate = $.grep(state.frame_rate, function (x) {
          return x !== v;
        });
        syncCheckboxes("frame_rate[]", state.frame_rate);
      });
    });

    $.each(state.orientation, function (i, v) {
      addChip(capitalize(v), function () {
        state.orientation = $.grep(state.orientation, function (x) {
          return x !== v;
        });
        syncCheckboxes("orientation[]", state.orientation);
      });
    });

    $.each(state.camera_movement, function (i, v) {
      addChip("Cam: " + v, function () {
        state.camera_movement = $.grep(state.camera_movement, function (x) {
          return x !== v;
        });
        syncCheckboxes("camera_movement[]", state.camera_movement);
      });
    });

    if (state.license) {
      addChip("License: " + state.license, function () {
        state.license = "";
        $('input.filter-radio[name="license"]').prop("checked", false);
      });
    }

    $.each(state.content_filters, function (i, v) {
      addChip("Content: " + capitalize(v.replace(/_/g, " ")), function () {
        state.content_filters = $.grep(state.content_filters, function (x) {
          return x !== v;
        });
        syncCheckboxes("content_filters[]", state.content_filters);
      });
    });
  }

  /* -------------------------------------------------------------------------
       RESET ALL
    -------------------------------------------------------------------------- */
  function resetAll(skipFetch = false) {
    isResetting = true; // ← block slider event handlers

    state.q = "";
    state.price_min = 0;
    state.price_max = MAX_PRICE;
    state.duration_min = 0;
    state.duration_max = MAX_DURATION;
    state.resolution = [];
    state.frame_rate = [];
    state.orientation = [];
    state.content_filters = [];
    state.license = "";
    state.camera_movement = [];
    state.with_people = "";
    state.sort = "relevant";

    $("input.filter-check").prop("checked", false);
    $("input.filter-radio").prop("checked", false);

    $(".trending-tag-btn").removeClass("active");
    $(".trending-tag-btn .tag-close").addClass("d-none");

    $(".sort-btn").removeClass("active");
    $('.sort-btn[data-value="relevant"]').addClass("active");
    $("#selectedOption").text("Most Relevant");

    syncAllPriceUI();
    syncAllDurationUI();
    isResetting = false; // ← re-enable handlers

    if (!skipFetch) {
      triggerFetch(0);
    }
  }

  /* -------------------------------------------------------------------------
       UI SYNC — Price
       Syncs BOTH desktop inputs/slider AND mobile inputs/slider from state
    -------------------------------------------------------------------------- */
  function syncAllPriceUI() {
    var el = document.getElementById("priceRangeMax");
    if (el) {
      el.value = state.price_max;
      el.dispatchEvent(new Event("input"));
    }
    // Desktop
    $("#priceRangeMax").val(state.price_max);
    $("#price_min_input").val(state.price_min);
    $("#price_max_input").val(state.price_max);
    $("#priceMaxLabel").text("$" + state.price_max);
    // Mobile
    $(".priceRangeMax_mobile").val(state.price_max);
    $(".price_min_mobile").val(state.price_min);
    $(".price_max_mobile").val(state.price_max);
    $(".priceMaxLabel_mobile").text("$" + state.price_max);
  }

  /* -------------------------------------------------------------------------
       UI SYNC — Duration
    -------------------------------------------------------------------------- */
  function syncAllDurationUI() {
    var label =
      state.duration_max + (state.duration_max >= MAX_DURATION ? "s+" : "s");

    var el = document.getElementById("durationRangeMax");
    if (el) {
      el.value = state.duration_max;
      el.dispatchEvent(new Event("input"));
    }
    // Desktop
    $("#durationRangeMax").val(state.duration_max);
    $("#duration_min_input").val(state.duration_min);
    $("#duration_max_input").val(state.duration_max);
    $("#durationMaxLabel").text(label);
    // Mobile

    var elM = document.querySelector(".durationRangeMax_mobile");
    if (elM) {
      elM.value = state.duration_max;
      elM.dispatchEvent(new Event("input"));
    }

    $(".durationRangeMax_mobile").val(state.duration_max);
    $(".duration_min_mobile").val(state.duration_min);
    $(".duration_max_mobile").val(state.duration_max);
    $(".durationMaxLabel_mobile").text(label);
  }

  /* -------------------------------------------------------------------------
       UI SYNC — Checkboxes (syncs desktop + mobile at once)
    -------------------------------------------------------------------------- */
  function syncCheckboxes(name, activeValues) {
    $('input[name="' + name + '"]').each(function () {
      $(this).prop("checked", $.inArray($(this).val(), activeValues) !== -1);
    });
  }

  function capitalize(str) {
    if (!str) return "";
    return str.charAt(0).toUpperCase() + str.slice(1);
  }

  /* =========================================================================
       EVENT BINDINGS
    ========================================================================= */

  /* --- Desktop: Price Slider --- */
  $(document).on("input", "#priceRangeMax", function () {
    if (isResetting) return; // ← add this guard

    state.price_max = parseInt($(this).val(), 10);
    syncAllPriceUI();
    triggerFetch();
  });

  /* --- Mobile: Price Slider --- */
  $(document).on("input", ".priceRangeMax_mobile", function () {
    if (isResetting) return;

    state.price_max = parseInt($(this).val(), 10);
    syncAllPriceUI();
    triggerFetch();
  });

  /* --- Desktop: Price number inputs --- */
  $(document).on("change", "#price_min_input", function () {
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.price_max)
    );
    state.price_min = val;
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("change", "#price_max_input", function () {
    var val = Math.max(
      state.price_min,
      Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
    );
    state.price_max = val;
    syncAllPriceUI();
    triggerFetch();
  });

  /* --- Mobile: Price number inputs --- */
  $(document).on("change", ".price_min_mobile", function () {
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.price_max)
    );
    state.price_min = val;
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("change", ".price_max_mobile", function () {
    var val = Math.max(
      state.price_min,
      Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
    );
    state.price_max = val;
    syncAllPriceUI();
    triggerFetch();
  });

  /* --- Desktop: Duration Slider --- */
  $(document).on("input", "#durationRangeMax", function () {
    if (isResetting) return; // ← add this guard
    state.duration_max = parseInt($(this).val(), 10);
    syncAllDurationUI();
    triggerFetch();
  });

  /* --- Mobile: Duration Slider --- */
  $(document).on("input", ".durationRangeMax_mobile", function () {
    if (isResetting) return;

    state.duration_max = parseInt($(this).val(), 10);
    syncAllDurationUI();
    triggerFetch();
  });

  /* --- Desktop: Duration number inputs --- */
  $(document).on("change", "#duration_min_input", function () {
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.duration_max)
    );
    state.duration_min = val;
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("change", "#duration_max_input", function () {
    var val = Math.max(
      state.duration_min,
      Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
    );
    state.duration_max = val;
    syncAllDurationUI();
    triggerFetch();
  });

  /* --- Mobile: Duration number inputs --- */
  $(document).on("change", ".duration_min_mobile", function () {
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.duration_max)
    );
    state.duration_min = val;
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("change", ".duration_max_mobile", function () {
    var val = Math.max(
      state.duration_min,
      Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
    );
    state.duration_max = val;
    syncAllDurationUI();
    triggerFetch();
  });

  /* --- Checkboxes: resolution, frame_rate, orientation, camera_movement, with_people ---
       Single handler for ALL checkboxes in BOTH sidebars (event delegation)         */
  $(document).on("change", "input.filter-check", function () {
    var $cb = $(this);
    var name = $cb.attr("name"); // e.g. "resolution[]" or "content_filters[]"
    var key = name.replace("[]", ""); // e.g. "resolution" or "content_filters"
    var val = $cb.val();

    if (key === "with_people") {
      // legacy standalone checkbox (if you still have it elsewhere)
      state.with_people = $cb.is(":checked") ? "1" : "";
      $('input.filter-check[name="with_people"]').prop(
        "checked",
        $cb.is(":checked")
      );
    } else if ($.isArray(state[key])) {
      // Handles: resolution[], frame_rate[], orientation[],
      //          camera_movement[], content_filters[]
      if ($cb.is(":checked")) {
        if ($.inArray(val, state[key]) === -1) {
          state[key].push(val);
        }
      } else {
        state[key] = $.grep(state[key], function (v) {
          return v !== val;
        });
      }
      // Keep desktop + mobile in sync
      syncCheckboxes(name, state[key]);
    }

    triggerFetch();
  });

  /* --- License radio buttons --- */
  $(document).on("change", 'input.filter-radio[name="license"]', function () {
    state.license = $(this).is(":checked") ? $(this).val() : "";
    // Sync both sidebars
    $('input.filter-radio[name="license"]').prop("checked", false);
    if (state.license) {
      $(
        'input.filter-radio[name="license"][value="' + state.license + '"]'
      ).prop("checked", true);
    }
    triggerFetch();
  });

  /* --- Sort dropdown --- */
  $(document).on("click", ".sort-btn", function () {
    var $btn = $(this);
    state.sort = $btn.data("value");

    $(".sort-btn").removeClass("active");
    $btn.addClass("active");
    $("#selectedOption").text(sortLabels[state.sort] || "Most Relevant");

    triggerFetch(0);
  });

  /* --- Trending tag pills --- */
  $(document).on("click", ".trending-tag-btn", function () {
    var $btn = $(this);
    var tag = $btn.data("tag");

    if (state.q === tag) {
      state.q = "";
      $btn.removeClass("active");
      $btn.find(".tag-close").addClass("d-none");
    } else {
      $(".trending-tag-btn").removeClass("active");
      $(".trending-tag-btn .tag-close").addClass("d-none");
      state.q = tag;
      $btn.addClass("active");
      $btn.find(".tag-close").removeClass("d-none");
    }

    triggerFetch(0);
  });

  /* --- Clear all (sidebar button + no-results button injected by AJAX) --- */
  $(document).on(
    "click",
    "#clearAllFiltersBtn, #noResultsClearBtn",
    function () {
      resetAll();
    }
  );

  /* --- View mode toggle --- */
  $(document).on("click", ".view-btn", function () {
    var $btn = $(this);
    $(".view-btn").removeClass("active");
    $btn.addClass("active");

    var cols = $btn.data("cols");
    $("#videoGrid").removeClass("cols-2 cols-1");
    if (cols == 2) {
      $("#videoGrid").addClass("cols-2");
    }
    if (cols == 1) {
      $("#videoGrid").addClass("cols-1");
    }
  });

  /* --- Mobile sidebar open / close --- */
  $(document).on("click", "#mobileFilterToggle", function () {
    $("#mobileFilterSidebar").toggleClass("open");
  });

  $(document).on("click", "#closeMobileFilter", function () {
    $("#mobileFilterSidebar").removeClass("open");
  });

  // Close on outside click
  $(document).on("click", function (e) {
    if (
      $("#mobileFilterSidebar").hasClass("open") &&
      $(e.target).closest("#mobileFilterSidebar").length === 0 &&
      $(e.target).closest("#mobileFilterToggle").length === 0
    ) {
      $("#mobileFilterSidebar").removeClass("open");
    }
  });

  /* -------------------------------------------------------------------------
       RE-BIND FAVORITES after AJAX swaps the grid HTML
       Your favorites.js should listen:
           $(document).on('videosGridRefreshed', function() { ... rebind ... });
    -------------------------------------------------------------------------- */
  function reBindFavorites() {
    $(document).trigger("videosGridRefreshed", [{ grid: $("#videoGrid") }]);
  }

  /* -------------------------------------------------------------------------
       INIT
    -------------------------------------------------------------------------- */

  renderChips();
  syncAllPriceUI();
  syncAllDurationUI();
  initRangeSlider("priceRangeMax"); // ← add this
  initRangeSlider("durationRangeMax");
})(jQuery);
/* -------------------------------------------------------------------------
     INIT — Read URL params and restore state
  -------------------------------------------------------------------------- */

// class RangeSlider {
//   constructor(el) {
//     this.el = el;
//     this.min = +el.dataset.min || 0;
//     this.max = +el.dataset.max || 100;
//     this.value = +el.dataset.value || this.min;

//     this.create();
//     this.updateUI();
//     this.events();
//   }

//   create() {
//     this.track = document.createElement("div");
//     this.track.className = "range-track";

//     this.fill = document.createElement("div");
//     this.fill.className = "range-fill";

//     this.thumb = document.createElement("div");
//     this.thumb.className = "range-thumb";

//     this.valueLabel = document.createElement("div");
//     this.valueLabel.className = "range-value";

//     this.track.appendChild(this.fill);
//     this.track.appendChild(this.thumb);
//     this.el.appendChild(this.track);
//     this.el.appendChild(this.valueLabel);
//   }

//   updateUI() {
//     const percent = ((this.value - this.min) / (this.max - this.min)) * 100;

//     this.fill.style.width = percent + "%";
//     this.thumb.style.left = percent + "%";
//     this.valueLabel.textContent = this.value;
//   }

//   setValue(percent) {
//     percent = Math.max(0, Math.min(100, percent));
//     this.value = Math.round(this.min + (percent / 100) * (this.max - this.min));
//     this.updateUI();
//   }

//   events() {
//     const move = (e) => {
//       const rect = this.track.getBoundingClientRect();
//       const percent = ((e.clientX - rect.left) / rect.width) * 100;
//       this.setValue(percent);
//     };

//     this.track.addEventListener("click", move);

//     this.thumb.addEventListener("mousedown", () => {
//       const onMove = (e) => move(e);
//       const stop = () => {
//         document.removeEventListener("mousemove", onMove);
//         document.removeEventListener("mouseup", stop);
//       };

//       document.addEventListener("mousemove", onMove);
//       document.addEventListener("mouseup", stop);
//     });
//   }
// }

// document.querySelectorAll(".range-slider").forEach((el) => {
//   new RangeSlider(el);
// });

function initRangeSlider(inputId) {
  var input = document.getElementById(inputId);
  if (!input) return;

  var wrap = input.closest(".track-wrap");
  if (!wrap) return;

  var fill = wrap.querySelector(".track-fill");
  if (!fill) return;

  function updateFill() {
    var min = parseFloat(input.min) || 0;
    var max = parseFloat(input.max) || 100;
    var val = parseFloat(input.value) || 0;
    var pct = ((val - min) / (max - min)) * 100;
    fill.style.width = pct + "%";
  }

  updateFill();
  input.addEventListener("input", updateFill);
}

$(document).on("mouseenter", ".product-img", function () {
  this.play().catch(() => {});
});

$(document).on("mouseleave", ".product-img", function () {
  this.pause();
  this.currentTime = 0;
});
