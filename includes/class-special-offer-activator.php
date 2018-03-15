<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer_Activator
{
    /**
     * Special_Offer plugin activate
     * @return void
     */
    public static function activate()
    {
        flush_rewrite_rules();
    }

}