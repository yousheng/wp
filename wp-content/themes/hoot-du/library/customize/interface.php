<?php
/**
 * Builds out customize options
 *
 * @package    Hoot Du
 * @subpackage Library
 */

/**
 * Configure and add panels, sections, settings/controls for the theme customizer
 *
 * @since 3.0.0
 * @param object $wp_customize The global customizer object.
 * @return void
 */
function hootdu_customize_register( $wp_customize ) {

	$hootdu_customize = Hootdu_Customize::get_instance();
	$options = $hootdu_customize->get_options();
	if ( empty( $options ) ) {
		return;
	}

	/** Add the panels **/
	if ( !empty( $options['panels'] ) && is_array( $options['panels'] ) ) {
		hootdu_customize_add_panels( $options['panels'], $wp_customize );
	}

	/** Add the sections **/
	if ( !empty( $options['sections'] ) && is_array( $options['sections'] ) ) {
		hootdu_customize_add_sections( $options['sections'], $wp_customize );
	}

	/** Exit if no settings to add **/
	if ( empty( $options['settings'] ) || !is_array( $options['settings'] ) )
		return;

	/** Objects added.. Use this hook instead of 'customize_register' hook to remove or modify any Customizer object, and to access the Customizer Manager. For adding, continue using 'customize_register' **/
	do_action( 'hootdu_customize_registered', $wp_customize, $hootdu_customize );

	// Sets the priority for each control added
	$loop = 0;

	/** Loop through each of the settings **/
	foreach ( $options['settings'] as $id => $setting ) :
		if ( isset( $setting['type'] ) ) :

			/** Prepare Setting **/

			// Apply a default sanitization if one isn't set and
			// set blank active_callback if one isn't set
			$callback = hootdu_customize_sanitize_callback( $setting['type'], $setting, $id );
			$setting = wp_parse_args( $setting, array(
				'label'             => '',
				'section'           => '',
				'sanitize_callback' => ( ( is_string( $callback ) && function_exists( $callback ) ) ? $callback : false ),
				'active_callback'   => '',
			) );

			// Set Priority (increment priority by 10 to allow child themes to insert controls in between)
			if ( ! isset( $setting['priority'] ) || ! is_numeric( $setting['priority'] ) ) {
				$loop += 10;
				$setting['priority'] = $loop;
			}
			if ( defined( 'HOOT_DEBUG' ) && true === HOOT_DEBUG )
				hootdu_debug_info( "[{$setting['priority']}] {$id}\n" );

			// Set and prepare description
			$setting['description'] = empty( $setting['description'] ) ? '' : $setting['description'];
			$setting['description'] =  ( is_array( $setting['description'] ) ) ? (
										( !empty( $setting['description']['text'] ) ) ? $setting['description']['text'] : ''
										) : $setting['description'];

			/** Add the setting **/

			hootdu_customize_add_setting( $wp_customize, $id, $setting );

			/** Adds control **/

			switch ( $setting['type'] ) :

				/* input Text */
				case 'text':
				case 'url':
				case 'select':
				case 'radio':
				case 'checkbox':
				case 'range':
				case 'dropdown-pages':
					$wp_customize->add_control( $id, $setting );
					break;

				/* Textarea */
				case 'textarea':
					$wp_customize->add_control( $id, $setting );
					break;

				/* Color Picker */
				case 'color':
					$wp_customize->add_control(
						new WP_Customize_Color_Control( $wp_customize, $id, $setting )
					);
					break;

				/* Image Upload */
				case 'image':
					$wp_customize->add_control(
						new WP_Customize_Image_Control( $wp_customize, $id, array(
							'label'             => $setting['label'],
							'section'           => $setting['section'],
							'sanitize_callback' => $setting['sanitize_callback'],
							'priority'          => $setting['priority'],
							'active_callback'   => $setting['active_callback'],
							'description'       => $setting['description']
						) )
					);
					break;

				/* File Upload */
				case 'upload':
					$wp_customize->add_control(
						new WP_Customize_Upload_Control( $wp_customize, $id, array(
							'label'             => $setting['label'],
							'section'           => $setting['section'],
							'sanitize_callback' => $setting['sanitize_callback'],
							'priority'          => $setting['priority'],
							'active_callback'   => $setting['active_callback'],
							'description'       => $setting['description']
						) )
					);
					break;

				/* Allow custom controls to hook into interface */
				default:
					do_action( 'hootdu_customize_control_interface', $wp_customize, $id, $setting );

			endswitch;

		endif;
	endforeach;
}

add_action( 'customize_register', 'hootdu_customize_register', 99 );

/**
 * Add the customizer panels
 * 
 * @since 3.0.0
 * @param array $panels
 * @return void
 */
function hootdu_customize_add_panels( $panels, $wp_customize ) {

	$loop = 0;

	foreach ( $panels as $id => $panel ) {

		if ( ! isset( $panel['description'] ) ) {
			$panel['description'] = FALSE;
		}
		if ( ! isset( $panel['priority'] ) || ! is_numeric( $panel['priority'] ) ) {
			$loop += 10;
			$panel['priority'] = $loop;
		}
		if ( defined( 'HOOT_DEBUG' ) && true === HOOT_DEBUG )
			hootdu_debug_info( "Panel [{$panel['priority']}] {$id}\n" );

		// Add Panel
		$wp_customize->add_panel( $id, $panel );

	}

}

/**
 * Add the customizer sections
 *
 * @since 3.0.0
 * @param array $sections
 * @return void
 */
function hootdu_customize_add_sections( $sections, $wp_customize ) {

	$loop = 0;

	foreach ( $sections as $id => $section ) {

		if ( ! isset( $section['description'] ) ) {
			$section['description'] = FALSE;
		}
		if ( ! isset( $section['priority'] ) || ! is_numeric( $section['priority'] ) ) {
			$loop += 5;
			$section['priority'] = $loop;
		}
		if ( defined( 'HOOT_DEBUG' ) && true === HOOT_DEBUG )
			hootdu_debug_info( "Section [{$section['priority']}] {$id}\n" );

		// Add Section
		$wp_customize->add_section( $id, $section );

	}

}

/**
 * Add the setting and proper sanitization
 *
 * @since 3.0.0
 * @param string $id
 * @param array $setting
 * @return void
 */
function hootdu_customize_add_setting( $wp_customize, $id, $setting ) {

	$add_setting = wp_parse_args( $setting, array(
		'default'              => NULL,
		'option_type'          => 'theme_mod',
		'capability'           => 'edit_theme_options',
		'theme_supports'       => NULL,
		'transport'            => NULL,
		'sanitize_callback'    => 'wp_kses_post',
		'sanitize_js_callback' => NULL
	) );

	// Add Setting
	$wp_customize->add_setting( $id, array(
			'default'              => $add_setting['default'],
			'type'                 => $add_setting['option_type'],
			'capability'           => $add_setting['capability'],
			'theme_supports'       => $add_setting['theme_supports'],
			'transport'            => $add_setting['transport'],
			'sanitize_callback'    => $add_setting['sanitize_callback'],
			'sanitize_js_callback' => $add_setting['sanitize_js_callback']
		)
	);

}

/**
 * Enqueue scripts to customizer screen
 *
 * @since 3.0.0
 * @return void
 */
function hootdu_customize_enqueue_scripts() {

	// Enqueue Styles
	wp_enqueue_style( 'font-awesome' );
	$style_uri = hootdu_locate_style( hootdu_data()->liburi . 'css/customize' );
	wp_enqueue_style( 'hootdu-customize', $style_uri, array(),  hootdu_data()->hootdu_version );

	// Enqueue Scripts
	$script_uri = hootdu_locate_script( hootdu_data()->liburi . 'js/customize' );
	wp_enqueue_script( 'hootdu-customize', $script_uri, array( 'jquery', 'wp-color-picker', 'customize-controls' ), hootdu_data()->hootdu_version, true );

	// Localize Script
	$data = apply_filters( 'hootdu_customize_control_footer_js_data_object', array() );
	if ( is_array( $data ) && !empty( $data ) )
		wp_localize_script( 'hootdu-customize', 'hootdu_customize_data', $data );

}
// Load scripts at priority 11 so that Hoot Customizer Custom Controls have loaded their scripts
add_action( 'customize_controls_enqueue_scripts', 'hootdu_customize_enqueue_scripts', 11 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 3.0.0
 * @return void
 */
function hootdu_customize_preview_js() {

	$script_uri = ( function_exists( 'hootdu_locate_script' ) ) ? hootdu_locate_script( hootdu_data()->incuri . 'admin/js/customize-preview' ) : '';
	if ( $script_uri )
		wp_enqueue_script( 'hootdu-customize-preview', $script_uri, array( 'customize-preview' ), hootdu_data()->hootdu_version, true );

}
add_action( 'customize_preview_init', 'hootdu_customize_preview_js' );