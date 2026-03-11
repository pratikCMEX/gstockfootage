// batch

var base_url = $("#base_url").val();
let filteropenbtn = document.getElementById("search_filter");
let filteropensmall = document.getElementById("search_filter_mobile");
let filterclosebtn = document.getElementById("close-filter");
let filtercontent = document.getElementById("search-filter-content");
let batchitems = document.querySelector("#batch-content-active");
filteropenbtn?.addEventListener("click", function () {
  filtercontent.classList.add("filtershow");
  batchitems.classList.add("batch-show-content");
});
filterclosebtn?.addEventListener("click", function () {
  filtercontent.classList.remove("filtershow");
  batchitems.classList.remove("batch-show-content");
  filtercontent.classList.remove("filtershowsmall");
});
filteropensmall?.addEventListener("click", function () {
  filtercontent.classList.add("filtershowsmall");
});

// more detail dropdown
$(document).on("click", ".more-detail-btn", function () {
  let parent = $(this).closest(".batch-content");
  let table = parent.find(".batch-content-table-details");
  table.slideToggle(300);
  $(this).toggleClass("active");
});

$(document).on("click", ".batch-dropdown-menu .dropdown-item", function (e) {
  e.preventDefault();
  // image size big to small range
  const slider = document.querySelector(".slider");
  function updateProgress() {
    const value =
      ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
    slider.style.setProperty("--progress", value + "%");
  }
  slider.addEventListener("input", updateProgress);
  updateProgress();

  let value = $(this).data("value");
  let text = $(this).text();
  $("#submission_type").val(value);
  $(".batch-dropdown").html(text + ' <i class="fa-solid fa-angle-down"></i>');
});
$("#create_batch").validate({
  ignore: [], // IMPORTANT → validate hidden inputs

  onkeyup: false,
  rules: {
    submission_type: {
      required: true,
    },
    // brief_code: {
    //   // required: true,
    //   remote: {
    //     headers: {
    //       "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //     },
    //     url: base_url + "/admin/batch/check_brief_code",
    //     type: "POST",
    //     data: {
    //       brief_code: function () {
    //         return $("#brief_code").val();
    //       },
    //       id: function () {
    //         return null;
    //       },
    //     },
    //   },
    // },
    batch_name: {
      required: true,
    },
  },
  messages: {
    submission_type: {
      required: "Please select submission type",
    },
    // brief_code: {
    //   remote: "This brief code already exists",
    // },
    batch_name: {
      required: "Please select batch name",
    },
  },
  normalizer: function (value) {
    return $.trim(value);
  },

  errorClass: "text-danger",
  errorElement: "span",
  highlight: function (element) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element) {
    $(element).removeClass("is-invalid");
  },
  submitHandler: function (form) {
    $(form)
      .find('button[type="submit"]')
      .prop("disabled", true)
      .text("Please wait...");

    form.submit();
  },
});

// upload
let openupload = document.querySelector(".upload-btn");
let uploadcontent = document.querySelector(".upload-from-device");
let closeupload = document.querySelector(".upload-close-btn");
openupload?.addEventListener("click", function () {
  uploadcontent.classList.add("active");
});
closeupload?.addEventListener("click", function () {
  uploadcontent.classList.remove("active");
});
// upload search filter
let uploadfiltermobile = document.querySelector("#upload_search_filter_mobile");
let uploadfilteropen = document.querySelector("#upload_search_filter");
let uploadfiltercontent = document.querySelector(".upload-search-filter");
let uploadfilterclose = document.querySelector("#upload_close-filter");
uploadfilteropen?.addEventListener("click", function () {
  uploadfiltercontent.classList.add("active");
});
uploadfiltermobile?.addEventListener("click", function () {
  uploadfiltercontent.classList.add("mobileactive");
});
uploadfilterclose?.addEventListener("click", function () {
  uploadfiltercontent.classList.remove("active");
  uploadfiltercontent.classList.remove("mobileactive");
});
// img click
let selectedImages = document.querySelectorAll(".upload-image");
// let uploadimages = document.querySelector("#upload_images");
let nofileselected = document.querySelector(".no-file-selected");
let nofilekeyword = document.querySelector(".no-file-keywording");
let uploadimgclose = document.querySelector(".close-select-btn");
let addmetadata = document.querySelector(".add-metadata");
let selectimgdrop = document.querySelector(".select-img");

document.querySelectorAll(".dot-dropdown").forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.stopPropagation();
  });
});
document.querySelectorAll(".dropdown-item-upload").forEach((menu) => {
  menu.addEventListener("click", (e) => {
    e.stopPropagation();
  });
});

uploadimgclose?.addEventListener("click", function () {
  selectimgdrop.classList.remove("active");
  nofileselected.classList.remove("active");
  nofilekeyword.classList.remove("active");
  addmetadata.classList.remove("active");
  viewdata.classList.remove("notactive");
  selectedImages?.forEach((item) => {
    item.classList.remove("selected");
  });
  function updateProgress() {
    const value =
      ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
    slider.style.setProperty("--progress", value + "%");
  }

  slider.addEventListener("input", updateProgress);
  updateProgress();
});

// view metadata
let viewdata = document.querySelector(".view-metadata");
let mobilemetadata = document.querySelector(".mobile-no-file-selcted-btn");
viewdata?.addEventListener("click", function () {
  nofileselected.classList.add("active");
});
addmetadata?.addEventListener("click", function () {
  nofileselected.classList.add("showaddmetadataactive");
});
mobilemetadata?.addEventListener("click", function () {
  nofileselected.classList.remove("active");
  nofileselected.classList.remove("showaddmetadataactive");
});

document.addEventListener("DOMContentLoaded", () => {
  const tagsInput = document.getElementById("tags");

  if (tagsInput) {
    tagsInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        const tagValue = tagsInput.value.trim();

        if (tagValue) {
          console.log("Tag added:", tagValue);
          tagsInput.value = "";
        }
      }
    });
  }
});

const slider = document.getElementById("rangeSlider");

function updateSliderProgress() {
  if (!slider) return;

  const min = slider.min;
  const max = slider.max;
  const val = slider.value;

  const percentage = ((val - min) / (max - min)) * 100;
  slider.style.setProperty("--progress", percentage + "%");
}

if (slider) {
  updateSliderProgress();
  slider.addEventListener("input", updateSliderProgress);
}

const classNames = [
  "",
  "images-content-1",
  "images-content-2",
  "images-content-3",
  "images-content-4",
  "images-content-5",
];

$("#rangeSlider").on("input", function () {
  let value = parseInt($(this).val());

  $(".images-content")
    .removeClass(classNames.join(" "))
    .addClass(classNames[6 - value]); // reverse logic
});

// $(document).ready(function () {
function updateUI() {
  let images = $(".upload-image");
  let selectedCount = images.filter(".selected").length;
  let total = images.length;
  let button = $(".select-btn");
  $("#tags").tagsinput("removeAll");
  updateKeywordCount();
  // 🔥 Update Select All Button Text
  if (selectedCount === total && total > 0) {
    button.text("Deselect All");
  } else {
    button.text("Select All");
  }

  // 🔥 Update Delete Count
  $(".delete-count").text(selectedCount);

  // 🔥 Hide count if 0 (optional cleaner UI)
  if (selectedCount === 0) {
    $(".delete-count").hide();
    $(".total_file_selected").text("No File Selected");
  } else {
    $(".delete-count").show();
    $(".total_file_selected").text(selectedCount + " File Selected");
  }

  // Panels
  if (images.length == 0) {
    $(".data-empty").removeClass("d-none");
  } else {
    $(".data-empty").addClass("d-none");
  }
  if (selectedCount > 0) {
    selectimgdrop?.classList.add("active");
    viewdata?.classList.add("notactive");
    addmetadata?.classList.add("active");
    if (selectedCount === 1) {
      nofileselected?.classList.add("active");
    }
  } else {
    selectimgdrop?.classList.remove("active");
    viewdata?.classList.remove("notactive");
    addmetadata?.classList.remove("active");
    nofileselected?.classList.remove("active");
  }
}

// 🔥 Image Click Logic (Fixed)
$(document).on("click", ".upload-image", function (e) {
  let data_id = $(this).attr("data-id");

  if ($(e.target).closest(".dot-menu").length) return;

  let images = $(".upload-image");
  let selectedCount = images.filter(".selected").length;
  let total = images.length;
  let isSelected = $(this).hasClass("selected");

  if (selectedCount === total) {
    // If ALL were selected → remove only this one
    $(this).removeClass("selected");
  } else if (selectedCount > 1) {
    // If multiple selected (from Select All or other logic)
    $(this).toggleClass("selected");
  } else {
    // Only one allowed manually
    images.removeClass("selected");

    if (!isSelected) {
      $(this).addClass("selected");
    }
  }

  updateUI();
  if ($(this).hasClass("selected")) {
    loadImageMetadata(data_id);
  } else {
    clearMetadata();
  }
});

function formatFileSize(bytes) {
  if (bytes >= 1073741824) {
    return (bytes / 1073741824).toFixed(2) + " GB";
  } else if (bytes >= 1048576) {
    return (bytes / 1048576).toFixed(2) + " MB";
  } else if (bytes >= 1024) {
    return (bytes / 1024).toFixed(2) + " KB";
  } else {
    return bytes + " bytes";
  }
}

function formatDuration(seconds) {
  let hrs = Math.floor(seconds / 3600);
  let mins = Math.floor((seconds % 3600) / 60);
  let secs = Math.floor(seconds % 60);

  return [
    hrs.toString().padStart(2, "0"),
    mins.toString().padStart(2, "0"),
    secs.toString().padStart(2, "0"),
  ].join(":");
}

console.log(formatFileSize(6355361));
function loadImageMetadata(file_id) {
  $.ajax({
    url: base_url + "/admin/batch/get_file_metadata",
    type: "POST",
    data: {
      file_id: file_id,
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (res) {
      // fill form
      console.log(res);
      $("input[name='file_id']").val(res.id);
      $("input[name='title']").val(res.title);
      $("input[name='description']").val(res.description);
      $("input[name='date_created']").val(res.date_created);
      $("input[name='clip_length']").val(formatDuration(res.duration));
      $("input[name='frame_rate']").val(res.frame_rate);
      $("input[name='date_created']").val(res.date_created);
      $("input[name='frame_size']").val(res.height + "x" + res.width);
      $("input[name='image_height']").val(res.height);
      $("input[name='image_width']").val(res.width);

      $("#tags").tagsinput("removeAll");

      if (res.keywords) {
        let tags = res.keywords.split(",");

        tags.forEach(function (tag) {
          $("#tags").tagsinput("add", tag.trim());
        });
        updateKeywordCount();
      }
    },
    error: function (xhr) {
      console.log(xhr.responseText);
      console.log($('meta[name="csrf-token"]').attr("content"));
    },
  });
}

$(document).on("click", ".clear-data", function () {
  clearMetadata();
  updateUI();
});
function clearMetadata() {
  $(".all-inputs")
    .find("input, textarea, select")
    .each(function () {
      $(this).val("");
    });
}

function updateKeywordCount() {
  let count = $("#tags").tagsinput("items").length;
  $(".add-keyword span").text(count);
}
$("#tags").on("itemAdded itemRemoved", function () {
  updateKeywordCount();
});

$(document).on("click", "#save-metadata", function () {
  let formData = {
    file_id: $("#selected_file_id").val(),
    title: $("input[name='title']").val(),
    description: $("input[name='description']").val(),
    date_created: $("input[name='date_created']").val(),
    tags: $("input[name='tags']").val(),
    _token: $('meta[name="csrf-token"]').attr("content"),
  };

  $.ajax({
    url: base_url + "/admin/batch/save_file_metadata",
    type: "POST",
    data: formData,

    success: function (res) {
      toastr.success("File metadata saved successfully");
    },

    error: function (xhr) {
      console.log(xhr.responseText);
    },
  });
});
// Select All Button
$(document).on("click", ".select-btn", function () {
  let images = $(".upload-image");
  let allSelected = images.length === images.filter(".selected").length;

  // if (allSelected == 1) {
  if (allSelected) {
    images.removeClass("selected");
  } else {
    images.addClass("selected");
  }
  // }
  updateUI();
});
$(document).on("click", ".delete-btn-batch", function () {
  let selectedImages = $(".upload-image.selected");

  if (selectedImages.length > 0) {
    let formData = new FormData();

    selectedImages.each(function () {
      formData.append("ids[]", $(this).data("id"));
    });

    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

    $.ajax({
      url: base_url + "/admin/batch_delete",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,

      beforeSend: function () {
        console.log("Deleting...");
      },

      success: function (response) {
        if (response.status === true) {
          selectedImages.remove(); // remove only selected
          updateUI();
          toastr.success(response.message);
        }
      },

      error: function (xhr) {
        console.log(xhr.responseText);
      },
    });
  }
});

const MAX_VISIBLE = 4;
let allFiles = []; // { id, file, category }
let idCounter = 0;

// ─────────────────────────────────────────────
// DOM REFS  (safe — called after DOM ready)
// ─────────────────────────────────────────────
const fileInput = document.getElementById("myfile"); // hidden input (Select file)
const fileInput2 = document.getElementById("111myfile"); // hidden input (Upload from device)
const strip = document.getElementById("previewStrip");
const thumbsWrap = document.getElementById("previewThumbs");
const previewLabel = document.getElementById("previewLabel");
// const clearAllBtn = document.getElementById("clearAll");

function getCategory(file) {
  const n = file.name.toLowerCase();
  if (/\.(jpg|jpeg|png|gif|webp|bmp)$/.test(n)) return "image";
  if (/\.(mp4|mov|mxf|avi|mkv|webm)$/.test(n)) return "video";
  if (/\.(zip|rar|7z|tar|gz)$/.test(n)) return "zip";
  return "other";
}

[fileInput, fileInput2].forEach((inp) => {
  if (!inp) return;

  inp.addEventListener("change", () => {
    if (inp.files && inp.files.length) {
      addFiles(inp.files);
    }

    inp.value = "";
  });
});

const dndZone = document.querySelector("#dndZone");

if (dndZone) {
  dndZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    e.stopPropagation();
  });

  dndZone.addEventListener("drop", (e) => {
    e.preventDefault();
    e.stopPropagation();

    const items = e.dataTransfer.items;
    console.log("DROP FIRED");
    console.log("items:", items);
    console.log("files:", e.dataTransfer.files);
    console.log("data-type attribute:", dndZone.getAttribute("data-type"));

    // const items = e.dataTransfer.items;
    if (!items || !items.length) return;

    const files = [];
    for (let i = 0; i < items.length; i++) {
      const file = items[i].getAsFile();
      console.log(`File ${i}:`, {
        name: file?.name,
        type: file?.type, // often "" for zips
        size: file?.size,
        kind: items[i].kind, // should be "file"
      });
      if (file) files.push(file);
    }

    if (!files.length) return;

    const fileType = dndZone.getAttribute("data-type");

    if (fileType === "image") {
      const validFiles = files.filter(
        (file) =>
          file.type.startsWith("image/") ||
          /\.(zip|rar|7z|tar|gz)$/i.test(file.name) // ✅ allow zip in image zone
      );
      if (validFiles.length) addFiles(validFiles);
    } else if (fileType === "video") {
      const validFiles = files.filter(
        (file) =>
          file.type.startsWith("video/") ||
          /\.(zip|rar|7z|tar|gz)$/i.test(file.name) // ✅ allow zip in video zone
      );
      if (validFiles.length) addFiles(validFiles);
    } else {
      // zip-only zone or fallback
      const zipFiles = files.filter((file) =>
        /\.(zip|rar|7z|tar|gz)$/i.test(file.name)
      );
      if (zipFiles.length) addFiles(zipFiles);
    }
  });
}
function addFiles(list) {
  Array.from(list).forEach((f) => {
    allFiles.push({
      id: ++idCounter,
      file: f,
      url: URL.createObjectURL(f), // create once
      category: getCategory(f),
    });
  });

  render();
}

function render() {
  console.log("visible", allFiles);

  thumbsWrap.innerHTML = "";

  if (!allFiles.length) {
    strip.classList.remove("visible");
    return;
  }

  strip.classList.add("visible");

  const total = allFiles.length;
  const visible = allFiles; // Include all files
  const extra = total - MAX_VISIBLE;

  previewLabel.textContent =
    total + " file" + (total !== 1 ? "s" : "") + " selected";

  visible.forEach(({ id, file, url, category }) => {
    const thumb = document.createElement("div");
    thumb.className = "p-thumb";

    let inner = "";

    if (category === "image") {
      inner = `<img src="${url}" alt="">
               <span class="p-badge p-badge-img">IMG</span>`;
    } else if (category === "video") {
      inner = `<video src="${url}" muted preload="metadata"></video>
               <div class="p-vid-overlay"><i class="fa-solid fa-play"></i></div>
               <span class="p-badge p-badge-vid">VID</span>`;
    } else if (category === "zip") {
      const ext = file.name.split(".").pop().toUpperCase();
      inner = `<div class="p-thumb-zip">
                 <i class="fa-solid fa-file-zipper"></i>
                 <span>${ext}</span>
               </div>
               <span class="p-badge p-badge-zip">ZIP</span>`;
    } else {
      const ext = file.name.split(".").pop().toUpperCase();
      inner = `<div class="p-thumb-zip">
                 <i class="fa-solid fa-file-zipper"></i>
                 <span>${ext}</span>
               </div>
               <span class="p-badge p-badge-zip">ZIP</span>`;
    }
    inner += `<button class="p-remove" data-id="${id}">
                <i class="fa-solid fa-xmark"></i>
              </button>`;

    thumb.innerHTML = inner;
    thumbsWrap.appendChild(thumb);
  });

  // +N more bubble
  if (extra > 0) {
    const more = document.createElement("div");
    more.className = "p-thumb-more";
    more.innerHTML = `+${extra}<span class="more-sub">more</span>`;
    thumbsWrap.appendChild(more);
  }
}
// remove file
let counterRaf = null;

function startUploadToast() {
  const toast = document.getElementById("uploadToast");
  const barFill = document.getElementById("barFill");
  const pctLabel = document.getElementById("pctLabel");
  const toastTitle = document.getElementById("toastTitle");
  const toastSub = document.getElementById("toastSub");
  const waitText = document.getElementById("waitText");
  const successMsg = document.getElementById("successMsg");
  const spinRing = document.getElementById("spinRing");
  const checkRing = document.getElementById("checkRing");
  const counterBox = document.getElementById("counterBox");

  // Reset
  cancelAnimationFrame(counterRaf);
  barFill.style.transition = "none";
  barFill.style.width = "0%";
  pctLabel.textContent = "0";
  toastTitle.textContent = "Uploading...";
  toastSub.textContent = "Image upload in progress";
  waitText.style.display = "flex";
  successMsg.style.display = "none";
  counterBox.style.display = "flex";
  spinRing.style.display = "block";
  checkRing.style.display = "none";

  // Show toast
  toast.classList.add("show");

  // Animate bar slowly (won't finish — stopped on success)
  barFill.style.transition = "width 25s linear";
  barFill.style.width = "90%";

  // Count 0 → 90 slowly (fake progress)
  const totalMs = 25000;
  const startTime = performance.now();

  function tick(now) {
    const elapsed = now - startTime;
    const progress = Math.min(elapsed / totalMs, 1);
    const eased = 1 - Math.pow(1 - progress, 2);
    const val = Math.min(Math.floor(eased * 90), 90);
    pctLabel.textContent = val;
    if (progress < 1) counterRaf = requestAnimationFrame(tick);
  }
  counterRaf = requestAnimationFrame(tick);
}

function completeUploadToast() {
  const toast = document.getElementById("uploadToast");
  const barFill = document.getElementById("barFill");
  const pctLabel = document.getElementById("pctLabel");
  const toastTitle = document.getElementById("toastTitle");
  const toastSub = document.getElementById("toastSub");
  const waitText = document.getElementById("waitText");
  const successMsg = document.getElementById("successMsg");
  const spinRing = document.getElementById("spinRing");
  const checkRing = document.getElementById("checkRing");
  const counterBox = document.getElementById("counterBox");

  cancelAnimationFrame(counterRaf);

  // Shoot to 100%
  barFill.style.transition = "width 0.4s ease";
  barFill.style.width = "100%";

  // Count remaining → 100
  const start = parseInt(pctLabel.textContent) || 90;
  const duration = 400;
  const startTime = performance.now();

  function finish(now) {
    const progress = Math.min((now - startTime) / duration, 1);
    pctLabel.textContent = Math.floor(start + (100 - start) * progress);
    if (progress < 1) {
      requestAnimationFrame(finish);
    } else {
      pctLabel.textContent = "100";

      // Switch to success state
      setTimeout(() => {
        toastTitle.textContent = "Upload Complete";
        toastSub.textContent = "Your image is ready";
        waitText.style.display = "none";
        counterBox.style.display = "none";
        successMsg.style.display = "block";
        spinRing.style.display = "none";
        checkRing.style.display = "block";

        // Auto-dismiss after 3s
        setTimeout(() => toast.classList.remove("show"), 3000);
      }, 300);
    }
  }
  requestAnimationFrame(finish);
}

function failUploadToast() {
  const toast = document.getElementById("uploadToast");
  const toastTitle = document.getElementById("toastTitle");
  const toastSub = document.getElementById("toastSub");
  const spinRing = document.getElementById("spinRing");

  cancelAnimationFrame(counterRaf);
  toastTitle.textContent = "Upload Failed";
  toastSub.textContent = "Something went wrong";
  spinRing.style.opacity = "0.3";

  setTimeout(() => toast.classList.remove("show"), 3000);
}

$(document).on("click", ".btn-upload-device", function () {
  if (!allFiles.length) {
    alert("Please choose files first");
    return;
  }

  const formData = new FormData();
  const batch_id = $("#batch_id").val();
  const batch_type = $(this).attr("data-type");

  allFiles.forEach(({ file }) => {
    formData.append("files[]", file);
    formData.append("batch_type", batch_type);
  });

  formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

  startUploadToast();

  $.ajax({
    url: base_url + "/admin/image_upload/" + batch_id,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,

    beforeSend: function () {
      console.log("Uploading", allFiles.length, "file(s)…");
    },

    success: function (response) {
      if (response.status === "success") {
        toastr.success(response.message);

        setTimeout(() => {
          allFiles = [];
          render();
          location.reload();
        }, 1000);
      }
    },

    error: function (xhr) {
      console.error("Upload failed:", xhr.responseText);
      failUploadToast();
    },
  });
});
$(document).ready(function () {
  // $("#batch-content-active").DataTable({
  //   processing: true,
  //   serverSide: true,
  //   ajax: "{{ route('admin.batch.datatable') }}",
  //   columns: [
  //     { data: "title" },
  //     { data: "batch_code" },
  //     { data: "created_at" },
  //     { data: "files_count" },
  //     { data: "action" },
  //   ],
  // });
});

function loadBatches(page = 1) {
  let data = $("#filterForm").serialize();

  $.ajax({
    url: "?page=" + page + "&" + currentFilters,
    type: "GET",

    success: function (res) {
      $("#batch-content-active").html(res);
    },
  });
}

let currentFilters = {};
// $("#filterForm input, #filterForm select").on("change keyup", function () {
//   // alert();
//   currentFilters = $("#filterForm").serialize();
//   loadBatches(1);
// });

let typingTimer;
let delay = 500;
$("#filterForm input, #filterForm select").on("change keyup", function () {
  clearTimeout(typingTimer);

  typingTimer = setTimeout(function () {
    let startDate = $("input[name='start_date']").val();
    let endDate = $("input[name='end_date']").val();

    if (startDate && endDate) {
      currentFilters = $("#filterForm").serialize();
    } else {
      let data = $("#filterForm").serializeArray();

      data = data.filter(
        (item) => item.name !== "start_date" && item.name !== "end_date"
      );

      currentFilters = $.param(data);
    }

    loadBatches(1);
  }, delay);
});

$(document).on("click", ".reset-filter", function (e) {
  e.preventDefault();

  $("#filterForm")[0].reset();
  currentFilters = "";
  loadBatches(1);
});
if (window.location.search) {
  window.history.replaceState({}, document.title, window.location.pathname);
}

$(document).on("click", "[data-bs-target='#renameModal']", function () {
  // alert();
  let id = $(this).data("id");
  let name = $(this).data("name");

  $("#rename_batch_id").val(id);
  $("#rename_batch_name").val(name);
});

$(document).on("click", ".BatchrenameModal", function () {
  // alert();
  let id = $(this).data("id");
  let name = $(this).data("name");

  $("#rename_batch_id").val(id);
  $("#rename_batch_name").val(name);
});

$(document).on("click", '[data-bs-target="#deleteModal"]', function (e) {
  e.preventDefault();
  let id = $(this).attr("data-id");
  $("#delete_batch_id").val(id);
});

$(document).on("click", ".delete_branch", function (e) {
  e.preventDefault();
  let batch_id = $("#delete_batch_id").val();

  $.ajax({
    url: base_url + "/admin/batch/delete",
    type: "POST",
    data: {
      batch_id: batch_id,
      _token: $("meta[name='csrf-token']").attr("content"),
    },

    success: function (res) {
      $("#deleteModal").modal("hide");
      // reload batches
      loadBatches(1);
      toastr.success(res.message);
    },
  });
});

$(document).on("click", ".edit_branch_name", function (e) {
  e.preventDefault();
  let batch_id = $("#rename_batch_id").val();
  let branch_name = $("#rename_batch_name").val();

  $.ajax({
    url: base_url + "/admin/batch/rename",
    type: "POST",
    data: {
      batch_id: batch_id,
      branch_name: branch_name,
      _token: $("meta[name='csrf-token']").attr("content"),
    },

    success: function (res) {
      $("#renameModal").modal("hide");
      toastr.success(res.message);

      // reload batches
      loadBatches(1);
    },
  });
});

$(document).on("click", ".copy-keywords", function () {
  let tags = $("#tags").val();

  let temp = $("<textarea>");
  $("body").append(temp);
  temp.val(tags).select();
  document.execCommand("copy");
  temp.remove();

  toastr.success("Keywords copied!");
});
// });

document.addEventListener("DOMContentLoaded", function () {
  const clearAllBtn = document.getElementById("clearAll");

  if (clearAllBtn) {
    clearAllBtn.addEventListener("click", () => {
      allFiles = [];
      render();
    });
  }
});
