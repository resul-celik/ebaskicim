<?php get_header();
        
    if (have_posts()) {

        while (have_posts()) {

            the_post();
            
            if (is_account_page() || is_cart() || is_checkout()) {
                
                the_content();
                
            } else {
                
                echo '<div class="container-xl page-container">';
                    echo '<div class="row">';
                        echo '<h1 class="title page-title">'.get_the_title().'</h1>';
                        echo '<article class="page-content">';
                
                        the_content();

                        if (!get_the_content()) {

                            echo "İçerik eklenmemiş";

                        }

                        echo '</article>';
                    echo '</div>';
                echo '</div>';
                
            }

                

        }
        
    } else {
        
        echo "İçerik eklenmedi.";
        
    }

get_footer(); ?>