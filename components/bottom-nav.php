<?php
defined('ABSPATH') || exit;

$bn_cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$bn_badge_text = $bn_cart_count > 99 ? '99+' : (string) $bn_cart_count;
?>

<nav class="bottom-nav md:hidden" aria-label="Alt Navigasyon">
    <div class="bottom-nav-inner">

        <a href="<?php echo esc_url(site_url()); ?>"
           class="bottom-nav-item <?php echo is_front_page() ? 'bottom-nav-item--active' : ''; ?>"
           aria-label="Anasayfa">
            <i class="icon icon-home"></i>
            <span class="bottom-nav-label">Anasayfa</span>
        </a>

        <button type="button" class="bottom-nav-item categories-nav-button" aria-label="Kategoriler">
            <i class="icon icon-grid"></i>
            <span class="bottom-nav-label">Kategoriler</span>
        </button>

        <button type="button" class="bottom-nav-item mobile-search-btn" aria-label="Arama">
            <i class="icon icon-search"></i>
            <span class="bottom-nav-label">Arama</span>
        </button>

        <?php if (!is_cart()) : ?>
            <button type="button" class="bottom-nav-item cart-button" aria-label="Sepetim">
                <span class="bottom-nav-icon-wrap">
                    <?php if ($bn_cart_count > 0) : ?>
                        <span class="bottom-nav-badge"><?php echo esc_html($bn_badge_text); ?></span>
                    <?php endif; ?>
                    <i class="icon icon-cart"></i>
                </span>
                <span class="bottom-nav-label">Sepetim</span>
            </button>
        <?php else : ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
               class="bottom-nav-item bottom-nav-item--active"
               aria-label="Sepetim">
                <i class="icon icon-cart"></i>
                <span class="bottom-nav-label">Sepetim</span>
            </a>
        <?php endif; ?>

        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
           class="bottom-nav-item <?php echo is_account_page() ? 'bottom-nav-item--active' : ''; ?>"
           aria-label="Hesabım">
            <i class="icon icon-person"></i>
            <span class="bottom-nav-label">Hesabım</span>
        </a>

    </div>
</nav>

<?php
echo get_drawer_menu([
    'wrapperClass' => 'categories-drawer-menu',
    'buttonClass'  => 'categories-nav-button',
    'width'        => 'w-full md:w-470',
    'title'        => 'Kategoriler',
    'icon'         => 'grid',
], 'ebs_categories_drawer_content');

// Mobile search overlay
?>
<div class="mobile-search-overlay" id="mobile-search-overlay" hidden aria-modal="true" role="dialog">
    <div class="mobile-search-header">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mobile-search-form">
            <i class="icon icon-search text-gray-400 flex-shrink-0"></i>
            <input
                type="search"
                name="s"
                id="mobile-search-input"
                class="mobile-search-input"
                placeholder="Ürün, kategori ara..."
                autocomplete="off"
                enterkeyhint="search"
            >
            <input type="hidden" name="post_type" value="product">
        </form>
        <button type="button" class="mobile-search-close" id="mobile-search-close" aria-label="Kapat">
            <i class="icon icon-close"></i>
        </button>
    </div>
</div>
<?php

function ebs_categories_drawer_content()
{
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => 0,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    if (empty($categories) || is_wp_error($categories)) {
        echo '<p class="px-20 text-gray-500">Kategori bulunamadı.</p>';
        return;
    }
    ?>
    <ul class="w-full flex flex-col overflow-y-auto px-20 pb-20 m-0 list-none">
        <?php foreach ($categories as $cat) : ?>
            <li class="w-full m-0 p-0">
                <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                   class="w-full flex flex-row items-center justify-between py-15 border-b border-gray-100 paragraph-md text-gray-900 hover:text-primary-500 no-underline">
                    <span><?php echo esc_html($cat->name); ?></span>
                    <i class="icon icon-chevron-right text-gray-400"></i>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
}
?>
