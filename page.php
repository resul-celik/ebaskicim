<?php get_header();
get_template_part('components/header'); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php if (is_cart() || is_account_page() || is_checkout()) : ?>
            <?php the_content(); ?>
        <?php else : ?>
            <main class="main page-container">
                <article class="w-full max-w-[690px] px-20 py-60">
                    <h1 class="page-title"><?php echo get_the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
            </main>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_template_part('components/footer');
get_footer();
