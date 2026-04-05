<?php $menu_items = wp_get_nav_menu_items('header'); ?>

<nav class="w-full hidden md:flex fle-row justify-center items-center border-b border-gray-200 px-20 relative overflow-x-hidden" role="menu">
    <div id="main-nav-list" class="w-full max-w-[1920px] flex flex-row justify-start relative z-100 bg-white gap-4 overflow-x-auto cursor-grab select-none">
        <?php if ($menu_items) : ?>
            <?php foreach ($menu_items as $menu_item) : ?>
                <?php if ($menu_item->menu_item_parent) continue; ?>
                <a href="<?php echo $menu_item->url; ?>" data-item-id="<?php echo $menu_item->ID; ?>" class="main-menu-item flex flex-row px-20 py-15 gap-6 shrink-0 text-md select-none cursor-pointer relative">
                    <?php echo esc_html($menu_item->title); ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php

    function get_child_menus($menu_items, $parent_id = 0)
    {
        $child_menus = array();
        foreach ($menu_items as $menu_item) {
            if ($menu_item->menu_item_parent == $parent_id) {
                $child_menus[] = $menu_item;
                $child_menus = array_merge($child_menus, get_child_menus($menu_items, $menu_item->ID));
            }
        }
        return $child_menus;
    }
    ?>
    <?php if ($menu_items) : ?>
        <?php foreach ($menu_items as $menu) : ?>
            <?php if (!empty($child_menus = get_child_menus($menu_items, $menu->ID))) : ?>
                <div class="w-full max-w-[1920px] menu-content menu-content-<?php echo $menu->ID; ?> flex flex-col hidden p-40 gap-40 bg-white rounded-[15px] items-start justify-start shadow-xl absolute -bottom-5 z-99 translate-y-[100%]">
                    <h2 class="display-md text-gray-900"><?php echo esc_html($menu->title); ?></h2>
                    <div class="w-full flex flex-row gap-20">
                        <?php
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 4,
                            'post__in' => array_column($child_menus, 'object_id')
                        );
                        $products = new WP_Query($args);
                        if ($products->have_posts()) :
                            while ($products->have_posts()) : $products->the_post();
                                wc_get_template_part('content', 'product');
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                    <?php
                    $buttonArgs = array(
                        "text" => "Tümünü Gör",
                        "url" => esc_url($menu->url),
                        "trailingIcon" => "arrow-right"
                    );
                    echo get_button($buttonArgs);
                    ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</nav>