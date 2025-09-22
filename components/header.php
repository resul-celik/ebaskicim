<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<header class="w-full flex items-center justify-center" role="heading">
    <div class="w-full max-w-[1920px] flex flex-col">
        <div class="w-full flex flex-row items-center justify-between px-[20px] py-[15px] border-b border-gray-200">
            <div class="flex flex-row gap-[20px]">
                <a href="<?php echo site_url(); ?>" role="logo">
                    <?php get_template_part('components/logo'); ?>
                </a>
                <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-field flex flex-row bg-gray-100 rounded-full items-center pl-[20px] pr-[15px] h-[45px]" role="search">
                    <input type="text" name="s" class="block grow-1 shrink-1 placeholder:text-gray-600" placeholder="Ara" />
                    <input type="hidden" value="submit" />
                    <input type="hidden" name="post_type" value="product" />
                    <button class="flex items-center justify-center text-gray-600" type="submit">
                        <i class="icon icon-search"></i>
                    </button>
                </form>
            </div>
            <div class="flex flex-row gap-[7px]">
                <div class="relative">
                    <div class="w-auto h-[20px] min-w-[20px] flex items-center justify-center absolute z-10 top-0 right-0 bg-primary-400 rounded-full text-xs font-bold"><?php echo count(WC()->cart->get_cart()); ?></div>
                    <a href="<?php echo wc_get_cart_url(); ?>" class="header-button"><i class="icon icon-cart"></i></a>
                </div>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")); ?>" class="w-[45px] h-[45px] flex items-center justify-center bg-primary-400 text-xl rounded-full">
                        <?php
                        $user = wp_get_current_user();
                        $display_name = $user->display_name;

                        echo mb_substr($display_name, 0, 1);
                        ?>
                    </a>
                <?php else : ?>
                    <a href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")); ?>" class="header-button"><span class="header-button-text">Giriş yap / Kaydol</span><i class="icon icon-person"></i></a>
                <?php endif; ?>

            </div>
        </div>
        <?php get_template_part('components/main-menu'); ?>
    </div>
</header>
<div class="hidden-side-menu-container hidden-right-side-menu account-side-menu hide-right-side-menu">
    <div class="hidden-side-menu-close-button">
        <i class="icon close-24"></i>
    </div>
    <div class="hidden-side-menu-wrapper">
        <a href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")); ?>" class="go-to-profile-wrapper">
            <div class="account-username">
                <span class="au-username-span"><?php echo wp_get_current_user()->display_name; ?></span>
                <?php if (current_user_can('kurumsal_uye')) : ?>
                    <span class="ebaskicim-corporating-badge">
                        <div class="tooltip">
                            <div class="tooltiptext">Kurumsal üye</div>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/ebaskicim-badge.png" />
                        </div>
                    </span>
                <?php endif; ?>
            </div>
            <div class="got-to-profile">Profile git</div>
        </a>
        <nav class="side-menu-profile-navigation" role="navigation">
            <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
                <?php if ($endpoint != 'downloads' && $endpoint != 'orders') : ?>
                    <li class="side-menu-profile-navigation-item <?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
                            <?php

                            if ($endpoint == 'dashboard') {

                                echo "Siparişlerim";
                            } else {

                                echo esc_html($label);
                            }

                            ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    </div>
    <div class="hidden-side-menu-shadow"></div>
</div>