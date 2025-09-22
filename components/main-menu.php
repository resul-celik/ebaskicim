<?php $menu_items = wp_get_nav_menu_items('header'); ?>

<nav class="w-full flex fle-row justify-start border-b border-gray-200 px-[20px]" role="menu">
    <ul class="w-full flex fle-row justify-start">
        <?php if ($menu_items) : ?>
            <?php foreach ($menu_items as $menu_item) : ?>
                <li class="flex flex-row px-[20px] py-[15px] gap-[6px] text-lg">
                    <?php echo esc_html($menu_item->title); ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php

        /* if ($all_categories) {

                foreach ($all_categories as $category) {

                    if ($category->category_parent == 0 && $category->slug != 'genel') {

                        $category_id = $category->term_id;

                        echo '<li class="menu-item main-menu-item" role="menuitem">';
                        echo '<a href="' . get_term_link($category->slug, 'product_cat') . '" class="main-menu-parent-category cat-' . $category->slug . '">' . $category->name . '</a>';
                        echo '<div class="main-menu-sub-categories-wrapper">';
                        echo '<div class="hidden-filling"></div>';
                        echo '<div class="sub-categories-container">';
                        echo '<div class="title parent-category-title">' . $category->name . '</div>';
                        echo '<div class="sub-category-items-wrapper">';

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

                        if ($sub_cats) {

                            foreach ($sub_cats as $sub_cat) {

                                $thumbnail_id = get_term_meta($sub_cat->term_id, 'thumbnail_id', true);
                                $image = wp_get_attachment_url($thumbnail_id);

                                if (!$image) {

                                    $image = get_template_directory_uri() . '/images/placeholders/no-image-placeholder.jpg';
                                }

                                echo '<a href="' . get_term_link($sub_cat->slug, 'product_cat') . '" class="sub-category-item sub-cat-' . $sub_cat->slug . '">';
                                echo ' <div class="sub-category-item-thumbnail">';
                                echo '<img src="' . $image . '" alt="' . $sub_cat->slug . '" />';
                                echo '</div>';
                                echo '<div class="sub-category-title">' . $sub_cat->name . '</div>';
                                echo '</a>';
                            }
                        }

                        echo '</div>';
                        echo '</div>'; // sub-categories-wrapper END
                        echo '</div>'; // main-menu-sub-categories-wrapper END
                        echo '</li>';
                    }
                }

                echo '<div class="menu-shadow"></div>';
            } */

        ?>
    </ul>
</nav>