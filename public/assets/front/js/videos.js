// /**
//  * video-filter.js
//  * FILE: public/assets/front/js/video-filter.js
//  *
//  * Full jQuery AJAX filter system for the videos listing page.
//  * Requires: jQuery (already loaded via Bootstrap stack)
//  * Depends on: window.VIDEO_FILTER_CONFIG = { ajaxUrl, csrfToken }
//  *             injected in the blade template via:
//  *             <script>window.VIDEO_FILTER_CONFIG = { ajaxUrl: '{{ route("front.videos") }}', csrfToken: '{{ csrf_token() }}' };</script>
//  */

// /**
//  * video-filter.js
//  * FILE: public/assets/front/js/video-filter.js
//  *
//  * jQuery AJAX filter system for the videos section.
//  * Requires: jQuery (loaded via Bootstrap stack)
//  * Requires: window.VIDEO_FILTER_CONFIG = { ajaxUrl, csrfToken }
//  *           — injected by the blade just before this script loads:
//  *             <script>
//  *               window.VIDEO_FILTER_CONFIG = {
//  *                 ajaxUrl:   '{{ route("front.videos") }}',
//  *                 csrfToken: '{{ csrf_token() }}'
//  *               };
//  *             </script>
//  */

// (function ($) {
//   "use strict";

//   // Clear query params immediately on page load

//   /* GUARD */
//   //   if ($("#videoGrid").length === 0) return;
//   /* -------------------------------------------------------------------------
//        GUARD — only run on pages that have #videoGrid
//     -------------------------------------------------------------------------- */
//   if ($("#videoGrid").length === 0) return;

//   // window.history.replaceState({}, "", window.location.pathname);

//   /* -------------------------------------------------------------------------
//        CONFIG
//     -------------------------------------------------------------------------- */
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

//   /* -------------------------------------------------------------------------
//        STATE
//     -------------------------------------------------------------------------- */
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
//     content_filters: [], // ✅ ADD THIS
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

//   /* -------------------------------------------------------------------------
//        DEBOUNCE
//     -------------------------------------------------------------------------- */
//   var debounceTimer = null;

//   function triggerFetch(delay) {
//     if (delay === undefined) {
//       delay = 350;
//     }
//     clearTimeout(debounceTimer);
//     debounceTimer = setTimeout(doFetch, delay);
//   }

//   /* -------------------------------------------------------------------------
//        BUILD PARAMS
//     -------------------------------------------------------------------------- */
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

//   /* -------------------------------------------------------------------------
//        AJAX FETCH
//     -------------------------------------------------------------------------- */
//   function doFetch() {
//     var params = buildParams();
//     var qs = $.param(params);

//     // Update browser URL without reload
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
//           '<div style="grid-column:1/-1;">' +
//             '<div class="alert alert-danger text-center m-3">' +
//             "Something went wrong. Please try again." +
//             "</div></div>"
//         );
//       },

//       complete: function () {
//         $("#videoGrid").removeClass("loading");
//         $("#videoLoader").addClass("d-none");
//       },
//     });
//   }

//   /* -------------------------------------------------------------------------
//        ACTIVE FILTER CHIPS
//     -------------------------------------------------------------------------- */
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

//   /* -------------------------------------------------------------------------
//        RESET ALL
//     -------------------------------------------------------------------------- */
//   function resetAll(skipFetch = false) {
//     isResetting = true; // ← block slider event handlers

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
//     isResetting = false; // ← re-enable handlers

//     if (!skipFetch) {
//       triggerFetch(0);
//     }
//   }

//   /* -------------------------------------------------------------------------
//        UI SYNC — Price
//        Syncs BOTH desktop inputs/slider AND mobile inputs/slider from state
//     -------------------------------------------------------------------------- */
//   function syncAllPriceUI() {
//     // var el = document.getElementById("priceRangeMax");
//     // if (el) {
//     //   el.value = state.price_max;
//     //   el.dispatchEvent(new Event("input"));
//     // }
//     // Desktop
//     $("#priceRangeMin").val(state.price_min);
//     $("#priceRangeMax").val(state.price_max);
//     $("#price_min_input").val(state.price_min);
//     $("#price_max_input").val(state.price_max);

//     $("#priceMinLabel").text("$" + state.price_min);
//     $("#priceMaxLabel").text("$" + state.price_max);
//     // Mobile
//     $(".priceRangeMax_mobile").val(state.price_max);
//     $(".price_min_mobile").val(state.price_min);
//     $(".price_max_mobile").val(state.price_max);
//     $(".priceMaxLabel_mobile").text("$" + state.price_max);

//     updateDualRangeFill("priceRangeMin", "priceRangeMax", "priceTrackFill");
//   }

//   function updateDualRangeFill(minId, maxId, fillId) {
//     var minEl = document.getElementById(minId);
//     var maxEl = document.getElementById(maxId);
//     var fill = document.getElementById(fillId);
//     if (!minEl || !maxEl || !fill) return;

//     var min = parseFloat(minEl.min) || 0;
//     var max = parseFloat(minEl.max) || 100;
//     var pMin = ((parseFloat(minEl.value) - min) / (max - min)) * 100;
//     var pMax = ((parseFloat(maxEl.value) - min) / (max - min)) * 100;

//     fill.style.left = pMin + "%";
//     fill.style.width = pMax - pMin + "%";
//   }
//   /* -------------------------------------------------------------------------
//        UI SYNC — Duration
//     -------------------------------------------------------------------------- */

//   /* Desktop: Duration MIN slider */
//   $(document).on("input", "#durationRangeMin", function () {
//     if (isResetting) return;
//     var val = parseInt($(this).val(), 10);
//     if (val >= state.duration_max) {
//       $(this).val(state.duration_max - 1);
//       val = state.duration_max - 1;
//     }
//     state.duration_min = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* Desktop: Duration MAX slider */
//   $(document).on("input", "#durationRangeMax", function () {
//     if (isResetting) return;
//     var val = parseInt($(this).val(), 10);
//     if (val <= state.duration_min) {
//       $(this).val(state.duration_min + 1);
//       val = state.duration_min + 1;
//     }
//     state.duration_max = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });
//   function syncAllDurationUI() {
//     var GAP = 1;
//     if (state.duration_min >= state.duration_max)
//       state.duration_min = state.duration_max - GAP;
//     if (state.duration_max <= state.duration_min)
//       state.duration_max = state.duration_min + GAP;

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

//     // Mobile inputs + labels
//     $(".duration_min_mobile").val(state.duration_min);
//     $(".duration_max_mobile").val(state.duration_max);
//     $(".durationMinLabel_mobile").text(labelMin);
//     $(".durationMaxLabel_mobile").text(labelMax);

//     // Update fill — no dispatchEvent
//     var fill = document.getElementById("durationTrackFill");
//     if (fill) {
//       fill.style.left = (state.duration_min / MAX_DURATION) * 100 + "%";
//       fill.style.right =
//         ((MAX_DURATION - state.duration_max) / MAX_DURATION) * 100 + "%";
//     }
//   }

//   /* -------------------------------------------------------------------------
//        UI SYNC — Checkboxes (syncs desktop + mobile at once)
//     -------------------------------------------------------------------------- */
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
//        EVENT BINDINGS
//     ========================================================================= */

//   /* --- Desktop: Price Slider --- */
//   $(document).on("input", "#priceRangeMax", function () {
//     if (isResetting) return; // ← add this guard

//     state.price_max = parseInt($(this).val(), 10);
//     syncAllPriceUI();
//     triggerFetch();
//   });

//   /* --- Mobile: Price Slider --- */
//   $(document).on("input", ".priceRangeMax_mobile", function () {
//     if (isResetting) return;

//     state.price_max = parseInt($(this).val(), 10);
//     syncAllPriceUI();
//     triggerFetch();
//   });

//   /* --- Desktop: Price number inputs --- */
//   $(document).on("input", "#price_min_input", function () {
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.price_max)
//     );
//     state.price_min = val;
//     syncAllPriceUI();
//     triggerFetch(150); // faster for typed input
//   });
//   $(document).on("change", "#price_max_input", function () {
//     var val = Math.max(
//       state.price_min,
//       Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
//     );
//     state.price_max = val;
//     syncAllPriceUI();
//     triggerFetch();
//   });

//   /* --- Mobile: Price number inputs --- */
//   $(document).on("change", ".price_min_mobile", function () {
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.price_max)
//     );
//     state.price_min = val;
//     syncAllPriceUI();
//     triggerFetch();
//   });
//   $(document).on("change", ".price_max_mobile", function () {
//     var val = Math.max(
//       state.price_min,
//       Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
//     );
//     state.price_max = val;
//     syncAllPriceUI();
//     triggerFetch();
//   });

//   /* --- Desktop: Duration Slider --- */
//   $(document).on("input", "#durationRangeMax", function () {
//     if (isResetting) return; // ← add this guard
//     state.duration_max = parseInt($(this).val(), 10);
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* --- Mobile: Duration Slider --- */
//   $(document).on("input", ".durationRangeMax_mobile", function () {
//     if (isResetting) return;

//     state.duration_max = parseInt($(this).val(), 10);
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* --- Desktop: Duration number inputs --- */
//   $(document).on("change", "#duration_min_input", function () {
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.duration_max)
//     );
//     state.duration_min = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });
//   $(document).on("change", "#duration_max_input", function () {
//     var val = Math.max(
//       state.duration_min,
//       Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
//     );
//     state.duration_max = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* --- Mobile: Duration number inputs --- */
//   $(document).on("change", ".duration_min_mobile", function () {
//     var val = Math.max(
//       0,
//       Math.min(parseInt($(this).val(), 10) || 0, state.duration_max)
//     );
//     state.duration_min = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });
//   $(document).on("change", ".duration_max_mobile", function () {
//     var val = Math.max(
//       state.duration_min,
//       Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
//     );
//     state.duration_max = val;
//     syncAllDurationUI();
//     triggerFetch();
//   });

//   /* --- Checkboxes: resolution, frame_rate, orientation, camera_movement, with_people ---
//        Single handler for ALL checkboxes in BOTH sidebars (event delegation)         */
//   $(document).on("change", "input.filter-check", function () {
//     var $cb = $(this);
//     var name = $cb.attr("name"); // e.g. "resolution[]" or "content_filters[]"
//     var key = name.replace("[]", ""); // e.g. "resolution" or "content_filters"
//     var val = $cb.val();

//     if (key === "with_people") {
//       // legacy standalone checkbox (if you still have it elsewhere)
//       state.with_people = $cb.is(":checked") ? "1" : "";
//       $('input.filter-check[name="with_people"]').prop(
//         "checked",
//         $cb.is(":checked")
//       );
//     } else if ($.isArray(state[key])) {
//       // Handles: resolution[], frame_rate[], orientation[],
//       //          camera_movement[], content_filters[]
//       if ($cb.is(":checked")) {
//         if ($.inArray(val, state[key]) === -1) {
//           state[key].push(val);
//         }
//       } else {
//         state[key] = $.grep(state[key], function (v) {
//           return v !== val;
//         });
//       }
//       // Keep desktop + mobile in sync
//       syncCheckboxes(name, state[key]);
//     }

//     triggerFetch();
//   });

//   /* --- License radio buttons --- */
//   $(document).on("change", 'input.filter-radio[name="license"]', function () {
//     state.license = $(this).is(":checked") ? $(this).val() : "";
//     // Sync both sidebars
//     $('input.filter-radio[name="license"]').prop("checked", false);
//     if (state.license) {
//       $(
//         'input.filter-radio[name="license"][value="' + state.license + '"]'
//       ).prop("checked", true);
//     }
//     triggerFetch();
//   });

//   /* --- Sort dropdown --- */
//   $(document).on("click", ".sort-btn", function () {
//     var $btn = $(this);
//     state.sort = $btn.data("value");

//     $(".sort-btn").removeClass("active");
//     $btn.addClass("active");
//     $("#selectedOption").text(sortLabels[state.sort] || "Most Relevant");

//     triggerFetch(0);
//   });

//   /* --- Trending tag pills --- */
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

//   /* --- Clear all (sidebar button + no-results button injected by AJAX) --- */
//   $(document).on(
//     "click",
//     "#clearAllFiltersBtn, #noResultsClearBtn",
//     function () {
//       resetAll();
//     }
//   );

//   /* --- View mode toggle --- */
//   $(document).on("click", ".view-btn", function () {
//     var $btn = $(this);
//     $(".view-btn").removeClass("active");
//     $btn.addClass("active");

//     var cols = $btn.data("cols");
//     $("#videoGrid").removeClass("cols-2 cols-1");
//     if (cols == 2) {
//       $("#videoGrid").addClass("cols-2");
//     }
//     if (cols == 1) {
//       $("#videoGrid").addClass("cols-1");
//     }
//   });
//   function initDualRangeSlider(
//     minRangeId,
//     maxRangeId,
//     minNumId,
//     maxNumId,
//     minLabelId,
//     maxLabelId
//   ) {
//     var minRange = document.getElementById(minRangeId);
//     var maxRange = document.getElementById(maxRangeId);
//     var minNum = document.getElementById(minNumId);
//     var maxNum = document.getElementById(maxNumId);
//     var minLabel = document.getElementById(minLabelId);
//     var maxLabel = document.getElementById(maxLabelId);

//     if (!minRange || !maxRange) return;

//     var wrap = maxRange.closest(".track-wrap");
//     var fill = wrap ? wrap.querySelector(".track-fill") : null;
//     var MAX = parseFloat(maxRange.max) || 100;
//     var MIN = parseFloat(maxRange.min) || 0;
//     var GAP = 1;

//     function update() {
//       var lo = parseFloat(minRange.value);
//       var hi = parseFloat(maxRange.value);

//       if (fill) {
//         fill.style.left = ((lo - MIN) / (MAX - MIN)) * 100 + "%";
//         fill.style.right = ((MAX - hi) / (MAX - MIN)) * 100 + "%";
//         fill.style.width = "auto"; // clear any conflicting width
//       }

//       if (minNum) minNum.value = lo;
//       if (maxNum) maxNum.value = hi;
//       if (minLabel) minLabel.textContent = "$" + lo;
//       if (maxLabel) maxLabel.textContent = "$" + hi;
//     }

//     // Remove old listeners by cloning (prevents duplicate bindings)
//     var newMin = minRange.cloneNode(true);
//     var newMax = maxRange.cloneNode(true);
//     minRange.parentNode.replaceChild(newMin, minRange);
//     maxRange.parentNode.replaceChild(newMax, maxRange);
//     minRange = newMin;
//     maxRange = newMax;

//     minRange.addEventListener("input", function () {
//       if (+minRange.value >= +maxRange.value - GAP) {
//         minRange.value = +maxRange.value - GAP;
//       }
//       update();
//     });

//     maxRange.addEventListener("input", function () {
//       if (+maxRange.value <= +minRange.value + GAP) {
//         maxRange.value = +minRange.value + GAP;
//       }
//       update();
//     });

//     update();
//   }
//   /* --- Mobile sidebar open / close --- */
//   $(document).on("click", "#mobileFilterToggle", function () {
//     $("#mobileFilterSidebar").toggleClass("open");
//   });

//   $(document).on("click", "#closeMobileFilter", function () {
//     $("#mobileFilterSidebar").removeClass("open");
//   });

//   // Close on outside click
//   $(document).on("click", function (e) {
//     if (
//       $("#mobileFilterSidebar").hasClass("open") &&
//       $(e.target).closest("#mobileFilterSidebar").length === 0 &&
//       $(e.target).closest("#mobileFilterToggle").length === 0
//     ) {
//       $("#mobileFilterSidebar").removeClass("open");
//     }
//   });

//   /* -------------------------------------------------------------------------
//        RE-BIND FAVORITES after AJAX swaps the grid HTML
//        Your favorites.js should listen:
//            $(document).on('videosGridRefreshed', function() { ... rebind ... });
//     -------------------------------------------------------------------------- */
//   function reBindFavorites() {
//     $(document).trigger("videosGridRefreshed", [{ grid: $("#videoGrid") }]);
//   }

//   /* -------------------------------------------------------------------------
//        INIT
//     -------------------------------------------------------------------------- */

//   renderChips();
//   syncAllPriceUI();
//   syncAllDurationUI();

//   initDualRangeSlider(
//     "priceRangeMin",
//     "priceRangeMax",
//     "price_min_input",
//     "price_max_input",
//     "priceMinLabel",
//     "priceMaxLabel"
//   );

//   initDualRangeSlider(
//     "durationRangeMin",
//     "durationRangeMax",
//     "duration_min_input",
//     "duration_max_input",
//     "durationMinLabel",
//     "durationMaxLabel"
//   );
// })(jQuery);
// /* -------------------------------------------------------------------------
//      INIT — Read URL params and restore state
//   -------------------------------------------------------------------------- */

// // class RangeSlider {
// //   constructor(el) {
// //     this.el = el;
// //     this.min = +el.dataset.min || 0;
// //     this.max = +el.dataset.max || 100;
// //     this.value = +el.dataset.value || this.min;

// //     this.create();
// //     this.updateUI();
// //     this.events();
// //   }

// //   create() {
// //     this.track = document.createElement("div");
// //     this.track.className = "range-track";

// //     this.fill = document.createElement("div");
// //     this.fill.className = "range-fill";

// //     this.thumb = document.createElement("div");
// //     this.thumb.className = "range-thumb";

// //     this.valueLabel = document.createElement("div");
// //     this.valueLabel.className = "range-value";

// //     this.track.appendChild(this.fill);
// //     this.track.appendChild(this.thumb);
// //     this.el.appendChild(this.track);
// //     this.el.appendChild(this.valueLabel);
// //   }

// //   updateUI() {
// //     const percent = ((this.value - this.min) / (this.max - this.min)) * 100;

// //     this.fill.style.width = percent + "%";
// //     this.thumb.style.left = percent + "%";
// //     this.valueLabel.textContent = this.value;
// //   }

// //   setValue(percent) {
// //     percent = Math.max(0, Math.min(100, percent));
// //     this.value = Math.round(this.min + (percent / 100) * (this.max - this.min));
// //     this.updateUI();
// //   }

// //   events() {
// //     const move = (e) => {
// //       const rect = this.track.getBoundingClientRect();
// //       const percent = ((e.clientX - rect.left) / rect.width) * 100;
// //       this.setValue(percent);
// //     };

// //     this.track.addEventListener("click", move);

// //     this.thumb.addEventListener("mousedown", () => {
// //       const onMove = (e) => move(e);
// //       const stop = () => {
// //         document.removeEventListener("mousemove", onMove);
// //         document.removeEventListener("mouseup", stop);
// //       };

// //       document.addEventListener("mousemove", onMove);
// //       document.addEventListener("mouseup", stop);
// //     });
// //   }
// // }

// // document.querySelectorAll(".range-slider").forEach((el) => {
// //   new RangeSlider(el);
// // });

// function initRangeSlider(inputId) {
//   var input = document.getElementById(inputId);
//   if (!input) return;

//   var wrap = input.closest(".track-wrap");
//   if (!wrap) return;

//   var fill = wrap.querySelector(".track-fill");
//   if (!fill) return;

//   function updateFill() {
//     var min = parseFloat(input.min) || 0;
//     var max = parseFloat(input.max) || 100;
//     var val = parseFloat(input.value) || 0;
//     var pct = ((val - min) / (max - min)) * 100;
//     fill.style.width = pct + "%";
//   }

//   updateFill();
//   input.addEventListener("input", updateFill);
// }

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

  var sortLabels = {
    relevant: "Most Relevant",
    newest: "Newest First",
    popular: "Most Popular",
    price_asc: "Price: Low to High",
    price_desc: "Price: High to Low",
    duration_asc: "Duration: Shortest",
    duration_desc: "Duration: Longest",
  };

  var debounceTimer = null;
  function triggerFetch(delay) {
    if (delay === undefined) delay = 350;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(doFetch, delay);
  }

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

  function doFetch() {
    var params = buildParams();
    var qs = $.param(params);
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
          '<div style="grid-column:1/-1;"><div class="alert alert-danger text-center m-3">Something went wrong. Please try again.</div></div>'
        );
      },
      complete: function () {
        $("#videoGrid").removeClass("loading");
        $("#videoLoader").addClass("d-none");
      },
    });
  }

  /* -------------------------------------------------------------------------
     FILL UPDATE — single source of truth, uses left+right (no width conflict)
  -------------------------------------------------------------------------- */
  function updateFill(minId, maxId, fillId) {
    var minEl = document.getElementById(minId);
    var maxEl = document.getElementById(maxId);
    var fill = document.getElementById(fillId);
    if (!minEl || !maxEl || !fill) return;

    var absMin = parseFloat(minEl.min) || 0;
    var absMax = parseFloat(minEl.max) || 100;
    var lo = parseFloat(minEl.value) || absMin;
    var hi = parseFloat(maxEl.value) || absMax;

    // Clamp to 0–100 to prevent floating point causing right < 0
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

  /* -------------------------------------------------------------------------
     UI SYNC — Price
  -------------------------------------------------------------------------- */
  function syncAllPriceUI() {
    var GAP = 1;
    if (state.price_min >= state.price_max)
      state.price_min = Math.max(0, state.price_max - GAP);
    if (state.price_max <= state.price_min)
      state.price_max = Math.min(MAX_PRICE, state.price_min + GAP);

    // Desktop sliders
    $("#priceRangeMin").val(state.price_min);
    $("#priceRangeMax").val(state.price_max);

    // Desktop number inputs
    $("#price_min_input").val(state.price_min);
    $("#price_max_input").val(state.price_max);

    // Desktop labels
    $("#priceMinLabel").text("$" + state.price_min);
    $("#priceMaxLabel").text("$" + state.price_max);

    // Mobile
    $(".price_min_mobile").val(state.price_min);
    $(".price_max_mobile").val(state.price_max);
    $(".priceMinLabel_mobile").text("$" + state.price_min);
    $(".priceMaxLabel_mobile").text("$" + state.price_max);

    updateFill("priceRangeMin", "priceRangeMax", "priceTrackFill");
  }

  /* -------------------------------------------------------------------------
     UI SYNC — Duration
  -------------------------------------------------------------------------- */
  function syncAllDurationUI() {
    var GAP = 1;
    if (state.duration_min >= state.duration_max)
      state.duration_min = Math.max(0, state.duration_max - GAP);
    if (state.duration_max <= state.duration_min)
      state.duration_max = Math.min(MAX_DURATION, state.duration_min + GAP);

    var labelMin = state.duration_min + "s";
    var labelMax =
      state.duration_max + (state.duration_max >= MAX_DURATION ? "s+" : "s");

    // Desktop sliders
    $("#durationRangeMin").val(state.duration_min);
    $("#durationRangeMax").val(state.duration_max);

    // Desktop number inputs
    $("#duration_min_input").val(state.duration_min);
    $("#duration_max_input").val(state.duration_max);

    // Desktop labels
    $("#durationMinLabel").text(labelMin);
    $("#durationMaxLabel").text(labelMax);

    // Mobile
    $(".duration_min_mobile").val(state.duration_min);
    $(".duration_max_mobile").val(state.duration_max);
    $(".durationMinLabel_mobile").text(labelMin);
    $(".durationMaxLabel_mobile").text(labelMax);

    updateFill("durationRangeMin", "durationRangeMax", "durationTrackFill");
  }

  /* -------------------------------------------------------------------------
     RESET ALL
  -------------------------------------------------------------------------- */
  function resetAll(skipFetch) {
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

    syncAllPriceUI();
    syncAllDurationUI();
    isResetting = false;

    if (!skipFetch) triggerFetch(0);
  }

  /* -------------------------------------------------------------------------
     CHIPS
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
     EVENT BINDINGS — Price sliders
     NOTE: jQuery delegated events work on the live DOM by ID so cloning
           is NOT needed and NOT done here.
  ========================================================================= */

  /* Price MIN slider */
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

  /* Price MAX slider */
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

  /* Price MIN number input */
  $(document).on("input", "#price_min_input", function () {
    if (isResetting) return;
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.price_max - 1)
    );
    state.price_min = val;
    syncAllPriceUI();
    triggerFetch(150);
  });

  /* Price MAX number input */
  $(document).on("input", "#price_max_input", function () {
    if (isResetting) return;
    var val = Math.max(
      state.price_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
    );
    state.price_max = val;
    syncAllPriceUI();
    triggerFetch(150);
  });

  /* Mobile price */
  $(document).on("input", ".priceRangeMax_mobile", function () {
    if (isResetting) return;
    state.price_max = parseInt($(this).val(), 10);
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("change", ".price_min_mobile", function () {
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.price_max - 1)
    );
    state.price_min = val;
    syncAllPriceUI();
    triggerFetch();
  });
  $(document).on("change", ".price_max_mobile", function () {
    var val = Math.max(
      state.price_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_PRICE, MAX_PRICE)
    );
    state.price_max = val;
    syncAllPriceUI();
    triggerFetch();
  });

  /* =========================================================================
     EVENT BINDINGS — Duration sliders
  ========================================================================= */

  /* Duration MIN slider */
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

  /* Duration MAX slider */
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

  /* Duration number inputs */
  $(document).on("input", "#duration_min_input", function () {
    if (isResetting) return;
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.duration_max - 1)
    );
    state.duration_min = val;
    syncAllDurationUI();
    triggerFetch(150);
  });
  $(document).on("input", "#duration_max_input", function () {
    if (isResetting) return;
    var val = Math.max(
      state.duration_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
    );
    state.duration_max = val;
    syncAllDurationUI();
    triggerFetch(150);
  });

  /* Mobile duration */
  $(document).on("input", ".durationRangeMax_mobile", function () {
    if (isResetting) return;
    state.duration_max = parseInt($(this).val(), 10);
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("change", ".duration_min_mobile", function () {
    var val = Math.max(
      0,
      Math.min(parseInt($(this).val(), 10) || 0, state.duration_max - 1)
    );
    state.duration_min = val;
    syncAllDurationUI();
    triggerFetch();
  });
  $(document).on("change", ".duration_max_mobile", function () {
    var val = Math.max(
      state.duration_min + 1,
      Math.min(parseInt($(this).val(), 10) || MAX_DURATION, MAX_DURATION)
    );
    state.duration_max = val;
    syncAllDurationUI();
    triggerFetch();
  });

  /* =========================================================================
     OTHER EVENT BINDINGS
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
      $(e.target).closest("#mobileFilterSidebar").length === 0 &&
      $(e.target).closest("#mobileFilterToggle").length === 0
    ) {
      $("#mobileFilterSidebar").removeClass("open");
    }
  });

  function reBindFavorites() {
    $(document).trigger("videosGridRefreshed", [{ grid: $("#videoGrid") }]);
  }

  /* -------------------------------------------------------------------------
     INIT
  -------------------------------------------------------------------------- */
  renderChips();
  syncAllPriceUI();
  syncAllDurationUI();
})(jQuery);

/* -------------------------------------------------------------------------
   Video hover play/pause
-------------------------------------------------------------------------- */
$(document).on("mouseenter", ".product-img", function () {
  this.play().catch(() => {});
});
$(document).on("mouseleave", ".product-img", function () {
  this.pause();
  this.currentTime = 0;
});
