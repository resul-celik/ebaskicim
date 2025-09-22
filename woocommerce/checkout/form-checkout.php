<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="container-xl checkout-container">
        <div class="row payment-breadcrumb-wrapper">
            <div class="breadcrumb-item active-payment-breadcrumb-line">
                <a href="<?php echo wc_get_cart_url(); ?>">
                    <div class="breadcrumb-icon breadcrumb-active"><i class="icon cart-24"></i></div>
                    <div class="breadcrumb-text">Sepet</div>
                </a>
            </div>
            <div class="breadcrumb-item">
                <div class="breadcrumb-icon breadcrumb-active"><i class="icon card-24"></i></div>
                <div class="breadcrumb-text">Ödeme</div>
            </div>
            <div class="breadcrumb-item">
                <div class="breadcrumb-icon"><i class="icon confirm-24"></i></div>
                <div class="breadcrumb-text">Onay</div>
            </div>
        </div>
        <h1 class="title main-title">Ödeme:</h1>
        <div class="row checkout-row">
            <div class="col-lg-8">
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php woocommerce_checkout_payment();?>
                </div>
                <?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-12">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-12">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
                <?php 
                
                do_action( 'woocommerce_checkout_after_order_review' ); ?>
                
            </div>
            <div class="col-lg-4">
                <?php woocommerce_order_review(); ?>
                <div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
            
                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
            
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
                <div class="form-row place-order">
                    <noscript>
                        <?php
                        
                        /* translators: $1 and $2 opening and closing emphasis tags respectively */
                        printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
                        
                        ?>
                        <br/>
                        <button type="submit" class="button alt secondary-button" name="woocommerce_checkout_update_totals" value="Toplamları güncelle">Toplamları güncelle</button>
                    </noscript>
                    <?php wc_get_template( 'checkout/terms.php' ); ?>
                    <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

                    <?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt primary-button" style="width: 100%;" name="woocommerce_checkout_place_order" id="place_order" value="Öde">Ödemeyi onayla<i class="icon arrow-right-16"></i></button>'); // @codingStandardsIgnoreLine ?>
                    

                    <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

                    <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
jQuery(function($){
    
    $(document.body).on('checkout_error', function(){
        
        $('.close-notice').on('click', function(){

            $(this).parents('.notices').addClass('hide-notices');

        }); 

    });
    
});
</script>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>