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

$(document).on("click", ".more-detail-btn", function () {
  let parent = $(this).closest(".batch-content");
  let table = parent.find(".batch-content-table-details");

  table.slideToggle(300);

  // rotate arrow
  $(this).toggleClass("active");
});



// upload
let openupload = document.querySelector(".upload-btn");
let uploadcontent = document.querySelector(".upload-from-device")
let closeupload = document.querySelector(".upload-close-btn");
openupload?.addEventListener("click", function () {
  uploadcontent.classList.add("active");
});
closeupload?.addEventListener("click", function () {
  uploadcontent.classList.remove("active");

});

let uploadfilteropen = document.querySelector("#upload_search_filter");
let uploadfiltercontent = document.querySelector(".upload-search-filter");
let uploadfilterclose = document.querySelector("#upload_close-filter");
uploadfilteropen?.addEventListener("click", function () {
  uploadfiltercontent.classList.add("active");
});
uploadfilterclose?.addEventListener("click", function () {
  uploadfiltercontent.classList.remove("active");
});

let uploadimages = document.querySelector("#upload_images");
let uploadimgclose = document.querySelector(".close-select-btn");
let selectimgdrop = document.querySelector(".select-img");
uploadimages?.addEventListener("click", function () {
  selectimgdrop.classList.add("active");
});
uploadimgclose?.addEventListener("click", function () {
  selectimgdrop.classList.remove("active");
});

const selectedImages = document.querySelectorAll(".upload-image");

selectedImages.forEach((item) => {
  item.addEventListener("click", function () {
    this.classList.add("selected");
  });
});

const slider = document.querySelector(".slider");

function updateProgress() {
  const value = (slider.value - slider.min) / (slider.max - slider.min) * 100;
  slider.style.setProperty("--progress", value + "%");
}

slider.addEventListener("input", updateProgress);
updateProgress();