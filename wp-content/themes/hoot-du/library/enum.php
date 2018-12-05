<?php
/**
 * Data Sets
 * These sets can be easily used to create option lists and
 * subsequently by sanitization functions to check for allowed values
 *
 * @package    Hoot Du
 * @subpackage Library
 */


/* == fonts == */


/**
 * Functions for sending list of fonts available.
 * 
 * Generates the font (websafe) list
 * Font list should always have the form:
 * {css style} => {font name}
 *
 * @since 3.0.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_fonts_list' ) ):
function hootdu_fonts_list() {

	return apply_filters( 'hootdu_fonts_list', array(
		'Arial, Helvetica, sans-serif'            => 'Arial',
		'Helvetica, sans-serif'                   => 'Helvetica',
		'Verdana, Geneva, sans-serif'             => 'Verdana, Geneva',
		'"Trebuchet MS", Helvetica, sans-serif'   => 'Trebuchet',
		'Georgia, serif'                          => 'Georgia',
		'"Times New Roman", serif'                => 'Times New Roman',
		'Tahoma, Geneva, sans-serif'              => 'Tahoma, Geneva',
		)
	);

}
endif;


/* == enum == */


/**
 * Functions for sending list of icons available.
 *
 * @since 3.0.0
 * @access public
 * @param string $return array to return icons|sections|list/empty
 * @return array
 */
if ( !function_exists( 'hootdu_enum_icons' ) ):
function hootdu_enum_icons( $return = 'list' ) {
	$return = ( empty( $return ) ) ? 'list' : $return;
	$list = array();

	if ( $return == 'sections' || $return == 'section' )
		$list = hootdu_fonticons_list('sections');

	if ( $return == 'icons' || $return == 'icon' )
		$list = hootdu_fonticons_list('icons');

	if ( $return == 'lists' || $return == 'list' ) {
		$iconsList = hootdu_fonticons_list('icons');
		foreach ( $iconsList as $name => $array )
			$list = array_merge( $list, $array );
	}

	return apply_filters( 'hootdu_enum_icons', $list, $return );
}
endif;

/**
 * Get background repeat settings
 *
 * @since 3.0.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_enum_background_repeat' ) ):
function hootdu_enum_background_repeat() {
	$default = array(
		'no-repeat' => __( 'No Repeat', 'hoot-du' ),
		'repeat-x'  => __( 'Repeat Horizontally', 'hoot-du' ),
		'repeat-y'  => __( 'Repeat Vertically', 'hoot-du' ),
		'repeat'    => __( 'Repeat All', 'hoot-du' ),
		);
	return apply_filters( 'hootdu_enum_background_repeat', $default );
}
endif;

/**
 * Get background positions
 *
 * @since 3.0.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_enum_background_position' ) ):
function hootdu_enum_background_position() {
	$default = array(
		'top left'      => __( 'Top Left', 'hoot-du' ),
		'top center'    => __( 'Top Center', 'hoot-du' ),
		'top right'     => __( 'Top Right', 'hoot-du' ),
		'center left'   => __( 'Middle Left', 'hoot-du' ),
		'center center' => __( 'Middle Center', 'hoot-du' ),
		'center right'  => __( 'Middle Right', 'hoot-du' ),
		'bottom left'   => __( 'Bottom Left', 'hoot-du' ),
		'bottom center' => __( 'Bottom Center', 'hoot-du' ),
		'bottom right'  => __( 'Bottom Right', 'hoot-du')
		);
	return apply_filters( 'hootdu_enum_background_position', $default );
}
endif;

/**
 * Get background attachment settings
 *
 * @since 3.0.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_enum_background_attachment' ) ):
function hootdu_enum_background_attachment() {
	$default = array(
		'scroll' => __( 'Scroll Normally', 'hoot-du' ),
		'fixed'  => __( 'Fixed in Place', 'hoot-du'),
		);
	return apply_filters( 'hootdu_enum_background_attachment', $default );
}
endif;

/**
 * Get background types
 *
 * @since 3.0.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_enum_background_type' ) ):
function hootdu_enum_background_type() {
	$default = array(
		'predefined' => __( 'Predefined Pattern', 'hoot-du' ),
		'custom'     => __( 'Custom Image', 'hoot-du' ),
		);
	return apply_filters( 'hootdu_enum_background_type', $default );
}
endif;

/**
 * Get background patterns
 *
 * @since 3.0.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_enum_background_pattern' ) ):
function hootdu_enum_background_pattern() {
	return apply_filters( 'hootdu_enum_background_pattern', array() );
}
endif;

/**
 * Get font sizes.
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @since 3.0.0
 * @access public
 * @param int $min
 * @param int $max
 * @return array
 */
if ( !function_exists( 'hootdu_enum_font_sizes' ) ):
function hootdu_enum_font_sizes( $min = 9, $max = 82 ) {
	static $cache = array();
	$default = wp_parse_args( apply_filters( 'hootdu_enum_font_sizes', array() ), array(
		'min' => 9,
		'max' => 82,
		) );
	if ( empty( $cache ) )
		$cache = range( absint( $default['min'] ), absint( $default['max'] ) );
	if ( $min != $default['min'] || $max != $default['min'] )
		return range( absint( $min ), absint( $max ) );
	else
		return $cache;
}
endif;

/**
 * Get font sizes for optiosn array
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @since 3.0.0
 * @access public
 * @param int $min
 * @param int $max
 * @param string $postfix
 * @return array
 */
if ( !function_exists( 'hootdu_enum_font_sizes_array' ) ):
function hootdu_enum_font_sizes_array( $min = 9, $max = 82, $postfix = 'px' ) {
	$args = wp_parse_args( apply_filters( 'hootdu_enum_font_sizes', array(
		'min' => $min,
		'max' => $max,
		) ), array(
		'min' => 9,
		'max' => 82,
		) );
	$sizes = hootdu_enum_font_sizes( $args['min'], $args['max'] );
	$output = array();
	foreach ( $sizes as $size )
		$output[ $size ] = $size . $postfix;
	return $output;
}
endif;

/**
 * Get font faces.
 *
 * Returns an array of all recognized font faces.
 * Keys are intended to be stored in the database
 * while values are ready for display in html.
 *
 * @since 3.0.0
 * @access public
 * @param string $return array to return websafe|google-fonts|empty/list
 * @return array
 */
if ( !function_exists( 'hootdu_enum_font_faces' ) ):
function hootdu_enum_font_faces( $return = '' ) {
	$fonts = array();
	$webfonts = ( function_exists('hootdu_fonts_list') ) ? hootdu_fonts_list() : array();
	$googlefonts = ( function_exists('hootdu_googlefonts_list') ) ? hootdu_googlefonts_list() : apply_filters( 'hootdu_google_fonts', array() );

	if ( $return == 'websafe' )
		$fonts = $webfonts;
	elseif ( $return == 'google-fonts' || $return == 'google-font' )
		$fonts = $googlefonts;
	else
		$fonts = array_merge( $webfonts, $googlefonts );

	return apply_filters( 'hootdu_enum_font_faces', $fonts, $return );
}
endif;

/**
 * Get font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in html.
 *
 * @since 3.0.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_enum_font_styles' ) ):
function hootdu_enum_font_styles() {
	$default = array(
		'none'                     => __( 'None', 'hoot-du' ),
		'italic'                   => __( 'Italic', 'hoot-du' ),
		'bold'                     => __( 'Bold', 'hoot-du' ),
		'bold italic'              => __( 'Bold Italic', 'hoot-du' ),
		'lighter'                  => __( 'Light', 'hoot-du' ),
		'lighter italic'           => __( 'Light Italic', 'hoot-du' ),
		'uppercase'                => __( 'Uppercase', 'hoot-du' ),
		'uppercase italic'         => __( 'Uppercase Italic', 'hoot-du' ),
		'uppercase bold'           => __( 'Uppercase Bold', 'hoot-du' ),
		'uppercase bold italic'    => __( 'Uppercase Bold Italic', 'hoot-du' ),
		'uppercase lighter'        => __( 'Uppercase Light', 'hoot-du' ),
		'uppercase lighter italic' => __( 'Uppercase Light Italic', 'hoot-du' )
		);
	return apply_filters( 'hootdu_enum_font_styles', $default );
}
endif;

/**
 * Get social profiles and icons
 *
 * Returns an array of all recognized social profiles.
 * Keys are intended to be stored in the database
 * while values are ready for display in html.
 *
 * @since 3.0.0
 * @access public
 * @param bool $skype Add skype icon to list
 * @param bool $email Add email icon to list
 * @return array
 */
if ( !function_exists( 'hootdu_enum_social_profiles' ) ):
function hootdu_enum_social_profiles( $skype = false, $email = true ) {
	$social = array(
		'fa-amazon'         => __( 'Amazon', 'hoot-du' ),
		'fa-android'        => __( 'Android', 'hoot-du' ),
		'fa-apple'          => __( 'Apple', 'hoot-du' ),
		'fa-bandcamp'       => __( 'Bandcamp', 'hoot-du' ),
		'fa-behance'        => __( 'Behance', 'hoot-du' ),
		'fa-bitbucket'      => __( 'Bitbucket', 'hoot-du' ),
		'fa-btc'            => __( 'BTC', 'hoot-du' ),
		'fa-buysellads'     => __( 'BuySellAds', 'hoot-du' ),
		'fa-codepen'        => __( 'Codepen', 'hoot-du' ),
		'fa-codiepie'       => __( 'Codie Pie', 'hoot-du' ),
		'fa-contao'         => __( 'Contao', 'hoot-du' ),
		'fa-dashcube'       => __( 'Dash Cube', 'hoot-du' ),
		'fa-delicious'      => __( 'Delicious', 'hoot-du' ),
		'fa-deviantart'     => __( 'Deviantart', 'hoot-du' ),
		'fa-digg'           => __( 'Digg', 'hoot-du' ),
		'fa-dribbble'       => __( 'Dribbble', 'hoot-du' ),
		'fa-dropbox'        => __( 'Dropbox', 'hoot-du' ),
		'fa-eercast'        => __( 'Eercast', 'hoot-du' ),
		'fa-envelope'       => __( 'Email', 'hoot-du' ),
		'fa-etsy'           => __( 'Etsy', 'hoot-du' ),
		'fa-facebook'       => __( 'Facebook', 'hoot-du' ),
		'fa-flickr'         => __( 'Flickr', 'hoot-du' ),
		'fa-forumbee'       => __( 'Forumbee', 'hoot-du' ),
		'fa-foursquare'     => __( 'Foursquare', 'hoot-du' ),
		'fa-free-code-camp' => __( 'Free Code Camp', 'hoot-du' ),
		'fa-get-pocket'     => __( 'Pocket (getpocket)', 'hoot-du' ),
		'fa-github'         => __( 'Github', 'hoot-du' ),
		'fa-google'         => __( 'Google', 'hoot-du' ),
		'fa-google-plus'    => __( 'Google Plus', 'hoot-du' ),
		'fa-google-wallet'  => __( 'Google Wallet', 'hoot-du' ),
		'fa-houzz'          => __( 'Houzz', 'hoot-du' ),
		'fa-imdb'           => __( 'IMDB', 'hoot-du' ),
		'fa-instagram'      => __( 'Instagram', 'hoot-du' ),
		'fa-jsfiddle'       => __( 'JS Fiddle', 'hoot-du' ),
		'fa-lastfm'         => __( 'Last FM', 'hoot-du' ),
		'fa-leanpub'        => __( 'Leanpub', 'hoot-du' ),
		'fa-linkedin'       => __( 'Linkedin', 'hoot-du' ),
		'fa-meetup'         => __( 'Meetup', 'hoot-du' ),
		'fa-mixcloud'       => __( 'Mixcloud', 'hoot-du' ),
		'fa-paypal'         => __( 'Paypal', 'hoot-du' ),
		'fa-pinterest'      => __( 'Pinterest', 'hoot-du' ),
		'fa-quora'          => __( 'Quora', 'hoot-du' ),
		'fa-reddit'         => __( 'Reddit', 'hoot-du' ),
		'fa-rss'            => __( 'RSS', 'hoot-du' ),
		'fa-scribd'         => __( 'Scribd', 'hoot-du' ),
		'fa-skype'          => __( 'Skype', 'hoot-du' ),
		'fa-slack'          => __( 'Slack', 'hoot-du' ),
		'fa-slideshare'     => __( 'Slideshare', 'hoot-du' ),
		'fa-snapchat'       => __( 'Snapchat', 'hoot-du' ),
		'fa-soundcloud'     => __( 'Soundcloud', 'hoot-du' ),
		'fa-spotify'        => __( 'Spotify', 'hoot-du' ),
		'fa-stack-exchange' => __( 'Stack Exchange', 'hoot-du' ),
		'fa-stack-overflow' => __( 'Stack Overflow', 'hoot-du' ),
		'fa-steam'          => __( 'Steam', 'hoot-du' ),
		'fa-stumbleupon'    => __( 'Stumbleupon', 'hoot-du' ),
		'fa-trello'         => __( 'Trello', 'hoot-du' ),
		'fa-tripadvisor'    => __( 'Trip Advisor', 'hoot-du' ),
		'fa-tumblr'         => __( 'Tumblr', 'hoot-du' ),
		'fa-twitch'         => __( 'Twitch', 'hoot-du' ),
		'fa-twitter'        => __( 'Twitter', 'hoot-du' ),
		'fa-viadeo'         => __( 'Viadeo', 'hoot-du' ),
		'fa-vimeo-square'   => __( 'Vimeo', 'hoot-du' ),
		'fa-vk'             => __( 'VK', 'hoot-du' ),
		'fa-wikipedia-w'    => __( 'Wikipedia', 'hoot-du' ),
		'fa-windows'        => __( 'Windows', 'hoot-du' ),
		'fa-wordpress'      => __( 'WordPress', 'hoot-du' ),
		'fa-xing'           => __( 'Xing', 'hoot-du' ),
		'fa-y-combinator'   => __( 'Y Combinator', 'hoot-du' ),
		'fa-yelp'           => __( 'Yelp', 'hoot-du' ),
		'fa-youtube'        => __( 'Youtube', 'hoot-du' ),
	);
	if ( !$skype ) unset( $social['fa-skype'] );
	if ( !$email ) unset( $social['fa-envelope'] );
	return apply_filters( 'hootdu_enum_social_profiles', $social, $skype );
}
endif;


/* == icons == */


/**
 * Generates the icon and section list
 *
 * @since 3.0.0
 * @access public
 * @param string $return array to return sections|icons
 * @return array
 */
function hootdu_fonticons_list( $return = 'icons' ) {

	if ( 'sections' == $return ) :
		return apply_filters( 'hootdu_fonticons_sections', array(
			'fonticons' => __('Font Icons', 'hoot-du'),
			'brands'    => __('Brands', 'hoot-du'),
			)
		);
	endif;

	if ( 'icons' == $return ) :
		return apply_filters( 'hootdu_fonticons_icons', array (

			'fonticons' => array (
				'fa-address-book far',
				'fa-address-book fas',
				'fa-address-card far',
				'fa-address-card fas',
				'fa-adjust fas',
				'fa-align-center fas',
				'fa-align-justify fas',
				'fa-align-left fas',
				'fa-align-right fas',
				'fa-allergies fas',
				'fa-ambulance fas',
				'fa-american-sign-language-interpreting fas',
				'fa-anchor fas',
				'fa-angle-double-down fas',
				'fa-angle-double-left fas',
				'fa-angle-double-right fas',
				'fa-angle-double-up fas',
				'fa-angle-down fas',
				'fa-angle-left fas',
				'fa-angle-right fas',
				'fa-angle-up fas',
				'fa-archive fas',
				'fa-arrow-alt-circle-down far',
				'fa-arrow-alt-circle-down fas',
				'fa-arrow-alt-circle-left far',
				'fa-arrow-alt-circle-left fas',
				'fa-arrow-alt-circle-right far',
				'fa-arrow-alt-circle-right fas',
				'fa-arrow-alt-circle-up far',
				'fa-arrow-alt-circle-up fas',
				'fa-arrow-circle-down fas',
				'fa-arrow-circle-left fas',
				'fa-arrow-circle-right fas',
				'fa-arrow-circle-up fas',
				'fa-arrow-down fas',
				'fa-arrow-left fas',
				'fa-arrow-right fas',
				'fa-arrows-alt fas',
				'fa-arrows-alt-h fas',
				'fa-arrows-alt-v fas',
				'fa-arrow-up fas',
				'fa-assistive-listening-systems fas',
				'fa-asterisk fas',
				'fa-at fas',
				'fa-audio-description fas',
				'fa-backward fas',
				'fa-balance-scale fas',
				'fa-ban fas',
				'fa-band-aid fas',
				'fa-barcode fas',
				'fa-bars fas',
				'fa-baseball-ball fas',
				'fa-basketball-ball fas',
				'fa-bath fas',
				'fa-battery-empty fas',
				'fa-battery-full fas',
				'fa-battery-half fas',
				'fa-battery-quarter fas',
				'fa-battery-three-quarters fas',
				'fa-bed fas',
				'fa-beer fas',
				'fa-bell far',
				'fa-bell fas',
				'fa-bell-slash far',
				'fa-bell-slash fas',
				'fa-bicycle fas',
				'fa-binoculars fas',
				'fa-birthday-cake fas',
				'fa-blind fas',
				'fa-bold fas',
				'fa-bolt fas',
				'fa-bomb fas',
				'fa-book fas',
				'fa-bookmark far',
				'fa-bookmark fas',
				'fa-bowling-ball fas',
				'fa-box fas',
				'fa-boxes fas',
				'fa-box-open fas',
				'fa-braille fas',
				'fa-briefcase fas',
				'fa-briefcase-medical fas',
				'fa-bug fas',
				'fa-building far',
				'fa-building fas',
				'fa-bullhorn fas',
				'fa-bullseye fas',
				'fa-burn fas',
				'fa-bus fas',
				'fa-calculator fas',
				'fa-calendar far',
				'fa-calendar fas',
				'fa-calendar-alt far',
				'fa-calendar-alt fas',
				'fa-calendar-check far',
				'fa-calendar-check fas',
				'fa-calendar-minus far',
				'fa-calendar-minus fas',
				'fa-calendar-plus far',
				'fa-calendar-plus fas',
				'fa-calendar-times far',
				'fa-calendar-times fas',
				'fa-camera fas',
				'fa-camera-retro fas',
				'fa-capsules fas',
				'fa-car fas',
				'fa-caret-down fas',
				'fa-caret-left fas',
				'fa-caret-right fas',
				'fa-caret-square-down far',
				'fa-caret-square-down fas',
				'fa-caret-square-left far',
				'fa-caret-square-left fas',
				'fa-caret-square-right far',
				'fa-caret-square-right fas',
				'fa-caret-square-up far',
				'fa-caret-square-up fas',
				'fa-caret-up fas',
				'fa-cart-arrow-down fas',
				'fa-cart-plus fas',
				'fa-certificate fas',
				'fa-chart-area fas',
				'fa-chart-bar far',
				'fa-chart-bar fas',
				'fa-chart-line fas',
				'fa-chart-pie fas',
				'fa-check fas',
				'fa-check-circle far',
				'fa-check-circle fas',
				'fa-check-square far',
				'fa-check-square fas',
				'fa-chess fas',
				'fa-chess-bishop fas',
				'fa-chess-board fas',
				'fa-chess-king fas',
				'fa-chess-knight fas',
				'fa-chess-pawn fas',
				'fa-chess-queen fas',
				'fa-chess-rook fas',
				'fa-chevron-circle-down fas',
				'fa-chevron-circle-left fas',
				'fa-chevron-circle-right fas',
				'fa-chevron-circle-up fas',
				'fa-chevron-down fas',
				'fa-chevron-left fas',
				'fa-chevron-right fas',
				'fa-chevron-up fas',
				'fa-child fas',
				'fa-circle far',
				'fa-circle fas',
				'fa-circle-notch fas',
				'fa-clipboard far',
				'fa-clipboard fas',
				'fa-clipboard-check fas',
				'fa-clipboard-list fas',
				'fa-clock far',
				'fa-clock fas',
				'fa-clone far',
				'fa-clone fas',
				'fa-closed-captioning far',
				'fa-closed-captioning fas',
				'fa-cloud fas',
				'fa-cloud-download-alt fas',
				'fa-cloud-upload-alt fas',
				'fa-code fas',
				'fa-code-branch fas',
				'fa-coffee fas',
				'fa-cog fas',
				'fa-cogs fas',
				'fa-columns fas',
				'fa-comment far',
				'fa-comment fas',
				'fa-comment-alt far',
				'fa-comment-alt fas',
				'fa-comment-dots fas',
				'fa-comments far',
				'fa-comments fas',
				'fa-comment-slash fas',
				'fa-compass far',
				'fa-compass fas',
				'fa-compress fas',
				'fa-copy far',
				'fa-copy fas',
				'fa-copyright far',
				'fa-copyright fas',
				'fa-couch fas',
				'fa-credit-card far',
				'fa-credit-card fas',
				'fa-crop fas',
				'fa-crosshairs fas',
				'fa-cube fas',
				'fa-cubes fas',
				'fa-cut fas',
				'fa-database fas',
				'fa-deaf fas',
				'fa-desktop fas',
				'fa-diagnoses fas',
				'fa-dna fas',
				'fa-dollar-sign fas',
				'fa-dolly fas',
				'fa-dolly-flatbed fas',
				'fa-donate fas',
				'fa-dot-circle far',
				'fa-dot-circle fas',
				'fa-dove fas',
				'fa-download fas',
				'fa-edit far',
				'fa-edit fas',
				'fa-eject fas',
				'fa-ellipsis-h fas',
				'fa-ellipsis-v fas',
				'fa-envelope far',
				'fa-envelope fas',
				'fa-envelope-open far',
				'fa-envelope-open fas',
				'fa-envelope-square fas',
				'fa-eraser fas',
				'fa-euro-sign fas',
				'fa-exchange-alt fas',
				'fa-exclamation fas',
				'fa-exclamation-circle fas',
				'fa-exclamation-triangle fas',
				'fa-expand fas',
				'fa-expand-arrows-alt fas',
				'fa-external-link-alt fas',
				'fa-external-link-square-alt fas',
				'fa-eye fas',
				'fa-eye-dropper fas',
				'fa-eye-slash far',
				'fa-eye-slash fas',
				'fa-fast-backward fas',
				'fa-fast-forward fas',
				'fa-fax fas',
				'fa-female fas',
				'fa-fighter-jet fas',
				'fa-file far',
				'fa-file fas',
				'fa-file-alt far',
				'fa-file-alt fas',
				'fa-file-archive far',
				'fa-file-archive fas',
				'fa-file-audio far',
				'fa-file-audio fas',
				'fa-file-code far',
				'fa-file-code fas',
				'fa-file-excel far',
				'fa-file-excel fas',
				'fa-file-image far',
				'fa-file-image fas',
				'fa-file-medical fas',
				'fa-file-medical-alt fas',
				'fa-file-pdf far',
				'fa-file-pdf fas',
				'fa-file-powerpoint far',
				'fa-file-powerpoint fas',
				'fa-file-video far',
				'fa-file-video fas',
				'fa-file-word far',
				'fa-file-word fas',
				'fa-film fas',
				'fa-filter fas',
				'fa-fire fas',
				'fa-fire-extinguisher fas',
				'fa-first-aid fas',
				'fa-flag far',
				'fa-flag fas',
				'fa-flag-checkered fas',
				'fa-flask fas',
				'fa-folder far',
				'fa-folder fas',
				'fa-folder-open far',
				'fa-folder-open fas',
				'fa-font fas',
				'fa-football-ball fas',
				'fa-forward fas',
				'fa-frown far',
				'fa-frown fas',
				'fa-futbol far',
				'fa-futbol fas',
				'fa-gamepad fas',
				'fa-gavel fas',
				'fa-gem far',
				'fa-gem fas',
				'fa-genderless fas',
				'fa-gift fas',
				'fa-glass-martini fas',
				'fa-globe fas',
				'fa-golf-ball fas',
				'fa-graduation-cap fas',
				'fa-hand-holding fas',
				'fa-hand-holding-heart fas',
				'fa-hand-holding-usd fas',
				'fa-hand-lizard far',
				'fa-hand-lizard fas',
				'fa-hand-paper far',
				'fa-hand-paper fas',
				'fa-hand-peace far',
				'fa-hand-peace fas',
				'fa-hand-point-down far',
				'fa-hand-point-down fas',
				'fa-hand-pointer far',
				'fa-hand-pointer fas',
				'fa-hand-point-left far',
				'fa-hand-point-left fas',
				'fa-hand-point-right far',
				'fa-hand-point-right fas',
				'fa-hand-point-up far',
				'fa-hand-point-up fas',
				'fa-hand-rock far',
				'fa-hand-rock fas',
				'fa-hands fas',
				'fa-hand-scissors far',
				'fa-hand-scissors fas',
				'fa-handshake far',
				'fa-handshake fas',
				'fa-hands-helping fas',
				'fa-hand-spock far',
				'fa-hand-spock fas',
				'fa-hashtag fas',
				'fa-hdd far',
				'fa-hdd fas',
				'fa-heading fas',
				'fa-headphones fas',
				'fa-heart far',
				'fa-heart fas',
				'fa-heartbeat fas',
				'fa-history fas',
				'fa-hockey-puck fas',
				'fa-home fas',
				'fa-hospital far',
				'fa-hospital fas',
				'fa-hospital-alt fas',
				'fa-hospital-symbol fas',
				'fa-hourglass far',
				'fa-hourglass fas',
				'fa-hourglass-end fas',
				'fa-hourglass-half fas',
				'fa-hourglass-start fas',
				'fa-h-square fas',
				'fa-i-cursor fas',
				'fa-id-badge far',
				'fa-id-badge fas',
				'fa-id-card far',
				'fa-id-card fas',
				'fa-id-card-alt fas',
				'fa-image far',
				'fa-image fas',
				'fa-images far',
				'fa-images fas',
				'fa-inbox fas',
				'fa-indent fas',
				'fa-industry fas',
				'fa-info fas',
				'fa-info-circle fas',
				'fa-italic fas',
				'fa-key fas',
				'fa-keyboard far',
				'fa-keyboard fas',
				'fa-language fas',
				'fa-laptop fas',
				'fa-leaf fas',
				'fa-lemon far',
				'fa-lemon fas',
				'fa-level-down-alt fas',
				'fa-level-up-alt fas',
				'fa-life-ring far',
				'fa-life-ring fas',
				'fa-lightbulb far',
				'fa-lightbulb fas',
				'fa-link fas',
				'fa-lira-sign fas',
				'fa-list fas',
				'fa-list-alt far',
				'fa-list-alt fas',
				'fa-list-ol fas',
				'fa-list-ul fas',
				'fa-location-arrow fas',
				'fa-lock fas',
				'fa-lock-open fas',
				'fa-long-arrow-alt-down fas',
				'fa-long-arrow-alt-left fas',
				'fa-long-arrow-alt-right fas',
				'fa-long-arrow-alt-up fas',
				'fa-low-vision fas',
				'fa-magic fas',
				'fa-magnet fas',
				'fa-male fas',
				'fa-map far',
				'fa-map fas',
				'fa-map-marker fas',
				'fa-map-marker-alt fas',
				'fa-map-pin fas',
				'fa-map-signs fas',
				'fa-mars fas',
				'fa-mars-double fas',
				'fa-mars-stroke fas',
				'fa-mars-stroke-h fas',
				'fa-mars-stroke-v fas',
				'fa-medkit fas',
				'fa-meh far',
				'fa-meh fas',
				'fa-mercury fas',
				'fa-microchip fas',
				'fa-microphone fas',
				'fa-microphone-slash fas',
				'fa-minus fas',
				'fa-minus-circle fas',
				'fa-minus-square far',
				'fa-minus-square fas',
				'fa-mobile fas',
				'fa-mobile-alt fas',
				'fa-money-bill-alt far',
				'fa-money-bill-alt fas',
				'fa-moon far',
				'fa-moon fas',
				'fa-motorcycle fas',
				'fa-mouse-pointer fas',
				'fa-music fas',
				'fa-neuter fas',
				'fa-newspaper far',
				'fa-newspaper fas',
				'fa-notes-medical fas',
				'fa-object-group far',
				'fa-object-group fas',
				'fa-object-ungroup far',
				'fa-object-ungroup fas',
				'fa-outdent fas',
				'fa-paint-brush fas',
				'fa-pallet fas',
				'fa-paperclip fas',
				'fa-paper-plane far',
				'fa-paper-plane fas',
				'fa-parachute-box fas',
				'fa-paragraph fas',
				'fa-paste fas',
				'fa-pause fas',
				'fa-pause-circle far',
				'fa-pause-circle fas',
				'fa-paw fas',
				'fa-pencil-alt fas',
				'fa-pen-square fas',
				'fa-people-carry fas',
				'fa-percent fas',
				'fa-phone fas',
				'fa-phone-slash fas',
				'fa-phone-square fas',
				'fa-phone-volume fas',
				'fa-piggy-bank fas',
				'fa-pills fas',
				'fa-plane fas',
				'fa-play fas',
				'fa-play-circle far',
				'fa-play-circle fas',
				'fa-plug fas',
				'fa-plus fas',
				'fa-plus-circle fas',
				'fa-plus-square far',
				'fa-plus-square fas',
				'fa-podcast fas',
				'fa-poo fas',
				'fa-pound-sign fas',
				'fa-power-off fas',
				'fa-prescription-bottle fas',
				'fa-prescription-bottle-alt fas',
				'fa-print fas',
				'fa-procedures fas',
				'fa-puzzle-piece fas',
				'fa-qrcode fas',
				'fa-question fas',
				'fa-question-circle far',
				'fa-question-circle fas',
				'fa-quidditch fas',
				'fa-quote-left fas',
				'fa-quote-right fas',
				'fa-random fas',
				'fa-recycle fas',
				'fa-redo fas',
				'fa-redo-alt fas',
				'fa-registered far',
				'fa-registered fas',
				'fa-reply fas',
				'fa-reply-all fas',
				'fa-retweet fas',
				'fa-ribbon fas',
				'fa-road fas',
				'fa-rocket fas',
				'fa-rss fas',
				'fa-rss-square fas',
				'fa-ruble-sign fas',
				'fa-rupee-sign fas',
				'fa-save far',
				'fa-save fas',
				'fa-search fas',
				'fa-search-minus fas',
				'fa-search-plus fas',
				'fa-seedling fas',
				'fa-server fas',
				'fa-share fas',
				'fa-share-alt fas',
				'fa-share-alt-square fas',
				'fa-share-square far',
				'fa-share-square fas',
				'fa-shekel-sign fas',
				'fa-shield-alt fas',
				'fa-ship fas',
				'fa-shipping-fast fas',
				'fa-shopping-bag fas',
				'fa-shopping-basket fas',
				'fa-shopping-cart fas',
				'fa-shower fas',
				'fa-sign fas',
				'fa-signal fas',
				'fa-sign-in-alt fas',
				'fa-sign-language fas',
				'fa-sign-out-alt fas',
				'fa-sitemap fas',
				'fa-sliders-h fas',
				'fa-smile far',
				'fa-smile fas',
				'fa-smoking fas',
				'fa-snowflake far',
				'fa-snowflake fas',
				'fa-sort fas',
				'fa-sort-alpha-down fas',
				'fa-sort-alpha-up fas',
				'fa-sort-amount-down fas',
				'fa-sort-amount-up fas',
				'fa-sort-down fas',
				'fa-sort-numeric-down fas',
				'fa-sort-numeric-up fas',
				'fa-sort-up fas',
				'fa-space-shuttle fas',
				'fa-spinner fas',
				'fa-square far',
				'fa-square fas',
				'fa-square-full fas',
				'fa-star far',
				'fa-star fas',
				'fa-star-half far',
				'fa-star-half fas',
				'fa-step-backward fas',
				'fa-step-forward fas',
				'fa-stethoscope fas',
				'fa-sticky-note far',
				'fa-sticky-note fas',
				'fa-stop fas',
				'fa-stop-circle far',
				'fa-stop-circle fas',
				'fa-stopwatch fas',
				'fa-street-view fas',
				'fa-strikethrough fas',
				'fa-subscript fas',
				'fa-subway fas',
				'fa-suitcase fas',
				'fa-sun far',
				'fa-sun fas',
				'fa-superscript fas',
				'fa-sync fas',
				'fa-sync-alt fas',
				'fa-syringe fas',
				'fa-table fas',
				'fa-tablet fas',
				'fa-tablet-alt fas',
				'fa-table-tennis fas',
				'fa-tablets fas',
				'fa-tachometer-alt fas',
				'fa-tag fas',
				'fa-tags fas',
				'fa-tape fas',
				'fa-tasks fas',
				'fa-taxi fas',
				'fa-terminal fas',
				'fa-text-height fas',
				'fa-text-width fas',
				'fa-th fas',
				'fa-thermometer fas',
				'fa-thermometer-empty fas',
				'fa-thermometer-full fas',
				'fa-thermometer-half fas',
				'fa-thermometer-quarter fas',
				'fa-thermometer-three-quarters fas',
				'fa-th-large fas',
				'fa-th-list fas',
				'fa-thumbs-down far',
				'fa-thumbs-down fas',
				'fa-thumbs-up far',
				'fa-thumbs-up fas',
				'fa-thumbtack fas',
				'fa-ticket-alt fas',
				'fa-times fas',
				'fa-times-circle far',
				'fa-times-circle fas',
				'fa-tint fas',
				'fa-toggle-off fas',
				'fa-toggle-on fas',
				'fa-trademark fas',
				'fa-train fas',
				'fa-transgender fas',
				'fa-transgender-alt fas',
				'fa-trash fas',
				'fa-trash-alt far',
				'fa-trash-alt fas',
				'fa-tree fas',
				'fa-trophy fas',
				'fa-truck fas',
				'fa-truck-loading fas',
				'fa-truck-moving fas',
				'fa-tty fas',
				'fa-tv fas',
				'fa-umbrella fas',
				'fa-underline fas',
				'fa-undo fas',
				'fa-undo-alt fas',
				'fa-universal-access fas',
				'fa-university fas',
				'fa-unlink fas',
				'fa-unlock fas',
				'fa-unlock-alt fas',
				'fa-upload fas',
				'fa-user far',
				'fa-user fas',
				'fa-user-circle far',
				'fa-user-circle fas',
				'fa-user-md fas',
				'fa-user-plus fas',
				'fa-users fas',
				'fa-user-secret fas',
				'fa-user-times fas',
				'fa-utensils fas',
				'fa-utensil-spoon fas',
				'fa-venus fas',
				'fa-venus-double fas',
				'fa-venus-mars fas',
				'fa-vial fas',
				'fa-vials fas',
				'fa-video fas',
				'fa-video-slash fas',
				'fa-volleyball-ball fas',
				'fa-volume-down fas',
				'fa-volume-off fas',
				'fa-volume-up fas',
				'fa-warehouse fas',
				'fa-weight fas',
				'fa-wheelchair fas',
				'fa-wifi fas',
				'fa-window-close far',
				'fa-window-close fas',
				'fa-window-maximize far',
				'fa-window-maximize fas',
				'fa-window-minimize far',
				'fa-window-minimize fas',
				'fa-window-restore far',
				'fa-window-restore fas',
				'fa-wine-glass fas',
				'fa-won-sign fas',
				'fa-wrench fas',
				'fa-x-ray fas',
				'fa-yen-sign fas',
			),

			'brands' => array (
				'fa-500px fab',
				'fa-accessible-icon fab',
				'fa-accusoft fab',
				'fa-adn fab',
				'fa-adversal fab',
				'fa-affiliatetheme fab',
				'fa-algolia fab',
				'fa-amazon fab',
				'fa-amazon-pay fab',
				'fa-amilia fab',
				'fa-android fab',
				'fa-angellist fab',
				'fa-angrycreative fab',
				'fa-angular fab',
				'fa-app-store fab',
				'fa-app-store-ios fab',
				'fa-apper fab',
				'fa-apple fab',
				'fa-apple-pay fab',
				'fa-asymmetrik fab',
				'fa-audible fab',
				'fa-autoprefixer fab',
				'fa-avianex fab',
				'fa-aviato fab',
				'fa-aws fab',
				'fa-bandcamp fab',
				'fa-behance fab',
				'fa-behance-square fab',
				'fa-bimobject fab',
				'fa-bitbucket fab',
				'fa-bitcoin fab',
				'fa-bity fab',
				'fa-black-tie fab',
				'fa-blackberry fab',
				'fa-blogger fab',
				'fa-blogger-b fab',
				'fa-bluetooth fab',
				'fa-bluetooth-b fab',
				'fa-btc fab',
				'fa-buromobelexperte fab',
				'fa-buysellads fab',
				'fa-cc-amazon-pay fab',
				'fa-cc-amex fab',
				'fa-cc-apple-pay fab',
				'fa-cc-diners-club fab',
				'fa-cc-discover fab',
				'fa-cc-jcb fab',
				'fa-cc-mastercard fab',
				'fa-cc-paypal fab',
				'fa-cc-stripe fab',
				'fa-cc-visa fab',
				'fa-centercode fab',
				'fa-chrome fab',
				'fa-cloudscale fab',
				'fa-cloudsmith fab',
				'fa-cloudversify fab',
				'fa-codepen fab',
				'fa-codiepie fab',
				'fa-connectdevelop fab',
				'fa-contao fab',
				'fa-cpanel fab',
				'fa-creative-commons fab',
				'fa-css3 fab',
				'fa-css3-alt fab',
				'fa-cuttlefish fab',
				'fa-d-and-d fab',
				'fa-dashcube fab',
				'fa-delicious fab',
				'fa-deploydog fab',
				'fa-deskpro fab',
				'fa-deviantart fab',
				'fa-digg fab',
				'fa-digital-ocean fab',
				'fa-discord fab',
				'fa-discourse fab',
				'fa-dochub fab',
				'fa-docker fab',
				'fa-draft2digital fab',
				'fa-dribbble fab',
				'fa-dribbble-square fab',
				'fa-dropbox fab',
				'fa-drupal fab',
				'fa-dyalog fab',
				'fa-earlybirds fab',
				'fa-edge fab',
				'fa-elementor fab',
				'fa-ember fab',
				'fa-empire fab',
				'fa-envira fab',
				'fa-erlang fab',
				'fa-ethereum fab',
				'fa-etsy fab',
				'fa-expeditedssl fab',
				'fa-facebook fab',
				'fa-facebook-f fab',
				'fa-facebook-messenger fab',
				'fa-facebook-square fab',
				'fa-firefox fab',
				'fa-first-order fab',
				'fa-firstdraft fab',
				'fa-flickr fab',
				'fa-flipboard fab',
				'fa-fly fab',
				'fa-font-awesome fab',
				'fa-font-awesome-alt fab',
				'fa-font-awesome-flag fab',
				'fa-fonticons fab',
				'fa-fonticons-fi fab',
				'fa-fort-awesome fab',
				'fa-fort-awesome-alt fab',
				'fa-forumbee fab',
				'fa-foursquare fab',
				'fa-free-code-camp fab',
				'fa-freebsd fab',
				'fa-get-pocket fab',
				'fa-gg fab',
				'fa-gg-circle fab',
				'fa-git fab',
				'fa-git-square fab',
				'fa-github fab',
				'fa-github-alt fab',
				'fa-github-square fab',
				'fa-gitkraken fab',
				'fa-gitlab fab',
				'fa-gitter fab',
				'fa-glide fab',
				'fa-glide-g fab',
				'fa-gofore fab',
				'fa-goodreads fab',
				'fa-goodreads-g fab',
				'fa-google fab',
				'fa-google-drive fab',
				'fa-google-play fab',
				'fa-google-plus fab',
				'fa-google-plus-g fab',
				'fa-google-plus-square fab',
				'fa-google-wallet fab',
				'fa-gratipay fab',
				'fa-grav fab',
				'fa-gripfire fab',
				'fa-grunt fab',
				'fa-gulp fab',
				'fa-hacker-news fab',
				'fa-hacker-news-square fab',
				'fa-hips fab',
				'fa-hire-a-helper fab',
				'fa-hooli fab',
				'fa-hotjar fab',
				'fa-houzz fab',
				'fa-html5 fab',
				'fa-hubspot fab',
				'fa-imdb fab',
				'fa-instagram fab',
				'fa-internet-explorer fab',
				'fa-ioxhost fab',
				'fa-itunes fab',
				'fa-itunes-note fab',
				'fa-java fab',
				'fa-jenkins fab',
				'fa-joget fab',
				'fa-joomla fab',
				'fa-js fab',
				'fa-js-square fab',
				'fa-jsfiddle fab',
				'fa-keycdn fab',
				'fa-kickstarter fab',
				'fa-kickstarter-k fab',
				'fa-korvue fab',
				'fa-laravel fab',
				'fa-lastfm fab',
				'fa-lastfm-square fab',
				'fa-leanpub fab',
				'fa-less fab',
				'fa-line fab',
				'fa-linkedin fab',
				'fa-linkedin-in fab',
				'fa-linode fab',
				'fa-linux fab',
				'fa-lyft fab',
				'fa-magento fab',
				'fa-maxcdn fab',
				'fa-medapps fab',
				'fa-medium fab',
				'fa-medium-m fab',
				'fa-medrt fab',
				'fa-meetup fab',
				'fa-microsoft fab',
				'fa-mix fab',
				'fa-mixcloud fab',
				'fa-mizuni fab',
				'fa-modx fab',
				'fa-monero fab',
				'fa-napster fab',
				'fa-nintendo-switch fab',
				'fa-node fab',
				'fa-node-js fab',
				'fa-npm fab',
				'fa-ns8 fab',
				'fa-nutritionix fab',
				'fa-odnoklassniki fab',
				'fa-odnoklassniki-square fab',
				'fa-opencart fab',
				'fa-openid fab',
				'fa-opera fab',
				'fa-optin-monster fab',
				'fa-osi fab',
				'fa-page4 fab',
				'fa-pagelines fab',
				'fa-palfed fab',
				'fa-patreon fab',
				'fa-paypal fab',
				'fa-periscope fab',
				'fa-phabricator fab',
				'fa-phoenix-framework fab',
				'fa-php fab',
				'fa-pied-piper fab',
				'fa-pied-piper-alt fab',
				'fa-pied-piper-hat fab',
				'fa-pied-piper-pp fab',
				'fa-pinterest fab',
				'fa-pinterest-p fab',
				'fa-pinterest-square fab',
				'fa-playstation fab',
				'fa-product-hunt fab',
				'fa-pushed fab',
				'fa-python fab',
				'fa-qq fab',
				'fa-quinscape fab',
				'fa-quora fab',
				'fa-ravelry fab',
				'fa-react fab',
				'fa-readme fab',
				'fa-rebel fab',
				'fa-red-river fab',
				'fa-reddit fab',
				'fa-reddit-alien fab',
				'fa-reddit-square fab',
				'fa-rendact fab',
				'fa-renren fab',
				'fa-replyd fab',
				'fa-resolving fab',
				'fa-rocketchat fab',
				'fa-rockrms fab',
				'fa-safari fab',
				'fa-sass fab',
				'fa-schlix fab',
				'fa-scribd fab',
				'fa-searchengin fab',
				'fa-sellcast fab',
				'fa-sellsy fab',
				'fa-servicestack fab',
				'fa-shirtsinbulk fab',
				'fa-simplybuilt fab',
				'fa-sistrix fab',
				'fa-skyatlas fab',
				'fa-skype fab',
				'fa-slack fab',
				'fa-slack-hash fab',
				'fa-slideshare fab',
				'fa-snapchat fab',
				'fa-snapchat-ghost fab',
				'fa-snapchat-square fab',
				'fa-soundcloud fab',
				'fa-speakap fab',
				'fa-spotify fab',
				'fa-stack-exchange fab',
				'fa-stack-overflow fab',
				'fa-staylinked fab',
				'fa-steam fab',
				'fa-steam-square fab',
				'fa-steam-symbol fab',
				'fa-sticker-mule fab',
				'fa-strava fab',
				'fa-stripe fab',
				'fa-stripe-s fab',
				'fa-studiovinari fab',
				'fa-stumbleupon fab',
				'fa-stumbleupon-circle fab',
				'fa-superpowers fab',
				'fa-supple fab',
				'fa-telegram fab',
				'fa-telegram-plane fab',
				'fa-tencent-weibo fab',
				'fa-themeisle fab',
				'fa-trello fab',
				'fa-tripadvisor fab',
				'fa-tumblr fab',
				'fa-tumblr-square fab',
				'fa-twitch fab',
				'fa-twitter fab',
				'fa-twitter-square fab',
				'fa-typo3 fab',
				'fa-uber fab',
				'fa-uikit fab',
				'fa-uniregistry fab',
				'fa-untappd fab',
				'fa-usb fab',
				'fa-ussunnah fab',
				'fa-vaadin fab',
				'fa-viacoin fab',
				'fa-viadeo fab',
				'fa-viadeo-square fab',
				'fa-viber fab',
				'fa-vimeo fab',
				'fa-vimeo-square fab',
				'fa-vimeo-v fab',
				'fa-vine fab',
				'fa-vk fab',
				'fa-vnv fab',
				'fa-vuejs fab',
				'fa-weibo fab',
				'fa-weixin fab',
				'fa-whatsapp fab',
				'fa-whatsapp-square fab',
				'fa-whmcs fab',
				'fa-wikipedia-w fab',
				'fa-windows fab',
				'fa-wordpress fab',
				'fa-wordpress-simple fab',
				'fa-wpbeginner fab',
				'fa-wpexplorer fab',
				'fa-wpforms fab',
				'fa-xbox fab',
				'fa-xing fab',
				'fa-xing-square fab',
				'fa-y-combinator fab',
				'fa-yahoo fab',
				'fa-yandex fab',
				'fa-yandex-international fab',
				'fa-yelp fab',
				'fa-yoast fab',
				'fa-youtube fab',
				'fa-youtube-square fab',
			),

		) );
	endif;

}