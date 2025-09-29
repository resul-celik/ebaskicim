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

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation account-nav w-full md:max-w-350 flex flex-col p-25 bg-gray-100 gap-20 rounded-[15px] items-center" aria-label="<?php esc_html_e('Account pages', 'woocommerce'); ?>">
	<div class="w-full flex flex-col items-center gap-24">
		<div class="w-80 h-80 flex items-center justify-center bg-primary-400 text-[30px] rounded-full">
			<?php
			$user = wp_get_current_user();
			$display_name = $user->display_name;

			echo mb_substr($display_name, 0, 1);
			?>
		</div>
		<div class="flex flex-col gap-4 items-center">
			<div class="paragraph-2xl paragraph-medium text-gray-900">
				<?php
				$current_user = wp_get_current_user();
				if ($current_user->display_name) {
					echo esc_html($current_user->display_name);
				} else {
					echo esc_html($current_user->user_login);
				}
				?>
			</div>
			<div class="paragraph-md paragraph-regular text-gray-700">
				<?php
				if ($current_user->user_email) {
					echo esc_html($current_user->user_email);
				}
				?>
			</div>
		</div>
	</div>
	<ul class="w-full flex flex-col">
		<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<?php if ($endpoint !== 'customer-logout' && $endpoint !== 'dashboard' && $endpoint !== 'downloads') : ?>
				<li class="w-full flex border-b border-gray-400 last:border-0 hover:border-primary-500 <?php echo wc_get_account_menu_item_classes($endpoint); ?>">
					<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" class="w-full flex flex-row py-12 justify-between items-center paragraph-lg paragraph-medium text-gray-900 hover:text-primary-500 " <?php echo is_wc_endpoint_url($endpoint) ? 'aria-current="page"' : ''; ?>>
						<?php echo esc_html($label); ?>
						<i class="icon icon-arrow-right"></i>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<a href="<?php echo esc_url(wc_get_account_endpoint_url('customer-logout')); ?>" class="<?php echo wc_get_account_menu_item_classes('customer-logout'); ?>" <?php echo is_wc_endpoint_url('customer-logout') ? 'aria-current="page"' : ''; ?>>
		<?
		$buttonArgs = array(
			"text" => "Çıkış Yap",
			"type" => "submit",
			"name" => "customer-logout",
			"value" => "Çıkış Yap",
			"hierarchy" => "link",
			"leadingIcon" => "logout"
		);
		?>
		<?php echo get_button($buttonArgs); ?>
	</a>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>