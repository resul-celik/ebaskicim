<?php

/**
 * Template Name: Search Page
 */

get_header();
$search_query = get_search_query();
?>

<div class="juno-page search-results">
    <div class="page-head" onclick="openSearchForm()">
        <div class="search-title-wrapper">
            <div class="search--small-title">Search results for:</div>
            <h1 class="page-title"><?php echo $search_query; ?></h1>
        </div>
        <div class="icon icon-search"></div>
    </div>
    <div class="page-content">
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
    </div>
</div>

<?php
get_footer();
