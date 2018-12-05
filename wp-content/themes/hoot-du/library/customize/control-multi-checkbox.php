<?php
/**
 * Customize for Multiple Checkbox (bettercheckbox), extend the WP customizer
 *
 * @package    Hoot Du
 * @subpackage Library
 */

/**
 * Better Checkbox Control Class extends the WP customizer
 *
 * @since 3.0.0
 */
// Only load in customizer (not in frontend)
if ( class_exists( 'WP_Customize_Control' ) ) :
class Hootdu_Customize_Bettercheckbox_Control extends WP_Customize_Control {

	/**
	 * @since 3.0.0
	 * @access public
	 * @var string
	 */
	public $type = 'bettercheckbox';

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

			case 'bettercheckbox' :

				?>
				<span class="<?php if ( !empty( $this->choices ) && is_array( $this->choices ) ) echo 'bettercheckbox-multi'; else echo 'bettercheckbox-single'; ?>">
				<?php

					if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php endif;

					if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
					<?php endif;

					if ( ! empty( $this->sublabel ) ) : ?>
						<span class="description customize-control-sublabel"><?php echo wp_kses_post( $this->sublabel ); ?></span>
					<?php endif;

					if ( !empty( $this->choices ) && is_array( $this->choices ) ) {

						$multi_values = ( !is_array( $this->value() ) ) ? explode( ',', $this->value() ) : $this->value();
						$multi_values = array_map( 'trim', $multi_values );

						foreach ( $this->choices as $value => $label ) :
							?>
							<label>
								<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
								<?php echo esc_html( $label ); ?><br/>
							</label>
							<?php
						endforeach;
						?>

						<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
						<?php

					} else {
						?>
						<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
						<?php
					}

				?>
				</span>
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
function hootdu_customize_bettercheckbox_control_interface ( $wp_customize, $id, $setting ) {
	if ( isset( $setting['type'] ) ) :
		if ( $setting['type'] == 'bettercheckbox' || $setting['type'] == 'multicheckbox' ) {
			$setting['type'] = 'bettercheckbox';
			$wp_customize->add_control(
				new Hootdu_Customize_Bettercheckbox_Control( $wp_customize, $id, $setting )
			);
		}
	endif;
}
add_action( 'hootdu_customize_control_interface', 'hootdu_customize_bettercheckbox_control_interface', 10, 3 );
endif;

/**
 * Modify the settings array and prepare bettercheckbox settings for Customizer Library Interface functions
 *
 * @since 3.0.0
 * @param array $value
 * @param string $key
 * @param array $setting
 * @param int $count
 * @return void
 */
function hootdu_customize_prepare_bettercheckbox_settings( $value, $key, $setting, $count ) {

	if ( $setting['type'] == 'checkbox' ) {
		$setting['type'] = 'bettercheckbox';
		$value[ $key ] = $setting;
	}

	return $value;

}
add_filter( 'hootdu_customize_prepare_settings', 'hootdu_customize_prepare_bettercheckbox_settings', 10, 4 );

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
function hootdu_customize_sanitize_bettercheckbox_callback( $callback, $type, $setting, $name ) {
	if ( $type == 'bettercheckbox' ) {
		if ( !empty( $setting['choices'] ) && is_array( $setting['choices'] ) )
			$callback = 'hootdu_sanitize_customize_multicheckbox';
		else
			$callback = 'hootdu_sanitize_checkbox';
	}
	return $callback;
}
add_filter( 'hootdu_customize_sanitize_callback', 'hootdu_customize_sanitize_bettercheckbox_callback', 5, 4 );

/**
 * Sanitize multicheckbox value to allow only allowed choices.
 *
 * @since 3.0.0
 * @param string $value The value to sanitize.
 * @param mixed $setting 'WP_Customize_Setting' Object (called by Customizer) or Setting Name (called by hootdu_get_mod)
 * @return string The sanitized value.
 */
function hootdu_sanitize_customize_multicheckbox( $value, $setting ) {
	$name = '';
	if ( is_object( $setting ) )
		$name = $setting->id;
	elseif ( is_string( $setting ) )
		$name = $setting;

	$choices = hootdu_customize_get_choices( $name );

	return hootdu_sanitize_multicheck( $value, $choices, true );
}