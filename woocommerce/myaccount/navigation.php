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

$current_user = wp_get_current_user();
$display_name = $current_user->display_name ?: $current_user->user_login;
$is_kurumsal  = current_user_can('kurumsal');

?>

<nav class="woocommerce-MyAccount-navigation account-nav w-full md:max-w-350 flex flex-col p-25 bg-gray-100 gap-20 rounded-[15px] items-center" aria-label="<?php esc_html_e('Account pages', 'woocommerce'); ?>">
	<div class="w-full flex flex-col items-center gap-24">
		<div class="w-80 h-80 flex items-center justify-center bg-primary-400 text-[30px] rounded-full uppercase">
			<?php echo ebs_get_avatar(); ?>
		</div>
		<div class="flex flex-col gap-4 items-center">
			<div class="flex flex-row items-center justify-center gap-5 paragraph-2xl paragraph-medium text-gray-900">
				<?php echo esc_html($display_name); ?>
				<?php if ($is_kurumsal) : ?>
					<?php get_template_part('components/corporate-badge'); ?>
				<?php endif; ?>
			</div>
			<?php if ($current_user->user_email) : ?>
				<div class="paragraph-md paragraph-regular text-gray-700">
					<?php echo esc_html($current_user->user_email); ?>
				</div>
			<?php endif; ?>
			<?php if ($is_kurumsal) : ?>
				<p class="paragraph-xs paragraph-medium text-primary-600">Tüm ürünlerde %<?php echo esc_html(apply_filters('ebs_kurumsal_discount_percentage', 0)); ?> kurumsal indirim</p>
			<?php endif; ?>
		</div>
	</div>
	<ul class="w-full flex flex-col">
		<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<?php if ($endpoint !== 'customer-logout' && $endpoint !== 'dashboard' && $endpoint !== 'downloads') : ?>
				<li class="w-full flex border-b border-gray-400 last:border-0 hover:border-primary-500 <?php echo esc_attr(wc_get_account_menu_item_classes($endpoint)); ?>">
					<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" class="w-full flex flex-row py-12 justify-between items-center paragraph-lg paragraph-medium text-gray-900 hover:text-primary-500" <?php echo is_wc_endpoint_url($endpoint) ? 'aria-current="page"' : ''; ?>>
						<?php echo esc_html($label); ?>
						<i class="icon icon-arrow-right"></i>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<a href="<?php echo esc_url(wc_get_account_endpoint_url('customer-logout')); ?>" class="<?php echo esc_attr(wc_get_account_menu_item_classes('customer-logout')); ?>" <?php echo is_wc_endpoint_url('customer-logout') ? 'aria-current="page"' : ''; ?>>
		<?php echo get_button([
			"text"        => "Çıkış Yap",
			"type"        => "submit",
			"name"        => "customer-logout",
			"value"       => "Çıkış Yap",
			"hierarchy"   => "link",
			"leadingIcon" => "logout",
			"destructive" => true,
		]); ?>
	</a>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>