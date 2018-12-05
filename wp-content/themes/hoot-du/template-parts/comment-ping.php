<li <?php hootdu_attr( 'comment' ); ?>>

	<header class="comment-meta comment-ping">
		<cite <?php hootdu_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite>
		<br />
		<div class="comment-meta-block">
			<time <?php hootdu_attr( 'comment-published' ); ?>><?php $d = apply_filters( 'comment_date_format', '' ); echo esc_html( get_comment_date( $d ) ); ?></time>
		</div>
		<div class="comment-meta-block">
			<a <?php hootdu_attr( 'comment-permalink' ); ?>><?php esc_html_e( 'Permalink', 'hoot-du' ); ?></a>
		</div>
		<?php edit_comment_link(); ?>
	</header><!-- .comment-meta -->

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>