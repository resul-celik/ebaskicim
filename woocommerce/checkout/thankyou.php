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
//$order = wc_get_order(121);
?>

<div class="woocommerce-order w-full max-w-[540px] flex flex-col items-start justify-start gap-10 px-20 py-60">

	<?php
	if ($order) :

		do_action('woocommerce_before_thankyou', $order->get_id());
	?>

		<?php if ($order->has_status('failed')) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed paragraph-mg paragraph-regular text-error-500 text-center pb-15">
				Bankanız, işleminizi reddettiği için siparişiniz maalesef işleme alınamadı. Lütfen bilgileri kontrol edip tekrar satın almayı deneyin.
			</p>
			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions w-full flex flex-col gap-5 items-center pb-30">

				<?php
				$buttonArgs = [
					'text'			=> "Tekrar Satın Almayı dene",
					'url' 			=> esc_url($order->get_checkout_payment_url()),
					'leadingIcon' 	=> "credit-card",
				];
				echo get_button($buttonArgs);
				?>
				<?php if (is_user_logged_in()) : ?>
					<?php
					$buttonArgs = [
						'text' 			=> "Hesabım'a Git",
						'url' 			=> esc_url(wc_get_page_permalink('myaccount')),
						'hierarchy' 	=> 'secondary',
						'trailingIcon' 	=> "arrow-right",
					];
					echo get_button($buttonArgs);
					?>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template('checkout/order-received.php', array('order' => $order)); ?>

			<div class="card-container card-container-secondary w-full">
				<h2 class="card-title"><?php esc_html_e('Order details', 'woocommerce'); ?></h2>
				<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details w-full flex flex-col gap-20">

					<li class="woocommerce-order-overview__order order w-full flex fleex-row items-center justify-between">
						<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Order number:', 'woocommerce'); ?></div>
						<strong class="paragraph-md paragraph-bold text-gray-900"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																					?></strong>
					</li>

					<li class="woocommerce-order-overview__date date w-full flex fleex-row items-center justify-between">
						<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Date:', 'woocommerce'); ?></div>
						<strong class="paragraph-md paragraph-bold text-gray-900"><?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																					?></strong>
					</li>

					<?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
						<li class="woocommerce-order-overview__email email w-full flex fleex-row items-center justify-between">
							<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Email:', 'woocommerce'); ?></div>
							<strong class="paragraph-md paragraph-bold text-gray-900"><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																						?></strong>
						</li>
					<?php endif; ?>

					<?php if ($order->get_payment_method_title()) : ?>
						<li class="woocommerce-order-overview__payment-method method w-full flex fleex-row items-center justify-between">
							<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Payment method:', 'woocommerce'); ?></div>
							<strong class="paragraph-md paragraph-bold text-gray-900"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
						</li>
					<?php endif; ?>
					<!-- Subtotal -->
					<div class="w-full border-b border-dashed border-gray-900"></div>
					<li class="woocommerce-order-overview__total total w-full flex fleex-row items-center justify-between">
						<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Subtotal:', 'woocommerce'); ?></div>
						<strong class="paragraph-md paragraph-bold text-gray-900"><?php echo $order->get_subtotal_to_display(); ?></strong>
					</li>
					<li class="woocommerce-order-overview__total total w-full flex fleex-row items-center justify-between">
						<div class="paragraph-md paragraph-regular text-gray-900"><?php esc_html_e('Total:', 'woocommerce'); ?></div>
						<strong class="paragraph-md paragraph-bold text-gray-900"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																					?></strong>
					</li>
				</ul>
			</div>

		<?php endif; ?>
		<div class="card-container card-container-primary w-full">
			<h2 class="card-title"><?php esc_html_e('Product Details', 'woocommerce'); ?></h2>
			<div class="flex flex-col gap-15">
				<?php
				$order_items = $order->get_items();
				foreach ($order_items as $item_id => $item) {
					/** @disregard P1013 ignore get_product error */
					$product = $item->get_product();
				?>
					<div class="w-full flex flex-row items-center justify-start gap-15">
						<a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="relative">
							<?php echo ebs_get_badge($item->get_quantity() . 'x', ["classes" => "absolute -top-5 -right-5"]); ?>
							<figure class="w-60 h-60 rounded-[10px] overflow-hidden grow-0 shrink-0 border border-gray-400">
								<?php echo $product->get_image("product_thubmbnail_medium", array('class' => 'w-full h-full object-cover')); ?>
							</figure>
						</a>
						<div class="flex flex-col gap-5">
							<a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="paragraph-md paragraph-regular text-gray-900"><?php echo $product->get_name(); ?></a>
							<p class="paragraph-md paragraph-bold text-gray-900"><?php echo $product->get_price_html(); ?></p>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>

		<div class="card-container card-container-secondary w-full">
			<h2 class="card-title"><?php esc_html_e('Billing Address', 'woocommerce'); ?></h2>
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