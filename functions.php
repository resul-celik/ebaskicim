<?php

// WOOCOMMERCE

function customtheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'customtheme_add_woocommerce_support');
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
add_filter('woocommerce_ship_to_different_address_checked', '__return_true');

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
    <div class="flex flex-col items-start justify-start p-30 gap-30 bg-gray-50 shrink-0 rounded-[15px] features-slider-item">
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

function ebs_get_badge($text)
{
    return '<div class="w-auto h-[20px] min-w-[20px] px-5 flex items-center justify-center bg-primary-400 rounded-full text-xs font-bold">' . $text . '</div>';
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
            'name' => 'Footer Menus',
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
