<?php

/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (! function_exists('wc_get_gallery_image_html')) {
	return;
}
global $product;
$product_video = get_post_meta($product->get_id(), 'jun_product_video', true);
$attachment_ids = $product->get_gallery_image_ids();

/* <?php if ($product->is_in_stock()) : ?>
	<?php
	$post_date = get_the_date('U', $product->get_id());
	$current_date = current_time('timestamp');
	$date_diff = $current_date - $post_date;

	if ($date_diff < DAY_IN_SECONDS) {
	?>
		<div class="product-tag new-tag">
			<div class="icon icon-fire"></div>
			<?php _e('New', 'junobjects'); ?>
		</div>
	<?php
	}
	?>

	<?php
	$sale_price = $product->get_sale_price();
	$regular_price = $product->get_regular_price();

	if ($sale_price && $regular_price) {
		echo '<div class="product-tag discount-tag">';
		$discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
		echo '<div class="icon icon-smile"></div>' . sprintf(__('%d%% off', 'junobjects'), $discount_percentage);
		echo '</div>';
	}
	?>
	<?php if ($product->is_featured()) : ?>
		<div class="product-tag best-tag">
			<div class="icon icon-diamond"></div>
			<?php _e('Best seller', 'junobjects'); ?>
		</div>
	<?php endif; ?>
	<?php $stock = $product->get_stock_quantity(); ?>
	<?php if ($stock > 0) : ?>
		<div class="product-tag stock-tag">
			<?php echo sprintf(__('%d in stock', 'junobjects'), $stock); ?>
		</div>
	<?php endif; ?>
<?php else : ?>
	<div class="product-tag sold-out-tag">
		<div class="icon icon-sad"></div>
		<?php _e('Sold out', 'junobjects'); ?>
	</div>
<?php endif; ?> */

function ebs_project_tags()
{
	global $product;

?>
	<div class="absolute top-20 left-20 flex flex-col gap-[3px] justify-start items-start z-10">
		<?php if ($product->is_in_stock()) {
			// New tag
			$post_date = get_the_date('U', $product->get_id());
			$current_date = current_time('timestamp');
			$date_diff = $current_date - $post_date;

			if ($date_diff < DAY_IN_SECONDS) {
				echo product_status_tag("Yeni", "bg-black text-white");
			}

			// Discount tag
			$sale_price = $product->get_sale_price();
			$regular_price = $product->get_regular_price();

			if ($sale_price && $regular_price) {
				$discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
				echo product_status_tag("%$discount_percentage indirim", "bg-primary-400 text-gray-900");
			}

			// Featured tag
			if ($product->is_featured()) {
				echo product_status_tag("Çok Satan", "bg-gray-700 text-white");
			}
		} else {
			echo product_status_tag("Tükendi", "bg-red-500 text-white");
		} ?>
	</div>
<?php
}
?>

<div class="w-700 grow-0 shrink-0">
	<?php

	// Display product thumbnail
	echo '<figure class="product-thumbnail w-full aspect-4/3 flex items-center justify-center relative overflow-hidden rounded-[15px]">';
	echo ebs_project_tags();
	echo woocommerce_get_product_thumbnail('woocommerce_single');
	echo '</figure>';

	if ($attachment_ids && is_array($attachment_ids)) {
		foreach ($attachment_ids as $attachment_id) {
			$image_url = wp_get_attachment_url($attachment_id);
			echo '<figure class="product-image">';
			echo '<img src="' . esc_url($image_url) . '" alt="">';
			echo '</figure>';
		}
	}

	?>
</div>