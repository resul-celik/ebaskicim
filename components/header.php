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
                <div class="cart-button relative">
                    <div class="absolute z-10 top-0 right-0">
                        <? $badgeText = WC()->cart->get_cart_contents_count() > 99 ? '99+' : WC()->cart->get_cart_contents_count(); ?>
                        <?php echo ebs_get_badge($badgeText); ?>
                    </div>
                    <div class="header-button cursor-pointer"><i class="icon icon-cart"></i></div>
                </div>
                <?php if (is_user_logged_in()) : ?>
                    <div class="account-button w-[45px] h-[45px] flex items-center justify-center bg-primary-400 text-xl rounded-full select-none cursor-pointer">
                        <?php
                        $user = wp_get_current_user();
                        $display_name = $user->display_name;

                        echo mb_substr($display_name, 0, 1);
                        ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")); ?>" class="header-button"><span class="header-button-text">Giriş yap / Kaydol</span><i class="icon icon-person"></i></a>
                <?php endif; ?>

            </div>
        </div>
        <?php get_template_part('components/main-menu'); ?>
    </div>
</header>
<?php
$cartArgs = array(
    'customClass' => 'cart-drawer-menu',
    'width' => 'w-1/4',
    'title' => 'Sepetim',
    'icon' => 'icon-cart',
    'badgeCount' =>  WC()->cart->get_cart_contents_count()
)
?>
<?php echo get_drawer_menu(array('customClass' => 'account-drawer-menu', 'width' => 'w-2/10', 'title' => 'Hesabım', 'icon' => 'icon-person'), "account_drawer_menu_content"); ?>
<?php echo get_drawer_menu($cartArgs, "woocommerce_mini_cart"); ?>
<div class="dimness w-full h-screen inset-0 fixed bg-black/20 z-998">
</div>
<?php // echo get_permalink(get_option("woocommerce_myaccount_page_id")); 
?>