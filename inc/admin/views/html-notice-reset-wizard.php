<?php
/**
 * Admin View: Notice - Reset Wizard
 *
 * @package Potter_kit
 */

defined( 'ABSPATH' ) || exit;

$reset_url = wp_nonce_url(
	add_query_arg( 'do_reset_wordpress', 'true', admin_url( 'themes.php?page=demo-importer' ) ),
	'potter_kit_importer_reset',
	'potter_kit_importer_reset_nonce'
);
?>
<div id="message" class="updated potter-kit-message">
	<p><?php _e( '<strong>Reset Wizard</strong> &#8211; If you need to reset the WordPress back to default again :)', 'potter-kit' ); ?></p>
	<p class="submit"><a href="<?php echo esc_url( $reset_url ); ?>" class="button button-primary wppotter-reset-wordpress"><?php _e( 'Reset WordPress Now', 'potter-kit' ); ?></a> <a class="button-secondary skip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'potter-kit-hide-notice', 'reset_notice', admin_url( 'themes.php?page=demo-importer' ) ), 'potter_kit_importer_hide_notice_nonce', '_potter_kit_importer_notice_nonce' ) ); ?>"><?php _e( 'Hide this notice', 'potter-kit' ); ?></a></p>
</div>
