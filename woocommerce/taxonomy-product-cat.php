<?php

/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header('shop');
get_template_part('components/header');

$category = get_queried_object();
$category_slug = $category->slug;
$category_url = get_term_link($category);
$currentCat = get_queried_object();

$filters = ebs_get_category_filters($category_slug);

print_r($filters);



$paged = (get_query_var('paged', 1));
$tax_queries = array('relation' => 'AND');

foreach ($_GET as $key => $value) {
	if (strpos($key, 'pa_') === 0 && !empty($value)) {
		$terms = array_map('sanitize_text_field', explode(',', $value));
		$tax_queries[] = array(
			'taxonomy' => $key,
			'field' => 'slug',
			'terms' => $terms,
			'operator' => 'IN',
		);
	}
}

$args = array(
	'post_type' => 'product',
	'product_cat' => $category->slug,
	'orderby' => array(
		'menu_order' => 'ASC',
		'meta_value' => 'ASC',
		'date' => 'DESC',
	),
	'order' => 'DESC',
	'paged' => $paged,
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => '_stock_status',
			'value' => 'instock',
			'compare' => '=',
		),
		array(
			'key' => '_stock_status',
			'value' => 'outofstock',
			'compare' => '=',
		),
	),
	'tax_query' => $tax_queries,
);


$products = new WP_Query($args);


do_action('woocommerce_before_main_content'); ?>
<div class="results-page w-full max-w-[1920px] flex flex-col items-center justify-start px-20 pt-30 pb-100 gap-30 grow-1">
	<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
		<div class="w-full flex flex-row items-center justify-between">
			<div class="w-full flex flex-col gap-15">
				<h1 class="display-lg text-gray-900"><?php woocommerce_page_title(); ?></h1>
				<div class="w-full flex flex-row items-center justify-between"><? do_action('woocommerce_before_shop_loop'); ?></div>
			</div>
		</div>
	<?php endif; ?>
	<div class="w-full flex flex-row gap-30">
		<div class="w-444 flex flex-col grow-1 shrink-1 basis-1/4 gap-30 px-20 py-20 shadow-xs rounded-[15px] shrink-0">
			<div class="w-full flex flex-col gap-10">
				<h2 class="paragraph-lg paragraph-bold text-gray-900">Kelimeye göre filtrele</h2>
				<?php echo do_shortcode('[woocommerce_product_search]'); ?>
			</div>
			<div class="w-full flex flex-col gap-10">
				<h2 class="paragraph-lg paragraph-bold text-gray-900">Kategoriler</h2>
				<div class="w-full flex flex-row gap-5 flex-wrap">
					<?php

					$terms = get_terms(array(
						'taxonomy' => 'product_cat',
						'hide_empty' => false,
					));

					$currentCat = get_queried_object();

					foreach ($terms as $term) {
						$term_link = get_term_link($term);
						echo '<a href="' . $term_link . '" class="flex flex-row items-center justify-center px-15 py-5 ' . ($currentCat->slug === $term->slug ? 'bg-primary-400' : 'bg-gray-100 hover:bg-gray-200') . ' rounded-full paragraph-sm">' . $term->name . '</a>';
					}

					?>
				</div>
			</div>
			<?php if ($filters["taxonomies"]) : ?>
				<div class="w-full flex flex-col gap-10">
					<h2 class="paragraph-lg paragraph-bold text-gray-900">Özellikler</h2>
					<div class="flex flex-col">
						<?php foreach ($filters["taxonomies"] as $attribute) : ?>
							<?php
							$attributeName = $attribute["name"];
							$attributeSlug = $attribute["slug"];
							$getAttribute = @$_GET[$attributeSlug];
							?>
							<details class="group/filter-accordion border-b-1 border-gray-200 last:border-none" <?php echo $getAttribute ? "open" : "" ?>>
								<summary class="flex flex-row items-center justify-between py-15 paragraph-md paragraph-medium text-gray-900 select-none cursor-pointer">
									<?php echo esc_html($attributeName); ?>
									<i class="icon icon-chevron-down"></i>
								</summary>
								<?php if ($attribute["terms"]) : ?>
									<div class="w-full flex flex-row gap-5 flex-wrap pb-10">
										<?php
										$checkAttribute =  $getAttribute ? 'bg-gray-100 hover:bg-gray-200' : 'bg-primary-400';
										echo sprintf(
											'<a href="%s" class="flex flex-row items-center justify-center px-15 py-5 rounded-full paragraph-sm %s">%s</a>',
											$category_url,
											$checkAttribute,
											"Tümü"
										);
										?>
										<?php foreach ($attribute["terms"] as $term) : ?>
											<?php
											$filter_url = add_query_arg($attributeSlug, $term["slug"], $category_url);
											$filter_active = isset($getAttribute) && $getAttribute === $term["slug"];
											$termClass = $filter_active ? 'bg-primary-400' : 'bg-gray-100 hover:bg-gray-200';

											echo sprintf(
												'<a href="%s" class="flex flex-row items-center justify-center px-15 py-5 rounded-full paragraph-sm %s">%s</a>',
												$filter_url,
												$termClass,
												$term["name"]
											);
											?>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</details>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="flex flex-row items-start justify-start grow-1 shrink-1 basis-3/4 gap-y-20 flex-wrap">
			<?php

			if ($products->have_posts()) :

				if (wc_get_loop_prop('total')) :
					while ($products->have_posts()) : $products->the_post();

						do_action('woocommerce_shop_loop');

						wc_get_template_part('content', 'product');

					endwhile;
					wp_reset_postdata();
				endif;
				if ($products->max_num_pages > 1) :
					do_action('woocommerce_after_shop_loop');
				endif;
			else:
				do_action('woocommerce_no_products_found');
			endif;
			do_action('woocommerce_after_main_content');

			?>
		</div>
	</div>
</div>
<?php get_template_part('components/footer');
get_footer('shop');
