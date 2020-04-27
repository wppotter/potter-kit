<?php
/**
 * Admin View: Page - Importer
 *
 * @package Potter_Kit
 */

defined( 'ABSPATH' ) || exit;

?>


<div class="wrap demo-importer">
	<div class="wp-filter hide-if-no-js">
		<div class="filter-section">

			<svg width="35px"  viewBox="0 0 130 127" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: inline-block; padding: 10px; vertical-align: middle;">
			    <g id="logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			        <g id="Group-3" fill="#0056FF">
			            <path d="M112.564253,70.1937764 L112.742402,61.1321986 L112.719073,61.1549521 L112.719073,61.1506858 L99.8145926,73.9737001 L120.097404,43.2643087 L123.198042,63.0193162 L112.564253,70.1937764 Z M107.997421,108.093271 L54.4947991,93.0688564 L66.3819928,69.7671484 L87.7676305,91.4249167 L108.671135,70.6566677 L107.997421,108.093271 Z M86.8542642,120.251457 L76.7916823,112.303378 L85.4064514,109.667528 L69.2740838,101.266513 L104.57654,111.181346 L86.8542642,120.251457 Z M39.5486766,119.652756 L37.2178959,63.7950681 L62.9349541,67.9845546 L49.0902439,95.1486677 L75.149461,108.721125 L39.5486766,119.652756 Z M21.5188825,103.184916 L25.9280664,91.09428 L31.0802441,98.5311164 L31.0894343,98.4742327 L31.1127633,98.5083629 L34.0373735,80.5622579 L34.079083,81.5591452 L35.5721399,117.334744 L21.5188825,103.184916 Z M7.49743735,57.735529 L59.5472983,38.2521412 L63.5506987,64.1349484 L33.5813973,59.2657013 L28.8109671,88.3944361 L7.49743735,57.735529 Z M17.4971016,35.4001333 L30.2722118,35.8815119 L24.851397,43.1071674 L24.8549317,43.1064563 L24.8535178,43.1078784 L42.7914098,40.3646607 L8.46170332,53.2139837 L17.4971016,35.4001333 Z M56.1037942,7.92244866 L90.6236675,51.7250521 L69.3822456,62.5222947 L67.3816058,63.5390913 L62.712268,33.3729395 L33.7051118,37.8091592 L56.1037942,7.92244866 Z M80.3136566,10.5860292 L83.8087673,22.9646394 L75.2993322,20.0038414 L83.448228,36.3444032 L60.6762812,7.44675849 L80.3136566,10.5860292 Z M118.234618,39.0378477 L87.4784921,85.6050003 L69.131282,67.0182423 L96.2268728,53.2666011 L83.0459792,26.834866 L118.234618,39.0378477 Z M129.904074,61.2992945 L126.404722,38.9980291 C125.948038,36.0898485 123.945985,33.686511 121.179729,32.7265981 L90.747382,22.164712 L87.1186597,9.31396685 C86.280936,6.34961359 83.7847313,4.12190461 80.7597357,3.63839292 L58.5908087,0.0952477357 C55.7474966,-0.360533132 52.7811769,0.845401894 51.0463465,3.15630333 L31.6599348,28.9971587 L18.3991569,28.497293 C15.2999326,28.3792592 12.4679315,30.0637286 11.0667767,32.8261446 L0.864927604,52.9373866 C-0.464826269,55.5611485 -0.249209613,58.6883314 1.42835867,61.1009125 L19.8575738,87.6108628 L15.2702411,100.190699 C14.2147799,103.083237 14.9323238,106.361162 17.0976806,108.54123 L32.961411,124.514892 C34.454468,126.017334 36.4388482,126.844281 38.5504776,126.844281 C39.3309392,126.844281 40.1064522,126.72838 40.8536876,126.498712 L71.646574,117.051747 L82.0923173,125.303443 C83.4765056,126.397032 85.2099221,127 86.9709093,127 C88.2101748,127 89.4487335,126.70136 90.5529735,126.136078 L110.557958,115.896296 C113.166566,114.560951 114.820098,111.90377 114.874532,108.960037 L115.456344,76.5889295 L126.502986,69.1357391 C129.047263,67.4192726 130.381965,64.342574 129.904074,61.2992945 Z" id="Fill-1"></path>
			        </g>
			    </g>
			</svg>
			<div class="filter-count">
				<span class="count theme-count demo-count"></span>
			</div>

			<?php if ( ! empty( $this->demo_packages->categories ) ) : ?>
				<ul class="filter-links categories">
					<?php foreach ( $this->demo_packages->categories as $slug => $label ) : ?>
						<li><a href="#" data-sort="<?php echo esc_attr( $slug ); ?>" class="category-tab"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="filter-section right">
			<?php if ( ! empty( $this->demo_packages->pagebuilders ) ) : ?>
				<ul class="filter-links pagebuilders">
					<?php foreach ( $this->demo_packages->pagebuilders as $slug => $label ) : ?>
						<?php if ( 'default' !== $slug ) : ?>
							<li><a href="#" data-type="<?php echo esc_attr( $slug ); ?>" class="pagebuilder-tab"><?php echo esc_html( $label ); ?></a></li>
						<?php else : ?>
							<li><a href="#" data-type="<?php echo esc_attr( $slug ); ?>" class="pagebuilder-tab tips" data-tip="<?php esc_attr_e( 'Without Page Builder', 'potter-kit' ); ?>"><?php echo esc_html( $label ); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<form class="search-form"></form>
		</div>
	</div>
	<div class="admin-heading-content">
	<h1 class="wp-heading-inline"><span class="count theme-count demo-count"></span><?php esc_html_e( 'Ready to use websites', 'potter-kit' ); ?></h1>
	<p>Import any of the demo and change content image to match your requirements. </p>
	</div>
	<?php if ( apply_filters( 'wppotter_demo_importer_upcoming_demos', false ) ) : ?>
		<a href="<?php echo esc_url( 'https://wppotter.com/upcoming-demos' ); ?>" class="page-title-action" target="_blank"><?php esc_html_e( 'Upcoming Demos', 'potter-kit' ); ?></a>
	<?php endif; ?>

	<hr class="wp-header-end">

	<div class="error hide-if-js">
		<p><?php esc_html_e( 'The Demo Importer screen requires JavaScript.', 'potter-kit' ); ?></p>
	</div>

	<h2 class="screen-reader-text hide-if-no-js"><?php esc_html_e( 'Filter demos list', 'potter-kit' ); ?></h2>


	<h2 class="screen-reader-text hide-if-no-js"><?php esc_html_e( 'Themes list', 'potter-kit' ); ?></h2>
	<div class="theme-browser content-filterable"></div>
	<div class="theme-install-overlay wp-full-overlay expanded"></div>

	<p class="no-themes"><?php esc_html_e( 'No demos found. Try a different search.', 'potter-kit' ); ?></p>
	<span class="spinner"></span>
</div>

<script id="tmpl-demo" type="text/template">
	<# if ( data.screenshot_url ) { #>
		<div class="theme-screenshot">
			<img src="{{ data.screenshot_url }}" alt="" />
		</div>
	<# } else { #>
		<div class="theme-screenshot blank"></div>
	<# } #>

	<# if ( data.isPremium ) { #>
		<span class="premium-demo-banner"><?php esc_html_e( 'Premium', 'potter-kit' ); ?></span>
	<# } #>

	<# if ( data.isPro ) { #>
		<span class="premium-demo-banner"><?php esc_html_e( 'Pro', 'potter-kit' ); ?></span>
	<# } #>

	<div class="theme-author">
		<?php
		/* translators: %s: Demo author name */
		printf( esc_html__( 'By %s', 'potter-kit' ), '{{{ data.author }}}' );
		?>
	</div>

	<div class="theme-id-container">
		<# if ( data.active ) { #>
			<h2 class="theme-name" id="{{ data.id }}-name">
				<?php
				/* translators: %s: Demo name */
				printf( __( '<span>Imported:</span> %s', 'potter-kit' ), '{{{ data.name }}}' ); // @codingStandardsIgnoreLine
				?>
			</h2>
		<# } else { #>
			<h2 class="theme-name" id="{{ data.id }}-name">{{{ data.name }}}</h2>
		<# } #>

		<div class="theme-actions">
			<# if ( data.active ) { #>
				<a class="button button-primary live-preview" target="_blank" href="<?php echo esc_url_raw( home_url( '/' ) ); ?>"><?php esc_html_e( 'Live Preview', 'potter-kit' ); ?></a>
			<# } else { #>
				<# if ( data.isPremium ) { #>
					<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e( 'Buy Now', 'potter-kit' ); ?></a>
				<# } else if ( data.isPro ) { #>
					<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e( 'Buy Now', 'potter-kit' ); ?></a>
				<# } else { #>
					<?php
					/* translators: %s: Demo name */
					$aria_label = sprintf( esc_html_x( 'Import %s', 'demo', 'potter-kit' ), '{{ data.name }}' );
					?>
					<a class="button button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}" aria-label="<?php echo esc_attr( $aria_label ); ?>" data-plugins="{{ JSON.stringify( data.plugins ) }}"><?php esc_html_e( 'Import', 'potter-kit' ); ?></a>
				<# } #>
				<button class="button preview install-demo-preview"><?php esc_html_e( 'Preview', 'potter-kit' ); ?></button>
			<# } #>
		</div>
	</div>

	<# if ( data.imported ) { #>
		<div class="notice notice-success notice-alt"><p><?php echo esc_html_x( 'Imported', 'demo', 'potter-kit' ); ?></p></div>
	<# } #>
</script>

<script id="tmpl-demo-preview" type="text/template">
	<div class="wp-full-overlay-sidebar">
		<div class="wp-full-overlay-header">
			<button class="close-full-overlay"><span class="screen-reader-text"><?php esc_html_e( 'Close', 'potter-kit' ); ?></span></button>
			<button class="previous-theme"><span class="screen-reader-text"><?php echo esc_html_x( 'Previous', 'Button label for a demo', 'potter-kit' ); ?></span></button>
			<button class="next-theme"><span class="screen-reader-text"><?php echo esc_html_x( 'Next', 'Button label for a demo', 'potter-kit' ); ?></span></button>
			<# if ( data.isPremium ) { #>
				<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e( 'Buy Now', 'potter-kit' ); ?></a>
			<# } else if ( data.isPro ) { #>
				<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e( 'Buy Now', 'potter-kit' ); ?></a>
			<# } else if ( data.requiredTheme ) { #>
				<button class="button button-primary hide-if-no-js disabled"><?php esc_html_e( 'Import Demo', 'potter-kit' ); ?></button>
			<# } else { #>
				<# if ( data.active ) { #>
					<a class="button button-primary live-preview" target="_blank" href="<?php echo esc_url_raw( home_url( '/' ) ); ?>"><?php esc_html_e( 'Live Preview', 'potter-kit' ); ?></a>
				<# } else { #>
					<a class="button button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}"><?php esc_html_e( 'Import Demo', 'potter-kit' ); ?></a>
				<# } #>
			<# } #>
		</div>
		<div class="wp-full-overlay-sidebar-content">
			<div class="install-theme-info">
				<h3 class="theme-name">
					{{ data.name }}
				</h3>

				<span class="theme-by">
					<?php
					/* translators: %s: Demo author name */
					printf( esc_html__( 'By %s', 'potter-kit' ), '{{ data.author }}' );
					?>
				</span>
				<div class="install-screenshot">
				<img class="theme-screenshot" src="{{ data.screenshot_url }}" alt="" />
			</div>

				<div class="theme-details">
					<# if ( ! data.isPremium && data.requiredTheme ) { #>
						<div class="demo-message notice notice-error notice-alt"><p>
							<?php
							/* translators: %s: Theme Name */
							printf( esc_html__( '%s theme is not active.', 'potter-kit' ), '<strong>{{{ data.theme }}}</strong>' );
							?>
						</p></div>
					<# } #>

					<# if ( ! data.isPro && data.requiredTheme ) { #>
						<div class="demo-message notice notice-error notice-alt"><p>
						<?php
						/* translators: %s: Theme Name */
						printf( esc_html__( '%s theme is not active.', 'potter-kit' ), '<strong>{{{ data.theme }}}</strong>' );
						?>
						</p></div>
					<# } #>
					<div class="theme-version">
						<?php
						/* translators: %s: Demo version */
						printf( esc_html__( 'Version: %s', 'potter-kit' ), '{{ data.version }}', 'potter-kit' );
						?>
					</div>
					<div class="theme-description">{{{ data.description }}}</div>
				</div>

				<div class="plugins-details">
					<h4 class="plugins-info"><?php esc_html_e( 'Plugins Information', 'potter-kit' ); ?></h4>

					<table class="plugins-list-table widefat striped">
						<thead>
							<tr>
								<th scope="col" class="manage-column required-plugins" colspan="2"><?php esc_html_e( 'Required Plugins', 'potter-kit' ); ?></th>
							</tr>
						</thead>
						<tbody id="the-list">
							<# if ( ! _.isEmpty( data.plugins ) ) { #>
								<# _.each( data.plugins, function( plugin, slug ) { #>
									<tr class="plugin<# if ( ! plugin.is_active ) { #> inactive<# } #>" data-slug="{{ slug }}" data-plugin="{{ plugin.slug }}" data-name="{{ plugin.name }}">
										<td class="plugin-name">
											<a href="<?php printf( esc_url( 'https://wordpress.org/plugins/%s' ), '{{ slug }}' ); ?>" target="_blank">{{ plugin.name }}</a>
										</td>
										<td class="plugin-status">
											<# if ( plugin.is_active && plugin.is_install ) { #>
												<span class="active"></span>
											<# } else if ( plugin.is_install ) { #>
												<span class="activate-now<# if ( ! data.requiredPlugins ) { #> active<# } #>"></span>
											<# } else { #>
												<span class="install-now<# if ( ! data.requiredPlugins ) { #> active<# } #>"></span>
											<# } #>
										</td>
									</tr>
								<# }); #>
							<# } else { #>
								<tr class="no-items">
									<td class="colspanchange" colspan="4"><?php esc_html_e( 'No plugins are required for this demo.', 'potter-kit' ); ?></td>
								</tr>
							<# } #>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="wp-full-overlay-footer">
			<div class="demo-import-actions">
				<# if ( data.isPremium ) { #>
					<a class="button button-hero button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e( 'Buy Now', 'potter-kit' ); ?></a>
				<# } else if ( data.isPro ) { #>
					<a class="button button-hero button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e( 'Buy Now', 'potter-kit' ); ?></a>
				<# } else if ( data.requiredTheme ) { #>
					<button class="button button-hero button-primary hide-if-no-js disabled"><?php esc_html_e( 'Import Demo', 'potter-kit' ); ?></button>
				<# } else { #>
					<# if ( data.active ) { #>
						<a class="button button-primary live-preview button-hero hide-if-no-js" target="_blank" href="<?php echo esc_url_raw( home_url( '/' ) ); ?>"><?php esc_html_e( 'Live Preview', 'potter-kit' ); ?></a>
					<# } else { #>
						<a class="button button-hero button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}"><?php esc_html_e( 'Import Demo', 'potter-kit' ); ?></a>
					<# } #>
				<# } #>
			</div>
			<button type="button" class="collapse-sidebar button" aria-expanded="true" aria-label="<?php esc_attr_e( 'Collapse Sidebar', 'potter-kit' ); ?>">
				<span class="collapse-sidebar-arrow"></span>
				<span class="collapse-sidebar-label"><?php esc_html_e( 'Collapse', 'potter-kit' ); ?></span>
			</button>
			<div class="devices-wrapper">
				<div class="devices">
					<button type="button" class="preview-desktop active" aria-pressed="true" data-device="desktop">
						<span class="screen-reader-text"><?php esc_html_e( 'Enter desktop preview mode', 'potter-kit' ); ?></span>
					</button>
					<button type="button" class="preview-tablet" aria-pressed="false" data-device="tablet">
						<span class="screen-reader-text"><?php esc_html_e( 'Enter tablet preview mode', 'potter-kit' ); ?></span>
					</button>
					<button type="button" class="preview-mobile" aria-pressed="false" data-device="mobile">
						<span class="screen-reader-text"><?php esc_html_e( 'Enter mobile preview mode', 'potter-kit' ); ?></span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="wp-full-overlay-main">
		<iframe src="{{ data.preview_url }}" title="<?php esc_attr_e( 'Preview', 'potter-kit' ); ?>"></iframe>
	</div>
</script>

<?php
wp_print_request_filesystem_credentials_modal();
wp_print_admin_notice_templates();
pk_print_admin_notice_templates();
