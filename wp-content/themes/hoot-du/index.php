<?php
/**
 * This is the most generic template file in a WordPress theme
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the blog posts index page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

// Loads the header.php template.
get_header();
?>

<?php
// Dispay Loop Meta at top
hootdu_theme_add_custom_title_content( 'pre', 'index.php' );
if ( hootdu_theme_titlearea_top() ) {
	hootdu_theme_loopmeta_header_img( 'index', false );
	get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
	hootdu_theme_add_custom_title_content( 'post', 'index.php' );
} else {
	hootdu_theme_loopmeta_header_img( 'index', true );
}

// Template modification Hook
do_action( 'hootdu_theme_before_content_grid', 'index.php' );
?>

<div class="hgrid main-content-grid">

	<main <?php hootdu_attr( 'content' ); ?>>
		<div <?php hootdu_attr( 'content-wrap', 'index' ); ?>>

			<?php
			// Template modification Hook
			do_action( 'hootdu_theme_main_start', 'index.php' );

			// Checks if any posts were found.
			if ( have_posts() ) :

				// Dispay Loop Meta in content wrap
				if ( ! hootdu_theme_titlearea_top() ) {
					hootdu_theme_add_custom_title_content( 'post', 'index.php' );
					get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
				}

				// Template modification Hook
				do_action( 'hootdu_theme_loop_start', 'index.php' );

				// Begins the loop through found posts, and load the post data.
				while ( have_posts() ) : the_post();

					// Loads the template-parts/content-{$post_type}.php template.
					hootdu_get_content_template();

				// End found posts loop.
				endwhile;

				// Template modification Hook
				do_action( 'hootdu_theme_loop_end', 'index.php' );

				// Template modification Hook
				do_action( 'hootdu_theme_before_loop_nav', 'index.php' );

				// Loads the template-parts/loop-nav.php template.
				get_template_part( 'template-parts/loop-nav' );

			// If no posts were found.
			else :

				// Loads the template-parts/error.php template.
				get_template_part( 'template-parts/error' );

			// End check for posts.
			endif;

			// Template modification Hook
			do_action( 'hootdu_theme_main_end', 'index.php' );
			?>

		</div><!-- #content-wrap -->
	</main><!-- #content -->

	<?php hootdu_get_sidebar( 'primary' ); // Loads the template-parts/sidebar-primary.php template. ?>

</div><!-- .main-content-grid -->

<?php get_footer(); // Loads the footer.php template. ?>