<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */
class Special_Offer_Loader
{
    /**
     * The array of actions registered with WordPress.
     *
     * @access   protected
     * @var      $actions
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @access   protected
     * @var      $filters
     */
    protected $filters;

    /**
     * The array of shortcodes registered with WordPress.
     *
     * @access   protected
     * @var      $filters
     */
    protected $shortcodes;

    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @return void
     */
    public function __construct()
    {
        $this->actions    = array();
        $this->filters    = array();
        $this->shortcodes = array();
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     *
     * @return void
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     *
     * @return void
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     *
     * @return void
     */
    public function add_shortcode($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->shortcodes = $this->add($this->shortcodes, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single collection.
     *
     * @param $hooks
     * @param $hook
     * @param $component
     * @param $callback
     * @param $priority
     * @param $accepted_args
     *
     * @return array
     */
    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
    {
        $hooks[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );
        return $hooks;
    }

    /**
     * Register the filters and actions and shortcodes with WordPress.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->filters as $hook){
            add_filter($hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args']);
        }

        foreach($this->actions as $hook){
            add_action($hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args']);
        }

        foreach($this->shortcodes as $hook){
            add_shortcode($hook['hook'], array( $hook['component'], $hook['callback'] ));
        }
    }

}