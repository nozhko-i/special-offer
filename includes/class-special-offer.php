<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer
{
    /**
     * @var $loader
     *
     * @sccess protected
     */
    protected $loader;

    /**
     * Special_Offer constructor.
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {
        if(defined('SO_VERSION')){
            $this->version = SO_VERSION;
        }
        else{
            $this->version = '1.0.0';
        }

        $this->plugin_name = 'special-offer';

        // Load the required dependencies for this plugin.
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_data_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @access   private
     *
     * @return void
     */
    private function load_dependencies()
    {
        // The class responsible for orchestrating the actions and filters of the core plugin.
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-special-offer-loader.php';

        // The class responsible for defining internationalization functionality of the plugin.
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-special-offer-i18n.php';

        // The class responsible for defining all actions that occur in the admin area.
        require_once plugin_dir_path(dirname(__FILE__)).'admin/class-special-offer-admin.php';

        // The class responsible for defining all actions that occur in the public-facing side of the site.
        require_once plugin_dir_path(dirname(__FILE__)).'public/class-special-offer-public.php';

        // The class responsible for defining all actions that occur in the public-facing side of the site.
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-special-offer-data.php';

        $this->loader = new Special_Offer_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * @access   private
     *
     * @return void
     */
    private function set_locale()
    {
        $plugin_i18n = new Special_Offer_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality of the plugin.
     *
     * @access   private
     *
     * @return void
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Special_Offer_Admin();

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'metaboxes', 10, 2);
        $this->loader->add_action('save_post', $plugin_admin, 'save', 1,2);
        $this->loader->add_action('init', $plugin_admin, 'so_tinymce_admin_head');
        $this->loader->add_filter('mce_external_plugins', $plugin_admin, 'tinymce_plugin');
        $this->loader->add_filter('mce_buttons', $plugin_admin, 'tinymce_button');
    }

    /**
     * Register all of the hooks related to the public-facing functionality of the plugin.
     *
     * @access   private
     *
     * @return void
     */
    private function define_public_hooks()
    {
        $plugin_public = new Special_Offer_Public();

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('wp_footer', $plugin_public, 'ajaxurl');
        $this->loader->add_action('wp_ajax_load_special_offer', $plugin_public, 'render_special_offer');
        $this->loader->add_action('wp_ajax_nopriv_load_special_offer', $plugin_public, 'render_special_offer');
        $this->loader->add_shortcode('special-offer', $plugin_public, 'render_shortcode_html');
        $this->loader->add_filter('so_currency', $plugin_public, 'currency');
    }

    /**
     * Register all of the hooks related to the public-facing functionality of the plugin.
     *
     * @access   private
     *
     * @return void
     */
    private function define_data_hooks()
    {
        $plugin_data = new Special_Offer_Data();

        $this->loader->add_action('init', $plugin_data, 'setup');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @access public
     *
     * @return void
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * Get plugin name
     * @return string
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * Get loader
     *
     * @access public
     *
     * @return Special_Offer_Loader
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Get version
     *
     * @access public
     *
     * @return string
     */
    public function get_version()
    {
        return $this->version;
    }

}