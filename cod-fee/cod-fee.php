<?php
/*
 * Plugin Name: COD Shipping Fee for International Orders
 * Description: Adds a RM5 shipping fee to the COD payment option only if the shipping address is outside of Malaysia
 * Version: 1.0
 * Author: Sofwan Rafiee
 * Author URI: http://github.com/billplz/billplz-for-woocommerce 
 * Requires PHP: 7.0
 * Requires at least: 4.6
 * License: GPLv3
 * Text Domain: bfw
 * Domain Path: /languages/
 */
*/

function custom_cod_shipping_fee() {
    global $woocommerce;

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
    $chosen_shipping = $chosen_methods[0];
    
    // get the shipping country
    $shipping_country = WC()->customer->get_shipping_country();

    if( $woocommerce->session->chosen_payment_method == 'cod' && $chosen_shipping == 'local_pickup' && $shipping_country != 'MY') {
        $fee = 5;
        $woocommerce->cart->add_fee( 'COD Shipping Fee', $fee, true, 'standard' );
    }
}
add_action( 'woocommerce_cart_calculate_fees', 'custom_cod_shipping_fee' );
