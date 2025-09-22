<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<h1 class="title main-title">Siparişlerim:</h1>

<?php if ( $has_orders ) : ?>
<div class="account-orders-wrapper row">
    <?php foreach ( $customer_orders->orders as $customer_order ) : 
    
        $order = wc_get_order($customer_order);
        $orderid = $order->get_id();
        $orderitems = $order->get_items();
        $orderColumn = wc_get_account_orders_columns();
        $actions = wc_get_account_orders_actions($order);

        //print_r($orderitems);
    
    
        foreach ($orderitems as $itemid => $itemval) :
    
            $itemProductId = $itemval->get_product_id();
            $itemProduct = $itemval->get_product();
            $itemProductName = $itemval->get_name();
            $attachment_id = $itemProduct->get_image_id();
            $statuscolor = ' style="background: #F1F3F5"';
    
            switch ($order->get_status()) {
                    
                case "pending" :
                    
                    $statuscolor = ' style="background: #F1F3F5"';
                    
                    break;
                    
                case "processing" :
                    
                    $statuscolor = ' style="background: #D9EEFF"';
                    
                    break;
                    
                case "on-hold" :
                    
                    $statuscolor = ' style="background: #FFE9C7"';
                    
                    break;
                    
                case "completed" :
                    
                    $statuscolor = ' style="background: #D7FFE9"';
                    
                    break;
                    
                case "cancelled" :
                    
                    $statuscolor = ' style="background: #FFD7D7"';
                    
                    break;
                    
                case "refunded" :
                    
                    $statuscolor = ' style="background: #F1F3F5"';
                    
                    break;
                    
                case "failed" :
                    
                    $statuscolor = ' style="background: #FFD7D7"';
                    
                    break;
                    
            }
    
    ?>
    <div class="col-lg-6 ebaskicim-order">
        <a href="<?php echo $actions['view']['url']; ?>">
            <div class="ebaskicim-order-thumbnail">
                <img src="<?php echo wp_get_attachment_image_src( $attachment_id, '500x500' )[0]; ?>">
            </div>
        </a>
        <div class="ebaskicim-order-title">
            <?php echo $itemProductName; ?>
        </div>
        <div class="ebaskicim-order-status">
            <div class="ebaskicim-order-small-title">Durum:</div>
            <div class="ebaskicim-order-value"<?php echo $statuscolor; ?>><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></div>
        </div>
        <div class="ebaskicim-order-price-and-number">
            <div class="ebaskicim-order-price">
                <div class="ebaskicim-order-small-title">Fiyat:</div>
                <div class="ebaskicim-order-value"><?php echo $order->get_formatted_order_total(); ?></div>
            </div>
            <div class="ebaskicim-order-number">
                <div class="ebaskicim-order-small-title">Sipariş numarası:</div>
                <div class="ebaskicim-order-value">#<?php echo $orderid; ?></div>
            </div>
        </div>
        <?php 
        
            if (!empty($actions)) {
                
                foreach ($actions as $key => $action) {
                    
                    echo '<a href="'.$action['url'].'" class="button';
                    
                    if ($key == "pay") {
                        
                        echo " primary-button ";
                        
                    } elseif ($key == "view") {
                        
                        echo " secondary-button ";
                        
                    } elseif ($key == "cancel") {
                        
                        echo " ghost-button "; 
                        
                    }
                    
                    echo 'text-only account-order-button '.sanitize_html_class( $key ).'">'.$action['name'].'</i></a>';
                    
                }
                
            }
        
        ?>
        
    </div>
    <?php endforeach; endforeach; ?>
</div>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button secondary-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>">
                    <?php esc_html_e( 'Previous', 'woocommerce' ); ?>
                    <i class="icon arrow-left-16"></i>
                </a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></a>
		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>