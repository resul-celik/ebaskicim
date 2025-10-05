<?php

// WOOCOMMERCE

function customtheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'customtheme_add_woocommerce_support');
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
add_filter('woocommerce_ship_to_different_address_checked', '__return_true');

/* KURUMSAL DISCOUNT (Start) */

function ebs_default_kurumsal_discount($discount)
{
    return 40;
}
add_filter('ebs_kurumsal_discount_percentage', 'ebs_default_kurumsal_discount');

// Calculate kurumsal discount on checkout
function ebs_apply_kurumsal_discount($cart)
{
    if (is_admin() && ! defined('DOING_AJAX')) return;
    if (! is_user_logged_in()) return;

    $user = wp_get_current_user();
    if (in_array('kurumsal', (array) $user->roles)) {
        $discount_percentage = apply_filters('ebs_kurumsal_discount_percentage', 0);
        $discount = $cart->get_subtotal() * ($discount_percentage / 100);
        $cart->add_fee(sprintf(__('Kurumsal İndirim (%%%s)', 'textdomain'), $discount_percentage), -$discount);
    }
}
add_action('woocommerce_cart_calculate_fees', 'ebs_apply_kurumsal_discount');

/* KURUMSAL DISCOUNT (End) */

/* PRICE HTML (Start) */

function ebs_price_html($price, $product)
{

    // Price with kurumsal discount
    if (is_user_logged_in() && in_array('kurumsal', wp_get_current_user()->roles)) {
        $discount_percentage = apply_filters('ebs_kurumsal_discount_percentage', 0);
        $regular_price = $product->get_price();
        $discounted = $regular_price * ((100 - $discount_percentage) / 100);

        $price = sprintf(
            '<del class="old-price">%s</del><ins class="new-price">%s</ins>',
            wc_price($regular_price, array('in_span' => false)),
            wc_price($discounted, array('in_span' => false))
        );
    } else {

        // Normal discount
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();

        if ($sale_price) {
            $price = sprintf(
                '<del class="old-price">%s</del><ins class="new-price">%s</ins>',
                wc_price($regular_price, array('in_span' => false)),
                wc_price($sale_price, array('in_span' => false))
            );
        } else {
            $price = sprintf(
                '<ins class="new-price">%s</ins>',
                wc_price($regular_price, array('in_span' => false))
            );
        }
    }
    return $price;
}
add_filter('woocommerce_get_price_html', 'ebs_price_html', 10, 2);

/* PRICE HTML (End) */


function ebs_get_avatar($args = [])
{
    $defaults = [
        "class" => "w-80 h-80 text-[30px]",
    ];

    $args = wp_parse_args($args, $defaults);
    $user = wp_get_current_user();

    // show First Name and Last Name if exists. If not, show display name
    $name = $user->first_name && $user->last_name ?  mb_substr($user->first_name, 0, 1) . '' . mb_substr($user->last_name, 0, 1) :  mb_substr($user->display_name, 0, 1);

    $classes =  $args["class"] . " flex items-center justify-center bg-primary-400 rounded-full uppercase grow-0 shrink-0 select-none";

    return sprintf('<div class="%s">%s</div>', $classes, $name);
}

// FUNCTIONS
function product_status_tag($text, $class)
{
    $return = '<div class="flex flex-row items-center justify-center ' . $class . ' rounded-full px-[8px] py-[1px] uppercase paragraph-xs paragraph-medium">';
    $return .= $text;
    $return .= '</div>';
    return $return;
}

function site_feature_box($args)
{
    $args["title"] = $args["title"] ?? '';
    $args["description"] = $args["description"] ?? '';
    $args["image"] = $args["image"] ?? '';

    if (!$args["title"] || !$args["description"]) {
        return;
    }
?>
    <div class="flex flex-row md:flex-col items-center md:items-start justify-start p-15 md:p-30 gap-30 bg-gray-50 shrink-0 rounded-[15px] features-slider-item">
        <?php if ($args["image"]) : ?>
            <div class="w-full aspect-4/3 flex items-center justify-center">
                <img src="<?php echo $args["image"]; ?>" alt="" class="w-full h-full object-contain">
            </div>
        <?php endif; ?>
        <div class="w-full flex flex-col gap-10 items-start justify-start">
            <h2 class="display-sm text-gray-900"><?php echo $args['title']; ?></h2>
            <p class="paragraph-lg text-gray-600"><?php echo $args['description']; ?></p>
        </div>
    </div>
<?php
}

function ebs_get_badge($text, $args = array())
{
    $defaults = array(
        "classes" => "",
    );

    $args = array_merge($defaults, $args);

    return sprintf('<div class="w-auto h-20 min-w-20 px-5 flex items-center justify-center bg-primary-400 rounded-full text-xs font-bold %s">%s</div>', $args["classes"], $text);
}
// REGISTER CUSTOM CSS & JS
function ebaskicim_custom_css()
{
    wp_enqueue_style('ebaskicim-styles', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), '1.0', 'all');
    wp_enqueue_style('ebaskicim-tailwind', get_stylesheet_directory_uri() . '/assets/css/tw-output.css', array(), '1.0', 'all');
    wp_enqueue_style('ebaskicim-main-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js', array(), false, true);
    wp_enqueue_script('ebaskicim-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'ebaskicim_custom_css', 20);

// COMPONENTS

include get_template_directory() . '/components/button.php';
include get_template_directory() . '/components/accordion.php';
include get_template_directory() . '/components/icons.php';
include get_template_directory() . '/components/quantity-input.php';
include get_template_directory() . '/components/select-input.php';
include get_template_directory() . '/components/text-input.php';
include get_template_directory() . '/components/drawer-menu.php';
include get_template_directory() . '/components/products.php';
include get_template_directory() . '/components/section.php';
include get_template_directory() . '/components/account-drawer.php';
include get_template_directory() . '/components/filter-tag.php';


// Register sidebar
if (function_exists('register_sidebar')) {

    register_sidebar(
        array(
            'name' => 'Slider',
            'id' => 'slider',
            'description' => '+ butonuyla slider öğesi ekleyin',
            'before_widget' => '<div class="main-slider-item w-full h-full shrink-0">',
            'after_widget' => '</div>',
        )
    );
}
if (function_exists('register_sidebar')) {

    register_sidebar(
        array(
            'name' => 'Footer Menüleri',
            'id' => 'footer-menus',
            'description' => '+ butonuyla yeni footer menüsü ekleyin',
            'before_widget' => '<div class="footer-menu col-span-2 flex-1 flex flex-col gap-4">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="paragraph-md paragraph-bold text-gray-900">',
            'after_title' => '</h2>',
        )
    );
}
// Register Menus
/* function register_my_menus()
{
    register_nav_menus(
        array(
            'header' => __('Header Menu'),
            'footer' => __('Footer Menu'),
            'footer2' => __('Footer Menu 2'),
            'footer3' => __('Footer Menu 3'),
        )
    );
}
add_action('init', 'register_my_menus'); */



/* CUSTOM COUPON HTML FOR CHECKOUT (Start) */
add_filter('woocommerce_cart_totals_coupon_html', 'ebs_custom_checkout_coupon', 10, 3);

function ebs_custom_checkout_coupon($coupon_html, $coupon, $discount_amount_html)
{
    $remove_url = esc_url(add_query_arg(
        'remove_coupon',
        rawurlencode($coupon->get_code()),
        is_checkout() ? wc_get_checkout_url() : wc_get_cart_url()
    ));

    $new_html  = '<div class="paragraph-md paragraph-bold text-gray-900">' . $discount_amount_html . '</div>';

    return sprintf(
        '%s<a role="button" aria-label="%s" href="%s" class="paragraph-md paragraph-bold text-error-500" data-coupon="%s">%s</a>',
        $new_html,
        esc_attr(sprintf(__('Remove %s coupon', 'woocommerce'), $coupon->get_code())),
        $remove_url,
        esc_attr($coupon->get_code()),
        __('Remove', 'woocommerce')
    );
}
add_filter('woocommerce_cart_totals_coupon_label', 'ebs_custom_checkout_coupon_label', 10, 2);

function ebs_custom_checkout_coupon_label($sprintf, $coupon)
{

    $couponCode = '<strong>' . esc_html__($coupon->get_code()) . '</strong>';

    $sprintf = sprintf(__('Coupon: %s', 'woocommerce'), $couponCode);
    return $sprintf;
}



/* CUSTOM COUPON HTML (End) */


/* IMAGE SIZES (Start) */

function ebs_custom_image_sizes()
{
    add_theme_support('post-thumbnails');
    add_image_size('product_thubmbnail_small', 40, 40, true);
    add_image_size('product_thubmbnail_medium', 60, 60, true);
    add_image_size('product_thubmbnail_large', 100, 100, true);
    add_image_size('product_gallery_large', 1440, 1080, false);
}
add_action('after_setup_theme', 'ebs_custom_image_sizes');


/* IMAGE SIZES (End) */

add_action('template_redirect', 'misha_redirect_to_orders_from_dashboard');
function misha_redirect_to_orders_from_dashboard()
{

    if (is_account_page() && empty(WC()->query->get_current_endpoint())) {
        wp_safe_redirect(wc_get_account_endpoint_url('orders'));
        exit;
    }
}


function ebs_get_active_attribute_terms_in_category($taxonomy, $category_id)
{
    // Kategorideki ürünleri al
    $products = get_posts([
        'post_type' => 'product',
        'numberposts' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ],
        ],
        'fields' => 'ids', // sadece ID'leri al, performans için
    ]);

    if (empty($products)) return [];

    // Bu ürünlerde kullanılan attribute terimlerini al
    $terms = wp_get_object_terms($products, $taxonomy);

    return $terms;
}

function ebs_get_category_filters($category_slug)
{
    $category = get_term_by('slug', $category_slug, 'product_cat');
    if (!$category) return [];

    // Kategorideki ürünleri çek
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        ),
    );

    $product_ids = get_posts($args);
    if (empty($product_ids)) return [];

    // Tüm ürünlerde geçen attribute'ları bul
    $attributes = wc_get_attribute_taxonomies();
    $response = [
        'categoryName' => $category->name,
        'slug' => $category->slug,
        'taxonomies' => []
    ];

    foreach ($attributes as $attribute) {
        $taxonomy = 'pa_' . $attribute->attribute_name;
        if (!taxonomy_exists($taxonomy)) continue;

        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ]);

        $term_data = [];
        foreach ($terms as $term) {
            // Bu termi içeren ürünleri say
            $count_args = [
                'post_type' => 'product',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'tax_query' => [
                    'relation' => 'AND',
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $category_slug,
                    ],
                    [
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => $term->slug,
                    ]
                ]
            ];

            $term_products = get_posts($count_args);
            $product_count = count($term_products);

            // Eğer bu terim kategoride hiç kullanılmamışsa atla
            if ($product_count > 0) {
                $term_data[] = [
                    'name' => $term->name,
                    'slug' => $term->slug,
                    'products' => $product_count
                ];
            }
        }

        // Sadece term’leri olan taxonomy’leri ekle
        if (!empty($term_data)) {
            $response['taxonomies'][$taxonomy] = [
                'name' => $attribute->attribute_label,
                'slug' => $attribute->attribute_name,
                'terms' => $term_data
            ];
        }
    }

    return $response;
}
