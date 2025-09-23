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
include get_template_directory() . '/components/quantity-input.php';
include get_template_directory() . '/components/select-input.php';
include get_template_directory() . '/components/text-input.php';
include get_template_directory() . '/includes/products.php';
include get_template_directory() . '/components/section.php';


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
