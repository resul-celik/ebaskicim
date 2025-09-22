<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php
    
    if(is_user_logged_in() && current_user_can('kurumsal_uye')){
        
        $indirim = rct_get_discount($product->ID);
        if($indirim !== 0){
            
            if($product->is_type( 'variable' )) {
           
                echo apply_filters( 'woocommerce_sale_flash', '<div class="ebaskicim-sale-flash">%'.$indirim.'</div>', $post, $product );

            } else {

                echo apply_filters( 'woocommerce_sale_flash', '<div class="ebaskicim-sale-flash">%'.$indirim.'</div>', $post, $product );

            }
            
        }
        
    } else {
        
        if($product->is_on_sale() && !$product->is_type( 'variable' )) {
            
            $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
            echo apply_filters( 'woocommerce_sale_flash', '<div class="ebaskicim-sale-flash">%'.$price . sprintf( __('%s', 'woocommerce' ), $percentage ).'</div>', $post, $product );
            
        }
        
    }

?>
