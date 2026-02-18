// Tabs
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

// Toggle password
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

if (toggle) {
  toggle.addEventListener("click", () => {
    menu.classList.add("active");
    overlay.classList.add("active");
  });
  overlay.addEventListener("click", closeMenu);
  closeBtn.addEventListener("click", closeMenu);
}

function closeMenu() {
  menu.classList.remove("active");
  overlay.classList.remove("active");
}

// store slider
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

// related-product
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
