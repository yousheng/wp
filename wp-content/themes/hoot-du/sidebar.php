<?php

// Dispay Sidebar if not a one-column layout
$sidebar_size = hootdu_theme_layout( 'sidebar' );
if ( !empty( $sidebar_size ) ) :
?>

	<aside <?php hootdu_attr( 'sidebar', 'primary' ); ?>>
		<div <?php hootdu_attr( 'sidebar-wrap', 'primary' ); ?>>

			<?php

			// Template modification Hook
			do_action( 'hootdu_theme_sidebar_start', 'primary' );

			if ( is_active_sidebar( 'hoot-primary-sidebar' ) ) : // If the sidebar has widgets.

				dynamic_sidebar( 'hoot-primary-sidebar' ); // Displays the primary sidebar.

			elseif ( current_user_can( 'edit_theme_options' ) ) : // If the sidebar has no widgets.

				the_widget(
					'WP_Widget_Text',
					array(
						'title'  => __( 'Example Widget', 'hoot-du' ),
						/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
						'text'   => sprintf( __( 'This is an example widget to show how the Primary sidebar looks by default. You can add custom widgets from the %1$swidgets screen%2$s in wp-admin.<br /><br />(This widget is only displayed to logged in administrators when there is no widget in the sidebar. Your visitors will not see this text.)', 'hoot-du' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ),
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
			do_action( 'hootdu_theme_sidebar_end', 'primary' );

			?>

		</div><!-- .sidebar-wrap -->
	</aside><!-- #sidebar-primary -->

	<?php
	// Display second sidebar if its a 2 column layout
	$currentlayout = hootdu_data( 'currentlayout', 'layout' );
	if ( $currentlayout == 'narrow-left-left' || $currentlayout == 'narrow-left-right' || $currentlayout == 'narrow-right-right' ) :
	?>

		<aside <?php hootdu_attr( 'sidebar', 'secondary' ); ?>>
			<div <?php hootdu_attr( 'sidebar-wrap', 'secondary' ); ?>>

				<?php

				// Template modification Hook
				do_action( 'hootdu_theme_sidebar_start', 'secondary' );

				if ( is_active_sidebar( 'hoot-secondary-sidebar' ) ) : // If the sidebar has widgets.

					dynamic_sidebar( 'hoot-secondary-sidebar' ); // Displays the secondary sidebar.

				elseif ( current_user_can( 'edit_theme_options' ) ) : // If the sidebar has no widgets.

					the_widget(
						'WP_Widget_Text',
						array(
							'title'  => __( 'Example Widget', 'hoot-du' ),
							/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
							'text'   => sprintf( __( 'This is an example widget to show how the Secondary sidebar looks by default. You can add custom widgets from the %1$swidgets screen%2$s in wp-admin.<br /><br />(This widget is only displayed to logged in administrators when there is no widget in the sidebar. Your visitors will not see this text.)', 'hoot-du' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ),
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
				do_action( 'hootdu_theme_sidebar_end', 'secondary' );

				?>

			</div><!-- .sidebar-wrap -->
		</aside><!-- #sidebar-secondary -->

	<?php
	endif;
	?>

<?php
endif; // End layout check.