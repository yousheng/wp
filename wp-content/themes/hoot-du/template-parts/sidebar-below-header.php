<?php
// Get Content
$below_header_left = is_active_sidebar( 'hoot-below-header-left' );
$below_header_right = is_active_sidebar( 'hoot-below-header-right' );

// Template modification Hook
do_action( 'hootdu_theme_before_below_header', $below_header_left, $below_header_right );

// Display Below Header
if ( !empty( $below_header_left ) || !empty( $below_header_right ) ) :

	?>
	<div <?php hootdu_attr( 'below-header', '', 'contrast-typo inline-nav js-search hgrid-stretch' ); ?>>
		<div class="hgrid">
			<div class="hgrid-span-12">

				<div class="below-header-inner table<?php if ( !empty( $below_header_left ) && !empty( $below_header_right ) ) echo ' below-header-parts'; ?>">
					<?php
					if ( $below_header_left ):
						$below_headerid = ( $below_header_right ) ? 'left' : 'center';

						// Template modification Hook
						do_action( 'hootdu_theme_sidebar_start', 'below-header-left', $below_headerid );
						?>

						<div id="below-header-<?php echo $below_headerid; ?>" class="below-header-part table-cell-mid">
							<?php dynamic_sidebar( 'hoot-below-header-left' ); ?>
						</div>

						<?php
						// Template modification Hook
						do_action( 'hootdu_theme_sidebar_end', 'below-header-left', $below_headerid );

					endif;
					?>

					<?php
					if ( $below_header_right ):
						$below_headerid = ( $below_header_left ) ? 'right' : 'center';

						// Template modification Hook
						do_action( 'hootdu_theme_sidebar_start', 'below-header-right', $below_headerid );
						?>

						<div id="below-header-<?php echo $below_headerid; ?>" class="below-header-part table-cell-mid">
							<?php dynamic_sidebar( 'hoot-below-header-right' ); ?>
						</div>

						<?php
						// Template modification Hook
						do_action( 'hootdu_theme_sidebar_end', 'below-header-right', $below_headerid );

					endif;
					?>
				</div>

			</div>
		</div>
	</div>
	<?php

endif;

// Template modification Hook
do_action( 'hootdu_theme_after_below_header', $below_header_left, $below_header_right );