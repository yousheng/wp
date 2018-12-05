<?php
/**
 * Enqueue scripts and styles for the theme.
 * This file is loaded via the 'after_setup_theme' hook at priority '10'
 *
 * @package    Hoot Du
 * @subpackage Theme
 */

/* Add custom scripts. */
add_action( 'wp_enqueue_scripts', 'hootdu_theme_enqueue_scripts', 9 );

/* Set data for theme scripts localization. hootduData is actually localized at priority 11, so populate data before that at priority 9 */
add_action( 'wp_enqueue_scripts', 'hootdu_theme_localize_script', 9 );

/* Load theme script. Set priority to 11 so that the main script.js is loaded after @12, while other scripts are loaded before @10.*/
add_action( 'wp_enqueue_scripts', 'hootdu_theme_base_enqueue_scripts', 11 );

/* Add custom styles. Set priority to default 10 so that theme's main style is loaded after these styles @12, and can thus easily override any style without over-qualification. */
add_action( 'wp_enqueue_scripts', 'hootdu_theme_enqueue_styles', 10 );

/* Dequeue font awesome */
add_action( 'wp_enqueue_scripts', 'hootdu_theme_dequeue_fontawesome', 99 );

/**
 * Load scripts for the front end.
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_enqueue_scripts' ) ) :
function hootdu_theme_enqueue_scripts() {

	/* Load the comment reply script on singular posts with open comments if threaded comments are supported. */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );

	/* Load jquery */
	wp_enqueue_script( 'jquery' );

	/* Load Superfish and WP's hoverIntent */
	wp_enqueue_script( 'hoverIntent' );
	$script_uri = hootdu_locate_script( 'js/jquery.superfish' );
	wp_enqueue_script( 'jquery-superfish', $script_uri, array( 'jquery', 'hoverIntent'), '1.7.5', true );

	/* Load fitvids */
	$script_uri = hootdu_locate_script( 'js/jquery.fitvids' );
	wp_enqueue_script( 'jquery-fitvids', $script_uri, array( 'jquery' ), '1.1', true );

	/* Load parallax */
	$script_uri = hootdu_locate_script( 'js/jquery.parallax' );
	wp_enqueue_script( 'jquery-parallax', $script_uri, array( 'jquery' ), '1.4.2', true );

	/* Load Theia Sticky Sidebar */
	if ( !hootdu_get_mod( 'disable_sticky_sidebar' ) ) {
		$script_uri = hootdu_locate_script( 'js/resizesensor' );
		wp_enqueue_script( 'resizesensor', $script_uri, array(), '1.7.0', true );
		$script_uri = hootdu_locate_script( 'js/jquery.theia-sticky-sidebar' );
		wp_enqueue_script( 'jquery-theia-sticky-sidebar', $script_uri, array( 'jquery', 'resizesensor' ), '1.7.0', true );
	}

}
endif;

/**
 * Set data for theme scripts localization
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_localize_script' ) ) :
function hootdu_theme_localize_script() {

	$scriptdata = hootdu_data( 'scriptdata' );
	if ( empty( $scriptdata ) )
		$scriptdata = array();

	// Sticky Sidebar
	if ( hootdu_get_mod( 'disable_sticky_sidebar' ) )
		$scriptdata['stickySidebar'] = 'disable';

	hootdu_set_data( 'scriptdata', $scriptdata );

}
endif;

/**
 * Load scripts for the front end.
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_base_enqueue_scripts' ) ) :
function hootdu_theme_base_enqueue_scripts() {

	/* Load Theme Javascript */
	$script_uri = hootdu_locate_script( 'js/hoot.theme' );
	wp_enqueue_script( 'hootdu-theme', $script_uri, array( 'jquery' ), hootdu_data()->template_version, true );

	/* Pass data to various Theme Scripts. We use jquery so that data is available to all (jquery dependant) theme loaded scripts */
	$scriptdata = hootdu_data( 'scriptdata' );
	if ( !empty( $scriptdata ) && is_array( $scriptdata ) )
		wp_localize_script( 'jquery', 'hootduData', $scriptdata );

}
endif;

/**
 * Load stylesheets for the front end.
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_enqueue_styles' ) ) :
function hootdu_theme_enqueue_styles() {

	/* Load Google Fonts if 'google-fonts' is active. */
	$style_uri = hootdu_theme_google_fonts_enqueue_url();
	if ( $style_uri )
		wp_enqueue_style( 'hootdu-theme-googlefont', $style_uri, array(), null );

	/* Load font awesome if 'font-awesome' is active. */
	if ( apply_filters( 'hootdu_force_theme_fa', true, 'frontend' ) )
		wp_deregister_style( 'font-awesome' ); // Bug Fix for plugins using older font-awesome library
	$style_uri = hootdu_locate_style( hootdu_data()->liburi . 'fonticons/font-awesome' );
	wp_enqueue_style( 'font-awesome', $style_uri, false, '5.0.10' );

}
endif;

/**
 * Dequeue font awesome from frontend if a similar handle exists (registered by another plugin)
 * but it is already enqueued using the theme
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_dequeue_fontawesome' ) ) :
function hootdu_theme_dequeue_fontawesome() {
	if ( wp_style_is( 'fontawesome' ) )
		wp_dequeue_style( 'fontawesome' );
}
endif;