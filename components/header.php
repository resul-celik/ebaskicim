<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<header class="w-full flex flex-col bg-white" role="heading">
    <div class="w-full flex flex-row items-center justify-center py-15 border-b border-gray-200">
        <div class="w-full max-w-[1920px] flex flex-row items-center justify-between px-20">
            <div class="flex flex-row gap-20">
                <a href="<?php echo site_url(); ?>" role="logo">
                    <?php get_template_part('components/logo'); ?>
                </a>
                <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-field hidden md:flex flex-row bg-gray-100 rounded-full items-center pl-20 pr-15 h-45" role="search">
                    <input type="text" name="s" class="block grow-1 shrink-1 placeholder:text-gray-600" placeholder="Ara" />
                    <input type="hidden" value="submit" />
                    <input type="hidden" name="post_type" value="product" />
                    <button class="flex items-center justify-center text-gray-600" type="submit">
                        <i class="icon icon-search"></i>
                    </button>
                </form>
            </div>
            <div class="flex flex-row gap-7">
                <? if (!is_cart()) : ?>
                    <div class="cart-button relative">
                        <div class="absolute z-10 top-0 right-0">
                            <? $badgeText = WC()->cart->get_cart_contents_count() > 99 ? '99+' : WC()->cart->get_cart_contents_count(); ?>
                            <?php echo ebs_get_badge($badgeText); ?>
                        </div>

                        <div class="header-button cursor-pointer"><span class="header-button-text">Sepetim</span><i class="icon icon-cart"></i></div>
                    </div>
                <? endif; ?>
                <?php if (is_user_logged_in()) : ?>
                    <?php echo ebs_get_avatar(['class' => "account-button w-45 h-45 text-xl cursor-pointer"]); ?>
                <?php else : ?>
                    <a href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")); ?>" class="header-button"><span class="header-button-text">Giriş yap / Kaydol</span><i class="icon icon-person"></i></a>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <?php get_template_part('components/main-menu'); ?>
</header>
<?php
if (!is_cart()) {
    echo get_drawer_menu([
        'wrapperClass' => 'cart-drawer-menu',
        'buttonClass'  => 'cart-button',
        'width'        => 'w-full md:w-600',
        'title'        => 'Sepetim',
        'icon'         => 'cart',
        'badgeCount'   =>  WC()->cart->get_cart_contents_count()
    ], "woocommerce_mini_cart");
}
?>
<?php echo get_drawer_menu([
    'wrapperClass' => 'account-drawer-menu',
    'buttonClass'  => 'account-button',
    'width'        => 'w-full md:w-470',
    'title'        => 'Hesabım',
    'icon'         => 'person'
], "account_drawer_menu_content"); ?>
<div class="dimness w-full h-screen inset-0 fixed bg-black/20 z-998" onclick="close_drawer()"></div>
<?php // echo get_permalink(get_option("woocommerce_myaccount_page_id")); 
?>