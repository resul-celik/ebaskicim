<?php

function get_products()
{
    $return = '';
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10
    );

    $loop = new WP_Query($args);

    $return .= '<div class="swiper w-full"><div class="swiper-wrapper w-full relative box-content flex flex-row justify-start items-center">';

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();

            ob_start();
            wc_get_template_part('content', 'product');
            $return .= ob_get_clean();
        }
    }

    $return .= '</div></div>';

    wp_reset_postdata();

    return $return;
}
