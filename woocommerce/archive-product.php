<?php

defined('ABSPATH') || exit;
get_header();
get_template_part('components/header');

?>
<main class="w-full flex flex-col items-center justify-start overflow-hidden">
    <?php get_template_part('components/main-slider'); ?>
    <?php get_template_part('components/features'); ?>
    <?php
    for ($i = 1; $i <= 3; $i++) {
        $cat_slug = get_theme_mod("ebs_featured_{$i}_cat", '');

        if (!$cat_slug) continue;

        $cat = get_term_by('slug', $cat_slug, 'product_cat');
        if (!$cat || is_wp_error($cat)) continue;

        get_section([
            'title' => $cat->name,
            'url'   => get_term_link($cat),
            'order' => $i,
        ], function () use ($cat_slug) {
            echo get_products($cat_slug);
        });
    }
    ?>
</main>
<?php get_template_part('components/footer');
get_footer('shop');
