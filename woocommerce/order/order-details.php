<?php

/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

// phpcs:disable WooCommerce.Commenting.CommentHooks.MissingHookComment

defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if (! $order) {
	return;
}

$order_items        = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$downloads          = $order->get_downloadable_items();

// We make sure the order belongs to the user. This will also be true if the user is a guest, and the order belongs to a guest (userID === 0).
$show_customer_details = $order->get_user_id() === get_current_user_id();

if ($show_downloads) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details w-full flex flex-col gap-30 px-25">
	<?php do_action('woocommerce_order_details_before_order_table', $order); ?>

	<div class="woocommerce-table woocommerce-table--order-details shop_table order_details flex flex-col gap-30">
		<?php
		do_action('woocommerce_order_details_before_order_table_items', $order); ?>
		<div class="w-full flex flex-col">
			<?php foreach ($order_items as $item_id => $item) {
				$product = $item->get_product();

				wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				);
			} ?>
		</div>
		<?php do_action('woocommerce_order_details_after_order_table_items', $order); ?>
		<div class="cart-totals-divider w-full h-[1px] border-b border-gray-300 border-dashed"></div>
		<?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
			<div class="woocommerce-table__total w-full flex flex-row items-center justify-between">
				<div class="paragraph-md paragraph-regular text-gray-900"><?php echo esc_html($total['label']); ?></div>
				<strong><?php echo wp_kses_post($total['value']); ?></strong>
			</div>
		<?php endforeach; ?>
		<div class="cart-totals-divider w-full h-[1px] border-b border-gray-300 border-dashed"></div>
		<?php if ($order->get_customer_note()) : ?>
			<div class="woocommerce-table__total w-full flex flex-row items-center justify-between">
				<div class="paragraph-md paragraph-regular text-gray-900">Sipariş Notunuz:</div>
				<strong class="paragraph-sm paragraph-medium text-gray-900 px-15 py-10 bg-gray-100 rounded-tl-[15px] rounded-tr-[15px] rounded-br-[5px] rounded-bl-[15px]"><?php echo wp_kses(nl2br(wptexturize($order->get_customer_note())), array()); ?></strong>
			</div>
		<?php endif; ?>
	</div>

	<?php do_action('woocommerce_order_details_after_order_table', $order); ?>
</section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action('woocommerce_after_order_details', $order);

if ($show_customer_details) {
	wc_get_template('order/order-details-customer.php', array('order' => $order));
}
