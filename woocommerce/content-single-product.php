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

<section id="product-<?php the_ID(); ?>" <?php wc_product_class('w-full max-w-[1260px] flex flex-col md:flex-row gap-40 px-20 py-60 gap-30', $product); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action('woocommerce_before_single_product_summary');
	?>

	<div class="flex flex-col gap-30 flex-1">
		<h1 class="text-lg font-medium text-gray-900"><?php the_title(); ?></h1>
		<?php if ($product->is_type('variable')) : ?>
			<div class="variation-price-display single-product-price"></div>
		<?php else : ?>
			<?php woocommerce_template_single_price(); ?>
		<?php endif; ?>
		<div class="w-full h-[1px] bg-gray-200"></div>
		<?php do_action('woocommerce_template_single_rating'); ?>
		<?php woocommerce_template_single_excerpt(); ?>
		<details class="accordion w-full bg-gray-100 rounded-[10px]" open>
			<summary class="w-full h-50 flex flex-row justify-between items-center px-20 cursor-pointer select-none">
				<div class="paragraph-mg text-gray-900">Tasarımını Yükle (İsteğe Bağlı)</div>
				<i class="icon icon-plus"></i>
				<i class="icon icon-minus"></i>
			</summary>
			<div class="w-full flex flex-col  gap-15 px-20 pb-20">
				<div class="paragraph-sm text-gray-700">Kendi tasarımını yükleyerek ürünü kişiselleştirebilirsin.</div>
				<div class="design-dropzone" data-nonce="<?php echo wp_create_nonce('ebs_upload_design'); ?>">
					<div class="design-dropzone__area">
						<div class="w-full flex flex-col gap-3">
							<p class="paragraph-sm text-gray-600">Dosyayı buraya sürükle / bırak</p>
							<p class="paragraph-xs text-gray-500">Tasarımlar zip dosyası içinde yüklenmelidir.</p>
						</div>
						<button type="button" class="button secondary-button medium-button design-select-btn">Dosya Seç</button>
						<input type="file" class="design-file-input" accept=".jpg,.jpeg,.png,.pdf,.psd,.zip" />
					</div>
					<div class="design-upload-progress" hidden>
						<p class="paragraph-xs text-gray-600 design-progress-filename"></p>
						<div class="design-progress-track">
							<div class="design-progress-bar"></div>
						</div>
					</div>
					<div class="design-file-info" hidden>
						<i class="icon icon-attach-file text-primary-500"></i>
						<span class="design-file-name paragraph-sm text-gray-900"></span>
						<button type="button" class="design-remove-btn" aria-label="Dosyayı kaldır">&times;</button>
					</div>
				</div>
				<div class="paragraph-xs text-gray-600">Profesyonel grafik tasarım ekibimiz siparişinizden sonra sizinle irtibata geçecektir.</div>
			</div>
		</details>
		<div class="flex flex-col gap-18">
			<?php woocommerce_template_single_add_to_cart(); ?>
		</div>
		<?php
		// Exclude variation attributes — shown as chips in the add-to-cart form
		$all_attributes     = $product->get_attributes();
		$display_attributes = array_filter($all_attributes, fn($attr) => !$attr->get_variation());
		?>
		<?php if ($display_attributes || get_the_content()) : ?>
			<div class="w-full h-[1px] bg-gray-200"></div>
			<div class="w-full flex flex-col gap-4">
				<?php if ($display_attributes) : ?>
					<details class="accordion w-full bg-gray-100 rounded-[10px] gap-10">
						<summary class="w-full h-50 flex flex-row justify-between items-center px-20 cursor-pointer select-none">
							<div class="paragraph-mg text-gray-900">Özellikler</div>
							<i class="icon icon-plus"></i>
							<i class="icon icon-minus"></i>
						</summary>
						<ul class="w-full flex flex-col px-20 pb-15 m-0 p-0">
							<?php foreach ($display_attributes as $attribute) : ?>
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
					<details class="accordion w-full bg-gray-100 rounded-[10px] gap-10">
						<summary class="w-full h-50 flex flex-row justify-between items-center px-20 cursor-pointer select-none">
							<div class="paragraph-mg text-gray-900">Ürün Açıklaması</div>
							<i class="icon icon-plus"></i>
							<i class="icon icon-minus"></i>
						</summary>
						<div class="w-full flex flex-col px-20 pb-15 m-0 p-0 paragraph-sm text-gray-900">
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