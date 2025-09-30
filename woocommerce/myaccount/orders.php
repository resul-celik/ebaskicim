<?php

/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders); ?>

<? if ($has_orders) { ?>
	<h1 class="paragraph-2xl paragraph-medium text-gray-900 pt-25 pl-25">Siparişler</h1>
	<div class="w-full flex flex-row flex-wrap md:gap-y-10 md:pl-25 md:pr-15 pb-25">
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
				<div class="account-order-container w-full md:w-1/2 pr-10 flex flex-col grow-0 shrink-1 md:shrink-0">
					<div class="account-order w-full flex flex-col items-start justify-start gap-15 p-15 md:p-20 rounded-0 md:rounded-[15px]">
						<div class="w-full flex flex-row items-center justify-between">
							<div class="flex flex-col gap-1">
								<div class="flex flex-row gap-2">
									<p class="paragraph-md paragraph-regular text-gray-900">Sipariş</p>
									<p class="paragraph-md paragraph-bold text-gray-900">#<?php echo $order->get_order_number(); ?></p>
								</div>
								<div class="flex flex-row gap-2">
									<p class="paragraph-sm paragraph-regular text-gray-600"><?php echo wc_format_datetime($order->get_date_created()); ?></p>
									<p class="paragraph-sm paragraph-regular text-gray-600">—</p>
									<p class="paragraph-sm paragraph-regular text-gray-600"><?php echo sprintf(__('%d ürün'), count($items)); ?></p>
								</div>
							</div>
							<?
							$buttonArgs = array(
								"text" => "Detayları Gör",
								"url" => esc_url($order->get_view_order_url()),
								"hierarchy" => "link",
								"trailingIcon" => "arrow-right",
							);
							echo get_button($buttonArgs);
							?>
						</div>
						<div class="w-full h-[1px] border-b border-gray-300 border-dashed"></div>
						<a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="flex flex-row justify-start gap-3 items-center">
							<?php
							$i = 0;
							foreach ($items as $item) {
								$product = $item->get_product();
								$i++;

								if ($product && $i <= 5) {
									echo '<figure class="w-40 h-40 grow-0 shrink-0 rounded-[5px] overflow-hidden">';
									echo $product->get_image('product_thubmbnail_small', array('class' => 'w-full h-full object-cover'));
									echo '</figure>';
								}
							}

							if (count($items) > 5) {
								echo '<div class="w-40 h-40 flex flex-row items-center justify-center grow-0 shrink-0 rounded-[5px] bg-gray-100 paragraph-sm paragraph-regular text-gray-600 hover:bg-gray-200">+ ' . (count($items) - 5) . '</div>';
							}
							?>
						</a>
						<div class="w-full flex flex-row gap-10">
							<div class="w-full flex flex-col">
								<p class="paragraph-sm paragraph-regular text-gray-600">Fiyat:</p>
								<p class="paragraph-md paragraph-bold text-gray-900"><?php echo $order->get_formatted_order_total(); ?></p>
							</div>
							<div class="w-full flex flex-col">
								<p class="paragraph-sm paragraph-regular text-gray-600">Sipariş Durumu:</p>
								<p class="paragraph-md paragraph-medium text-gray-900">
									<?php if ($order->has_status('on-hold')) : ?>
										<span class="flex flex-row text-gray-600">Beklemede</span>
									<?php endif; ?>
									<?php if ($order->has_status('pending')) : ?>
										<span class="flex flex-row text-gray-600">Ödeme Bekleniyor</span>
									<?php endif; ?>
									<?php if ($order->has_status('failed')) : ?>
										<span class="flex flex-row text-error-500">Başarısız</span>
									<?php endif; ?>
									<?php if ($order->has_status('refunded')) : ?>
										<span class="flex flex-row text-primary-600">İade Edildi</span>
									<?php endif; ?>
									<?php if ($order->has_status('cancelled')) : ?>
										<span class="flex flex-row text-error-500">İptal Edildi</span>
									<?php endif; ?>
									<?php if ($order->has_status('completed')) : ?>
										<span class="flex flex-row text-success-600">Teslim Edildi</span>
									<?php endif; ?>
									<?php if ($order->has_status('processing')) : ?>
										<span class="flex flex-row text-gray-600">İşleniyor</span>
									<?php endif; ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php do_action('woocommerce_before_account_orders_pagination'); ?>

	<?php if (1 < $customer_orders->max_num_pages) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination w-full flex flex-row items-center justify-between px-25 pb-25">
			<?php if (1 !== $current_page) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous flex flex-row items center justify-center gap-10 paragraph-md paragraph-medium text-gray-900 button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>">
					<i class="icon icon-arrow-left"></i>
					<?php esc_html_e('Previous', 'woocommerce'); ?>
				</a>
			<?php endif; ?>
			<div></div>
			<?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next flex flex-row items center justify-center gap-10 paragraph-md paragraph-medium text-gray-900 button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>">
					<?php esc_html_e('Next', 'woocommerce'); ?>
					<i class="icon icon-arrow-right"></i></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

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
<?php } ?>



<?php do_action('woocommerce_after_account_orders', $has_orders); ?>