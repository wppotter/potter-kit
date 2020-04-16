<?php
/**
 * Admin View: Page - Importer
 *
 * @package Potter_Kit
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="wrap demo-importer">
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

	<div class="wp-filter hide-if-no-js">
		<div class="filter-section">


			<svg width="75px" height="52px" viewBox="0 0 300 214" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="float:left; margin-right: 20px;">
			    <defs>
			        <linearGradient x1="0%" y1="0%" x2="101.999998%" y2="100.999999%" id="linearGradient-1">
			            <stop stop-color="#3023AE" offset="0%"></stop>
			            <stop stop-color="#C86DD7" offset="100%"></stop>
			        </linearGradient>
			    </defs>
			    <g id="logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			        <g id="Group-91">
			            <path d="M3,0.5 L300,0.5 L300,213.5 L3,213.5 C1.34314575,213.5 2.02906125e-16,212.156854 0,210.5 L0,3.5 C-2.02906125e-16,1.84314575 1.34314575,0.5 3,0.5 Z" id="Rectangle" fill="url(#linearGradient-1)"></path>
			            <g id="Group-3" transform="translate(71.000000, 29.000000)" fill="#FFFFFF">
			                <path d="M140.272377,86.7749834 L140.494378,75.5728754 L140.465306,75.6010037 L140.465306,75.5957297 L124.384338,91.4478025 L149.659842,53.4842241 L153.523714,77.9057689 L140.272377,86.7749834 Z M134.581402,133.627115 L67.9089035,115.053626 L82.7221757,86.2475772 L109.37197,113.021354 L135.420953,87.3472192 L134.581402,133.627115 Z M108.233775,148.657313 L95.6942502,138.831735 L106.429578,135.573243 L86.326166,125.187736 L130.318457,137.444657 L108.233775,148.657313 Z M49.2837355,147.917186 L46.3792242,78.8647692 L78.4266351,84.0438982 L61.1739963,117.624731 L93.6477898,134.403281 L49.2837355,147.917186 Z M26.8158382,127.559306 L32.3103597,112.612614 L38.7307657,121.806183 L38.7422181,121.735862 L38.7712897,121.778055 L42.4158039,99.5927125 L42.4677803,100.825085 L44.328359,145.051612 L26.8158382,127.559306 Z M9.34296039,71.3738429 L74.2050948,47.2880801 L79.1939476,79.2849362 L41.8475874,73.2654732 L35.9028975,109.275012 L9.34296039,71.3738429 Z M21.8040805,43.7623695 L37.7238332,44.3574595 L30.9686639,53.2899628 L30.9730687,53.2890838 L30.9713068,53.2908418 L53.3246799,49.8996199 L10.5445841,65.7842161 L21.8040805,43.7623695 Z M69.913959,9.79389323 L112.931032,63.9435684 L86.4609522,77.2913407 L83.9678472,78.5483255 L78.149134,41.256311 L42.0017547,46.7404566 L69.913959,9.79389323 Z M100.083172,13.086666 L104.438618,28.3893574 L93.8345525,24.7291582 L103.98933,44.9296953 L75.6119812,9.2058353 L100.083172,13.086666 Z M147.338523,48.2593865 L109.011659,105.826654 L86.1482129,82.8493232 L119.913488,65.8492628 L103.488066,33.1738108 L147.338523,48.2593865 Z M161.880461,75.7794428 L157.51973,48.210162 C156.950632,44.6150096 154.455766,41.6439546 151.008585,40.4572906 L113.085199,27.4004707 L108.563253,11.5141165 C107.51932,7.84952232 104.408665,5.09558286 100.639055,4.49785582 L73.0131616,0.117747201 C69.4699572,-0.445698439 65.7734666,1.04510313 63.611601,3.9018868 L39.4531495,35.8468813 L22.9281801,35.228937 C19.0660698,35.0830213 15.5369608,37.1653968 13.7909063,40.580352 L1.07783286,65.442281 C-0.579245043,68.6858293 -0.310553517,72.5517168 1.77995465,75.534199 L24.745592,108.306342 L19.0290697,123.857793 C17.7138026,127.433608 18.6079728,131.485845 21.3063405,134.180891 L41.0749891,153.927859 C42.9355678,155.785208 45.4084108,156.807497 48.0398259,156.807497 C49.0124011,156.807497 49.9788097,156.664218 50.90998,156.380298 L89.2826537,144.701766 L102.299657,154.902681 C104.024568,156.254599 106.184672,157 108.379133,157 C109.923449,157 111.466883,156.630816 112.842936,155.932002 L137.772224,143.273374 C141.022951,141.622593 143.083507,138.337731 143.15134,134.698628 L143.876367,94.6808026 L157.642183,85.467016 C160.812743,83.345085 162.475987,79.5416072 161.880461,75.7794428 Z" id="Fill-1"></path>
			            </g>
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
					<# if ( data.isPremium ) { #>
						<span class="premium-demo-tag"><?php esc_html_e( 'Premium', 'potter-kit' ); ?></span>
					<# } #>

					<# if ( data.isPro ) { #>
						<span class="premium-demo-tag"><?php esc_html_e( 'Pro', 'potter-kit' ); ?></span>
					<# } #>
				</h3>

				<span class="theme-by">
					<?php
					/* translators: %s: Demo author name */
					printf( esc_html__( 'By %s', 'potter-kit' ), '{{ data.author }}' );
					?>
				</span>

				<img class="theme-screenshot" src="{{ data.screenshot_url }}" alt="" />

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
tg_print_admin_notice_templates();
