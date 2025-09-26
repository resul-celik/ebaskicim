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
//$category_slug = $category->slug;

// category url
$category_url = get_term_link($category);
$filterSize = isset($_GET['size']) ? $_GET['size'] : '';
$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : '';

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
	'post_type' => 'product',
	'product_cat' => $category->slug,
	'orderby' => array(
		'menu_order' => 'ASC',
		'meta_value' => 'ASC', // Order by stock status first
		'date' => 'DESC' // Then order by date
	),
	'order' => 'DESC',
	'paged' => $paged,
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => '_stock_status',
			'value' => 'instock',
			'compare' => '='
		),
		array(
			'key' => '_stock_status',
			'value' => 'outofstock',
			'compare' => '='
		)
	),
	/* 'tax_query' => array(
				array(
					'taxonomy' => 'pa_olcu',
					'field' => 'slug',
					'terms' => $filterSize,
					'operator' => $filterSize ? 'IN' : 'NOT IN',
				),
			), */
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

	<?php

	// all product size attribute values
	/* $size_terms = get_terms(array(
		'taxonomy' => 'pa_olcu',
		'hide_empty' => false,
	));

	$filters_output = null;

	foreach ($size_terms as $size_term) {
		$size = $size_term->name;
		$size_slug = $size_term->slug;
		$size_link = get_term_link($size_term);
		$size_active = isset($_GET['size']) && $_GET['size'] === $size_slug;
		$size_class = $size_active ? 'active' : '';

		$current_url = add_query_arg(null, null);
		$filtered_url = add_query_arg('size', $size_slug, $current_url);
		$args = array(
			'post_type' => 'product',
			'product_cat' => $category->slug,
			'posts_per_page' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'pa_size',
					'field' => 'slug',
					'terms' => $size_slug,
				),
			),
		);

		$query = new WP_Query($args);

		if ($query->have_posts()) {

			$filters_output .= "<a href='$filtered_url' class='tag " . ($filterSize === $size_slug ? 'tag-active' : '') . " $size_class' data-size='$size_slug'>$size</a>";
		}
		wp_reset_postdata();
	}

	if (isset($filters_output)) {
		$allPosts = "<a href='" . $category_url . "' class='tag " . ($filterSize === '' ? 'tag-active' : '') . "'>" . __('All', 'junobjects') . "</a>";
		echo '<div class="product-filters">' . $allPosts . $filters_output . '</div>';
	} */


	?>
	<div class="w-full flex flex-row gap-30">
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
<?php get_template_part('components/footer');
get_footer('shop');
