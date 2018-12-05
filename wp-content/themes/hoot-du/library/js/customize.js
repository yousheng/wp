jQuery(document).ready(function($) {
	"use strict";


	/*** Sortlist Control ***/

	$('ul.hootdu-control-sortlist').each(function(){

		/** Prepare Sortlist **/

		var $self = $(this),
			openstate = $self.data('openstate'),
			$listItems = $self.children('li'),
			$listItemHeads = $listItems.children('.hootdu-sortlistitem-head'),
			$listItemVisibility = $listItemHeads.children('.sortlistitem-display'),
			$listItemOptions = $listItems.children('.hootdu-sortlistitem-options');

		$listItemHeads.on('click', function(e){
			$(this).children('.sortlistitem-expand').toggleClass('options-open');
			$(this).siblings('.hootdu-sortlistitem-options').slideToggle('fast');
		});

		if ( openstate ) {
			if ( openstate != 'all' ) {
				$listItemOptions.hide();
				$listItems.filter('[data-choiceid="' + openstate + '"]').children('.hootdu-sortlistitem-head').click();
			}
		} else $listItemOptions.hide();

		$listItemVisibility.on('click', function(e){
			e.stopPropagation();
			var $liContainer = $(this).closest('li.hootdu-control-sortlistitem');
			$liContainer.toggleClass('deactivated');
			var hideValue = ( $liContainer.is('.deactivated') ) ? '1' : '0';
			$(this).siblings('input.hootdu-control-sortlistitem-hide').val(hideValue).trigger('change');
		});

		/** Sortlist Control **/

		var $optionsform = $self.find('input, textarea, select'),
			$input = $self.siblings('input.hootdu-customize-control-sortlist'),
			updateSortable = function(){
				$optionsform = $self.find('input, textarea, select'); // Get updated list item order
				// JSON.stringify( $optionsform.serializeArray() ) :: serializeArray does not create a multidimensional array. It simpy creates array with name/value pairs
				// Hence use $optionsform.serialize(). For more notes on this issue, see php file.
				$input.val( $optionsform.serialize() ).trigger('change');
			};

		$optionsform.on('change', updateSortable);

		if ( $self.is('.sortable') ) {
			$self.sortable({
				handle: ".sortlistitem-sort",
				placeholder: "hootdu-control-sortlistitem-placeholder",
				update: function(event, ui) {
					updateSortable();
				},
				// start: function(e, ui){
				// 	ui.placeholder.height(ui.item.height());
				// },
				forcePlaceholderSize: true,
			});
		}

	});


	/*** Radioimage Control ***/

	$('.customize-control-radioimage, .hootdu-sortlistitem-option-radioimage').each(function(){

		var $radios = $(this).find('input'),
			$labels = $(this).find('.hootdu-customize-radioimage');

		$radios.on('change',function(){
			$labels.removeClass('radiocheck');
			$(this).parent('.hootdu-customize-radioimage').addClass('radiocheck');
		});

	});


	/*** Icon Control ***/

	if ( (typeof hootdu_customize_data != 'undefined') && (typeof hootdu_customize_data.iconslist != 'undefined') ) {

		/** Fly Icon **/

		var $body = $('body'),
			$flyicon = $('#hootdu-flyicon-content');

		$body.on( "openflypanel", function() {
			var $flypanelbutton = $body.data('flypanelbutton');
			if( $flypanelbutton && $flypanelbutton.data('flypaneltype')=='icon' && $flypanelbutton.data('flypanel')=='open' ) {

				$flyicon.html( hootdu_customize_data.iconslist ).data('controlgroup', $flypanelbutton);

				var $flyiconIcons = $flyicon.find('i'),
					$input = $flypanelbutton.siblings('input.hootdu-customize-control-icon'),
					selected = $input.val(),
					$icondisplay = $flypanelbutton.children('i');

				$flypanelbutton.addClass('flygroup-open');

				if(selected)
					$flyicon.find('i.'+selected.replace(' ', '.')).addClass('selected');

				$flyiconIcons.click( function(event){
					var iconvalue = $(this).data('value');
					$flyiconIcons.removeClass('selected');
					$(this).addClass('selected');
					$input.val( iconvalue ).trigger('change');
					$icondisplay.removeClass().addClass(iconvalue );
					$('.hootdu-flypanel-back').trigger('click');
				});

				$body.addClass('hootdu-displaying-flyicon');
				$body.data('flypaneltype','icon');
			}
		});

		$body.on( "closeflypanel", function() {
			$body.removeClass('hootdu-displaying-flyicon');
			var controlGroup = $flyicon.data('controlgroup');
			if (controlGroup)
				$(controlGroup).removeClass('flygroup-open');
			if($body.data('flypaneltype')=='icon') {
				$body.data('flypaneltype','');
			}
		});

		$('.hootdu-customize-control-icon-remove').click( function(event){
			var input = $(this).siblings('input.hootdu-customize-control-icon'),
				icondisplay = $(this).siblings('.hootdu-customize-control-icon-picked').children('i');
			input.val('').trigger('change');
			icondisplay.removeClass();
			// $('.hootdu-flypanel-back').trigger('click'); // redundant
		});

	}


	/*** Group Control ***/

	/** Prepare Groups **/

	$( ".hootdu-customize-control-groupstart" ).each( function( index ) {
		var id = $(this).attr('id'),
			moveBlocks = $(this).nextUntil( '.hootdu-customize-control-groupend', "li" );
		moveBlocks.addClass('hootdu-customize-control-group-blocks').attr('data-controlgroup', id);
	});


	/** Fly Groups **/

	var $body = $('body');

	$body.on( "openflypanel", function() {
		var $flypanelbutton = $body.data('flypanelbutton');
		if( $flypanelbutton && $flypanelbutton.data('flypaneltype')=='group' && $flypanelbutton.data('flypanel')=='open' ) {
			var $groupstart = $flypanelbutton.parent('.hootdu-customize-control-groupstart');
			$groupstart.addClass('flygroup-open');
			var moveBlocks = $groupstart.nextUntil( '.hootdu-customize-control-groupend', "li" );
			$('#hootdu-flygroup-content').html('').append(moveBlocks).wrapInner('<ul></ul>');
			$body.addClass('hootdu-displaying-flygroup');
			$body.data('flypaneltype','group');
		}
	});

	$body.on( "closeflypanel", function() {
		$body.removeClass('hootdu-displaying-flygroup');
		if($body.data('flypaneltype')=='group') {
			$('#hootdu-flygroup-content > ul > li').each( function() {
				var controlGroup = $(this).data('controlgroup');
				$(this).insertBefore('#'+controlGroup+'-end');
				$('#'+controlGroup).removeClass('flygroup-open');
			});
			$body.data('flypaneltype','');
		}
	});


	/*** Multi Check Boxes ***/

	$('.customize-control-bettercheckbox .bettercheckbox-multi').each(function(){

		var $control = $(this),
			$multi = $control.find('input[type="checkbox"]'),
			$input = $control.find('input[type="hidden"]');

		$multi.on('change', function(){
			var multiValues = $multi.filter(':checked').map(function(){
				return this.value;
			}).get().join(',');
			$input.val(multiValues).trigger('change');
		});

	});


	/*** Fly Panels - generic ***/
	// This code doesnt 'do' anything. It just acts as framework for other flypanel types.

	var $body = $("body"),
		$flypanelButtons = $('.hootdu-flypanel-button'),
		initFly = function() {
			$flypanelButtons.click( function(event){
				if( $body.data('flypanel')=='open' && $(this).data('flypanel')=='open' ) {
					closeFly();
				} else {
					closeFly();
					openFly($(this));
				}
				event.stopPropagation();
			});
			$('.hootdu-flypanel-back').click( function(event){
				closeFly();
				event.stopPropagation();
			});
			$('.hootdu-flypanel').click( function(event){
				event.stopPropagation();
			});
			$body.click( function(event){
				if ( ! $(event.target).closest('.media-modal').length )
					closeFly();
			});
		},
		closeFly = function(){
			$body.data('flypanel','close');
			$body.data('flypanelbutton','');
			$flypanelButtons.data('flypanel','close');
			$body.trigger('closeflypanel');
		},
		openFly = function($flypanelButton){
			$body.data('flypanel','open');
			$body.data('flypanelbutton',$flypanelButton);
			$flypanelButton.data('flypanel','open');
			$body.trigger('openflypanel');
		};

	initFly();


});