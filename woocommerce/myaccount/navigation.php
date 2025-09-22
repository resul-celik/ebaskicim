<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$current_user = wp_get_current_user();

?>

<nav class="woocommerce-MyAccount-navigation">
    <div class="profile-name">
        <span><?php echo $current_user->display_name; ?></span>
        <?php if (current_user_can('kurumsal_uye')) : ?>
        <span class="ebaskicim-corporating-badge">
            <div class="tooltip">
                <div class="tooltiptext">Kurumsal üye</div>
                <img src="<?php echo get_template_directory_uri(); ?>/images/ebaskicim-badge.png" />
            </div>
        </span>
        <?php endif; ?>
    </div>
	<ul class="profile-navigation" role="navigation">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <?php if ($endpoint != 'downloads' && $endpoint != 'orders') : ?>
                <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                        <?php 

                            if ($endpoint == 'dashboard') {

                                echo "Siparişlerim";

                            } else {

                                echo esc_html($label);

                            }

                        ?>
                    </a>
                </li>
            <?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>