<?php

defined('ABSPATH') || exit;

global $product;
$button = new Button;

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

<section id="product-<?php the_ID(); ?>" <?php wc_product_class('w-full max-w-[1350px] flex flex-row gap-72 px-20 py-60 gap-30', $product); ?>>

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
		<?php woocommerce_template_single_excerpt(); ?>
		<div class="flex flex-col gap-18">
			<?php woocommerce_template_single_price(); ?>
			<?php woocommerce_template_single_add_to_cart(); ?>
		</div>
		<?php
		$attributes = $product->get_attributes();
		?>
		<?php if ($attributes || get_the_content()) : ?>
			<div class="accordions">
				<?php
				if ($attributes) : ?>
					<div class="accordion" onclick="toggleAccordion(this)">
						<div class="accordion-title">
							<?php _e('Features', 'junobjects') ?>
							<div class="icon icon-chevron-down"></div>
						</div>
						<ul class="accordion-list" onclick="preventAccordionToggle(event)">
							<?php foreach ($attributes as $attribute) : ?>
								<li class="accordion-list-item">
									<?php
									switch ($attribute->get_name()) {
										case 'Color':
											echo '<div class="icon icon-palette"></div>';
											break;
										case 'pa_size':
											echo '<div class="icon icon-ruler-combined"></div>';
											break;
										case 'Material':
											echo '<div class="icon icon-scissors"></div>';
											break;
										default:
											echo '<div class="icon icon-layers"></div>';
											break;
									}
									?>
									<strong><?php _e(wc_attribute_label($attribute->get_name()), 'junobjects'); ?>:</strong>
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
					</div>
				<?php endif; ?>
				<?php if (get_the_content()) : ?>
					<div class="accordion" onclick="toggleAccordion(this)">
						<div class="accordion-title">
							<?php _e('Details', 'junobjects') ?>
							<div class="icon icon-chevron-down"></div>
						</div>
						<div class="accordion-content">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
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
<?php echo get_section('Bunlar da ilginizi çekebilir', null, 1, function () {
	$id = get_the_ID();
	$related_products = wc_get_related_products($id, 4);
	$return = "";
	$return .= '<div class="swiper w-full"><div class="swiper-wrapper w-full relative box-content flex flex-row justify-start items-center">';
	foreach ($related_products as $related_product) {
		$product = wc_get_product($related_product);
		ob_start();
		wc_get_template_part('content', 'product');
		$return .= ob_get_clean();
	}
	$return .= '</div></div>';
	wp_reset_postdata();

	return $return;
}); ?>
<?php do_action('woocommerce_after_single_product'); ?>