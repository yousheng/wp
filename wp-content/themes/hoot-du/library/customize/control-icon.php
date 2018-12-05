<?php
/**
 * Customize for icon picker, extend the WP customizer
 *
 * @package    Hoot Du
 * @subpackage Library
 */

/**
 * Icon Picker Control Class extends the WP customizer
 *
 * @since 3.0.0
 */
// Only load in customizer (not in frontend)
if ( class_exists( 'WP_Customize_Control' ) ) :
class Hootdu_Customize_Icon_Control extends WP_Customize_Control {

	/**
	 * @since 3.0.0
	 * @access public
	 * @var string
	 */
	public $type = 'icon';

	/**
	 * Define variable to whitelist sublabel parameter
	 *
	 * @since 3.0.0
	 * @access public
	 * @var string
	 */
	public $sublabel = '';

	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since 3.0.0
	 * @return void
	 */
	public function render_content() {

		switch ( $this->type ) {

			case 'icon' :

				if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;

				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif;

				if ( ! empty( $this->sublabel ) ) : ?>
					<span class="description customize-control-sublabel"><?php echo wp_kses_post( $this->sublabel ); ?></span>
				<?php endif;

				$iconvalue = hootdu_sanitize_fa( $this->value() );
				?>
				<input class="hootdu-customize-control-icon" value="<?php echo esc_attr( $iconvalue ) ?>" <?php $this->link(); ?> type="hidden"/>
				<div class="hootdu-customize-control-icon-picked hootdu-flypanel-button" data-flypaneltype="icon"><i class="<?php echo esc_attr( $iconvalue ) ?>"></i><span><?php esc_attr_e( 'Select Icon', 'hoot-du' ) ?></span></div>
				<div class="hootdu-customize-control-icon-remove"><i class="fas fa-ban"></i><span><?php esc_attr_e( 'Remove Icon', 'hoot-du' ) ?></span></div>

				<?php
				break;

		}

	}

}
endif;

/**
 * Hook into control display interface
 *
 * @since 3.0.0
 * @param object $wp_customize
 * @param string $id
 * @param array $setting
 * @return void
 */
// Only load in customizer (not in frontend)
if ( class_exists( 'WP_Customize_Control' ) ) :
function hootdu_customize_icon_control_interface ( $wp_customize, $id, $setting ) {
	if ( isset( $setting['type'] ) ) :
		if ( $setting['type'] == 'icon' || $setting['type'] == 'icons' ) {
			$setting['type'] = 'icon';
			$wp_customize->add_control(
				new Hootdu_Customize_Icon_Control( $wp_customize, $id, $setting )
			);
		}
	endif;
}
add_action( 'hootdu_customize_control_interface', 'hootdu_customize_icon_control_interface', 10, 3 );
endif;

/**
 * Add Content to Customizer Panel Footer
 *
 * @since 3.0.0
 * @return void
 */
// Only load in customizer (not in frontend)
if ( class_exists( 'WP_Customize_Control' ) ) :
function hootdu_customize_footer_iconcontent() {

	?>
	<div id="hootdu-flyicon" class="hootdu-flypanel">
		<div class="hootdu-flypanel-header hootdu-flypanel-nav">
			<div class="primary-actions">
				<span class="hootdu-flypanel-back" tabindex="-1"><span class="screen-reader-text"><?php esc_attr_e( 'Back', 'hoot-du' ) ?></span></span>
			</div>
		</div>
		<div id="hootdu-flyicon-content" class="hootdu-flypanel-content">
		</div>
		<div class="hootdu-flypanel-footer hootdu-flypanel-nav">
			<div class="primary-actions">
				<span class="hootdu-flypanel-back" tabindex="-1"><span class="screen-reader-text"><?php esc_attr_e( 'Back', 'hoot-du' ) ?></span></span>
			</div>
		</div>
	</div><!-- .hootdu-flypanel -->
	<?php

}
add_action( 'customize_controls_print_footer_scripts', 'hootdu_customize_footer_iconcontent' );
endif;

/**
 * Add Content to JS object passed to hootdu-customize-script
 *
 * @since 3.0.0
 * @return void
 */
// Only load in customizer (not in frontend)
if ( class_exists( 'WP_Customize_Control' ) ) :
function hootdu_customize_controls_icon_control_js_object( $data ) {

	$iconslist = '';
	$section_icons = hootdu_enum_icons('icons');

	$iconslist .= '<div class="hootdu-icon-list-wrap">';

	foreach ( hootdu_enum_icons('sections') as $s_key => $s_title ) {
		$iconslist .= "<h4>$s_title</h4>";
		$iconslist .= '<div class="hootdu-icon-list">';
		foreach ( $section_icons[$s_key] as $i_key => $i_class ) {
			$iconslist .= "<i class='$i_class' data-value='$i_class' data-category='$s_key'></i>";
		}
		$iconslist .= '</div>';
	}

	$iconslist .= '</div>';

	$data['iconslist'] = $iconslist;
	return $data;

}
add_filter( 'hootdu_customize_control_footer_js_data_object', 'hootdu_customize_controls_icon_control_js_object' );
endif;

/**
 * Add sanitization function
 *
 * @since 3.0.0
 * @param string $callback
 * @param string $type
 * @param array $setting
 * @param string $name name (id) of the setting
 * @return string
 */
function hootdu_customize_sanitize_icon_callback( $callback, $type, $setting, $name ) {
	if ( $type == 'icon' )
		$callback = 'hootdu_sanitize_icon';
	return $callback;
}
add_filter( 'hootdu_customize_sanitize_callback', 'hootdu_customize_sanitize_icon_callback', 5, 4 );