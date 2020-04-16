<?php
/**
 * Admin View: Notice - Reset Wizard Success
 *
 * @package Potter_Kit
 */

defined( 'ABSPATH' ) || exit;

$user = get_user_by( 'id', 1 );

?>
<div id="message" class="notice notice-info is-dismissible potter-kit-message">
	<p><?php printf( __( 'WordPress has been reset back to defaults. The user <strong>"%1$s"</strong> was recreated with its previous password.', 'potter-kit' ), $user->user_login ); ?></p>
</div>
