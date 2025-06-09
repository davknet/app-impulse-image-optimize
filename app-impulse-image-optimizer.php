<?php 
/*
 * Plugin Name:       App-Impulse Image Optimizer
 * Plugin URI:        https://github.com/yourusername/app-impulse-image-optimizer
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



      //   plugin_dir_path( $pash , __FILE__ );
      //   plugins_url() plugins url 
      //   includes_url() 
      //   content_url() 
      //   admin_url() 
      //   site_url() 
      //   home_url()

defined('ABSPATH') or die("Direct access to the script does not allowed");




if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ){
    require_once __DIR__ . '/vendor/autoload.php';
}