<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table w-full flex flex-col gap-10">
	<div class="card-container card-container-secondary">
		<div class="flex flex-row items-center justify-start gap-5">
			<h2 class="card-title">Sepetiniz</h2>
			<?php echo ebs_get_badge(sprintf('%s', WC()->cart->get_cart_contents_count())); ?>
		</div>
		<div class="flex flex-col gap-15">
			<?php
			do_action('woocommerce_review_order_before_cart_contents');

			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
				$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

				if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
					//var_dump($_product);	
			?>
					<div class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?> w-full flex flex-row items-center justify-start gap-15">
						<a href="<?php echo esc_url(get_permalink($_product->get_id())); ?>" class="relative">
							<?php echo ebs_get_badge(sprintf('%sx', $cart_item['quantity']), ["classes" => "absolute -top-5 -right-5"]); ?>
							<figure class="w-60 h-60 rounded-[10px] overflow-hidden grow-0 shrink-0 border border-gray-400">
								<img src="<?php echo esc_url(wp_get_attachment_url($_product->get_image_id())); ?>" alt="" class="w-full h-full object-cover" />
							</figure>
						</a>
						<div class="flex flex-col gap-5">
							<a href="<?php echo esc_url(get_permalink($_product->get_id())); ?>" class="product-name paragraph-md paragraph-regular text-gray-900">
								<?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?>
								<?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?>
							</a>
							<div class="product-total paragraph-md paragraph-bold text-gray-900">
								<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?>
							</div>
						</div>
					</div>
			<?php
				}
			}

			do_action('woocommerce_review_order_after_cart_contents');
			?>
		</div>
	</div>
	<div class="card-container card-container-primary">
		<h2 class="card-title">Özet</h2>
		<div class="w-full flex flex-col gap-20">
			<div class="cart-subtotal w-full flex flex-row items-center justify-between">
				<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Subtotal', 'woocommerce'); ?></div>
				<div class="paragraph-md paragraph-bold text-gray-900"><?php wc_cart_totals_subtotal_html(); ?></div>
			</div>

			<?php
			foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
				<div class="cart-discount w-full flex flex-row items-center justify-between px-15 py-10 bg-primary-50 rounded-[10px] border border-primary-500 border-dashed coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
					<div class="paragraph-md text-gray-900"><?php wc_cart_totals_coupon_label($coupon); ?></div>
					<div class="flex flex-row gap-10 items-center justify-end"><?php wc_cart_totals_coupon_html($coupon); ?></div>
				</div>
			<?php endforeach; ?>

			<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
				<?php do_action('woocommerce_review_order_before_shipping'); ?>
				<div class="ebs-checkout-shipping w-full flex flex-col items-start justify-start">
					<?php wc_cart_totals_shipping_html(); ?>
				</div>
				<?php do_action('woocommerce_review_order_after_shipping'); ?>
			<?php endif; ?>

			<?php foreach (WC()->cart->get_fees() as $fee) : ?>
				<div class="fee w-full flex flex-row items-center justify-between">
					<div class="paragraph-md paragraph-regular text-gray-900"><?php echo esc_html($fee->name); ?></div>
					<div class="paragraph-md paragraph-bold text-gray-900"><?php wc_cart_totals_fee_html($fee); ?></div>
				</div>
			<?php endforeach; ?>

			<?php if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) : ?>
				<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
					<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
					?>
						<div class="tax-rate w-full flex flex-row items-center justify-between tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
							<div class="paragraph-md paragraph-regular text-gray-900"><?php echo esc_html($tax->label); ?></div class="paragraph-md paragraph-regular text-gray-900">
							<div class="paragraph-md paragraph-bold text-gray-900"><?php echo wp_kses_post($tax->formatted_amount); ?></div class="paragraph-md paragraph-regular text-gray-900">
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="tax-total w-full flex flex-row items-center justify-between">
						<div class="paragraph-md paragraph-regular text-gray-900"><?php echo esc_html(WC()->countries->tax_or_vat()); ?></div>
						<div class="paragraph-md paragraph-bold text-gray-900"><?php wc_cart_totals_taxes_total_html(); ?></div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php do_action('woocommerce_review_order_before_order_total'); ?>
			<div class="w-full border-b border-dashed border-primary-600"></div>
			<div class="order-total w-full flex flex-row items-center justify-between">
				<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Total', 'woocommerce'); ?></div>
				<div class="paragraph-md paragraph-bold text-gray-900"><?php wc_cart_totals_order_total_html(); ?></div>
			</div>

			<?php do_action('woocommerce_review_order_after_order_total'); ?>
		</div>

	</div>
</div>