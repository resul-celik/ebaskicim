<?php

/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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

if (! defined('ABSPATH')) {
	exit;
}

if (! apply_filters('woocommerce_order_item_visible', true, $item)) {
	return;
}
?>
<div class="w-full flex flex-row items-center justify-start py-5 border-b border-gray-200 last:border-b-0 <?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order)); ?>">

	<div class="woocommerce-table__product-name product-name flex items-center justify-start gap-10 grow-1">
		<?php
		$is_visible        = $product && $product->is_visible();
		$product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);

		echo '<a href="' . esc_url($product_permalink) . '" class="w-50 h-50 shrink-0 grow-0 rounded-[10px] overflow-hidden">';
		echo apply_filters('woocommerce_order_item_thumbnail', $product ? $product->get_image('product_thubmbnail_medium', array('title' => '', "class" => "w-full h-full object-cover")) : '', $item_id, $item);
		echo '</a>';
		echo '<div class="w-full flex flex-col justify-start">';
		echo '<div class="w-full flex flex-row gap-5">';

		echo wp_kses_post(apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s" class="paragraph-md paragraph-regular text-gray-900">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible));

		$qty          = $item->get_quantity();
		$refunded_qty = $order->get_qty_refunded_for_item($item_id);

		if ($refunded_qty) {
			$qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ($refunded_qty * -1)) . '</ins>';
		} else {
			$qty_display = esc_html($qty);
		}
		echo apply_filters('woocommerce_order_item_quantity_html', ' <div class="paragraph-md paragraph-regular text-gray-500">' . sprintf('(%s adet)', $qty_display) . '</div>', $item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo '</div>';
		if ($show_purchase_note && $purchase_note) :
			echo '<div class="woocommerce-table__product-purchase-note product-purchase-note paragraph-sm paragraph-medium text-primary-600">' . esc_html(do_shortcode(wp_kses_post($purchase_note))) . '</div>';
		endif;
		echo '</div>';


		do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false);

		wc_display_item_meta($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false);
		?>
	</div>

	<div class="woocommerce-table__product-total product-total paragraph-md paragraph-bold text-gray-900">
		<?php echo $order->get_formatted_line_subtotal($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
		?>
	</div>

</div>