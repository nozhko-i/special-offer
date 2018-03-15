<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer_Admin
{
    /**
     * Special_Offer_Admin constructor.
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @return void
     */
    public function enqueue_styles()
    {
        // jquery-ui
        wp_enqueue_style('jquery-ui', plugin_dir_url(__FILE__).'assets/css/jquery-ui.min.css', array(), filemtime(plugin_dir_path(__FILE__).'assets/css/jquery-ui.min.css'), 'all');

        // special-offer
        wp_enqueue_style('special-offer', plugin_dir_url(__FILE__).'assets/css/style.css', array(), filemtime(plugin_dir_path(__FILE__).'assets/css/style.css'), 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        // jquery-ui
        wp_enqueue_script('jquery-ui', plugin_dir_url(__FILE__) . 'assets/js/jquery-ui.min.js', array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'assets/js/jquery-ui.min.js'), true);

        // special-offer
        wp_enqueue_script('special-offer', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery-ui'), filemtime(plugin_dir_path(__FILE__) . 'assets/js/script.js'), true);
    }

    /**
     * Setup rooms metabox
     *
     * @return void
     */
    public function metaboxes()
    {
        add_meta_box('so_rooms_options', __('Options', SO_TEXTDOMAIN), array($this, 'so_metabox_rooms'),'rooms');
    }

    /**
     * Rooms metabox callback function
     *
     * @param $post
     *
     * @return void
     */
    public function so_metabox_rooms($post)
    {
        // wp nonce
        wp_nonce_field(plugin_basename(__FILE__), 'so_rooms_options_metabox_nonce');

        ?>
        <table class="so-table">
            <tbody>
            <tr>
                <?php so_metabox_control_input($post, 'hotel_name', 'Hotel name:', 'table', 'xlarge'); ?>
            </tr><tr>
                <?php so_metabox_control_input($post, 'room_name', 'Room name:', 'table', 'xlarge'); ?>
            </tr><tr>
                <?php so_metabox_control_input($post, 'rate_name', 'Rate name:', 'table', 'xlarge'); ?>
            </tr><tr>
                <?php so_metabox_control_input($post, 'number_adult', 'Number of adult:', 'table', 'xlarge'); ?>
            </tr><tr>
                <?php so_metabox_control_input($post, 'number_child', 'Number of child:', 'table', 'xlarge'); ?>
            </tr><tr>
                <?php so_metabox_control_input($post, 'cost', 'Cost:', 'table', 'xlarge'); ?>
            </tr><tr>
                <?php so_metabox_control_input($post, 'arrival_date', 'Arrival date:', 'table', 'xlarge'); ?>
            </tr><tr>
                <?php so_metabox_control_input($post, 'departure_date', 'Departure date:', 'table', 'xlarge'); ?>
            </tr>
            </tbody>
        </table>
        <?php
    }

    /**
     * Save metadata
     *
     * @param $post_id
     *
     * @return void
     */
    public function save($post_id)
    {
        // Check if our nonce is set.
        if(!isset($_POST['so_rooms_options_metabox_nonce'])){
            return;
        }

        // Verify that the nonce is valid.
        if(!wp_verify_nonce($_POST['so_rooms_options_metabox_nonce'], plugin_basename(__FILE__))){
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return;
        }

        // Check the user's permissions.
        if(isset($_POST['post_type']) && 'rooms' == $_POST['post_type']){
            if(!current_user_can('edit_page', $post_id)){
                return;
            }
        }
        else{
            if(!current_user_can('page', $post_id)){
                return;
            }
        }

        global $post; $post = get_post($post_id);

        /* OK, it's safe for us to save the data now. */
        so_metabox_control_save($post, 'hotel_name', 'str');
        so_metabox_control_save($post, 'room_name', 'str');
        so_metabox_control_save($post, 'rate_name', 'str');
        so_metabox_control_save($post, 'number_adult', 'str');
        so_metabox_control_save($post, 'number_child', 'str');
        so_metabox_control_save($post, 'cost', 'str');
        so_metabox_control_save($post, 'arrival_date', 'str');
        so_metabox_control_save($post, 'departure_date', 'str');
    }

    /**
     * TinyMCE expernal plugin
     *
     * @param $plugin_array
     *
     * @return mixed
     */
    public function tinymce_plugin($plugin_array)
    {
        $plugin_array['so_mce_button'] = plugins_url('admin/assets/js/shortcode.js', dirname(__FILE__));
        return $plugin_array;
    }

    /**
     * TinyMCE custom button
     *
     * @param $buttons
     *
     * @return mixed
     */
    public function tinymce_button($buttons)
    {
        array_push($buttons, 'so_mce_button');
        return $buttons;
    }

    /**
     * TinyMCE JS variables
     *
     * @return void
     */
    public function so_tinymce_admin_head()
    {
        foreach(array('post.php','post-new.php') as $hook){
            add_action("admin_head-$hook", array($this, 'so_tinymce_admin_head_variables'));
        }
    }

    /**
     * TinyMCE assign variables
     *
     * Assign variables which can be used in shortcode.ja
     *
     * @return void
     */
    public function so_tinymce_admin_head_variables()
    {
        $rooms = get_posts(array(
                'post_type' => 'rooms',
                'numberposts' => -1,
        ));

        $soMCEMenu = array();

        foreach($rooms as $item){
            $soMCEMenu[] = array(
                'text' => $item->post_title,
                'value' => '[special-offer id="'.$item->ID.'"]',
            );
        }
        ?>

        <!-- TinyMCE Shortcode Plugin -->
        <script type='text/javascript'>
            var soMCEMenu = <?php echo json_encode($soMCEMenu); ?>;
        </script>
        <!--/TinyMCE Shortcode Plugin -->

        <?php
    }

}
