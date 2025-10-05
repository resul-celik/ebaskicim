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
$base_url = get_term_link($category);
$currentCat = get_queried_object();
$filters = ebs_get_category_filters($category_slug);
$paged = (get_query_var('paged', 1));
$tax_queries = array('relation' => 'AND');
$productOrder = @$_GET["order"] ? $_GET["order"] : "DESC";

$metaKey = [
	"best_seller" => [
		"orderby" => "DESC",
		"key"     => "total_sales"
	],
	"price_desc" => [
		"orderby" => "DESC",
		"key" 	  => "_price"
	],
	"price_asc"  => [
		"orderby" => "ASC",
		"key" 	  => "_price"
	],
	"default" => [
		"orderby" => "DESC",
		"key" 	  => ""
	],
	"ASC" => [ // ignore $productOrder
		"orderby" => "DESC",
		"key" 	  => ""
	]
];

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
		'meta_value_num' => $metaKey[@$_GET["order"] ? $_GET["order"] : "default"]["orderby"],
		'tax_query' => 'ASC',
		'meta_value' => 'ASC',
		'date' => $productOrder,
	),
	'paged' => $paged,
	'meta_key' => $metaKey[@$_GET["order"] ? $_GET["order"] : "default"]["key"],
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
<section class="results-page w-full max-w-[1920px] flex flex-col items-center justify-start px-20 pt-30 pb-100 gap-30 grow-1">
	<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
		<header class="w-full flex flex-row items-center justify-between">
			<div class="w-full flex flex-col gap-10">
				<h1 class="display-lg text-gray-900"><?php woocommerce_page_title(); ?></h1>
				<div class="w-full flex flex-row items-center justify-between"><? echo woocommerce_result_count(); ?></div>
			</div>
			<?php
			echo get_button([
				"text" => "Filtreler",
				"hierarchy" => "tertiary",
				"leadingIcon" => "filter",
				"type" => "button",
				"classes" => "open-category-filters md:!hidden"
			]);
			?>
		</header>
	<?php endif; ?>
	<section class="w-full flex flex-col md:flex-row gap-30">
		<aside class="w-full max-w-444 hidden md:flex flex-col grow-1 shrink-1 basis-1/1 md:basis-1/4 gap-30 px-20 py-20 shadow-xs rounded-[15px] shrink-0">
			<?php get_template_part('components/category-filters', "category_filters", [
				"taxonomies" => $filters["taxonomies"],
				"base_url" => $base_url
			]); ?>
		</aside>
		<?php echo get_drawer_menu([
			'wrapperClass' => 'category-filters-drawer-menu',
			'buttonClass' => 'open-category-filters',
			'width' => 'w-full md:w-600',
			'title' => 'Filtreler',
			'icon' => 'filter',
		], function () use ($filters, $base_url) {
			echo '<div class="w-full flex flex-col p-20 gap-30">';
			get_template_part('components/category-filters', "category_filters", [
				"taxonomies" => $filters["taxonomies"],
				"base_url" => $base_url
			]);
			echo get_button([
				"text" => "Tamam",
				"type" => "button",
				"classes" => "close-drawer",
				"onclick" => "close_drawer()"
			]);
			echo '</div>';
		}); ?>
		<article class="flex flex-row items-start justify-start grow-1 shrink-1 basis-1/1 md:basis-3/4 gap-y-20 flex-wrap">
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
		</article>
	</section>
</section>
<?php get_template_part('components/footer');
get_footer('shop');
