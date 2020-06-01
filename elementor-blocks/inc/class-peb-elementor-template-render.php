<?php
/**
 * PKEB_Elementor_Template_Render setup
 *
 * @package potter-elementor-blocks
 */

/**
 * Potter theme compatibility.
 */
class PKEB_Elementor_Template_Render {

	/**
	 * Instance of PKEB_Elementor_Template_Render.
	 *
	 * @var PKEB_Elementor_Template_Render
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new PKEB_Elementor_Template_Render();

			add_action( 'wp', [ self::$instance, 'hooks' ] );
		}

		return self::$instance;
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( peb_before_header_enabled() ) {
				add_action( 'potter_before_header', 'peb_render_before_header' );
		}

		if ( peb_after_header_enabled() ) {
				add_action( 'potter_after_header', 'peb_render_after_header' );
		}

		if ( peb_single_post_article_after_enabled() ) {
				add_action( 'potter_article_after', 'peb_render_single_post_article_after' );
		}

		if ( peb_after_footer_enabled() ) {
				add_action( 'potter_after_footer', 'peb_render_after_footer' );
		}

		if ( peb_is_before_footer_enabled() ) {
					add_action( 'potter_before_footer', 'peb_render_before_footer' );
		}
	}



}

PKEB_Elementor_Template_Render::instance();
