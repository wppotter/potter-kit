jQuery(document).ready(function ($) {
	var peb_hide_shortcode_field = function() {
		var selected = jQuery('#peb_template_type').val() || 'none';
		jQuery( '.peb-options-table' ).removeClass().addClass( 'peb-options-table widefat peb-selected-template-type-' + selected );
	}

	jQuery(document).on( 'change', '#peb_template_type', function( e ) {
		peb_hide_shortcode_field();
	});

	peb_hide_shortcode_field();
});
