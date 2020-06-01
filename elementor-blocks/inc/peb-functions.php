<?php
/**
 * Potter Elementor Blocks Function
 *
 * @package  potter-elementor-blocks
 */

/**
 * Checks if Header is enabled from PEB.
 *
 * @since  1.0.2
 * @return bool True if header is enabled. False if header is not enabled
 */
function peb_before_header_enabled() {
	$before_header_id = Potter_Elementor_Blocks::get_settings( 'type_before_header', '' );
	$status    = false;

	if ( '' !== $before_header_id ) {
		$status = true;
	}
	return apply_filters( 'peb_before_header_enabled', $status );
}

function peb_after_header_enabled() {
	$after_header_id = Potter_Elementor_Blocks::get_settings( 'type_after_header', '' );
	$status    = false;

	if ( '' !== $after_header_id ) {
		$status = true;
	}
	return apply_filters( 'peb_after_header_enabled', $status );
}

function peb_single_post_article_after_enabled() {
	$single_post_article_after_id = Potter_Elementor_Blocks::get_settings( 'type_single_post_article_after', '' );
	$status    = false;

	if ( '' !== $single_post_article_after_id ) {
		$status = true;
	}
	return apply_filters( 'peb_single_post_article_after_enabled', $status );
}

/**
 * Checks if Footer is enabled from PEB.
 *
 * @since  1.0.2
 * @return bool True if header is enabled. False if header is not enabled.
 */
function peb_after_footer_enabled() {
	$footer_id = Potter_Elementor_Blocks::get_settings( 'type_after_footer', '' );
	$status    = false;

	if ( '' !== $after_footer_id ) {
		$status = true;
	}

	return apply_filters( 'peb_after_footer_enabled', $status );
}

/**
 * Get PEB Header ID
 *
 * @since  1.0.2
 * @return (String|boolean) header id if it is set else returns false.
 */
function get_peb_before_header_id() {
	$before_header_id = Potter_Elementor_Blocks::get_settings( 'type_before_header', '' );

	if ( '' === $before_header_id ) {
		$before_header_id = false;
	}

	return apply_filters( 'get_peb_before_header_id', $before_header_id );
}

function get_peb_after_header_id() {
	$before_header_id = Potter_Elementor_Blocks::get_settings( 'type_after_header', '' );

	if ( '' === $after_header_id ) {
		$after_header_id = false;
	}

	return apply_filters( 'get_peb_after_header_id', $before_header_id );
}

function get_peb_single_post_article_after_id() {
	$single_post_article_after_id = Potter_Elementor_Blocks::get_settings( 'type_single_post_article_after', '' );

	if ( '' === $single_post_article_after_id ) {
		$single_post_article_after_id = false;
	}

	return apply_filters( 'get_peb_single_post_article_after_id', $single_post_article_after_id );
}
/**
 * Get PEB Footer ID
 *
 * @since  1.0.2
 * @return (String|boolean) header id if it is set else returns false.
 */
function get_peb_after_footer_id() {
	$after_footer_id = Potter_Elementor_Blocks::get_settings( 'type_after_footer', '' );
	if ( '' === $after_footer_id ) {
		$after_footer_id = false;
	}
	return apply_filters( 'get_peb_after_footer_id', $after_footer_id );
}
/**
 * Display header markup.
 *
 * @since  1.0.2
 */
function peb_render_after_header() {
	if ( false == apply_filters( 'enable_peb_render_after_header', true ) ) {
		return;
	}

		 Potter_Elementor_Blocks::get_after_header_content();

}

function peb_render_before_header() {
	if ( false == apply_filters( 'enable_peb_render_before_header', true ) ) {
		return;
	}

		 Potter_Elementor_Blocks::get_before_header_content();

}

function peb_render_single_post_article_after() {
	if ( false == apply_filters( 'enable_peb_single_post_article_after', true ) ) {
		return;
	}

		 Potter_Elementor_Blocks::get_single_post_article_after_content();

}

/**
 * Display footer markup.
 *
 * @since  1.0.2
 */
function peb_render_after__footer() {

	if ( false == apply_filters( 'enable_peb_render_after_footer', true ) ) {
		return;
	}
 	Potter_Elementor_Blocks::get_after_footer_content();
}


/**
 * Get PEB Before Footer ID
 *
 * @since  1.0.2
 * @return String|boolean before footer id if it is set else returns false.
 */
function peb_get_before_footer_id() {

	$before_footer_id = Potter_Elementor_Blocks::get_settings( 'type_before_footer', '' );

	if ( '' === $before_footer_id ) {
		$before_footer_id = false;
	}

	return apply_filters( 'get_peb_before_footer_id', $before_footer_id );
}

/**
 * Checks if Before Footer is enabled from PEB.
 *
 * @since  1.0.2
 * @return bool True if before footer is enabled. False if before footer is not enabled.
 */
function peb_is_before_footer_enabled() {

	$before_footer_id = Potter_Elementor_Blocks::get_settings( 'type_before_footer', '' );
	$status           = false;

	if ( '' !== $before_footer_id ) {
		$status = true;
	}

	return apply_filters( 'peb_before_footer_enabled', $status );
}

/**
 * Display before footer markup.
 *
 * @since  1.0.2
 */
function peb_render_before_footer() {

	if ( false == apply_filters( 'enable_peb_render_before_footer', true ) ) {
		return;
	}

	?>
		<div class="peb-before-footer-wrap">
			<?php Potter_Elementor_Blocks::get_before_footer_content(); ?>
		</div>
	<?php

}

function peb_render_after_footer() {

	if ( false == apply_filters( 'enable_peb_render_after_footer', true ) ) {
		return;
	}

	?>
		<div class="peb-before-footer-wrap">
			<?php Potter_Elementor_Blocks::get_after_footer_content(); ?>
		</div>
	<?php

}
