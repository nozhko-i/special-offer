<?php
/**
 * The plugin bootstrap file
 *
 * @wordpress-plugin
 *
 * Plugin Name:       special-offer
 * Plugin URI:        https://github.com/nozhko-i/
 * Description:       Special offer plugin
 * Version:           1.0.0
 * Author:            Ivan Nozhka
 * Author URI:        https://github.com/nozhko-i
 * Text Domain:       special-offer
 * Domain Path:       /lang
 */


// If this file is called directly, abort.
if(!defined('ABSPATH')){
    exit;
}

// Plugin version
define('SO_VERSION', '1.1.0');

// Text domain
define('SO_TEXTDOMAIN', 'so');


// The code that runs during plugin activation.
if(!function_exists('activate_special_offer')){
    function activate_special_offer(){
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-special-offer-activator.php';
        Special_Offer_Activator::activate();
    }
}

// The code that runs during plugin deactivation.
if(!function_exists('deactivate_special_offer')){
    function deactivate_special_offer(){
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-special-offer-deactivator.php';
        Special_Offer_Deactivator::deactivate();
    }
}

register_activation_hook(__FILE__, 'activate_special_offer');
register_deactivation_hook(__FILE__, 'deactivate_special_offer');

// The helpers file
require plugin_dir_path(__FILE__).'includes/utils.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-special-offer.php';

// Execution of the plugin
if(!function_exists('special_offer_setup')){
    function special_offer_setup()
    {
        $plugin = new Special_Offer();
        $plugin->run();
    }
}
special_offer_setup();






































//include_once 'includes/utils.php';
//include_once 'includes/init.php';
//
//add_action( 'plugins_loaded', 'so_load_textdomain' );
//
//if(!function_exists('so_load_textdomain')){
//    function so_load_textdomain(){
//        load_plugin_textdomain( SO_TEXTDOMAIN, false, '/special-offer/lang' );
//    }
//}
//
//
//if(!class_exists('Special_Offer')){
//    class Special_Offer
//    {
//        /**
//         * Special_Offer constructor.
//         */
//        public function __construct()
//        {
//            // Base plugin directory uri
//            $this->base = plugins_url('special-offer');
//
//            // Plugin activation
//            register_activation_hook( __FILE__, array( 'Special_Offer', 'activate' ) );
//
//            // Plugin init
//            add_action( 'plugins_loaded', array( $this, 'init' ) );
//        }
//
//        public function init()
//        {
//            load_plugin_textdomain( SO_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
//        }
//    }
//}

// Run the plugin
//add_action('init', 'load_special_offer');
//if(!function_exists('load_special_offer')){
//    function load_special_offer() {
//        new Special_Offer();
//    }
//}
