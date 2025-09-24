<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

$button = new Button();

?>
<div class="cart-wrapper">
    <?php //do_action('woocommerce_before_cart'); 
    ?>
    <?php if (WC()->cart->get_cart()) : ?>
        <form class="woocommerce-cart-form shop_table shop_table_responsive cart woocommerce-cart-form__contents" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>
            <?php do_action('woocommerce_before_cart_contents'); ?>
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :

                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

            ?>

                    <div class="cart-item woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                        <div class="cart-item-thumbnail product-thumbnail">
                            <?php
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('custom-thumbnail'), $cart_item, $cart_item_key);

                            if (! $product_permalink) {
                                echo $thumbnail; // PHPCS: XSS ok.
                            } else {
                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                            }
                            ?>
                        </div>
                        <div class="cart-product-info">
                            <div class="cart-product-qty">
                                <?php echo sprintf(__('%d pieces', 'junobjects'), $cart_item['quantity']); ?>
                            </div>
                            <div class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                <?php
                                if (! $product_permalink) {
                                    echo wp_kses_post($product_name . '&nbsp;');
                                } else {
                                    /**
                                     * This filter is documented above.
                                     *
                                     * @since 2.1.0
                                     */
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                }

                                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                // Meta data.
                                echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                // Backorder notification.
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                }
                                ?>
                            </div>
                            <div class="cart-item-prices">
                                <div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                    <?php
                                    echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                    ?>
                                </div>
                                <div class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                    (<?php
                                        echo $cart_item['quantity'] . 'x = ';
                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                        ?>)
                                </div>
                            </div>
                        </div>
                        <div class="product-remove">
                            <?php
                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                'woocommerce_cart_item_remove_link',
                                sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    /* translators: %s is the product name */
                                    esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                    esc_attr($product_id),
                                    esc_attr($_product->get_sku())
                                ),
                                $cart_item_key
                            );
                            ?>
                        </div>
                    </div>
            <?php endif;
            endforeach; ?>
            <?php do_action('woocommerce_cart_contents'); ?>
            <!-- cart actions -->
            <?php do_action('woocommerce_after_cart_contents'); ?>
            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>

        <?php do_action('woocommerce_before_cart_collaterals'); ?>

        <div class="cart-collaterals">
            <?php
            /**
             * Cart collaterals hook.
             *
             * @hooked woocommerce_cross_sell_display
             * @hooked woocommerce_cart_totals - 10
             */
            //do_action('woocommerce_cart_collaterals');
            ?>
            <?php //woocommerce_cross_sell_display(); 
            ?>
            <?php woocommerce_cart_totals();
            ?>
        </div>

    <?php else:  ?>
        <div class="jun-empty-cart">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/juno-empty-cart.svg" alt="">
            <div><?php _e('Your cart is currently empty.', 'junobjects'); ?></div>
            <?php echo $button->get_button(__('Continue Shopping', 'junobjects'), 'primary-button button-sm blue-button', '', '', '', '', '', '', get_home_url()); ?>
        </div>
    <?php endif; ?>
</div>