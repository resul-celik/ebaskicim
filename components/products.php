<?php

function get_products($categorySlug = '')
{
    $return = '';
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        'product_cat' => $categorySlug
    );

    $loop = new WP_Query($args);

    $return .= '<div class="swiper w-full relative flex flex-col gap-30 items-start">';
    $return .= '<div class="swiper-wrapper w-full relative box-content flex flex-row justify-start items-center">';

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();

            ob_start();
            wc_get_template_part('content', 'product');
            $return .= ob_get_clean();
        }
    }

    $return .= '</div>';
    $return .= '<div class="product-slider-pagination"></div>';
    $return .= '</div>';

    wp_reset_postdata();

    return $return;
}
