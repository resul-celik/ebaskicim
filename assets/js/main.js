/* SLIDERS (Start) */

// Product item slider
var swiper = new Swiper(".swiper", {
  slidesPerView: 4,
  spaceBetween: 0,
  pagination: {
    el: ".product-slider-pagination",
    clickable: true,
  },
  breakpoints: {
    1440: {
      slidesPerView: 4,
      spaceBetween: 20,
    },
    1024: {
      slidesPerView: 4,
      spaceBetween: 15,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 10,
    },
    320: {
      slidesPerView: 1,
      spaceBetween: 5,
    },
  },
});

// main slider

var mainSlider = new Swiper(".main-slider", {
  slidesPerView: 1,
  spaceBetween: 0,
  wrapperClass: "main-slider-wrapper",
  slideClass: "main-slider-item",
  grabCursor: true,
  loop: true,
  speed: 1000,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
});

// Product gallery

var swiperThumbs = new Swiper(".swiper-thumbs", {
  slidesPerView: 4,
  spaceBetween: 12,
  freeMode: true,
  watchSlidesProgress: true,
  wrapperClass: "thumb-wrapper",
  slideClass: "photo-swiper-thumb-item",
});

var photoSwiper = new Swiper(".photo-swiper", {
  slidesPerView: 1,
  spaceBetween: 0,
  wrapperClass: "photo-swiper-wrapper",
  slideClass: "photo-swiper-item",
  thumbs: {
    swiper: swiperThumbs,
  },
  grabCursor: true,
  zoom: {
    maxRatio: 2,
  },
});

// Features slider

var featuresSlider = new Swiper(".features-slider", {
  slidesPerView: 4,
  spaceBetween: 20,
  wrapperClass: "features-slider-wrapper",
  slideClass: "features-slider-item",
  breakpoints: {
    1440: {
      slidesPerView: 4,
      spaceBetween: 20,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
    768: {
      slidesPerView: 1,
      spaceBetween: 10,
    },
    320: {
      slidesPerView: 1,
      spaceBetween: 5,
    },
  },
});

/* SLIDERS (End) */

var drawers = document.querySelectorAll(".drawer-menu");
var dimness = document.querySelector(".dimness");
var accountButton = document.querySelector(".account-button");
var cartButton = document.querySelector(".cart-button");

drawers.forEach((drawer) => {
  drawer.querySelector(".close-drawer").addEventListener("click", () => {
    drawer.classList.remove("drawer--active");
    dimness.classList.remove("dimness--active");
  });
});

dimness.addEventListener("click", () => {
  drawers.forEach((drawer) => {
    drawer.classList.remove("drawer--active");
  });
  dimness.classList.remove("dimness--active");
});

if (accountButton) {
  accountButton.addEventListener("click", () => {
    document
      .querySelector(".account-drawer-menu")
      .classList.add("drawer--active");
    dimness.classList.add("dimness--active");
  });
}

cartButton.addEventListener("click", () => {
  document.querySelector(".cart-drawer-menu").classList.add("drawer--active");
  dimness.classList.add("dimness--active");
});

// Menu

var maniMenuItems = document.querySelectorAll(".main-menu-item");

maniMenuItems.forEach((item) => {
  item.addEventListener("mouseover", () => {
    var dataItemId = item.getAttribute("data-item-id");
    var menuContent = document.querySelector(".menu-content-" + dataItemId);

    if (menuContent) {
      menuContent.addEventListener("mouseover", () => {
        menuContent.style.display = "flex";
        item.classList.add("main-menu-item--active");
      });
      menuContent.style.display = "flex";
    }

    item.classList.add("main-menu-item--active");
  });

  item.addEventListener("mouseout", () => {
    var dataItemId = item.getAttribute("data-item-id");
    var menuContent = document.querySelector(".menu-content-" + dataItemId);

    if (menuContent) {
      menuContent.addEventListener("mouseout", () => {
        menuContent.style.display = "none";
        item.classList.remove("main-menu-item--active");
      });
      menuContent.style.display = "none";
    }

    item.classList.remove("main-menu-item--active");
  });
});
