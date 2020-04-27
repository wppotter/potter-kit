<?php
/**
 * Potter Kit setup
 *
 * @package Potter_Kit
 * @since   1.0.4
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Potter Kit Class.
 *
 * @class Potter_Kit
 */
final class Potter_Kit {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0.4';

	/**
	 * Theme single instance of this class.
	 *
	 * @var object
	 */
	protected static $_instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.4
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'potter-kit' ), '1.4' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.4
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'potter-kit' ), '1.4' );
	}

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		$this->define_constants();
		$this->init_hooks();

		do_action( 'wppotter_demo_importer_loaded' );
	}

	/**
	 * Define WPPK Constants.
	 */
	private function define_constants() {
		$upload_dir = wp_upload_dir( null, false );

		$this->define( 'WPPK_ABSPATH', dirname( WPPK_PLUGIN_FILE ) . '/' );
		$this->define( 'WPPK_PLUGIN_BASENAME', plugin_basename( WPPK_PLUGIN_FILE ) );
		$this->define( 'WPPK_VERSION', $this->version );
		$this->define( 'WPPK_DEMO_DIR', $upload_dir['basedir'] . '/tg-demo-pack/' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Hook into actions and filters.
	 */
	private function init_hooks() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Register activation hook.
		register_activation_hook( WPPK_PLUGIN_FILE, array( $this, 'install' ) );

		// Register deactivation hook.
		register_deactivation_hook( WPPK_PLUGIN_FILE, array( $this, 'deactivate' ) );

		// Check if Potter theme is installed.
		if ( in_array( get_option( 'template' ), $this->get_core_supported_themes(), true ) ) {
			$this->includes();

			add_filter( 'plugin_action_links_' . WPPK_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		} else {
			add_action( 'admin_notices', array( $this, 'theme_support_missing_notice' ) );
		}
	}

	/**
	 * Get core supported themes.
	 *
	 * @return array
	 */
	private function get_core_supported_themes() {
		$core_themes = array( 'potter' );
		return array_merge( $core_themes);
	}

	/**
	 * Include required core files.
	 */
	private function includes() {
		include_once WPPK_ABSPATH . 'inc/class-demo-importer.php';
		include_once WPPK_ABSPATH . 'inc/functions-demo-importer.php';

		// Backward compatibility for demo packages config.
		if ( file_exists( WPPK_DEMO_DIR . 'tg-demo-config.php' ) ) {
			include_once WPPK_DEMO_DIR . 'tg-demo-config.php';
		}
	}

	/**
	 * Install TG Demo Importer.
	 */
	public function install() {
		$files = array(
			array(
				'base'    => WPPK_DEMO_DIR,
				'file'    => 'index.html',
				'content' => '',
			),
		);

		// Bypass if filesystem is read-only and/or non-standard upload system is used.
		if ( ! is_blog_installed() || apply_filters( 'wppotter_demo_importer_install_skip_create_files', false ) ) {
			return;
		}

		// Install files and folders.
		foreach ( $files as $file ) {
			if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
				$file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' ); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
				if ( $file_handle ) {
					fwrite( $file_handle, $file['content'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
					fclose( $file_handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
				}
			}
		}

		// Redirect to demo importer page.
		set_transient( '_pk_demo_importer_activation_redirect', 1, 30 );
	}

	/**
	 * Deactivation hook.
	 */
	function deactivate() {

		include_once dirname( __FILE__ ) . '/class-demo-importer-deactivator.php';

		PK_Demo_Sites_Deactivator::deactivate();

	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/potter-kit/potter-kit-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/potter-kit-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'potter-kit' );

		unload_textdomain( 'potter-kit' );
		load_textdomain( 'potter-kit', WP_LANG_DIR . '/potter-kit/potter-kit-' . $locale . '.mo' );
		load_plugin_textdomain( 'potter-kit', false, plugin_basename( dirname( WPPK_PLUGIN_FILE ) ) . '/languages' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', WPPK_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( WPPK_PLUGIN_FILE ) );
	}

	/**
	 * Display action links in the Plugins list table.
	 *
	 * @param  array $actions Plugin Action links.
	 * @return array
	 */
	public function plugin_action_links( $actions ) {
		$new_actions = array(
			'importer' => '<a href="' . admin_url( 'themes.php?page=demo-importer' ) . '" aria-label="' . esc_attr( __( 'View Demo Importer', 'potter-kit' ) ) . '">' . __( 'Demo Importer', 'potter-kit' ) . '</a>',
		);

		return array_merge( $new_actions, $actions );
	}

	/**
	 * Display row meta in the Plugins list table.
	 *
	 * @param  array  $plugin_meta Plugin Row Meta.
	 * @param  string $plugin_file Plugin Row Meta.
	 * @return array
	 */
	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( WPPK_PLUGIN_BASENAME === $plugin_file ) {
			$new_plugin_meta = array(
				'docs'    => '<a href="' . esc_url( apply_filters( 'wppotter_demo_importer_docs_url', 'https://wppotter.com/potter-kit/docs/' ) ) . '" title="' . esc_attr( __( 'View Demo Importer Documentation', 'potter-kit' ) ) . '">' . __( 'Docs', 'potter-kit' ) . '</a>',
				'support' => '<a href="' . esc_url( apply_filters( 'wppotter_demo_importer_support_url', 'https://pottertheme.com/support' ) ) . '" title="' . esc_attr( __( 'Visit Free Customer Support Forum', 'potter-kit' ) ) . '">' . __( 'Free Support', 'potter-kit' ) . '</a>',
			);

			return array_merge( $plugin_meta, $new_plugin_meta );
		}

		return (array) $plugin_meta;
	}

	/**
	 * Theme support fallback notice.
	 */
	public function theme_support_missing_notice() {
		$themes_url = array_intersect( array_keys( wp_get_themes() ), $this->get_core_supported_themes() ) ? admin_url( 'themes.php?search=potter' ) : admin_url( 'theme-install.php?search=potter' );

		/* translators: %s: Potter Theme URL */
		echo '<div class="error notice is-dismissible"><p style="font-size: 16px;">

<svg width="50px" height="50px" viewBox="0 0 185 185" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: inline-block; vertical-align: middle;">
    <defs>
        <linearGradient x1="24.2442255%" y1="23.8077192%" x2="84.375%" y2="89.036264%" id="linearGradient-1">
            <stop stop-color="#3023AE" offset="0%"></stop>
            <stop stop-color="#C86DD7" offset="100%"></stop>
        </linearGradient>
    </defs>
    <g id="logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Group-92">
            <rect id="Rectangle" fill="#FFFFFF" x="0" y="0" width="185" height="185"></rect>
            <g id="Group-3" transform="translate(20.000000, 23.000000)" fill="url(#linearGradient-1)">
                <path d="M124.686557,76.8262592 L124.883891,66.9084693 L124.85805,66.9333727 L124.85805,66.9287033 L110.563856,80.9633411 L133.030971,47.3522748 L136.465524,68.9738973 L124.686557,76.8262592 Z M119.627913,118.306808 L60.3634698,101.862764 L73.5308228,76.3593199 L97.2195292,100.063492 L120.37418,77.3328883 L119.627913,118.306808 Z M96.2078003,131.613799 L85.0615557,122.914721 L94.6040692,120.029814 L76.7343697,110.835002 L115.838628,121.68667 L96.2078003,131.613799 Z M43.8077649,130.958528 L41.225977,69.8229485 L69.7125645,74.4082921 L54.3768856,104.139093 L83.2424798,118.993987 L43.8077649,130.958528 Z M23.8363006,112.934672 L28.7203197,99.7016136 L34.4273473,107.841143 L34.4375272,107.778885 L34.4633686,107.81624 L37.7029368,88.1744397 L37.749138,89.2655211 L39.4029858,128.421491 L23.8363006,112.934672 Z M8.30485368,63.1908546 L65.9600843,41.8665168 L70.3946201,70.1949435 L37.1978555,64.86561 L31.9136867,96.7466663 L8.30485368,63.1908546 Z M19.3814049,38.7450278 L33.5322962,39.2718909 L27.5277013,47.1802856 L27.5316166,47.1795073 L27.5300505,47.1810638 L47.3997154,44.1786443 L9.37296368,58.2420766 L19.3814049,38.7450278 Z M62.1457413,8.67102649 L100.383139,56.6124586 L76.8541797,68.4299131 L74.6380864,69.542785 L69.4658969,36.5262881 L37.334893,41.3816782 L62.1457413,8.67102649 Z M88.9628196,11.5862839 L92.8343268,25.1345266 L83.4084911,21.8939681 L92.4349602,39.77852 L67.21065,8.15038922 L88.9628196,11.5862839 Z M130.967576,42.7264632 L96.8992528,93.6936618 L76.5761892,73.3506746 L106.589767,58.2996658 L91.9893923,29.3704439 L130.967576,42.7264632 Z M143.893743,67.0913539 L140.017538,42.6828822 C139.511673,39.4999129 137.294014,36.8694884 134.229854,35.8188751 L100.520177,24.2590155 L96.5006692,10.1940267 C95.5727291,6.94957708 92.8077024,4.51137591 89.456938,3.98217808 L64.9005881,0.104247522 C61.7510731,-0.394599255 58.4653037,0.925282388 56.5436454,3.45453672 L35.0694662,31.7370477 L20.3806046,31.1899506 C16.9476176,31.060764 13.8106318,32.9043959 12.2585834,35.9278276 L0.958073654,57.9393443 C-0.514884483,60.8110208 -0.276047571,64.2336856 1.58218191,66.8742271 L21.9960818,95.8890545 L16.9147286,109.657537 C15.7456023,112.823385 16.5404203,116.411035 18.9389693,118.797095 L36.5111015,136.280079 C38.1649492,137.924483 40.3630319,138.829567 42.7020675,138.829567 C43.5665788,138.829567 44.4256086,138.702715 45.2533155,138.451346 L79.3623589,128.111755 L90.9330284,137.143138 C92.4662831,138.340059 94.3863752,139 96.3370072,139 C97.7097321,139 99.081674,138.673143 100.304832,138.054448 L122.464199,126.847128 C125.353734,125.385608 127.185339,122.477354 127.245636,119.255473 L127.890104,83.8256787 L140.126385,75.6682498 C142.94466,73.7895976 144.4231,70.4221872 143.893743,67.0913539 Z" id="Fill-1"></path>
            </g>
        </g>
    </g>
</svg>
		<strong>' . esc_html__( 'Potter Kit', 'potter-kit' ) . '</strong> ' . sprintf( esc_html__( 'requires %s to be activated to work.', 'potter-kit' ), '<a href="' . esc_url( $themes_url ) . '">' . esc_html__( 'Potter Theme', 'potter-kit' ) . '</a>' ) . '</p></div>';
	}
}
