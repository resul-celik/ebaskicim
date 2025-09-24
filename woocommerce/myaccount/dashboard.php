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
	<div class="jun-order-wrapper">
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
				<a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="product-item order-item">
					<figure class="product-image">
						<?php
						foreach ($items as $item) {
							$product = $item->get_product();
							if ($product) {
								echo $product->get_image('medium_large');
							}
						}
						?>
						<div class="product-tags">
							<!-- item count -->
							<span class="product-tag stock-tag"><?php echo sprintf(__('%d items'), count($items)); ?></span>
							<!-- order status -->
							<?php if ($order->has_status('on-hold')) : ?>
								<span class="product-tag sold-out-tag"><?php _e('On Hold', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('pending')) : ?>
								<span class="product-tag sold-out-tag"><?php _e('Pending', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('failed')) : ?>
								<span class="product-tag red-tag"><?php _e('Failed', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('refunded')) : ?>
								<span class="product-tag best-tag"><?php _e('Refunded', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('cancelled')) : ?>
								<span class="product-tag red-tag"><?php _e('Cancelled', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('completed')) : ?>
								<span class="product-tag discount-tag"><?php _e('Completed', 'junobjects') ?></span>
							<?php endif; ?>
							<?php if ($order->has_status('processing')) : ?>
								<span class="product-tag sold-out-tag"><?php _e('Processing', 'junobjects') ?></span>
							<?php endif; ?>
						</div>
					</figure>
					<div class="product-info">
						<div class="name-and-price">
							<div class="order-date">
								<?php echo wc_format_datetime($order->get_date_created()); ?>
							</div>
							<div class="content-product-title">
								<?php echo $product->get_name(); ?>
							</div>
							<span class="price content-price">
								<?php echo $order->get_formatted_order_total(); ?>
							</span>
						</div>
						<div class="order-number"># <?php echo $order->get_order_number(); ?></div>
					</div>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php } else { ?>
	<div class="empty-cart-image">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/juno-empty-cart.svg" alt="">
	</div>
	<?php wc_print_notice(esc_html__('No order has been made yet.', 'woocommerce') . ' <a class="woocommerce-Button wc-forward button primary-button button-sm blue-button" href="' . esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) . '">' . esc_html__('Browse products', 'woocommerce') . '</a>', 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment 
	?>
<?php }
