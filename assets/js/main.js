/* MAIN NAV DRAG SCROLL (Start) */

jQuery(function ($) {
  var $nav = $("#main-nav-list");
  if (!$nav.length) return;

  var isDown = false;
  var startX, scrollLeft;

  $nav.on("mousedown", function (e) {
    isDown = true;
    $nav.addClass("is-dragging");
    startX = e.pageX - $nav.offset().left;
    scrollLeft = $nav.scrollLeft();
  });

  $(document).on("mouseup mouseleave", function () {
    if (!isDown) return;
    isDown = false;
    $nav.removeClass("is-dragging");
  });

  $nav.on("mousemove", function (e) {
    if (!isDown) return;
    e.preventDefault();
    var x = e.pageX - $nav.offset().left;
    var walk = (x - startX) * 1.5;
    $nav.scrollLeft(scrollLeft - walk);
  });

  // Sürükleme sırasında link tıklamalarını engelle
  $nav.on("click", "li", function (e) {
    if ($nav.data("dragged")) {
      e.preventDefault();
      e.stopPropagation();
    }
  });

  $nav.on("mousedown", function () {
    $nav.data("dragged", false);
  });

  $nav.on("mousemove", function () {
    if (isDown) $nav.data("dragged", true);
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
  console.log("test");

  drawers.forEach((drawer) => {
    drawer.classList.remove("drawer--active");
  });
  dimness.classList.remove("dimness--active");
}

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
