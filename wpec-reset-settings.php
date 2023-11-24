<?php

/*
  Plugin Name: WP Express Checkout Reset Settings
  Description: This plugin will reset the settings of the WP Express Checkout Plugin. Useful for cases when you may be locked out.
  Version: 0.0.1
  Text Domain: wp-express-checkout
 */

if (!defined('ABSPATH')) {
	exit;
}

//Define constants
define( 'WPECRS_PLUGIN_VER', '0.0.1' );
define( 'WPECRS_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define( 'WPECRS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPECRS_PLUGIN_FILE', __FILE__ );

require WPECRS_PLUGIN_PATH . '/includes/class-data-handler.php';
require WPECRS_PLUGIN_PATH . '/includes/class-main.php';

if (class_exists('WPECRS_Main') ) {
	new WPECRS_Main();
}