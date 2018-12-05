<?php

// Template modification Hook
do_action( 'hootdu_theme_before_menu', 'secondary');

if ( has_nav_menu( 'hoot-secondary-menu' ) ) : // Check if there's a menu assigned to the 'secondary' location.

	?>
	<div class="screen-reader-text"><?php esc_html_e( 'Secondary Navigation Menu', 'hoot-du' ); ?></div>
	<nav <?php hootdu_attr( 'menu', 'secondary' ); ?>>
		<div class="menu-toggle"><span class="menu-toggle-text"><?php esc_html_e( 'Menu', 'hoot-du' ); ?></span><i class="fas fa-bars"></i></div>

		<?php
		/* Create Menu Args Array */
		$menu_args = array(
			'theme_location'  => 'hoot-secondary-menu',
			'container'       => false,
			'menu_id'         => 'menu-secondary-items',
			'menu_class'      => 'menu-items sf-menu menu menu-highlight',
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

		/* Display Main Menu */
		wp_nav_menu( $menu_args ); ?>

	</nav><!-- #menu-secondary -->
	<?php

endif; // End check for menu.

// Template modification Hook
do_action( 'hootdu_theme_after_menu', 'secondary');