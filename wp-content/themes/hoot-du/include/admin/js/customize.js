/**
 * Theme Customizer
 */


( function( api ) {

	// Extends our custom "hootdu-theme" section.
	api.sectionConstructor['hootdu-theme'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );


jQuery(document).ready(function($) {
	"use strict";


	/*** Hide and link module BG buttons ***/

	$('.frontpage_sections_modulebg .button').on('click',function(event){
		event.stopPropagation();
		var choice = $(this).closest('li.hootdu-control-sortlistitem').data('choiceid');
		$('.hootdu-control-id-frontpage_sectionbg_' + choice + ' .hootdu-flypanel-button').trigger('click');
	});


});
