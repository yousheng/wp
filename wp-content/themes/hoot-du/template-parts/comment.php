<li <?php hootdu_attr( 'comment' ); ?>>

	<article>
		<header class="comment-avatar">
			<?php echo get_avatar( $comment ); ?>
			<?php global $post;
			if ( $comment->user_id === $post->post_author ) { ?>
				<div class="comment-by-author"><?php esc_html_e( 'Author', 'hoot-du' ); ?></div>
			<?php } ?>
		</header><!-- .comment-avatar -->

		<div class="comment-content-wrap">

			<div <?php hootdu_attr( 'comment-content' ); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<footer class="comment-meta">
				<div class="comment-meta-block">
					<cite <?php hootdu_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite>
				</div>
				<div class="comment-meta-block">
					<time <?php hootdu_attr( 'comment-published' ); ?>><?php $d = apply_filters( 'comment_date_format', '' ); echo esc_html( get_comment_date( $d ) ); ?></time>
				</div>
				<div class="comment-meta-block">
					<a <?php hootdu_attr( 'comment-permalink' ); ?>><?php esc_html_e( 'Permalink', 'hoot-du' ); ?></a>
				</div>
				<?php if ( comments_open() ) : ?>
					<div class="comment-meta-block">
						<?php hootdu_comment_reply_link(); ?>
					</div>
				<?php endif; ?>
				<?php edit_comment_link(); ?>
			</footer><!-- .comment-meta -->

		</div><!-- .comment-content-wrap -->

	</article>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>