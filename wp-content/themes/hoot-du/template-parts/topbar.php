<?php
// Get Content
$topbar_left = is_active_sidebar( 'hoot-topbar-left' );
$topbar_right = is_active_sidebar( 'hoot-topbar-right' );

// Template modification Hook
do_action( 'hootdu_theme_before_topbar', $topbar_left, $topbar_right );

// Display Topbar
if ( !empty( $topbar_left ) || !empty( $topbar_right ) ) :

	?>
	<div <?php hootdu_attr( 'topbar', '', 'contrast-typo inline-nav js-search hgrid-stretch' ); ?>>
		<div class="hgrid">
			<div class="hgrid-span-12">

				<div class="topbar-inner table<?php if ( !empty( $topbar_left ) && !empty( $topbar_right ) ) echo ' topbar-parts'; ?>">
					<?php if ( $topbar_left ): ?>
						<?php $topbarid = ( $topbar_right ) ? 'left' : 'center'; ?>
						<div id="topbar-<?php echo $topbarid; ?>" class="table-cell-mid topbar-part">
							<?php dynamic_sidebar( 'hoot-topbar-left' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $topbar_right ): ?>
						<?php $topbarid = ( $topbar_left ) ? 'right' : 'center'; ?>
						<div id="topbar-<?php echo $topbarid; ?>" class="table-cell-mid topbar-part">
							<?php dynamic_sidebar( 'hoot-topbar-right' ); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
	<?php

endif;

// Template modification Hook
do_action( 'hootdu_theme_after_topbar', $topbar_left, $topbar_right );