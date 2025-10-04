<?php

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<section id="product-<?php the_ID(); ?>" <?php wc_product_class('w-full max-w-[1350px] flex flex-col md:flex-row gap-72 px-20 py-60 gap-30', $product); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action('woocommerce_before_single_product_summary');
	?>

	<div class="flex flex-col gap-38 flex-1">
		<h1 class="display-sm text-gray-900"><?php the_title(); ?></h1>
		<? do_action('woocommerce_template_single_rating'); ?>
		<?php woocommerce_template_single_excerpt(); ?>
		<div class="flex flex-col gap-18">
			<?php woocommerce_template_single_price(); ?>
			<?php woocommerce_template_single_add_to_cart(); ?>
		</div>
		<?php
		$attributes = $product->get_attributes();
		?>
		<?php if ($attributes || get_the_content()) : ?>
			<div class="w-full h-[1px] bg-gray-200"></div>
			<div class="w-full flex flex-col gap-4">
				<?php
				if ($attributes) : ?>
					<details class="accordion w-full bg-gray-100 rounded-[25px] gap-10">
						<summary class="w-full h-50 flex flex-row justify-between items-center px-24 cursor-pointer select-none">
							<div class="paragraph-mg text-gray-900">Özellikler</div>
							<i class="icon icon-plus"></i>
							<i class="icon icon-minus"></i>
						</summary>
						<ul class="w-full flex flex-col px-24 pb-15 m-0 p-0">
							<?php foreach ($attributes as $attribute) : ?>
								<li class="w-full flex flex-row justify-start items-center m-0 p-0 py-9 gap-10 border-b border-gray-300 last:border-0 paragraph-sm">
									<div class="feature-icon w-20 h-20 flex flex-row justify-center items-center text-primary-500">
										<?php
										switch ($attribute->get_name()) {
											case 'Color':
												echo '<div class="icon icon-colors"></div>';
												break;
											case 'pa_olcu':
												echo '<div class="icon icon-ruler-triangle"></div>';
												break;
											case 'Material':
												echo '<div class="icon icon-scissors"></div>';
												break;
											default:
												echo '<div class="icon icon-layers"></div>';
												break;
										}
										?>
									</div>
									<span><?php echo wc_attribute_label($attribute->get_name()); ?>:</span>
									<?php
									$options = $attribute->get_options();
									$terms = array_map(function ($option) use ($attribute) {
										$term = get_term_by('id', $option, $attribute->get_name());
										return $term ? $term->name : $option;
									}, $options);
									echo implode(', ', $terms);
									?>
								</li>
							<?php endforeach; ?>
						</ul>
					</details>
				<?php endif; ?>
				<?php if (get_the_content()) : ?>
					<details class="accordion w-full bg-gray-100 rounded-[25px] gap-10">
						<summary class="w-full h-50 flex flex-row justify-between items-center px-24 cursor-pointer select-none">
							<div class="paragraph-mg text-gray-900">Detaylar</div>
							<i class="icon icon-plus"></i>
							<i class="icon icon-minus"></i>
						</summary>
						<div class="w-full flex flex-col px-24 pb-15 m-0 p-0 paragraph-sm text-gray-900">
							<?php the_content(); ?>
						</div>
					</details>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php woocommerce_template_single_meta(); ?>

	</div>

	<?php
	/**
	 * Hook: woocommerce_single_product_summary.
	 *
	 * @hooked woocommerce_template_single_title - 5
	 * @hooked woocommerce_template_single_rating - 10
	 * @hooked woocommerce_template_single_price - 10
	 * @hooked woocommerce_template_single_excerpt - 20
	 * @hooked woocommerce_template_single_add_to_cart - 30
	 * @hooked woocommerce_template_single_meta - 40
	 * @hooked woocommerce_template_single_sharing - 50
	 * @hooked WC_Structured_Data::generate_product_data() - 60
	 */
	//do_action( 'woocommerce_single_product_summary' );


	?>


</section>
<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
woocommerce_output_related_products();
?>
<?php do_action('woocommerce_after_single_product'); ?>