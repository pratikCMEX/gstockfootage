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
    filtercontent.classList.remove("filtershow")
    batchitems.classList.remove("batch-show-content");
    filtercontent.classList.remove("filtershowsmall");


});
filteropensmall?.addEventListener("click", function () {
    filtercontent.classList.add("filtershowsmall");
});
