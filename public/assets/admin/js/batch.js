// batch

fetch("/countries.json")
  .then((response) => response.json())
  .then((data) => {
    let select = document.getElementById("country");

    if (!select) return;

    data.forEach((country) => {
      let option = document.createElement("option");
      option.value = country.name;
      option.textContent = country.name;
      select.appendChild(option);
    });
  });
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
  // table.slideToggle(300);
  table.toggleClass("open");

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
      required: "Please select Submission Type",
    },
    // brief_code: {
    //   remote: "This brief code already exists",
    // },
    batch_name: {
      required: "Please select Batch Name",
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
  window.location.reload();
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

  toggleSelectedImages();
  function updateProgress() {
    const value =
      ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
    slider.style.setProperty("--progress", value + "%");
  }

  slider.addEventListener("input", updateProgress);
  $(".total_file_selected").text("No File Selected");

  updateProgress();
  clearMetadata();
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
  const MAX_TAGS = 50;
  const $tags = $("#tags");

  if ($tags.length) {
    // ── Wrap inner input in jQuery ──────────────────────────────
    const $innerInput = $($tags.tagsinput("input"));

    // ── Handle paste ────────────────────────────────────────────
    $innerInput.on("paste", function (e) {
      e.preventDefault();

      const pastedText = (
        e.originalEvent.clipboardData || window.clipboardData
      ).getData("text");
      const pastedTags = pastedText
        .split(",")
        .map((t) => t.trim())
        .filter((t) => t !== "");

      pastedTags.forEach(function (tag) {
        const currentCount = $tags.tagsinput("items").length;
        if (currentCount >= MAX_TAGS) return;
        $tags.tagsinput("add", tag);
      });

      const count = $tags.tagsinput("items").length;
      $(".total-tags").text(count);

      if (count >= MAX_TAGS) {
        $innerInput.prop("disabled", true);
        $innerInput.attr("placeholder", "Maximum 50 tags reached");
      }
    });

    // ── Block adding more than 50 ───────────────────────────────
    $tags.on("beforeItemAdd", function (e) {
      const currentCount = $tags.tagsinput("items").length;
      if (currentCount >= MAX_TAGS) {
        e.cancel = true;
        $innerInput.prop("disabled", true);
        $innerInput.attr("placeholder", "Maximum 50 tags reached");
      }
    });

    // ── Update counter on add ───────────────────────────────────
    $tags.on("itemAdded", function () {
      const count = $tags.tagsinput("items").length;
      $(".total-tags").text(count);

      if (count >= MAX_TAGS) {
        $innerInput.prop("disabled", true);
        $innerInput.attr("placeholder", "Maximum 50 tags reached");
      }
    });

    // ── Re-enable on remove ─────────────────────────────────────
    $tags.on("itemRemoved", function () {
      const count = $tags.tagsinput("items").length;
      $(".total-tags").text(count);

      if (count < MAX_TAGS) {
        $innerInput.prop("disabled", false);
        $innerInput.attr("placeholder", "Add a tag...");
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
    $("#save-metadata").prop("disabled", true);
    $(".generate-ai").prop("disabled", true);
  } else {
    $(".delete-count").show();
    $(".total_file_selected").text(selectedCount + " File Selected");
    $("#save-metadata").prop("disabled", false);
    $(".generate-ai").prop("disabled", false);
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

function toggleSelectedImages() {
  // alert();
  $(".upload-image").show();
  $(".upload-image.selected").show();
  $(".show_all_file").text("Show selected");
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
    toggleSelectedImages();

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

function loadSubCategories(category_id, selected_subcategory = null) {
  $.ajax({
    url: base_url + "/get-subcategories/" + category_id,
    type: "GET",
    data: { category_id: category_id },

    success: function (res) {
      $("#subcategory_id").html(
        '<option value="" selected disabled>Select Subcategory</option>'
      );

      $.each(res, function (key, value) {
        let selected = selected_subcategory == value.id ? "selected" : "";

        $("#subcategory_id").append(
          '<option value="' +
            value.id +
            '" ' +
            selected +
            ">" +
            value.name +
            "</option>"
        );
      });
    },
  });
}
function loadImageMetadata(file_id) {
  $("html, body").animate({ scrollTop: 0 }, 300);
  $(".no-file-selected").animate({ scrollTop: 0 }, 300);

  $.ajax({
    url: base_url + "/admin/batch/get_file_metadata",
    type: "POST",
    data: {
      file_id: file_id,
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (res) {
      // fill form
      // $(".error").text("");
      let validator = $("#add_new_img_form").validate();
      validator.resetForm(); // 🔥 resets errors properly

      console.log(res);

      // Existing fields
      $("input[name='file_id']").val(res.id);
      $("input[name='title']").val(res.title);
      // $("#description").val(res.description);
      // setEditorData(res.description);

      if (
        typeof CKEDITOR !== "undefined" &&
        CKEDITOR.instances["description"]
      ) {
        CKEDITOR.instances["description"].setData(res.description ?? "", {
          noSnapshot: true, // prevents undo history entry
          callback: function () {
            // Clear any description error after data is set
            $("label[for='description'].error").hide().text("");
            $("#cke_description").removeClass("error");
          },
        });
      } else {
        $("#description").val(res.description ?? "");
      }

      $("input[name='price']").val(res.price);
      $("input[name='date_created']").val(res.date_created);
      if (res.type == "image") {
        $(".generate-ai").attr("data-img", res.file_path);
      } else {
        $(".generate-ai").attr("data-img", res.thumbnail_path);
      }
      $("input[name='clip_length']").val(
        res.duration ? formatDuration(res.duration) : ""
      );
      $("input[name='frame_rate']").val(res.frame_rate ?? "");
      $("input[name='frame_size']").val(
        res.height && res.width ? res.height + "x" + res.width : ""
      );
      $("input[name='image_height']").val(res.height ?? "");
      $("input[name='image_width']").val(res.width ?? "");

      // ── Searchable selects — use trigger('change') for Select2 ──
      $("#category_id").val(res.category_id).trigger("change.select2");
      $("#collection_id").val(res.collection_id).trigger("change.select2");
      $("#country").val(res.country).trigger("change.select2");
      $("#orientation").val(res.orientation).trigger("change.select2");
      $("#camera_movement").val(res.camera_movement).trigger("change.select2");
      $("#license_type").val(res.license_type).trigger("change.select2");

      setTimeout(function () {
        loadSubCategories(res.category_id, res.subcategory_id);
      }, 100);
      // Tags / keywords
      $("#tags").tagsinput("removeAll");
      if (res.keywords) {
        let tags = res.keywords.split(",");
        tags.forEach(function (tag) {
          $("#tags").tagsinput("add", tag.trim());
        });

        updateKeywordCount();
      }

      // ── New filter fields ──────────────────────────────────────

      // Single-select dropdowns
      $("#orientation").val(res.orientation ?? "");
      $("#camera_movement").val(res.camera_movement ?? "");
      $("#license_type").val(res.license_type ?? "");

      // Content filter checkboxes
      // 1. Uncheck all first
      $("input[name='content_filters[]']").prop("checked", false);

      // 2. Re-check only the saved ones
      // res.content_filters is already a JS array because Laravel
      // returns JSON and the model casts it as array

      $(".generate-ai").prop("disabled", false).text("Generate AI Content");

      if (res.content_filters && res.content_filters.length > 0) {
        res.content_filters.forEach(function (value) {
          $("input[name='content_filters[]'][value='" + value + "']").prop(
            "checked",
            true
          );
        });
      }

      // ── End new filter fields ──────────────────────────────────
    },
    error: function (xhr) {
      console.log(xhr.responseText);
      console.log($('meta[name="csrf-token"]').attr("content"));
    },
  });
}

function setEditorData(data) {
  if (CKEDITOR.instances.description) {
    CKEDITOR.instances.description.setData(data || "");
  } else {
    setTimeout(function () {
      setEditorData(data);
    }, 200);
  }
}

$(document).on("click", ".generate-ai", function () {
  let btn = $(this);
  let imgUrl = btn.attr("data-img"); // ✅ reads live attribute, not cached value

  btn.prop("disabled", true).text("Generating...");
  $("#ai_loader").css("display", "flex");
  $.ajax({
    url: base_url + "/generate-ai-content",
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    data: { img_url: imgUrl },

    success: function (res) {
      console.log(res);
      // return;
      if (res.status === true) {
        $("input[name='title']").val(res.data.title);
        // $("#description").val(res.data.description);
        setEditorData(res.data.description);
        if (res.data.category_id && res.data.category_name) {
          var $catSelect = $("#category_id");
          if (
            $catSelect.find("option[value='" + res.data.category_id + "']")
              .length === 0
          ) {
            var newCatOption = new Option(
              res.data.category_name,
              res.data.category_id,
              true,
              true
            );
            $catSelect.append(newCatOption);
          }
          $catSelect.val(res.data.category_id).trigger("change.select2");
        }
        if (res.data.collection_id && res.data.collection_name) {
          var $colSelect = $("#collection_id");
          if (
            $colSelect.find("option[value='" + res.data.collection_id + "']")
              .length === 0
          ) {
            var newColOption = new Option(
              res.data.collection_name,
              res.data.collection_id,
              true,
              true
            );
            $colSelect.append(newColOption);
          }
          $colSelect.val(res.data.collection_id).trigger("change.select2");
        }
        // $("#collection_id")
        //   .val(res.data.collection_id)
        //   .trigger("change.select2");

        setTimeout(function () {
          loadSubCategories(
            res.data.category_id,
            res.data.subcategory_id,
            res.data.subcategory_name
          );
        }, 500);
        // loadSubCategories(res.category_id, res.subcategory_id);

        $("#tags").tagsinput("removeAll");
        if (res.data.tags) {
          let tags = res.data.tags.split(",");
          tags.forEach(function (tag) {
            $("#tags").tagsinput("add", tag.trim());
          });
          updateKeywordCount();
        }
        // $("#ai_tags").val(res.data.tags);

        btn.text("Generated ✓");
        $("#ai_loader").css("display", "none");
      } else {
        toastr.warning(res.message);
        btn.prop("disabled", false).text("Generate AI Content");
        $("#ai_loader").css("display", "none");
      }
    },
    error: function () {
      toastr.error("Something went wrong.");
      btn.prop("disabled", false).text("Generate AI Content");
      $("#ai_loader").css("display", "none");
    },
  });
});

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

$(document).ready(function () {
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
// $("#add_new_img_form").validate({
//   ignore: [],
//   rules: {
//     title: {
//       required: true,
//       minlength: 1,
//     },
//     description: {
//       required: true,
//       minlength: 5,
//     },
//     price: {
//       required: true,
//       number: true,
//     },
//     category_id: {
//       required: true,
//     },
//     subcategory_id: {
//       required: true,
//     },
//   },

//   messages: {
//     title: {
//       required: "Please enter title",
//     },
//     description: {
//       required: "Please enter description",
//     },
//     price: {
//       required: "Please enter price",
//     },
//     category_id: {
//       required: "Please select a category",
//     },

//     subcategory_id: {
//       required: "Please select a subcategory",
//     },
//   },
//   errorPlacement: function (error, element) {
//     if (element.hasClass("select2-hidden-accessible")) {
//       error.insertAfter(element.next(".select2")); // ✅ place after UI
//     } else {
//       error.insertAfter(element);
//     }
//   },
//   submitHandler: function (form) {
//     // Collect all checked content_filters[] checkboxes into an array
//     // e.g. ["with_people", "outdoors_nature", "copy_space"]
//     let contentFilters = [];
//     $("input[name='content_filters[]']:checked").each(function () {
//       contentFilters.push($(this).val());
//     });

//     let formData = {
//       file_id: $("#selected_file_id").val(),
//       title: $("input[name='title']").val(),
//       description: $("#description").val(),
//       price: parseFloat($("input[name='price']").val()),
//       date_created: $("input[name='date_created']").val(),
//       tags: $("input[name='tags']").val(),
//       country: $("#country").val(),
//       category_id: $("#category_id").val(),
//       subcategory_id: $("#subcategory_id").val(),
//       collection_id: $("#collection_id").val(),

//       // New filter fields
//       orientation: $("#orientation").val(),
//       camera_movement: $("#camera_movement").val(),
//       license_type: $("#license_type").val(),

//       // Checkboxes array — sent as content_filters[0], content_filters[1], etc.
//       content_filters: contentFilters,

//       _token: $('meta[name="csrf-token"]').attr("content"),
//     };

//     $.ajax({
//       url: base_url + "/admin/batch/save_file_metadata",
//       type: "POST",
//       data: formData,

//       // IMPORTANT: tells jQuery to send arrays correctly as content_filters[]
//       // so Laravel receives it as an array, not content_filters[0], [1]...
//       traditional: false,

//       success: function (res) {
//         toastr.success("File metadata saved successfully");
//       },

//       error: function (xhr) {
//         toastr.error("Something went wrong");
//         console.log(xhr.responseText);
//       },
//     });

//     return false; // prevent normal submit
//   },
// });

$("#add_new_img_form").validate({
  ignore: [],

  rules: {
    title: {
      required: true,
      minlength: 1,
    },

    description: {
      required: function () {
        return CKEDITOR.instances.description.getData().trim() === "";
      },
      // minlength: 5,
    },

    price: {
      required: true,
      number: true,
    },

    category_id: {
      required: true,
    },

    subcategory_id: {
      required: true,
    },
  },

  messages: {
    title: {
      required: "Please enter Title",
    },
    description: {
      required: "Please enter Description",
    },
    price: {
      required: "Please enter Price",
    },
    category_id: {
      required: "Please select Category",
    },
    subcategory_id: {
      required: "Please select Subcategory",
    },
  },

  errorPlacement: function (error, element) {
    // ✅ CKEditor error placement
    if (element.attr("name") === "description") {
      error.insertAfter("#cke_description");
    }

    // ✅ Select2 error placement
    else if (element.hasClass("select2-hidden-accessible")) {
      error.insertAfter(element.next(".select2"));
    } else {
      error.insertAfter(element);
    }
  },

  submitHandler: function (form) {
    // ✅ IMPORTANT: Sync CKEditor data
    if (CKEDITOR.instances.description) {
      CKEDITOR.instances.description.updateElement();
    }

    let contentFilters = [];
    $("input[name='content_filters[]']:checked").each(function () {
      contentFilters.push($(this).val());
    });

    let formData = {
      file_id: $("#selected_file_id").val(),
      title: $("input[name='title']").val(),

      // ✅ FIXED: get from CKEditor
      description: CKEDITOR.instances.description.getData(),

      price: parseFloat($("input[name='price']").val()),
      date_created: $("input[name='date_created']").val(),
      tags: $("input[name='tags']").val(),
      country: $("#country").val(),
      category_id: $("#category_id").val(),
      subcategory_id: $("#subcategory_id").val(),
      collection_id: $("#collection_id").val(),

      orientation: $("#orientation").val(),
      camera_movement: $("#camera_movement").val(),
      license_type: $("#license_type").val(),

      content_filters: contentFilters,

      _token: $('meta[name="csrf-token"]').attr("content"),
    };

    $.ajax({
      url: base_url + "/admin/batch/save_file_metadata",
      type: "POST",
      data: formData,
      traditional: false,

      success: function (res) {
        toastr.success("File metadata saved successfully");

        if (res.status) {
          let container = $('.image-title-id[data-id="' + res.file_id + '"]');

          let iconDiv = container.find(".check, .error");
          let imgtitle = container.find(".img-title");

          iconDiv
            .removeClass("error")
            .addClass("check")
            .html('<i class="fa-solid fa-circle-check"></i>');

          imgtitle.text(res.title);
        }
      },

      error: function (xhr) {
        toastr.error("Something went wrong");
        console.log(xhr.responseText);
      },
    });

    return false;
  },
});

if (typeof CKEDITOR !== "undefined") {
  CKEDITOR.on("instanceReady", function (e) {
    if (e.editor.name === "description") {
      e.editor.on("change", function () {
        // Sync CKEditor content back to textarea
        e.editor.updateElement();

        // Re-validate only the description field to clear error instantly
        $("#add_new_img_form").validate().element("#description");
      });
    }
  });
}

$(document).on("click", ".select-btn", function () {
  let images = $(".upload-image");
  let allSelected = images.length === images.filter(".selected").length;

  // if (allSelected == 1) {
  if (allSelected) {
    images.removeClass("selected");
    toggleSelectedImages();
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
    $("#loader").css("display", "flex");

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
          $(".total-files-count").text(response.total + " Items");
          $("#loader").css("display", "none");
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
  $(".btn-upload-device").prop("disabled", false);
}

function render() {
  console.log("visible", allFiles);
  if (allFiles.length == 0) {
    $(".btn-upload-device").prop("disabled", true);
  }
  thumbsWrap.innerHTML = "";

  if (!allFiles.length) {
    strip.classList.remove("visible");
    return;
  }

  strip.classList.add("visible");

  const total = allFiles.length;
  const visible = allFiles.slice(0, MAX_VISIBLE); // show limited thumbnails
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
    } else {
      const ext = file.name.split(".").pop().toUpperCase();
      inner = `<div class="p-thumb-zip">
                 <i class="fa-solid fa-file-zipper"></i>
                 <span>${ext}</span>
               </div>
               <span class="p-badge p-badge-zip">${ext}</span>`;
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

  $(".btn-upload-device").prop("disabled", false);
}

document.addEventListener("click", function (e) {
  const btn = e.target.closest(".p-remove");
  if (!btn) return;

  const id = btn.dataset.id;

  // remove from array
  allFiles = allFiles.filter((file) => file.id != id);

  // re-render thumbnails
  render();
});
// remove file
let counterRaf = null;
let animRaf = null;
let lastPercent = 0;
let counterTimer = null;
let realUploadPercent = 0;
let displayPercent = 0;
let uploadDone = false;

const MAX_SPEED = 0.08; // max % per frame during upload
const CRAWL_SPEED = 0.005; // very slow crawl 90→99 while server processes

// ── Store real XHR progress ─────────────────────────────────────────
function updateUploadProgress(targetPercent) {
  realUploadPercent = Math.min(Math.floor(targetPercent), 90);
}

// ── Smooth RAF — speed limited + server crawl ───────────────────────
function startProgressAnimation() {
  const barFill = document.getElementById("barFill");
  const pctLabel = document.getElementById("pctLabel");

  displayPercent = 0;
  realUploadPercent = 0;
  uploadDone = false;

  cancelAnimationFrame(animRaf);

  function animate() {
    if (!uploadDone) {
      if (displayPercent < realUploadPercent) {
        // Phase 1: Follow real XHR — speed limited
        displayPercent = Math.min(
          displayPercent + MAX_SPEED,
          realUploadPercent
        );
      } else if (displayPercent >= 70 && displayPercent < 99) {
        // Phase 2: XHR done, server processing — slow crawl 90→99
        displayPercent += CRAWL_SPEED;
      }
    }

    displayPercent = Math.min(displayPercent, 99);

    barFill.style.transition = "none";
    barFill.style.width = displayPercent + "%";
    pctLabel.textContent = Math.floor(displayPercent);

    animRaf = requestAnimationFrame(animate);
  }

  animRaf = requestAnimationFrame(animate);
}

// ── Start toast ─────────────────────────────────────────────────────
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
  const batch_type = document.getElementById("batch_type");

  cancelAnimationFrame(counterRaf);
  cancelAnimationFrame(animRaf);
  clearInterval(counterTimer);

  lastPercent = 0;
  realUploadPercent = 0;
  displayPercent = 0;
  uploadDone = false;

  barFill.style.transition = "none";
  barFill.style.width = "0%";
  pctLabel.textContent = "0";

  toastTitle.textContent = "Uploading...";
  toastSub.textContent =
    batch_type.value == "video"
      ? "Video upload in progress"
      : "Image upload in progress";
  waitText.style.display = "flex";
  successMsg.style.display = "none";
  counterBox.style.display = "flex";
  spinRing.style.display = "block";
  checkRing.style.display = "none";

  toast.classList.add("show");
  startProgressAnimation();
}

// ── Complete toast ──────────────────────────────────────────────────
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

  // Stop crawl — server responded
  uploadDone = true;
  cancelAnimationFrame(animRaf);
  cancelAnimationFrame(counterRaf);
  clearInterval(counterTimer);

  // Shoot to 100%
  barFill.style.transition = "width 0.4s ease";
  barFill.style.width = "100%";

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
      setTimeout(() => {
        toastTitle.textContent = "Upload Complete";
        toastSub.textContent =
          batch_type.value == "video"
            ? "Your video is ready"
            : "Your image is ready";
        waitText.style.display = "none";
        counterBox.style.display = "none";
        successMsg.style.display = "block";
        spinRing.style.display = "none";
        checkRing.style.display = "block";
        setTimeout(() => toast.classList.remove("show"), 3000);
      }, 300);
    }
  }
  requestAnimationFrame(finish);
}

// ── Fail toast ──────────────────────────────────────────────────────
function failUploadToast() {
  const toast = document.getElementById("uploadToast");
  const toastTitle = document.getElementById("toastTitle");
  const toastSub = document.getElementById("toastSub");
  const spinRing = document.getElementById("spinRing");

  uploadDone = true;
  cancelAnimationFrame(animRaf);
  cancelAnimationFrame(counterRaf);
  clearInterval(counterTimer);

  toastTitle.textContent = "Upload Failed";
  toastSub.textContent = "Something went wrong";
  spinRing.style.opacity = "0.3";

  setTimeout(() => toast.classList.remove("show"), 3000);
}

// ── Upload button click ─────────────────────────────────────────────
$(document).on("click", ".btn-upload-device", function () {
  if (!allFiles.length) {
    alert("Please choose files first");
    return;
  }

  $(this).prop("disabled", true);

  const formData = new FormData();
  const batch_id = $("#batch_id").val();
  const batch_type = $(this).attr("data-type");

  allFiles.forEach(({ file }) => {
    formData.append("files[]", file);
    formData.append("batch_type", batch_type);
  });

  formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

  startUploadToast();
  $(".btn-upload").prop("disabled", true);

  $.ajax({
    url: base_url + "/admin/image_upload/" + batch_id,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,

    xhr: function () {
      let xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener(
        "progress",
        function (evt) {
          if (evt.lengthComputable) {
            let realPercent = (evt.loaded / evt.total) * 100;
            updateUploadProgress(realPercent);
          }
        },
        false
      );
      return xhr;
    },

    success: function (response) {
      if (response.status === "success") {
        toastr.success(response.message);
        completeUploadToast();
        $(".btn-upload").prop("disabled", false);
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

function toggleSelected(btn, itemSelector) {
  let showingSelected = $(btn).hasClass("showing-selected");

  if (!showingSelected) {
    $(itemSelector).hide();
    $(itemSelector + ".selected").show();

    $(btn).text("Show all");
    $(btn).addClass("showing-selected");
  } else {
    $(itemSelector).show();

    $(btn).text("Show selected");
    $(btn).removeClass("showing-selected");
  }
}

$(".show_all_file").on("click", function () {
  toggleSelected(this, ".upload-image");
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

$("#BatchrenameModal").on("show.bs.modal", function (event) {
  let button = $(event.relatedTarget);

  let id = button.attr("data-id");
  let name = button.attr("data-name");

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
      $(".batch_name").html(branch_name);
      $(".BatchrenameModal").attr("data-name", branch_name);
      toastr.success(res.message);
      $("#BatchrenameModal").modal("hide");

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
  $(document).on("click", ".batch_file_keyword", function () {
    console.log("clicked");
    let keywords = $(this).data("keywords");

    let temp = $("<textarea>");
    $("body").append(temp);
    temp.val(keywords).select();
    document.execCommand("copy");
    temp.remove();

    toastr.success("Keywords copied!");
  });

  const clearAllBtn = document.getElementById("clearAll");

  if (clearAllBtn) {
    clearAllBtn.addEventListener("click", () => {
      $(".btn-upload-device").prop("disabled", true);

      allFiles = [];
      render();
      $(".btn-upload-device").prop("disabled", true);
    });
  }
});
$(document).on("change", "#subcategory_id", function () {
  let categoryId = $(this).val();
  $(this).valid();
});

$(document).on("change", "#category_id", function () {
  // alert();
  let categoryId = $(this).val();
  $(this).valid();

  // $("#subcategory").html("<option>Loading...</option>");

  if (categoryId != "") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: base_url + "/get-subcategories/" + categoryId,
      type: "GET",
      success: function (data) {
        $("#subcategory_id").html(
          '<option value="" selected disabled>Select Subcategory</option>'
        );
        console.log(data);

        $.each(data, function (key, value) {
          $("#subcategory_id").append(
            '<option value="' + value.id + '">' + value.name + "</option>"
          );
        });
      },
    });
  } else {
    $("#subcategory").html(
      '<option value="" selected disabled>Choose SubCategory...</option>'
    );
  }
});
