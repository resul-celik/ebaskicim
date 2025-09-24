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

<a href=<?php echo esc_url(get_permalink($product->get_id())); ?> class="product-item mega-banner-item<?php echo $product->is_in_stock() ? '' : ' sold-out'; ?>">

    <figure class="product-image">
        <?php echo woocommerce_get_product_thumbnail('medium_large'); ?>
    </figure>
    <div class="product-info">
        <div class="name-and-price">
            <div class="content-product-title">
                <?php _e(get_the_title(), 'junobjects'); ?>
            </div>
            <span class="price content-price">
                <?php _e($product->get_price_html(), 'junobjects'); ?>
            </span>
        </div>
        <?php if ($product->is_on_sale()) : ?>
            <?php $sale_price = $product->get_sale_price(); ?>
            <?php $regular_price = $product->get_regular_price(); ?>
            <?php $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100); ?>
            <div class="mega-discount">
                <?php echo $discount_percentage; ?>%
            </div>
        <?php endif; ?>
    </div>
</a>