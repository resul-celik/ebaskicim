<?php

get_header();

echo '<div class="container-xl">';

    if ( is_active_sidebar('slider') ) {

        dynamic_sidebar('slider');

    }

echo '</div>';

get_footer();