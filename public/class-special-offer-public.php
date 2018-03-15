<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer_Public
{
    /**
     * Special_Offer_Public constructor.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @return void
     */
    public function enqueue_styles()
    {
        // special-offer
        wp_enqueue_style('special-offer', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), filemtime(plugin_dir_path(__FILE__) . 'assets/css/style.css'), 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @return void
     */
    public function enqueue_scripts(){

        // visible. visible.js jquery plugin
        wp_enqueue_script('visible', plugin_dir_url(__FILE__) . 'assets/js/jquery.visible.min.js', array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'assets/js/jquery.visible.min.js'), true);

        // special-offer
        wp_enqueue_script('special-offer', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'assets/js/script.js'), true);
    }

    /**
     * Currency
     *
     * @param $value
     *
     * @return string
     */
    public function currency($value)
    {
        return '$ '.$value.' USD/Night';
    }

    /**
     * Fix ajax url
     *
     * @return void
     */
    public function ajaxurl()
    {
        ?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
        <?php
    }

    /**
     * Render special offer shortcode
     *
     * @param $atts
     *
     * @return string
     */
    public function render_shortcode_html($atts)
    {
        $atts = shortcode_atts(array(
            'id' => 0
        ), $atts, 'special-offer');

        ob_start(); ?>

        <div class="special-offer" data-id="<?php echo $atts['id']; ?>" data-loaded="0" id="so_<?php echo $atts['id']; ?>">
            <div class="special-offer__loader">
                <img src="<?php echo plugins_url('public/assets/images/ajax-loader.gif', dirname(__FILE__)); ?>" class="special-offer__loader-image" />
            </div>
        </div>

        <?php return ob_get_clean();
    }

    /**
     * Render of Special Offer
     *
     * @return mixed|string|void
     */
    public function render_special_offer()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : false;
        if(!$id){
            ajax_error('ID of special offer isn\'t provided');
            die();
        }

        $room = get_post($_REQUEST['id']);
        if(!$id){
            ajax_error('Room data unavailable');
            die();
        }

        $content = $this->special_offer_content($room);
        $result = array('room' => $content);

        ajax_success('Ok', $result);
        die();
    }

    /**
     * Spetial Offer content
     *
     * @param $post
     */
    public function special_offer_content($post)
    {
        ?>

        <div class="special-offer__container">
            <div class="special-offer__row">
                <div class="special-offer__col">
                    <?php echo get_the_post_thumbnail($post->ID, 'room-thumbnail', array('class' => 'special-offer__thumbnail')); ?>
                </div>
                <div class="special-offer__col">
                    <h2 class="special-offer__hotel-name"><?php echo so_get_postmeta($post, 'hotel_name'); ?></h2>
                    <h3 class="special-offer__room-name"><?php echo so_get_postmeta($post, 'room_name'); ?></h3>
                    <span class="special-offer__price">
                            <?php echo apply_filters('so_currency', so_get_postmeta($post, 'cost')); ?> | <?php echo so_get_postmeta($post, 'rate_name'); ?>
                        </span>
                    <div class="special-offer__row">
                        <div class="special-offer__col">
                            <div class="special-offer__date-outer">
                                <span class="special-offer__date-title"><?php echo __('Arrival', SO_TEXTDOMAIN); ?></span>
                                <div class="special-offer__month"><?php echo date('F', strtotime(so_get_postmeta($post, 'arrival_date'))); ?></div>
                                <div class="special-offer__day"><?php echo date('d', strtotime(so_get_postmeta($post, 'arrival_date'))); ?></div>
                            </div>
                        </div>
                        <div class="special-offer__col">
                            <div class="special-offer__date-outer">
                                <span class="special-offer__date-title"><?php echo __('Departure', SO_TEXTDOMAIN); ?></span>
                                <div class="special-offer__month"><?php echo date('F', strtotime(so_get_postmeta($post, 'departure_date'))); ?></div>
                                <div class="special-offer__day"><?php echo date('d', strtotime(so_get_postmeta($post, 'departure_date'))); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="special-offer__row">
                        <div class="special-offer__col special-offer__col--wide special-offer__col--text-center">
                            <div class="special-offer__person">

                                <?php if(so_get_postmeta($post, 'number_adult')): ?>
                                <div class="special-offer__person-container special-offer__person-container--adult">
                                    <span><?php echo so_get_postmeta($post, 'number_adult'); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if(so_get_postmeta($post, 'number_child')): ?>
                                <div class="special-offer__person-container special-offer__person-container--child">
                                    <span><?php echo so_get_postmeta($post, 'number_child'); ?></span>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}