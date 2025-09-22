/* jQuery(document).ready(function ($) {
  $("#product-slider").owlCarousel({
    loop: false,
    margin: 30,
    responsiveClass: true,
    stageClass: "slider-items",
    stageOuterClass: "product-slider-outer-wrapper",
    navClass: ["slider-prev", "slider-next"],
    itemElement: "a",
    navContainerClass: "slider-nav",
    dotsClass: "slider-dots",
    dotClass: "slider-dot",
    nav: true,
    dots: true,
    itemClass: "slider-item",
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      1200: {
        items: 4,
      },
    },
  });
}); */

var swiper = new Swiper(".swiper", {
  slidesPerView: 4,
  spaceBetween: 20,
});
