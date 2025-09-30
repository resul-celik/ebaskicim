<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined('ABSPATH') || exit;

get_template_part("components/header");

do_action('woocommerce_before_cart'); ?>

<section class="w-full max-w-[1920px] flex items-start justify-start flex-row gap-32 px-20 py-60">
	<form class="woocommerce-cart-form flex flex-col gap-30 grow-1 shrink-1 shadow-xs rounded-[15px]" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
		<?php do_action('woocommerce_before_cart_table'); ?>
		<h1 class="paragraph-2xl paragraph-medium text-gray-900 pt-25 pl-25">Sepet</h1>
		<div class="w-full flex flex-col gap-30 px-25 pb-25 grow-1">
			<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-full border-separate border-spacing-x-0 border-spacing-y-5" cellspacing="0">
				<thead>
					<tr>
						<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e('Remove item', 'woocommerce'); ?></span></th>
						<th class="product-thumbnail w-50 text-left paragraph-sm paragraph-regular text-gray-600"><span class="screen-reader-text block w-50"><?php esc_html_e('Thumbnail image', 'woocommerce'); ?></span></th>
						<th scope="col" class="product-name text-left paragraph-sm paragraph-regular text-gray-600"><?php esc_html_e('Product', 'woocommerce'); ?></th>
						<th scope="col" class="product-price text-left paragraph-sm paragraph-regular text-gray-600"><?php esc_html_e('Price', 'woocommerce'); ?></th>
						<th scope="col" class="product-quantity text-left paragraph-sm paragraph-regular text-gray-600"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
						<th scope="col" class="product-subtotal text-left paragraph-sm paragraph-regular text-gray-600"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php do_action('woocommerce_before_cart_contents'); ?>

					<?php
					foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
						$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
						/**
						 * Filter the product name.
						 *
						 * @since 2.1.0
						 * @param string $product_name Name of the product in the cart.
						 * @param array $cart_item The product in the cart.
						 * @param string $cart_item_key Key for the product in the cart.
						 */
						$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

						if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
							$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
					?>
							<tr class="woocommerce-cart-form__cart-item bg-gray-50 <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

								<td class="product-remove w-20 py-10 px-15 rounded-tl-[10px] rounded-bl-[10px]">
									<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a role="button" href="%s" class="remove w-32 h-32 flex items-center justify-center text-error-500 rounded-full hover:bg-error-100 grow-0 shrink-0" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon !w-20 !h-20 icon-delete before:!text-[20px]"></i></a>',
											esc_url(wc_get_cart_remove_url($cart_item_key)),
											/* translators: %s is the product name */
											esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
											esc_attr($product_id),
											esc_attr($_product->get_sku())
										),
										$cart_item_key
									);
									?>
								</td>

								<td class="product-thumbnail py-10 pr-15 w-50">
									<?php
									/**
									 * Filter the product thumbnail displayed in the WooCommerce cart.
									 *
									 * This filter allows developers to customize the HTML output of the product
									 * thumbnail. It passes the product image along with cart item data
									 * for potential modifications before being displayed in the cart.
									 *
									 * @param string $thumbnail     The HTML for the product image.
									 * @param array  $cart_item     The cart item data.
									 * @param string $cart_item_key Unique key for the cart item.
									 *
									 * @since 2.1.0
									 */
									$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image("product_thubmbnail_medium"), $cart_item, $cart_item_key);

									if (! $product_permalink) {
										echo $thumbnail; // PHPCS: XSS ok.
									} else {
										printf('<a href="%s" class="block w-50 h-50 rounded-[5px] overflow-hidden">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
									}
									?>
								</td>

								<td scope="row" role="rowheader" class="product-name py-10" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
									<?php
									if (! $product_permalink) {
										echo wp_kses_post($product_name . '&nbsp;');
									} else {
										/**
										 * This filter is documented above.
										 *
										 * @since 2.1.0
										 */
										echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="hover:underline">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
									}

									do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

									// Meta data.
									echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

									// Backorder notification.
									if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
										echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
									}
									?>
								</td>

								<td class="product-price py-10 paragraph-md paragraph-bold text-gray-900" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
									<?php
									echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
									?>
								</td>

								<td class="product-quantity py-10" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
									<?php
									if ($_product->is_sold_individually()) {
										$min_quantity = 1;
										$max_quantity = 1;
									} else {
										$min_quantity = 0;
										$max_quantity = $_product->get_max_purchase_quantity();
									}

									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $max_quantity,
											'min_value'    => $min_quantity,
											'product_name' => $product_name,
										),
										$_product,
										false
									);

									echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
									?>
								</td>

								<td class="product-subtotal py-10 rounded-tr-[10px] rounded-br-[10px] paragraph-md paragraph-bold text-gray-900" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
									<?php
									echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
									?>
								</td>
							</tr>
					<?php
						}
					}
					?>

					<?php do_action('woocommerce_cart_contents'); ?>

					<?php do_action('woocommerce_after_cart_contents'); ?>
				</tbody>
			</table>
			<div class="actions w-full flex flex-row items-center justify-between">

				<?php if (wc_coupons_enabled()) { ?>
					<div class="coupon flex flex-row items-center justify-start gap-10">
						<label for="coupon_code" class="screen-reader-text">
							<?php esc_html_e('Coupon:', 'woocommerce'); ?>
						</label>
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
						<?
						$buttonArgs = [
							'text' => esc_attr__('Apply coupon', 'woocommerce'),
							'classes' => "grow-0 shrink-0",
							'name' => 'apply_coupon',
							'value' => esc_attr__('Apply coupon', 'woocommerce'),
							'type' => 'submit',
							'hierarchy' => 'primary',
							'leadingIcon' => "gift"
						];
						echo get_button($buttonArgs);
						?>
						<?php do_action('woocommerce_cart_coupon'); ?>
					</div>
				<?php } ?>
				<?
				$updateButton = [
					'text' => esc_attr__('Update cart', 'woocommerce'),
					'classes' => "grow-0 shrink-0",
					'name' => 'update_cart',
					'value' => esc_attr__('Update cart', 'woocommerce'),
					'type' => 'submit',
					'hierarchy' => 'tertiary',
					'trailingIcon' => "refresh"
				];
				echo get_button($updateButton);
				?>

				<?php do_action('woocommerce_cart_actions'); ?>

				<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
			</div>
		</div>
		<?php do_action('woocommerce_after_cart_table'); ?>

	</form>

	<?php do_action('woocommerce_before_cart_collaterals'); ?>

	<div class="cart-collaterals grow-0 shrink-1 basis-[450px]">
		<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action('woocommerce_cart_collaterals');
		?>
	</div>
</section>

<?php do_action('woocommerce_after_cart'); ?>