<?php
/**
 * Entry point for the plugin. Checks if Elementor is installed and activated and loads it's own files and actions.
 *
 * @package potter-elementor-blocks
 */

use PEB\Lib\Potter_Target_Rules_Fields;

/**
 * Class Potter_Elementor_Blocks
 */
class Potter_Elementor_Blocks {

	/**
	 * Current theme template
	 *
	 * @var String
	 */
	public $template;

	/**
	 * Instance of Elemenntor Frontend class.
	 *
	 * @var \Elementor\Frontend()
	 */
	private static $elementor_instance;

	/**
	 * Instance of PKEB_Admin
	 *
	 * @var Potter_Elementor_Blocks
	 */
	private static $_instance = null;

	/**
	 * Instance of Potter_Elementor_Blocks
	 *
	 * @return Potter_Elementor_Blocks Instance of Potter_Elementor_Blocks
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	/**
	 * Constructor
	 */
	function __construct() {
		$this->template = get_template();

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
			self::$elementor_instance = Elementor\Plugin::instance();

			$this->includes();
			$this->load_textdomain();

			// Scripts and styles.
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
			add_filter( 'body_class', [ $this, 'body_class' ] );
			add_shortcode( 'peb_template', [ $this, 'render_template' ] );

		} else {
			add_action( 'elementor_block_message', [ $this, 'elementor_not_available' ] );
		}
	}

	/**
	 * Enqueue CSS for the Rating Notice.
	 *
	 * @since 1.2.0
	 * @return void
	 */
	public function rating_notice_css() {
		wp_enqueue_style( 'peb-admin-style', PKEB_URL . 'assets/css/admin-potter-elementor-blocks.css', [], PKEB_VER );
	}

	/**
	 * Prints the admin notics when Elementor is not installed or activated.
	 */
	public function elementor_not_available() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			// Check user capability.
			if ( ! ( current_user_can( 'activate_plugins' ) && current_user_can( 'install_plugins' ) ) ) {
				return;
			}

			/* TO DO */
			$class = 'notice notice-error is-dismissible elementor-blocks-notice';
			/* translators: %s: html tags */
			$message = sprintf( __( '%1$sElementor Blocks%2$s is  a block building fetaure of Potter Kit. Using this feature you can create Block template with Elementor and publish them in non editable areas like above header and many more places. To use this feature you need to install and active %1$sElementor%2$s plugin.', 'potter-kit' ), '<strong>', '</strong>' );
			$button_label = __( 'Read More', 'potter-kit' );


			$button = '<p><a class="button button-primary" href="https://wppotter.com/potter-kit" target="_b lank">' . $button_label . '</a></p><p></p>';

			printf( '<div class="%1$s">

	<svg width="362px" height="362px" viewBox="0 0 126 123" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
		<g id="Group-4" transform="translate(-10.000000, -5.000000)" fill="#E01072">
				<path d="M45.7510204,0.809316237 L47.5119511,0.895754094 C54.9756921,1.26212272 60.9386735,7.24078947 61.2854337,14.7054671 L66.0933247,118.20454 C66.4413137,125.695669 60.6506546,132.050529 53.1595258,132.398518 C52.7278083,132.418573 52.2953796,132.418005 51.8637163,132.396816 L50.1027856,132.310378 C42.6390446,131.94401 36.6760632,125.965343 36.329303,118.500665 L31.521412,15.0015926 C31.173423,7.5104637 36.9640821,1.15560312 44.4552109,0.807614195 C44.8869284,0.787559422 45.3193571,0.788127416 45.7510204,0.809316237 Z" id="Rectangle" transform="translate(48.807368, 66.603066) rotate(30.000000) translate(-48.807368, -66.603066) "></path>
				<path d="M93.7510204,0.809316237 L95.5119511,0.895754094 C102.975692,1.26212272 108.938674,7.24078947 109.285434,14.7054671 L114.093325,118.20454 C114.441314,125.695669 108.650655,132.050529 101.159526,132.398518 C100.727808,132.418573 100.29538,132.418005 99.8637163,132.396816 L98.1027856,132.310378 C90.6390446,131.94401 84.6760632,125.965343 84.329303,118.500665 L79.521412,15.0015926 C79.173423,7.5104637 84.9640821,1.15560312 92.4552109,0.807614195 C92.8869284,0.787559422 93.3193571,0.788127416 93.7510204,0.809316237 Z" id="Rectangle-Copy" transform="translate(96.807368, 66.603066) rotate(30.000000) translate(-96.807368, -66.603066) "></path>
		</g>
</g>
</svg>
<div class="notice-content"><p>%2$s</p>%3$s</div></div>', esc_attr( $class ), wp_kses_post( $message ), wp_kses_post( $button ) );
		}
	}


	/**
	 * Loads the globally required files for the plugin.
	 */
	public function includes() {
		require_once PKEB_DIR . 'admin/class-peb-admin.php';

		require_once PKEB_DIR . 'inc/peb-functions.php';

		// Load Elementor Canvas Compatibility.
		require_once PKEB_DIR . 'inc/class-peb-elementor-template-render.php';

		// Load WPML Compatibility if WPML is installed and activated.
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			require_once PKEB_DIR . 'inc/compatibility/class-peb-wpml-compatibility.php';
		}

		// Load the Admin Notice Class.
		require_once PKEB_DIR . 'inc/lib/notices/class-potter-notices.php';

		// Load Target rules.
		require_once PKEB_DIR . 'inc/lib/target-rule/class-potter-target-rules-fields.php';
		// Setup upgrade routines.
		require_once PKEB_DIR . 'inc/class-peb-update.php';
	}

	/**
	 * Loads textdomain for the plugin.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'potter-kit' );
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'peb-style', PKEB_URL . 'assets/css/potter-elementor-blocks.css', [], PKEB_VER );

		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$elementor_pro = \ElementorPro\Plugin::instance();
			$elementor_pro->enqueue_styles();
		}
	}

	/**
	 * Load admin styles on header footer elementor edit screen.
	 */
	public function enqueue_admin_scripts() {
		global $pagenow;
		$screen = get_current_screen();

		if ( ( 'elementor-pb' == $screen->id && ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) ) || ( 'edit.php' == $pagenow && 'edit-elementor-pb' == $screen->id ) ) {
			wp_enqueue_style( 'peb-admin-style', PKEB_URL . 'admin/assets/css/peb-admin.css', [], PKEB_VER );
			wp_enqueue_script( 'peb-admin-script', PKEB_URL . 'admin/assets/js/peb-admin.js', [], PKEB_VER );
		}
	}

	/**
	 * Adds classes to the body tag conditionally.
	 *
	 * @param  Array $classes array with class names for the body tag.
	 *
	 * @return Array          array with class names for the body tag.
	 */
	public function body_class( $classes ) {
		$classes[] = 'peb-template-' . $this->template;
		$classes[] = 'peb-stylesheet-' . get_stylesheet();
		return $classes;
	}


	/**
	 * Prints the Header content.
	 */
	public static function get_after_header_content() {
		echo self::$elementor_instance->frontend->get_builder_content_for_display( get_peb_after_header_id() );
	}
	public static function get_before_header_content() {
		echo self::$elementor_instance->frontend->get_builder_content_for_display( get_peb_before_header_id() );
	}

	public static function get_single_post_article_after_content() {
		echo self::$elementor_instance->frontend->get_builder_content_for_display( get_peb_single_post_article_after_id() );
	}

	/**
	 * Prints the Footer content.
	 */
	public static function get_after_footer_content() {
		echo "<div class='footer-width-fixer'>";
		echo self::$elementor_instance->frontend->get_builder_content_for_display( get_peb_after_footer_id() );
		echo '</div>';
	}

	/**
	 * Prints the Before Footer content.
	 */
	public static function get_before_footer_content() {
		echo "<div class='footer-width-fixer'>";
		echo self::$elementor_instance->frontend->get_builder_content_for_display( peb_get_before_footer_id() );
		echo '</div>';
	}
	/**
	 * Get option for the plugin settings
	 *
	 * @param  mixed $setting Option name.
	 * @param  mixed $default Default value to be received if the option value is not stored in the option.
	 *
	 * @return mixed.
	 */
	public static function get_settings( $setting = '', $default = '' ) {
		if ( 'type_before_header' == $setting || 'type_after_header' == $setting || 'type_after_footer' == $setting || 'type_before_footer' == $setting || 'type_single_post_article_after' == $setting ) {
			$templates = self::get_template_id( $setting );

			$template = ! is_array( $templates ) ? $templates : $templates[0];

			$template = apply_filters( "peb_get_settings_{$setting}", $template );

			return $template;
		}
	}

	/**
	 * Get header or footer template id based on the meta query.
	 *
	 * @param  String $type Type of the template header/footer.
	 *
	 * @return Mixed       Returns the header or footer template id if found, else returns string ''.
	 */
	public static function get_template_id( $type ) {
		$option = [
			'location'  => 'peb_target_include_locations',
			'exclusion' => 'peb_target_exclude_locations',
			'users'     => 'peb_target_user_roles',
		];

		$peb_templates = Potter_Target_Rules_Fields::get_instance()->get_posts_by_conditions( 'elementor-pb', $option );

		foreach ( $peb_templates as $template ) {
			if ( get_post_meta( absint( $template['id'] ), 'peb_template_type', true ) === $type ) {
				return $template['id'];
			}
		}

		return '';
	}

	/**
	 * Callback to shortcode.
	 *
	 * @param array $atts attributes for shortcode.
	 */
	public function render_template( $atts ) {
		$atts = shortcode_atts(
			[
				'id' => '',
			],
			$atts,
			'peb_template'
		);

		$id = ! empty( $atts['id'] ) ? apply_filters( 'peb_render_template_id', intval( $atts['id'] ) ) : '';

		if ( empty( $id ) ) {
			return '';
		}

		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $id );
		} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
			// Load elementor styles.
			$css_file = new \Elementor\Post_CSS_File( $id );
		}
			$css_file->enqueue();

		return self::$elementor_instance->frontend->get_builder_content_for_display( $id );
	}

}
/**
 * Is elementor plugin installed.
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {

	/**
	 * Check if Elementor is installed
	 *
	 * @since 1.5.0
	 *
	 * @access public
	 */
	function _is_elementor_installed() {
		return defined( 'ELEMENTOR_VERSION' ) ? true : false;
	}
}
