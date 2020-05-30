/**
 * Customizer controls toggles
 *
 * @package Potter
 */

( function( $ ) {

	/**
	 * Helper class for the main Customizer interface.
	 *
	 * @since 1.0.0
	 * @class ASTCustomizer
	 */
	PotterNotices = {

		/**
		 * Initializes our custom logic for the Customizer.
		 *
		 * @since 1.0.0
		 * @method init
		 */
		init: function()
		{
			this._bind();
		},

		/**
		 * Binds events for the Potter Portfolio.
		 *
		 * @since 1.0.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			$( document ).on('click', '.potter-notice-close', PotterNotices._dismissNoticeNew );
			$( document ).on('click', '.potter-notice .notice-dismiss', PotterNotices._dismissNotice );
		},

		_dismissNotice: function( event ) {
			event.preventDefault();

			var repeat_notice_after = $( this ).parents('.potter-notice').data( 'repeat-notice-after' ) || '';
			var notice_id = $( this ).parents('.potter-notice').attr( 'id' ) || '';

			PotterNotices._ajax( notice_id, repeat_notice_after );
		},

		_dismissNoticeNew: function( event ) {
			event.preventDefault();

			var repeat_notice_after = $( this ).attr( 'data-repeat-notice-after' ) || '';
			var notice_id = $( this ).parents('.potter-notice').attr( 'id' ) || '';

			var $el = $( this ).parents('.potter-notice');
			$el.fadeTo( 100, 0, function() {
				$el.slideUp( 100, function() {
					$el.remove();
				});
			});

			PotterNotices._ajax( notice_id, repeat_notice_after );

			var link   = $( this ).attr( 'href' ) || '';
			var target = $( this ).attr( 'target' ) || '';
			if( '' !== link && '_blank' === target ) {
				window.open(link , '_blank');
			}
		},

		_ajax: function( notice_id, repeat_notice_after ) {

			if( '' === notice_id ) {
				return;
			}

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action            : 'potter-notice-dismiss',
					notice_id         : notice_id,
					repeat_notice_after : parseInt( repeat_notice_after ),
					nonce             : potterNotices._notice_nonce
				},
			});

		}
	};

	$( function() {
		PotterNotices.init();
	} );
} )( jQuery );
