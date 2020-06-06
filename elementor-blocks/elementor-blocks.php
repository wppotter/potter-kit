<?php
/**
 *
 * @package         potter-elementor-blocks
 */

define( 'PKEB_VER', '1.0.5' );
define( 'PKEB_DIR', plugin_dir_path( __FILE__ ) );
define( 'PKEB_URL', plugins_url( '/', __FILE__ ) );
define( 'PKEB_PATH', plugin_basename( __FILE__ ) );
require_once PKEB_DIR . '/inc/class-potter-elementor-blocks.php';
function peb_init() {
	Potter_Elementor_Blocks::instance();
}
add_action( 'plugins_loaded', 'peb_init' );
