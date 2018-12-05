<?php
/**
 * This file contains functions and hooks for styling Hootkit plugin
 *   Hootkit is a free plugin released under GPL license and hosted on wordpress.org.
 *   It is recommended to the user via wp-admin using TGMPA class
 *
 * This file is loaded at 'after_setup_theme' action @priority 10 ONLY IF hootkit plugin is active
 *
 * @package    Hoot Du
 * @subpackage HootKit
 */

// Register HootKit
add_filter( 'hootkit_register', 'hootdu_theme_register_hootkit', 5 );

// Add hootkit styles. Set priority to @11 (unlike other scripts/styles @10)
// However we set stylesheet dependency to main stylesheet so hootkit css is loaded afterwards.
// Hootkit plugin loads its styles at default @10 (we skip this using config 'theme_css')
// The theme's main style is loaded @12 (Hence dynamic styles are loaded after -> now hooked to hootkit)
// The theme's main script is loaded @11
add_action( 'wp_enqueue_scripts', 'hootdu_theme_enqueue_hootkit', 11 );
// Set dynamic css handle to hootkit
add_filter( 'hootdu_style_builder_inline_style_handle', 'hootdu_theme_dynamic_css_hootkit_handle', 5 );

// Add dynamic CSS for hootkit
add_action( 'hootdu_dynamic_cssrules', 'hootdu_theme_hootkit_dynamic_cssrules' );

/**
 * Register Hootkit
 *
 * @since 1.0
 * @param array $config
 * @return string
 */
if ( !function_exists( 'hootdu_theme_register_hootkit' ) ) :
function hootdu_theme_register_hootkit( $config ) {
	// Array of configuration settings.
	$config = array(
		'nohoot'    => false,
		'theme_css' => true,
		'modules'   => array(
			'sliders' => array( 'image', 'postimage' ),
			'widgets' => array( 'announce', 'content-blocks', 'content-posts-blocks', 'cta', 'icon', 'post-grid', 'post-list', 'social-icons', 'ticker', ),
		),
	);
	if ( apply_filters( 'hootdu_theme_support_ocdi', true ) ) {
		$config['modules']['importer'] = array( array(
				'import_file_name'           => __( 'Hoot Du Demo', 'hoot-du' ),
				'import_file_url'            => 'https://demo.wphoot.com/downloads/hoot-du-content.xml',
				'import_widget_file_url'     => 'https://demo.wphoot.com/downloads/hoot-du-widgets.wie',
				'import_customizer_file_url' => 'https://demo.wphoot.com/downloads/hoot-du-customize.dat',
				'import_preview_image_url'   => hootdu_data()->template_uri . 'screenshot.jpg',
				/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
				'import_notice'              => sprintf( esc_html__( 'You are using the free version of the theme.%1$sSome features (available only in the premium version) will not get imported - You may see %2$s"Could not import"%3$s message for these features in the log once the installation is finished. You can safely ignore these messages.', 'hoot-du' ), '<br />', '<em>', '</em>' ),
				'preview_url'                => 'https://demo.wphoot.com/hoot-du/',
			), );
	}
	return $config;
}
endif;

/**
 * Enqueue Scripts and Styles
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_enqueue_hootkit' ) ) :
function hootdu_theme_enqueue_hootkit() {

	/* Load Hootkit Style - Add dependency so that hotkit is loaded after */
	$style_uri = hootdu_locate_style( 'hootkit/hootkit' );
	wp_enqueue_style( 'hootdu-theme-hootkit', $style_uri, array( 'hootdu-style' ), hootdu_data()->template_version );

	/* Load Hootkit Javascript */
	// $script_uri = hootdu_locate_script( 'hootkit/hootkit' );
	// wp_enqueue_script( 'hootdu-theme-hootkit', $script_uri, array( 'jquery' ), hootdu_data()->template_version, true );

}
endif;

/**
 * Set dynamic css handle to hootkit
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_theme_dynamic_css_hootkit_handle' ) ) :
function hootdu_theme_dynamic_css_hootkit_handle( $handle ) {
	return 'hootdu-theme-hootkit';
}
endif;

/**
 * Custom CSS built from user theme options for hootkit features
 * For proper sanitization, always use functions from library/sanitization.php
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_theme_hootkit_dynamic_cssrules' ) ) :
function hootdu_theme_hootkit_dynamic_cssrules() {

	// Get user based style values
	$styles = hootdu_theme_user_style(); // echo '<!-- '; print_r($styles); echo ' -->';
	extract( $styles );

	/*** Add Dynamic CSS ***/

	/* Light Slider */

	hootdu_add_css_rule( array(
						'selector'  => '.lSSlideOuter ul.lSPager.lSpg > li:hover a, .lSSlideOuter ul.lSPager.lSpg > li.active a',
						'property'  => 'background-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );


	/* Sidebars and Widgets */

	hootdu_add_css_rule( array(
						'selector'  => '.widget .view-all a:hover',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	if ( !empty( $widgetmargin ) ) :
		hootdu_add_css_rule( array(
						'selector'  => '.bottomborder-line:after' . ',' . '.bottomborder-shadow:after',
						'property'  => 'margin-top',
						'value'     => $widgetmargin,
						'idtag'     => 'widgetmargin',
					) );
		hootdu_add_css_rule( array(
						'selector'  => '.topborder-line:before' . ',' . '.topborder-shadow:before',
						'property'  => 'margin-bottom',
						'value'     => $widgetmargin,
						'idtag'     => 'widgetmargin',
					) );
	endif;
	if ( !empty( $smallwidgetmargin ) ) :
		hootdu_add_css_rule( array(
						'selector'  => '.content-block-row' . ',' . '.vcard-row',
						'property'  => 'margin-bottom',
						'value'     => $smallwidgetmargin,
						'idtag'     => 'widgetmargin',
					) );
	endif;

	hootdu_add_css_rule( array(
						'selector'  => '.cta-subtitle',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	hootdu_add_css_rule( array(
						'selector' => '.content-block-icon i',
						'property' => 'color',
						'value'    => $accent_color,
						'idtag'    => 'accent_color',
					) );

	hootdu_add_css_rule( array(
						'selector' => '.icon-style-circle' .',' . '.icon-style-square',
						'property' => 'border-color',
						'value'    => $accent_color,
						'idtag'    => 'accent_color',
					) );

	hootdu_add_css_rule( array(
						'selector'  => '.content-block-style3 .content-block-icon',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );

}
endif;

/**
 * HootKit Customization
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_theme_hootkit_content_block' ) ) :
function hootdu_theme_hootkit_content_block( $attr, $context ) {
	if ( !empty( $context['style'] ) && $context['style'] == 'style2' && !empty( $context['visualtype'] ) )
		$attr['class'] = 'content-block contrast-typo';

	return $attr;
}
endif;
add_filter( 'hootdu_attr_content-block', 'hootdu_theme_hootkit_content_block', 10, 2 );

/**
 * Modify Post Grid settings
 *
 * @since 1.0
 * @param array $settings
 * @return string
 */
function hootdu_theme_post_grid_widget_settings( $settings ) {
	if ( isset( $settings['form_options']['columns']['std'] ) )
		$settings['form_options']['columns']['std'] = 4;
	if ( isset( $settings['form_options']['count']['desc'] ) )
		$settings['form_options']['count']['desc'] = __( 'Default: 5 (posts without a featured image are skipped)', 'hoot-du' );
	return $settings;
}
add_filter( 'hootkit_post_grid_widget_settings', 'hootdu_theme_post_grid_widget_settings', 5 );

/**
 * Modify Post Grid Query Args
 *
 * @since 1.0
 * @param array $query_args
 * @param array $instance
 * @return string
 */
function hootdu_theme_post_grid_query( $query_args, $instance ) {
	$count = ( isset( $instance['count'] ) ) ? $instance['count'] : 5;
	$count = intval( $count );
	$query_args['posts_per_page'] = ( empty( $count ) ) ? 5 : $count;
	return $query_args;
}
add_filter( 'hootkit_post_grid_query', 'hootdu_theme_post_grid_query', 5, 2 );