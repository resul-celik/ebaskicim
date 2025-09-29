<?php

function account_drawer_menu_content()
{ ?>
    <div class="w-full flex items-center justify-center px-20 pb-20">
        <a href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")); ?>" class="w-full p-20 flex flex-row items-center justify-start bg-gray-100 rounded-[10px] gap-10 hover:bg-gray-200">
            <div class="account-button w-[70px] h-[70px] flex items-center justify-center bg-primary-400 text-[30px] rounded-full select-none cursor-pointer shrink-0 grow-0">
                <?php
                $user = wp_get_current_user();
                $display_name = $user->display_name;

                echo mb_substr($display_name, 0, 1);
                ?>
            </div>
            <div class="flex flex-col gap-4 items-start grow-1">
                <div class="flex flex-row items-center justify-start gap-5">
                    <div class="paragraph-mg paragraph-bold text-gray-900"><?php echo wp_get_current_user()->display_name; ?></div>
                    <?php if (current_user_can('kurumsal_uye')) : ?>
                        <?php echo get_template_part('components/corporate-badge'); ?>
                    <?php endif; ?>
                </div>
                <div class="paragraph-mg paragraph-regular text-gray-600"><?php echo wp_get_current_user()->user_email; ?></div>
            </div>
            <i class="icon icon-chevron-right"></i>
        </a>
    </div>
    <nav class="w-full flex flex-col px-20 grow-1" role="navigation">
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
            <?php if ($endpoint != 'downloads' && $endpoint != 'orders' && $endpoint != 'customer-logout') : ?>
                <li class="w-full">
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" class="w-full flex flex-row items-center justify-between px-20 py-15 hover:bg-gray-100 rounded-[10px] paragraph-md paragraphy-regular text-gray-900">
                        <?php

                        if ($endpoint == 'dashboard') {

                            echo "Siparişlerim";
                        } else {

                            echo esc_html($label);
                        }

                        ?>
                        <i class="icon icon-chevron-right"></i>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
    <div class="w-full p-20 flex items-center justify-start border-t border-gray-200 gap-10">
        <?
        $buttonArgs = array(
            "text" => "Çıkış yap",
            "leadingIcon" => "logout",
            "url" => wp_logout_url(home_url()),
            "hierarchy" => "link",
            "destructive" => true
        );
        echo get_button($buttonArgs); ?>
    </div>
<?php } ?>