// (function ($) {
//   "use strict";

//   if ($("#videoGrid").length === 0) return;

//   var CONFIG = window.VIDEO_FILTER_CONFIG || {};
//   var AJAX_URL = CONFIG.ajaxUrl || window.location.pathname;
//   var CSRF =
//     CONFIG.csrfToken || $('meta[name="csrf-token"]').attr("content") || "";
//   var MAX_PRICE = parseInt($("#priceRangeMax").attr("max")) || 0;
//   var MAX_DURATION = parseInt($("#durationRangeMax").attr("max")) || 0;
//   var isResetting = false;

//   $.ajaxSetup({
//     headers: {
//       "X-CSRF-TOKEN": CSRF,
//       "X-Requested-With": "XMLHttpRequest",
//       Accept: "application/json",
//     },
//   });

//   var state = {
//     q: "",
//     price_min: 0,
//     price_max: MAX_PRICE,
//     duration_min: 0,
//     duration_max: MAX_DURATION,
//     resolution: [],
//     frame_rate: [],
//     orientation: [],
//     license: "",
//     camera_movement: [],
//     content_filters: [],
//     with_people: "",
//     sort: "relevant",
//   };

//   var sortLabels = {
//     relevant: "Most Relevant",
//     newest: "Newest First",
//     popular: "Most Popular",
//     price_asc: "Price: Low to High",
//     price_desc: "Price: High to Low",
//     duration_asc: "Duration: Shortest",
//     duration_desc: "Duration: Longest",
//   };

//   var debounceTimer = null;
//   function triggerFetch(delay) {
//     if (delay === undefined) delay = 350;
//     clearTimeout(debounceTimer);
//     debounceTimer = setTimeout(doFetch, delay);
//   }

//   function buildParams() {
//     var params = {};
//     if (state.q) params.q = state.q;
//     if (state.price_min > 0) params.price_min = state.price_min;
//     if (state.price_max < MAX_PRICE) params.price_max = state.price_max;
//     if (state.duration_min > 0) params.duration_min = state.duration_min;
//     if (state.duration_max < MAX_DURATION)
//       params.duration_max = state.duration_max;
//     if (state.resolution.length) params["resolution[]"] = state.resolution;
//     if (state.frame_rate.length) params["frame_rate[]"] = state.frame_rate;
//     if (state.orientation.length) params["orientation[]"] = state.orientation;
//     if (state.camera_movement.length)
//       params["camera_movement[]"] = state.camera_movement;
//     if (state.license) params.license = state.license;
//     if (state.with_people) params.with_people = state.with_people;
//     if (state.sort !== "relevant") params.sort = state.sort;
//     if (state.content_filters.length)
//       params["content_filters[]"] = state.content_filters;
//     return params;
//   }

//   function doFetch() {
//     var params = buildParams();
//     var qs = $.param(params);
//     window.history.replaceState({}, "", AJAX_URL + (qs ? "?" + qs : ""));
//     $("#videoGrid").addClass("loading");
//     $("#videoLoader").removeClass("d-none");

//     $.ajax({
//       url: AJAX_URL,
//       type: "GET",
//       data: params,
//       dataType: "json",
//       success: function (data) {
//         $("#videoGrid").html(data.html);
//         $("#videoResultCount").text(data.count + " result(s)");
//         renderChips();
//         reBindFavorites();
//       },
//       error: function () {
//         $("#videoGrid").html(
//           '<div style="grid-column:1/-1;"><div class="alert alert-danger text-center m-3">Something went wrong. Please try again.</div></div>'
//         );
//       },
//       complete: function () {
//         $("#videoGrid").removeClass("loading");
//         $("#videoLoader").addClass("d-none");
//       },
//     });
//   }

//   /* -------------------------------------------------------------------------
//      FILL UPDATE — single source of truth, uses left+right (no width conflict)
//   -------------------------------------------------------------------------- */
//   function updateFill(minId, maxId, fillId) {
//     var minEl = document.getElementById(minId);
//     var maxEl = document.getElementById(maxId);
//     var fill = document.getElementById(fillId);
//     if (!minEl || !maxEl || !fill) return;

//     var absMin = parseFloat(minEl.min) || 0;
//     var absMax = parseFloat(minEl.max) || 100;
//     var lo = parseFloat(minEl.value) || absMin;
//     var hi = parseFloat(maxEl.value) || absMax;

//     // Clamp to 0–100 to prevent floating point causing right < 0
//     var leftPct = Math.max(
//       0,
//       Math.min(100, ((lo - absMin) / (absMax - absMin)) * 100)
//     );
//     var rightPct = Math.max(
//       0,
//       Math.min(100, ((absMax - hi) / (absMax - absMin)) * 100)
//     );

//     fill.style.left = leftPct + "%";
//     fill.style.right = rightPct + "%";
//     fill.style.width = "";
//   }

//   /* -------------------------------------------------------------------------
//      UI SYNC — Price
//   -------------------------------------------------------------------------- */
//   function syncAllPriceUI() {
//     var GAP = 1;
//     if (state.price_min >= state.price_max)
//       state.price_min = Math.max(0, state.price_max - GAP);
//     if (state.price_max <= state.price_min)
//       state.price_max = Math.min(MAX_PRICE, state.price_min + GAP);

//     // Desktop sliders
//     $("#priceRangeMin").val(state.price_min);
//     $("#priceRangeMax").val(state.price_max);

//     // Desktop number inputs
//     $("#price_min_input").val(state.price_min);
//     $("#price_max_input").val(state.price_max);

//     // Desktop labels
//     $("#priceMinLabel").text("$" + state.price_min);
//     $("#priceMaxLabel").text("$" + state.price_max);

//     // Mobile
//     $(".price_min_mobile").val(state.price_min);
//     $(".price_max_mobile").val(state.price_max);
//     $(".priceMinLabel_mobile").text("$" + state.price_min);
//     $(".priceMaxLabel_mobile").text("$" + state.price_max);

//     updateFill("priceRangeMin", "priceRangeMax", "priceTrackFill");
//   }

//   /* -------------------------------------------------------------------------
//      UI SYNC — Duration
//   -------------------------------------------------------------------------- */
//   function syncAllDurationUI() {
//     var GAP = 1;
//     if (state.duration_min >= state.duration_max)
//       state.duration_min = Math.max(0, state.duration_max - GAP);
//     if (state.duration_max <= state.duration_min)
//       state.duration_max = Math.min(MAX_DURATION, state.duration_min + GAP);

//     var labelMin = state.duration_min + "s";
//     var labelMax =
//       state.duration_max + (state.duration_max >= MAX_DURATION ? "s+" : "s");

//     // Desktop sliders
//     $("#durationRangeMin").val(state.duration_min);
//     $("#durationRangeMax").val(state.duration_max);

//     // Desktop number inputs
//     $("#duration_min_input").val(state.duration_min);
//     $("#duration_max_input").val(state.duration_max);

//     // Desktop labels
//     $("#durationMinLabel").text(labelMin);
//     $("#durationMaxLabel").text(labelMax);

//     // Mobile
//     $(".duration_min_mobile").val(state.duration_min);
//     $(".duration_max_mobile").val(state.duration_max);
//     $(".durationMinLabel_mobile").text(labelMin);
//     $(".durationMaxLabel_mobile").text(labelMax);

//     updateFill("durationRangeMin", "durationRangeMax", "durationTrackFill");
//   }

//   /* -------------------------------------------------------------------------
//      RESET ALL
//   -------------------------------------------------------------------------- */
//   function resetAll(skipFetch) {
//     isResetting = true;
//     state.q = "";
//     state.price_min = 0;
//     state.price_max = MAX_PRICE;
//     state.duration_min = 0;
//     state.duration_max = MAX_DURATION;
//     state.resolution = [];
//     state.frame_rate = [];
//     state.orientation = [];
//     state.content_filters = [];
//     state.license = "";
//     state.camera_movement = [];
//     state.with_people = "";
//     state.sort = "relevant";

//     $("input.filter-check").prop("checked", false);
//     $("input.filter-radio").prop("checked", false);
//     $(".trending-tag-btn").removeClass("active");
//     $(".trending-tag-btn .tag-close").addClass("d-none");
//     $(".sort-btn").removeClass("active");
//     $('.sort-btn[data-value="relevant"]').addClass("active");
//     $("#selectedOption").text("Most Relevant");

//     syncAllPriceUI();
//     syncAllDurationUI();
//     isResetting = false;

//     if (!skipFetch) triggerFetch(0);
//   }

//   /* -------------------------------------------------------------------------
//      CHIPS
//   -------------------------------------------------------------------------- */
//   function renderChips() {
//     var $container = $("#activeFilterChips").empty();
//     function addChip(label, removeFn) {
//       var $chip = $('<span class="filter-chip"></span>').html(
//         label + ' <i class="fa-solid fa-xmark"></i>'
//       );
//       $chip.on("click", function () {
//         removeFn();
//         triggerFetch(0);
//       });
//       $container.append($chip);
//     }
//     if (state.q) {
//       addChip('"' + state.q + '"', function () {
//         state.q = "";
//         $(".trending-tag-btn").removeClass("active");
//         $(".trending-tag-btn .tag-close").addClass("d-none");
//       });
//     }
//     if (state.price_min > 0 || state.price_max < MAX_PRICE) {
//       addChip(
//         "$" + state.price_min + " \u2013 $" + state.price_max,
//         function () {
//           state.price_min = 0;
//           state.price_max = MAX_PRICE;
//           syncAllPriceUI();
//         }
//       );
//     }
//     if (state.duration_min > 0 || state.duration_max < MAX_DURATION) {
//       addChip(
//         state.duration_min + "s \u2013 " + state.duration_max + "s",
//         function () {
//           state.duration_min = 0;
//           state.duration_max = MAX_DURATION;
//           syncAllDurationUI();
//         }
//       );
//     }
//     $.each(state.resolution, function (i, v) {
//       addChip("Res: " + v, function () {
//         state.resolution = $.grep(state.resolution, function (x) {
//           return x !== v;
//         });
//         syncCheckboxes("resolution[]", state.resolution);
//       });
//     });
//     $.each(state.frame_rate, function (i, v) {
//       addChip(v + " fps", function () {
//         state.frame_rate = $.grep(state.frame_rate, function (x) {
//           return x !== v;
//         });
//         syncCheckboxes("frame_rate[]", state.frame_rate);
//       });
//     });
//     $.each(state.orientation, function (i, v) {
//       addChip(capitalize(v), function () {
//         state.orientation = $.grep(state.orientation, function (x) {
//           return x !== v;
//         });
//         syncCheckboxes("orientation[]", state.orientation);
//       });
//     });
//     $.each(state.camera_movement, function (i, v) {
//       addChip("Cam: " + v, function () {
//         state.camera_movement = $.grep(state.camera_movement, function (x) {
//           return x !== v;
//         });
//         syncCheckboxes("camera_movement[]", state.camera_movement);
//       });
//     });
//     if (state.license) {
//       addChip("License: " + state.license, function () {
//         state.license = "";
//         $('input.filter-radio[name="license"]').prop("checked", false);
//       });
//     }
//     $.each(state.content_filters, function (i, v) {
//       addChip("Content: " + capitalize(v.replace(/_/g, " ")), function () {
//         state.content_filters = $.grep(state.content_filters, function (x) {
//           return x !== v;
//         });
//         syncCheckboxes("content_filters[]", state.content_filters);
//       });
//     });
//   }

//   function syncCheckboxes(name, activeValues) {
//     $('input[name="' + name + '"]').each(function () {
//       $(this).prop("checked", $.inArray($(this).val(), activeValues) !== -1);
//     });
//   }
//   function capitalize(str) {
//     if (!str) return "";
//     return str.charAt(0).toUpperCase() + str.slice(1);
//   }

//   /* =========================================================================
//      EVENT BINDINGS — Price sliders
//      NOTE: jQuery delegated events work on the live DOM by ID so cloning
//            is NOT needed and NOT done here.
//   ========================================================================= */

//   /* Price MIN slider */
//   $(document).on("input", "#priceRangeMin", function () {
//     if (isResetting) return;
//     var val = parseInt($(this).val(), 10);
//     if (val >= state.price_max) {
//       val = state.price_max - 1;
//       $(this).val(val);
//     }
//     state.price_min = val;
//     syncAllPriceUI();
//     triggerFetch();
//   });

//   /* Price MAX slider */
//   $(document).on("input", "#priceRangeMax", function () {
//     if (isResetting) return;
//     var val = parseInt($(this).val(), 10);
//     if (val <= state.price_min) {
//       val = state.price_min + 1;
//       $(this).val(val);
//     }
//     state.price_max = val;
//     syncAllPriceUI();
//     triggerFetch();
//   });

//   /* Price MIN number input */
//   $(document).on("input", "#price_min_input", function () {
//     if (isResetting) return;
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.price_max - 1)
//     );
//     state.price_min = val;
//     syncAllPriceUI();
//     triggerFetch(150);
//   });

//   /* Price MAX number input */
//   $(document).on("input", "#price_max_input", function () {
//     if (isResetting) return;
//     var val = Math.max(
//       state.price_min + 1,
//       Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
//     );
//     state.price_max = val;
//     syncAllPriceUI();
//     triggerFetch(150);
//   });

//   /* Mobile price */
//   $(document).on("input", ".priceRangeMax_mobile", function () {
//     if (isResetting) return;
//     state.price_max = parseInt($(this).val(), 10);
//     syncAllPriceUI();
//     triggerFetch();
//   });
//   $(document).on("change", ".price_min_mobile", function () {
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.price_max - 1)
//     );
//     state.price_min = val;
//     syncAllPriceUI();
//     triggerFetch();
//   });
//   $(document).on("change", ".price_max_mobile", function () {
//     var val = Math.max(
//       state.price_min + 1,
//       Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
//     );
//     state.price_max = val;
//     syncAllPriceUI();
//     triggerFetch();
//   });

//   /* =========================================================================
//      EVENT BINDINGS — Duration sliders
//   ========================================================================= */

//   /* Duration MIN slider */
//   $(document).on("input", "#durationRangeMin", function () {
//     if (isResetting) return;
//     var val = parseInt($(this).val(), 10);
//     if (val >= state.duration_max) {
//       val = state.duration_max - 1;
//       $(this).val(val);
//     }
//     state.duration_min = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* Duration MAX slider */
//   $(document).on("input", "#durationRangeMax", function () {
//     if (isResetting) return;
//     var val = parseInt($(this).val(), 10);
//     if (val <= state.duration_min) {
//       val = state.duration_min + 1;
//       $(this).val(val);
//     }
//     state.duration_max = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* Duration number inputs */
//   $(document).on("input", "#duration_min_input", function () {
//     if (isResetting) return;
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.duration_max - 1)
//     );
//     state.duration_min = val;
//     syncAllDurationUI();
//     triggerFetch(150);
//   });
//   $(document).on("input", "#duration_max_input", function () {
//     if (isResetting) return;
//     var val = Math.max(
//       state.duration_min + 1,
//       Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
//     );
//     state.duration_max = val;
//     syncAllDurationUI();
//     triggerFetch(150);
//   });

//   /* Mobile duration */
//   $(document).on("input", ".durationRangeMax_mobile", function () {
//     if (isResetting) return;
//     state.duration_max = parseInt($(this).val(), 10);
//     syncAllDurationUI();
//     triggerFetch();
//   });
//   $(document).on("change", ".duration_min_mobile", function () {
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.duration_max - 1)
//     );
//     state.duration_min = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });
//   $(document).on("change", ".duration_max_mobile", function () {
//     var val = Math.max(
//       state.duration_min + 1,
//       Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
//     );
//     state.duration_max = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* =========================================================================
//      OTHER EVENT BINDINGS
//   ========================================================================= */
//   // $(document).on("change", "input.filter-check", function () {
//   //   var $cb = $(this);
//   //   var name = $cb.attr("name");
//   //   var key = name.replace("[]", "");
//   //   var val = $cb.val();
//   //   if (key === "with_people") {
//   //     state.with_people = $cb.is(":checked") ? "1" : "";
//   //     $('input.filter-check[name="with_people"]').prop(
//   //       "checked",
//   //       $cb.is(":checked")
//   //     );
//   //   } else if ($.isArray(state[key])) {
//   //     if ($cb.is(":checked")) {
//   //       if ($.inArray(val, state[key]) === -1) state[key].push(val);
//   //     } else {
//   //       state[key] = $.grep(state[key], function (v) {
//   //         return v !== val;
//   //       });
//   //     }
//   //     syncCheckboxes(name, state[key]);
//   //   }
//   //   triggerFetch();
//   // });

//   // $(document).on("change", 'input.filter-radio[name="license"]', function () {
//   //   state.license = $(this).is(":checked") ? $(this).val() : "";
//   //   $('input.filter-radio[name="license"]').prop("checked", false);
//   //   if (state.license) {
//   //     $(
//   //       'input.filter-radio[name="license"][value="' + state.license + '"]'
//   //     ).prop("checked", true);
//   //   }
//   //   triggerFetch();
//   // });

//   $(document).on("click", ".sort-btn", function () {
//     state.sort = $(this).data("value");
//     $(".sort-btn").removeClass("active");
//     $(this).addClass("active");
//     $("#selectedOption").text(sortLabels[state.sort] || "Most Relevant");
//     triggerFetch(0);
//   });

//   $(document).on("click", ".trending-tag-btn", function () {
//     var $btn = $(this);
//     var tag = $btn.data("tag");
//     if (state.q === tag) {
//       state.q = "";
//       $btn.removeClass("active");
//       $btn.find(".tag-close").addClass("d-none");
//     } else {
//       $(".trending-tag-btn").removeClass("active");
//       $(".trending-tag-btn .tag-close").addClass("d-none");
//       state.q = tag;
//       $btn.addClass("active");
//       $btn.find(".tag-close").removeClass("d-none");
//     }
//     triggerFetch(0);
//   });

//   $(document).on(
//     "click",
//     "#clearAllFiltersBtn, #noResultsClearBtn",
//     function () {
//       resetAll();
//     }
//   );

//   $(document).on("click", ".view-btn", function () {
//     $(".view-btn").removeClass("active");
//     $(this).addClass("active");
//     var cols = $(this).data("cols");
//     $("#videoGrid").removeClass("cols-2 cols-1");
//     if (cols == 2) $("#videoGrid").addClass("cols-2");
//     if (cols == 1) $("#videoGrid").addClass("cols-1");
//   });

//   $(document).on("click", "#mobileFilterToggle", function () {
//     $("#mobileFilterSidebar").toggleClass("open");
//   });
//   $(document).on("click", "#closeMobileFilter", function () {
//     $("#mobileFilterSidebar").removeClass("open");
//   });
//   $(document).on("click", function (e) {
//     if (
//       $("#mobileFilterSidebar").hasClass("open") &&
//       $(e.target).closest("#mobileFilterSidebar").length === 0 &&
//       $(e.target).closest("#mobileFilterToggle").length === 0
//     ) {
//       $("#mobileFilterSidebar").removeClass("open");
//     }
//   });

//   function reBindFavorites() {
//     $(document).trigger("videosGridRefreshed", [{ grid: $("#videoGrid") }]);
//   }

//   /* -------------------------------------------------------------------------
//      INIT
//   -------------------------------------------------------------------------- */
//   renderChips();
//   syncAllPriceUI();
//   syncAllDurationUI();
// })(jQuery);

// /* -------------------------------------------------------------------------
//    Video hover play/pause
// -------------------------------------------------------------------------- */
// $(document).on("mouseenter", ".product-img", function () {
//   this.play().catch(() => {});
// });
// $(document).on("mouseleave", ".product-img", function () {
//   this.pause();
//   this.currentTime = 0;
// });

(function ($) {
  "use strict";

  if ($("#videoGrid").length === 0) return;

  /* =========================================================================
     CONFIG & CONSTANTS
  ========================================================================= */
  var CONFIG = window.VIDEO_FILTER_CONFIG || {};
  var AJAX_URL = CONFIG.ajaxUrl || window.location.pathname;
  var CSRF =
    CONFIG.csrfToken || $('meta[name="csrf-token"]').attr("content") || "";
  var MAX_PRICE = parseInt($("#priceRangeMax").attr("max")) || 0;
  var MAX_DURATION = parseInt($("#durationRangeMax").attr("max")) || 0;

  var isResetting = false;
  var currentPage = 1;

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": CSRF,
      "X-Requested-With": "XMLHttpRequest",
      Accept: "application/json",
    },
  });

  var sortLabels = {
    relevant: "Most Relevant",
    newest: "Newest First",
    popular: "Most Popular",
    price_asc: "Price: Low to High",
    price_desc: "Price: High to Low",
    duration_asc: "Duration: Shortest",
    duration_desc: "Duration: Longest",
  };

  /* =========================================================================
     STATE
  ========================================================================= */
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
    content_filters: [],
    with_people: "",
    sort: "relevant",
  };

  /* =========================================================================
     DEBOUNCE
  ========================================================================= */
  var debounceTimer = null;
  function triggerFetch(delay) {
    if (delay === undefined) delay = 350;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function () {
      doFetch(true);
    }, delay);
  }

  /* =========================================================================
     BUILD PARAMS — single source of truth for all AJAX calls
  ========================================================================= */
  function buildParams(page) {
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
    if (state.content_filters.length)
      params["content_filters[]"] = state.content_filters;
    if (state.license) params.license = state.license;
    if (state.with_people) params.with_people = state.with_people;
    if (state.sort !== "relevant") params.sort = state.sort;
    params.page = page || 1;
    return params;
  }

  /* =========================================================================
     FETCH — reset (page 1) vs load-more (append)
  ========================================================================= */
  function doFetch(reset) {
    if (reset) currentPage = 1;

    var params = buildParams(currentPage);
    var qs = $.param(params);

    // Keep URL in sync (only on reset / filter change)
    if (reset) {
      window.history.replaceState({}, "", AJAX_URL + (qs ? "?" + qs : ""));
    }

    $("#videoGrid").addClass("loading");
    $("#videoLoader").removeClass("d-none");

    $.ajax({
      url: AJAX_URL,
      type: "GET",
      data: params,
      dataType: "json",
      success: function (data) {
        if (reset) {
          $("#videoGrid").html(data.html);
          $("#videoResultCount").text(data.count + " result(s)");
          renderChips();
        } else {
          $("#videoGrid").append(data.html);
        }

        // Load-more button visibility
        var $lmWrapper = $("#load-more-wrapper");
        if ($lmWrapper.length) {
          $lmWrapper.toggle(!!data.hasMore);
        }

        reBindFavorites();
      },
      error: function () {
        if (reset) {
          $("#videoGrid").html(
            '<div style="grid-column:1/-1;"><div class="alert alert-danger text-center m-3">Something went wrong. Please try again.</div></div>'
          );
        }
      },
      complete: function () {
        $("#videoGrid").removeClass("loading");
        $("#videoLoader").addClass("d-none");

        // Re-enable load-more button
        $("#loadMoreBtn").prop("disabled", false);
        $("#loadMoreText").text("Load More");
        $("#loadMoreSpinner").addClass("d-none");
      },
    });
  }

  /* =========================================================================
     LOAD MORE
  ========================================================================= */
  $(document).on("click", "#loadMoreBtn", function () {
    currentPage++;
    $("#loadMoreBtn").prop("disabled", true);
    $("#loadMoreText").text("Loading...");
    $("#loadMoreSpinner").removeClass("d-none");
    doFetch(false);
  });

  /* =========================================================================
     RANGE SLIDER FILL — left + right (avoids width conflicts)
  ========================================================================= */
  function updateFill(minId, maxId, fillId) {
    var minEl = document.getElementById(minId);
    var maxEl = document.getElementById(maxId);
    var fill = document.getElementById(fillId);
    if (!minEl || !maxEl || !fill) return;

    var absMin = parseFloat(minEl.min) || 0;
    var absMax = parseFloat(minEl.max) || 100;
    var lo = parseFloat(minEl.value) || absMin;
    var hi = parseFloat(maxEl.value) || absMax;
    var leftPct = Math.max(
      0,
      Math.min(100, ((lo - absMin) / (absMax - absMin)) * 100)
    );
    var rightPct = Math.max(
      0,
      Math.min(100, ((absMax - hi) / (absMax - absMin)) * 100)
    );

    fill.style.left = leftPct + "%";
    fill.style.right = rightPct + "%";
    fill.style.width = "";
  }

  /* =========================================================================
     UI SYNC — Price
  ========================================================================= */
  function syncAllPriceUI() {
    var GAP = 1;
    if (state.price_min >= state.price_max)
      state.price_min = Math.max(0, state.price_max - GAP);
    if (state.price_max <= state.price_min)
      state.price_max = Math.min(MAX_PRICE, state.price_min + GAP);

    $("#priceRangeMin").val(state.price_min);
    $("#priceRangeMax").val(state.price_max);
    $("#price_min_input").val(state.price_min);
    $("#price_max_input").val(state.price_max);
    $("#priceMinLabel").text("$" + state.price_min);
    $("#priceMaxLabel").text("$" + state.price_max);

    $(".price_min_mobile").val(state.price_min);
    $(".price_max_mobile").val(state.price_max);
    $(".priceMinLabel_mobile").text("$" + state.price_min);
    $(".priceMaxLabel_mobile").text("$" + state.price_max);

    updateFill("priceRangeMin", "priceRangeMax", "priceTrackFill");
  }

  /* =========================================================================
     UI SYNC — Duration
  ========================================================================= */
  function syncAllDurationUI() {
    var GAP = 1;
    if (state.duration_min >= state.duration_max)
      state.duration_min = Math.max(0, state.duration_max - GAP);
    if (state.duration_max <= state.duration_min)
      state.duration_max = Math.min(MAX_DURATION, state.duration_min + GAP);

    var labelMin = state.duration_min + "s";
    var labelMax =
      state.duration_max + (state.duration_max >= MAX_DURATION ? "s+" : "s");

    $("#durationRangeMin").val(state.duration_min);
    $("#durationRangeMax").val(state.duration_max);
    $("#duration_min_input").val(state.duration_min);
    $("#duration_max_input").val(state.duration_max);
    $("#durationMinLabel").text(labelMin);
    $("#durationMaxLabel").text(labelMax);

    $(".duration_min_mobile").val(state.duration_min);
    $(".duration_max_mobile").val(state.duration_max);
    $(".durationMinLabel_mobile").text(labelMin);
    $(".durationMaxLabel_mobile").text(labelMax);

    updateFill("durationRangeMin", "durationRangeMax", "durationTrackFill");
  }

  /* =========================================================================
     RESET ALL
  ========================================================================= */
  function resetAll() {
    isResetting = true;

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

    // Hide all sub-category lists and uncheck their boxes
    $("[id^='sub_']").hide().find(".sub-category-check").prop("checked", false);

    syncAllPriceUI();
    syncAllDurationUI();

    isResetting = false;
    triggerFetch(0);
  }

  /* =========================================================================
     ACTIVE FILTER CHIPS
  ========================================================================= */
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
        $(".trending-tag-btn")
          .removeClass("active")
          .find(".tag-close")
          .addClass("d-none");
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

    var arrayChips = [
      {
        key: "resolution",
        label: function (v) {
          return "Res: " + v;
        },
      },
      {
        key: "frame_rate",
        label: function (v) {
          return v + " fps";
        },
      },
      {
        key: "orientation",
        label: function (v) {
          return capitalize(v);
        },
      },
      {
        key: "camera_movement",
        label: function (v) {
          return "Cam: " + v;
        },
      },
      {
        key: "content_filters",
        label: function (v) {
          return "Content: " + capitalize(v.replace(/_/g, " "));
        },
      },
    ];
    $.each(arrayChips, function (_, cfg) {
      $.each(state[cfg.key], function (i, v) {
        addChip(cfg.label(v), function () {
          state[cfg.key] = $.grep(state[cfg.key], function (x) {
            return x !== v;
          });
          syncCheckboxes(cfg.key + "[]", state[cfg.key]);
        });
      });
    });

    if (state.license) {
      addChip("License: " + state.license, function () {
        state.license = "";
        $('input.filter-radio[name="license"]').prop("checked", false);
      });
    }
  }

  function syncCheckboxes(name, activeValues) {
    $('input[name="' + name + '"]').each(function () {
      $(this).prop("checked", $.inArray($(this).val(), activeValues) !== -1);
    });
  }
  function capitalize(str) {
    return str ? str.charAt(0).toUpperCase() + str.slice(1) : "";
  }

  /* =========================================================================
     EVENT BINDINGS — Checkboxes & Radios
  ========================================================================= */
  $(document).on("change", "input.filter-check", function () {
    var $cb = $(this);
    var name = $cb.attr("name");
    var key = name.replace("[]", "");
    var val = $cb.val();

    if (key === "with_people") {
      state.with_people = $cb.is(":checked") ? "1" : "";
      $('input.filter-check[name="with_people"]').prop(
        "checked",
        $cb.is(":checked")
      );
    } else if ($.isArray(state[key])) {
      if ($cb.is(":checked")) {
        if ($.inArray(val, state[key]) === -1) state[key].push(val);
      } else {
        state[key] = $.grep(state[key], function (v) {
          return v !== val;
        });
      }
      syncCheckboxes(name, state[key]);
    }
    triggerFetch();
  });

  $(document).on("change", 'input.filter-radio[name="license"]', function () {
    state.license = $(this).is(":checked") ? $(this).val() : "";
    $('input.filter-radio[name="license"]').prop("checked", false);
    if (state.license) {
      $(
        'input.filter-radio[name="license"][value="' + state.license + '"]'
      ).prop("checked", true);
    }
    triggerFetch();
  });

  /* =========================================================================
     EVENT BINDINGS — Parent / sub-category checkboxes
  ========================================================================= */
  $(document).on("change", ".parent-category-check", function () {
    var $cb = $(this);
    var subList = document.getElementById("sub_" + $cb.data("categoryId"));
    if (subList) {
      if ($cb.is(":checked")) {
        $(subList).show();
      } else {
        $(subList).hide().find(".sub-category-check").prop("checked", false);
      }
    }
    triggerFetch();
  });

  /* =========================================================================
     EVENT BINDINGS — Price sliders
  ========================================================================= */
  $(document).on("input", "#priceRangeMin", function () {
    if (isResetting) return;
    var val = parseInt($(this).val(), 10);
    if (val >= state.price_max) {
      val = state.price_max - 1;
      $(this).val(val);
    }
    state.price_min = val;
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("input", "#priceRangeMax", function () {
    if (isResetting) return;
    var val = parseInt($(this).val(), 10);
    if (val <= state.price_min) {
      val = state.price_min + 1;
      $(this).val(val);
    }
    state.price_max = val;
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("input", "#price_min_input", function () {
    if (isResetting) return;
    state.price_min = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.price_max - 1)
    );
    syncAllPriceUI();
    triggerFetch(150);
  });
  $(document).on("input", "#price_max_input", function () {
    if (isResetting) return;
    state.price_max = Math.max(
      state.price_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
    );
    syncAllPriceUI();
    triggerFetch(150);
  });
  $(document).on("input", ".priceRangeMax_mobile", function () {
    if (isResetting) return;
    state.price_max = parseInt($(this).val(), 10);
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("change", ".price_min_mobile", function () {
    state.price_min = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.price_max - 1)
    );
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("change", ".price_max_mobile", function () {
    state.price_max = Math.max(
      state.price_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
    );
    syncAllPriceUI();
    triggerFetch();
  });

  /* =========================================================================
     EVENT BINDINGS — Duration sliders
  ========================================================================= */
  $(document).on("input", "#durationRangeMin", function () {
    if (isResetting) return;
    var val = parseInt($(this).val(), 10);
    if (val >= state.duration_max) {
      val = state.duration_max - 1;
      $(this).val(val);
    }
    state.duration_min = val;
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("input", "#durationRangeMax", function () {
    if (isResetting) return;
    var val = parseInt($(this).val(), 10);
    if (val <= state.duration_min) {
      val = state.duration_min + 1;
      $(this).val(val);
    }
    state.duration_max = val;
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("input", "#duration_min_input", function () {
    if (isResetting) return;
    state.duration_min = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.duration_max - 1)
    );
    syncAllDurationUI();
    triggerFetch(150);
  });
  $(document).on("input", "#duration_max_input", function () {
    if (isResetting) return;
    state.duration_max = Math.max(
      state.duration_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
    );
    syncAllDurationUI();
    triggerFetch(150);
  });
  $(document).on("input", ".durationRangeMax_mobile", function () {
    if (isResetting) return;
    state.duration_max = parseInt($(this).val(), 10);
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("change", ".duration_min_mobile", function () {
    state.duration_min = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.duration_max - 1)
    );
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("change", ".duration_max_mobile", function () {
    state.duration_max = Math.max(
      state.duration_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
    );
    syncAllDurationUI();
    triggerFetch();
  });

  /* =========================================================================
     EVENT BINDINGS — Sort, Tags, Clear, View, Mobile sidebar
  ========================================================================= */
  $(document).on("click", ".sort-btn", function () {
    state.sort = $(this).data("value");
    $(".sort-btn").removeClass("active");
    $(this).addClass("active");
    $("#selectedOption").text(sortLabels[state.sort] || "Most Relevant");
    triggerFetch(0);
  });

  $(document).on("click", ".trending-tag-btn", function () {
    var $btn = $(this);
    var tag = $btn.data("tag");
    if (state.q === tag) {
      state.q = "";
      $btn.removeClass("active").find(".tag-close").addClass("d-none");
    } else {
      $(".trending-tag-btn")
        .removeClass("active")
        .find(".tag-close")
        .addClass("d-none");
      state.q = tag;
      $btn.addClass("active").find(".tag-close").removeClass("d-none");
    }
    triggerFetch(0);
  });

  $(document).on(
    "click",
    "#clearAllFiltersBtn, #noResultsClearBtn",
    function () {
      resetAll();
    }
  );

  $(document).on("click", ".view-btn", function () {
    $(".view-btn").removeClass("active");
    $(this).addClass("active");
    var cols = $(this).data("cols");
    $("#videoGrid").removeClass("cols-2 cols-1");
    if (cols == 2) $("#videoGrid").addClass("cols-2");
    if (cols == 1) $("#videoGrid").addClass("cols-1");
  });

  $(document).on("click", "#mobileFilterToggle", function () {
    $("#mobileFilterSidebar").toggleClass("open");
  });
  $(document).on("click", "#closeMobileFilter", function () {
    $("#mobileFilterSidebar").removeClass("open");
  });
  $(document).on("click", function (e) {
    if (
      $("#mobileFilterSidebar").hasClass("open") &&
      !$(e.target).closest("#mobileFilterSidebar").length &&
      !$(e.target).closest("#mobileFilterToggle").length
    ) {
      $("#mobileFilterSidebar").removeClass("open");
    }
  });

  /* =========================================================================
     FAVORITES RE-BIND (called after grid refresh)
  ========================================================================= */
  function reBindFavorites() {
    $(document).trigger("videosGridRefreshed", [{ grid: $("#videoGrid") }]);
  }

  /* =========================================================================
     INIT
  ========================================================================= */
  renderChips();
  syncAllPriceUI();
  syncAllDurationUI();
})(jQuery);

/* =============================================================================
   VIDEO HOVER — play on enter, pause+reset on leave
============================================================================= */
$(document).on("mouseenter", ".product-img", function () {
  this.play().catch(function () {});
});
$(document).on("mouseleave", ".product-img", function () {
  this.pause();
  this.currentTime = 0;
});
