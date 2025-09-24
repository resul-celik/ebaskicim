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

if (! defined('ABSPATH')) {
	exit;
}

$button = new Button();

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation account-nav" aria-label="<?php esc_html_e('Account pages', 'woocommerce'); ?>">
	<div class="account-short-info">
		<div class="user-avatar-letters">
		<?php
                        $user = wp_get_current_user();
                        $display_name = $user->display_name;

                        echo mb_substr($display_name, 0, 1);
                        ?>
		</div>
		<div class="account-name">
			<?php
			$current_user = wp_get_current_user();
			if ($current_user->display_name) {
				echo esc_html($current_user->display_name);
			} else {
				echo esc_html($current_user->user_login);
			}
			?>
		</div>
		<a href="<?php echo esc_url(wc_get_account_endpoint_url('customer-logout')); ?>" class="<?php echo wc_get_account_menu_item_classes('customer-logout'); ?>" <?php echo is_wc_endpoint_url('customer-logout') ? 'aria-current="page"' : ''; ?>>
			<?php echo $button->get_button(__('Log Out', 'junobjects'), 'primary-button button-sm secondary-black-button '); ?>
		</a>
	</div>
	<ul class="account-nav__list">
		<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<?php if ($endpoint !== 'customer-logout' && $endpoint !== 'orders' && $endpoint !== 'downloads') : ?>
				<li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
					<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" class="tag" <?php echo is_wc_endpoint_url($endpoint) ? 'aria-current="page"' : ''; ?>>
						<?php _e(esc_html($label), 'junobjects'); ?>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>