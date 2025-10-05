<?php

/**
 * Template Name: Search Page
 */

get_header();
get_template_part('components/header');
//$filters = ebs_get_category_filters($category_slug);
$search_query = get_search_query();
?>

<main class="main">
    <section class="results-page w-full max-w-[1920px] flex flex-col items-center justify-start px-20 pt-30 pb-100 gap-30 grow-1">
        <header class="w-full flex flex-row items-center justify-between">
            <div class="w-full flex flex-col gap-10">
                <h1 class="display-sm text-gray-900">
                    <span>Arama sonuçları: </span>
                    <?php echo $search_query; ?>
                </h1>
                <div class="w-full flex flex-row items-center paragraph-lg text-gray-600"><? echo $GLOBALS['wp_query']->found_posts; ?> sonuç bulundu</div>
            </div>
        </header>
        <section class="w-full flex flex-col md:flex-row gap-30">
            <article class="flex flex-row items-start justify-start grow-1 shrink-1 basis-1/1 md:basis-3/4 gap-y-20 flex-wrap">
                <?php

                if (have_posts()) :
                    while (have_posts()) : the_post(); // Start the Loop
                        wc_get_template_part('content', 'product'); // Get the content-product.php  template
                    endwhile;

                    //pagination
                    the_posts_pagination(array(
                        'prev_text' => __('←', 'junobjects'),
                        'next_text' => __('→', 'junobjects'),
                        'screen_reader_text' => __('Search results navigation', 'junobjects'),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'junobjects') . ' </span>',

                    ));

                else :
                ?>
                    <div class="search-no-results">
                        <p><?php _e('No results found.', 'junobjects'); ?></p>
                    </div>
                <?php
                endif;
                ?>
            </article>
        </section>
    </section>
</main>

<?php
get_template_part('components/footer');
get_footer();
