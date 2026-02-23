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

// image size big to small range
const slider = document.querySelector(".slider");
function updateProgress() {
  const value = (slider.value - slider.min) / (slider.max - slider.min) * 100;
  slider.style.setProperty("--progress", value + "%");
}
slider.addEventListener("input", updateProgress);
updateProgress();


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
// upload search filter
let uploadfiltermobile = document.querySelector("#upload_search_filter_mobile")
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
let addmetadata = document.querySelector(".add-metadata")
let selectimgdrop = document.querySelector(".select-img");

selectedImages?.forEach((item) => {
  item.addEventListener("click", function () {
    this.classList.toggle("selected");
    selectimgdrop.classList.add("active");
    viewdata.classList.add("notactive");
    addmetadata.classList.add("active");
    nofileselected.classList.add("active");
  });
});
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

})