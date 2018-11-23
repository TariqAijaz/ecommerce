<?php
 /**
  * Plugin Name: WooCommerce Bookings Filter
  * Description: Adds searching functionality to WooCommerce Booking Plugin.
  * Version: 1.1.2.9
  * Author: <a href = "http://codup.io/" >Codup.io</a>
  * Text Domain: wcbf-filter-setting
  * Domain Path: /languages
  *
  * Copyright: © 2009-2013
  * License: GNU General Public License v3.0
  * License URI: http://www.gnu.org/licenses/gpl-3.0.html
  *
  */

  //direct access restriction
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  /**
   * Function to check if WooCommerce is active
   */
  if ( ! iss_woocommerce_active() || ! iss_woobooking_active() ) {
    return;
  }
        define( 'WCBF_ABSPATH', dirname( __FILE__ ) . '/' );
        define( 'WCBF_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );
        include WCBF_ABSPATH.'includes/views/admin/helper.php';
        include WCBF_ABSPATH.'includes/class-wcbf.php';

    /**
     * Check to init plugin
     */
  if( class_exists( 'WCBF_Main' ) ){
      $custom = new WCBF_Main();
    }
  /**
  * Function defination to check if wooCommerce is active
  * @return false||true
  */
  function iss_woocommerce_active(){
    return (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
}
    /**
     * Function defination to check if wooBooking is active
     * @param return false||true
     */
function iss_woobooking_active(){
  return (in_array( 'woocommerce-bookings/woocommerce-bookings.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
    
}
register_activation_hook(__FILE__, array($custom,'activate'));
register_deactivation_hook(__FILE__, array($custom,'deactivate'));
