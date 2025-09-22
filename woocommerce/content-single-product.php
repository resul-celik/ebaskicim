<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attachment_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$gallery_thumbnail = wc_get_image_size('gallery_thumbnail');
$alt_text = trim(wp_strip_all_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));


$producttype = $product->get_type();
echo $attributes;

echo woocommerce_output_all_notices();

//print_r( json_decode($variations_json));

?>
<div class="row product-row">
    <div class="col-lg-6">
        <figure class="product-image-slider-wrapper">
            <div class="product-full-size-images-wrapper">
                <?php 
                
                    woocommerce_show_product_sale_flash();
                
                    if ($attachment_id) {

                        echo '<div class="product-image"><img src="'.wp_get_attachment_image_src( $attachment_id, '500x500' )[0].'" alt="'.$alt_text.'" /></div>';

                        if ($attachment_ids && $product->get_image_id()) {

                            foreach ($attachment_ids as $atid) {

                                echo '<div class="product-image"><img src="'.wp_get_attachment_image_src( $atid, '500x500' )[0].'" alt="'.$alt_text.'" /></div>';

                            }

                        }

                    } else {

                        echo '<div class="product-image"><img src"'.get_template_directory_uri().'/images/placeholders/product-placeholder.jpg"></div>';
                    }

                ?>
                <div class="clear"></div>
            </div>
            <div class="product-thumbnails">
                <div class="thumbnail-arrows thumbnail-left-arrow">‹</div>
                <?php 

                    if ($attachment_id) {

                        echo '<div class="product-thumbnail"><img src="'.wp_get_attachment_image_src( $attachment_id, $gallery_thumbnail )[0].'" alt="'.$alt_text.'" /></div>';

                        if ($attachment_ids && $product->get_image_id()) {

                            foreach ($attachment_ids as $atid) {

                                echo '<div class="product-thumbnail"><img src="'.wp_get_attachment_image_src( $atid, $gallery_thumbnail )[0].'" alt="'.$alt_text.'" /></div>';

                            }

                        }

                    } else {

                        echo '<div class="product-thumbnail"><img src"'.get_template_directory_uri().'/images/placeholders/product-placeholder.jpg"></div>';
                    }

                ?>
                <div class="thumbnail-arrows thumbnail-right-arrow">›</div>
            </div>
        </figure>
    </div>
    <div class="col-lg-6">
        <h1 class="title product-title"><?php echo get_the_title(); ?></h1>
        <div class="product-price-wrapper">
            <span class="price product-price">
                <?php echo woocommerce_template_single_price(); ?>
            </span>
        </div>
        <?php

            $scructed = new WC_Structured_Data;

            //echo woocommerce_template_single_excerpt();
            
            //echo woocommerce_template_single_sharing();
            //echo $scructed->generate_product_data();
            // woocommerce_show_product_sale_flash
        
            if (get_field('ozel_tasarim')[0] == 'evet') {
                
                $accordions = array(

                    'Kendi tasarımını yükle (İsteğe bağlı)' => ozel_tasarim_yukleme_formu()

                );

                echo get_the_input('accordion', $accordions);
                
            }

        ?>
        <div class="add-to-cart-form-wrapper">
            <?php woocommerce_template_single_add_to_cart (); ?>
        </div>
        <div class="tab-menu-wrapper">
            <?php   

                woocommerce_output_product_data_tabs();

            ?>

        </div>
        <?php echo woocommerce_template_single_meta(); ?>
    </div>
</div>
<?php echo woocommerce_output_related_products(); wp_nonce_field('ajax_file_nonce', 'security', true, false);?>