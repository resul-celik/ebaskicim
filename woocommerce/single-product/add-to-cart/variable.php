<?php

/**
 * Variable product add to cart - Chip style
 *
 * Overrides WooCommerce default dropdown with chip/button selectors.
 * Hidden <select> elements are kept so wc-add-to-cart-variation.js works normally.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined('ABSPATH') || exit;

global $product;

$attribute_keys  = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form');
?>

<form class="variations_form cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo absint($product->get_id()); ?>" data-product_variations="<?php echo $variations_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																																																																						?>">
	<?php do_action('woocommerce_before_variations_form'); ?>

	<?php if (empty($available_variations) && false !== $available_variations) : ?>
		<p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?></p>
	<?php else : ?>
		<div class="variations flex flex-col gap-20">
			<?php foreach ($attributes as $attribute_name => $options) :

				// Pre-collect chip data so we can determine $has_swatch before rendering the label row
				$is_taxonomy = taxonomy_exists($attribute_name);
				$has_swatch  = false;
				$chips       = [];

				foreach ($options as $option) {
					$label    = $option;
					$color    = '';
					$image_id = 0;

					if ($is_taxonomy) {
						$term  = get_term_by('slug', $option, $attribute_name);
						$label = $term ? $term->name : $option;
						if ($term) {
							$image_id = (int) get_term_meta($term->term_id, 'ebs_term_image', true);
							if (!$image_id) {
								$color = get_term_meta($term->term_id, 'ebs_term_color', true);
							}
						}
					}

					if ($image_id || $color) {
						$has_swatch = true;
					}

					$chips[] = compact('option', 'label', 'color', 'image_id');
				}
			?>
				<div class="variation-group flex flex-col gap-10">
					<div class="variation-label flex flex-row gap-5 text-gray-700">
						<div class="paragraph-medium"><?php echo wc_attribute_label($attribute_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
														?></div>
						<?php if ($has_swatch) : ?>
							<div class="chip-label-name paragraph-regular text-gray-600"></div>
						<?php endif; ?>
					</div>

					<div class="variation-chips flex flex-row flex-wrap gap-8" data-attribute="<?php echo esc_attr(sanitize_title($attribute_name)); ?>" <?php echo $has_swatch ? 'data-swatch="true"' : ''; ?>>
						<?php foreach ($chips as $chip) :
							$option   = $chip['option'];
							$label    = $chip['label'];
							$color    = $chip['color'];
							$image_id = $chip['image_id'];
						?>
							<?php if ($image_id) :
								$image_url = wp_get_attachment_image_url($image_id, [48, 48]);
							?>
								<button type="button" class="variation-chip variation-chip--image" data-value="<?php echo esc_attr($option); ?>" data-label="<?php echo esc_attr($label); ?>" title="<?php echo esc_attr($label); ?>">
									<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($label); ?>" />
								</button>
							<?php elseif ($color) : ?>
								<button type="button" class="variation-chip variation-chip--color" data-value="<?php echo esc_attr($option); ?>" data-label="<?php echo esc_attr($label); ?>" title="<?php echo esc_attr($label); ?>">
									<span class="variation-chip__swatch" style="background-color:<?php echo esc_attr($color); ?>;"></span>
								</button>
							<?php else : ?>
								<button type="button" class="variation-chip" data-value="<?php echo esc_attr($option); ?>" data-label="<?php echo esc_attr($label); ?>">
									<?php echo esc_html($label); ?>
								</button>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>

					<?php
					// Hidden select — required by wc-add-to-cart-variation.js to detect changes
					wc_dropdown_variation_attribute_options([
						'options'   => $options,
						'attribute' => $attribute_name,
						'product'   => $product,
						'class'     => 'variation-select',
					]);
					?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>

		<?php do_action('woocommerce_after_variations_table'); ?>

		<div class="single_variation_wrap">
			<?php
			do_action('woocommerce_before_single_variation');
			do_action('woocommerce_single_variation');
			do_action('woocommerce_after_single_variation');
			?>
		</div>
	<?php endif; ?>

	<?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>