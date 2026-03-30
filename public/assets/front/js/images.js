function initDualRangeSlider(
  minRangeId,
  maxRangeId,
  minNumId,
  maxNumId,
  minLabelId,
  maxLabelId
) {
  var minRange = document.getElementById(minRangeId);
  var maxRange = document.getElementById(maxRangeId);
  var minNum = document.getElementById(minNumId);
  var maxNum = document.getElementById(maxNumId);
  var minLabel = document.getElementById(minLabelId);
  var maxLabel = document.getElementById(maxLabelId);

  if (!minRange || !maxRange) return;

  var wrap = maxRange.closest(".track-wrap");
  var fill = wrap ? wrap.querySelector(".track-fill") : null;
  var MAX = parseFloat(maxRange.max) || 100;
  var MIN = parseFloat(maxRange.min) || 0;
  var GAP = 1;

  function update() {
    var lo = parseFloat(minRange.value);
    var hi = parseFloat(maxRange.value);

    // fill: left% to right% — same as your raw HTML demo
    if (fill) {
      fill.style.left = ((lo - MIN) / (MAX - MIN)) * 100 + "%";
      fill.style.right = ((MAX - hi) / (MAX - MIN)) * 100 + "%";
    }

    if (minNum) minNum.value = lo;
    if (maxNum) maxNum.value = hi;
    if (minLabel) minLabel.textContent = "$" + lo;
    if (maxLabel) maxLabel.textContent = "$" + hi;
  }

  minRange.addEventListener("input", function () {
    if (+minRange.value >= +maxRange.value - GAP) {
      minRange.value = +maxRange.value - GAP;
    }
    update();
  });

  maxRange.addEventListener("input", function () {
    if (+maxRange.value <= +minRange.value + GAP) {
      maxRange.value = +minRange.value + GAP;
    }
    update();
  });

  if (minNum) {
    minNum.addEventListener("input", function () {
      var v = Math.min(
        Math.max(parseFloat(this.value) || MIN, MIN),
        +maxRange.value - GAP
      );
      minRange.value = v;
      update();
    });
  }

  if (maxNum) {
    maxNum.addEventListener("input", function () {
      var v = Math.max(
        Math.min(parseFloat(this.value) || MAX, MAX),
        +minRange.value + GAP
      );
      maxRange.value = v;
      update();
    });
  }

  update();
}

(function () {
  const gridWrapper = document.getElementById("photo-grid-wrapper");
  const countEl = document.getElementById("photo-count");
  const clearBtn = document.getElementById("clearAllFiltersBtn");
  const loadMoreBtn = document.getElementById("loadMoreBtn");
  const loadMoreWrapper = document.getElementById("load-more-wrapper");
  const loadMoreText = document.getElementById("loadMoreText");
  const loadMoreSpinner = document.getElementById("loadMoreSpinner");
  //   const baseUrl = "{{ route('all_photos') }}";
  const baseUrl = base_url + "/allPhotos";

  if (!gridWrapper) return;

  let currentPage = 1;

  function getFilterParams(page) {
    const params = new URLSearchParams();

    // Preserve search query from URL
    const q = new URLSearchParams(window.location.search).get("q");
    if (q) params.set("q", q);

    // Price min
    const priceMinEl = document.getElementById("price_min_input");
    const priceMinVal = parseFloat(priceMinEl?.value) || 0;
    if (priceMinEl && priceMinVal > 0) {
      params.set("price_min", priceMinVal);
    }

    // Price max
    const priceMaxEl = document.getElementById("price_max_input");
    const priceMaxVal = parseFloat(priceMaxEl?.value);
    const priceMaxMax = parseFloat(priceMaxEl?.max);
    if (priceMaxEl && priceMaxVal < priceMaxMax) {
      params.set("price_max", priceMaxVal);
    }

    // Category checkboxes
    document
      .querySelectorAll(".parent-category-check:checked")
      .forEach((cb) => {
        params.append("category_id[]", cb.value);
      });

    document.querySelectorAll(".collection-check:checked").forEach((cb) => {
      params.append("collection_ids[]", cb.value);
    });

    // Subcategory checkboxes
    document.querySelectorAll(".sub-category-check:checked").forEach((cb) => {
      params.append("subcategory_id[]", cb.value);
    });

    // Orientation + Content filters
    document
      .querySelectorAll(
        ".filter-check:not(.parent-category-check):not(.sub-category-check):not(.collection-check):checked"
      )
      .forEach((cb) => {
        params.append(cb.name, cb.value);
      });

    params.set("page", page || 1);
    return params;
  }

  function applyFilters() {
    currentPage = 1;
    gridWrapper.style.opacity = "0.4";
    gridWrapper.style.pointerEvents = "none";

    fetch(`${baseUrl}?${getFilterParams(1).toString()}`, {
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((res) => res.json())
      .then((data) => {
        gridWrapper.innerHTML = data.html;
        gridWrapper.style.opacity = "1";
        gridWrapper.style.pointerEvents = "auto";
        const visibleItems = gridWrapper.children.length;
        countEl.textContent = `Showing ${visibleItems} photo(s)`;
        if (loadMoreWrapper) {
          loadMoreWrapper.style.display = data.hasMore ? "block" : "none";
        }
      })
      .catch(() => {
        gridWrapper.style.opacity = "1";
        gridWrapper.style.pointerEvents = "auto";
      });
  }

  function smoothScrollToBottom(container, duration = 600) {
    const start = container.scrollTop;
    const end = container.scrollHeight;
    const change = end - start;
    const startTime = performance.now();

    function animateScroll(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);

      // easeOutCubic (very smooth)
      const ease = 1 - Math.pow(1 - progress, 3);

      container.scrollTop = start + change * ease;

      if (progress < 1) {
        requestAnimationFrame(animateScroll);
      }
    }

    requestAnimationFrame(animateScroll);
  }

  function loadMore() {
    currentPage++;
    if (loadMoreText) loadMoreText.textContent = "Loading...";
    if (loadMoreSpinner) loadMoreSpinner.classList.remove("d-none");
    if (loadMoreBtn) loadMoreBtn.disabled = true;

    fetch(`${baseUrl}?${getFilterParams(currentPage).toString()}`, {
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((res) => res.json())
      .then((data) => {
        gridWrapper.insertAdjacentHTML("beforeend", data.html);
        setTimeout(() => {
          smoothScrollToBottom(gridWrapper);
        }, 50);
        if (countEl) countEl.textContent = `Showing ${data.count} photo(s)`;
        if (loadMoreText) loadMoreText.textContent = "Load More";
        if (loadMoreSpinner) loadMoreSpinner.classList.add("d-none");
        if (loadMoreBtn) loadMoreBtn.disabled = false;
        if (!data.hasMore && loadMoreWrapper) {
          loadMoreWrapper.style.display = "none";
        }
      })
      .catch(() => {
        if (loadMoreText) loadMoreText.textContent = "Load More";
        if (loadMoreSpinner) loadMoreSpinner.classList.add("d-none");
        if (loadMoreBtn) loadMoreBtn.disabled = false;
      });
  }

  function debounce(fn, delay = 500) {
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => fn(...args), delay);
    };
  }

  const debouncedApply = debounce(applyFilters);

  // Price range (min + max) + checkboxes
  document
    .querySelectorAll(
      "#price_min_input, #price_max_input, #priceRangeMin, #priceRangeMax, .filter-check"
    )
    .forEach((el) => {
      el.addEventListener("change", debouncedApply);
      if (el.type === "number" || el.type === "range") {
        el.addEventListener("input", debouncedApply);
      }
    });

  // Parent category toggle — REPLACE your existing handler
  document.addEventListener("change", function (e) {
    if (!e.target.classList.contains("parent-category-check")) return;

    const subList = document.getElementById(
      `sub_${e.target.dataset.categoryId}`
    );
    if (subList) {
      if (e.target.checked) {
        subList.style.display = "block";
      } else {
        subList.style.display = "none";
        // ✅ Uncheck AND visually clear all subcategory checkboxes
        subList.querySelectorAll(".sub-category-check").forEach((cb) => {
          cb.checked = false;
        });
      }
    }

    debouncedApply();
  });

  // Subcategory change
  document.addEventListener("change", function (e) {
    if (!e.target.classList.contains("sub-category-check")) return;
    debouncedApply();
  });
  document.addEventListener("change", function (e) {
    if (!e.target.classList.contains("collection-check")) return;
    debouncedApply();
  });

  // Load more button
  loadMoreBtn?.addEventListener("click", loadMore);

  // Clear all
  clearBtn?.addEventListener("click", function () {
    document
      .querySelectorAll(".filter-check")
      .forEach((cb) => (cb.checked = false));
    document.querySelectorAll(".subcategory-list").forEach((el) => {
      el.style.display = "none";
      el.querySelectorAll(".sub-category-check").forEach(
        (cb) => (cb.checked = false)
      );
    });
    const minEl = document.getElementById("price_min_input");
    const maxEl = document.getElementById("price_max_input");
    const minRange = document.getElementById("priceRangeMin");
    const maxRange = document.getElementById("priceRangeMax");
    const minLabel = document.getElementById("priceMinLabel");
    const maxLabel = document.getElementById("priceMaxLabel");

    if (minEl) minEl.value = minEl.min || 0;
    if (maxEl) maxEl.value = maxEl.max;
    if (minRange) minRange.value = minRange.min || 0;
    if (maxRange) maxRange.value = maxRange.max;
    if (minLabel) minLabel.textContent = "$0.00";
    if (maxLabel && maxEl)
      maxLabel.textContent = "$" + parseFloat(maxEl.max).toFixed(2);

    // Re-sync fill without dispatchEvent
    var wrap = maxRange?.closest(".track-wrap");
    var fill = wrap?.querySelector(".track-fill");
    if (fill) {
      fill.style.left = "0%";
      fill.style.width = "100%";
    }

    applyFilters();
  });

  // No results clear button (dynamically rendered)
  document.addEventListener("click", function (e) {
    if (e.target.closest("#noResultsClearBtn")) clearBtn?.click();
  });

  // Init dual range slider
  initDualRangeSlider(
    "priceRangeMin",
    "priceRangeMax",
    "price_min_input",
    "price_max_input",
    "priceMinLabel",
    "priceMaxLabel"
  );
})();
