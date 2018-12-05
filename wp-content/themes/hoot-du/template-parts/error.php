<article <?php hootdu_attr( 'post' ); ?>>

	<?php if ( apply_filters ( 'hootdu_theme_display_404_title', true ) ) : ?>
		<header class="entry-header">
			<?php
			$loop_meta_displayed = hootdu_data( 'loop_meta_displayed' );
			$tag = ( $loop_meta_displayed ) ? 'h2' : 'h1';
			echo "<{$tag} class='entry-title'>" . esc_html__( 'Nothing found', 'hoot-du' ) . "</{$tag}>";
			?>
		</header><!-- .entry-header -->
	<?php endif; ?>

	<div <?php hootdu_attr( 'entry-content', '', 'no-shadow' ); ?>>
		<div class="entry-the-content">
			<?php do_action( 'hootdu_theme_404_content' ); ?>
		</div>
	</div><!-- .entry-content -->

</article><!-- .entry -->