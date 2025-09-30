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

?>
<?php //do_action('woocommerce_before_cart'); 
?>
<?php if (WC()->cart->get_cart()) : ?>
    <form class="woocommerce-cart-form shop_table shop_table_responsive cart w-full flex flex-col px-10 stretch grow-1 overflow-y-auto" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>
        <?php do_action('woocommerce_before_cart_contents'); ?>
        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :

                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

        ?>

                <div class="w-full flex flex-row p-10 gap-20 items-center justify-start rounded-[10px] hover:bg-gray-100 woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    <div class="cart-item-thumbnail w-90 h-90 rounded-[10px] overflow-hidden">
                        <?php
                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('product_thubmbnail_large'), $cart_item, $cart_item_key);

                        if (! $product_permalink) {
                            echo $thumbnail; // PHPCS: XSS ok.
                        } else {
                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                        }
                        ?>
                    </div>
                    <div class="flex flex-col grow-1">
                        <div class="mb-6 paragraph-xs text-gray-600 uppercase">
                            <?php echo sprintf(__('%d adet', 'ebaskicim'), $cart_item['quantity']); ?>
                        </div>
                        <div class="paragraph-sm text-gray-900" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                            <?php
                            if (! $product_permalink) {
                                echo wp_kses_post($product_name . '&nbsp;');
                            } else {
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
                        <div class="flex flex-row">
                            <div class="paragraph-md paragraph-medium text-gray-900" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                <?php
                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        'woocommerce_cart_item_remove_link',
                        sprintf(
                            '<a href="%s" class="remove w-32 h-32 flex items-center justify-center text-error-500 rounded-full hover:bg-error-100 grow-0 shrink-0" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon !w-20 !h-20 icon-delete before:!text-[20px]"></i></a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                            esc_attr($product_id),
                            esc_attr($_product->get_sku())
                        ),
                        $cart_item_key
                    );
                    ?>
                </div>
        <?php endif;
        endforeach; ?>
        <?php do_action('woocommerce_cart_contents'); ?>
        <!-- cart actions -->
        <?php do_action('woocommerce_after_cart_contents'); ?>
        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>

    <div class="cart-collaterals w-full flex flex-col">
        <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        //do_action('woocommerce_cart_collaterals');
        ?>
        <?php woocommerce_cart_totals();
        ?>
    </div>

<?php else:  ?>
    <div class="w-full flex flex-col items-center justify-center gap-45 py-55">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/empty-cart.svg" alt="">
        <div class="flex flex-col gap-15 items-center">
            <div class="paragraph-md text-gray-900">Sepetiniz boş</div>
            <?php echo get_button(array("text" => "Alışverişe devam et", "url" => get_home_url())); ?>
        </div>
    </div>
<?php endif; ?>