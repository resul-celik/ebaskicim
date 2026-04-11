/* MAIN NAV DRAG SCROLL (Start) */

jQuery(function ($) {
  var $nav = $("#main-nav-list");
  if (!$nav.length) return;

  var isDown = false;
  var hasDragged = false;
  var startX, scrollLeft;
  var DRAG_THRESHOLD = 5;

  $nav.on("dragstart", "a, img", function (e) {
    e.preventDefault();
  });

  $nav.on("mousedown", function (e) {
    isDown = true;
    hasDragged = false;
    $nav.addClass("is-dragging");
    startX = e.pageX - $nav.offset().left;
    scrollLeft = $nav.scrollLeft();
  });

  $(document).on("mouseup", function () {
    if (!isDown) return;
    isDown = false;
    $nav.removeClass("is-dragging");
  });

  $nav.on("mousemove", function (e) {
    if (!isDown) return;
    var x = e.pageX - $nav.offset().left;
    var walk = x - startX;
    if (Math.abs(walk) > DRAG_THRESHOLD) {
      e.preventDefault();
      hasDragged = true;
      $nav.scrollLeft(scrollLeft - walk * 1.5);
    }
  });

  $nav.on("click", "a", function (e) {
    if (hasDragged) {
      e.preventDefault();
      e.stopPropagation();
    }
  });
});

/* MAIN NAV DRAG SCROLL (End) */

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

const drawers = document.querySelectorAll(".drawer-menu");
const dimness = document.querySelector(".dimness");

function close_drawer() {
  drawers.forEach((drawer) => {
    drawer.classList.remove("drawer--active");
  });
  if (dimness) dimness.classList.remove("dimness--active");
}

drawers.forEach((drawer) => {
  const triggerClass = drawer.dataset.trigger;
  if (!triggerClass) return;

  const trigger = document.querySelector("." + triggerClass);
  if (!trigger) return;

  trigger.addEventListener("click", () => {
    drawer.classList.add("drawer--active");
    if (dimness) dimness.classList.add("dimness--active");
  });
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

/* VARIATION CHIPS (Start) */

jQuery(function ($) {
  var $form = $(".variations_form");
  if (!$form.length) return;

  // Click a chip: mark it active, sync the hidden <select>, update swatch label
  $form.on("click", ".variation-chip", function () {
    var $chip = $(this);
    if ($chip.hasClass("variation-chip--disabled")) return;

    var $chips = $chip.closest(".variation-chips");
    var attribute = $chips.data("attribute");
    var value = $chip.data("value");

    $chips.find(".variation-chip").removeClass("variation-chip--active");
    $chip.addClass("variation-chip--active");

    // Update label name for swatch groups (color / image chips)
    if ($chips.data("swatch")) {
      var label = $chip.data("label") || "";
      $chip.closest(".variation-group").find(".chip-label-name").text(label ? "— " + label : "");
    }

    $form
      .find('select[name="attribute_' + attribute + '"]')
      .val(value)
      .trigger("change");
  });

  // Auto-select the first chip of every attribute on page load
  $form.find(".variation-chips").each(function () {
    $(this).find(".variation-chip").first().trigger("click");
  });

  // When WooCommerce resets variations, deactivate all chips
  $form.on("reset_data", function () {
    $form.find(".variation-chip").removeClass("variation-chip--active");
  });

  // Sync variation price to the display container above the title
  var $priceDisplay = $(".variation-price-display");
  if ($priceDisplay.length) {
    $form.on("found_variation", function (_e, variation) {
      if (variation.price_html) {
        $priceDisplay.html(variation.price_html);
      }
    });
  }

  // Sync variation image to the main product photo swiper
  var $mainSlide = $(".photo-swiper .photo-swiper-item").first();
  var $thumbSlide = $(".swiper-thumbs .photo-swiper-thumb-item").first();

  $form.on("found_variation", function (_e, variation) {
    var img = variation.image;
    if (!img || !img.src || img.src.indexOf("woocommerce-placeholder") !== -1) return;

    var $mainImg = $mainSlide.find("img");
    var $thumbImg = $thumbSlide.find("img");

    // Store originals once
    if (!$mainImg.data("orig-src")) {
      $mainImg.data("orig-src", $mainImg.attr("src"));
      $mainImg.data("orig-srcset", $mainImg.attr("srcset") || "");
    }
    if (!$thumbImg.data("orig-src")) {
      $thumbImg.data("orig-src", $thumbImg.attr("src"));
    }

    $mainImg.attr("src", img.src).attr("srcset", img.srcset || "");
    $thumbImg.attr("src", img.gallery_thumbnail_src || img.src);

    // Go to first slide so the updated image is visible
    if (typeof photoSwiper !== "undefined") {
      photoSwiper.slideTo(0, 0);
    }
  });

  $form.on("reset_data", function () {
    var $mainImg = $mainSlide.find("img");
    var $thumbImg = $thumbSlide.find("img");

    if ($mainImg.data("orig-src")) {
      $mainImg.attr("src", $mainImg.data("orig-src")).attr("srcset", $mainImg.data("orig-srcset"));
    }
    if ($thumbImg.data("orig-src")) {
      $thumbImg.attr("src", $thumbImg.data("orig-src"));
    }
  });
});

/* VARIATION CHIPS (End) */

/* const searchFilter = document.querySelector(".search-filter");
const resultList = document.querySelector(".results");

searchFilter.addEventListener("keyup", function (e) {
  const inputText = e.target.value;
  if (inputText.length == 0) {
    resultList.innerHTML = `<li>Product not found</li>`;
  } else {
    const dataText = {
      query: inputText,
    };

    jQuery.ajax({
      type: "post",
      url: `${window.location.origin}/wp-admin/admin-ajax.php`,
      data: {
        action: "ebs_category_filter_action",
        ajax_data: dataText,
      },
      complete: function (response) {
        const responseData = response.responseJSON.data;
        let products = "";

        document.location.search = "?order=ASC";

        for (let i = 0; i < responseData.length; i++) {
          products += `<li>${responseData[i].post_title}</li>`;
        }

        resultList.innerHTML = products;
      },
    });
  }
}); */
