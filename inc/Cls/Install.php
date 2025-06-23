<?php 
namespace Inc\Cls;

/**
 * Class Install
 *
 * Handles the activation routine for the plugin.
 *
 * This class is responsible for tasks that need to run when the plugin is activated,
 * such as creating necessary database tables, setting default options, and preparing
 * the environment for first-time use.
 *
 * Usage:
 * Typically called via the register_activation_hook() function.
 *
 *
 * @package App-Impulse-Image_optimizer 
 */

 /**
 * App-Impulse Image Optimizer.
 *
 * @package    App-Impulse Image Optimizer
 * @author     David Kahadze
 * @license    GPL-2.0+
 * @link       https://davidkahadze.com
 * @copyright  Copyright 2025 David Kahadze
 */

 defined('ABSPATH') or die("Direct access to the script does not allowed");


class Install{



    /**
     * Plugin version name
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private static $VERSION_NAME = 'impulse_image_optimizer_version';

    /**
     * Plugin version, used for cache-busting of style and script file references.
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private static $VERSION = '1.0.0';

    /**
     * Unique identifier for your plugin.
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * plugin file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    private static $PLUGIN_SLUG = 'app-impulse-image-optimizer';

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the plugin by setting localization and loading public scripts
     * and styles.
     *
     * @since     1.0.0
     */
    private function __construct()
    {
        add_action('init', array($this, 'load_plugin_textdomain'));

        add_action('wpmu_new_blog', array($this, 'activate_new_site'));




        

    }

    /**
     * Return the plugin slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_plugin_slug()
    {
        return self::$PLUGIN_SLUG;
    }

    /**
     * Return the plugin version.
     *
     * @since    1.0.0
     *
     * @return    Plugin version variable.
     */
    public function get_plugin_version()
    {
        return self::$VERSION;
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Fired when the plugin is activated.
     *
     * @since    1.0.0
     *
     * @param    boolean    $network_wide    True if WPMU superadmin uses
     *                                       "Network Activate" action, false if
     *                                       WPMU is disabled or plugin is
     *                                       activated on an individual blog.
     */
    public static function activate($network_wide)
    {

        if (function_exists('is_multisite') && is_multisite())
        {

            if ($network_wide)
            {
                // Get all blog ids
                    $blog_ids = self::get_blog_ids();

                    foreach ($blog_ids as $blog_id) 
                    {

                        switch_to_blog($blog_id);
                        self::single_activate();
                    }
              restore_current_blog();
            }else
            {
                self::single_activate();
            }

        }else
        {

              if(version_compare( get_bloginfo('version') , '6.8.1' , '<' ))
              {
                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                deactivate_plugins( plugin_basename(__FILE__) );
                error_log('Error: during activation of app-impulse-image-optimizer Plugin : Plugin version 6.8.1 or greater ' , current_time( 'timestamp' ) ) ;
                wp_die( __('This plugin requires WordPress 6.8.1  or greater.' , 'app-impulse-image-optimizer' ) );
                return ;
             }

            
             if(version_compare( phpversion()  , '8.2.0' , '<'))
             {
                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                deactivate_plugins( plugin_basename(__FILE__) );
                error_log('Error: during activation of app-impulse-image-optimizer Plugin :  PHP version  8.2.0  or greater ' , current_time( 'timestamp' ) ) ;
                wp_die( __('This plugin requires PHP version  8.2.0  or greater.' ,  'app-impulse-image-optimizer'  ) );
                return ;

             }

            self::single_activate();
        }

    }

    /**
     * Fired when the plugin is deactivated.
     *
     * @since    1.0.0
     *
     * @param    boolean    $network_wide    True if WPMU superadmin uses
     *                                       "Network Deactivate" action, false if
     *                                       WPMU is disabled or plugin is
     *                                       deactivated on an individual blog.
     */
    public static function deactivate($network_wide)
    {

        if (function_exists('is_multisite') && is_multisite()) {

            if ($network_wide) {

                // Get all blog ids
                $blog_ids = self::get_blog_ids();

                foreach ($blog_ids as $blog_id) {

                    switch_to_blog($blog_id);
                    self::single_deactivate();

                }

                restore_current_blog();

            } else {
                self::single_deactivate();
            }

        } else {

           

            self::single_deactivate();
        }

    }

    /**
     * Fired when a new site is activated with a WPMU environment.
     *
     * @since    1.0.0
     *
     * @param    int    $blog_id    ID of the new blog.
     */
    public function activate_new_site($blog_id)
    {

        if (1 !== did_action('wpmu_new_blog')) {
            return;
        }

        switch_to_blog($blog_id);
        self::single_activate();
        restore_current_blog();

    }

    /**
     * Get all blog ids of blogs in the current network that are:
     * - not archived
     * - not spam
     * - not deleted
     *
     * @since    1.0.0
     *
     * @return   array|false    The blog ids, false if no matches.
     */
    private static function get_blog_ids()
    {

        global $wpdb;

        // get an array of blog ids
        $sql = "SELECT blog_id FROM $wpdb->blogs
            WHERE archived = '0' AND spam = '0'
            AND deleted = '0'";

        return $wpdb->get_col($sql);

    }

    /**
     * Fired for each blog when the plugin is activated.
     *
     * @since    1.0.0
     */
    private static function single_activate()
    {
        update_option(self::$VERSION_NAME, self::$VERSION);

        // @TODO: Define activation functionality here
    }

    /**
     * Fired for each blog when the plugin is deactivated.
     *
     * @since    1.0.0
     */
    private static function single_deactivate()
    {
        // @TODO: Define deactivation functionality here
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        $domain = self::$PLUGIN_SLUG;
        $locale = apply_filters('plugin_locale', get_locale(), $domain );

        load_textdomain($domain, trailingslashit(WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo');

        load_plugin_textdomain($domain, false, basename(plugin_dir_path(dirname(__FILE__))) . '/languages/');

    }





}