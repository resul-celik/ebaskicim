<div class="mobile-header mobile-view">
    <div class="mobile-search-wrapper hidden-ms-input">
        <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
            <input type="text" name="s" id="mobile-search" placeholder="Search..." inputmode="search" />
            <input type="hidden" value="submit" />
            <input type="hidden" name="post_type" value="product" />
        </form>
        <div class="mobile-search-button-wrapper">
            <i class="icon search-24"></i>
        </div>
    </div>
    <div class="mobile-header-left">
        <div class="menu-icon-wrapper">
            <i class="icon menu-24"></i>
        </div>
        <a href="<?php echo site_url(); ?>" class="logo header-top-item mobile-logo" role="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/images/ebaskicim-logo.png" alt="Ebaskıcım logosu" />
        </a>
    </div>
    <div class="mobile-header-right">
        <div class="button secondary-button icon-only icon-only-button-small mobile-search-icon">
            <i class="icon search-24"></i>
        </div>
        <div class="header-cart-button-wrapper">
            <div class="header-cart-total-count"><?php echo $cartcount; ?></div>
            <a href="<?php echo wc_get_cart_url(); ?>" class="button secondary-button icon-only icon-only-button-small"><i class="icon cart-24"></i></a>
        </div>
    </div>
</div>
<div class="hidden-side-menu-container hidden-left-side-menu hidden-mobile-side-menu hide-left-side-menu">
    <div class="hidden-side-menu-close-button">
        <i class="icon close-24"></i>
    </div>
    <div class="hidden-side-menu-wrapper">
        <div class="hidden-side-menu-buttons-wrapper">
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="button secondary-button button-small">
                    Hesabım
                    <i class="icon user-24"></i>
                </a>
                <div class="button ghost-button text-only text-only-button-small">
                    Çıkış yap
                </div>
            <?php else : ?>
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="button secondary-button text-only text-only-button-small">Giriş yap / Kaydol</a>
            <?php endif; ?>
        </div>
        <div class="title hidden-side-menu-title">Kategoriler</div>
        <div class="menu-accordion-wrapper">
            <?php if ($all_categories) : ?>
                <?php foreach ($all_categories as $category) : ?>
                    <?php if ($category->category_parent == 0) : ?>
                        <div class="menu-accordion-title"><?php echo $category->name; ?></div>
                        <div class="menu-accordion-content content-open">
                            <div class="menu-accordion">
                                <ul>
                                    <?php

                                    $category_id = $category->term_id;

                                    $args2 = array(

                                        'taxonomy'     => $taxonomy,
                                        'child_of'     => 0,
                                        'parent'       => $category_id,
                                        'orderby'      => $orderby,
                                        'show_count'   => $show_count,
                                        'pad_counts'   => $pad_counts,
                                        'hierarchical' => $hierarchical,
                                        'title_li'     => $title,
                                        'hide_empty'   => $empty

                                    );

                                    $sub_cats = get_categories($args2);

                                    if ($sub_cats) :
                                        foreach ($sub_cats as $sub_cat) : ?>
                                            <li class="menu-item">
                                                <a href=""><?php echo $sub_cat->name; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="hidden-side-menu-shadow"></div>
</div>