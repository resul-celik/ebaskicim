<?php

/**
 * Checkout Order Receipt Template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-receipt.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.2.0
 */

if (! defined('ABSPATH')) {
	exit;
}
?>

<div class="woocommerce-order w-full max-w-[540px] flex flex-col items-start justify-start gap-10 px-20 py-60">
	<div class="card-container card-container-secondary w-full">
		<h2 class="card-title">
			<?php esc_html_e('Order details', 'woocommerce'); ?>
		</h2>
		<ul class="order_details w-full flex flex-col gap-20">
			<li class="order w-full flex fleex-row items-center justify-between">
				<?php esc_html_e('Order number:', 'woocommerce'); ?>
				<strong><?php echo esc_html($order->get_order_number()); ?></strong>
			</li>
			<li class="date w-full flex fleex-row items-center justify-between">
				<?php esc_html_e('Date:', 'woocommerce'); ?>
				<strong><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></strong>
			</li>
			<li class="total w-full flex fleex-row items-center justify-between">
				<?php esc_html_e('Total:', 'woocommerce'); ?>
				<strong><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
			</li>
			<?php if ($order->get_payment_method_title()) : ?>
				<li class="method w-full flex fleex-row items-center justify-between">
					<?php esc_html_e('Payment method:', 'woocommerce'); ?>
					<strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<h2 class="w-full text-center paragraph-2xl paragraph-medium text-gray-900 pb-30 ">Ödeme Yöntemi</h2>
</div>
<?php do_action('woocommerce_receipt_' . $order->get_payment_method(), $order->get_id()); ?>

<div class="clear"></div>