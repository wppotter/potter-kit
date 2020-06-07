<?php
/**
 * Potter Kit setup
 *
 * @package Potter_Kit
 * @since   1.0.4
 */

defined('ABSPATH') || exit;

/**
 * Main Potter Kit Class.
 *
 * @class Potter_Kit
 */
final class Potter_Kit
{

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
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 1.4
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'potter-kit'), '1.4');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.4
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'potter-kit'), '1.4');
    }

    /**
     * Initialize the plugin.
     */
    private function __construct()
    {
        $this->define_constants();
        $this->init_hooks();

        do_action('wppotter_demo_importer_loaded');
    }

    /**
     * Define WPPK Constants.
     */
    private function define_constants()
    {
        $upload_dir = wp_upload_dir(null, false);

        $this->define('WPPK_ABSPATH', dirname(WPPK_PLUGIN_FILE) . '/');
        $this->define('WPPK_PLUGIN_BASENAME', plugin_basename(WPPK_PLUGIN_FILE));
        $this->define('WPPK_VERSION', $this->version);
        $this->define('WPPK_DEMO_DIR', $upload_dir['basedir'] . '/pk-demo-pack/');
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (! defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Hook into actions and filters.
     */
    private function init_hooks()
    {
        // Load plugin text domain.
        add_action('init', array( $this, 'load_plugin_textdomain' ));

        // Register activation hook.
        register_activation_hook(WPPK_PLUGIN_FILE, array( $this, 'install' ));

        // Register deactivation hook.
        register_deactivation_hook(WPPK_PLUGIN_FILE, array( $this, 'deactivate' ));

        // Check if Potter theme is installed.
        if (in_array(get_option('template'), $this->get_core_supported_themes(), true)) {
            $this->includes();

            add_filter('plugin_action_links_' . WPPK_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ));
            add_filter('plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2);

        } else {
            add_action('admin_notices', array( $this, 'theme_support_missing_notice' ));
        }

    }

    /**
     * Get core supported themes.
     *
     * @return array
     */
    private function get_core_supported_themes()
    {
        $core_themes = array( 'potter' );
        return array_merge($core_themes);
        
    }

    /**
     * Include required core files.
     */
    private function includes()
    {
        include_once WPPK_ABSPATH . 'inc/class-demo-importer.php';
        include_once WPPK_ABSPATH . 'inc/functions-demo-importer.php';

        // Backward compatibility for demo packages config.
        if (file_exists(WPPK_DEMO_DIR . 'pk-demo-config.php')) {
            include_once WPPK_DEMO_DIR . 'pk-demo-config.php';
        }
    }

    /**
     * Install TG Demo Importer.
     */
    public function install()
    {
        $files = array(
            array(
                'base'    => WPPK_DEMO_DIR,
                'file'    => 'index.html',
                'content' => '',
            ),
        );

        // Bypass if filesystem is read-only and/or non-standard upload system is used.
        if (! is_blog_installed() || apply_filters('wppotter_demo_importer_install_skip_create_files', false)) {
            return;
        }

        // Install files and folders.
        foreach ($files as $file) {
            if (wp_mkdir_p($file['base']) && ! file_exists(trailingslashit($file['base']) . $file['file'])) {
                $file_handle = @fopen(trailingslashit($file['base']) . $file['file'], 'w'); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
                if ($file_handle) {
                    fwrite($file_handle, $file['content']); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
                    fclose($file_handle); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
                }
            }
        }

        // Redirect to demo importer page.
        set_transient('_pk_demo_importer_activation_redirect', 1, 30);
    }



    /**
     * Deactivation hook.
     */
    public function deactivate()
    {
        include_once dirname(__FILE__) . '/class-demo-importer-deactivator.php';

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
    public function load_plugin_textdomain()
    {
        $locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
        $locale = apply_filters('plugin_locale', $locale, 'potter-kit');

        unload_textdomain('potter-kit');
        load_textdomain('potter-kit', WP_LANG_DIR . '/potter-kit/potter-kit-' . $locale . '.mo');
        load_plugin_textdomain('potter-kit', false, plugin_basename(dirname(WPPK_PLUGIN_FILE)) . '/languages');
    }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url()
    {
        return untrailingslashit(plugins_url('/', WPPK_PLUGIN_FILE));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path()
    {
        return untrailingslashit(plugin_dir_path(WPPK_PLUGIN_FILE));
    }

    /**
     * Display action links in the Plugins list table.
     *
     * @param  array $actions Plugin Action links.
     * @return array
     */


    public function plugin_action_links($actions)
    {
        $new_actions = array(
            'importer' => '<a href="' . admin_url('themes.php?page=demo-importer') . '" aria-label="' . esc_attr(__('View Demo Importer', 'potter-kit')) . '">' . __('Demo Sites', 'potter-kit') . '</a>',
        );

        return array_merge($new_actions, $actions);
    }

    /**
     * Display row meta in the Plugins list table.
     *
     * @param  array  $plugin_meta Plugin Row Meta.
     * @param  string $plugin_file Plugin Row Meta.
     * @return array
     */
    public function plugin_row_meta($plugin_meta, $plugin_file)
    {
        if (WPPK_PLUGIN_BASENAME === $plugin_file) {
            $new_plugin_meta = array(
                'docs'    => '<a href="' . esc_url(apply_filters('wppotter_demo_importer_docs_url', 'https://wppotter.com/potter-kit/docs/')) . '" title="' . esc_attr(__('View Demo Importer Documentation', 'potter-kit')) . '">' . __('Docs', 'potter-kit') . '</a>',
                'support' => '<a href="' . esc_url(apply_filters('wppotter_demo_importer_support_url', 'https://pottertheme.com/support')) . '" title="' . esc_attr(__('Visit Free Customer Support Forum', 'potter-kit')) . '">' . __('Free Support', 'potter-kit') . '</a>',
            );

            return array_merge($plugin_meta, $new_plugin_meta);
        }

        return (array) $plugin_meta;
    }

    /**
     * Theme support fallback notice.
     */
    public function theme_support_missing_notice()
    {
        $themes_url = array_intersect(array_keys(wp_get_themes()), $this->get_core_supported_themes()) ? admin_url('themes.php?search=potter') : admin_url('theme-install.php?search=potter');

        /* translators: %s: Potter Theme URL */
        echo '<div class="error notice is-dismissible"><p style="font-size: 16px;">
<svg width="50px" height="50px" viewBox="0 0 362 362" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: inline-block; vertical-align: middle; margin-right: 20px;">
	<defs>
			<linearGradient x1="0%" y1="0%" x2="101.315975%" y2="100.322682%" id="linearGradient-1">
					<stop stop-color="#372E8B" offset="0%"></stop>
					<stop stop-color="#753E7E" offset="100%"></stop>
			</linearGradient>
	</defs>
	<g id="logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<path d="M97.8266208,341.8005 C39.7108455,311.679242 0,250.977103 0,181 C0,81.0364603 81.0364603,0 181,0 C280.96354,0 362,81.0364603 362,181 C362,279.883851 282.704607,360.247271 184.232363,361.971718 C194.582499,358.226645 193.499867,352.433108 193.499867,352.433108 L193.499867,289.211653 L158.278654,289.211653 C89.41688,292.123936 95.2603648,334.132043 95.2603648,334.132043 C95.6602411,336.966062 96.552089,339.512512 97.8266208,341.8005 Z M89,296.698712 C107.780647,269.663474 150.767202,268.831648 150.767202,268.831648 L211.281524,268.831648 C308.106052,254.2738 297.671962,164.848932 297.671962,164.848932 C286.404111,84.1591301 212.11618,80 212.11618,80 L157.444446,80 C92.7559502,80.4150205 89,127.831781 89,127.831781 L89,296.698712 Z" id="Combined-Shape-Copy-3" fill="url(#linearGradient-1)"></path>
	</g>

</svg>
		<strong>' . esc_html__('Potter Kit', 'potter-kit') . '</strong> ' . sprintf(esc_html__('requires %s to be activated to work.', 'potter-kit'), '<a href="' . esc_url($themes_url) . '">' . esc_html__('Potter Theme', 'potter-kit') . '</a>') . '</p></div>';
    }
}
