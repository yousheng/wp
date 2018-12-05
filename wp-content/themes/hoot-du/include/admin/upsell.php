<?php
/**
 * Upsell page
 *
 * @package    Hoot Du
 * @subpackage Theme
 */

/**
 * Sets up the Appearance Subpage
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hootdu_theme_add_appearance_subpage() {

	add_theme_page(
		__( 'Hoot Du Premium', 'hoot-du' ),	// Page Title
		__( 'Premium Options', 'hoot-du' ),			// Menu Title
		'edit_theme_options',								// capability
		'hoot-du-premium',							// menu-slug
		'hootdu_theme_appearance_subpage'						// function name
		);

	add_action( 'admin_enqueue_scripts', 'hootdu_theme_admin_enqueue_upsell_styles' );

}
/* Add the admin setup function to the 'admin_menu' hook. */
add_action( 'admin_menu', 'hootdu_theme_add_appearance_subpage' );

/**
 * Enqueue CSS
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hootdu_theme_admin_enqueue_upsell_styles( $hook ) {
	if ( $hook == 'appearance_page_hoot-du-premium' )
		wp_enqueue_style( 'hootdu-admin-upsell', hootdu_data()->incuri . 'admin/css/upsell.css', array(),  hootdu_data()->hootdu_version );
}

/**
 * Display the Appearance Subpage
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hootdu_theme_appearance_subpage() {

	/*** Upsell Copy ***/

	$hootdu_options_premium = array();
	$imagepath =  esc_url( hootdu_data()->incuri . 'admin/images/' );

	$hootdu_cta_top = $hootdu_cta = '<a class="button button-primary button-buy-premium" href="https://wphoot.com/themes/hoot-du/" target="_blank">' . esc_html__( 'Buy Hoot Du Premium', 'hoot-du' ) . '</a>';
	$hootdu_cta_demo = '<a class="button button-secondary button-view-demo" href="https://demo.wphoot.com/hoot-du/" target="_blank">' . esc_html__( 'View Demo Site', 'hoot-du' ) . '</a>';

	$hootdu_intro = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Upgrade to %1$sHoot Du %2$sPremium%3$s%4$s', 'hoot-du' ), '<span>', '<strong>', '</strong>', '</span>' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'If you have enjoyed using Hoot Du, you are going to love %1$sHoot Du Premium%2$s.%3$sIt is a robust upgrade to Hoot Du that gives you many useful features.', 'hoot-du' ), '<strong>', '</strong>', '<br />' ),
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Complete %1$sStyle %2$sCustomization%3$s', 'hoot-du' ), '<br />', '<strong>', '</strong>' ),
		'desc' => esc_html__( 'Different looks and styles. Choose from an extensive range of customization features in Hoot Du Premium to setup your own unique front page. Give youe site the personality it deserves.', 'hoot-du' ),
		// 'img' => $imagepath . 'premium-style.jpg',
		'style' => 'hero-top',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( 'Unlimited Colors &amp; Backgrounds for Sections', 'hoot-du' ),
		'desc' => esc_html__( 'Hoot Du Premium lets you select unlimited colors for different parts of your site. Select pre-existing backgrounds for site sections like topbar, header, footer, page title etc. or upload your own background images/patterns.', 'hoot-du' ),
		'img' => $imagepath . 'premium-colors.jpg',
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Fonts and %1$sTypography Control%2$s', 'hoot-du' ), '<span>', '</span>' ),
		'desc' => esc_html__( 'Assign different typography (fonts, text size, font color) to menu, topbar, logo, content headings, sidebar, footer etc.', 'hoot-du' ),
		'img' => $imagepath . 'premium-typography.jpg',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( 'Unlimites Sliders, Unlimites Slides', 'hoot-du' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Hoot Du Premium allows you to create unlimited sliders with as many slides as you need using the awesome HootKit plugin.%1$s%2$sAdd as Shortcodes%3$sYou can use these sliders on your Frontpage, or add them anywhere using shortcodes - like in your Posts, Sidebars or Footer.', 'hoot-du' ), '<hr>', '<h4>', '</h4>' ),
		'img' => $imagepath . 'premium-sliders.jpg',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( '600+ Google Fonts', 'hoot-du' ),
		'desc' => esc_html__( "With the integrated Google Fonts library, you can find the fonts that match your site's personality, and there's over 600 options to choose from.", 'hoot-du' ),
		'img' => $imagepath . 'premium-googlefonts.jpg',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( 'Image Carousels', 'hoot-du' ),
		'desc' => esc_html__( 'Add carousels to your post, in your sidebar, on your frontpage or in your footer. A simple drag and drop interface allows you to easily create and manage carousels.', 'hoot-du' ),
		'img' => $imagepath . 'premium-carousels.jpg',
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Floating %1$s%2$s\'Sticky\' Header%3$s &amp; %4$s\'Goto Top\'%5$s button (optional)', 'hoot-du' ), '<br>', '<span>', '</span>', '<span>', '</span>' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'The floating header follows the user down your page as they scroll, which means they never have to scroll back up to access your navigation menu, improving user experience.%1$sOr, use the \'Goto Top\' button appears on the screen when users scroll down your page, giving them a quick way to go back to the top of the page.', 'hoot-du' ), '<hr>' ),
		'img' => $imagepath . 'premium-header-top.jpg',
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'One Page %1$sScrolling Website /%2$s %3$sLanding Page%4$s', 'hoot-du' ), '<span>', '</span>', '<span>', '</span>' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Make One Page websites with menu items linking to different sections on the page. Watch the scroll animation kick in when a user clicks a menu item to jump to a page section.%1$sCreate different landing pages on your site. Change the menu for each page so that the menu items point to sections of the page being displayed.', 'hoot-du' ), '<hr>' ),
		'img' => $imagepath . 'premium-scroller.jpg',
		'style' => 'side',
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Additional Blog Layouts (including pinterest %1$stype mosaic)%2$s', 'hoot-du' ), '<span>', '</span>' ),
		'desc' => esc_html__( 'Hoot Du Premium gives you the option to display your post archives in different layouts including a mosaic type layout similar to pinterest.', 'hoot-du' ),
		'img' => $imagepath . 'premium-blogstyles.jpg',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( 'Custom Widgets', 'hoot-du' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Additional Hootkit Custom widgets crafted and designed specifically for Hoot Du Premium Theme to give you the flexibility of adding stylized content -%1$s Buttons, Carousel Sliders, Carousel Posts Slider, Contact Info, Icon Lists, Notices, Number Blocks, Tabs, Toggles and Vcards among others.', 'hoot-du' ), '<hr>' ),
		'img' => $imagepath . 'premium-widgets.jpg',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( 'Menu Icons', 'hoot-du' ),
		'desc' => esc_html__( 'Select from over 500 icons for your main navigation menu links.', 'hoot-du' ),
		'img' => $imagepath . 'premium-menuicons.jpg',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( 'Premium Background Patterns (CC0)', 'hoot-du' ),
		'desc' => esc_html__( 'Hoot Du Premium comes with many additional premium background patterns. You can always upload your own background image/pattern to match your site design.', 'hoot-du' ),
		// 'img' => $imagepath . 'premium-backgrounds.jpg',
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Automatic Image Lightbox and %1$sWordPress Gallery%2$s', 'hoot-du' ), '<span>', '</span>' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Automatically open image links on your site with the integrates lightbox in Hoot Du Premium.%1$sAutomatically convert standard WordPress galleries to beautiful lightbox gallery slider.', 'hoot-du' ), '<hr>' ),
		'img' => $imagepath . 'premium-lightbox.jpg',
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Developers %1$slove {LESS}', 'hoot-du' ), '<br />' ),
		'desc' => esc_html__( 'CSS is passe! Developers love the modularity and ease of using LESS, which is why Hoot Du Premium comes with properly organized LESS files for the main stylesheet.', 'hoot-du' ),
		'img' => $imagepath . 'premium-lesscss.jpg',
		);

	$hootdu_options_premium[] = array(
		'name' => esc_html__( 'Easy Import/Export', 'hoot-du' ),
		'desc' => esc_html__( 'Moving to a new host? Or applying a new child theme? Easily import/export your customizer settings with just a few clicks - right from the backend.', 'hoot-du' ),
		// 'img' => $imagepath . 'premium-import-export.jpg',
		);

	$hootdu_options_premium[] = array(
		'style' => 'aside',
		'blocks' => array(
			array(
				/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
				'name' => sprintf( esc_html__( 'Custom Javascript &amp; %1$sGoogle Analytics%2$s', 'hoot-du' ), '<span>', '</span>' ),
				'desc' => esc_html__( 'Easily insert any javascript snippet to your header without modifying the code files. This helps in adding scripts for Google Analytics, Adsense or any other custom code.', 'hoot-du' ),
				// 'img' => $imagepath . 'premium-customjs.jpg',
				),
			array(
				/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
				'name' => sprintf( esc_html__( 'Continued %1$sLifetime Updates', 'hoot-du' ), '<br />' ),
				'desc' => esc_html__( 'You will help support the continued development of Hoot Du - ensuring it works with future versions of WordPress for years to come.', 'hoot-du' ),
				// 'img' => $imagepath . 'premium-updates.jpg',
				),
			),
		);

	$hootdu_options_premium[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Premium %1$sPriority Support', 'hoot-du' ), '<br />' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Need help setting up Hoot Du? Upgrading to Hoot Du Premium gives you prioritized support. We have a growing support team ready to help you with your questions.%1$sNeed small modifications? If you are not a developer yourself, you can count on our support staff to help you with CSS snippets to get the look you are after. Best of all, your changes will persist across updates.', 'hoot-du' ), '<hr>' ),
		'img' => $imagepath . 'premium-support.jpg',
		'style' => 'side',
		);

	?>
	<div id="hootdu-upsell" class="wrap">
		<h1 class="centered"><?php echo $hootdu_intro['name']; ?></h1>
		<p class="hootdu-upsell-intro centered"><?php echo $hootdu_intro['desc']; ?></p>
		<p class="hootdu-upsell-cta centered"><?php if ( !empty( $hootdu_cta_demo ) ) echo $hootdu_cta_demo; echo $hootdu_cta_top; ?></p>
		<?php if ( !empty( $hootdu_options_premium ) && is_array( $hootdu_options_premium ) ): ?>
			<div class="hootdu-upsell-sub">
				<?php foreach ( $hootdu_options_premium as $key => $feature ) : ?>
					<?php $style = empty( $feature['style'] ) ? 'info' : $feature['style']; ?>
					<div class="section-premium <?php
						if ( $style == 'hero-top' || $style == 'hero-bottom' ) echo "premium-hero premium-{$style}";
						elseif ( $style == 'side' ) echo 'premium-sideinfo';
						elseif ( $style == 'aside' ) echo 'premium-asideinfo';
						else echo "premium-{$style}";
						?>">

						<?php if ( $style == 'hero-top' || $style == 'hero-bottom' ) : ?>
							<?php if ( $style == 'hero-top' ) : ?>
								<h4 class="heading"><?php echo $feature['name']; ?></h4>
								<?php if ( !empty( $feature['desc'] ) ) echo '<div class="premium-hero-text">' . $feature['desc'] . '</div>'; ?>
							<?php endif; ?>
							<?php if ( !empty( $feature['img'] ) ) : ?>
								<div class="premium-hero-img">
									<img src="<?php echo esc_url( $feature['img'] ); ?>" />
								</div>
							<?php endif; ?>
							<?php if ( $style == 'hero-bottom' ) : ?>
								<h4 class="heading"><?php echo $feature['name']; ?></h4>
								<?php if ( !empty( $feature['desc'] ) ) echo '<div class="premium-hero-text">' . $feature['desc'] . '</div>'; ?>
							<?php endif; ?>

						<?php elseif ( $style == 'side' ) : ?>
							<div class="premium-side-wrap">
								<div class="premium-side-img">
									<img src="<?php echo esc_url( $feature['img'] ); ?>" />
								</div>
								<div class="premium-side-textblock">
									<?php if ( !empty( $feature['name'] ) ) : ?>
										<h4 class="heading"><?php echo $feature['name']; ?></h4>
									<?php endif; ?>
									<?php if ( !empty( $feature['desc'] ) ) echo '<div class="premium-side-text">' . $feature['desc'] . '</div>'; ?>
								</div>
								<div class="clear"></div>
							</div>

						<?php elseif ( $style == 'aside' ) : ?>
							<?php if ( !empty( $feature['blocks'] ) ) : ?>
								<div class="premium-aside-wrap">
								<?php foreach ( $feature['blocks'] as $key => $block ) {
									echo '<div class="premium-aside-block premium-aside-'.($key+1).'">';
										if ( !empty( $block['img'] ) ) : ?>
											<div class="premium-aside-img">
												<img src="<?php echo esc_url( $block['img'] ); ?>" />
											</div>
										<?php endif;
										if ( !empty( $block['name'] ) ) : ?>
											<h4 class="heading"><?php echo $block['name']; ?></h4>
										<?php endif;
										if ( !empty( $block['desc'] ) ) echo '<div class="premium-aside-text">' . $block['desc'] . '</div>';
									echo '</div>';
								} ?>
								<div class="clear"></div>
								</div>
							<?php endif; ?>

						<?php else : ?>
							<?php if ( !empty( $feature['img'] ) ) : ?>
								<div class="premium-info-img">
									<img src="<?php echo esc_url( $feature['img'] ); ?>" />
								</div>
							<?php endif; ?>
							<div class="premium-info-textblock">
								<?php if ( !empty( $feature['name'] ) ) : ?>
									<div class="premium-info-heading"><h4 class="heading"><?php echo $feature['name']; ?></h4></div>
								<?php endif; ?>
								<?php if ( !empty( $feature['desc'] ) ) echo '<div class="premium-info-text">' . $feature['desc'] . '</div>'; ?>
								<div class="clear"></div>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
				<div class="section-premium hootdu-upsell-cta centered"><?php if ( !empty( $hootdu_cta_demo ) ) echo $hootdu_cta_demo; echo $hootdu_cta; ?></p>
			</div>
		<?php endif; ?>
		<a class="hootdu-theme-top" href="#wpbody"><span class="dashicons dashicons-arrow-up-alt"></span></a>
	</div>
	<?php
}