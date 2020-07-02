<?php
/**
 * Admin View: Notice - Reset Wizard
 *
 * @package Potter_kit
 */

defined( 'ABSPATH' ) || exit;

$reset_url = wp_nonce_url(
	add_query_arg( 'do_reset_wordpress', 'true', admin_url( 'admin.php?page=demo-importer' ) ),
	'potter_kit_importer_reset',
	'potter_kit_importer_reset_nonce'
);
?>
<div id="message" class="updated potter-kit-message">

<svg width="35px" height="35px" viewBox="0 0 352 352" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
    <g id="logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="reset" fill="#E76E54">
            <path d="M352,176 C352,273.203125 273.203125,352 176,352 C78.796875,352 0,273.203125 0,176 C0,78.796875 78.796875,0 176,0 C273.203125,0 352,78.796875 352,176 Z M184,272 L184,240 C148.703125,240 120,211.296875 120,176 C120,140.703125 148.703125,112 184,112 C215.230469,112 241.296875,134.480469 246.910156,164.097656 L212.992188,147.136719 L198.671875,175.761719 L280,216.433594 L280,176 C280,123.054688 236.945312,80 184,80 C131.054688,80 88,123.054688 88,176 C88,228.945312 131.054688,272 184,272 Z" id="Combined-Shape"></path>
        </g>
    </g>
</svg>
	<p><?php _e( '<strong>Reset Wizard</strong> &#8211; If you need to reset the WordPress back to default again :)', 'potter-kit' ); ?></p>
	<p class="submit"><a href="<?php echo esc_url( $reset_url ); ?>" class="button button-primary wppotter-reset-wordpress"><?php _e( 'Reset WordPress Now', 'potter-kit' ); ?></a> <a class="button-secondary skip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'potter-kit-hide-notice', 'reset_notice', admin_url( 'admin.php?page=demo-importer' ) ), 'potter_kit_importer_hide_notice_nonce', '_potter_kit_importer_notice_nonce' ) ); ?>"><?php _e( 'Hide this notice', 'potter-kit' ); ?></a></p>
</div>
