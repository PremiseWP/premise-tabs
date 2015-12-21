/**
 * Plugin JS
 * 
 * @package Premise Tabs
 */
(function ($) {

	// OnLoad.
	$(function() {
		PremiseTabsHeight();

		$( '.premise-tab-radio' ).click( function() { PremiseTabsHeight(); } );
	});

	function PremiseTabsHeight() {

		if ( typeof PremiseTabsHeight.tabsheight == 'undefined' ) {

			PremiseTabsHeight.tabsheight = $( '.premise-tab-label' ).outerHeight(); // Static var.

			var tabcontenttop = PremiseTabsHeight.tabsheight;

			// Set content top offset.
			if ( $( '.premise-tab-label' ).css( 'display' ) !== 'block' ) { // If inline tabs.

				tabcontenttop -= parseInt( $( '.premise-tabs' ).css( 'margin-top' ), 10 );
			}

			$( '.premise-tab-content' ).css( 'top', tabcontenttop + 'px' );
		}

		var contentheight = $( '.premise-tab-radio:checked ~ .premise-tab-content' ).height(),
			height = contentheight + PremiseTabsHeight.tabsheight;

		// Set content min-height.
		$( '.premise-tabs' ).css( 'min-height', height + 'px' );

		return false;
	}

})(jQuery);

