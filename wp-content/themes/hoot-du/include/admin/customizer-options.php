<?php
/**
 * Defines customizer options
 *
 * This file is loaded at 'after_setup_theme' hook with 10 priority.
 *
 * @package    Hoot Du
 * @subpackage Theme
 */

/**
 * Theme default colors and fonts
 *
 * @since 1.0
 * @access public
 * @param string $key return a specific key value, else the entire defaults array
 * @return array|string
 */
if ( !function_exists( 'hootdu_theme_default_style' ) ) :
function hootdu_theme_default_style( $key = false ){

	// Do not use static cache variable as any reference to 'hootdu_theme_default_style()'
	// (example: get default value during declaring add_theme_support for WP custom background which
	// is also loaded at 'after_setup_theme' hook with 10 priority) will prevent further applying
	// of filter hook (by child-theme/plugin/premium). Ideally, this function should be called only
	// after 'after_setup_theme' hook with 11 priority
	$defaults = apply_filters( 'hootdu_theme_default_style', array(
		'accent_color'         => '#f85658',
		'accent_font'          => '#ffffff',
		// 'contrast_color'       => '#222222',
		'contrast_font'        => '#ffffff',
		'highlight_color'      => '#f5f5f5',
		// 'highlight_dark'       => '#3e3e3e',
		'box_background'       => '#ffffff',
		'site_background'      => '#222222', // Used by WP custom-background
	) );

	if ( $key )
		return ( isset( $defaults[ $key ] ) ) ? $defaults[ $key ] : false;
	else
		return $defaults;
}
endif;

/**
 * Build the Customizer options (panels, sections, settings)
 *
 * Always remember to mention specific priority for non-static options like:
 *     - options being added based on a condition (eg: if woocommerce is active)
 *     - options which may get removed (eg: logo_size, headings_fontface)
 *     - options which may get rearranged (eg: logo_background_type)
 *     This will allow other options inserted with priority to be inserted at
 *     their intended place.
 *
 * @since 1.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hootdu_theme_customizer_options' ) ) :
function hootdu_theme_customizer_options() {

	// Stores all the settings to be added
	$settings = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Theme default colors and fonts
	extract( hootdu_theme_default_style() );

	// Directory path for radioimage buttons
	$imagepath =  hootdu_data()->incuri . 'admin/images/';

	// Logo Sizes (different range than standard typography range)
	$logosizes = array();
	$logosizerange = range( 14, 110 );
	foreach ( $logosizerange as $isr )
		$logosizes[ $isr . 'px' ] = $isr . 'px';
	$logosizes = apply_filters( 'hootdu_theme_options_logosizes', $logosizes);

	// Logo Font Options for Lite version
	$logofont = apply_filters( 'hootdu_theme_options_logofont', array(
					'heading'  => __( "Logo Font (set in 'Typography' section)", 'hoot-du' ),
					'heading2' => __( "Heading Font (set in 'Typography' section)", 'hoot-du' ),
					'standard' => __( "Standard Body Font", 'hoot-du' ),
					) );

	/*** Add Options (Panels, Sections, Settings) ***/

	/** Section **/

	$section = 'links';

	$sections[ $section ] = array(
		'title'       => __( 'Demo / Support', 'hoot-du' ),
		'priority'    => '2',
	);

	$lcontent = '';
	$lcontent .= '<a class="hootdu-cust-link" href="' .
				 'https://demo.wphoot.com/hoot-du/' .
				 '" target="_blank"><span class="hootdu-cust-link-head">' .
				 '<i class="fas fa-eye"></i> ' .
				 __( "Demo", 'hoot-du') . 
				 '</span><span class="hootdu-cust-link-desc">' .
				 __( "Demo the theme features and options with sample content.", 'hoot-du') .
				 '</span></a>';
	$lcontent .= '<a class="hootdu-cust-link" href="' .
				 'https://wphoot.com/support/' .
				 '" target="_blank"><span class="hootdu-cust-link-head">' .
				 '<i class="far fa-life-ring"></i> ' .
				 __( "Documentation / Support", 'hoot-du') . 
				 '</span><span class="hootdu-cust-link-desc">' .
				 __( "Get theme related support for both free and premium users.", 'hoot-du') .
				 '</span></a>';
	$lcontent .= '<a class="hootdu-cust-link" href="' .
				 'https://wordpress.org/support/theme/hoot-du/reviews/?filter=5#new-post' .
				 '" target="_blank"><span class="hootdu-cust-link-head">' .
				 '<i class="fas fa-star"></i> ' .
				 __( "Rate Us", 'hoot-du') . 
				 '</span><span class="hootdu-cust-link-desc">' .
				 /* translators: five stars */
				 sprintf( __( "If you are happy with the theme, please give us a %s rating on wordpress.org. Thanks in advance!", 'hoot-du'), '<span style="color:#0073aa;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>' ) .
				 '</span></a>';

	$settings['linksection'] = array(
		// 'label'       => __( 'Misc Links', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'content',
		'priority'    => '8', // Non static options must have a priority
		'content'     => $lcontent,
	);

	/** Section **/

	$section = 'title_tagline';

	$sections[ $section ] = array(
		'title'       => __( 'Setup &amp; Layout', 'hoot-du' ),
	);

	$settings['site_layout'] = array(
		'label'       => __( 'Site Layout - Boxed vs Stretched', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'boxed'   => __( 'Boxed layout', 'hoot-du' ),
			'stretch' => __( 'Stretched layout (full width)', 'hoot-du' ),
		),
		'default'     => 'stretch',
	);

	$settings['site_width'] = array(
		'label'       => __( 'Max. Site Width (pixels)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'1380' => __( '1380px (wide)', 'hoot-du' ),
			'1260' => __( '1260px (normal)', 'hoot-du' ),
			'1080' => __( '1080px (compact)', 'hoot-du' ),
		),
		'default'     => '1380',
	);

	$settings['load_minified'] = array(
		'label'       => __( 'Load Minified Styles and Scripts (when available)', 'hoot-du' ),
		'sublabel'    => __( 'Checking this option reduces data size, hence increasing page load speed.', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		// 'default'     => 1,
	);

	$settings['sidebar'] = array(
		'label'       => __( 'Sidebar Layout (Site-wide)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
			'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
			'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
		'description' => __( 'Set the default sidebar width and position for your site.', 'hoot-du' ),
	);

	$settings['sidebar_pages'] = array(
		'label'       => __( 'Sidebar Layout (for Pages)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
			'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
			'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
	);

	$settings['sidebar_posts'] = array(
		'label'       => __( 'Sidebar Layout (for single Posts)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
			'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
			'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
	);

	$settings['disable_sticky_sidebar'] = array(
		'label'       => __( 'Disable Sticky Sidebar', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'description' => __( 'Check this if you do not want to display a fixed Sidebar the user scrolls down the page.', 'hoot-du' ),
	);

	$settings['widgetmargin'] = array(
		'label'       => __( 'Widget Margin', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'text',
		'default'     => 45,
		'description' => __( '(in pixels) Margin space above and below widgets. Leave empty if you dont want to change the default.', 'hoot-du' ),
		'input_attrs' => array(
			'placeholder' => __( 'default: 45', 'hoot-du' ),
		),
	);

	/** Section **/

	$section = 'header';

	$sections[ $section ] = array(
		'title'       => __( 'Header', 'hoot-du' ),
	);

	$settings['primary_menuarea'] = array(
		'label'       => __( 'Header Area (right of logo)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'menu'        => __( 'Display Menu', 'hoot-du' ),
			'search'      => __( 'Display Search', 'hoot-du' ),
			'custom'      => __( 'Custom Text', 'hoot-du' ),
			'widget-area' => __( "'Header Side' widget area", 'hoot-du' ),
			'none'        => __( 'None (Logo will get centre aligned)', 'hoot-du' ),
		),
		'default'     => 'widget-area',
	);

	$settings['primary_menuarea_custom'] = array(
		'label'             => __( 'Custom Text instead of Menu', 'hoot-du' ),
		'section'           => $section,
		'type'              => 'textarea',
		'description'       => __( 'You can use this area to display ads or custom text.', 'hoot-du' ),
		'active_callback'   => 'hootdu_theme_callback_show_primary_menuarea_custom',
	);
	// Allow users to add javascript in case they need to use this area to insert code for ads
	// etc. To enable this, add the following code in your child theme's functions.php file (without
	// the '//'). This code is already included in premium version.
	//     add_filter( 'hootdu_theme_primary_menuarea_custom_allowscript', 'hootdu_child_textarea_allowscript' );
	//     function hootdu_child_textarea_allowscript(){ return true; }
	if ( apply_filters( 'hootdu_theme_primary_menuarea_custom_allowscript', true ) )
		$settings['primary_menuarea_custom']['sanitize_callback'] = 'hootdu_theme_sanitize_textarea_allowscript';

	$settings['secondary_menu_location'] = array(
		'label'       => __( 'Full Width Menu Area (location)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'top'        => __( 'Top (above logo)', 'hoot-du' ),
			'bottom'     => __( 'Bottom (below logo)', 'hoot-du' ),
			'none'       => __( "Do not display full width menu (useful if you already have 'menu' selected in 'Header Area' above')", 'hoot-du' ),
		),
		'default'     => 'bottom',
	);

	$settings['secondary_menu_align'] = array(
		'label'       => __( 'Full Width Menu Area (alignment)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'left'      => __( 'Left', 'hoot-du' ),
			'right'     => __( 'Right', 'hoot-du' ),
			'center'    => __( 'Center', 'hoot-du' ),
		),
		'default'     => 'left',
	);

	$settings['disable_table_menu'] = array(
		'label'       => __( 'Disable Table Menu', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		// 'default'     => 1,
		'description' => "<img src='{$imagepath}menu-table.png'><br/>" . __( 'Disable Table Menu if you have a lot of Top Level menu items, <strong>and dont have menu item descriptions.</strong>', 'hoot-du' ),
	);

	$settings['mobile_menu'] = array(
		'label'       => __( 'Mobile Menu', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'inline' => __( 'Inline - Menu Slide Downs to open', 'hoot-du' ),
			'fixed'  => __( 'Fixed - Menu opens on the left', 'hoot-du' ),
		),
		'default'     => 'fixed',
	);

	$settings['mobile_submenu_click'] = array(
		'label'       => __( "[Mobile Menu] Submenu opens on 'Click'", 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
		'description' => __( "Uncheck this option to make all Submenus appear in 'Open' state. By default, submenus open on clicking (i.e. single tap on mobile).", 'hoot-du' ),
	);

	/** Section **/

	$section = 'logo';

	$sections[ $section ] = array(
		'title'       => __( 'Logo', 'hoot-du' ),
	);

	$settings['logo_background_type'] = array(
		'label'       => __( 'Logo Background', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'priority'    => '155', // Non static options must have a priority
		'choices'     => array(
			'transparent' => __( 'None', 'hoot-du' ),
			'accent'      => __( 'Accent Color', 'hoot-du' ),
		),
		'default'     => 'transparent',
	); // Overridden in premium

	$settings['logo'] = array(
		'label'       => __( 'Site Logo', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'text'        => __( 'Default Text (Site Title)', 'hoot-du' ),
			'custom'      => __( 'Custom Text', 'hoot-du' ),
			'image'       => __( 'Image Logo', 'hoot-du' ),
			'mixed'       => __( 'Image &amp; Default Text (Site Title)', 'hoot-du' ),
			'mixedcustom' => __( 'Image &amp; Custom Text', 'hoot-du' ),
		),
		'default'     => 'text',
		/* Translators: 1 is the link start markup, 2 is link markup end */
		'description' => sprintf( __( 'Use %1$sSite Title%2$s as default text logo', 'hoot-du' ), '<a href="' . esc_url( admin_url('options-general.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['logo_size'] = array(
		'label'       => __( 'Logo Text Size', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => '165', // Non static options must have a priority
		'choices'     => array(
			'tiny'   => __( 'Tiny', 'hoot-du'),
			'small'  => __( 'Small', 'hoot-du'),
			'medium' => __( 'Medium', 'hoot-du'),
			'large'  => __( 'Large', 'hoot-du'),
			'huge'   => __( 'Huge', 'hoot-du'),
		),
		'default'     => 'medium',
		'active_callback' => 'hootdu_theme_callback_logo_size',
	);

	$settings['site_title_icon'] = array(
		'label'           => __( 'Site Title Icon (Optional)', 'hoot-du' ),
		'section'         => $section,
		'type'            => 'icon',
		// 'default'         => 'fa-anchor fas',
		'description'     => __( 'Leave empty to hide icon.', 'hoot-du' ),
		'active_callback' => 'hootdu_theme_callback_site_title_icon',
	);

	$settings['site_title_icon_size'] = array(
		'label'           => __( 'Site Title Icon Size', 'hoot-du' ),
		'section'         => $section,
		'type'            => 'select',
		'choices'         => $logosizes,
		'default'         => '50px',
		'active_callback' => 'hootdu_theme_callback_site_title_icon',
	);

	$settings['logo_image_width'] = array(
		'label'           => __( 'Maximum Logo Width', 'hoot-du' ),
		'section'         => $section,
		'type'            => 'text',
		'priority'        => '186', // Keep it with logo image ( 'custom_logo' )->priority logo
		'default'         => 200,
		'description'     => __( '(in pixels)<hr>The logo width may be automatically adjusted by the browser depending on title length and space available.', 'hoot-du' ),
		'input_attrs'     => array(
			'placeholder' => __( '(in pixels)', 'hoot-du' ),
		),
		'active_callback' => 'hootdu_theme_callback_logo_image_width',
	);

	$logo_custom_line_options = array(
		'text' => array(
			'label'       => __( 'Line Text', 'hoot-du' ),
			'type'        => 'text',
		),
		'size' => array(
			'label'       => __( 'Line Size', 'hoot-du' ),
			'type'        => 'select',
			'choices'     => $logosizes,
			'default'     => '24px',
		),
		'font' => array(
			'label'       => __( 'Line Font', 'hoot-du' ),
			'type'        => 'select',
			'choices'     => $logofont,
			'default'     => 'heading',
		),
	);

	$settings['logo_custom'] = array(
		'label'           => __( 'Custom Logo Text', 'hoot-du' ),
		'section'         => $section,
		'type'            => 'sortlist',
		'description'     => __( "Use &lt;b&gt; and &lt;em&gt; tags in 'Line Text' fields below to emphasize different words. Example:<br /><code>&lt;b&gt;Hoot&lt;/b&gt; &lt;em&gt;Du&lt;/em&gt;</code>", 'hoot-du' ),
		'choices'         => array(
			'line1' => __( 'Line 1', 'hoot-du' ),
			'line2' => __( 'Line 2', 'hoot-du' ),
			'line3' => __( 'Line 3', 'hoot-du' ),
			'line4' => __( 'Line 4', 'hoot-du' ),
		),
		'default'     => array(
			'line3'  => array( 'sortitem_hide' => 1, ),
			'line4'  => array( 'sortitem_hide' => 1, ),
		),
		'options'         => array(
			'line1' => $logo_custom_line_options,
			'line2' => $logo_custom_line_options,
			'line3' => $logo_custom_line_options,
			'line4' => $logo_custom_line_options,
		),
		'attributes'      => array(
			'hideable'   => true,
			'sortable'   => false,
			// 'open-state' => 'first',
		),
		'active_callback' => 'hootdu_theme_callback_logo_custom',
	);

	$settings['show_tagline'] = array(
		'label'           => __( 'Show Tagline', 'hoot-du' ),
		'sublabel'        => __( 'Display site description as tagline below logo.', 'hoot-du' ),
		'section'         => $section,
		'type'            => 'checkbox',
		'default'         => 1,
		// 'active_callback' => 'hootdu_theme_callback_show_tagline',
	);

	/** Section **/

	$section = 'colors';

	// Redundant as 'colors' section is added by WP. But we still add it for brevity
	$sections[ $section ] = array(
		'title'       => __( 'Colors', 'hoot-du' ),
	);

	$settings['contrast_font'] = array(
		'label'       => __( 'Font Color on Contrast Color', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'color',
		'priority'    => '205', // Non static options must have a priority
		'default'     => $contrast_font,
	); // Overridden in premium

	$settings['box_background_color'] = array(
		'label'       => __( 'Site Content Background', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'color',
		'priority'    => '205', // Non static options must have a priority
		'default'     => $box_background,
	); // Overridden in premium

	$settings['accent_color'] = array(
		'label'       => __( 'Accent Color', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $accent_color,
	);

	$settings['accent_font'] = array(
		'label'       => __( 'Font Color on Accent Color', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $accent_font,
	);

	if ( current_theme_supports( 'woocommerce' ) ) :
		$settings['woocommerce-colors-plugin'] = array(
			'label'       => __( 'Woocommerce Styling', 'hoot-du' ),
			'section'     => $section,
			'type'        => 'content',
			'priority'    => '225', // Non static options must have a priority
			/* Translators: 1 is the link start markup, 2 is link markup end */
			'content'     => sprintf( __( 'Looks like you are using Woocommerce. Install %1$sthis plugin%2$s to change colors and styles for WooCommerce elements like buttons etc.', 'hoot-du' ), '<a href="https://wordpress.org/plugins/woocommerce-colors/" target="_blank">', '</a>' ),
		);
	endif;

	/** Section **/

	$section = 'typography';

	$sections[ $section ] = array(
		'title'       => __( 'Typography', 'hoot-du' ),
	);

	$settings['logo_fontface'] = array(
		'label'       => __( 'Logo Font (Free Version)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => 227, // Non static options must have a priority
		'choices'     => array(
			'standard'  => __( 'Standard Font (Fira Sans)', 'hoot-du'),
			'alternate' => __( 'Alternate Font (Comfortaa)', 'hoot-du'),
			'display'   => __( 'Display Font (Oswald)', 'hoot-du'),
			'display2'  => __( 'Display Font (Patua One)', 'hoot-du'),
			'heading'   => __( 'Heading Font (Slabo)', 'hoot-du'),
		),
		'default'     => 'display2',
	);

	$settings['logo_fontface_style'] = array(
		'label'       => __( 'Logo Font Style', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => 227, // Non static options must have a priority
		'choices'     => array(
			'standard'  => __( 'Standard', 'hoot-du'),
			'uppercase' => __( 'Uppercase', 'hoot-du'),
		),
		'default'     => 'uppercase',
	);

	$settings['headings_fontface'] = array(
		'label'       => __( 'Headings Font (Free Version)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => 227, // Non static options must have a priority
		'choices'     => array(
			'standard'  => __( 'Standard Font (Fira Sans)', 'hoot-du'),
			'alternate' => __( 'Alternate Font (Comfortaa)', 'hoot-du'),
			'display'   => __( 'Display Font (Oswald)', 'hoot-du'),
			'display2'  => __( 'Display Font (Patua One)', 'hoot-du'),
			'heading'   => __( 'Heading Font (Slabo)', 'hoot-du'),
		),
		'default'     => 'display2',
	);

	$settings['headings_fontface_style'] = array(
		'label'       => __( 'Heading Font Style', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => 227, // Non static options must have a priority
		'choices'     => array(
			'standard'  => __( 'Standard', 'hoot-du'),
			'uppercase' => __( 'Uppercase', 'hoot-du'),
		),
		'default'     => 'standard',
	);

	/** Section **/

	$section = 'frontpage';

	$sections[ $section ] = array(
		'title'       => __( 'Frontpage - Modules', 'hoot-du' ),
	);

	$widget_area_options = array(
		'columns' => array(
			'label'   => __( 'Columns', 'hoot-du' ),
			'type'    => 'select',
			'choices' => array(
				'100'         => __( 'One Column [100]', 'hoot-du' ),
				'50-50'       => __( 'Two Columns [50 50]', 'hoot-du' ),
				'33-66'       => __( 'Two Columns [33 66]', 'hoot-du' ),
				'66-33'       => __( 'Two Columns [66 33]', 'hoot-du' ),
				'25-75'       => __( 'Two Columns [25 75]', 'hoot-du' ),
				'75-25'       => __( 'Two Columns [75 25]', 'hoot-du' ),
				'33-33-33'    => __( 'Three Columns [33 33 33]', 'hoot-du' ),
				'25-25-50'    => __( 'Three Columns [25 25 50]', 'hoot-du' ),
				'25-50-25'    => __( 'Three Columns [25 50 25]', 'hoot-du' ),
				'50-25-25'    => __( 'Three Columns [50 25 25]', 'hoot-du' ),
				'25-25-25-25' => __( 'Four Columns [25 25 25 25]', 'hoot-du' ),
			),
		),
		'grid' => array(
			'label'    => __( 'Layout', 'hoot-du' ),
			'sublabel' => __( 'The fully stretched grid layout is especially useful for displaying full width slider widgets.', 'hoot-du' ),
			'type'     => 'radioimage',
			'choices'     => array(
				'boxed'   => $imagepath . 'fp-widgetarea-boxed.png',
				'stretch' => $imagepath . 'fp-widgetarea-stretch.png',
			),
			'default'  => 'boxed',
		),
		'modulebg' => array(
			'label'       => '',
			'type'        => 'content',
			'content'     => '<div class="button">' . __( 'Module Background', 'hoot-du' ) . '</div>',
		),
	);

	$settings['frontpage_sections'] = array(
		'label'       => __( 'Frontpage Widget Areas', 'hoot-du' ),
		/* Translators: 1 is the link start markup, 2 is link markup end */
		'sublabel'    => sprintf( __( "<p></p><ul><li>Sort different sections of the Frontpage in the order you want them to appear.</li><li>You can add content to widget areas from the %1$1sWidgets Management screen%2$2s.</li><li>You can disable areas by clicking the 'eye' icon. (This will hide them on the Widgets screen as well)</li></ul>", 'hoot-du' ), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
		'section'     => $section,
		'type'        => 'sortlist',
		'choices'     => array(
			'area_a'      => __( 'Widget Area A', 'hoot-du' ),
			'area_b'      => __( 'Widget Area B', 'hoot-du' ),
			'area_c'      => __( 'Widget Area C', 'hoot-du' ),
			'area_d'      => __( 'Widget Area D', 'hoot-du' ),
			'content'     => __( 'Frontpage Content', 'hoot-du' ),
			'area_e'      => __( 'Widget Area E', 'hoot-du' ),
			'area_f'      => __( 'Widget Area F', 'hoot-du' ),
			'area_g'      => __( 'Widget Area G', 'hoot-du' ),
			'area_h'      => __( 'Widget Area H', 'hoot-du' ),
			'area_i'      => __( 'Widget Area I', 'hoot-du' ),
			'area_j'      => __( 'Widget Area J', 'hoot-du' ),
		),
		'default'     => array(
			// 'content' => array( 'sortitem_hide' => 1, ),
			'area_b'  => array( 'columns' => '50-50' ),
			'area_f'  => array( 'sortitem_hide' => 1, ),
			'area_g'  => array( 'sortitem_hide' => 1, ),
			'area_h'  => array( 'sortitem_hide' => 1, ),
			'area_i'  => array( 'sortitem_hide' => 1, ),
			'area_j'  => array( 'sortitem_hide' => 1, ),
		),
		'options'     => array(
			'area_a'      => $widget_area_options,
			'area_b'      => $widget_area_options,
			'area_c'      => $widget_area_options,
			'area_d'      => $widget_area_options,
			'area_e'      => $widget_area_options,
			'area_f'      => $widget_area_options,
			'area_g'      => $widget_area_options,
			'area_h'      => $widget_area_options,
			'area_i'      => $widget_area_options,
			'area_j'      => $widget_area_options,
			'content'     => array(
							'title' => array(
								'label'       => __( 'Title (optional)', 'hoot-du' ),
								'type'        => 'text',
							),
							'modulebg' => array(
								'label'       => '',
								'type'        => 'content',
								'content'     => '<div class="button">' . __( 'Module Background', 'hoot-du' ) . '</div>',
							), ),
		),
		'attributes'  => array(
			'hideable'      => true,
			'sortable'      => true,
			'open-state'    => 'area_a',
		),
		// 'description' => sprintf( __( 'You must first save the changes you make here and refresh this screen for widget areas to appear in the Widgets panel (in customizer). Once you save the settings, you can add content to these widget areas using the %sWidgets Management screen%s.', 'hoot-du' ), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['frontpage_content_desc'] = array(
		'label'       => __( "Frontpage Content", 'hoot-du' ),
		'section'     => $section,
		'type'        => 'content',
		/* Translators: 1 is the link start markup, 2 is link markup end, 3 is the link start markup, 4 is link markup end */
		'content'     => sprintf( __( "The 'Frontpage Content' module in above list will show<ul style='list-style:disc;margin:1em 0 0 2em;'><li>the <strong>'Blog'</strong> if you have <strong>Your Latest Posts</strong> selectd in %1$1sReading Settings%2$2s</li><li>the <strong>Page Content</strong> of the page set as Front page if you have <strong>A static page</strong> selected in %3$3sReading Settings%4$4s</li></ul>", 'hoot-du' ), '<a href="' . esc_url( admin_url('options-reading.php') ) . '" target="_blank">', '</a>', '<a href="' . esc_url( admin_url('options-reading.php') ) . '" target="_blank">', '</a>' ),
	);

	$frontpagemodule_bg = array(
		'area_a'      => __( 'Widget Area A', 'hoot-du' ),
		'area_b'      => __( 'Widget Area B', 'hoot-du' ),
		'area_c'      => __( 'Widget Area C', 'hoot-du' ),
		'area_d'      => __( 'Widget Area D', 'hoot-du' ),
		'area_e'      => __( 'Widget Area E', 'hoot-du' ),
		'area_f'      => __( 'Widget Area F', 'hoot-du' ),
		'area_g'      => __( 'Widget Area G', 'hoot-du' ),
		'area_h'      => __( 'Widget Area H', 'hoot-du' ),
		'area_i'      => __( 'Widget Area I', 'hoot-du' ),
		'area_j'      => __( 'Widget Area J', 'hoot-du' ),
		'content'     => __( 'Frontpage Content', 'hoot-du' ),
		);

	foreach ( $frontpagemodule_bg as $fpgmodid => $fpgmodname ) {

		$settings["frontpage_sectionbg_{$fpgmodid}"] = array(
			'label'       => '',
			'section'     => $section,
			'type'        => 'group',
			'startwrap'   => 'fp-section-bg-button',
			'button'      => __( 'Module Background', 'hoot-du' ),
			'options'     => array(
				'description' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<span class="hootdu-module-bg-title">' . $fpgmodname . '</span>',
				),
				'type' => array(
					'label'   => __( 'Background Type', 'hoot-du' ),
					'type'    => 'radio',
					'choices' => array(
						'none'        => __( 'None', 'hoot-du' ),
						// 'highlight'   => __( 'Highlight', 'hoot-du' ),
						'color'       => __( 'Color', 'hoot-du' ),
						'image'       => __( 'Image', 'hoot-du' ),
					),
					'default' => 'none',
					// 'default' => ( ( $fpgmodid == 'area_b' ) ? 'image' :
					// 											( ( $fpgmodid == 'area_d' ) ? 'highlight' : 'none' )
					// 			 ),
					// 'default' => ( ( $fpgmodid == 'area_b' ) ? 'image' : 'none' ),
				),
				'color' => array(
					'label'       => __( "Background Color (Select 'Color' above)", 'hoot-du' ),
					'type'        => 'color',
					'default'     => $highlight_color, // $highlight_dark
				),
				'image' => array(
					'label'       => __( "Background Image (Select 'Image' above)", 'hoot-du' ),
					'type'        => 'image',
					// 'default' => ( ( $fpgmodid == 'area_b' ) ? hootdu_data()->template_uri . 'images/modulebg.jpg' : '' ),
				),
				'parallax' => array(
					'label'   => __( 'Apply Parallax Effect to Background Image', 'hoot-du' ),
					'type'    => 'checkbox',
					'default' => 1,
					// 'default' => ( ( $fpgmodid == 'area_b' ) ? 1 : 0 ),
				),
			),
		);

	} // end for

	/** Section **/

	$section = 'archives';

	$sections[ $section ] = array(
		'title'       => __( 'Archives (Blog, Cats, Tags)', 'hoot-du' ),
	);

	$settings['archive_type'] = array(
		'label'       => __( 'Archive (Blog) Layout', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'big'     => $imagepath . 'archive-big.png',
			'block2'  => $imagepath . 'archive-block2.png',
			'block3'  => $imagepath . 'archive-block3.png',
		),
		'default'     => 'block2',
	);

	$settings['archive_post_content'] = array(
		'label'       => __( 'Post Items Content', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'none' => __( 'None', 'hoot-du' ),
			'excerpt' => __( 'Post Excerpt', 'hoot-du' ),
			'full-content' => __( 'Full Post Content', 'hoot-du' ),
		),
		'default'     => 'excerpt',
		'description' => __( 'Content to display for each post in the list', 'hoot-du' ),
	);

	$settings['archive_post_meta'] = array(
		'label'       => __( 'Meta Information for Post List Items', 'hoot-du' ),
		'sublabel'    => __( 'Check which meta information to display for each post item in the archive list.', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __( 'Author', 'hoot-du' ),
			'date'     => __( 'Date', 'hoot-du' ),
			'cats'     => __( 'Categories', 'hoot-du' ),
			'tags'     => __( 'Tags', 'hoot-du' ),
			'comments' => __( 'No. of comments', 'hoot-du' ),
		),
		'default'     => 'author, date, cats, comments',
	);

	$settings['excerpt_length'] = array(
		'label'       => __( 'Excerpt Length', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Number of words in excerpt. Default is 50. Leave empty if you dont want to change it.', 'hoot-du' ),
		'input_attrs' => array(
			'placeholder' => __( 'default: 50', 'hoot-du' ),
		),
	);

	$settings['read_more'] = array(
		'label'       => __( "'Read More' Text", 'hoot-du' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( "Replace the default 'Read More' text. Leave empty if you dont want to change it.", 'hoot-du' ),
		'input_attrs' => array(
			'placeholder' => __( 'default: READ MORE &rarr;', 'hoot-du' ),
		),
	);

	/** Section **/

	$section = 'singular';

	$sections[ $section ] = array(
		'title'       => __( 'Single (Posts, Pages)', 'hoot-du' ),
	);

	$settings['page_header_full'] = array(
		'label'       => __( 'Stretch Page Title Area to Full Width', 'hoot-du' ),
		'sublabel'    => '<img src="' . $imagepath . 'page-header.png">',
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'default'    => __( 'Default (Archives, Blog, Woocommerce etc.)', 'hoot-du' ),
			'posts'      => __( 'For All Posts', 'hoot-du' ),
			'pages'      => __( 'For All Pages', 'hoot-du' ),
			'no-sidebar' => __( 'Always override for full width pages (any page which has no sidebar)', 'hoot-du' ),
		),
		'default'     => 'default, pages, no-sidebar',
		'description' => __( 'This is the Page Header area containing Page/Post Title and Meta details like author, categories etc.', 'hoot-du' ),
	);

	$settings['post_featured_image'] = array(
		'label'       => __( 'Display Featured Image (Post)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => array(
			'none'    => __( 'Do not display', 'hoot-du'),
			'header'  => __( 'Full width in header (Parallax Effect)', 'hoot-du'),
			'content' => __( 'Beginning of content', 'hoot-du'),
		),
		'default'     => 'content',
		'description' => __( 'Display featured image on a Post page.', 'hoot-du' ),
	);

	$settings['post_featured_image_page'] = array(
		'label'       => __( 'Display Featured Image (Page)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => array(
			'none'    => __( 'Do not display', 'hoot-du'),
			'header'  => __( 'Full width in header (Parallax Effect)', 'hoot-du'),
			'content' => __( 'Beginning of content', 'hoot-du'),
		),
		'default'     => 'header',
		'description' => __( "Display featured image on a 'Page' page.", 'hoot-du' ),
	);

	$settings['post_meta'] = array(
		'label'       => __( 'Meta Information on Posts', 'hoot-du' ),
		'sublabel'    => __( "Check which meta information to display on an individual 'Post' page", 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __( 'Author', 'hoot-du' ),
			'date'     => __( 'Date', 'hoot-du' ),
			'cats'     => __( 'Categories', 'hoot-du' ),
			'tags'     => __( 'Tags', 'hoot-du' ),
			'comments' => __( 'No. of comments', 'hoot-du' )
		),
		'default'     => 'author, date, cats, tags, comments',
	);

	$settings['page_meta'] = array(
		'label'       => __( 'Meta Information on Page', 'hoot-du' ),
		'sublabel'    => __( "Check which meta information to display on an individual 'Page' page", 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __( 'Author', 'hoot-du' ),
			'date'     => __( 'Date', 'hoot-du' ),
			'comments' => __( 'No. of comments', 'hoot-du' ),
		),
		'default'     => 'author, date, comments',
	);

	$settings['post_meta_location'] = array(
		'label'       => __( 'Meta Information location', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'top'    => __( 'Top (below title)', 'hoot-du' ),
			'bottom' => __( 'Bottom (after content)', 'hoot-du' ),
		),
		'default'     => 'top',
	);

	$settings['post_prev_next_links'] = array(
		'label'       => __( 'Previous/Next Posts', 'hoot-du' ),
		'sublabel'    => __( 'Display links to Prev/Next Post links at the end of post content.', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
	);

	if ( current_theme_supports( 'woocommerce' ) ) :

		/** Section **/

		$section = 'hootdu_woocommerce';

		$sections[ $section ] = array(
			'title'       => __( 'WooCommerce (Hoot Du)', 'hoot-du' ),
			'priority'    => '43', // Non static options must have a priority
		);

		$wooproducts = range( 0, 99 );
		for ( $wpr=0; $wpr < 4; $wpr++ )
			unset( $wooproducts[$wpr] );
		$settings['wooshop_products'] = array(
			'label'       => __( 'Total Products per page', 'hoot-du' ),
			'section'     => $section,
			'type'        => 'select',
			'priority'    => '1135', // Non static options must have a priority
			'choices'     => $wooproducts,
			'default'     => '12',
			'description' => __( 'Total number of products to show on the Shop page', 'hoot-du' ),
		);

		$settings['wooshop_product_columns'] = array(
			'label'       => __( 'Product Columns', 'hoot-du' ),
			'section'     => $section,
			'type'        => 'select',
			'priority'    => '1135', // Non static options must have a priority
			'choices'     => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'default'     => '3',
			'description' => __( 'Number of products to show in 1 row on the Shop page', 'hoot-du' ),
		);

		$settings['sidebar_wooshop'] = array(
			'label'       => __( 'Sidebar Layout (Woocommerce Shop/Archives)', 'hoot-du' ),
			'section'     => $section,
			'type'        => 'radioimage',
			'priority'    => '1135', // Non static options must have a priority
			'choices'     => array(
				'wide-right'         => $imagepath . 'sidebar-wide-right.png',
				'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'          => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
				'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
				'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
				'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
				'full-width'         => $imagepath . 'sidebar-full.png',
				'none'               => $imagepath . 'sidebar-none.png',
			),
			'default'     => 'wide-right',
			'description' => __( 'Set the default sidebar width and position for WooCommerce Shop and Archives pages like product categories etc.', 'hoot-du' ),
		);

		$settings['sidebar_wooproduct'] = array(
			'label'       => __( 'Sidebar Layout (Woocommerce Single Product Page)', 'hoot-du' ),
			'section'     => $section,
			'type'        => 'radioimage',
			'priority'    => '1135', // Non static options must have a priority
			'choices'     => array(
				'wide-right'         => $imagepath . 'sidebar-wide-right.png',
				'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'          => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
				'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
				'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
				'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
				'full-width'         => $imagepath . 'sidebar-full.png',
				'none'               => $imagepath . 'sidebar-none.png',
			),
			'default'     => 'wide-right',
			'description' => __( 'Set the default sidebar width and position for WooCommerce product page', 'hoot-du' ),
		);

	endif;

	/** Section **/

	$section = 'footer';

	$sections[ $section ] = array(
		'title'       => __( 'Footer', 'hoot-du' ),
	);

	$settings['footer'] = array(
		'label'       => __( 'Footer Layout', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'1-1' => $imagepath . '1-1.png',
			'2-1' => $imagepath . '2-1.png',
			'2-2' => $imagepath . '2-2.png',
			'2-3' => $imagepath . '2-3.png',
			'3-1' => $imagepath . '3-1.png',
			'3-2' => $imagepath . '3-2.png',
			'3-3' => $imagepath . '3-3.png',
			'3-4' => $imagepath . '3-4.png',
			'4-1' => $imagepath . '4-1.png',
		),
		'default'     => '3-1',
		/* Translators: 1 is the link start markup, 2 is link markup end */
		'description' => sprintf( __( 'You must first save the changes you make here and refresh this screen for footer columns to appear in the Widgets panel (in customizer).<hr> Once you save the settings here, you can add content to footer columns using the %1$sWidgets Management screen%2$s.', 'hoot-du' ), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['site_info'] = array(
		'label'       => __( 'Site Info Text (footer)', 'hoot-du' ),
		'section'     => $section,
		'type'        => 'textarea',
		'default'     => __( '<!--default-->', 'hoot-du'),
		/* Translators: 1 is the link start markup, 2 is link markup end */
		'description' => sprintf( __( 'Text shown in footer. Useful for showing copyright info etc.<hr>Use the <code>&lt;!--default--&gt;</code> tag to show the default Info Text.<hr>Use the <code>&lt;!--year--&gt;</code> tag to insert the current year.<hr>Always use %1$sHTML codes%2$s for symbols. For example, the HTML for &copy; is <code>&amp;copy;</code>', 'hoot-du' ), '<a href="http://ascii.cl/htmlcodes.htm" target="_blank">', '</a>' ),
	);


	/*** Return Options Array ***/
	return apply_filters( 'hootdu_theme_customizer_options', array(
		'settings' => $settings,
		'sections' => $sections,
		'panels'   => $panels,
	) );

}
endif;

/**
 * Add Options (settings, sections and panels) to Hootdu_Customize class options object
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_add_customizer_options' ) ) :
function hootdu_theme_add_customizer_options() {

	$hootdu_customize = Hootdu_Customize::get_instance();

	// Add Options
	$options = hootdu_theme_customizer_options();
	$hootdu_customize->add_options( array(
		'settings' => $options['settings'],
		'sections' => $options['sections'],
		'panels' => $options['panels'],
		) );

}
endif;
add_action( 'init', 'hootdu_theme_add_customizer_options', 0 ); // cannot hook into 'after_setup_theme' as this hook is already being executed (this file is loaded at after_setup_theme @priority 10) (hooking into same hook from within while hook is being executed leads to undesirable effects as $GLOBALS[$wp_filter]['after_setup_theme'] has already been ksorted)
// Hence, we hook into 'init' @priority 0, so that settings array gets populated before 'widgets_init' action ( which itself is hooked to 'init' at priority 1 ) for creating widget areas ( settings array is needed for creating defaults when user value has not been stored )

/**
 * Enqueue custom scripts to customizer screen
 *
 * @since 1.0
 * @return void
 */
function hootdu_theme_customizer_enqueue_scripts() {
	// Enqueue Styles
	$style_uri = ( function_exists( 'hootdu_locate_style' ) ) ? hootdu_locate_style( hootdu_data()->incuri . 'admin/css/customize' ) : hootdu_data()->incuri . 'admin/css/customize.css';
	wp_enqueue_style( 'hootdu-theme-customize-styles', $style_uri, array(),  hootdu_data()->hootdu_version );
	// Enqueue Scripts
	$script_uri = ( function_exists( 'hootdu_locate_script' ) ) ? hootdu_locate_script( hootdu_data()->incuri . 'admin/js/customize' ) : hootdu_data()->incuri . 'admin/js/customize.js';
	wp_enqueue_script( 'hootdu-theme-customize', $script_uri, array( 'jquery', 'wp-color-picker', 'customize-controls', 'hootdu-customize' ), hootdu_data()->hootdu_version, true );
}
// Load scripts at priority 12 so that Hoot Customizer Interface (11) / Custom Controls (10) have loaded their scripts
add_action( 'customize_controls_enqueue_scripts', 'hootdu_theme_customizer_enqueue_scripts', 12 );

/**
 * Modify default WordPress Settings Sections and Panels
 *
 * @since 1.0
 * @param object $wp_customize
 * @return void
 */
function hootdu_theme_modify_default_customizer_options( $wp_customize ) {

	/**
	 * Defaults: [type] => cropped_image
	 *           [width] => 150
	 *           [height] => 150
	 *           [flex_width] => 1
	 *           [flex_height] => 1
	 *           [button_labels] => array(...)
	 *           [label] => Logo
	 */
	$wp_customize->get_control( 'custom_logo' )->section = 'logo';
	$wp_customize->get_control( 'custom_logo' )->priority = 185;
	$wp_customize->get_control( 'custom_logo' )->width = 300;
	$wp_customize->get_control( 'custom_logo' )->height = 180;
	// $wp_customize->get_control( 'custom_logo' )->type = 'image'; // Stored value becomes url instead of image ID (fns like the_custom_logo() dont work)
	$wp_customize->get_control( 'custom_logo' )->active_callback = 'hootdu_theme_callback_logo_image';

	if ( function_exists( 'get_site_icon_url' ) )
		$wp_customize->get_control( 'site_icon' )->priority = 10;

	$wp_customize->get_section( 'static_front_page' )->priority = 3;
	if ( current_theme_supports( 'custom-header' ) ) {
		$wp_customize->get_section( 'header_image' )->priority = 28;
		$wp_customize->get_section( 'header_image' )->title = __( 'Frontpage - Header Image', 'hoot-du' );
	}

	// Backgrounds
	if ( current_theme_supports( 'custom-background' ) ) {
		$wp_customize->get_control( 'background_color' )->label =  __( 'Site Background Color / Contrast Color', 'hoot-du' );
		$wp_customize->get_setting( 'background_color' )->transport =  'refresh';
		$wp_customize->get_section( 'background_image' )->priority = 23;
		$wp_customize->get_section( 'background_image' )->title = __( 'Site Background Image', 'hoot-du' );
	}

	// $wp_customize->get_section( 'title_tagline' )->panel = 'general';
	// $wp_customize->get_section( 'title_tagline' )->priority = 1;
	// $wp_customize->get_section( 'colors' )->panel = 'styling';
	// 	$wp_customize->get_panel( 'nav_menus' )->priority = 999;
	// This will set the priority, however will give a 'Creating Default Object from Empty Value' error first.
	// $wp_customize->get_panel( 'widgets' )->priority = 999;

}
add_action( 'customize_register', 'hootdu_theme_modify_default_customizer_options', 100 );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function hootdu_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'hootdu_theme_customize_register' );

/**
 * Callback Functions for customizer settings
 */

function hootdu_theme_callback_logo_size( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'mixed' ) ? true : false;
}
function hootdu_theme_callback_site_title_icon( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'custom' ) ? true : false;
}
function hootdu_theme_callback_logo_image( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'image' || $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}
function hootdu_theme_callback_logo_image_width( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}
function hootdu_theme_callback_logo_custom( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'custom' || $selector == 'mixedcustom' ) ? true : false;
}
function hootdu_theme_callback_show_tagline( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'custom' || $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}
function hootdu_theme_callback_show_primary_menuarea_custom( $control ) {
	$selector = $control->manager->get_setting('primary_menuarea')->value();
	return ( $selector == 'custom' ) ? true : false;
}

/**
 * Specific Sanitization Functions for customizer settings
 * See specific settings above for more details.
 */
function hootdu_theme_sanitize_textarea_allowscript( $value ) {
	global $allowedposttags;
	// Allow javascript to let users ad code for ads etc.
	$allow = array_merge( $allowedposttags, array(
		'script' => array( 'async' => true, 'charset' => true, 'defer' => true, 'src' => true, 'type' => true ),
	) );
	return wp_kses( $value , $allow );
}