<?php
/**
 * Admin View: Page - Importer
 *
 * @package Potter_Kit
 */

defined('ABSPATH') || exit;

?>
<div class="wrap demo-importer">
	<div class="wp-filter hide-if-no-js">
		<div class="filter-section">
		<svg width="25px" viewBox="0 0 152 193" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display:inline-block; margin: 0px 5px 0px 20px; vertical-align: middle;">
	<g id="logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<g id="Group-128-Copy">
					<path d="M71.9769977,138 C71.9765244,168.689318 71.9762877,184.033977 71.9762877,184.033977 C71.9762877,184.033977 70.5033217,189.395508 65.137403,191 C59.7714844,192.604492 49,192.604492 37.0898437,192.604492 C25.1796875,192.604492 2.83841374,190.090823 0.0900156481,170.708267 C0.0900156481,170.708267 -4.18592558,140.120546 46.2033387,138 L71.9769977,138 Z" id="Fill-4" fill="#0F89FF"></path>
					<path d="M1.91344241e-12,43.2397799 C1.91344241e-12,43.2397799 2.69565672,9.29550782 49.1227841,8.99840679 C95.5499114,8.70130575 88.3608508,8.99840679 88.3608508,8.99840679 C88.3608508,8.99840679 141.677521,11.9758064 149.764492,69.7392751 C149.764492,69.7392751 157.18081,137.027555 87.7618159,145.165538 C54.1334456,149.107789 34.3083092,148.251651 23.1763941,149.766655 C12.044479,151.28166 2.34519441,156.198207 0,172.625488 L1.91344241e-12,43.2397799 Z" id="Fill-1" fill-opacity="0.413581295" fill="#505877"></path>
					<path d="M1.93895594e-12,35.6545192 C1.93895594e-12,35.6545192 2.73160017,1.30068576 49.7777792,1 C96.8239582,0.699314236 89.5390398,1 89.5390398,1 C89.5390398,1 143.566626,4.013324 151.761427,62.4737495 C151.761427,62.4737495 159.276633,130.573909 88.9320175,138.810083 C54.8552521,142.7999 34.7657705,141.933432 23.4854243,143.466716 C12.2050781,145 2.37646484,152 0,168.625488 L1.93895594e-12,35.6545192 Z" id="Fill-1" fill="#07123B"></path>
			</g>
				</g>
			</svg>
			<div class="filter-count">
				<span class="count theme-count demo-count"></span>
			</div>

			<?php if (! empty($this->demo_packages->categories)) : ?>
				<ul class="filter-links categories">
					<?php foreach ($this->demo_packages->categories as $slug => $label) : ?>
						<li><a href="#" data-sort="<?php echo esc_attr($slug); ?>" class="category-tab"><?php echo esc_html($label); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="filter-section right">
			<?php if (! empty($this->demo_packages->pagebuilders)) : ?>
				<ul class="filter-links pagebuilders">
					<?php foreach ($this->demo_packages->pagebuilders as $slug => $label) : ?>
						<?php if ('default' !== $slug) : ?>
							<li><a href="#" data-type="<?php echo esc_attr($slug); ?>" class="pagebuilder-tab"><?php echo esc_html($label); ?></a></li>
						<?php else : ?>
							<li><a href="#" data-type="<?php echo esc_attr($slug); ?>" class="pagebuilder-tab tips" data-tip="<?php esc_attr_e('Without Page Builder', 'potter-kit'); ?>"><?php echo esc_html($label); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<form class="search-form"></form>
		</div>
	</div>
	<div class="admin-heading-content">
	<h1 class="wp-heading-inline"><span class="count theme-count demo-count"></span><?php esc_html_e('Ready to use websites', 'potter-kit'); ?></h1>
	<p>Import any of the demo and change content image to match your requirements. </p>
	</div>
	<?php if (apply_filters('wppotter_demo_importer_upcoming_demos', false)) : ?>
		<a href="<?php echo esc_url('https://wppotter.com/upcoming-demos'); ?>" class="page-title-action" target="_blank"><?php esc_html_e('Upcoming Demos', 'potter-kit'); ?></a>
	<?php endif; ?>
<?php do_action( 'elementor_block_message' ); ?>
	<hr class="wp-header-end">

	<div class="error hide-if-js">
		<p><?php esc_html_e('The Demo Importer screen requires JavaScript.', 'potter-kit'); ?></p>
	</div>

	<h2 class="screen-reader-text hide-if-no-js"><?php esc_html_e('Filter demos list', 'potter-kit'); ?></h2>


	<h2 class="screen-reader-text hide-if-no-js"><?php esc_html_e('Themes list', 'potter-kit'); ?></h2>
	<div class="theme-browser content-filterable"></div>
	<div class="theme-install-overlay wp-full-overlay expanded"></div>

	<p class="no-themes"><?php esc_html_e('No demos found. Try a different search.', 'potter-kit'); ?></p>
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
		<span class="premium-demo-banner"><?php esc_html_e('Premium', 'potter-kit'); ?></span>
	<# } #>

	<# if ( data.isPro ) { #>
		<span class="premium-demo-banner"><?php esc_html_e('Pro', 'potter-kit'); ?></span>
	<# } #>

	<div class="theme-author">
		<?php
        /* translators: %s: Demo author name */
        printf(esc_html__('By %s', 'potter-kit'), '{{{ data.author }}}');
        ?>
	</div>

	<div class="theme-id-container">
		<# if ( data.active ) { #>
			<h2 class="theme-name" id="{{ data.id }}-name">
				<?php
                /* translators: %s: Demo name */
                printf(__('<span>Imported:</span> %s', 'potter-kit'), '{{{ data.name }}}'); // @codingStandardsIgnoreLine
                ?>
			</h2>
		<# } else { #>
			<h2 class="theme-name" id="{{ data.id }}-name">{{{ data.name }}}</h2>
		<# } #>

		<div class="theme-actions">
			<# if ( data.active ) { #>
				<a class="button button-primary live-preview" target="_blank" href="<?php echo esc_url_raw(home_url('/')); ?>"><?php esc_html_e('Live Preview', 'potter-kit'); ?></a>
			<# } else { #>
				<# if ( data.isPremium ) { #>
					<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e('Buy Now', 'potter-kit'); ?></a>
				<# } else if ( data.isPro ) { #>
					<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e('Buy Now', 'potter-kit'); ?></a>
				<# } else { #>
					<?php
                    /* translators: %s: Demo name */
                    $aria_label = sprintf(esc_html_x('Import %s', 'demo', 'potter-kit'), '{{ data.name }}');
                    ?>
					<a class="button button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}" aria-label="<?php echo esc_attr($aria_label); ?>" data-plugins="{{ JSON.stringify( data.plugins ) }}"><?php esc_html_e('Import', 'potter-kit'); ?></a>
				<# } #>
				<button class="button preview install-demo-preview"><?php esc_html_e('Preview', 'potter-kit'); ?></button>
			<# } #>
		</div>
	</div>

	<# if ( data.imported ) { #>
		<div class="notice notice-success notice-alt"><p><?php echo esc_html_x('Imported', 'demo', 'potter-kit'); ?></p></div>
	<# } #>
</script>

<script id="tmpl-demo-preview" type="text/template">
	<div class="wp-full-overlay-sidebar">
		<div class="wp-full-overlay-header">
			<button class="close-full-overlay"><span class="screen-reader-text"><?php esc_html_e('Close', 'potter-kit'); ?></span></button>
			<button class="previous-theme"><span class="screen-reader-text"><?php echo esc_html_x('Previous', 'Button label for a demo', 'potter-kit'); ?></span></button>
			<button class="next-theme"><span class="screen-reader-text"><?php echo esc_html_x('Next', 'Button label for a demo', 'potter-kit'); ?></span></button>
			<# if ( data.isPremium ) { #>
				<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e('Buy Now', 'potter-kit'); ?></a>
			<# } else if ( data.isPro ) { #>
				<a class="button button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e('Buy Now', 'potter-kit'); ?></a>
			<# } else if ( data.requiredTheme ) { #>
				<button class="button button-primary hide-if-no-js disabled"><?php esc_html_e('Import Demo', 'potter-kit'); ?></button>
			<# } else { #>
				<# if ( data.active ) { #>
					<a class="button button-primary live-preview" target="_blank" href="<?php echo esc_url_raw(home_url('/')); ?>"><?php esc_html_e('Live Preview', 'potter-kit'); ?></a>
				<# } else { #>
					<a class="button button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}"><?php esc_html_e('Import Demo', 'potter-kit'); ?></a>
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
                    printf(esc_html__('By %s', 'potter-kit'), '{{ data.author }}');
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
                            printf(esc_html__('%s theme is not active.', 'potter-kit'), '<strong>{{{ data.theme }}}</strong>');
                            ?>
						</p></div>
					<# } #>

					<# if ( ! data.isPro && data.requiredTheme ) { #>
						<div class="demo-message notice notice-error notice-alt"><p>
						<?php
                        /* translators: %s: Theme Name */
                        printf(esc_html__('%s theme is not active.', 'potter-kit'), '<strong>{{{ data.theme }}}</strong>');
                        ?>
						</p></div>
					<# } #>
					<div class="theme-version">
						<?php
                        /* translators: %s: Demo version */
                        printf(esc_html__('Version: %s', 'potter-kit'), '{{ data.version }}', 'potter-kit');
                        ?>
					</div>
					<div class="theme-description">{{{ data.description }}}</div>
				</div>

				<div class="plugins-details">
					<h4 class="plugins-info"><?php esc_html_e('Plugins Information', 'potter-kit'); ?></h4>

					<table class="plugins-list-table widefat striped">
						<thead>
							<tr>
								<th scope="col" class="manage-column required-plugins" colspan="2"><?php esc_html_e('Required Plugins', 'potter-kit'); ?></th>
							</tr>
						</thead>
						<tbody id="the-list">
							<# if ( ! _.isEmpty( data.plugins ) ) { #>
								<# _.each( data.plugins, function( plugin, slug ) { #>
									<tr class="plugin<# if ( ! plugin.is_active ) { #> inactive<# } #>" data-slug="{{ slug }}" data-plugin="{{ plugin.slug }}" data-name="{{ plugin.name }}">
										<td class="plugin-name">
											<a href="<?php printf(esc_url('https://wordpress.org/plugins/%s'), '{{ slug }}'); ?>" target="_blank">{{ plugin.name }}</a>
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
									<td class="colspanchange" colspan="4"><?php esc_html_e('No plugins are required for this demo.', 'potter-kit'); ?></td>
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
					<a class="button button-hero button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e('Buy Now', 'potter-kit'); ?></a>
				<# } else if ( data.isPro ) { #>
					<a class="button button-hero button-primary purchase-now" href="{{ data.homepage }}" target="_blank"><?php esc_html_e('Buy Now', 'potter-kit'); ?></a>
				<# } else if ( data.requiredTheme ) { #>
					<button class="button button-hero button-primary hide-if-no-js disabled"><?php esc_html_e('Import Demo', 'potter-kit'); ?></button>
				<# } else { #>
					<# if ( data.active ) { #>
						<a class="button button-primary live-preview button-hero hide-if-no-js" target="_blank" href="<?php echo esc_url_raw(home_url('/')); ?>"><?php esc_html_e('Live Preview', 'potter-kit'); ?></a>
					<# } else { #>
						<a class="button button-hero button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}"><?php esc_html_e('Import Demo', 'potter-kit'); ?></a>
					<# } #>
				<# } #>
			</div>
			<button type="button" class="collapse-sidebar button" aria-expanded="true" aria-label="<?php esc_attr_e('Collapse Sidebar', 'potter-kit'); ?>">
				<span class="collapse-sidebar-arrow"></span>
				<span class="collapse-sidebar-label"><?php esc_html_e('Collapse', 'potter-kit'); ?></span>
			</button>
			<div class="devices-wrapper">
				<div class="devices">
					<button type="button" class="preview-desktop active" aria-pressed="true" data-device="desktop">
						<span class="screen-reader-text"><?php esc_html_e('Enter desktop preview mode', 'potter-kit'); ?></span>
					</button>
					<button type="button" class="preview-tablet" aria-pressed="false" data-device="tablet">
						<span class="screen-reader-text"><?php esc_html_e('Enter tablet preview mode', 'potter-kit'); ?></span>
					</button>
					<button type="button" class="preview-mobile" aria-pressed="false" data-device="mobile">
						<span class="screen-reader-text"><?php esc_html_e('Enter mobile preview mode', 'potter-kit'); ?></span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="wp-full-overlay-main">
		<iframe src="{{ data.preview_url }}" title="<?php esc_attr_e('Preview', 'potter-kit'); ?>"></iframe>
	</div>
</script>

<?php
wp_print_request_filesystem_credentials_modal();
wp_print_admin_notice_templates();
pk_print_admin_notice_templates();
