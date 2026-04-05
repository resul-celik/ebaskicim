<?php

defined('ABSPATH') || exit;
get_header();
get_template_part('components/header');

?>
<main class="w-full flex flex-col items-center justify-start overflow-hidden">
    <?php get_template_part('components/main-slider'); ?>
    <?php get_template_part('components/features'); ?>
    <?php $neonCat = get_term_by("slug", 'dijital-baski', 'product_cat'); ?>
    <?php $posterCat = get_term_by("slug", 'promosyon', 'product_cat'); ?>
    <?php $kanvasCat = get_term_by("slug", 'tablolar', 'product_cat'); ?>
    <?
    $neonLed = [
        "title" => "Neon Led",
        "url" => get_category_link($neonCat->term_id),
        "order" => 2
    ];
    $poster = [
        "title" => "Poster",
        "url" => get_category_link($posterCat->term_id),
        "order" => 1
    ];
    $kanvas = [
        "title" => "Kanvas Tablo",
        "url" => get_category_link($kanvasCat->term_id),
        "order" => 3
    ];
    ?>
    <?php get_section($neonLed, function () {
        echo get_products("dijital-baski");
    }); ?>
    <?php get_section($poster, function () {
        echo get_products("display-urunler");
    }); ?>
    <?php get_section($kanvas, function () {
        echo get_products("tablolar");
    }); ?>
</main>
<?php get_template_part('components/footer');
get_footer('shop');
