<?php $footer = wp_get_nav_menu_items('footer'); ?>
<?php $footer2 = wp_get_nav_menu_items('footer2'); ?>
<?php $footer3 = wp_get_nav_menu_items('footer3'); ?>

<footer class="w-full flex flex-col">
    <div class="w-full flex items-center justify-center border-t border-gray-200 py-36">
        <div class="w-full max-w-[1920px] grid grid-cols-12 px-20">
            <div class="col-span-10 grid grid-cols-10">
                <?php dynamic_sidebar('footer-menus'); ?>
            </div>
            <div class="col-span-2 flex flex-col items-end justify-start gap-20">
                <div class="flex flex-row gap-10">
                    <div class="w-40 h-40 flex items-center justify-center bg-gray-200 rounded-full">
                        <?php echo ebs_get_icon('instagram'); ?>
                    </div>
                    <div class="w-40 h-40 flex items-center justify-center bg-gray-200 rounded-full">
                        <?php echo ebs_get_icon('facebook'); ?>
                    </div>
                    <div class="w-40 h-40 flex items-center justify-center bg-gray-200 rounded-full">
                        <?php echo ebs_get_icon('youtube'); ?>
                    </div>
                </div>
                <div class="safety-shopping-badge">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ssl.svg" />
                </div>
            </div>
        </div>
    </div>
    <div class="w-full flex flex-col items-center justify-center border-t border-gray-200 py-15">
        <div class="w-full max-w-[1920px] flex flex-row items-center justify-between px-20">
            <div class="paragraph-xs text-gray-500">&copy; 2026 Ebaskıcım</div>
            <div class="flex flex-row gap-10">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/iyzico.svg" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mastercard.svg" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/visa.svg" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/troy.svg" />
            </div>
        </div>
    </div>
</footer>