// batch
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
    brief_code: {
      required: true,
    },
    batch_name: {
      required: true,
    },
  },
  messages: {
    submission_type: {
      required: "Please select submission type",
    },
    brief_code: {
      required: "Please select brief code",
    },
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
let uploadimgclose = document.querySelector(".close-select-btn");
let addmetadata = document.querySelector(".add-metadata");
let selectimgdrop = document.querySelector(".select-img");

// selectedImages?.forEach((item) => {
//   item.addEventListener("click", function () {
//     this.classList.toggle("selected");
//     selectimgdrop.classList.toggle("active");
//     viewdata.classList.add("notactive");
//     addmetadata.classList.add("active");
//     nofileselected.classList.toggle("active");
//   });
// });
// selectedImages?.forEach((item) => {
//   item.addEventListener("click", function () {
//     // If already selected → remove everything
//     if (this.classList.contains("selected")) {
//       this.classList.remove("selected");

//       selectimgdrop.classList.remove("active");
//       viewdata.classList.remove("notactive");
//       addmetadata.classList.remove("active");
//       nofileselected.classList.add("active");

//       return; // stop here
//     }

//     // Remove selected from all
//     selectedImages.forEach((img) => img.classList.remove("selected"));

//     // Add to clicked one
//     this.classList.add("selected");

//     // Activate UI
//     selectimgdrop.classList.add("active");
//     viewdata.classList.add("notactive");
//     addmetadata.classList.add("active");
//     nofileselected.classList.remove("active");
//   });
// });
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
  nofileselected.classList.add("showactive");
});
addmetadata?.addEventListener("click", function () {
  nofileselected.classList.add("showaddmetadataactive");
});
mobilemetadata?.addEventListener("click", function () {
  nofileselected.classList.remove("showactive");
  nofileselected.classList.remove("showaddmetadataactive");
});

const slider = document.getElementById("rangeSlider");

function updateSliderProgress() {
  const min = slider.min;
  const max = slider.max;
  const val = slider.value;

  const percentage = ((val - min) / (max - min)) * 100;
  slider.style.setProperty("--progress", percentage + "%");
}

// Run on load (important)
updateSliderProgress();

// Run on slide
slider.addEventListener("input", updateSliderProgress);

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

// $(document).on("click", ".select-btn", function () {
//   let images = $(".upload-image");
//   let button = $(this);

//   // Check if all are already selected
//   let allSelected = images.length === images.filter(".selected").length;

//   if (allSelected) {
//     // If all selected → unselect all
//     images.removeClass("selected");
//     button.text("Select All");
//   } else {
//     // Otherwise → select all
//     images.addClass("selected");
//     button.text("Deselect All");
//   }

//   // Toggle UI panels
//   selectimgdrop?.classList.toggle("active");
//   viewdata?.classList.toggle("notactive");
//   addmetadata?.classList.toggle("active");
//   nofileselected?.classList.toggle("active");
// });
$(document).ready(function () {
  function updateUI() {
    let images = $(".upload-image");
    let selectedCount = images.filter(".selected").length;
    let total = images.length;
    let button = $(".select-btn");

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
    } else {
      $(".delete-count").show();
    }

    // Panels
    if (selectedCount > 0) {
      selectimgdrop?.classList.add("active");
      viewdata?.classList.add("notactive");
      addmetadata?.classList.add("active");
      nofileselected?.classList.remove("active");
    } else {
      selectimgdrop?.classList.remove("active");
      viewdata?.classList.remove("notactive");
      addmetadata?.classList.remove("active");
      nofileselected?.classList.add("active");
    }
  }

  // 🔥 Image Click Logic (Fixed)
  $(document).on("click", ".upload-image", function (e) {
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
  });

  // Select All Button
  $(document).on("click", ".select-btn", function () {
    let images = $(".upload-image");
    let allSelected = images.length === images.filter(".selected").length;

    if (allSelected) {
      images.removeClass("selected");
    } else {
      images.addClass("selected");
    }

    updateUI();
  });
});
