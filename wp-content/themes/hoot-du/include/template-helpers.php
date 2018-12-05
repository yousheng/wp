<?php
/**
 * Miscellaneous template tags and template utility functions
 * 
 * These functions are for use throughout the theme's various template files.
 * This file is loaded via the 'after_setup_theme' hook at priority '10'
 *
 * @package    Hoot Du
 * @subpackage Theme
 */

/**
 * Display the branding area
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_branding' ) ):
function hootdu_theme_branding() {
	?>
	<div <?php hootdu_attr( 'branding' ); ?>>
		<div id="site-logo" class="<?php
			echo 'site-logo-' . esc_attr( hootdu_get_mod( 'logo' ) );
			if ( hootdu_get_mod('logo_background_type') == 'accent' )
				echo ' accent-typo with-background';
			elseif ( hootdu_get_mod('logo_background_type') == 'background' )
				echo ' with-background';
			?>">
			<?php
			// Display the Image Logo or Site Title
			hootdu_theme_logo();
			?>
		</div>
	</div><!-- #branding -->
	<?php
}
endif;

/**
 * Displays the logo
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_logo' ) ):
function hootdu_theme_logo() {

	$display = '';
	$hootdu_theme_logo = hootdu_get_mod( 'logo' );

	if ( ( is_front_page() ) ) {
		$tag_h1 = 'h1';
		$tag_h2 = 'h2';
	} else {
		$tag_h1 = $tag_h2 = 'div';
	}

	if ( 'text' == $hootdu_theme_logo || 'custom' == $hootdu_theme_logo ) {
		$display .= hootdu_theme_get_text_logo( $hootdu_theme_logo, $tag_h1, $tag_h2 );
	} elseif ( 'mixed' == $hootdu_theme_logo || 'mixedcustom' == $hootdu_theme_logo ) {
		$display .= hootdu_theme_get_mixed_logo( $hootdu_theme_logo, $tag_h1, $tag_h2 );
	} elseif ( 'image' == $hootdu_theme_logo ) {
		$display .= hootdu_theme_get_image_logo( $hootdu_theme_logo, $tag_h1, $tag_h2 );
	}

	echo wp_kses( apply_filters( 'hootdu_theme_logo', $display, $hootdu_theme_logo, $tag_h1, $tag_h2 ), hootdu_data( 'hootallowedtags' ) );
}
endif;

/**
 * Return the text logo
 *
 * @since 1.0
 * @access public
 * @param string $hootdu_theme_logo text|custom
 * @param string $tag_h1
 * @param string $tag_h2
 * @return void
 */
if ( !function_exists( 'hootdu_theme_get_text_logo' ) ):
function hootdu_theme_get_text_logo( $hootdu_theme_logo, $tag_h1 = 'div', $tag_h2 = 'div' ) {
	$display = '';
	$title_icon = hootdu_sanitize_fa( hootdu_get_mod( 'site_title_icon', NULL ) );

	$class = $id = 'site-logo-' . esc_attr( $hootdu_theme_logo );
	$class .= ( $title_icon ) ? ' site-logo-with-icon' : '';
	$class .= ( 'text' == $hootdu_theme_logo && !function_exists( 'hootdu_theme_premium' ) ) ? ' site-logo-text-' . hootdu_get_mod( 'logo_size' ) : '';

	// Start Logo
	$display .= '<div id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '">';

		// Site Title with Icon
		$display .= "<{$tag_h1} " . hootdu_get_attr( 'site-title' ) . '>';
			$display .= '<a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url">';
				$display .= ( $title_icon ) ? '<i class="' . $title_icon . '"></i>' : '';
				$title = ( 'custom' == $hootdu_theme_logo ) ? hootdu_theme_get_custom_text_logo() : get_bloginfo( 'name' );
				$display .= apply_filters( 'hootdu_theme_site_title', $title );
			$display .= "</a>";
		$display .= "</{$tag_h1}>";

		// Site Description
		if ( hootdu_get_mod( 'show_tagline' ) && $desc = get_bloginfo( 'description' ) ) {
			$display .= "<{$tag_h2} " . hootdu_get_attr( 'site-description' ) . '>';
				$display .= $desc;
			$display .= "</{$tag_h2}>";
		}

	$display .= '</div>';

	return apply_filters( 'hootdu_theme_get_text_logo', $display, $hootdu_theme_logo, $tag_h1, $tag_h2 );
}
endif;

/**
 * Return the mixed logo
 *
 * @since 1.0
 * @access public
 * @param string $hootdu_theme_logo mixed|mixedcustom
 * @param string $tag_h1
 * @param string $tag_h2
 * @return void
 */
if ( !function_exists( 'hootdu_theme_get_mixed_logo' ) ):
function hootdu_theme_get_mixed_logo( $hootdu_theme_logo, $tag_h1 = 'div', $tag_h2 = 'div' ) {
	$display = '';
	$has_logo = ( function_exists( 'get_custom_logo' ) ) ? has_custom_logo() : hootdu_get_mod( 'logo_image' );

	$class = $id = 'site-logo-' . esc_attr( $hootdu_theme_logo );
	$class .= ( !empty( $has_logo ) ) ? ' site-logo-with-image' : '';
	$class .= ( 'mixed' == $hootdu_theme_logo && !function_exists( 'hootdu_theme_premium' ) ) ? ' site-logo-text-' . hootdu_get_mod( 'logo_size' ) : '';

	// Start Logo
	$display .= '<div id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '">';

		// Logo Image
		if ( $has_logo ) {
			$display .= '<div class="site-logo-mixed-image">';
				$logo_image = ( function_exists( 'get_custom_logo' ) ) ?
								get_custom_logo() :
								'<a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url">' .
									'<img src="' . esc_url( hootdu_get_mod( 'logo_image' ) ) . '" />' .
								'</a>';
				$display .= $logo_image;
			$display .= '</div>';
		}

		$display .= '<div class="site-logo-mixed-text">';

			// Site Title (No Icon)
			$display .= "<{$tag_h1} " . hootdu_get_attr( 'site-title' ) . '>';
				$display .= '<a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url">';
					$title = ( 'mixedcustom' == $hootdu_theme_logo ) ? hootdu_theme_get_custom_text_logo() : get_bloginfo( 'name' );
					$display .= apply_filters( 'hootdu_theme_site_title', $title );
				$display .= "</a>";
			$display .= "</{$tag_h1}>";

			// Site Description
			if ( hootdu_get_mod( 'show_tagline' ) && $desc = get_bloginfo( 'description' ) ) {
				$display .= "<{$tag_h2} " . hootdu_get_attr( 'site-description' ) . '>';
					$display .= $desc;
				$display .= "</{$tag_h2}>";
			}

		$display .= '</div>';

	$display .= '</div>';

	return apply_filters( 'hootdu_theme_get_mixed_logo', $display, $hootdu_theme_logo, $tag_h1, $tag_h2 );
}
endif;

/**
 * Return the image logo
 *
 * @since 1.0
 * @access public
 * @param string $hootdu_theme_logo
 * @param string $tag_h1
 * @param string $tag_h2
 * @return void
 */
if ( !function_exists( 'hootdu_theme_get_image_logo' ) ):
function hootdu_theme_get_image_logo( $hootdu_theme_logo = 'image', $tag_h1 = 'div', $tag_h2 = 'div' ) {
	$display = '';
	$has_logo = ( function_exists( 'get_custom_logo' ) ) ? has_custom_logo() : hootdu_get_mod( 'logo_image' );

	if ( !empty( $has_logo ) ) {
		$display .= '<div id="site-logo-image" class="site-logo-image">';

			// Logo Image
			$display .= "<{$tag_h1} " . hootdu_get_attr( 'site-title' ) . '>';
				$logo_image = ( function_exists( 'get_custom_logo' ) ) ?
								get_custom_logo() :
								'<a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url">' .
									'<img src="' . esc_url( hootdu_get_mod( 'logo_image' ) ) . '" />' .
								'</a>';
				$display .= $logo_image;
			$display .= "</{$tag_h1}>";

			// Site Description
			if ( hootdu_get_mod( 'show_tagline' ) && $desc = get_bloginfo( 'description' ) ) {
				$display .= "<{$tag_h2} " . hootdu_get_attr( 'site-description' ) . '>';
					$display .= $desc;
				$display .= "</{$tag_h2}>";
			}

		$display .= '</div>';
	}

	return apply_filters( 'hootdu_theme_get_image_logo', $display, $hootdu_theme_logo, $tag_h1, $tag_h2 );
}
endif;

/**
 * Returns the custom text logo
 *
 * @since 1.0
 * @access public
 * @return string
 */
if ( !function_exists( 'hootdu_theme_get_custom_text_logo' ) ):
function hootdu_theme_get_custom_text_logo() {
	$title = '';
	$logo_custom = apply_filters( 'hootdu_theme_logo_custom_text', hootdu_sortlist( hootdu_get_mod( 'logo_custom' ) ) );

	if ( is_array( $logo_custom ) && !empty( $logo_custom ) ) {
		$lcount = 1;
		foreach ( $logo_custom as $logo_custom_line ) {
			if ( !$logo_custom_line['sortitem_hide'] && !empty( $logo_custom_line['text'] ) ) {
				$line_class = 'site-title-line site-title-line' . $lcount;
				$line_class .= ( $logo_custom_line['font'] == 'standard' ) ? ' site-title-body-font' : '';
				$line_class .= ( $logo_custom_line['font'] == 'heading2' ) ? ' site-title-heading-font' : '';
				$title .= '<span class="' . $line_class . '">' . wp_kses_decode_entities( $logo_custom_line['text'] ) . '</span>';
			}
			$lcount++;
		}

	}
	return apply_filters( 'hootdu_theme_get_custom_text_logo', $title, $logo_custom );
}
endif;

/**
 * Display the primary menu area
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_header_aside' ) ):
function hootdu_theme_header_aside() {
	$area = esc_attr( hootdu_get_mod( 'primary_menuarea' ) );
	if ( $area == 'none' )
		return;

	$class = ( $area == 'menu' ) ? 'header-aside-menu-' . hootdu_get_mod( 'mobile_menu' ) : '';
	$class .= ( $area == 'search' ) ? ' js-search' : '';
	?><div <?php hootdu_attr( 'header-aside', '', "header-aside-{$area} {$class}" ); ?>><?php

		if ( $area == 'menu' ):
			// Loads the template-parts/menu-primary.php template.
			hootdu_get_menu( 'primary' );
		endif;

		if ( $area == 'custom' ):
			echo wp_kses_post( hootdu_get_mod( 'primary_menuarea_custom' ) );
		endif;

		if ( $area == 'search' ):
			get_search_form();
		endif;

		if ( $area == 'widget-area' ):
			hootdu_get_sidebar( 'header' );
		endif;

	?></div><?php

}
endif;

/**
 * Display the secondary menu
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_secondary_menu' ) ):
function hootdu_theme_secondary_menu( $location ) {
	$menu_location = hootdu_get_mod( 'secondary_menu_location' );
	if ( $location == $menu_location ) {
		$menu_side = ( is_active_sidebar( 'hoot-menu-side' ) ) ? true : false;
		$menu_side_class = ( $menu_side ) ? 'menu-side' : 'menu-side-none';
		?>
		<div <?php hootdu_attr( 'header-part', 'supplementary', $menu_side_class . ' contrast-typo' ); ?>>
			<div class="hgrid">
				<div class="hgrid-span-12">
					<?php
					if ( $menu_side )
						echo '<div ' . hootdu_get_attr( 'navarea-table', '', 'table' ) . '><div ' . hootdu_get_attr( 'menu-nav-box', 'menu-side', 'table-cell-mid' ) . '>';
					else
						echo '<div ' . hootdu_get_attr( 'menu-nav-box', 'menu-side-none' ) . '>';
					// Loads the template-parts/menu-secondary.php template.
					hootdu_get_menu( 'secondary' );
					echo '</div>';
					if ( $menu_side ) {
						echo '<div ' . hootdu_get_attr( 'menu-side-box', '', 'table-cell-mid inline-nav js-search' ) . '>';
						dynamic_sidebar( 'hoot-menu-side' );
						echo '</div></div>';
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
}
endif;

/**
 * Get the top level menu items array
 * @NU (@U mag hoot)
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hootdu_theme_nav_menu_toplevel_items( $theme_location = 'hoot-primary-menu' ) {
	static $location_items;
	if ( !isset( $location_items[$theme_location] ) && ($theme_locations = get_nav_menu_locations()) && isset( $theme_locations[$theme_location] ) ) {
		$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
		if ( !empty( $menu_obj->term_id ) ) {
			$menu_items = wp_get_nav_menu_items($menu_obj->term_id);
			if ( $menu_items )
				foreach( $menu_items as $menu_item )
					if ( empty( $menu_item->menu_item_parent ) )
						$location_items[$theme_location][] = $menu_item;
		}
	}
	if ( !empty( $location_items[$theme_location] ) )
		return $location_items[$theme_location];
	else
		return array();
}

/**
 * Display Menu Nav Item Description
 *
 * @since 1.0
 * @param string   $title The menu item's title.
 * @param WP_Post  $item  The current menu item.
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return string
 */
if ( !function_exists( 'hootdu_theme_menu_description' ) ):
function hootdu_theme_menu_description( $title, $item, $args, $depth ) {

	$return = '';
	$return .= '<span class="menu-title">' . $title . '</span>';
	if ( !empty( $item->description ) )
		$return .= '<span class="menu-description enforce-body-font">' . $item->description . '</span>';

	return $return;
}
endif;
add_filter( 'nav_menu_item_title', 'hootdu_theme_menu_description', 5, 4 );

/**
 * Display title area content
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_add_custom_title_content' ) ):
function hootdu_theme_add_custom_title_content( $location = 'pre', $context = '' ) {

	$pre_title_content_post = apply_filters( 'hootdu_theme_pre_title_content_post', '', $location, $context );
	if ( ( $location == 'pre' && !$pre_title_content_post ) ||
		 ( $location == 'post' && $pre_title_content_post ) ) : 

		$pre_title_content = apply_filters( 'hootdu_theme_pre_title_content', '', $location, $context );
		if ( !empty( $pre_title_content ) ) :

			$pre_title_content_stretch =  apply_filters( 'hootdu_theme_pre_title_content_stretch', '', $location, $context ); ?>
			<div id="custom-content-title-area" class="<?php
				echo sanitize_html_class( $location . '-content-title-area ' );
				echo ( ($pre_title_content_stretch) ? 'content-title-area-stretch' : 'content-title-area-grid' );
				?>">
				<div class="<?php echo ( ($pre_title_content_stretch) ? 'hgrid-stretch' : 'hgrid' ); ?>">
					<div class="hgrid-span-12">
						<?php echo wp_kses_post( do_shortcode( $pre_title_content ) ); ?>
					</div>
				</div>
			</div>
			<?php

		endif;

	endif;
}
endif;

/**
 * Return the display array of meta blocks to show
 *
 * @since 1.0
 * @access public
 * @param array|string $args    (comma delimited) information to display
 * @param string       $context context in which meta blocks are being displayed
 * @param bool         $bool    Return bool value
 * @return array|bool
 */
if ( !function_exists( 'hootdu_theme_meta_info' ) ):
function hootdu_theme_meta_info( $args = '', $context = '', $bool = false ) {

	if ( !is_array( $args ) )
		$args = array_map( 'trim', explode( ',', $args ) );

	$display = array();
	foreach ( array( 'author', 'date', 'cats', 'tags', 'comments' ) as $key ) {
		if ( in_array( $key, $args ) )
			$display[ $key ] = true;
	}

	// if ( is_page() ) { : returns true in post loop when frontpage set as static page
	if ( get_post_type() == ' post' ) {
		if ( isset( $display['cats'] ) ) unset( $display['cats'] );
		if ( isset( $display['tags'] ) ) unset( $display['tags'] );
	}

	if ( !empty( $display['author'] ) )
		$display['publisher'] = true;

	$display = apply_filters( 'hootdu_theme_meta_info', $display, $context );

	if ( $bool ) {
		if ( empty( $display ) ) return false; else return true;
	} else {
		return $display;
	}

}
endif;

/**
 * Display the meta information HTML for single post/page
 *
 * @since 1.0
 * @access public
 * @param array|string $args     (comma delimited) information to display
 * @param string       $context  context in which meta blocks are being displayed
 * @param bool         $editlink display Edit link
 * @return void
 */
if ( !function_exists( 'hootdu_theme_display_meta_info' ) ):
function hootdu_theme_display_meta_info( $args = '', $context = '', $editlink = true ) {

	if ( !is_array( $args ) )
		$args = array_map( 'trim', explode( ',', $args ) );

	$display = hootdu_theme_meta_info( $args, $context );

	if ( empty( $display ) ) {
		echo '<div class="entry-byline empty"></div>';
		return;
	}

	$blocks = array();

	if ( !empty( $display['author'] ) ) :
		$blocks['author']['label'] = __( 'By:', 'hoot-du' );
		ob_start();
		the_author_posts_link();
		$blocks['author']['content'] = '<span ' . hootdu_get_attr( 'entry-author' ) . '>' . ob_get_clean() . '</span>';
	endif;

	if ( !empty( $display['date'] ) ) :
		$blocks['date']['label'] = __( 'On:', 'hoot-du' );
		$blocks['date']['content'] = '<time ' . hootdu_get_attr( 'entry-published' ) . '>' . get_the_date() . '</time>';
	endif;

	if ( !empty( $display['cats'] ) ) :
		$category_list = get_the_category_list(', ');
		if ( !empty( $category_list ) ) :
			$blocks['cats']['label'] = __( 'In:', 'hoot-du' );
			$blocks['cats']['content'] = $category_list;
		endif;
	endif;

	if ( !empty( $display['tags'] ) && get_the_tags() ) :
		$blocks['tags']['label'] = __( 'Tagged:', 'hoot-du' );
		$blocks['tags']['content'] = ( ! get_the_tags() ) ? __( 'No Tags', 'hoot-du' ) : get_the_tag_list( '', ', ', '' );
	endif;

	if ( !empty( $display['comments'] ) && comments_open() ) :
		$blocks['comments']['label'] = __( 'With:', 'hoot-du' );
		ob_start();
		comments_popup_link(__( '0 Comments', 'hoot-du' ),
							__( '1 Comment', 'hoot-du' ),
							__( '% Comments', 'hoot-du' ), 'comments-link', '' );
		$blocks['comments']['content'] = ob_get_clean();
	endif;

	if ( $editlink && $edit_link = get_edit_post_link() ) :
		$blocks['editlink']['label'] = '';
		$blocks['editlink']['content'] = '<a href="' . $edit_link . '">' . __( 'Edit This', 'hoot-du' ) . '</a>';
	endif;

	$blocks = apply_filters( 'hootdu_theme_display_meta_info', $blocks, $context, $display, $editlink );

	if ( !empty( $blocks ) )
		echo '<div class="entry-byline">';

	foreach ( $blocks as $key => $block ) {
		if ( !empty( $block['content'] ) ) {
			echo ' <div class="entry-byline-block entry-byline-' . sanitize_html_class( $key ) . '">';
				if ( !empty( $block['label'] ) )
					echo ' <span class="entry-byline-label">' . esc_html( $block['label'] ) . '</span> ';
				echo wp_kses( $block['content'], hootdu_data( 'hootallowedtags' ) );
			echo ' </div>';
		}
	}

	if ( !empty( $display['publisher'] ) ) {
		static $microdatapublisher;
		if ( empty( $microdatapublisher ) ) {
			$pname = get_bloginfo();
			if ( function_exists( 'get_custom_logo' ) ) {
				$iid = intval( get_theme_mod( 'custom_logo' ) );
				if ( !empty( $iid ) ) {
					$isrc = wp_get_attachment_image_src( $iid, 'full' );
					if( empty( $isrc ) ) $isrc = wp_get_attachment_image_src( $iid, 'full', true );
					if ( !empty( $isrc[0] ) ) {
						$ilogo = $isrc[0];
						$iwidth = ( empty( $isrc[1] ) ) ? '' : $isrc[1];
						$iheight = ( empty( $isrc[2] ) ) ? '' : $isrc[2];
					}
				}
			}
			if ( empty( $ilogo ) )
				$ilogo = $iwidth = $iheight = '';
			$microdatapublisher = wp_kses( apply_filters( 'hootdu_theme_entry_byline_publisher',
				'<span class="entry-publisher" itemprop="publisher" itemscope="itemscope" itemtype="https://schema.org/Organization">' .
					'<meta itemprop="name" content="' . $pname . '">' .
					'<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">' .
						'<meta itemprop="url" content="' . $ilogo . '">' .
						'<meta itemprop="width" content="' . $iwidth . '">' .
						'<meta itemprop="height" content="' . $iheight . '">' .
					'</span>' .
				'</span>' ), hootdu_data( 'hootallowedtags' ) );
		}
		echo $microdatapublisher;
	}

	if ( !empty( $blocks ) )
		echo '</div><!-- .entry-byline -->';

}
endif;

/**
 * Force meta info block display
 * @NU
 *
 * @since 1.0
 * @access public
 * @param array  $display
 * @param string $context
 * @return array
 */
if ( !function_exists( 'hootdu_theme_display_meta_info_forcedisplay' ) ):
function hootdu_theme_display_meta_info_forcedisplay( $display, $context ) {
	if ( empty( $context ) ) return $display;
	if ( !is_array( $context ) )
		$context = array_map( 'trim', explode( ',', $context ) );
	foreach ( $context as $key )
		$display[ $key ] = true;
	return $display;
}
endif;
// add_filter( 'hootdu_theme_meta_info', 'hootdu_theme_display_meta_info_forcedisplay', 5, 2 );

/**
 * Display 404 content
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_display_404_content' ) ):
function hootdu_theme_display_404_content() {
	echo esc_html( __( 'Apologies, but no entries were found.', 'hoot-du' ) );
}
endif;
add_action( 'hootdu_theme_404_content', 'hootdu_theme_display_404_content', 5 );

/**
 * Calculate size and display the post thumbnail image
 * (along with proper image microdata)
 *
 * @since 1.0
 * @access public
 * @param string $classes    additional classes
 * @param string $size       span or column size or actual image size name. Default is content width span.
 * @param bool   $miscrodata true|false Add microdata or not
 * @param string $link       image link url
 * @param bool   $crop       true|false|null Using null will return closest matched image irrespective of its crop setting
 * @return void
 */
if ( !function_exists( 'hootdu_theme_post_thumbnail' ) ):
function hootdu_theme_post_thumbnail( $classes = '', $size = '', $microdata = false, $link = '', $crop = NULL ) {

	if ( has_post_thumbnail() ) :

		/* Add custom Classes if any */
		$custom_class = ( !empty( $classes ) ) ? hootdu_sanitize_html_classes( $classes ) : '';

		/* Calculate the size to display */
		$thumbnail_size = hootdu_theme_thumbnail_size( $size, $crop );

		/* Finally display the image */
		if ( $microdata ) {
			$iid = get_post_thumbnail_id();
			if ( !empty( $iid ) ) {
				$isrc = wp_get_attachment_image_src( $iid, $thumbnail_size );
				if( empty( $isrc ) ) $isrc = wp_get_attachment_image_src( $iid, $thumbnail_size, true );
				if ( !empty( $isrc[0] ) ) {
					$iwidth = ( empty( $isrc[1] ) ) ? '' : $isrc[1];
					$iheight = ( empty( $isrc[2] ) ) ? '' : $isrc[2];
					echo wp_kses( apply_filters( 'hootdu_theme_post_thumbnail_microdata',
						'<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject" class="entry-featured-img-wrap">' .
						'<meta itemprop="url" content="' . $isrc[0] . '">' .
						'<meta itemprop="width" content="' . $iwidth . '">' .
						'<meta itemprop="height" content="' . $iheight . '">'
						, $isrc[0], $iwidth, $iheight ), hootdu_data( 'hootallowedtags' ) );
					$microdatadisplay = true;
				}
			}
		}
		if ( empty( $microdatadisplay ) )
			echo '<div class="entry-featured-img-wrap">';
		if ( !empty( $link ) ) echo '<a href="' . esc_url( $link ) . '" ' . hootdu_get_attr( 'entry-featured-img-link' ) . '>';
		the_post_thumbnail( $thumbnail_size, array( 'class' => "attachment-$thumbnail_size $custom_class", 'itemscope' => '' ) );
		if ( !empty( $link ) ) echo '</a>';
		echo '</div>';

	endif;

}
endif;

/**
 * Get the thumbnail size based on column span
 * This function is sort of a wrapper for 'hootdu_get_image_size_name' in context of theme layout
 *
 * @since 1.0
 * @access public
 * @param string $size span or column size or actual image size name. Default is content width span.
 * @param bool   $crop true|false|null Using null will return closest matched image irrespective of its crop setting
 * @return string
 */
if ( !function_exists( 'hootdu_theme_thumbnail_size' ) ):
function hootdu_theme_thumbnail_size( $size = '', $crop = NULL ) {

	/* Calculate the size to display */
	if ( !empty( $size ) ) {
		if ( 0 === strpos( $size, 'span-' ) || 0 === strpos( $size, 'column-' ) )
			$thumbnail_size = hootdu_get_image_size_name( $size, $crop );
		else
			$thumbnail_size = $size;
	} else {
		$size = 'span-' . hootdu_theme_layout( 'content' );
		$thumbnail_size = hootdu_get_image_size_name( $size, $crop );
	}

	/* Let child themes filter the size name */
	$thumbnail_size = apply_filters( 'hootdu_theme_post_thumbnail_size' , $thumbnail_size, $size, $crop );

	return $thumbnail_size;
}
endif;

/**
 * Utility function to map footer sidebars structure to CSS span architecture.
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_footer_structure' ) ):
function hootdu_theme_footer_structure() {
	$footers = hootdu_get_mod( 'footer' );
	$structure = array(
				'1-1' => array( 12, 12, 12, 12 ),
				'2-1' => array(  6,  6, 12, 12 ),
				'2-2' => array(  4,  8, 12, 12 ),
				'2-3' => array(  8,  4, 12, 12 ),
				'3-1' => array(  4,  4,  4, 12 ),
				'3-2' => array(  6,  3,  3, 12 ),
				'3-3' => array(  3,  6,  3, 12 ),
				'3-4' => array(  3,  3,  6, 12 ),
				'4-1' => array(  3,  3,  3,  3 ),
				);
	if ( isset( $structure[ $footers ] ) )
		return $structure[ $footers ];
	else
		return array( 12, 12, 12, 12 );
}
endif;

/**
 * Get footer column option.
 *
 * @since 1.0
 * @access public
 * @return int
 */
function hootdu_theme_get_footer_columns() {
	$footers = hootdu_get_mod( 'footer' );
	$columns = ( $footers ) ? intval( substr( $footers, 0, 1 ) ) : false;
	$columns = ( is_numeric( $columns ) && 0 < $columns ) ? $columns : false;
	return $columns;
}

/**
 * Utility function to map 2 column widths to CSS span architecture.
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_get_column_span' ) ):
function hootdu_theme_get_column_span( $col_width ) {
	$return = array();
	switch( $col_width ):
		case '100':
			$return[0] = 'hgrid-span-12';
			break;
		case '50-50': default:
			$return[0] = 'hgrid-span-6';
			$return[1] = 'hgrid-span-6';
			break;
		case '33-66':
			$return[0] = 'hgrid-span-4';
			$return[1] = 'hgrid-span-8';
			break;
		case '66-33':
			$return[0] = 'hgrid-span-8';
			$return[1] = 'hgrid-span-4';
			break;
		case '25-75':
			$return[0] = 'hgrid-span-3';
			$return[1] = 'hgrid-span-9';
			break;
		case '75-25':
			$return[0] = 'hgrid-span-9';
			$return[1] = 'hgrid-span-3';
			break;
		case '33-33-33':
			$return[0] = 'hgrid-span-4';
			$return[1] = 'hgrid-span-4';
			$return[2] = 'hgrid-span-4';
			break;
		case '25-25-50':
			$return[0] = 'hgrid-span-3';
			$return[1] = 'hgrid-span-3';
			$return[2] = 'hgrid-span-6';
			break;
		case '25-50-25':
			$return[0] = 'hgrid-span-3';
			$return[1] = 'hgrid-span-6';
			$return[2] = 'hgrid-span-3';
			break;
		case '50-25-25':
			$return[0] = 'hgrid-span-6';
			$return[1] = 'hgrid-span-3';
			$return[2] = 'hgrid-span-3';
			break;
		case '25-25-25-25':
			$return[0] = 'hgrid-span-3';
			$return[1] = 'hgrid-span-3';
			$return[2] = 'hgrid-span-3';
			$return[3] = 'hgrid-span-3';
			break;
	endswitch;
	return $return;
}
endif;

/**
 * Wrapper function for hootdu_theme_layout() to get the class names for current context.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 * @param string $context content|primary-sidebar|sidebar|sidebar-primary
 * @return string
 */
if ( !function_exists( 'hootdu_theme_layout_class' ) ):
function hootdu_theme_layout_class( $context ) {
	return hootdu_theme_layout( $context, 'class' );
}
endif;

/**
 * Utility function to return layout size or classes for the context.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 * @param string $context content|primary-sidebar|sidebar|sidebar-primary
 * @param string $return  class|size return class name or just the span size integer
 * @return string
 */
if ( !function_exists( 'hootdu_theme_layout' ) ):
function hootdu_theme_layout( $context, $return = 'size' ) {

	// Set layout if not already set
	$layout = hootdu_data( 'currentlayout' );
	if ( empty( $layout ) )
		hootdu_theme_set_layout();

	// Get layout
	$layout = hootdu_data( 'currentlayout' );
	$span_sidebar = $layout['sidebar'];
	$span_content = $layout['content'];
	$layout_class = ' layout-' . $layout['layout'];

	// Return Class or Span Size for the Content/Sidebar
	if ( $context == 'content' ) {

		if ( $return == 'class' ) {
			$extra_class = ( empty( $span_sidebar ) ) ? ' no-sidebar' : ' has-sidebar';
			return ' hgrid-span-' . $span_content . $extra_class . $layout_class . ' ';
		} elseif ( $return == 'size' ) {
			return intval( $span_content );
		}

	} elseif ( $context == 'sidebar' ||  $context == 'sidebar-primary' || $context == 'primary-sidebar' || $context == 'secondary-sidebar' || $context == 'sidebar-secondary' ) {

		if ( $return == 'class' ) {
			if ( !empty( $span_sidebar ) )
				return ' hgrid-span-' . $span_sidebar . $layout_class . ' ';
			else
				return '';
		} elseif ( $return == 'size' ) {
			return intval( $span_sidebar );
		}

	}

	return '';

}
endif;

/**
 * Utility function to calculate and set main (content+aside) layout according to the sidebar layout
 * set by user for the current view.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_theme_set_layout' ) ):
function hootdu_theme_set_layout() {

	// Apply full width for front page
	if ( is_front_page() && !is_home() ) {
		$sidebar = 'full-width';
	}
	// Apply Sidebar Layout for Posts
	elseif ( is_singular( 'post' ) ) {
		$sidebar = hootdu_get_mod( 'sidebar_posts' );
	}
	// Check for attachment before page (to handle images attached to a page - true for is_page and is_attachment)
	// Apply 'Full Width'
	elseif ( is_attachment() ) {
		$sidebar = 'none';
	}
	// Apply Sidebar Layout for Pages
	elseif ( is_page() ) {
		$sidebar = hootdu_get_mod( 'sidebar_pages' );
	}
	// Apply No Sidebar Layout for 404
	elseif ( is_404() ) {
		$sidebar = 'none';
	}
	// Apply Sidebar Layout for Site
	else {
		$sidebar = hootdu_get_mod( 'sidebar' );
	}

	// Allow for custom manipulation of the layout by child themes
	$sidebar = esc_attr( apply_filters( 'hootdu_theme_layout', $sidebar ) );

	// Save the layout for current view
	hootdu_theme_set_layout_span( $sidebar );

}
endif;

/**
 * Utility function to calculate and set main (content+aside) layout according to the sidebar layout
 * set by user for the current view.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_theme_set_layout_span' ) ):
function hootdu_theme_set_layout_span( $sidebar ) {
	$spans = apply_filters( 'hootdu_theme_layout_spans', array(
		'none' => array(
			'content' => 9,
			'sidebar' => 0,
		),
		'full' => array(
			'content' => 12,
			'sidebar' => 0,
		),
		'full-width' => array(
			'content' => 12,
			'sidebar' => 0,
		),
		'narrow-right' => array(
			'content' => 9,
			'sidebar' => 3,
		),
		'wide-right' => array(
			'content' => 8,
			'sidebar' => 4,
		),
		'narrow-left' => array(
			'content' => 9,
			'sidebar' => 3,
		),
		'wide-left' => array(
			'content' => 8,
			'sidebar' => 4,
		),
		'narrow-left-left' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-left-right' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-right-left' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-right-right' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'default' => array(
			'content' => 8,
			'sidebar' => 4,
		),
	) );

	/* Set the layout for current view */
	$currentlayout['layout'] = $sidebar;
	if ( isset( $spans[ $sidebar ] ) ) {
		$currentlayout['content'] = $spans[ $sidebar ]['content'];
		$currentlayout['sidebar'] = $spans[ $sidebar ]['sidebar'];
	} else {
		$currentlayout['content'] = $spans['default']['content'];
		$currentlayout['sidebar'] = $spans['default']['sidebar'];
	}
	hootdu_set_data( 'currentlayout', $currentlayout );

}
endif;

/**
 * Utility function to determine the location of page header
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_theme_titlearea_top' ) ):
function hootdu_theme_titlearea_top() {

	$full = array_map( 'trim', explode( ',', hootdu_get_mod( 'page_header_full' ) ) );

	/* Override For Full Width Pages (including 404 page) */
	if ( in_array( 'no-sidebar', $full ) ) {
		$sidebar_size = hootdu_theme_layout( 'primary-sidebar' );
		if ( empty( $sidebar_size ) )
			return apply_filters( 'hootdu_theme_titlearea_top', true, 'no-sidebar', $full );
	}

	/* For Posts */
	if ( is_singular( 'post' ) ) {
		if ( in_array( 'posts', $full ) )
			return apply_filters( 'hootdu_theme_titlearea_top', true, 'posts', $full );
		else
			return apply_filters( 'hootdu_theme_titlearea_top', false, 'posts', $full );
	}

	/* For Pages */
	if ( is_page() ) {
		if ( in_array( 'pages', $full ) )
			return apply_filters( 'hootdu_theme_titlearea_top', true, 'pages', $full );
		else
			return apply_filters( 'hootdu_theme_titlearea_top', false, 'pages', $full );
	}

	/* Default */
	if ( in_array( 'default', $full ) )
		return apply_filters( 'hootdu_theme_titlearea_top', true, 'default', $full );
	else
		return apply_filters( 'hootdu_theme_titlearea_top', false, 'default', $full );

}
endif;

/**
 * Utility function to display featured image in loop meta header
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_theme_loopmeta_header_img' ) ):
function hootdu_theme_loopmeta_header_img( $context, $display ) {
	$context = sanitize_html_class( $context );
	$location = ( $context == 'post' ) ? hootdu_get_mod( 'post_featured_image' ) : hootdu_get_mod( 'post_featured_image_page' );

	$view_id = $img_id = 0;

	if ( is_singular() ) {
		$view_id = null;
	} elseif ( is_home() && !is_front_page() ) {
		$view_id = get_option( 'page_for_posts' );
	} elseif ( current_theme_supports( 'woocommerce' ) ) {
		if ( is_shop() ) {
			$view_id = get_option( 'woocommerce_shop_page_id' );
		} elseif ( is_product_category() ) {
			global $wp_query;
			$cat = $wp_query->get_queried_object();
			$img_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		}
	}

	$img_id = ( $view_id !== 0 && has_post_thumbnail( $view_id ) ) ? get_post_thumbnail_id( $view_id ) : $img_id;
	$img_id = apply_filters( 'hootdu_theme_loopmeta_header_img_id', $img_id, $context, $location, $view_id );
	$img_id = absint( $img_id );

	if ( $location == 'header' && !empty( $img_id ) ) {
		$img_src = wp_get_attachment_image_src( $img_id, apply_filters( "hootdu_theme_{$context}_imgsize", 'full', 'header' ) );
		if ( !empty( $img_src[0] ) ) {
			$wrap_attr = array(
				'data-parallax' => 'scroll',
				'data-image-src' => esc_url( $img_src[0] ),
			);
			if ( $display )
				echo '<div ' . hootdu_get_attr( 'entry-featured-img-headerwrap', '', $wrap_attr ) . '></div>';
			else
				hootdu_set_data( 'loop-meta-wrap', $wrap_attr );
		}
	}
}
endif;

/**
 * Display function to render posts for Jetpack's infinite scroll module
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_theme_jetpack_infinitescroll_render' ) ):
function hootdu_theme_jetpack_infinitescroll_render(){
	while ( have_posts() ) : the_post();
		// Loads the template-parts/content-{$post_type}.php template.
		hootdu_get_content_template();
	endwhile;
}
endif;