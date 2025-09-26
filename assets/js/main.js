var swiper = new Swiper(".swiper", {
  slidesPerView: 4,
  spaceBetween: 20,
});

var mainSlider = new Swiper(".main-slider", {
  slidesPerView: 1,
  spaceBetween: 0,
  wrapperClass: "main-slider-wrapper",
  slideClass: "main-slider-item",
});

var orderSlider = new Swiper(".order-images", {
  slidesPerView: 1,
  spaceBetween: 0,
  wrapperClass: "order-images-wrapper",
  slideClass: "order-image",
});

// Photo Swiper

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
});

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

accountButton.addEventListener("click", () => {
  document
    .querySelector(".account-drawer-menu")
    .classList.add("drawer--active");
  dimness.classList.add("dimness--active");
});

cartButton.addEventListener("click", () => {
  document.querySelector(".cart-drawer-menu").classList.add("drawer--active");
  dimness.classList.add("dimness--active");
});
