<?php
// Dispay Sidebar if sidebar has widgets
if ( is_active_sidebar( 'hoot-header' ) ) :

	?>
	<div <?php hootdu_attr( 'header-sidebar', '', 'inline-nav js-search hgrid-stretch' ); ?>>
		<?php

		// Template modification Hook
		do_action( 'hootdu_theme_sidebar_start', 'header-sidebar' );

		?>
		<aside <?php hootdu_attr( 'sidebar', 'header-sidebar' ); ?>>
			<?php dynamic_sidebar( 'hoot-header' ); ?>
		</aside>
		<?php

		// Template modification Hook
		do_action( 'hootdu_theme_sidebar_end', 'header-sidebar' );

		?>
	</div>
	<?php

endif;