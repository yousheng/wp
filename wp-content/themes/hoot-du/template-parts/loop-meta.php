<?php
/**
 * Template modification Hooks
 */
$display_loop_meta = apply_filters( 'hootdu_theme_display_loop_meta', true );
do_action( 'hootdu_theme_loop_meta', 'start' );

if ( !$display_loop_meta )
	return;

/**
 * If viewing a multi post page 
 */
if ( !is_front_page() && !is_singular() ) :

	$display_title = apply_filters( 'hootdu_theme_loop_meta_display_title', true, 'plural' );
	if ( $display_title !== 'hide' ) :

		// Display Featured Image in header if present (static/parallax)
		$wrap_attr = hootdu_data( 'loop-meta-wrap' );
		hootdu_unset_data( 'loop-meta-wrap' );
		?>

		<div <?php hootdu_attr( 'loop-meta-wrap', 'archive', $wrap_attr ); ?>>
			<div class="hgrid">

				<div <?php hootdu_attr( 'loop-meta', 'archive', 'hgrid-span-12' ); ?>>

					<h1 <?php hootdu_attr( 'loop-title', 'archive' ); ?>><?php echo wp_kses_post( get_the_archive_title() ); // Displays title for archive type (multi post) pages. ?></h1>

					<?php if ( $desc = get_the_archive_description() ) : ?>
						<div <?php hootdu_attr( 'loop-description', 'archive' ); ?>>
							<?php echo wp_kses_post( $desc ); // Displays description for archive type (multi post) pages. ?>
						</div><!-- .loop-description -->
					<?php endif; // End paged check. ?>

				</div><!-- .loop-meta -->

			</div>
		</div>

	<?php
	hootdu_set_data( 'loop_meta_displayed', true );
	endif;

/**
 * If viewing a single post/page
 */
elseif ( is_singular() ) :

	if ( have_posts() ) :

		// Begins the loop through found posts, and load the post data.
		while ( have_posts() ) : the_post();

			$display_title = apply_filters( 'hootdu_theme_loop_meta_display_title', '', 'singular' );
			if ( $display_title !== 'hide' ) :

				// Display Featured Image in header if present (static/parallax)
				$wrap_attr = hootdu_data( 'loop-meta-wrap' );
				hootdu_unset_data( 'loop-meta-wrap' );
				?>

				<div <?php hootdu_attr( 'loop-meta-wrap', 'singular', $wrap_attr ); ?>>
					<div class="hgrid">

						<div <?php hootdu_attr( 'loop-meta', '', 'hgrid-span-12' ); ?>>
							<div class="entry-header">

								<?php
								global $post;
								$pretitle = ( !isset( $post->post_parent ) || empty( $post->post_parent ) ) ? '' : '<span class="loop-pretitle">' . get_the_title( $post->post_parent ) . ' &raquo; </span>';
								$pretitle = apply_filters( 'hootdu_theme_singular_loop_pretitle', $pretitle );
								?>
								<h1 <?php hootdu_attr( 'loop-title' ); ?>><?php the_title( $pretitle ); ?></h1>

								<?php
								$hide_meta_info = apply_filters( 'hootdu_theme_hide_meta', false, 'top' );
								if ( !$hide_meta_info && 'top' == hootdu_get_mod( 'post_meta_location' ) && !is_attachment() ):
									$metarray = ( is_page() ) ? hootdu_get_mod('page_meta') : hootdu_get_mod('post_meta');
									if ( hootdu_theme_meta_info( $metarray, 'loop-meta', true ) ) :
										?><div <?php hootdu_attr( 'loop-description' ); ?>><?php
											hootdu_theme_display_meta_info( $metarray, 'loop-meta' );
										?></div><!-- .loop-description --><?php
									endif;
								endif;
								?>

							</div><!-- .entry-header -->
						</div><!-- .loop-meta -->

					</div>
				</div>

			<?php
			hootdu_set_data( 'loop_meta_displayed', true );
			endif;

		endwhile;
		rewind_posts();

	endif;

endif;

/**
 * Template modification Hooks
 */
do_action( 'hootdu_theme_loop_meta', 'end' );