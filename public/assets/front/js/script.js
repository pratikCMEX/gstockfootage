// cart side bar
let cart_content = document.querySelector(".cart-section");
let opencart = document.querySelector(".cart-open");
let closecart = document.querySelector(".close-cart-btn");
const cartoverlay = document?.getElementById("cartoverlay");

opencart?.addEventListener("click", function () {
  cart_content.classList.add("show_popup");
  cartoverlay.classList.add("active");
});
closecart?.addEventListener("click", function () {
  cart_content.classList.remove("show_popup");
  cartoverlay.classList.remove("active");
});

// log in & sign up Tabs
const tabs = document?.querySelectorAll(".tab-btn");
const forms = document?.querySelectorAll(".auth-form");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    tabs.forEach((t) => t.classList.remove("active"));
    forms.forEach((f) => f.classList.remove("active"));

    tab.classList.add("active");
    document?.getElementById(tab.dataset.tab).classList.add("active");
  });
});

// log in & sign up Toggle password
document.querySelectorAll(".toggle-password").forEach((icon) => {
  icon.addEventListener("click", () => {
    const input = icon.previousElementSibling;
    input.type = input.type === "password" ? "text" : "password";
    icon.classList.toggle("bi-eye-slash");
    icon.classList.toggle("bi-eye");
  });
});

// side menubar
const toggle = document?.getElementById("menuToggle");
const menu = document?.getElementById("sideMenu");
const overlay = document?.getElementById("overlay");
const closeBtn = document?.getElementById("closeMenu");

toggle.addEventListener("click", () => {
  menu.classList.add("active");
  overlay.classList.add("active");
});
overlay.addEventListener("click", closeMenu);
closeBtn.addEventListener("click", closeMenu);
function closeMenu() {
  menu.classList.remove("active");
  overlay.classList.remove("active");
}

//book store slider
const swiper = new Swiper(".store-swiper", {
  slidesPerView: 4,
  spaceBetween: 20,
  navigation: {
    nextEl: ".arrow-right",
    prevEl: ".arrow-left",
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    425: { slidesPerView: 1.5 },
    576: { slidesPerView: 2 },
    768: { slidesPerView: 2.2 },
    992: { slidesPerView: 3 },
    1200: { slidesPerView: 4 },
  },
});

// related-product slider
new Swiper(".product-swiper", {
  loop: true,
  slidesPerView: 4,
  spaceBetween: 20,
  navigation: {
    nextEl: ".arrow-product-right",
    prevEl: ".arrow-product-left",
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    425: { slidesPerView: 1.5 },
    576: { slidesPerView: 2 },
    768: { slidesPerView: 3 },
    992: { slidesPerView: 3 },
    1200: { slidesPerView: 4 },
  },
});

// product- detail slider
const produtThumb = new Swiper(".sideproduct", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 4,
  freeMode: true,
  direction: "vertical",
  watchSlidesProgress: true,
  navigation: {
    nextEl: ".custom-product-detail-next",
    prevEl: ".custom-product-detail-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 2,

      direction: "horizontal",
    },
    424: {
      slidesPerView: 2.8,
      direction: "horizontal",
    },
    575: {
      slidesPerView: 3.5,
      direction: "horizontal",
    },
    767: {
      direction: "horizontal",
      slidesPerView: 4.5,
    },
    991: {
      direction: "horizontal",
      slidesPerView: 3.5,
      spaceBetween: 10,
    },
    1199: {
      direction: "vertical",

      slidesPerView: 4,
    },
  },
});
new Swiper(".frontproduct", {
  loop: true,
  spaceBetween: 10,
  effect: "fade",
  thumbs: {
    swiper: produtThumb,
  },
  navigation: {
    nextEl: ".custom-product-detail-next",
    prevEl: ".custom-product-detail-prev",
  },
});

// input range
document.addEventListener("DOMContentLoaded", function () {
  const rangeInput = document.getElementById("range4");
  const rangeOutput = document.getElementById("rangeValue");

  if (!rangeInput || !rangeOutput) return; // safety guard

  rangeOutput.textContent = rangeInput.value;

  rangeInput.addEventListener("input", function () {
    rangeOutput.textContent = this.value;
  });
});

// input duration range
document.addEventListener("DOMContentLoaded", function () {
  const rangeInputSecond = document?.getElementById("rangeseconds");
  const rangeOutputSecond = document?.getElementById("rangesecondValue");

  if (!rangeInputSecond || !rangeOutputSecond) return; // safety guard

  rangeOutputSecond.textContent = rangeInputSecond.value;

  rangeInputSecond.addEventListener("input", function () {
    rangeOutputSecond.textContent = this.value;
  });
});

// brows video sort dropdown
const items = document?.querySelectorAll(".dropdown-item");
const selectedText = document?.getElementById("selectedOption");

items.forEach((item) => {
  item.addEventListener("click", () => {
    // Remove active from all
    items.forEach((i) => i.classList.remove("active"));

    // Add active to clicked
    item.classList.add("active");

    // Update button text
    selectedText.textContent = item.dataset.value;
  });
});

// filter side-bar
let mobilefilterbtn = document.querySelector(".filter-btn");
let closefilter = document.querySelector(".closefilter");
let filtercontent = document.querySelector(".filter-mobile");
mobilefilterbtn?.addEventListener("click", function () {
  filtercontent.classList.add("filteractive");
});
closefilter?.addEventListener("click", function () {
  filtercontent.classList.remove("filteractive");
});

// open
// opencart?.addEventListener("click", function (e) {
//   e.stopPropagation();
//   cart_content.classList.add("show_popup");
//   cartoverlay.classList.add("active");
// });

// // prevent inside click closing
// cart_content?.addEventListener("click", function (e) {
//   e.stopPropagation();
// });

// // close on outside
// document.addEventListener("click", function () {
//   cart_content.classList.remove("show_popup");
//   cartoverlay.classList.remove("active");
// });

document.addEventListener("click", function (e) {
  const isInsideCart = cart_content?.contains(e.target);
  const isOpenBtn = opencart?.contains(e.target);

  if (!isInsideCart && !isOpenBtn) {
    cart_content?.classList.remove("show_popup");
    cartoverlay?.classList.remove("active");
  }
});
