<?php

/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-billing-fields flex flex-col gap-32">
	<?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>
		<h3 class="display-sm checkout-title text-gray-900"><?php esc_html_e('Billing &amp; Shipping', 'woocommerce'); ?></h3>
	<?php else : ?>
		<h3 class="display-sm checkout-title text-gray-900"><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>
	<?php endif; ?>

	<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

	<div class="woocommerce-billing-fields__field-wrapper input-field-wrapper">
		<? $fields = $checkout->get_checkout_fields('billing'); ?>
		<? foreach ($fields as $key => $field) : ?>
			<?
			$field["class"] 	= array("input-field");
			?>
			<? woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
		<? endforeach; ?>
	</div>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>