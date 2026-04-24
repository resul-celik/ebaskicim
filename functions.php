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

function ebs_default_kurumsal_discount()
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
    // For variable products, resolve to the cheapest variation's prices
    if ($product->is_type('variable')) {
        $variation_prices = $product->get_variation_prices();
        if (empty($variation_prices['price'])) {
            return $price;
        }
        $min_id        = key($variation_prices['price']);
        $regular_price = $variation_prices['regular_price'][$min_id] ?? '';
        $sale_price    = $variation_prices['sale_price'][$min_id] ?? '';
    } else {
        $regular_price = $product->get_regular_price();
        $sale_price    = $product->get_sale_price();
    }

    // Price with kurumsal discount
    if (is_user_logged_in() && in_array('kurumsal', wp_get_current_user()->roles)) {
        $discount_percentage = apply_filters('ebs_kurumsal_discount_percentage', 0);
        $base_price  = ($sale_price && (float) $sale_price < (float) $regular_price) ? $sale_price : $regular_price;
        $discounted  = $base_price * ((100 - $discount_percentage) / 100);

        $price = sprintf(
            '<del class="old-price">%s</del><ins class="new-price">%s</ins>',
            wc_price($base_price, array('in_span' => false)),
            wc_price($discounted, array('in_span' => false))
        );
    } elseif ($sale_price && (float) $sale_price < (float) $regular_price) {
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
    wp_enqueue_style('ebaskicim-styles', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), '1.6', 'all');
    wp_enqueue_style('ebaskicim-tailwind', get_stylesheet_directory_uri() . '/assets/css/tw-output.css', array(), '1.6', 'all');
    wp_enqueue_style('ebaskicim-main-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.3', 'all');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js', array(), false, true);
    wp_enqueue_script('ebaskicim-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '1.5', true);
    wp_localize_script('ebaskicim-main', 'ebs_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
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


function register_eb_menus()
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
add_action('init', 'register_eb_menus');

/* CUSTOM COUPON HTML FOR CHECKOUT (Start) */
add_filter('woocommerce_cart_totals_coupon_html', 'ebs_custom_checkout_coupon', 10, 3);

function ebs_custom_checkout_coupon($_coupon_html, $coupon, $discount_amount_html)
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
                'slug' => 'pa_' . $attribute->attribute_name,
                'terms' => $term_data
            ];
        }
    }

    return $response;
}


add_filter('navigation_markup_template', 'ebs_product_pagination', 10, 2);

function ebs_product_pagination($template, $_output)
{
    $template = '<div class="w-full flex flex-row items-center justify-center pt-20"><nav class="pagination" role="navigation" aria-label="Pagination">%3$s</nav></div>';
    return $template;
}


/* ============================================================
   CUSTOMIZER — Öne Çıkan Kategoriler
   ============================================================ */

add_action('customize_register', 'ebs_customize_slider');

function ebs_customize_slider(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_section('ebs_slider', [
        'title'       => 'Ana Slider',
        'description' => 'Her slayt için görsel ve link belirleyin. Görseli boş bırakılan slaytlar gösterilmez.',
        'priority'    => 20,
    ]);

    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("ebs_slider_{$i}_image", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "ebs_slider_{$i}_image", [
            'label'   => "{$i}. Slayt — Görsel",
            'section' => 'ebs_slider',
        ]));

        $wp_customize->add_setting("ebs_slider_{$i}_url", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("ebs_slider_{$i}_url", [
            'label'   => "{$i}. Slayt — Link",
            'section' => 'ebs_slider',
            'type'    => 'url',
        ]);
    }
}

add_action('customize_register', 'ebs_customize_featured_sections');

function ebs_customize_featured_sections(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_section('ebs_featured_sections', [
        'title'       => 'Öne Çıkan Kategoriler',
        'description' => 'Anasayfada gösterilecek 3 bölümü buradan yönetebilirsiniz.',
        'priority'    => 30,
    ]);

    $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    $cat_choices = ['' => '— Seçiniz —'];
    foreach ($cats as $cat) {
        $cat_choices[$cat->slug] = $cat->name;
    }

    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("ebs_featured_{$i}_cat", [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("ebs_featured_{$i}_cat", [
            'label'   => "{$i}. Bölüm",
            'section' => 'ebs_featured_sections',
            'type'    => 'select',
            'choices' => $cat_choices,
        ]);
    }
}

// Footer Column Titles

add_action('customize_register', 'eb_customize_footer_columns');

function eb_customize_footer_columns(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_section('eb_footer_columns', [
        'title'       => 'Footer Sütun Başlıkları',
        'description' => 'Her sütunun başlığını girin. Menü içerikleri için Görünüm → Menüler bölümünü kullanın.',
        'priority'    => 35,
    ]);

    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("eb_footer_col_{$i}_title", [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("eb_footer_col_{$i}_title", [
            'label'   => "{$i}. Sütun Başlığı",
            'section' => 'eb_footer_columns',
            'type'    => 'text',
        ]);
    }
}

// Social Media Username Fields

add_action('customize_register', 'eb_social_media_links');

function eb_social_media_links(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_section('eb_social_media_sections', [
        'title'       => 'Sosyal Medya',
        'description' => 'Sosyal medya hesaplarınızın kullanıcı adını giriniz.',
        'priority'    => 40,
    ]);

    $platforms = [
        'eb_instagram'  => 'Instagram',
        'eb_facebook'   => 'Facebook',
        'eb_youtube'    => 'YouTube',
        'eb_twitter'    => 'X (Twitter)',
        'eb_pinterest'  => 'Pinterest',
        'eb_linkedin'   => 'LinkedIn',
    ];

    foreach ($platforms as $key => $label) {
        $wp_customize->add_setting($key, [
            'default'           => ''
        ]);
        $wp_customize->add_control($key, [
            'label'       => $label,
            'section'     => 'eb_social_media_sections',
            'type'        => 'text',
            'input_attrs' => [
                'placeholder' => 'kullaniciadi',
            ],
        ]);
    }
}


// Block BeRocket subscribe/promo admin notices (stored in DB options)
add_filter('pre_option_berocket_admin_notices', function () {
    return [];
});
add_filter('pre_option_berocket_information_notices', function () {
    return [];
});

// Block update checks for modified third-party plugins
add_filter('site_transient_update_plugins', function ($transient) {
    $blocked = [
        'product-watermark-for-woocommerce/woocommerce-products-image-watermark.php',
    ];
    foreach ($blocked as $plugin) {
        unset($transient->response[$plugin]);
        unset($transient->checked[$plugin]);
    }
    return $transient;
});

add_action('wp_ajax_ebs_category_filter_action', 'ebs_ajax_query');
add_action('wp_ajax_nopriv_ebs_category_filter_action', 'ebs_ajax_query');

function ebs_ajax_query()
{

    $query = $_POST["ajax_data"];

    if ($query["query"] !== "") {

        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
            's' => $query["query"]
        ];

        $products = get_posts($args);

        wp_send_json_success($products);
    } else {
        wp_send_json_error("product not found");
    }
}

/* ATTRIBUTE TERM FIELDS (Start) */

/**
 * Register color + image fields on every pa_* attribute taxonomy term.
 * Hooks must be added at init after WooCommerce has registered the taxonomies.
 */
function ebs_register_attribute_term_fields()
{
    $attribute_taxonomies = wc_get_attribute_taxonomies();
    if (!$attribute_taxonomies) return;

    foreach ($attribute_taxonomies as $tax) {
        $taxonomy = wc_attribute_taxonomy_name($tax->attribute_name);
        add_action("{$taxonomy}_add_form_fields",  'ebs_attribute_term_add_fields');
        add_action("{$taxonomy}_edit_form_fields", 'ebs_attribute_term_edit_fields', 10, 2);
        add_action("created_{$taxonomy}",          'ebs_attribute_term_save_fields');
        add_action("edited_{$taxonomy}",           'ebs_attribute_term_save_fields');
    }
}
add_action('init', 'ebs_register_attribute_term_fields', 20);

/** Render fields on the "Add new term" form */
function ebs_attribute_term_add_fields()
{
?>
    <div class="form-field">
        <label for="ebs_term_color"><?php esc_html_e('Renk', 'ebaskicim'); ?></label>
        <input type="text" name="ebs_term_color" id="ebs_term_color" value="" class="ebs-color-picker" />
        <p class="description"><?php esc_html_e('Chip içinde gösterilecek renk. Görsel de seçildiyse renk gösterilmez.', 'ebaskicim'); ?></p>
    </div>
    <div class="form-field">
        <label><?php esc_html_e('Görsel', 'ebaskicim'); ?></label>
        <div class="ebs-term-image-wrap">
            <img id="ebs_term_image_preview" src="" style="display:none;width:60px;height:60px;object-fit:cover;border-radius:6px;margin-bottom:6px;" />
            <br>
            <input type="hidden" name="ebs_term_image" id="ebs_term_image" value="" />
            <button type="button" class="button ebs-upload-image-btn"><?php esc_html_e('Görsel Seç', 'ebaskicim'); ?></button>
            <button type="button" class="button ebs-remove-image-btn" style="display:none;"><?php esc_html_e('Kaldır', 'ebaskicim'); ?></button>
        </div>
        <p class="description"><?php esc_html_e('Chip içinde gösterilecek görsel (doku, malzeme vb.). Dolu ise renk alanı göz ardı edilir.', 'ebaskicim'); ?></p>
    </div>
<?php
}

/** Render fields on the "Edit term" form */
function ebs_attribute_term_edit_fields($term, $_taxonomy)
{
    $color     = get_term_meta($term->term_id, 'ebs_term_color', true);
    $image_id  = (int) get_term_meta($term->term_id, 'ebs_term_image', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
?>
    <tr class="form-field">
        <th><label for="ebs_term_color"><?php esc_html_e('Renk', 'ebaskicim'); ?></label></th>
        <td>
            <input type="text" name="ebs_term_color" id="ebs_term_color" value="<?php echo esc_attr($color); ?>" class="ebs-color-picker" />
            <p class="description"><?php esc_html_e('Chip içinde gösterilecek renk. Görsel de seçildiyse renk gösterilmez.', 'ebaskicim'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th><label><?php esc_html_e('Görsel', 'ebaskicim'); ?></label></th>
        <td>
            <div class="ebs-term-image-wrap">
                <img id="ebs_term_image_preview" src="<?php echo esc_url($image_url); ?>" style="<?php echo $image_url ? '' : 'display:none;'; ?>width:60px;height:60px;object-fit:cover;border-radius:6px;margin-bottom:6px;" />
                <br>
                <input type="hidden" name="ebs_term_image" id="ebs_term_image" value="<?php echo esc_attr($image_id ?: ''); ?>" />
                <button type="button" class="button ebs-upload-image-btn"><?php esc_html_e('Görsel Seç', 'ebaskicim'); ?></button>
                <button type="button" class="button ebs-remove-image-btn" <?php echo $image_url ? '' : 'style="display:none;"'; ?>><?php esc_html_e('Kaldır', 'ebaskicim'); ?></button>
            </div>
            <p class="description"><?php esc_html_e('Chip içinde gösterilecek görsel (doku, malzeme vb.). Dolu ise renk alanı göz ardı edilir.', 'ebaskicim'); ?></p>
        </td>
    </tr>
<?php
}

/** Save term meta */
function ebs_attribute_term_save_fields($term_id)
{
    if (isset($_POST['ebs_term_color'])) {
        $color = sanitize_hex_color($_POST['ebs_term_color']);
        if ($color) {
            update_term_meta($term_id, 'ebs_term_color', $color);
        } else {
            delete_term_meta($term_id, 'ebs_term_color');
        }
    }

    if (isset($_POST['ebs_term_image'])) {
        $image_id = absint($_POST['ebs_term_image']);
        if ($image_id) {
            update_term_meta($term_id, 'ebs_term_image', $image_id);
        } else {
            delete_term_meta($term_id, 'ebs_term_image');
        }
    }
}

/** Enqueue color picker + media uploader on attribute term pages */
function ebs_enqueue_attribute_term_scripts($hook)
{
    if (!in_array($hook, ['edit-tags.php', 'term.php'], true)) return;

    $screen = get_current_screen();
    if (!$screen || strpos($screen->taxonomy, 'pa_') !== 0) return;

    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script(
        'ebs-attribute-term-fields',
        get_template_directory_uri() . '/assets/js/admin-term-fields.js',
        ['jquery', 'wp-color-picker'],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('admin_enqueue_scripts', 'ebs_enqueue_attribute_term_scripts');

/* ATTRIBUTE TERM FIELDS (End) */

/* DESIGN UPLOAD (Start) */

/**
 * AJAX: upload a design file to /uploads/design-uploads/
 *
 * Security measures:
 *  - Nonce verification
 *  - PHP upload error check
 *  - 20 MB size cap
 *  - wp_check_filetype_and_ext() validates BOTH extension AND actual file signature
 *  - SVG/AI/EPS excluded (script injection risk)
 *  - Randomised filename — original name never hits the filesystem
 *  - .htaccess blocks PHP execution and directory listing in the target dir
 *  - file_url NOT returned to the client (no roadmap to the file)
 */
function ebs_upload_design()
{
    check_ajax_referer('ebs_upload_design', 'nonce');

    // Basic upload sanity check
    if (empty($_FILES['design_file']) || $_FILES['design_file']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('Dosya bulunamadı veya yükleme hatası oluştu.');
    }

    $file = $_FILES['design_file'];

    // 1. File size cap (20 MB)
    $max_bytes = 20 * 1024 * 1024;
    if ($file['size'] > $max_bytes) {
        wp_send_json_error('Dosya boyutu 20 MB\'ı geçemez.');
    }

    // 2. Validate extension AND actual file content signature
    //    SVG, AI, EPS are intentionally excluded: SVG can embed <script>,
    //    PostScript can trigger code execution in some interpreters.
    $allowed = [
        'jpg|jpeg' => 'image/jpeg',
        'png'      => 'image/png',
        'pdf'      => 'application/pdf',
        'psd'      => 'image/vnd.adobe.photoshop',
        'zip'      => 'application/zip',
    ];

    $checked = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], $allowed);
    if (!$checked['type'] || !$checked['ext']) {
        wp_send_json_error('Desteklenmeyen dosya türü. İzin verilenler: JPG, PNG, PDF, PSD, ZIP.');
    }

    // 3. Prepare target directory
    $upload_dir = wp_upload_dir();
    $design_dir = trailingslashit($upload_dir['basedir']) . 'design-uploads/';

    wp_mkdir_p($design_dir);

    // Block PHP execution and directory listing via .htaccess (Apache)
    $htaccess = $design_dir . '.htaccess';
    if (!file_exists($htaccess)) {
        file_put_contents(
            $htaccess,
            "Options -Indexes\n" .
                "<FilesMatch \"\\.ph(p[2-9]?|tml|ar|ps)$\">\n" .
                "  Order Allow,Deny\n" .
                "  Deny from all\n" .
                "</FilesMatch>\n"
        );
    }

    // index.php fallback for servers without mod_autoindex control
    $index = $design_dir . 'index.php';
    if (!file_exists($index)) {
        file_put_contents($index, '<?php // Silence is golden.');
    }

    // 4. Store with a fully randomised name — original filename never touches disk
    $file_key = wp_generate_password(32, false) . '.' . $checked['ext'];
    $dest     = $design_dir . $file_key;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        wp_send_json_error('Dosya kaydedilemedi.');
    }

    // Return the display name (original) and the opaque server key only
    wp_send_json_success([
        'file_key'  => $file_key,
        'file_name' => sanitize_text_field($file['name']), // display only, never used as path
    ]);
}
add_action('wp_ajax_ebs_upload_design',        'ebs_upload_design');
add_action('wp_ajax_nopriv_ebs_upload_design', 'ebs_upload_design');

/** Add a hidden input inside every add-to-cart form to carry the uploaded file key */
function ebs_design_hidden_input()
{
    echo '<input type="hidden" name="ebs_design_file_key" class="ebs-design-file-key" value="" />';
    echo '<input type="hidden" name="ebs_design_file_name" class="ebs-design-file-name" value="" />';
}
add_action('woocommerce_before_add_to_cart_button', 'ebs_design_hidden_input');

/** Attach the design file data to the cart item */
function ebs_add_design_to_cart_item($cart_item_data, $_product_id, $_variation_id)
{
    $file_key  = isset($_POST['ebs_design_file_key'])  ? sanitize_text_field($_POST['ebs_design_file_key'])  : '';
    $file_name = isset($_POST['ebs_design_file_name']) ? sanitize_text_field($_POST['ebs_design_file_name']) : '';

    if ($file_key) {
        $cart_item_data['ebs_design_file_key']  = $file_key;
        $cart_item_data['ebs_design_file_name'] = $file_name;
        $cart_item_data['unique_key']           = md5(microtime() . $file_key);
    }

    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'ebs_add_design_to_cart_item', 10, 3);

/** Show design file name in the cart and checkout summary */
function ebs_display_design_in_cart($item_data, $cart_item)
{
    if (!empty($cart_item['ebs_design_file_name'])) {
        $item_data[] = [
            'key'   => 'Tasarım Dosyası',
            'value' => esc_html($cart_item['ebs_design_file_name']),
        ];
    }
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'ebs_display_design_in_cart', 10, 2);

/** Save design file data to the order line item meta */
function ebs_save_design_to_order_item($item, $_cart_item_key, $values, $_order)
{
    if (!empty($values['ebs_design_file_key'])) {
        $item->add_meta_data('_ebs_design_file_key',  $values['ebs_design_file_key'], true);
        $item->add_meta_data('Tasarım Dosyası', $values['ebs_design_file_name'], true);
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'ebs_save_design_to_order_item', 10, 4);

/** Show a download link for the uploaded design file in the admin order detail */
function ebs_admin_order_item_design_link($_item_id, $item, $_product)
{
    $file_key = $item->get_meta('_ebs_design_file_key');
    if (!$file_key) return;

    $display_name = $item->get_meta('Tasarım Dosyası') ?: $file_key;
    $upload_dir   = wp_upload_dir();
    $file_url     = trailingslashit($upload_dir['baseurl']) . 'design-uploads/' . rawurlencode($file_key);

    printf(
        '<div class="ebs-design-download" style="margin-top:8px;">
            <strong>Tasarım Dosyası:</strong>
            <a href="%s" download="%s" target="_blank" style="margin-left:6px;">%s ↓</a>
        </div>',
        esc_url($file_url),
        esc_attr($display_name),
        esc_html($display_name)
    );
}
add_action('woocommerce_after_order_itemmeta', 'ebs_admin_order_item_design_link', 10, 3);

/* DESIGN UPLOAD (End) */
