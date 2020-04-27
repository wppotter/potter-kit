<?php
/**
 * Plugin Name: Potter Kit - Demo Importer for Potter Theme
 * Plugin URI: https://wppotter.com/potter-kit/
 * Description: Import Potter themes demo content, widgets and theme settings with just one click.
 * Version: 1.0.4
 * Author: wppotter
 * Author URI: https://wppotter.com
 * License: GPLv3 or later
 * Text Domain: potter-kit
 * Domain Path: /languages/
 *
 * @package Potter Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WPPK_PLUGIN_FILE.
if ( ! defined( 'WPPK_PLUGIN_FILE' ) ) {
	define( 'WPPK_PLUGIN_FILE', __FILE__ );
}

// Include the main Potter Kit class.
if ( ! class_exists( 'Potter_Kit' ) ) {
	include_once dirname( __FILE__ ) . '/inc/class-potter-kit.php';
}

function potter_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'themes.php?page=demo-importer&browse=all' ) ) );
    }
}
add_action( 'activated_plugin', 'potter_activation_redirect' );

/**
 * Main instance of Potter Kit.
 *
 * Returns the main instance of WPPK to prevent the need to use globals.
 *
 * @since  1.3.4
 * @return Potter_Kit
 */
function wppk() {
	return Potter_Kit::instance();
}

// Global for backwards compatibility.
$GLOBALS['potter-kit'] = wppk();
