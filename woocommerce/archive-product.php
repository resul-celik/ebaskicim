<?php

defined('ABSPATH') || exit;
get_header();
get_template_part('components/header');

?>
<main class="w-full flex flex-col items-center justify-start overflow-hidden">
    <?php get_template_part('components/main-slider'); ?>
    <?php get_template_part('components/features'); ?>
    <?php $neonCat = get_term_by("slug", 'neon-led', 'product_cat'); ?>
    <?php $posterCat = get_term_by("slug", 'poster', 'product_cat'); ?>
    <?php $kanvasCat = get_term_by("slug", 'kanvas-tablo', 'product_cat'); ?>
    <?php echo get_section('Neon Led', get_category_link($neonCat->term_id), 2, "get_products", "neon-led"); ?>
    <?php echo get_section('Poster', get_category_link($posterCat->term_id), 1, "get_products", "poster"); ?>
    <?php echo get_section('Kanvas Tablo', get_category_link($kanvasCat->term_id), 3, "get_products", "kanvas-tablo"); ?>
</main>
<?php get_template_part('components/footer');
get_footer('shop');
