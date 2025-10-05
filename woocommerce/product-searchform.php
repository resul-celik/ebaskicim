<?php

/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if (! defined('ABSPATH')) {
	exit;
}

?>
<form role="search" method="get" class="woocommerce-product-search hidden md:flex flex-row bg-gray-100 rounded-full items-center pl-20 pr-15 h-45" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>"><?php esc_html_e('Search for:', 'woocommerce'); ?></label>
	<div class="search-field">
		<input type="search" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__('Search&hellip;', 'woocommerce'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</div>
	<button type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'woocommerce'); ?>" class="search-button <?php echo esc_attr(wc_wp_theme_get_element_class_name('button')); ?>">
		<div class="icon icon-search"></div>
	</button>
</form>
<div class="close-search" onclick="closeSearchForm()"></div>

<?php

/* 

<form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-field hidden md:flex flex-row bg-gray-100 rounded-full items-center pl-20 pr-15 h-45" role="search">
                    <input type="text" name="s" class="block grow-1 shrink-1 placeholder:text-gray-600" placeholder="Ara" />
                    <input type="hidden" value="submit" />
                    <input type="hidden" name="post_type" value="product" />
                    <button class="flex items-center justify-center text-gray-600" type="submit">
                        <i class="icon icon-search"></i>
                    </button>
                </form>

*/

?>