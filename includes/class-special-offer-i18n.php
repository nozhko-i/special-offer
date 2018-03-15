<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer_i18n
{
    /**
     * Load plugin texdomain
     *
     * @access public
     *
     * @return void
     */
    public function load_plugin_textdomain(){
        load_plugin_textdomain(SO_TEXTDOMAIN, false, dirname(dirname(plugin_basename(__FILE__))).'/lang/');
    }
}