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
			<svg width="35px"  viewBox="0 0 362 362" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: inline-block; padding: 8px 10px 8px 10px; vertical-align: middle;">
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
