<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to ebaskicim/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || ! $product->is_visible()) {
    return;
}

/**
 * stock_status
 * regular_price
 * sale_price
 * price
 * permalink
 */

?>

<a href=<?php echo esc_url(get_permalink($product->get_id())); ?> class="product-item flex shrink-0 flex-col swiper-slide<?php echo $product->is_in_stock() ? '' : ' sold-out'; ?>">
    <figure class="product-image w-full aspect-4/3 relative overflow-hidden rounded-[10px]">
        <?php echo woocommerce_get_product_thumbnail('medium_large'); ?>
        <?php woocommerce_show_product_sale_flash(); ?>
        <div class="absolute top-20 left-20 flex flex-col gap-[3px] justify-start items-start z-10">
            <?php if ($product->is_in_stock()) {
                // New tag
                $post_date = get_the_date('U', $product->get_id());
                $current_date = current_time('timestamp');
                $date_diff = $current_date - $post_date;

                if ($date_diff < DAY_IN_SECONDS) {
                    echo product_status_tag("Yeni", "bg-black text-white");
                }

                // Discount tag
                $sale_price = $product->get_sale_price();
                $regular_price = $product->get_regular_price();

                if ($sale_price && $regular_price) {
                    $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                    echo product_status_tag("%$discount_percentage indirim", "bg-primary-400 text-gray-900");
                }

                // Featured tag
                if ($product->is_featured()) {
                    echo product_status_tag("Çok Satan", "bg-gray-700 text-white");
                }
            } else if ($product->is_on_backorder()) {
                echo product_status_tag("Stokta Yok", "bg-gray-500 text-white");
            } else {
                echo product_status_tag("Tükendi", "bg-red-500 text-white");
            } ?>
        </div>
    </figure>
    <div class="product-info flex flex-col gap-[5px] pt-[20px]">
        <div class="paragraph-lg text-gray-600">
            <?php echo get_the_title($product->get_id()); ?>
        </div>
        <span class="price flex flex-row gap-[8px] justify-start display-sm text-gray-900">
            <?php
            // get sale price
            if ($product->is_on_sale()) {
                echo "<del class='old-price'>" . wc_price($product->get_regular_price()) . "</del>";
                echo wc_price($product->get_sale_price());
            } else {
                echo wc_price($product->get_regular_price());
            }
            ?>
        </span>
    </div>
</a>