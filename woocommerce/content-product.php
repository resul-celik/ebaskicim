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



<a href=<?php echo esc_url(get_permalink($product->get_id())); ?> class="product flex shrink-0 flex-col swiper-slide<?php echo $product->is_in_stock() ? '' : ' sold-out'; ?>">

    <figure class="product-image w-full aspect-4/3 relative overflow-hidden">
        <?php echo woocommerce_get_product_thumbnail('medium_large'); ?>
        <?php woocommerce_show_product_sale_flash(); ?>
        <div class="product-tags">
            <?php if ($product->is_in_stock()) : ?>
                <?php
                $post_date = get_the_date('U', $product->get_id());
                $current_date = current_time('timestamp');
                $date_diff = $current_date - $post_date;

                if ($date_diff < DAY_IN_SECONDS) {
                ?>
                    <div class="product-tag new-tag">
                        <div class="icon icon-fire"></div>
                        <?php _e('New', 'junobjects'); ?>
                    </div>
                <?php
                }
                ?>

                <?php
                $sale_price = $product->get_sale_price();
                $regular_price = $product->get_regular_price();

                if ($sale_price && $regular_price) {
                    echo '<div class="product-tag discount-tag">';
                    $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                    echo '<div class="icon icon-smile"></div>' . sprintf(__('%d%% off', 'junobjects'), $discount_percentage);
                    echo '</div>';
                }
                ?>
                <?php if ($product->is_featured()) : ?>
                    <div class="product-tag best-tag">
                        <div class="icon icon-diamond"></div>
                        <?php _e('Best seller', 'junobjects'); ?>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div class="product-tag sold-out-tag">
                    <div class="icon icon-sad"></div>
                    <?php _e('Sold out', 'junobjects'); ?>
                </div>
            <?php endif; ?>
        </div>
    </figure>
    <div class="flex flex-col gap-[5px] pt-[20px]">
        <div class="content-product-title m-0">
            <?php _e(get_the_title($product->get_id()), 'junobjects'); ?>
        </div>
        <span class="price content-price">
            <?php echo $product->get_price_html(); ?>
        </span>
    </div>
</a>