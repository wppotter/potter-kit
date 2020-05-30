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
			$message = sprintf( __( 'To Use %1$sElementor Blocks%2$s feature, %1$sElementor%2$s plugin needs to be installed & activated.', 'potter-kit' ), '<strong>', '</strong>' );

			$plugin = 'elementor/elementor.php';
				$button_label = __( 'Install and Active Elementor', 'potter-kit' );


			$button = '<p>' . $button_label . '</p><p></p>';

			printf( '<div class="%1$s"><p>%2$s</p>%3$s</div>', esc_attr( $class ), wp_kses_post( $message ), wp_kses_post( $button ) );
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
		if ( 'type_before_header' == $setting || 'type_after_header' == $setting || 'type_after_footer' == $setting || 'type_before_footer' == $setting ) {
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
