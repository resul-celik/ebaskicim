<?php

defined('ABSPATH') || exit;
get_header();
get_template_part('components/header');

?>
<main class="w-full flex flex-col items-center justify-start overflow-hidden">
    <?php get_template_part('components/main-slider'); ?>
    <?php get_template_part('components/features'); ?>
    <?php echo get_section('Ürünlerimiz', '#', 1, "get_products"); ?>
</main>
<?php get_template_part('components/footer');
get_footer('shop');
