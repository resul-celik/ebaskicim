<?php

/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();
?>
<div class="order-info w-full flex flex-row items-start justify-between pt-25 px-25">
	<div class="w-full flex flex-col gap-8">
		<h1 class="paragraph-2xl paragraph-medium text-gray-900 order-number">
			<?
			$ordersPageUrl = get_page_link(get_option('woocommerce_myaccount_orders_url'));
			?>
			<a href="<?php echo $ordersPageUrl; ?>" class="hover:underline"><?php esc_html_e('Orders', 'woocommerce'); ?></a>
			<span class="text-gray-500">></span> #<?php echo $order->get_order_number(); ?>
		</h1>
		<div class="pragraph-md paragraph-regular text-gray-600 order-date">Sipariş tarihi: <? echo wc_format_datetime($order->get_date_created()); ?></div>
	</div>
	<div class="order-status flex flex-row gap-10 shrink-0">
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
			<span class="flex flex-row text-gray-600">İşleniyor...</span>
		<?php endif; ?>
	</div>
</div>
<?php if ($notes) : ?>
	<div class="w-full flex flex-col gap-8 px-25">
		<h2 class="paragraph-md paragraph-medium text-primary-600">Ebaskıcım bir not ekledi</h2>
		<ol class="woocommerce-OrderUpdates commentlist notes w-full flex flex-col gap-4 items-start">
			<?php foreach ($notes as $note) : ?>
				<li class="woocommerce-OrderUpdate comment note flex flex-col gap-4 px-15 py-10 bg-primary-100 rounded-tl-[5px] rounded-tr-[15px] rounded-br-[15px] rounded-bl-[15px]">
					<div class="woocommerce-OrderUpdate-description description paragraph-sm paragraph-regular text-gray-900">
						<?php echo wpautop(wptexturize($note->comment_content)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						?>
					</div>
					<p class="woocommerce-OrderUpdate-meta meta paragraph-xs paragraph-regular text-primary-700">
						<?php echo date_i18n(esc_html__('j F Y, H:i', 'woocommerce'), strtotime($note->comment_date)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						?>
					</p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
<?php endif; ?>
<?php do_action('woocommerce_view_order', $order_id); ?>