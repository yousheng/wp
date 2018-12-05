<?php
// Let child theme modify template structure
do_action( 'hootdu_theme_frontpage' );

// Loads the header.php template.
get_header();

// Template modification Hook
do_action( 'hootdu_theme_before_content_grid', 'frontpage.php' );
?>

<div <?php hootdu_attr( 'frontpage-grid' ); ?>">

	<main <?php hootdu_attr( 'frontpage-content' ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hootdu_theme_main_start', 'frontpage.php' );

		// Display Header Image
		if ( get_header_image() ) :
			?><div id="fp-header-image" class="hgrid-stretch">
				<img src="<?php header_image(); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div><?php
		endif;

		// Get Sections List
		$sections = hootdu_sortlist( hootdu_get_mod( 'frontpage_sections' ) );

		// Display Each Section according to ther sort order.
		if ( is_array( $sections ) && !empty( $sections ) ) :
			foreach ( $sections as $key => $section ) :
				if ( empty( $section[ 'sortitem_hide' ] ) ):

					// Set section type / context
					$context = ( strpos( $key, 'area_' ) === 0 ) ? str_replace( 'area_', '', $key ) : '';
					if ( ! empty( $context ) )
						$type = 'widgetarea';
					elseif ( $key == 'content' )
						$type = ( is_home() ) ? 'content-blog' : 'content-page';
					else
						$type = $key;
					$type = apply_filters( 'hootdu_theme_frontpage_sections_switch', $type, $key, $sections );

					// Exit the loop except main content for a paged post list (blog)
					if ( $type != 'content-blog' && apply_filters( 'hootdu_theme_paged_frontpage_hidemodules', is_paged() ) )
						continue;

					// Set section background
					$module_bg = hootdu_get_mod( "frontpage_sectionbg_{$key}-type" );
					$module_bg = ( empty( $module_bg ) ) ? 'none' : $module_bg;
					$section_class = 'module-bg-' . $module_bg;
					$section_class .= ( !empty( $section['grid'] ) && $section['grid'] == 'stretch' ) ? ' frontpage-area-stretch' : ' frontpage-area-boxed';

					// Allow child themes to have templates
					$custom_template = hootdu_get_template_part( 'front-page-' . $key, $context );
					if ( $custom_template ):
						include( $custom_template );
					else:

						switch( $type ):

							// Display Widget Areas
							case 'widgetarea':
								$areakey = 'area_' . $context;
								$section['columns'] = isset( $section['columns'] ) ? $section['columns'] : '100';
								$structure = hootdu_theme_get_column_span( $section['columns'] );
								$count = count( $structure );
								$displayarea = false;
								for ( $c = 1; $c <= $count ; $c++ ) {
									if ( is_active_sidebar( "hoot-frontpage-{$areakey}_{$c}" ) ) {
										$displayarea = true;
										break;
									}
								}
								if ( $displayarea ) : ?>
									<div id="frontpage-<?php echo sanitize_html_class( $areakey ); ?>" <?php hootdu_attr( 'frontpage-area', $areakey, 'frontpage-area frontpage-widgetarea ' . esc_attr( $section_class ) ); ?>>
										<div class="hgrid">
											<?php
											for ( $c = 1; $c <= $count ; $c++ ) {
												$area_id = "frontpage-{$areakey}_{$c}";
												$structurekey = $c - 1;
												?>
												<div id="<?php echo sanitize_html_class( $area_id ); ?>" class="<?php if ( !empty( $structure[$structurekey] ) ) echo sanitize_html_class( $structure[$structurekey] ); ?>">
													<?php
													if ( is_active_sidebar( 'hoot-' . $area_id ) )
														dynamic_sidebar( 'hoot-' . $area_id );
													?>
												</div>
												<?php
											}
											?>
										</div>
									</div>
								<?php endif;
								break;

							// Display Blog Content
							case 'content-blog':
								wp_reset_postdata(); ?>
								<div id="frontpage-page-content" <?php hootdu_attr( 'frontpage-area', $key, 'frontpage-area frontpage-pagecontent ' . esc_attr( $section_class ) ); ?>>
									<?php
									if ( !empty( $section['title'] ) )
										echo '<div class="hgrid frontpage-page-content-title"><div class="hgrid-span-12"><h3 class="hootdu-blogposts-title">' . wp_kses_post( $section['title'] ) . '</h3></div></div>';
									?>

									<div class="hgrid hootdu-blogposts main-content-grid">

										<div <?php hootdu_attr( 'content' ); ?>>
											<div <?php hootdu_attr( 'content-wrap', 'frontpage-blog' ); ?>>

												<?php
												if ( have_posts() ) :

													// Template modification Hook
													do_action( 'hootdu_theme_loop_start', 'frontpage.php' );

													while ( have_posts() ) : the_post();
														// Loads the template-parts/content-{$post_type}.php template.
														hootdu_get_content_template();
													endwhile;

													// Template modification Hook
													do_action( 'hootdu_theme_loop_end', 'frontpage.php' );

													// Loads the template-parts/loop-nav.php template.
													get_template_part( 'template-parts/loop-nav' );

												else :
													// Loads the template-parts/error.php template.
													get_template_part( 'template-parts/error' );
												endif;
												?>

											</div><!-- #content-wrap -->
										</div><!-- #content -->

										<?php hootdu_get_sidebar( 'primary' ); ?>

									</div><!-- .main-content-grid -->
								</div>

								<?php break;

							// Display Page Content
							case 'content-page':
								wp_reset_postdata(); ?>
								<div id="frontpage-page-content" <?php hootdu_attr( 'frontpage-area', $key, 'frontpage-area frontpage-pagecontent ' . esc_attr( $section_class ) ); ?>>
									<?php
									if ( !empty( $section['title'] ) )
										echo '<div class="hgrid frontpage-page-content-title"><div class="hgrid-span-12"><h3 class="hootdu-blogposts-title">' . wp_kses_post( $section['title'] ) . '</h3></div></div>';
									?>

									<div class="hgrid main-content-grid">

										<div <?php hootdu_attr( 'content' ); ?>>
											<div <?php hootdu_attr( 'content-wrap', 'frontpage-page', 'entry-content' ); ?>>
												<?php
												// Load the static page content
												while ( have_posts() ) : the_post();
													hootdu_get_content_template();
												endwhile;
												?>
											</div><!-- #content-wrap -->
										</div><!-- #content -->

										<?php hootdu_get_sidebar( 'primary' ); ?>

									</div><!-- .main-content-grid -->
								</div>

								<?php break;

							default:
								// Allow mods to display content
								do_action( 'hootdu_theme_frontpage_sections', $type, $sections, $section_class, $context );

						endswitch;

					endif;

				endif;
			endforeach;
		endif;

		// Template modification Hook
		do_action( 'hootdu_theme_main_end', 'frontpage.php' );
		?>

	</main><!-- #frontpage-content -->

	<?php
	// Template modification Hook
	do_action( 'hootdu_theme_after_main', 'frontpage.php' );
	?>

</div><!-- .frontpage-grid -->

<?php get_footer(); // Loads the footer.php template. ?>