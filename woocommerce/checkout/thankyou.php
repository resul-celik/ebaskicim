<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;

$button = new Button();
?>

<div class="woocommerce-order">

	<?php
	if ($order) :

		do_action('woocommerce_before_thankyou', $order->get_id());
	?>

		<?php if ($order->has_status('failed')) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">

				<?php echo $button->get_button(esc_html('Pay Now', 'woocommerce'), 'primary-button button-sm blue-button pay', '', '', '', '', '', '', esc_url($order->get_checkout_payment_url())); ?>
				<?php if (is_user_logged_in()) : ?>

					<?php echo $button->get_button(esc_html('My account', 'woocommerce'), 'button-sm secondary-black-button pay', '', '', '', '', '', 'icon-arrow-right', esc_url(wc_get_page_permalink('myaccount'))); ?>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template('checkout/order-received.php', array('order' => $order)); ?>

			<div class="jun-detail-box jun-detail-box--light">
				<h2><?php esc_html_e('Order details', 'woocommerce'); ?></h2>
				<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details jun-overview">

					<li class="jun-overview-item woocommerce-order-overview__order order">
						<?php esc_html_e('Order number:', 'woocommerce'); ?>
						<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?></strong>
					</li>

					<li class="jun-overview-item woocommerce-order-overview__date date">
						<?php esc_html_e('Date:', 'woocommerce'); ?>
						<strong><?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?></strong>
					</li>

					<?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
						<li class="jun-overview-item woocommerce-order-overview__email email">
							<?php esc_html_e('Email:', 'woocommerce'); ?>
							<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></strong>
						</li>
					<?php endif; ?>

					<?php if ($order->get_payment_method_title()) : ?>
						<li class="jun-overview-item woocommerce-order-overview__payment-method method">
							<?php esc_html_e('Payment method:', 'woocommerce'); ?>
							<strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
						</li>
					<?php endif; ?>
					<!-- Subtotal -->
					<div class="cart-totals-divider"></div>
					<li class="jun-overview-item woocommerce-order-overview__total total">
						<?php esc_html_e('Subtotal:', 'woocommerce'); ?>
						<strong><?php echo $order->get_subtotal_to_display(); ?></strong>
					</li>

					<div class="cart-totals-divider"></div>
					<li class="jun-overview-item woocommerce-order-overview__total total">
						<?php esc_html_e('Total:', 'woocommerce'); ?>
						<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?></strong>
					</li>
				</ul>
			</div>

		<?php endif; ?>
		<div class="jun-detail-box jun-detail-box--dark">
			<h2><?php esc_html_e('Product Details', 'woocommerce'); ?></h2>
			<?php
			$order_items = $order->get_items();
			foreach ($order_items as $item_id => $item) {
				$product = $item->get_product();
			?>
				<div class="jun-product-detail">
					<div class="jun-product-detail__image">
						<?php echo $product->get_image(); ?>
					</div>
					<div class="jun-product-detail__content">
						<p class="jun-product-detail__quantity"><?php echo  $item->get_quantity() . 'pieces'; ?></p>
						<h3 class="jun-product-detail__title"><?php echo $product->get_name(); ?></h3>
						<p class="jun-product-detail__price"><?php echo $product->get_price_html(); ?></p>
					</div>
				</div>
			<?php } ?>

		</div>

		<div class="jun-detail-box jun-detail-box--light">
			<h2><?php esc_html_e('Billing Address', 'woocommerce'); ?></h2>
			<address>
				<?php echo wp_kses_post($order->get_formatted_billing_address()); ?>
				<?php if ($order->get_billing_phone()) : ?>
					<p><?php echo esc_html($order->get_billing_phone()); ?></p>
					<p><?php echo esc_html($order->get_billing_email()); ?></p>
				<?php endif; ?>
			</address>
		</div>

	<?php else : ?>

		<?php wc_get_template('checkout/order-received.php', array('order' => false)); ?>

	<?php endif; ?>

</div>