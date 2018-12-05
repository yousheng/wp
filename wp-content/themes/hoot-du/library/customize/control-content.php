<?php
/**
 * Customize for general content, extend the WP customizer
 *
 * @package    Hoot Du
 * @subpackage Library
 */

/**
 * General Content Control Class extends the WP customizer
 *
 * @since 3.0.0
 */
// Only load in customizer (not in frontend)
if ( class_exists( 'WP_Customize_Control' ) ) :
class Hootdu_Customize_Content_Control extends WP_Customize_Control {

	/**
	 * @since 3.0.0
	 * @access public
	 * @var string
	 */
	public $type = 'content';

	/**
	 * Define variable to whitelist sublabel parameter
	 *
	 * @since 3.0.0
	 * @access public
	 * @var string
	 */
	public $sublabel = '';

	/**
	 * Define variable to whitelist content parameter
	 *
	 * @since 3.0.0
	 * @access public
	 * @var string
	 */
	public $content = '';

	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since 3.0.0
	 * @return void
	 */
	public function render_content() {

		switch ( $this->type ) {

			case 'content' :

				if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;

				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif;

				if ( ! empty( $this->sublabel ) ) : ?>
					<span class="description customize-control-sublabel"><?php echo wp_kses_post( $this->sublabel ); ?></span>
				<?php endif;

				if ( ! empty( $this->content ) ) : ?>
					<span class="hootdu-customize-control-content-text"><?php echo wp_kses_post( $this->content ); ?></span>
				<?php endif;

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
function hootdu_customize_content_control_interface ( $wp_customize, $id, $setting ) {
	if ( isset( $setting['type'] ) ) :
		if ( $setting['type'] == 'content' ) {
			$wp_customize->add_control(
				new Hootdu_Customize_Content_Control( $wp_customize, $id, $setting )
			);
		}
	endif;
}
add_action( 'hootdu_customize_control_interface', 'hootdu_customize_content_control_interface', 10, 3 );
endif;