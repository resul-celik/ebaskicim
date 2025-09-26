<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);

// listing orders
$customer_orders = wc_get_orders(
	apply_filters(
		'woocommerce_my_account_my_orders_query',
		array(
			'customer' => get_current_user_id(),
			'page'     => 1,
			'paginate' => true,
		)
	)
);

$has_orders = 0 < $customer_orders->total;

if ($has_orders) { ?>
	<h1 class="paragraph-2xl paragraph-medium text-gray-900">Siparişler</h1>
	<div class="w-full flex flex-row flex-wrap gap-y-30 -mr-15">
		<?php foreach ($customer_orders->orders as $customer_order) : ?>
			<?php
			$order = wc_get_order($customer_order);
			$items = $order->get_items();
			$show_order = false;
			foreach ($items as $item) {
				$product = $item->get_product();
				if ($product) {
					$show_order = true;
					break;
				}
			}
			if ($show_order) : ?>
				<div class="w-1/3 flex flex-col gap-20 grow-0 shrink-0 pr-15">
					<div class="w-full relative">
						<div class="order-images w-full aspect-4/3 overflow-hidden rounded-[10px]">
							<div class="order-images-wrapper w-full aspect-4/3 relative box-content flex flex-row justify-start items-center">
								<?php
								foreach ($items as $item) {
									$product = $item->get_product();
									if ($product) {
										echo '<figure class="order-image shrink-0">';
										echo $product->get_image('medium_large');
										echo '</figure>';
									}
								}
								?>
							</div>
						</div>
						<div class="absolute top-10 left-10 z-10 paragraph-xs paragraph-medium text-gray-900">
							<!-- order status -->
							<?php if ($order->has_status('on-hold')) : ?>
								<span class="flex flex-row gap-5 px-13 bg-gray-100 rounded-[10px]"><?php echo sprintf(__('%d items'), count($items)); ?> <?php _e('On Hold', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('pending')) : ?>
								<span class="flex flex-row gap-5 px-13 bg-gray-100 rounded-[10px]"><?php echo sprintf(__('%d items'), count($items)); ?> <?php _e('Pending', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('failed')) : ?>
								<span class="flex flex-row gap-5 px-13 bg-error-500 rounded-[10px] text-white"><?php echo sprintf(__('%d items'), count($items)); ?> <?php _e('Failed', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('refunded')) : ?>
								<span class="flex flex-row gap-5 px-13 bg-success-700 rounded-[10px] text-white"><?php echo sprintf(__('%d items'), count($items)); ?> <?php _e('Refunded', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('cancelled')) : ?>
								<span class="flex flex-row gap-5 px-13 bg-error-500 rounded-[10px] text-white"><?php echo sprintf(__('%d items'), count($items)); ?> <?php _e('Cancelled', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('completed')) : ?>
								<span class="flex flex-row gap-5 px-13 bg-success-700 rounded-[10px] text-white"><?php echo sprintf(__('%d items'), count($items)); ?> <?php _e('Completed', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('processing')) : ?>
								<span class="product-tag sold-out-tag"><?php echo sprintf(__('%d items'), count($items)); ?> <?php _e('Processing', 'junobjects') ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="flex flex-col">
						<div class="paragraph-md paragraph-medium text-gray-900">
							<?php echo $product->get_name(); ?>
						</div>
						<div class="paragraph-sm paragraph-regular text-gray-600">
							<?php echo wc_format_datetime($order->get_date_created()); ?>
						</div>
					</div>
					<div class="w-full flex flex-col gap-10">
						<div class="w-full flex flex-col">
							<p class="paragraph-xs paragraph-regular text-gray-900">Fiyat:</p>
							<p class="paragraph-2xl paragraph-bold text-gray-900"><?php echo $order->get_formatted_order_total(); ?></p>
						</div>
						<div class="w-full flex flex-col">
							<p class="paragraph-xs paragraph-regular text-gray-900">Sipariş numarası:</p>
							<div class="flex flex-row paragraph-2xl paragraph-bold text-gray-900">#<?php echo $order->get_order_number(); ?></div>
						</div>
					</div>
					<?
					$buttonArgs = array(
						"text" => "Detayları Gör",
						"url" => esc_url($order->get_view_order_url())
					);
					echo get_button($buttonArgs);
					?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php } else { ?>
	<h1 class="paragraph-2xl paragraph-medium text-gray-900">Siparişler</h1>
	<div class="w-full flex flex-col items-center">
		<div class="w-full max-w-350 flex flex-col items-center gap-20 py-60">
			<p>Henüz siparişiniz yok</p>
			<?
			$btnArgs = array(
				'text' => 'Sipariş ver',
				'hierarchy' => 'primary',
				'url' => esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))),
			);
			echo get_button($btnArgs);
			?>
		</div>
	</div>
<?php }
