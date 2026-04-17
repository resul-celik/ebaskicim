<?php
$footer_columns = [
    ['menu' => 'footer',  'title_mod' => 'eb_footer_col_1_title'],
    ['menu' => 'footer2', 'title_mod' => 'eb_footer_col_2_title'],
    ['menu' => 'footer3', 'title_mod' => 'eb_footer_col_3_title'],
];
?>
<?php
$social_platforms = [
    'instagram' => 'https://www.instagram.com/',
    'facebook'  => 'https://www.facebook.com/',
    'youtube'   => 'https://www.youtube.com/@',
    'twitter'   => 'https://x.com/',
    'linkedin'  => 'https://www.linkedin.com/in/',
    'pinterest' => 'https://www.pinterest.com/',
];
$social_links = array_filter(array_map(function ($icon, $base_url) {
    $username = get_theme_mod('eb_' . $icon, '');
    if (empty($username)) return null;
    return ['icon' => $icon, 'url' => $base_url . ltrim($username, '/')];
}, array_keys($social_platforms), array_values($social_platforms)));

$locations = get_nav_menu_locations();
?>
<footer class="w-full flex flex-col">
    <div class="w-full flex items-center justify-center border-t border-gray-200 py-36">
        <div class="w-full max-w-[1920px] flex flex-col gap-0 px-20">

            <div class="w-full flex flex-col md:grid md:grid-cols-12 gap-0 md:gap-20">

                <div class="md:col-span-10 flex flex-col md:grid md:grid-cols-10 md:gap-20">
                    <?php foreach ($footer_columns as $col) :
                        $title        = get_theme_mod($col['title_mod'], '');
                        $location_key = $col['menu'];
                        $has_menu     = !empty($locations[$location_key]);
                        if (!$title && !$has_menu) continue;
                    ?>
                        <div class="hidden md:flex md:col-span-3 flex-col gap-16">
                            <?php if ($title) : ?>
                                <h3 class="paragraph-md paragraph-bold text-gray-900"><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>
                            <?php wp_nav_menu([
                                'theme_location' => $location_key,
                                'container'      => false,
                                'menu_class'     => 'footer-menu-list',
                                'fallback_cb'    => false,
                            ]); ?>
                        </div>

                        <?php if ($title || $has_menu) : ?>
                            <details class="footer-mobile-accordion md:hidden border-b border-gray-100">
                                <summary class="w-full flex flex-row items-center justify-between py-16 cursor-pointer list-none">
                                    <span class="paragraph-md paragraph-bold text-gray-900"><?php echo esc_html($title); ?></span>
                                    <i class="icon icon-chevron-down text-gray-400 footer-accordion-icon"></i>
                                </summary>
                                <div class="pb-16">
                                    <?php wp_nav_menu([
                                        'theme_location' => $location_key,
                                        'container'      => false,
                                        'menu_class'     => 'footer-menu-list',
                                        'fallback_cb'    => false,
                                    ]); ?>
                                </div>
                            </details>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="md:col-span-2 flex flex-col items-center md:items-end justify-center md:justify-start gap-20 pt-24 md:pt-0">
                    <?php if (!empty($social_links)) : ?>
                        <div class="flex flex-row gap-10">
                            <?php foreach ($social_links as $social) : ?>
                                <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" class="w-40 h-40 flex items-center justify-center bg-gray-200 hover:bg-primary-400 rounded-full">
                                    <?php echo ebs_get_icon($social['icon']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="safety-shopping-badge">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ssl.svg" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="w-full flex flex-col items-center justify-center border-t border-gray-200 py-15">
        <div class="w-full max-w-[1920px] flex flex-row items-center justify-between gap-12 px-20">
            <div class="paragraph-xs text-gray-500">&copy; 2026 Ebaskıcım</div>
            <div class="flex flex-row items-center gap-20">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/paytr.svg" class="h-12 md:h-20" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mastercard.svg" class="h-15 md:h-20" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/visa.svg" class="h-13 md:h-20" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/troy.svg" class="h-15 md:h-20" />
            </div>
        </div>
    </div>
</footer>