<?php 
// Loads the header.php template.
get_header();
?>

<?php
// Dispay Loop Meta at top
hootdu_theme_add_custom_title_content( 'pre', 'page.php' );
if ( hootdu_theme_titlearea_top() ) {
	hootdu_theme_loopmeta_header_img( 'page', false );
	get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
	hootdu_theme_add_custom_title_content( 'post', 'page.php' );
} else {
	hootdu_theme_loopmeta_header_img( 'page', true );
}

// Template modification Hook
do_action( 'hootdu_theme_before_content_grid', 'page.php' );
?>

<div class="hgrid main-content-grid">

	<main <?php hootdu_attr( 'content' ); ?>>
		<div <?php hootdu_attr( 'content-wrap', 'page' ); ?>>

			<?php
			// Template modification Hook
			do_action( 'hootdu_theme_main_start', 'page.php' );

			// Checks if any posts were found.
			if ( have_posts() ) :

				// Display Featured Image if present
				if ( hootdu_get_mod( 'post_featured_image_page' ) == 'content' ) {
					$img_size = apply_filters( 'hootdu_theme_page_imgsize', '', 'content' );
					hootdu_theme_post_thumbnail( 'entry-content-featured-img', $img_size, true );
				}

				// Dispay Loop Meta in content wrap
				if ( ! hootdu_theme_titlearea_top() ) {
					hootdu_theme_add_custom_title_content( 'post', 'page.php' );
					get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
				}

				// Template modification Hook
				do_action( 'hootdu_theme_loop_start', 'page.php' );

				// Begins the loop through found posts, and load the post data.
				while ( have_posts() ) : the_post();

					// Loads the template-parts/content-{$post_type}.php template.
					hootdu_get_content_template();

				// End found posts loop.
				endwhile;

				// Template modification Hook
				do_action( 'hootdu_theme_loop_end', 'page.php' );

				// Template modification Hook
				do_action( 'hootdu_theme_after_content_wrap', 'page.php' );

				// Loads the comments.php template if this page is not being displayed as frontpage or a custom 404 page or if this is attachment page of media attached (uploaded) to a page.
				if ( !is_front_page() && !is_attachment() ) :

					// Loads the comments.php template
					comments_template( '', true );

				endif;

			// If no posts were found.
			else :

				// Loads the template-parts/error.php template.
				get_template_part( 'template-parts/error' );

			// End check for posts.
			endif;

			// Template modification Hook
			do_action( 'hootdu_theme_main_end', 'page.php' );
			?>

		</div><!-- #content-wrap -->
	</main><!-- #content -->

	<?php hootdu_get_sidebar( 'primary' ); // Loads the template-parts/sidebar-primary.php template. ?>

</div><!-- .main-content-grid -->

<?php get_footer(); // Loads the footer.php template. ?>