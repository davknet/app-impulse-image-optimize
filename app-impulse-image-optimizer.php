<?php 
use Inc\Cls\Install;
/*
 * Plugin Name:       App-Impulse Image Optimizer
 * Plugin URI:        https://github.com/davknet/app-impulse-image-optimizer
 * Description:       Optimizes images automatically for improved performance and faster load times.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      8.0
 * Author:            David Kahadze
 * Author URI:        https://github.com/davknet or  https://app-development.store
 * License:           GPL v2 or later
 * License URI:       https://app-development.store
 * Update URI:        https://github.com/davknet/app-impulse-image-optimiser
 * Text Domain:       app-impulse-image-optimizer
 * Domain Path:       /languages
 */



      //   plugin_dir_path(  __FILE__ );
      //   plugins_url() 
      //   includes_url() 
      //   content_url() 
      //   admin_url() 
      //   site_url() 
      //   home_url()

defined('ABSPATH') or die("Direct access to the script does not allowed");

define('APP_IMP_DIR_PATH'    , plugin_dir_path(  __FILE__  ));
define('APP_IMP_PLUGIN_URL'  , plugins_url() );






if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ){

    require __DIR__ . '/vendor/autoload.php';
}


 /* * 
 * * ATTENTION! * * *
 * * FOR DEVELOPMENT ONLY
 * * SHOULD BE DISABLED ON PRODUCTION
 */

error_reporting(E_ALL);
ini_set('display_errors', 1 );
ini_set('log_errors', 1);

$image_optimizer = Install::get_instance();
register_activation_hook( __FILE__, array($image_optimizer , 'activate') );

// $log_path = plugin_dir_path( __FILE__ ) . 'logs/error_logs.log';

ini_set('error_log',     plugin_dir_path( __FILE__ ) . 'logs/error_logs.log' );

// ========================================= clear

