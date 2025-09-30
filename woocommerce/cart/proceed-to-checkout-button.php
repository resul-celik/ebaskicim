<?php

/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$additionalclasses = esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '');

$buttonArgs = array(
	"text" => "Ödeme Sayfasına Git",
	"classes" => "alt wc-forward" . $additionalclasses,
	"trailingIcon" => "arrow-right",
	"url" => wc_get_checkout_url()
);

$cartButtonArgs = array(
	"text" => "Sepet Detayları",
	"trailingIcon" => "plus",
	"url" => wc_get_cart_url(),
	"hierarchy" => "tertiary"
);
?>
<?php
echo '<div class="w-full flex flex-col gap-5">';
echo get_button($buttonArgs);
echo get_button($cartButtonArgs);
echo '</div>'; ?>