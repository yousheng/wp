<?php
$site_info = hootdu_get_mod( 'site_info' );
if ( !empty( $site_info ) ) :
?>
	<div <?php hootdu_attr( 'post-footer', '', 'contrast-typo hgrid-stretch linkstyle' ); ?>>
		<div class="hgrid">
			<div class="hgrid-span-12">
				<p class="credit small">
					<?php
					if ( trim( $site_info ) == '<!--default-->' ) {
						printf(
							/* Translators: 1 is Privacy Policy link 2 is Theme name/link, 3 is WordPress name/link, 4 is site name/link */
							__( '%1$s Designed using %2$s. Powered by %3$s.', 'hoot-du' ),
							( function_exists( 'get_the_privacy_policy_link' ) ) ? wp_kses_post( get_the_privacy_policy_link() ) : '',
							hootdu_get_theme_link(),
							hootdu_get_wp_link(),
							hootdu_get_site_link()
						);
					} else {
						$site_info = str_replace( "<!--year-->" , date_i18n( 'Y' ) , $site_info );
						echo wp_kses_post( $site_info );
					} ?>
				</p><!-- .credit -->
			</div>
		</div>
	</div>
<?php
endif;
?>