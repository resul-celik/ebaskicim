<?php

defined('ABSPATH') || exit;

if (is_active_sidebar('slider')) : ?>
    <section class="w-full max-w-[1920px] p-20 flex flex-col items-center justify-center">
        <div class="main-slider w-full aspect-18/6 overflow-hidden rounded-[15px]">
            <div class="main-slider-wrapper w-full aspect-18/6 relative box-content flex flex-row justify-start items-center">
                <?php dynamic_sidebar('slider'); ?>
            </div>
        </div>
    </section>
<?php endif;
