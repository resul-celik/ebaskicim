<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.3
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment">
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			if ( ! empty( $available_gateways ) ) {
                
                $getPaymentMethod = array();
                
				foreach ( $available_gateways as $gateway ) {
                    
					
                    $description = $gateway->get_description();
                    if ( $description ) {

                      $desc = wpautop(wptexturize( $description)); // @codingStandardsIgnoreLine.

                    }

                    if ( $gateway->supports( 'default_credit_card_form' ) ) {

                      $cartform = $gateway->credit_card_form(); // Deprecated, will be removed in a future version.

                    }
                    
                    $paymentfield = $desc.$cartform;


                    $getPaymentMethod[$gateway->get_title()] = array(

                        $paymentfield,
                        array(

                            'id' => 'payment_method_'.esc_attr($gateway->id),
                            'name' => 'payment_method',
                            'value' => esc_attr($gateway->id),
                            'data-order_button_text' => esc_attr($gateway->order_button_text)

                        )

                    );

                    
				}
                
                get_the_input('tab', $getPaymentMethod);
                
                echo "<script>
                
                $(function(){
                
                    $('.tm-tab').eq(0).addClass('active-tab');
                    $('.tm-tab-panel').eq(0).addClass('active-panel');

                    $('.tm-tab').on('click', function(){

                        var tabIndex = $(this).index();

                        $('.tm-tab').removeClass('active-tab');
                        $(this).addClass('active-tab');
                        $('.tm-tab-panel').removeClass('active-panel');
                        $('.tm-tab-panel:eq('+tabIndex+')').addClass('active-panel');

                    });
                
                });
                
                
                </script>";
                
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
			}
			?>
		</ul>
	<?php endif; ?>
	
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}