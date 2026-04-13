/* MAIN NAV SCROLL BUTTONS (Start) */

jQuery(function ($) {
  var $nav      = $("#main-nav-list");
  if (!$nav.length) return;

  var $btnLeft  = $("#nav-scroll-left");
  var $btnRight = $("#nav-scroll-right");
  var STEP      = 240;

  function updateButtons() {
    var el       = $nav[0];
    var atStart  = el.scrollLeft <= 0;
    var atEnd    = el.scrollLeft >= el.scrollWidth - el.clientWidth - 1;

    $btnLeft.prop("hidden", atStart);
    $btnRight.prop("hidden", atEnd);
  }

  $nav.on("scroll", updateButtons);
  $(window).on("resize", updateButtons);
  updateButtons();

  $btnLeft.on("click", function () {
    $nav.animate({ scrollLeft: $nav.scrollLeft() - STEP }, 250);
  });

  $btnRight.on("click", function () {
    $nav.animate({ scrollLeft: $nav.scrollLeft() + STEP }, 250);
  });
});

/* MAIN NAV SCROLL BUTTONS (End) */

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
  pagination: {
    el: ".main-slider-pagination",
    clickable: true,
  },
  navigation: {
    prevEl: ".main-slider-nav-btn--prev",
    nextEl: ".main-slider-nav-btn--next",
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

// Menu — dropdown hover with gap-bridging delay

(function () {
  var hideTimer = null;
  var activeContent = null;
  var activeItem = null;

  function showDropdown(content, item) {
    clearTimeout(hideTimer);
    if (activeContent && activeContent !== content) {
      activeContent.style.display = "none";
      if (activeItem) activeItem.classList.remove("main-menu-item--active");
    }
    content.style.display = "flex";
    item.classList.add("main-menu-item--active");
    activeContent = content;
    activeItem = item;
  }

  function scheduleHide() {
    hideTimer = setTimeout(function () {
      if (activeContent) activeContent.style.display = "none";
      if (activeItem) activeItem.classList.remove("main-menu-item--active");
      activeContent = null;
      activeItem = null;
    }, 120);
  }

  document.querySelectorAll(".main-menu-item").forEach(function (item) {
    var id = item.getAttribute("data-item-id");
    var content = document.querySelector(".menu-content-" + id);
    if (!content) return;

    item.addEventListener("mouseenter", function () { showDropdown(content, item); });
    item.addEventListener("mouseleave", scheduleHide);
    content.addEventListener("mouseenter", function () { clearTimeout(hideTimer); });
    content.addEventListener("mouseleave", scheduleHide);
  });
})();

/* DESIGN UPLOAD (Start) */

jQuery(function ($) {
  var $dropzone = $(".design-dropzone");
  if (!$dropzone.length) return;

  var $area      = $dropzone.find(".design-dropzone__area");
  var $fileInput = $dropzone.find(".design-file-input");
  var $progress  = $dropzone.find(".design-upload-progress");
  var $progBar   = $dropzone.find(".design-progress-bar");
  var $progName  = $dropzone.find(".design-progress-filename");
  var $fileInfo  = $dropzone.find(".design-file-info");
  var $fileName  = $dropzone.find(".design-file-name");
  var $removeBtn = $dropzone.find(".design-remove-btn");
  var nonce      = $dropzone.data("nonce");

  // "Dosya Seç" button opens the hidden file input
  $dropzone.on("click", ".design-select-btn", function () {
    $fileInput.trigger("click");
  });

  // File selected via browse
  $fileInput.on("change", function () {
    if (this.files.length) handleFile(this.files[0]);
  });

  // Drag over — highlight zone
  $area.on("dragover dragenter", function (e) {
    e.preventDefault();
    $area.addClass("design-dropzone__area--active");
  });

  $area.on("dragleave dragend", function () {
    $area.removeClass("design-dropzone__area--active");
  });

  // Drop
  $area.on("drop", function (e) {
    e.preventDefault();
    $area.removeClass("design-dropzone__area--active");
    var files = e.originalEvent.dataTransfer.files;
    if (files.length) handleFile(files[0]);
  });

  // Remove uploaded file
  $removeBtn.on("click", function () {
    resetUpload();
  });

  function resetUpload() {
    $(".ebs-design-file-key").val("");
    $(".ebs-design-file-name").val("");
    $fileInput.val("");
    $fileInfo.prop("hidden", true);
    $area.prop("hidden", false);
  }

  function handleFile(file) {
    var formData = new FormData();
    formData.append("action", "ebs_upload_design");
    formData.append("nonce", nonce);
    formData.append("design_file", file);

    $area.prop("hidden", true);
    $fileInfo.prop("hidden", true);
    $progName.text(file.name);
    $progBar.css("width", "0%");
    $progress.prop("hidden", false);

    $.ajax({
      url: window.ebs_ajax.ajax_url,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      xhr: function () {
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (e) {
          if (e.lengthComputable) {
            $progBar.css("width", (e.loaded / e.total) * 100 + "%");
          }
        });
        return xhr;
      },
      success: function (res) {
        $progress.prop("hidden", true);
        if (res.success) {
          $(".ebs-design-file-key").val(res.data.file_key);
          $(".ebs-design-file-name").val(res.data.file_name); // display name only
          $fileName.text(res.data.file_name);
          $fileInfo.prop("hidden", false);
        } else {
          $area.prop("hidden", false);
          alert("Yükleme hatası: " + res.data);
        }
      },
      error: function () {
        $progress.prop("hidden", true);
        $area.prop("hidden", false);
        alert("Dosya yüklenemedi. Lütfen tekrar deneyin.");
      },
    });
  }
});

/* DESIGN UPLOAD (End) */

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
