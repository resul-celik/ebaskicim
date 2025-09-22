<section class="footer">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-3 desktop-view">
                <div class="title footer-title">Ebaskıcım</div>
                <?php wp_nav_menu( array( 'theme_location' => 'footer_menu_1', 'container_class' => 'footer-menu' ) ); ?>
            </div>
            <div class="col-lg-3 desktop-view">
                <div class="title footer-title">Müşteri hizmetleri</div>
                <?php wp_nav_menu( array( 'theme_location' => 'footer_menu_2', 'container_class' => 'footer-menu' ) ); ?>
            </div>
            <div class="col-lg-3 desktop-view">
                <div class="title footer-title">Yasal</div>
                <?php wp_nav_menu( array( 'theme_location' => 'footer_menu_3', 'container_class' => 'footer-menu' ) ); ?>
            </div>
            <div class="col-lg-3 desktop-view">
                <div class="social-media-wrapper">
                    <div class="button secondary-button icon-only icon-only-button-small social-media-item">
                        <i class="icon facebook-24"></i>
                    </div>
                    <div class="button secondary-button icon-only icon-only-button-small social-media-item">
                        <i class="icon instagram-24"></i>
                    </div>
                    <div class="button secondary-button icon-only icon-only-button-small social-media-item">
                        <i class="icon youtube-24"></i>
                    </div>
                    <div class="button secondary-button icon-only icon-only-button-small social-media-item">
                        <i class="icon whatsapp-24"></i>
                    </div>
                </div>
                <div class="safety-shopping-badge">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/secure-shopping-badge.png" />
                </div>
            </div>
            <div class="menu-accordion-wrapper mobile-view">
                <div class="menu-accordion-title">Ebaskıcım</div>
                <div class="menu-accordion-content content-open">
                    <?php wp_nav_menu( array( 'theme_location' => 'footer_menu_1', 'container_class' => 'menu-accordion' ) ); ?>
                </div>
                <div class="menu-accordion-title">Müşteri hizmetleri</div>
                <div class="menu-accordion-content content-open">
                    <?php wp_nav_menu( array( 'theme_location' => 'footer_menu_2', 'container_class' => 'menu-accordion' ) ); ?>
                </div>
                <div class="menu-accordion-title">Yasal</div>
                <div class="menu-accordion-content content-open">
                    <?php wp_nav_menu( array( 'theme_location' => 'footer_menu_3', 'container_class' => 'menu-accordion' ) ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-wrapper">
        <div class="container-xl">
            <div class="row footer-bottom-row">
                <div class="footer-bottom-left">
                    <span class="credits">&copy; 2021 Ebaskıcım</span>
                </div>
                <div class="footer-bottom-right">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/payment-methods-badge.png" />
                </div>
            </div>
        </div>
    </div>
</section>
<?php wp_footer(); ?>
    </body>
</html>