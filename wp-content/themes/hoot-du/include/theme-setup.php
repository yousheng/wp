<?php
/**
 * Theme Setup
 * This file is loaded using 'after_setup_theme' hook at priority 10
 *
 * @package    Hoot Du
 * @subpackage Theme
 */


/* === WordPress === */


// Automatically add <title> to head.
add_theme_support( 'title-tag' );

// Adds core WordPress HTML5 support.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add theme support for WordPress Custom Logo
add_theme_support( 'custom-logo' );

// Add theme support for WordPress Custom Background
add_theme_support( 'custom-background', array( 'default-color' => hootdu_theme_default_style( 'site_background' ) ) );

// Add theme support for custom headers
add_theme_support( 'custom-header', array( 'width' => 1380, 'height' => 500, 'flex-height' => true, 'flex-width' => true, 'default-image' => hootdu_data()->template_uri . '/images/header.jpg', 'header-text' => false ) );

// Adds theme support for WordPress 'featured images'.
add_theme_support( 'post-thumbnails' );

// Automatically add feed links to <head>.
add_theme_support( 'automatic-feed-links' );

// WordPress Jetpack
add_theme_support( 'infinite-scroll', array(
	'type' => apply_filters( 'hootdu_theme_jetpack_infinitescroll_type', 'click' ), // scroll or click
	'container' => apply_filters( 'hootdu_theme_jetpack_infinitescroll_container', 'content' ),
	'footer' => false,
	'wrapper' => true,
	'render' => apply_filters( 'hootdu_theme_jetpack_infinitescroll_render', 'hootdu_theme_jetpack_infinitescroll_render' ),
) );


/* === WooCommerce Plugin === */


// Woocommerce support and init load theme woo functions
if ( class_exists( 'WooCommerce' ) ) {
	add_theme_support( 'woocommerce' );
	if ( file_exists( hootdu_data()->template_dir . 'woocommerce/functions.php' ) )
		include_once( hootdu_data()->template_dir . 'woocommerce/functions.php' );
}


/* === Hootkit Plugin === */


// Load theme's Hootkit functions if plugin is active
if ( class_exists( 'HootKit' ) && file_exists( hootdu_data()->template_dir . 'hootkit/functions.php' ) )
	include_once( hootdu_data()->template_dir . 'hootkit/functions.php' );


/* === Theme Hooks === */


/**
 * Handle content width for embeds and images.
 * Hooked into 'init' so that we can pull custom content width from theme options
 *
 * @since 1.0
 * @return void
 */
function hootdu_theme_set_content_width() {
	$width = intval( hootdu_get_mod( 'site_width' ) );
	$width = !empty( $width ) ? $width : 1260;
	$GLOBALS['content_width'] = absint( $width );
}
add_action( 'init', 'hootdu_theme_set_content_width', 10 );

/**
 * Modify the '[...]' Read More Text
 *
 * @since 1.0
 * @return string
 */
function hootdu_theme_readmoretext( $more ) {
	$read_more = esc_html( hootdu_get_mod('read_more') );
	/* Translators: %s is the HTML &rarr; symbol */
	$read_more = ( empty( $read_more ) ) ? sprintf( __( 'Read More %s', 'hoot-du' ), '&rarr;' ) : $read_more;
	return $read_more;
}
add_filter( 'hootdu_readmoretext', 'hootdu_theme_readmoretext' );

/**
 * Modify the exceprt length.
 * Make sure to set the priority correctly such as 999, else the default WordPress filter on this function will run last and override settng here.
 *
 * @since 1.0
 * @return void
 */
function hootdu_theme_custom_excerpt_length( $length ) {
	if ( is_admin() )
		return $length;

	$excerpt_length = intval( hootdu_get_mod('excerpt_length') );
	if ( !empty( $excerpt_length ) )
		return $excerpt_length;
	return 50;
}
add_filter( 'excerpt_length', 'hootdu_theme_custom_excerpt_length', 999 );

/**
 * Register recommended plugins via TGMPA
 *
 * @since 1.0
 * @return void
 */
function hootdu_theme_tgmpa_plugins() {
	// Array of plugin arrays. Required keys are name and slug.
	// Since source is from the .org repo, it is not required.
	$plugins = apply_filters( 'hootdu_theme_tgmpa_plugins', array(
		array(
			'name'     => __( '(HootKit) Hoot Du Sliders, Widgets, 1-Click Installation', 'hoot-du' ),
			'slug'     => 'hootkit',
			'required' => false,
		),
	) );
	// Array of configuration settings.
	$config = array(
		'is_automatic' => true,
	);
	// Register plugins with TGM_Plugin_Activation class
	tgmpa( $plugins, $config );
}
add_filter( 'tgmpa_register', 'hootdu_theme_tgmpa_plugins' );