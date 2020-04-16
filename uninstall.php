<?php
/**
 * Potter Kit Uninstall
 *
 * Uninstalls the plugin and associated data.
 *
 * @package Importer\Unistaller
 * @version 1.3.4
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

global $wpdb;

delete_transient( 'potter_kit_packages' );

/*
 * Only remove ALL demo importer data if WPPK_REMOVE_ALL_DATA constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'WPPK_REMOVE_ALL_DATA' ) && true === WPPK_REMOVE_ALL_DATA ) {
	// Delete options.
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'potter_kit\_%';" );
}
