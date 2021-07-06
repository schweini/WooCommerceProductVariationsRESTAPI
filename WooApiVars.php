<?php
/**
 * Plugin Name: Product variations info in parent product's REST API info
 * Plugin URI: http://gometa.org
 * Description: Includes more detailed product variation info like price and stock in base product's API return value JSON. Stolen from https://stackoverflow.com/questions/49352665/woocommerce-rest-api-get-all-products-with-variations-without-too-many-request
 * Version: 1.0
 * Author: Moritz von Schweinitz
 * Author URI: http://gometa.org
 */

add_filter('woocommerce_rest_prepare_product_object', 'custom_change_product_response', 20, 3);
add_filter('woocommerce_rest_prepare_product_variation_object', 'custom_change_product_response', 20, 3);

function custom_change_product_response($response, $object, $request) {
    $variations = $response->data['variations'];
    $variations_res = array();
    $variations_array = array();
    if (!empty($variations) && is_array($variations)) {
        foreach ($variations as $variation) {
            $variation_id = $variation;
            $variation = new WC_Product_Variation($variation_id);
            $variations_res['id'] = $variation_id;
            $variations_res['on_sale'] = $variation->is_on_sale();
            $variations_res['regular_price'] = (float)$variation->get_regular_price();
            $variations_res['sale_price'] = (float)$variation->get_sale_price();
            $variations_res['sku'] = $variation->get_sku();
            $variations_res['quantity'] = $variation->get_stock_quantity();
            if ($variations_res['quantity'] == null) {
                $variations_res['quantity'] = '';
            }
            $variations_res['stock'] = $variation->get_stock_quantity();

            $attributes = array();
            // variation attributes
            foreach ( $variation->get_variation_attributes() as $attribute_name => $attribute ) {
                // taxonomy-based attributes are prefixed with `pa_`, otherwise simply `attribute_`
                $attributes[] = array(
                    'name'   => wc_attribute_label( str_replace( 'attribute_', '', $attribute_name ), $variation ),
                    'slug'   => str_replace( 'attribute_', '', wc_attribute_taxonomy_slug( $attribute_name ) ),
                    'option' => $attribute,
                );
            }

            $variations_res['attributes'] = $attributes;
            $variations_array[] = $variations_res;
        }
    }
    $response->data['product_variations'] = $variations_array;

    return $response;
}
