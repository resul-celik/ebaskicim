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

<div class="w-700 flex flex-col grow-0 shrink-0 gap-12">
	<div class="photo-swiper w-full aspect-4/3 overflow-hidden rounded-[15px] relative">
		<?php echo ebs_project_tags(); ?>
		<div class="photo-swiper-wrapper w-full aspect-4/3 relative box-content flex flex-row justify-start items-center">
			<?php
			// Display product thumbnail
			echo '<figure class="photo-swiper-item product-thumbnail shrink-0">';
			echo woocommerce_get_product_thumbnail('woocommerce_single');
			echo '</figure>';

			if ($attachment_ids && is_array($attachment_ids)) {
				foreach ($attachment_ids as $attachment_id) {
					$image_url = wp_get_attachment_url($attachment_id);
					echo '<figure class="photo-swiper-item product-image shrink-0">';
					echo '<img src="' . esc_url($image_url) . '" alt="">';
					echo '</figure>';
				}
			}

			?>
		</div>
	</div>
	<div thumbsSlider="" class="swiper-thumbs w-full h-60">
		<div class="thumb-wrapper w-full flex flex-row justify-start items-center">
			<?php
			if ($attachment_ids && is_array($attachment_ids)) {
				foreach ($attachment_ids as $attachment_id) {
					$image_url = wp_get_attachment_url($attachment_id);
					echo '<div class="photo-swiper-thumb-item !w-60 !h-60 shrink-0 grow-0 rounded-[15px] overflow-hidden">';
					echo '<img src="' . esc_url($image_url) . '" alt="" class="w-full h-full object-cover">';
					echo '</div>';
				}
			}
			?>
		</div>
	</div>
</div>