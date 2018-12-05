<?php
/**
 * General template functions. These functions are for use throughout the theme's various template files.
 * Their main purpose is to handle many of the template tags that are currently lacking in core WordPress.
 *
 * @credit https://github.com/justintadlock/hybrid-core/blob/master/inc/template-comments.php
 * @credit https://github.com/justintadlock/hybrid-core/blob/master/inc/template-general.php
 *
 * @package    Hoot Du
 * @subpackage Library
 */

/**
 * Outputs an HTML element's attributes.
 *
 * @since 3.0.0
 * @access public
 * @param string $slug The slug/ID of the element (e.g., 'sidebar').
 * @param string $context A specific context (e.g., 'primary').
 * @param string|array $attr Addisitonal css classes to add / Array of attributes to pass in (overwrites filters).
 * @return void
 */
if ( !function_exists( 'hootdu_attr' ) ):
function hootdu_attr( $slug, $context = '', $attr = '' ) {
	echo hootdu_get_attr( $slug, $context, $attr );
}
endif;

/**
 * Gets an HTML element's attributes. This function is actually meant so plugins and child themes can easily filter data.
 * The purpose is to allow modify, remove, or add any attributes without having to edit every template file in the theme.
 * So, one could support microformats instead of microdata, if desired.
 *
 * @since 3.0.0
 * @access public
 * @param string $slug The slug/ID of the element (e.g., 'sidebar').
 * @param string $context A specific context (e.g., 'primary').
 * @param string|array $attr Addisitonal css classes to add / Array of attributes to pass in (overwrites filters).
 * @return string
 */
if ( !function_exists( 'hootdu_get_attr' ) ):
function hootdu_get_attr( $slug, $context = '', $attr = '' ) {

	/* Define variables */
	$out             = '';
	$classes         = ( is_string( $attr ) ) ? $attr : '';
	$attr            = ( is_array( $attr ) ) ? $attr : array();
	$attr['classes'] = ( !empty( $classes ) ) ? $classes : '';

	/* Build attrs */
	// $slugger = str_replace( "-", "_", $slug );
	$attr = apply_filters( "hootdu_attr_{$slug}", $attr, $context );
	if ( !isset( $attr['class'] ) )
		$attr['class'] = $slug;

	/* Add custom Classes if any */
	if ( !empty( $attr['classes'] ) && is_string( $attr['classes'] ) )
		$attr['class'] .= ' ' . $attr['classes'];
	unset( $attr['classes'] );

	/* Create attributes */

	// 1. Get ID and class first
	foreach ( array( 'id', 'class' ) as $key ) {
		if ( !empty( $attr[ $key ] ) ) {
			$out .= ' ' . esc_attr( $key ) . '="' . hootdu_sanitize_html_classes( $attr[ $key ] ) . '"';
			unset( $attr[ $key ] );
		}
	}

	// 2. Remaining attributes
	foreach ( $attr as $name => $value ) {
		if ( $value !== false ) {
			$out .= ( !empty( $value ) ) ?
					' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"' :
					' ' . esc_attr( $name );
		}
	}

	return trim( $out );
}
endif;

/**
 * Callback function for 'wp_list_comments' to display individual comments
 *
 * @since 3.0.0
 * @access public
 * @param array
 * @param string
 * @return array
 */
if ( !function_exists( 'hootdu_comments_callback' ) ) :
function hootdu_comments_callback( $comment ) {

	// Get the comment type of the current comment.
	$comment_type = get_comment_type( $comment->comment_ID );

	// Locate the template and include it
	$template = hootdu_get_comment( $comment_type, false );
	if ( !empty( $template ) )
		include( $template );

}
endif;

/**
 * Callback function for 'wp_list_comments' to display end of individual comments
 *
 * @since 3.0.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_comments_end_callback' ) ) :
function hootdu_comments_end_callback() {
	echo '</li><!-- .comment -->';
}
endif;

/**
 * Outputs the comment reply link.  Note that WP's 'comment_reply_link()' doesn't work outside of
 * 'wp_list_comments()' without passing in the proper arguments (it isn't meant to).  This function
 * is just a wrapper for 'get_comment_reply_link()', which adds in the arguments automatically.
 *
 * @since 3.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
if ( !function_exists( 'hootdu_comment_reply_link' ) ) :
function hootdu_comment_reply_link( $args = array() ) {

	if ( ! get_option( 'thread_comments' ) || in_array( get_comment_type(), array( 'pingback', 'trackback' ) ) )
		return '';

	$args = wp_parse_args(
		$args,
		array(
			'depth'     => intval( $GLOBALS['comment_depth'] ),
			'max_depth' => get_option( 'thread_comments_depth' ),
		)
	);
	echo get_comment_reply_link( $args );

}
endif;

/**
 * Returns a link back to the site.
 *
 * @since 3.0.0
 * @access public
 * @return string
 */

if ( !function_exists( 'hootdu_get_site_link' ) ) :
function hootdu_get_site_link() {
	return sprintf( '<a class="site-link" href="%s" rel="home">%s</a>', esc_url( home_url() ), get_bloginfo( 'name' ) );
}
endif;

/**
 * Returns a link to WordPress.org.
 *
 * @since 3.0.0
 * @access public
 * @return string
 */
if ( !function_exists( 'hootdu_get_wp_link' ) ) :
function hootdu_get_wp_link() {
	return sprintf( '<a class="wp-link" href="%s">%s</a>', esc_url( __( 'https://wordpress.org', 'hoot-du' ) ), esc_html__( 'WordPress', 'hoot-du' ) );
}
endif;

/**
 * Returns a link to theme on WordPress.org.
 *
 * @since 3.0.0
 * @access public
 * @param string $link
 * @param string $anchor
 * @return string
 */
if ( !function_exists( 'hootdu_get_wp_theme_link' ) ) :
function hootdu_get_wp_theme_link( $link = '', $anchor = '' ) {
	$slug   = preg_replace( "/[\s-]+/", " ", strtolower( hootdu_data()->template_name ) );
	$slug   = str_replace( " ", "-", $slug );
	$link   = ( empty( $link ) ) ? 'https://wordpress.org/themes/' . $slug : $link;
	$anchor = ( empty( $anchor ) ) ? hootdu_data()->template_name : $anchor;
	/* Translators: %s is the Template Name */
	$title  = sprintf( __( '%s WordPress Theme', 'hoot-du' ), hootdu_data()->template_name );

	return sprintf( '<a class="wp-theme-link" href="%s" title="%s">%s</a>', esc_url( $link ), esc_attr( $title ), esc_html( $anchor ) );
}
endif;

/**
 * Returns a link to the theme URI.
 *
 * @since 3.0.0
 * @access public
 * @param string $link
 * @param string $anchor
 * @return string
 */
if ( !function_exists( 'hootdu_get_theme_link' ) ) :
function hootdu_get_theme_link( $link = '', $anchor = '' ) {
	$link   = ( empty( $link ) ) ? hootdu_data()->template_author_uri : $link;
	$anchor = ( empty( $anchor ) ) ? hootdu_data()->template_name : $anchor;
	/* Translators: %s is the Template Name */
	$title  = sprintf( __( '%s WordPress Theme', 'hoot-du' ), hootdu_data()->template_name );

	return sprintf( '<a class="theme-link" href="%s" title="%s">%s</a>', esc_url( $link ), esc_attr( $title ), esc_html( $anchor ) );
}
endif;

/**
 * Get excerpt with Custom Length
 * This function must be used within loop
 * @NU
 *
 * @since 3.0.0
 * @access public
 * @param int $words
 * @return string
 */
if ( !function_exists( 'hootdu_get_excerpt' ) ):
function hootdu_get_excerpt( $words ) {
	if ( empty( $words ) ) {
		return apply_filters( 'the_excerpt', get_the_excerpt() );
	} else {
		hootdu_set_data( 'excerpt_customlength', $words );
		add_filter( 'excerpt_length', 'hootdu_getexcerpt_customlength', 99999 );
		$return = apply_filters( 'the_excerpt', get_the_excerpt() );
		remove_filter( 'excerpt_length', 'hootdu_getexcerpt_customlength', 99999 );
		hootdu_unset_data( 'excerpt_customlength' );
		return $return;
	}
}
endif;

/**
 * Custom Excerpt Length if set
 * @NU
 *
 * @since 3.0.0
 * @access public
 * @param int $length
 * @return int
 */
if ( !function_exists( 'hootdu_getexcerpt_customlength' ) ):
function hootdu_getexcerpt_customlength( $length ){
	$excerpt_customlength = hootdu_data( 'excerpt_customlength' );
	if ( !empty( $excerpt_customlength ) )
		return $excerpt_customlength;
	else
		return $length;
}
endif;

/**
 * Temporarily remove read more links from excerpts
 * Used with 'hootdu_reinstate_readmore_link'
 * @NU
 *
 * @since 3.0.0
 * @access public
 */
if ( !function_exists( 'hootdu_remove_readmore_link' ) ):
function hootdu_remove_readmore_link() {
	add_filter( 'hootdu_readmore', 'hootdu_readmore_empty_string' );
}
endif;
if ( !function_exists( 'hootdu_readmore_empty_string' ) ):
function hootdu_readmore_empty_string() {
	return '';
}
endif;

/**
 * Reinstate read more links to excerpts
 * Used with 'hootdu_remove_readmore_link'
 * @NU
 *
 * @since 3.0.0
 * @access public
 */
if ( !function_exists( 'hootdu_reinstate_readmore_link' ) ):
function hootdu_reinstate_readmore_link() {
	remove_filter( 'hootdu_readmore', 'hootdu_readmore_empty_string' );
}
endif;

/**
 * Add debug info if HOOT_DEBUG is true
 *
 * @since 3.0.0
 * @access public
 */
if ( !function_exists( 'hootdu_debug_info' ) ):
function hootdu_debug_info( $msg, $return = false ) {
	static $string = '';
	if ( !empty( $msg ) )
		$string = $string . $msg;
	if ( $return )
		return $string;
}
endif;

/**
 * Add debug info if HOOT_DEBUG is true
 *
 * @since 3.0.0
 * @access public
 */
if ( !function_exists( 'hootdu_add_debug_info' ) ):
function hootdu_add_debug_info() {
	if ( current_user_can('manage_options') ) {
		echo "\n<!-- HOOT DEBUG INFO-->\n" ;
		if ( function_exists( 'hootdu_developer_data' ) )
			echo "\n<!-- " . esc_html( hootdu_developer_data() ) . "-->\n" ;
		$info = ( defined( 'HOOT_DEBUG' ) && true === HOOT_DEBUG ) ? hootdu_debug_info( '', true ) : '';
		if ( $info )
			echo "<!--\n" . esc_html( $info ) . "\n-->" ;
	}
}
endif;
add_action( 'wp_footer', 'hootdu_add_debug_info' );
add_action( 'admin_footer', 'hootdu_add_debug_info' );

/**
 * Display Site Performance Data
 *
 * @since 3.0.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_developer_data' ) ):
function hootdu_developer_data( $commented = true ) {
	ob_start();
	echo intval( get_num_queries() ) . ' ' . esc_attr__( 'queries.', 'hoot-du' ) . ' ';
	timer_stop(1);
	echo esc_html( ' ' . __( 'seconds.', 'hoot-du' ) . ' ' . ( memory_get_peak_usage(1) / 1024 ) / 1024 . 'MB' );
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}
endif;