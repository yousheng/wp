<?php
/**
 * HTML attribute filters.
 * Filter schema ('library/attr-schema.php') for generic container's attributes based on specific theme options
 * Attributes for non-generic structural elements (mostly theme specific) are also loaded in this file.
 *
 * @package    Hoot Du
 * @subpackage Theme
 */

/* Modify Original Schema for Generic container's Option specific attributes */
add_filter( 'hootdu_attr_header',   'hootdu_theme_attr_header',   7, 2 );
add_filter( 'hootdu_attr_menu',     'hootdu_theme_attr_menu',     7, 2 );
add_filter( 'hootdu_attr_content',  'hootdu_theme_attr_content',  7    );
add_filter( 'hootdu_attr_sidebar',  'hootdu_theme_attr_sidebar',  7, 2 );
add_filter( 'hootdu_attr_branding', 'hootdu_theme_attr_branding', 7    );

/* New Theme Filters */
add_filter( 'hootdu_attr_page-wrapper',      'hootdu_theme_attr_page_wrapper',      7    );
add_filter( 'hootdu_attr_topbar',            'hootdu_theme_attr_topbar',            7    );
add_filter( 'hootdu_attr_header-part',       'hootdu_theme_attr_header_part',       7, 2 );
add_filter( 'hootdu_attr_header-aside',      'hootdu_theme_attr_header_aside',      7    );
add_filter( 'hootdu_attr_below-header',      'hootdu_theme_attr_below_header',      7    );
add_filter( 'hootdu_attr_main',              'hootdu_theme_attr_main',              7    );
add_filter( 'hootdu_attr_frontpage-grid',    'hootdu_theme_attr_frontpage_grid',    7    );
add_filter( 'hootdu_attr_frontpage-content', 'hootdu_theme_attr_frontpage_content', 7    );
add_filter( 'hootdu_attr_frontpage-area',    'hootdu_theme_attr_frontpage_area',    7, 2 );
add_filter( 'hootdu_attr_loop-meta-wrap',    'hootdu_theme_attr_loop_meta_wrap',    7, 2 );
add_filter( 'hootdu_attr_loop-meta',         'hootdu_theme_attr_loop_meta',         7, 2 ); // This is a bit more generic (archive / singular etc ) than just for archives
add_filter( 'hootdu_attr_loop-title',        'hootdu_theme_attr_loop_title',        7, 2 ); // This is a bit more generic (archive / singular etc ) than just for archives
add_filter( 'hootdu_attr_loop-description',  'hootdu_theme_attr_loop_description',  7, 2 ); // This is a bit more generic (archive / singular etc ) than just for archives
add_filter( 'hootdu_attr_content-wrap',      'hootdu_theme_attr_content_wrap',      7, 2 );
add_filter( 'hootdu_attr_sidebar-wrap',      'hootdu_theme_attr_sidebar_wrap',      7, 2 );
add_filter( 'hootdu_attr_sub-footer',        'hootdu_theme_attr_sub_footer',        7    );
add_filter( 'hootdu_attr_post-footer',       'hootdu_theme_attr_post_footer',       7    );

/**
 * Modify <header> element attributes
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_header( $attr, $context ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' header-layout-primary-' . hootdu_get_mod( 'primary_menuarea' );
	$attr['class'] .= ' header-layout-secondary-' . hootdu_get_mod( 'secondary_menu_location' );
	$attr['class'] .= ( hootdu_get_mod( 'disable_table_menu' ) ) ? '' : ' tablemenu';
	return $attr;
}

/**
 * Nav menu attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_menu( $attr, $context ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$mobile_menu = hootdu_get_mod( 'mobile_menu' );
	$attr['class'] .= " mobilemenu-{$mobile_menu}";
	$mobile_submenu_click = hootdu_get_mod( 'mobile_submenu_click' );
	$attr['class'] .= ( $mobile_submenu_click ) ? ' mobilesubmenu-click' : ' mobilesubmenu-open';
	return $attr;
}

/**
 * Modify Main content container of the page attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_content( $attr ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];

	$layout_class = hootdu_theme_layout_class( 'content' );
	if ( !empty( $layout_class ) )
		$attr['class'] .= ' ' . $layout_class;

	return $attr;
}

/**
 * Modify Sidebar attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_sidebar( $attr, $context ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	if ( !empty( $context ) && ( $context == 'primary' || $context == 'secondary' ) ) {
		$layout_class = hootdu_theme_layout_class( "sidebar" );
		if ( !empty( $layout_class ) )
			$attr['class'] .= $layout_class;
	}

	return $attr;
}

/**
 * Branding attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_branding( $attr ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' table-cell-mid';
	return $attr;
}

/**
 * Page wrapper attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_page_wrapper( $attr ) {
	$attr['id'] = 'page-wrapper';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];

	// Set site layout class
	$site_layout = hootdu_get_mod( 'site_layout' );
	$attr['class'] .= ( $site_layout == 'boxed' ) ? ' hgrid site-boxed' : ' site-stretch';
	$attr['class'] .= ' page-wrapper';

	// Set layout if not already set
	$layout = hootdu_data( 'currentlayout' );
	if ( empty( $layout ) )
		hootdu_theme_layout('');

	// Set sidebar layout class
	$currentlayout = hootdu_data( 'currentlayout', 'layout' );
	if ( !empty( $currentlayout ) ) :
		$attr['class'] .= ' sitewrap-'. $currentlayout;
		switch( $currentlayout ) {
			case 'none' :
			case 'full' :
			case 'full-width' :
				$attr['class'] .= ' sidebars0';
				break;
			case 'narrow-right' :
			case 'wide-right' :
			case 'narrow-left' :
			case 'wide-left' :
				$attr['class'] .= ' sidebarsN sidebars1';
				break;
			case 'narrow-left-left' :
			case 'narrow-left-right' :
			case 'narrow-right-left' :
			case 'narrow-right-right' :
				$attr['class'] .= ' sidebarsN sidebars2';
				break;
		}
	endif;

	// Set plugin style classes
	$classes = apply_filters( 'hootdu_theme_attr_page_wrapper_plugins', array( 'hootdu-cf7-style', 'hootdu-mapp-style', 'hootdu-jetpack-style' ) );
	$attr['class'] .= ' ' . hootdu_sanitize_html_classes( $classes );

	// Set sticky sidebar class
	if ( !hootdu_get_mod( 'disable_sticky_sidebar' ) )
		$attr['class'] .= ' hootdu-sticky-sidebar';

	return $attr;
}

/**
 * Topbar attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_topbar( $attr ) {
	$attr['id'] = 'topbar';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' topbar';
	return $attr;
}

/**
 * Modify header part attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_header_part( $attr, $context ) {
	$attr['id'] = 'header-' . $context;
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];

	$attr['class'] .= ' header-part header-' . $context;
	if ( $context == 'primary' ) {
		$attr['class'] .= ' header-primary-' . hootdu_get_mod( 'primary_menuarea' );
	} elseif ( $context == 'supplementary' ) {
		$attr['class'] .= ' header-supplementary-' . hootdu_get_mod( 'secondary_menu_location' );
		$attr['class'] .= ' header-supplementary-' . hootdu_get_mod( 'secondary_menu_align' );
		$attr['class'] .= ' header-supplementary-mobilemenu-' . hootdu_get_mod( 'mobile_menu' );
	}

	return $attr;
}

/**
 * Header Aside attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_header_aside( $attr ) {
	$attr['id'] = 'header-aside';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' header-aside table-cell-mid';
	return $attr;
}

/**
 * Below Header attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_below_header( $attr ) {
	$attr['id'] = 'below-header';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' below-header';
	return $attr;
}

/**
 * Main attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_main( $attr ) {
	$attr['id'] = 'main';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' main';
	return $attr;
}

/**
 * Main content container of the frontpage
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_frontpage_grid( $attr ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' hgrid-stretch frontpage-grid';

	return $attr;
}

/**
 * Main content container of the frontpage
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_frontpage_content( $attr ) {
	$attr['id'] = 'content-frontpage';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' content-frontpage';

	return $attr;
}

/**
 * Frontpage Area
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_frontpage_area( $attr, $context ) {

	$key = $context;
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$module_bg = hootdu_get_mod( "frontpage_sectionbg_{$key}-type" );

	if ( $module_bg == 'image' ) {
		$module_bg_img = hootdu_get_mod( "frontpage_sectionbg_{$key}-image" );
		if ( !empty( $module_bg_img ) ) {
			$module_bg_parallax = hootdu_get_mod( "frontpage_sectionbg_{$key}-parallax" );
			$attr['class'] .= ( $module_bg_parallax ) ? ' bg-fixed' : ' bg-scroll';
			if ( $module_bg_parallax ) {
				$attr['data-parallax'] = 'scroll';
				// $attr['data-speed'] = '0.4'; // Default is 0.2 :: range [0-1]
				$attr['data-image-src'] = esc_url( $module_bg_img );
			} else {
				$attr['style'] = 'background-image:url(' . esc_attr( $module_bg_img ) . ');';
			}
		}
	} elseif ( $module_bg == 'color' ) {
		$module_bg_color = hootdu_get_mod( "frontpage_sectionbg_{$key}-color" );
		if ( !empty( $module_bg_color ) ) {
			$attr['class'] .= ' area-bgcolor';
			$attr['style'] = 'background-color:' . sanitize_hex_color( $module_bg_color ) . ';';
		}
	}
	return $attr;
}

/**
 * Loop meta attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_loop_meta_wrap( $attr, $context ) {

	$attr['id'] = 'loop-meta';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= 'loop-meta-wrap pageheader-bg-default';

	$imgwrap = ( !empty( $attr['data-image-src'] ) ) ? esc_url( $attr['data-image-src'] ) : '';
	$attr['class'] .= ( ( $imgwrap && !empty( $attr['data-parallax'] ) ) ? ' loop-meta-imgwrap' : '' );

	return $attr;
}

/**
 * Loop meta attributes.
 * hootdu_attr_archive_header in v3.0.0 ; we use it for generic loop (archive / singular etc )
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_loop_meta( $attr, $context ) {

	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' loop-meta';
	if ( $context == 'archive' ) $attr['class'] .= ' archive-header';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'https://schema.org/WebPageElement';
	return $attr;

}

/**
 * Loop title attributes.
 * hootdu_attr_archive_title in v3.0.0 ; we use it for generic loop (archive / singular etc )
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_loop_title( $attr, $context ) {

	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' loop-title';
	if ( $context == 'archive' ) $attr['class'] .= ' archive-title';
	$attr['itemprop']  = 'headline';

	return $attr;
}

/**
 * Loop description attributes.
 * hootdu_attr_archive_description in v3.0.0 ; we use it for generic loop (archive / singular etc
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_loop_description( $attr, $context ) {

	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' loop-description';
	if ( $context == 'archive' ) $attr['class'] .= ' archive-description';
	$attr['itemprop']  = 'text';

	return $attr;
}

/**
 * Content Wrap attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_content_wrap( $attr, $context ) {
	$attr['id'] = 'content-wrap';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' content-wrap';
	if ( !hootdu_get_mod( 'disable_sticky_sidebar' ) )
		$attr['class'] .= ' theiaStickySidebar';
	return $attr;
}

/**
 * Sidebar Wrap attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootdu_theme_attr_sidebar_wrap( $attr, $context ) {
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' sidebar-wrap';
	if ( !hootdu_get_mod( 'disable_sticky_sidebar' ) )
		$attr['class'] .= ' theiaStickySidebar';
	return $attr;
}

/**
 * Subfooter attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_sub_footer( $attr ) {
	$attr['id'] = 'sub-footer';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' sub-footer';
	return $attr;
}

/**
 * Postfooter attributes.
 *
 * @since 1.0
 * @access public
 * @param array $attr
 * @return array
 */
function hootdu_theme_attr_post_footer( $attr ) {
	$attr['id'] = 'post-footer';
	$attr['class'] = ( empty( $attr['class'] ) ) ? '' : $attr['class'];
	$attr['class'] .= ' post-footer';
	return $attr;
}