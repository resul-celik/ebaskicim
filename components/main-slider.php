<?php

defined('ABSPATH') || exit;

$slides = [];
for ($i = 1; $i <= 5; $i++) {
    $image = get_theme_mod("ebs_slider_{$i}_image", '');
    if (!$image) continue;
    $slides[] = [
        'image' => $image,
        'url'   => get_theme_mod("ebs_slider_{$i}_url", ''),
    ];
}

if (empty($slides)) return;

?>
<section class="w-full max-w-[1920px] p-20 flex flex-col items-center justify-center">
    <div class="main-slider w-full aspect-18/6 overflow-hidden rounded-[15px] relative group">
        <div class="main-slider-wrapper w-full aspect-18/6 relative box-content flex flex-row justify-start items-center">
            <?php foreach ($slides as $slide) : ?>
                <div class="main-slider-item w-full aspect-18/6 shrink-0">
                    <?php if ($slide['url']) : ?>
                        <a href="<?php echo esc_url($slide['url']); ?>">
                            <img src="<?php echo esc_url($slide['image']); ?>" alt="" loading="lazy">
                        </a>
                    <?php else : ?>
                        <img src="<?php echo esc_url($slide['image']); ?>" alt="" loading="lazy">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="main-slider-pagination"></div>
        <button class="main-slider-nav-btn main-slider-nav-btn--prev" aria-label="Önceki slayt">
            <i class="icon icon-chevron-left"></i>
        </button>
        <button class="main-slider-nav-btn main-slider-nav-btn--next" aria-label="Sonraki slayt">
            <i class="icon icon-chevron-right"></i>
        </button>
    </div>
</section>
