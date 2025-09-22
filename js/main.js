$(function () {
  /**

        * Theme jQuery
        *
        * @package Ebaskıcım
        *
        * (c) 2020 All rights reserved. The codes belong to Ebaskıcım. Unauthorized using the codes, copying and sharing is strictly prohibited.
        *

    ########## TABLE OF CONTENTS ##########


    **/

  $(".input-label").click(function () {
    $(this).siblings("input").focus();
    $(this).siblings("textarea").focus();
  });

  $(".input-container > input").focus(function () {
    $(this).siblings(".input-label").addClass("label-up");
  });

  $(".input-container > textarea").focus(function () {
    $(this).siblings(".input-label").addClass("label-up");
  });

  $(".input-container > input").focusout(function () {
    if (!$(this).val()) {
      $(this).siblings(".input-label").removeClass("label-up");
    }
  });

  $(".input-container > textarea").focusout(function () {
    if (!$(this).val()) {
      $(this).siblings(".input-label").removeClass("label-up");
    }
  });

  $(document).ready(function () {
    if ($(".input-container > input").val()) {
      $(".input-container > input")
        .siblings(".input-label")
        .addClass("label-up");
    }
  });

  $(".big-slider-container").owlCarousel({
    items: 1,
    dragClass: "big-slider-drag",
    grabClass: "big-slider-grab",
    stageClass: "big-slider-items-wrapper",
    stageOuterClass: "big-slider-wrapper",
    nav: true,
    navContainerClass: "big-slider-navigations",
    navClass: ["big-slider-prev", "big-slider-next"],
    dotClass: "big-slider-dot",
    dotsClass: "big-slider-dots",
  });

  $(".mobile-introduction-container").owlCarousel({
    stagePadding: 50,
    items: 1,
    dragClass: "introduction-drag",
    grabClass: "introduction-grab",
    stageClass: "mobile-introduction-items-wrapper",
    stageOuterClass: "mobile-introduction-wrapper",
    navContainerClass: "mobile-introduction-navigations",
    navClass: ["mobile-introduction-prev", "mobile-introduction-next"],
    dotClass: "mobile-introduction-dot",
    dotsClass: "mobile-introduction-dots",
    margin: 20,
  });

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

  $(".product-prev").html('<i class="icon arrow-left-16"></i>');
  $(".product-next").html('<i class="icon arrow-right-16"></i>');

  $(document).ready(function () {
    var windowSize = $(window).width();

    if (windowSize > 500) {
      var sliderH = $(".big-slider-right-container").height();
      $(".big-slider-left-container").outerHeight(sliderH);
    }

    $(window).resize(function () {
      if (windowSize > 500) {
        var sliderH = $(".big-slider-right-container").height();
        $(".big-slider-left-container").outerHeight(sliderH);
      }
    });
  });

  /* SELECT INPUT */

  $(".selected-label").on("click", function (e) {
    e.preventDefault();

    var inputDisabled = $(this).attr("input-disabled");

    if (inputDisabled == "true") {
      $(this).addClass("input-disabled");
    } else {
      $(this).siblings(".select-options").toggleClass("hide-options");
    }

    return false;
  });

  $(".select-option-label").on("click", function () {
    var option = $(this);
    var optionVal = option.text();

    option
      .parents(".select-options")
      .siblings(".selected-label")
      .text(optionVal);
  });

  $(document).on("click", function () {
    $(".select-options").addClass("hide-options");
  });

  /* SELECT INPUT */

  $(".increase-quantity").on("click", function () {
    var changeButton = $(this);
    var quantityInput = changeButton.siblings(".quantity");
    var currentValue = quantityInput.val();
    var maxValue = quantityInput.attr("max");

    $(".cart-actions-cell").find(".button").prop("disabled", false);
    $(".cart-actions-cell").find(".button").attr("aria-disabled", false);

    if (typeof maxValue === "undefined") {
      ++currentValue;
      quantityInput.val(currentValue);
      quantityInput.attr("value", currentValue);
    } else {
      ++currentValue;

      if (maxValue >= currentValue) {
        quantityInput.val(currentValue);
        quantityInput.attr("value", currentValue);
      }
    }
  });

  $(".decrease-quantity").on("click", function () {
    var changeButton = $(this);
    var quantityInput = changeButton.siblings(".quantity");
    var currentValue = quantityInput.val();
    var minValue = quantityInput.attr("min");

    $(".cart-actions-cell").find(".button").prop("disabled", false);
    $(".cart-actions-cell").find(".button").attr("aria-disabled", false);

    if (typeof minValue === "undefined") {
      minValue = 0;
    }

    if (currentValue > minValue) {
      --currentValue;
      quantityInput.val(currentValue);
    }
  });

  $(".accordion-title").on("click", function () {
    $(this).nextAll(".accordion-panel:first").toggleClass("panel-hide");
    $(this).toggleClass("last-title");
  });

  $(".menu-accordion-title").on("click", function () {
    $(this)
      .nextAll(".menu-accordion-content:first")
      .toggleClass("content-open");
    $(this).toggleClass("title-open");
  });

  $(document).ready(function () {
    $(".tm-tab").eq(0).addClass("active-tab");
    $(".tm-tab-panel").eq(0).addClass("active-panel");

    $(".tm-tab").on("click", function () {
      var tabIndex = $(this).index();

      $(".tm-tab").removeClass("active-tab");
      $(this).addClass("active-tab");
      $(".tm-tab-panel").removeClass("active-panel");
      $(".tm-tab-panel:eq(" + tabIndex + ")").addClass("active-panel");
    });
  });

  $("#credit-card-name").keyup(function () {
    var fieldValue = $(this).val();
    var characterLength = fieldValue.length;

    $(".credit-card-preview").addClass("entered-card-information");

    if (characterLength > 14 && characterLength < 22) {
      $(".credit-card-holder-name").css("font-size", "1.2em");
    } else if (characterLength > 21) {
      $(".credit-card-holder-name").css("font-size", "1em");
    } else {
      $(".credit-card-holder-name").css("font-size", "1.6em");
    }

    if (characterLength == 0) {
      $(".credit-card-holder-name").text("card holder");
    } else {
      $(".credit-card-holder-name").text(fieldValue);
    }
  });

  $("#credit-card-number").keyup(function () {
    var fieldValue = $(this).val();
    var characterLength = fieldValue.length;

    $(".credit-card-preview").addClass("entered-card-information");

    if (characterLength == 0) {
      $(".credit-card-number").text("0000-0000-0000-0000");
    } else {
      $(".credit-card-number").text(fieldValue);
    }
  });

  $("#credit-card-number").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  $("#credit-card-cvc2").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  $("#credit-card-number").mask("0000-0000-0000-0000");

  $(".expired-month").click(function () {
    $(".credit-card-preview").addClass("entered-card-information");

    $(".credit-card-expire-date").text($(this).text() + "/");

    $(".expired-select-year").removeAttr("input-disabled");
    $(".expired-select-year").removeClass("input-disabled");
  });

  $(".expired-year").click(function () {
    $(".credit-card-preview").addClass("entered-card-information");

    $(".credit-card-expire-date").append($(this).text().slice(-2));
  });

  $("#credit-card-cvc2").focus(function () {
    $(".credit-card-preview-wrapper").addClass("flip-card");
  });

  $("#credit-card-cvc2").focusout(function () {
    $(".credit-card-preview-wrapper").removeClass("flip-card");
  });

  $("#credit-card-cvc2").keyup(function () {
    $(".credit-card-back-cvc2").text($(this).val());
  });

  $(document).ready(function () {
    var holderSize = $(".credit-card-col").width();
    var aspectRatio = (holderSize / 3) * 2;

    if (500 > holderSize) {
      $(".credit-card-preview").css({
        width: holderSize + "px",
        height: aspectRatio + "px",
        left: 0,
      });

      $(".credit-card-preview-wrapper").css({
        width: holderSize + "px",
        height: aspectRatio + "px",
        left: 0,
      });
    } else {
      $(".credit-card-preview").css({
        width: "500px",
        height: "300px",
      });

      $(".credit-card-preview-wrapper").css({
        width: "500px",
        height: "300px",
      });
    }
  });

  $(document).ready(function () {
    var psWrapperWidth = $(".product-image-slider-wrapper").width();
    var psImageIndex = $(".product-image").length;
    var psTotalWidth = psWrapperWidth * psImageIndex;
    var index = 0;

    $(".product-thumbnail").eq(0).addClass("active-thumbnail");

    $(".product-image").width(psWrapperWidth);
    $(".product-full-size-images-wrapper").width(psTotalWidth);

    // when clicked on thumbnails

    $(".product-thumbnail").on("click", function () {
      index = $(this).index() - 1;
      var thumbnailIndex = psWrapperWidth * index;

      $(".product-thumbnail").removeClass("active-thumbnail");
      $(this).addClass("active-thumbnail");

      $(".product-full-size-images-wrapper").css({
        left: "-" + thumbnailIndex + "px",
      });
    });

    // when clicked right arrow

    $(".thumbnail-right-arrow").on("click", function () {
      ++index;

      var thumbnailGoRight = psWrapperWidth * index;
      $(".product-thumbnail").removeClass("active-thumbnail");

      if (index > psImageIndex - 1) {
        index = 0;

        $(".product-thumbnail").eq(0).addClass("active-thumbnail");

        $(".product-full-size-images-wrapper").css({
          left: "0px",
        });
      } else {
        $(".product-thumbnail").eq(index).addClass("active-thumbnail");

        $(".product-full-size-images-wrapper").css({
          left: "-" + thumbnailGoRight + "px",
        });
      }
    });

    // when clicked left arrow

    $(".thumbnail-left-arrow").on("click", function () {
      var thumbnailGoRight;
      $(".product-thumbnail").removeClass("active-thumbnail");

      if (index == 0) {
        index = psImageIndex - 1;
        thumbnailGoRight = psWrapperWidth * index;

        $(".product-thumbnail").eq(index).addClass("active-thumbnail");

        $(".product-full-size-images-wrapper").css({
          left: "-" + thumbnailGoRight + "px",
        });
      } else {
        --index;
        thumbnailGoRight = psWrapperWidth * index;

        $(".product-thumbnail").eq(index).addClass("active-thumbnail");

        $(".product-full-size-images-wrapper").css({
          left: "-" + thumbnailGoRight + "px",
        });
      }
    });
  });

  $(document).ready(function () {
    if ($(window).width() < 991) {
      $(".product-image").zoom({
        on: "toggle",
      });
    } else {
      $(".product-image").zoom();
    }
  });

  /* to center */

  function to_center(element, from, topDec) {
    var topDecrease, fromH;

    if (typeof from === "undefined") {
      fromH = false;
    } else {
      if (from != false) {
        fromH = true;
      }
    }

    if (typeof topDec === "undefined") {
      topDecrease = 0;
    } else {
      if (topDec != false) {
        topDecrease = topDec;
      } else {
        topDecrease = 0;
      }
    }

    if (fromH == true) {
      var windowh = $(from).outerHeight();
    } else {
      var windowh = $(window).height();
    }

    var height = $(element).outerHeight();

    if (height > windowh) {
      $(element).css("top", "100px");
    } else {
      $(element).css("top", (windowh - height - topDecrease) / 2 + "px");
    }
  }

  $(document).ready(function () {
    to_center(".lightbox");
  });

  function show_curtain($click, $show) {
    $click.click(function () {
      $(".lightbox-wrapper").show();
      $(".lightbox").hide();
      $show.show();
      to_center($show);
    });
  }

  show_curtain($(".address-summary-edit"), $(".billing-lightbox"));
  show_curtain($(".checkout-add-new-address"), $(".shipping-lightbox"));

  $(".lightbox-close").click(function () {
    $(".lightbox-wrapper").hide();
    $(this).parent(".lightbox").hide();
  });

  $(".lightbox-cancel").click(function () {
    $(".lightbox-wrapper").hide();
    $(this).parent(".lightbox").hide();
  });

  $(".curtain").click(function () {
    $(".lightbox-wrapper").hide();
    $(this).siblings(".lightbox").hide();
  });

  $(".ebaskicim-variation-select")
    .find("select")
    .change(function () {
      $(".ebaskicim-variable-price").addClass("new-price-value");

      setTimeout(function () {
        var variablePrice = $(".woocommerce-variation-price").html();

        $(".ebaskicim-variable-price").html(variablePrice);

        $(".ebaskicim-variable-price").removeClass("new-price-value");
      }, 200);
    });

  var defaultPrice = $(".ebaskicim-variable-price").data("default-price");

  $(".reset_variations").on("click", function () {
    $(".ebaskicim-variable-price ins").find(".amount").html(defaultPrice);
    $(".ebaskicim-variable-price").find("del").hide();
    $(".ebaskicim-variable-price").addClass("new-price-value");

    setTimeout(function () {
      $(".ebaskicim-variable-price").removeClass("new-price-value");
    }, 200);
  });

  $(".mobile-search-icon").on("click", function () {
    $(".mobile-search-wrapper").removeClass("hidden-ms-input");
    $(".mobile-search-wrapper").find("#mobile-search").focus();
  });

  $(".mobile-search-wrapper")
    .find("#mobile-search")
    .focusout(function () {
      $(".mobile-search-wrapper").addClass("hidden-ms-input");
    });

  function hidden_side_menu(params) {
    var container = $(params.container);
    var trigger = $(params.trigger);
    var hideClass = params.hideClass;
    var scrollable = params.scrollable;

    if (typeof scrollable == "undefined" || !scrollable) {
      scrollable = false;
    }

    trigger.on("click", function () {
      container.removeClass(hideClass);

      if (scrollable == true) {
        $("body").css("position", "fixed");
      }
    });

    container.find(".hidden-side-menu-shadow").on("click", function () {
      container.addClass(hideClass);

      if (scrollable == true) {
        $("body").css("position", "static");
      }
    });

    container.find(".hidden-side-menu-close-button").on("click", function () {
      container.addClass(hideClass);

      if (scrollable == true) {
        $("body").css("position", "static");
      }
    });
  }

  hidden_side_menu({
    container: ".hidden-mobile-side-menu",
    trigger: ".menu-icon-wrapper",
    hideClass: "hide-left-side-menu",
    scrollable: true,
  });

  hidden_side_menu({
    container: ".account-side-menu",
    trigger: ".account-button",
    hideClass: "hide-right-side-menu",
  });

  $(".close-notice").on("click", function () {
    $(this).parents(".notices").addClass("hide-notices");
  });

  /* $('.update-address-summary').on('click', function(){
        
        var billingName = $('#billing_first_name').val();
        var billingLastName = $('#billing_last_name').val();
        var billingEmail = $('#billing_email').val();
        var billingAddress1 = $('#billing_address_1').val();
        var billingAddress2 = $('#billing_address_2').val();
        var billingCity = $('#billing_city').val();
        var billingState = $('#billing_state option:selected').val();
        var billingPhone = $('#billing_phone').val();
        var billingZip = $('#billing_postcode').val();
        
        
        $('.address-summary-name').text(billingName+' '+billingLastName);
        $('.address-summary-email').text(billingEmail);
        $('.address-summary-address').text(billingAddress1+' '+billingAddress2+', '+billingCity+', '+billingState);
        $('.address-summary-phone').text(billingPhone);
        $('.address-summary-zip').text(billingZip);
        
    }); */

  /* var data_str = $(".variations_form").attr("data-product_variations");
    var my_object = JSON.parse(decodeURIComponent(data_str));
    
    console.log(my_object);
    
    $('.select-option-label').on('click', function(){
        
        var variationId = $(this).siblings('.hidden-option').attr('name');
        var thisParent = $(this).parents('.select-option');
        var index = thisParent.length;
        
        
        $('.variation_id').val(variationId);
            
        
        
    });
    
    var optionLength = -1;
    
    $('.select-option').each(function(){
        
        ++optionLength;
        
        $(this).attr('data-product-index', optionLength);
        
        
        
    });
    
    $('.select-option').on('click', function(){
            
        var getAttr = $(this).data('product-index');
        
        $('.product-price').addClass('new-price-value');
        
        
        setTimeout(function(){
            
            $('.product-price').removeClass('new-price-value');
            
        }, 600);
        
        var newPrice = my_object[getAttr].display_price.toFixed(2);
        var newPriceWithComma = newPrice.replace('.',',');
        
        $('.product-price').text(newPriceWithComma+' TL');
            
    }); */
});
