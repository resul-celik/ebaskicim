<?php

/**
 * Order again button
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-again.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;
$args = array(
	"text" => "Siparişi Tekrarla",
	"url" => esc_url($order_again_url),
	"classes" => esc_attr($wp_button_class),
	"trailingIcon" => "refresh",
)
?>

<p class="order-again w-full flex flex-row items-center justify-start">
	<?php echo get_button($args); ?>
</p>