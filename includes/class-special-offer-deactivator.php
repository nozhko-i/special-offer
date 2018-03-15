<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer_Deactivator{
    /**
     * Special_Offer plugin deactivate
     *
     * @access public
     *
     * @return void
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}