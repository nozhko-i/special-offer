<?php
/**
 * @package Wordpress
 * @subpackage Special offer
 * @since version 1.0.0
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 */

if(!defined('ABSPATH')){
    exit;
}

add_action('activate_plugin', 'so_activate');
add_action('deactivate_plugin', 'so_deactivate');


// Activate plugin
if(!function_exists('so_activate')){
    function so_activate(){
        so_plugin_init();
    }
}

// Deactivate plugin
if(!function_exists('so_deactivate')){
    function so_deactivate(){
        flush_rewrite_rules();
    }
}

// Init post types & taxonomies of plugin
if(!function_exists('so_plugin_init')){
    function so_plugin_init(){
        so_register_post_types();
        so_register_taxonomies();
    }
}

// Posts types of plugin
if(!function_exists('so_register_post_types')){
    function so_register_post_types(){
        so_rooms();
    }
}

// Taxonomies of plugin
if(!function_exists('so_register_taxonomies')){
    function so_register_taxonomies(){}
}


/**
 * es_slider_init
 * @return void
 */
if(!function_exists('so_rooms')){
    function so_rooms(){
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


