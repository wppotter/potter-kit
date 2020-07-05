<?php
/**
 * Support section.
 *
 * @package Meta Box
 */

?>
<div id="support" class="gt-tab-pane">
	<p class="about-description">
		<?php
		$allowed_html = array(
			'a' => array(
				'href' => array(),
			),
		);
		// Translators: %s - link to documentation.
		echo wp_kses( sprintf( __( 'Still need help with Meta Box? We offer excellent support for you. But don\'t forget to check our <a href="%s">documentation</a> first.', 'potter-kit' ), 'https://docs.metabox.io?utm_source=WordPress&utm_medium=link&utm_campaign=plugin' ), $allowed_html );
		?>
	</p>
	<div class="two">
		<div class="col">
			<h3><?php esc_html_e( 'Free Support', 'potter-kit' ); ?></h3>
			<p><?php esc_html_e( 'If you have any question about how to use the plugin, please open a new topic on WordPress.org support forum or open a new issue on Github (preferable). We will try to answer as soon as we can.', 'potter-kit' ); ?><p>
			<p><a class="button" target="_blank" href="https://github.com/wpmetabox/potter-kit/issues"><?php esc_html_e( 'Go to Github', 'potter-kit' ); ?> &rarr;</a></p>
			<p><a class="button" target="_blank" href="https://wordpress.org/support/plugin/potter-kit"><?php esc_html_e( 'Go to WordPress.org', 'potter-kit' ); ?> &rarr;</a></p>
		</div>

		<div class="col">
			<h3><?php esc_html_e( 'Premium Support', 'potter-kit' ); ?></h3>
			<p><?php esc_html_e( 'For users that have bought premium extensions, the support is provided in the Meta Box Support forum. Any question will be answered with technical details within 24 hours.', 'potter-kit' ); ?><p>
			<p><a class="button" target="_blank" href="https://metabox.io/support/?utm_source=WordPress&utm_medium=link&utm_campaign=plugin"><?php esc_html_e( 'Go to support forum', 'potter-kit' ); ?> &rarr;</a></p>
		</div>
	</div>
</div>
