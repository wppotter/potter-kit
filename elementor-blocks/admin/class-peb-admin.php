<?php
/**
 * Entry point for the plugin. Checks if Elementor is installed and activated and loads it's own files and actions.
 *
 * @package  potter-elementor-blocks
 */

use PEB\Lib\Potter_Target_Rules_Fields;

defined( 'ABSPATH' ) or exit;

/**
 * PKEB_Admin setup
 *
 * @since 1.0
 */
class PKEB_Admin {

	/**
	 * Instance of PKEB_Admin
	 *
	 * @var PKEB_Admin
	 */
	private static $_instance = null;

	/**
	 * Instance of PKEB_Admin
	 *
	 * @return PKEB_Admin Instance of PKEB_Admin
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		add_action( 'elementor/init', __CLASS__ . '::load_admin', 0 );

		return self::$_instance;
	}

	/**
	 * Load the icons style in editor.
	 *
	 * @since 1.3.0
	 */
	public static function load_admin() {
		add_action( 'elementor/editor/after_enqueue_styles', __CLASS__ . '::peb_admin_enqueue_scripts' );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since 1.3.0
	 * @param string $hook Current page hook.
	 * @access public
	 */
	public static function peb_admin_enqueue_scripts( $hook ) {

		// Register the icons styles.
		wp_register_style(
			'peb-style',
			PKEB_URL . 'assets/css/style.css',
			[],
			PKEB_VER
		);

		wp_enqueue_style( 'peb-style' );
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'header_footer_posttype' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 50 );
		add_action( 'add_meta_boxes', [ $this, 'peb_register_metabox' ] );
		add_action( 'save_post', [ $this, 'peb_save_meta' ] );
		add_action( 'admin_notices', [ $this, 'location_notice' ] );
		add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );
		add_filter( 'single_template', [ $this, 'load_canvas_template' ] );
		add_filter( 'manage_elementor-pb_posts_columns', [ $this, 'set_shortcode_columns' ] );
		add_action( 'manage_elementor-pb_posts_custom_column', [ $this, 'render_shortcode_column' ], 10, 2 );
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) && ELEMENTOR_PRO_VERSION > 2.8 ) {
			add_action( 'elementor/editor/footer', [ $this, 'register_peb_epro_script' ], 99 );
		}

		if ( is_admin() ) {
			add_action( 'manage_elementor-pb_posts_custom_column', [ $this, 'column_content' ], 10, 2 );
			add_filter( 'manage_elementor-pb_posts_columns', [ $this, 'column_headings' ] );
		}
	}
	/**
	 * Script for Elementor Pro full site editing support.
	 *
	 * @since 1.4.0
	 *
	 * @return void
	 */


	/**
	 * Adds or removes list table column headings.
	 *
	 * @param array $columns Array of columns.
	 * @return array
	 */
	public function column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['elementor_hf_display_rules'] = __( 'Display Rules', 'potter-kit' );
		$columns['date']                       = __( 'Date', 'potter-kit' );
		return $columns;
	}

	/**
	 * Adds the custom list table column content.
	 *
	 * @since 1.2.0
	 * @param array $column Name of column.
	 * @param int   $post_id Post id.
	 * @return void
	 */
	public function column_content( $column, $post_id ) {

		if ( 'elementor_hf_display_rules' == $column ) {

			$locations = get_post_meta( $post_id, 'peb_target_include_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="pkt-advanced-headers-location-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Display: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$locations = get_post_meta( $post_id, 'peb_target_exclude_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="pkt-advanced-headers-exclusion-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Exclusion: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$users = get_post_meta( $post_id, 'peb_target_user_roles', true );
			if ( isset( $users ) && is_array( $users ) ) {
				if ( isset( $users[0] ) && ! empty( $users[0] ) ) {
					$user_label = [];
					foreach ( $users as $user ) {
						$user_label[] = Potter_Target_Rules_Fields::get_user_by_key( $user );
					}
					echo '<div class="pkt-advanced-headers-users-wrap">';
					echo '<strong>Users: </strong>';
					echo join( ', ', $user_label );
					echo '</div>';
				}
			}
		}
	}

	/**
	 * Get Markup of Location rules for Display rule column.
	 *
	 * @param array $locations Array of locations.
	 * @return void
	 */
	public function column_display_location_rules( $locations ) {

		$location_label = [];
		$index          = array_search( 'specifics', $locations['rule'] );
		if ( false !== $index && ! empty( $index ) ) {
			unset( $locations['rule'][ $index ] );
		}

		if ( isset( $locations['rule'] ) && is_array( $locations['rule'] ) ) {
			foreach ( $locations['rule'] as $location ) {
				$location_label[] = Potter_Target_Rules_Fields::get_location_by_key( $location );
			}
		}
		if ( isset( $locations['specific'] ) && is_array( $locations['specific'] ) ) {
			foreach ( $locations['specific'] as $location ) {
				$location_label[] = Potter_Target_Rules_Fields::get_location_by_key( $location );
			}
		}

		echo join( ', ', $location_label );
	}


	/**
	 * Register Post type for header footer & blocks templates
	 */
	public function header_footer_posttype() {
		$labels = [
			'name'               => __( 'Potter Elementor Blocks', 'potter-kit' ),
			'singular_name'      => __( 'Potter Elementor Blocks', 'potter-kit' ),
			'menu_name'          => __( 'Elementor Blocks', 'potter-kit' ),
			'name_admin_bar'     => __( 'Elementor Blocks', 'potter-kit' ),
			'add_new'            => __( 'Add New', 'potter-kit' ),
			'add_new_item'       => __( 'Add New Blocks', 'potter-kit' ),
			'new_item'           => __( 'New Block', 'potter-kit' ),
			'edit_item'          => __( 'Edit Block', 'potter-kit' ),
			'view_item'          => __( 'View Block', 'potter-kit' ),
			'all_items'          => __( 'All Elementor Blocks', 'potter-kit' ),
			'search_items'       => __( 'Search Blocks', 'potter-kit' ),
			'parent_item_colon'  => __( 'Parent Blocks:', 'potter-kit' ),
			'not_found'          => __( 'No Blocks found.', 'potter-kit' ),
			'not_found_in_trash' => __( 'No Blocks found in Trash.', 'potter-kit' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => [ 'title', 'thumbnail', 'elementor' ],
		];

		register_post_type( 'elementor-pb', $args );
	}

	/**
	 * Register the admin menu for Elementor Blocks builder.
	 *
	 * @since  1.0.0
	 * @since  1.0.1
	 *         Moved the menu under Appearance -> Elementor Blocks Builder
	 */
	public function register_admin_menu() {
		add_menu_page(
			__( 'Potter Kit', 'potter-kit' ),
			__( 'Potter Kit', 'potter-kit' ),
			'switch_themes',
			'potter-kit',
			array( $this, 'potter_kit_display' ),
			plugins_url( 'potter-kit/elementor-blocks/assets/image/potter.svg' )
		 );

		add_submenu_page(
			'potter-kit',
			__( 'Elementor Blocks', 'potter-kit' ),
			__( 'Elementor Blocks', 'potter-kit' ),
			'edit_pages',
			'edit.php?post_type=elementor-pb'
		);
	}


/* potter kit content */


	/**
	 * Register meta box(es).
	 */
	function peb_register_metabox() {
		add_meta_box(
			'peb-meta-box',
			__( 'Block Display Options', 'potter-kit' ),
			[
				$this,
				'efh_metabox_render',
			],
			'elementor-pb',
			'side',
			'high'
		);
	}

	/**
	 * Render Meta field.
	 *
	 * @param  POST $post Currennt post object which is being displayed.
	 */
	function efh_metabox_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['peb_template_type'] ) ? esc_attr( $values['peb_template_type'][0] ) : '';


		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'peb_meta_nounce', 'peb_meta_nounce' );
		?>
		<table class="peb-options-table widefat">
			<tbody>
				<tr class="peb-options-row type-of-template">

					<td class="peb-options-row-content">
							<label for="peb_template_type"><?php _e( 'Locations for display the block', 'potter-kit' ); ?></label>
						<select name="peb_template_type" id="peb_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php _e( 'Select Location', 'potter-kit' ); ?></option>
							<option value="type_before_header" <?php selected( $template_type, 'type_before_header' ); ?>><?php _e( 'Before Header', 'potter-kit' ); ?></option>
							<option value="type_after_header" <?php selected( $template_type, 'type_after_header' ); ?>><?php _e( 'After Header', 'potter-kit' ); ?></option>
							<option value="type_single_post_article_after" <?php selected( $template_type, 'type_single_post_article_after' ); ?>><?php _e( 'After Single Post Article', 'potter-kit' ); ?></option>
							<option value="type_before_footer" <?php selected( $template_type, 'type_before_footer' ); ?>><?php _e( 'Before Footer', 'potter-kit' ); ?></option>
							<option value="type_after_footer" <?php selected( $template_type, 'type_after_footer' ); ?>><?php _e( 'After Footer', 'potter-kit' ); ?></option>
							<option value="custom_location" <?php selected( $template_type, 'custom_location' ); ?>><?php _e( 'Custom Location', 'potter-kit' ); ?></option>
						</select>
					</td>
				</tr>

				<?php $this->display_rules_tab(); ?>
				<tr class="peb-options-row peb-shortcode">
					<td class="peb-options-row-content"	<label for="peb_template_type"><?php _e( 'Shortcode', 'potter-kit' ); ?></label>
						<span class="peb-shortcode-col-wrap">
							<input type="text" onfocus="this.select();" readonly="readonly" value="[peb_template id='<?php echo esc_attr( $post->ID ); ?>']" class="peb-large-text code">
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Markup for Display Rules Tabs.
	 *
	 * @since  1.0.0
	 */
	public function display_rules_tab() {
		// Load Target Rule assets.
		Potter_Target_Rules_Fields::get_instance()->admin_styles();

		$include_locations = get_post_meta( get_the_id(), 'peb_target_include_locations', true );
		$exclude_locations = get_post_meta( get_the_id(), 'peb_target_exclude_locations', true );
		$users             = get_post_meta( get_the_id(), 'peb_target_user_roles', true );
		?>
		<tr class="pebs-target-rules-row peb-options-row">

			<td class="pebs-target-rules-row-content peb-options-row-content">
				<label><?php esc_html_e( 'Display On', 'potter-kit' ); ?></label>
				<?php
				Potter_Target_Rules_Fields::target_rule_settings_field(
					'pebs-target-rules-location',
					[
						'title'          => __( 'Display Rules', 'potter-kit' ),
						'value'          => '[{"type":"basic-global","specific":null}]',
						'tags'           => 'site,enable,target,pages',
						'rule_type'      => 'display',
						'add_rule_label' => __( 'Add Display Rule', 'potter-kit' ),
					],
					$include_locations
				);
				?>
			</td>
		</tr>
		<tr class="pebs-target-rules-row peb-options-row">

			<td class="pebs-target-rules-row-content peb-options-row-content">

				<label><?php esc_html_e( 'Do Not Display On', 'potter-kit' ); ?></label>
				<?php
				Potter_Target_Rules_Fields::target_rule_settings_field(
					'pebs-target-rules-exclusion',
					[
						'title'          => __( 'Exclude On', 'potter-kit' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add Exclusion Rule', 'potter-kit' ),
						'rule_type'      => 'exclude',
					],
					$exclude_locations
				);
				?>
			</td>
		</tr>
		<tr class="pebs-target-rules-row peb-options-row">
			<td class="pebs-target-rules-row-content peb-options-row-content">
				<label><?php esc_html_e( 'User Roles', 'potter-kit' ); ?></label>

				<?php
				Potter_Target_Rules_Fields::target_user_role_settings_field(
					'pebs-target-rules-users',
					[
						'title'          => __( 'Users', 'potter-kit' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add User Rule', 'potter-kit' ),
					],
					$users
				);
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save meta field.
	 *
	 * @param  POST $post_id Currennt post object which is being displayed.
	 *
	 * @return Void
	 */
	public function peb_save_meta( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['peb_meta_nounce'] ) || ! wp_verify_nonce( $_POST['peb_meta_nounce'], 'peb_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$target_locations = Potter_Target_Rules_Fields::get_format_rule_value( $_POST, 'pebs-target-rules-location' );
		$target_exclusion = Potter_Target_Rules_Fields::get_format_rule_value( $_POST, 'pebs-target-rules-exclusion' );
		$target_users     = [];

		if ( isset( $_POST['pebs-target-rules-users'] ) ) {
			$target_users = array_map( 'sanitize_text_field', $_POST['pebs-target-rules-users'] );
		}

		update_post_meta( $post_id, 'peb_target_include_locations', $target_locations );
		update_post_meta( $post_id, 'peb_target_exclude_locations', $target_exclusion );
		update_post_meta( $post_id, 'peb_target_user_roles', $target_users );

		if ( isset( $_POST['peb_template_type'] ) ) {
			update_post_meta( $post_id, 'peb_template_type', esc_attr( $_POST['peb_template_type'] ) );
		}

		if ( isset( $_POST['display-on-canvas-template'] ) ) {
			update_post_meta( $post_id, 'display-on-canvas-template', esc_attr( $_POST['display-on-canvas-template'] ) );
		} else {
			delete_post_meta( $post_id, 'display-on-canvas-template' );
		}
	}

	/**
	 * Display notice when editing the header or footer when there is one more of similar layout is active on the site.
	 *
	 * @since 1.0.0
	 */
	public function location_notice() {
		global $pagenow;
		global $post;

		if ( 'post.php' != $pagenow || ! is_object( $post ) || 'elementor-pb' != $post->post_type ) {
			return;
		}

		$template_type = get_post_meta( $post->ID, 'peb_template_type', true );

		if ( '' !== $template_type ) {
			$templates = Potter_Elementor_Blocks::get_template_id( $template_type );

			// Check if more than one template is selected for current template type.
			if ( is_array( $templates ) && isset( $templates[1] ) && $post->ID != $templates[0] ) {
				$post_title        = '<strong>' . get_the_title( $templates[0] ) . '</strong>';
				$template_location = '<strong>' . $this->template_location( $template_type ) . '</strong>';
				/* Translators: Post title, Template Location */
				$message = sprintf( __( 'Template %1$s is already assigned to the location %2$s', 'potter-kit' ), $post_title, $template_location );

				echo '<div class="error"><p>';
				echo $message;
				echo '</p></div>';
			}
		}
	}

	/**
	 * Convert the Template name to be added in the notice.
	 *
	 * @since  1.0.0
	 *
	 * @param  String $template_type Template type name.
	 *
	 * @return String $template_type Template type name.
	 */
	public function template_location( $template_type ) {
		$template_type = ucfirst( str_replace( 'type_', '', $template_type ) );

		return $template_type;
	}

	/**
	 * Don't display the elementor header footer & blocks templates on the frontend for non edit_posts capable users.
	 *
	 * @since  1.0.0
	 */
	public function block_template_frontend() {
		if ( is_singular( 'elementor-pb' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * Single template function which will choose our template
	 *
	 * @since  1.0.1
	 *
	 * @param  String $single_template Single template.
	 */
	function load_canvas_template( $single_template ) {
		global $post;

		if ( 'elementor-pb' == $post->post_type ) {
			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}
		return $single_template;
	}

	/**
	 * Set shortcode column for template list.
	 *
	 * @param array $columns template list columns.
	 */
	function set_shortcode_columns( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['shortcode'] = __( 'Shortcode', 'potter-kit' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * Display shortcode in template list column.
	 *
	 * @param array $column template list column.
	 * @param int   $post_id post id.
	 */
	function render_shortcode_column( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				ob_start();
				?>
				<span class="peb-shortcode-col-wrap">
					<input type="text" onfocus="this.select();" readonly="readonly" value="[peb_template id='<?php echo esc_attr( $post_id ); ?>']" class="peb-large-text code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}
}

PKEB_Admin::instance();
