<?php
/**
 * Loads up all the necessary libraries and functions.
 * This file should be loaded before anything else.
 *
 * @package    Hoot Du
 * @subpackage Library
 */

/* Define parent theme, and child theme constants. */
add_action( 'after_setup_theme', 'hootdu_lib_constants', 1 );

/* Load the core functions/classes */
add_action( 'after_setup_theme', 'hootdu_lib_core', 2 );

/**
 * Defines the constant paths for use throughout the theme.
 *
 * @since 3.0.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_lib_constants' ) ) :
function hootdu_lib_constants() {

	// Set Hoot Version.
	hootdu_set_data( 'hootdu_version', '3.0.0' );

	// Theme directory paths
	hootdu_set_data( 'template_dir', trailingslashit( get_template_directory() ) );
	hootdu_set_data( 'child_dir',    trailingslashit( get_stylesheet_directory() ) );
	// Theme directory URIs
	hootdu_set_data( 'template_uri', trailingslashit( get_template_directory_uri() ) );
	hootdu_set_data( 'child_uri',    trailingslashit( get_stylesheet_directory_uri() ) );

	// Set Theme Location Constants
	hootdu_set_data( 'libdir',       trailingslashit( hootdu_data()->template_dir . 'library' ) );
	hootdu_set_data( 'liburi',       trailingslashit( hootdu_data()->template_uri . 'library' ) );
	hootdu_set_data( 'incdir',       trailingslashit( hootdu_data()->template_dir . 'include' ) );
	hootdu_set_data( 'incuri',       trailingslashit( hootdu_data()->template_uri . 'include' ) );

	// Set theme detail Constants
	hootdu_set_data( 'theme', wp_get_theme() );
	if ( is_child_theme() ) {
		hootdu_set_data( 'childtheme_version',  hootdu_data( 'theme' )->get( 'Version' ) );
		hootdu_set_data( 'template_version',    hootdu_data( 'theme' )->parent()->get( 'Version' ) );
		hootdu_set_data( 'template_name',       hootdu_data( 'theme' )->parent()->get( 'Name' ) );
		hootdu_set_data( 'template_author',     hootdu_data( 'theme' )->parent()->get( 'Author' ) );
		hootdu_set_data( 'template_author_uri', hootdu_data( 'theme' )->parent()->get( 'AuthorURI' ) );
	} else {
		hootdu_set_data( 'template_version',    hootdu_data( 'theme' )->get( 'Version' ) );
		hootdu_set_data( 'template_name',       hootdu_data( 'theme' )->get( 'Name' ) );
		hootdu_set_data( 'template_author',     hootdu_data( 'theme' )->get( 'Author' ) );
		hootdu_set_data( 'template_author_uri', hootdu_data( 'theme' )->get( 'AuthorURI' ) );
	}

	// Custom allowed tags to accomodate microdata schema to be used in wp_kses()
	global $allowedposttags;
	$hootallowedtags = $allowedposttags;
	$hootallowedtags[ 'time' ] = array( 'id' => 1, 'class' => 1, 'datetime' => 1, 'title' => 1 );
	$hootallowedtags[ 'meta' ] = array( 'content' => 1 );
	foreach ( $hootallowedtags as $key => $value ) {
		if ( !empty( $value ) ) $hootallowedtags[ $key ]['itemprop'] = $hootallowedtags[ $key ]['itemscope'] = $hootallowedtags[ $key ]['itemtype'] = 1;
	}
	hootdu_set_data( 'hootallowedtags', $hootallowedtags );

}
endif;

/**
 * Loads the core classes & functions. These files are needed before loading anything else in the 
 * theme because they have required functions for use. Many of the files run filters that 
 * may be removed using child theme or plugins.
 *
 * @since 3.0.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_lib_core' ) ) :
function hootdu_lib_core() {

	/* Load language functions */
	require_once( hootdu_data()->libdir . 'i18n.php' );
	/* Load schema attributes */
	require_once( hootdu_data()->libdir . 'attr-schema.php' );
	/* Load context functions */
	require_once( hootdu_data()->libdir . 'context.php' );
	/* Load up functions hooked to filters */
	require_once( hootdu_data()->libdir . 'filters.php' );
	/* Load the data set functions => also needed for sanitization. */
	require_once( hootdu_data()->libdir . 'enum.php' );
	/* Load Sanitization functions. */
	require_once( hootdu_data()->libdir . 'sanitization.php' );
	/* Load Helper functions */
	require_once( hootdu_data()->libdir . 'helpers.php' );
	/* Load Media functions */
	require_once( hootdu_data()->libdir . 'media.php' );
	/* Load functions hooked to head */
	require_once( hootdu_data()->libdir . 'head.php' );
	/* Load the scripts functions. */
	require_once( hootdu_data()->libdir . 'scripts.php' );
	/* Load the styles functions. */
	require_once( hootdu_data()->libdir . 'styles.php' );
	/* Load template location functions. */
	require_once( hootdu_data()->libdir . 'locations.php' );
	/* Load several theme template functions. */
	require_once( hootdu_data()->libdir . 'template.php' );
	/* Load Sidebar functions */
	require_once( hootdu_data()->libdir . 'sidebars.php' );
	/* Load Color functions */
	require_once( hootdu_data()->libdir . 'color.php' );
	/* Load the Customize extension */
	require_once( hootdu_data()->libdir . 'customize/customize.php' );
	/* Load the Style Builder class */
	require_once( hootdu_data()->libdir . 'style-builder.php' );

}
endif;

/* Create an empty object for storing hoot data */
global $hootdu_data;
if ( !isset( $hootdu_data ) || !is_object( $hootdu_data ) )
	$hootdu_data = new stdClass();

/**
 * This function is useful for quickly grabbing data
 *
 * @since 3.0.0
 * @access public
 * @param string
 * @return mixed
 */
if ( !function_exists( 'hootdu_data' ) ) :
function hootdu_data( $key = '', $subkey = '' ) {
	global $hootdu_data;

	// Return entire data object if no key provided
	if ( ! $key ) {
		return $hootdu_data;
	}

	// Return data value
	elseif ( $key && is_string( $key ) ) {
		if ( isset( $hootdu_data->$key ) ) {

			if ( !$subkey || ( !is_string( $subkey ) && !is_integer( $subkey ) ) )
				return $hootdu_data->$key;

			if ( is_object( $hootdu_data->$key ) )
				return ( isset( $hootdu_data->$key->$subkey ) ) ? $hootdu_data->$key->$subkey : null;

			if ( is_array( $hootdu_data->$key ) ) {
				$arr = $hootdu_data->$key;
				return ( isset( $arr[ $subkey ] ) ) ? $arr[ $subkey ] : null;
			}

		} else {

			// $key has not been set in $hootdu_data
			return null;

		}
	}

	// $key provided but isn't a string - Nothing!

}
endif;
/* Declare 'hootdu_get_data' for brevity */
if ( !function_exists( 'hootdu_get_data' ) ) :
function hootdu_get_data( $key = '', $subkey = '' ) {
	return hootdu_data( $key, $subkey );
}
endif;

/**
 * Sets properties of the hootdu_data class. This function is useful for quickly setting data
 *
 * @since 3.0.0
 * @access public
 * @param string
 * @param mixed
 * @param bool $override
 * @return void
 */
if ( !function_exists( 'hootdu_set_data' ) ) :
function hootdu_set_data( $key, $value, $override = true ) {
	global $hootdu_data;
	if ( !isset( $hootdu_data->$key ) || $override )
		$hootdu_data->$key = $value;
}
endif;

/**
 * Unsets properties of the hootdu_data class. This function is useful for quickly setting data
 *
 * @since 3.0.0
 * @access public
 * @param string
 * @return void
 */
if ( !function_exists( 'hootdu_unset_data' ) ) :
function hootdu_unset_data( $key ) {
	global $hootdu_data;
	if ( isset( $hootdu_data->$key ) )
		unset( $hootdu_data->$key );
}
endif;

/* Setup complete */
do_action( 'hootdu_library_loaded' );