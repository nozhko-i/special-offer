<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer_Data
{
    /**
     * Special_Offer_Data constructor.
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Special offer data setup
     *
     * @access public
     *
     * @return void
     */
    public function setup()
    {
        add_image_size('room-thumbnail', 300, 180, true);

        $this->rooms_post_type();
    }

    /**
     * Register rooms post type
     *
     * @access public
     *
     * @return void
     */
    public function rooms_post_type()
    {
        $labels = array(
            'name'                => _x('Rooms', 'post type general name', SO_TEXTDOMAIN),
            'singular_name'       => _x('Room', 'post type singular name', SO_TEXTDOMAIN),
            'menu_name'           => _x('Room', 'admin menu', SO_TEXTDOMAIN),
            'name_admin_bar'      => _x('Room', 'add new on admin bar', SO_TEXTDOMAIN),
            'add_new'             => _x('Add New', 'room', SO_TEXTDOMAIN),
            'add_new_item'        => __('Add New Room', SO_TEXTDOMAIN),
            'new_item'            => __('New Room', SO_TEXTDOMAIN),
            'edit_item'           => __('Edit Room', SO_TEXTDOMAIN),
            'view_item'           => __('View Room', SO_TEXTDOMAIN),
            'all_items'           => __('All Rooms', SO_TEXTDOMAIN),
            'search_items'        => __('Search Rooms', SO_TEXTDOMAIN),
            'parent_item_colon'   => __('Parent Room:', SO_TEXTDOMAIN),
            'not_found'           => __('No rooms found.', SO_TEXTDOMAIN),
            'not_found_in_trash'  => __('No rooms found in trash.', SO_TEXTDOMAIN)
        );
        $args = array(
            'labels'              => $labels,
            'description'         => __('Rooms', SO_TEXTDOMAIN),
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
            'has_archive'         => false,
            'hierarchical'        => false,
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-admin-multisite',
            'supports'            => array('title', 'thumbnail')
        );
        register_post_type('rooms', $args);
    }
}
