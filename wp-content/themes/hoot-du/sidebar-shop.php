<?php

// Dispay Sidebar if not a one-column layout
$sidebar_size = hootdu_theme_layout( 'primary-sidebar' );
if ( !empty( $sidebar_size ) ) :
?>

	<aside <?php hootdu_attr( 'sidebar', 'primary' ); ?>>

		<?php

		// Template modification Hook
		do_action( 'hootdu_theme_sidebar_start', 'shop' );

		if ( is_active_sidebar( 'hoot-woo-sidebar-primary' ) ) : // If the sidebar has widgets.

			dynamic_sidebar( 'hoot-woo-sidebar-primary' ); // Displays the woocommerce sidebar.

		elseif ( current_user_can( 'edit_theme_options' ) ) : // If the sidebar has no widgets.

			the_widget(
				'WP_Widget_Text',
				array(
					'title'  => __( 'Woocommerce Sidebar', 'hoot-du' ),
					/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
					'text'   => sprintf( __( 'Woocommerce pages have a separate sidebar than the rest of your site. You can add custom widgets from the %1$swidgets screen%2$s in wp-admin.<br /><br />(This widget is only displayed to logged in administrators when there is no widget in the sidebar. Your visitors will not see this text.)', 'hoot-du' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ),
					'filter' => true,
				),
				array(
					'before_widget' => '<section class="widget widget_text">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title"><span>',
					'after_title'   => '</span></h3>'
				)
			);

		endif; // End widgets check.

		// Template modification Hook
		do_action( 'hootdu_theme_sidebar_end', 'shop' );

		?>

	</aside><!-- #sidebar-primary -->

	<?php
	// Display second sidebar if its a 2 column layout
	$currentlayout = hootdu_data( 'currentlayout', 'layout' );
	if ( $currentlayout == 'narrow-left-left' || $currentlayout == 'narrow-left-right' || $currentlayout == 'narrow-right-right' ) :
	?>

		<aside <?php hootdu_attr( 'sidebar', 'secondary' ); ?>>

			<?php

			// Template modification Hook
			do_action( 'hootdu_theme_sidebar_start', 'shop-secondary' );

			if ( is_active_sidebar( 'hoot-woo-sidebar-secondary' ) ) : // If the sidebar has widgets.

				dynamic_sidebar( 'hoot-woo-sidebar-secondary' ); // Displays the woocommerce sidebar.

			elseif ( current_user_can( 'edit_theme_options' ) ) : // If the sidebar has no widgets.

				the_widget(
					'WP_Widget_Text',
					array(
						'title'  => __( 'Woocommerce Sidebar', 'hoot-du' ),
						/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
						'text'   => sprintf( __( 'Woocommerce pages have a separate sidebar than the rest of your site. You can add custom widgets from the %1$swidgets screen%2$s in wp-admin.<br /><br />(This widget is only displayed to logged in administrators when there is no widget in the sidebar. Your visitors will not see this text.)', 'hoot-du' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ),
						'filter' => true,
					),
					array(
						'before_widget' => '<section class="widget widget_text">',
						'after_widget'  => '</section>',
						'before_title'  => '<h3 class="widget-title"><span>',
						'after_title'   => '</span></h3>'
					)
				);

			endif; // End widgets check.

			// Template modification Hook
			do_action( 'hootdu_theme_sidebar_end', 'shop-secondary' );

			?>

		</aside><!-- #sidebar-secondary -->

	<?php
	endif;
	?>

<?php
endif; // End layout check.