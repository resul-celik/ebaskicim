<?php $base_url = $args["base_url"] ?? '/'; ?>


<div class="w-full flex flex-col gap-10">
    <h2 class="paragraph-lg paragraph-bold text-gray-900">Kategoriler</h2>
    <div class="w-full flex flex-row gap-5 flex-wrap">
        <?php

        $terms = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));

        $currentCat = get_queried_object();
        $currentCatSlug = ($currentCat instanceof WP_Term) ? $currentCat->slug : '';

        foreach ($terms as $term) {
            if ($term->slug === "uncategorized") continue;
            $term_link = get_term_link($term);
            echo ebs_get_filter_tag([
                "text" => $term->name,
                "active" => $currentCatSlug === $term->slug,
                "url" => $term_link
            ]);
        }

        ?>
    </div>
</div>
<?php if (!empty($args["taxonomies"])) : ?>
    <div class="w-full flex flex-col gap-10">
        <h2 class="paragraph-lg paragraph-bold text-gray-900">Özellikler</h2>
        <div class="flex flex-col">
            <?php foreach ($args["taxonomies"] as $attribute) : ?>
                <?php
                $attributeName = $attribute["name"];
                $attributeSlug = $attribute["slug"];
                $getAttribute = isset($_GET[$attributeSlug]) ? sanitize_text_field($_GET[$attributeSlug]) : '';
                ?>
                <details class="group/filter-accordion border-b-1 border-gray-200 last:border-none" <?php echo $getAttribute ? "open" : "" ?>>
                    <summary class="flex flex-row items-center justify-between py-15 paragraph-md paragraph-medium text-gray-900 select-none cursor-pointer">
                        <?php echo esc_html($attributeName); ?>
                        <i class="icon icon-chevron-down"></i>
                    </summary>
                    <?php if (!empty($attribute["terms"])) : ?>
                        <div class="w-full flex flex-row gap-5 flex-wrap pb-10">
                            <?php
                            echo ebs_get_filter_tag([
                                "text" => "Tümü",
                                "active" => !$getAttribute,
                                "url" => $base_url
                            ]);
                            ?>
                            <?php foreach ($attribute["terms"] as $term) : ?>
                                <?php
                                $filter_url = add_query_arg($attributeSlug, $term["slug"]);
                                $filter_active = $getAttribute === $term["slug"];

                                echo ebs_get_filter_tag([
                                    "text" => $term["name"],
                                    "active" => $filter_active,
                                    "url" => $filter_url
                                ]);
                                ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<div class="w-full flex flex-col gap-10">
    <h2 class="paragraph-lg paragraph-bold text-gray-900">Sıralama</h2>
    <div class="w-full flex flex-row gap-5 flex-wrap pb-10">
        <?php
        $currentOrder = isset($_GET["order"]) ? sanitize_text_field($_GET["order"]) : '';
        $ascUrl = add_query_arg("order", "ASC");
        $bestUrl = add_query_arg("order", "best_seller");
        $priceAscUrl = add_query_arg("order", "price_asc");
        $priceDescUrl = add_query_arg("order", "price_desc");
        echo ebs_get_filter_tag([
            "text" => "Yeniden Eskiye",
            "active" => !$currentOrder,
            "url" => $base_url
        ]);
        echo ebs_get_filter_tag([
            "text" => "Eskiden Yeniye",
            "active" => $currentOrder === "ASC",
            "url" => $ascUrl
        ]);
        echo ebs_get_filter_tag([
            "text" => "Çok Satan",
            "active" => $currentOrder === "best_seller",
            "url" => $bestUrl
        ]);
        echo ebs_get_filter_tag([
            "text" => "Artan Fiyat",
            "active" => $currentOrder === "price_asc",
            "url" => $priceAscUrl
        ]);
        echo ebs_get_filter_tag([
            "text" => "Azalan Fiyat",
            "active" => $currentOrder === "price_desc",
            "url" => $priceDescUrl
        ]);
        ?>
    </div>
</div>