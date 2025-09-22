<?php

defined('ABSPATH') || exit;
get_header();
get_template_part('components/header');

?>
<main class="w-full flex flex-col items-center justify-start overflow-hidden">
    <?php echo get_section('Ürunlerimiz', '#', 1, "get_products"); ?>
</main>

<section class="container-xl main" role="main">
    <?php if (is_active_sidebar('slider')) : ?>
        <div class="row slider-row" role="row">
            <!------ Ebaskicim The Big Slider Section ------>
            <div class="slider-container big-slider-container" role="slider">
                <div class="slider-wrapper big-slider-wrapper">
                    <div class="big-slider-items-wrapper">
                        <?php dynamic_sidebar('slider'); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row introduction-row" role="row">
        <?php

        $directory = get_template_directory_uri();

        $introductions = array(

            'Ücretsiz kargo' => $directory . '/images/illustrations/ebaskicim-ill-1-1x.png',

            'Kurumsal indirim' => $directory . '/images/illustrations/ebaskicim-ill-2-1x.png',

            'Baskı garantisi' => $directory . '/images/illustrations/ebaskicim-ill-3-1x.png',

            'Tasarımınızı ekleyin' => $directory . '/images/illustrations/ebaskicim-ill-4-1x.png'

        );

        $introductions_mb = array(

            'Ücretsiz kargo' => $directory . '/images/illustrations/ebaskicim-ill-1-2x.png',

            'Kurumsal indirim' => $directory . '/images/illustrations/ebaskicim-ill-2-2x.png',

            'Baskı garantisi' => $directory . '/images/illustrations/ebaskicim-ill-3-2x.png',

            'Tasarımınızı ekleyin' => $directory . '/images/illustrations/ebaskicim-ill-4-2x.png'

        );

        foreach ($introductions as $title => $image) :

        ?>
            <div class="col-xs-6 col-sm-6 col-lg-3 introduction">
                <figure class="introduction-illustration" role="img">
                    <img src="<?php echo $image; ?>" alt="Ücretsiz kargo" />
                </figure>
                <div class="title introduction-title" role="heading"><?php echo $title; ?></div>
                <div class="introduction-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque dapibus ornare tortor,
                </div>
            </div>
        <?php endforeach; ?>
        <div class="slider-container mobile-introduction-container">
            <div class="slider-wrapper mobile-introduction-wrapper">
                <div class="mobile-introduction-items-wrapper">
                    <?php foreach ($introductions_mb as $title => $image) : ?>
                        <div class="owl-item">
                            <div class="mobile-introduction">
                                <figure class="introduction-illustration" role="img">
                                    <img src="<?php echo $image; ?>" alt="Ücretsiz kargo" />
                                </figure>
                                <div class="title introduction-title" role="heading"><?php echo $title; ?></div>
                                <div class="introduction-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque dapibus ornare tortor,
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

</section>
<?php get_footer('shop');
