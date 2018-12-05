<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">

<head>
<?php
// Fire the wp_head action required for hooking in scripts, styles, and other <head> tags.
wp_head();
?>
</head>

<body <?php hootdu_attr( 'body' ); ?>>

	<?php
	// Display Topbar
	get_template_part( 'template-parts/topbar' );
	?>

	<div <?php hootdu_attr( 'page-wrapper' ); ?>>

		<div class="skip-link">
			<a href="#content" class="screen-reader-text"><?php esc_html_e( 'Skip to content', 'hoot-du' ); ?></a>
		</div><!-- .skip-link -->

		<?php
		// Template modification Hook
		do_action( 'hootdu_theme_site_start' );
		?>

		<header <?php hootdu_attr( 'header' ); ?>>

			<?php
			// Display Secondary Menu
			hootdu_theme_secondary_menu( 'top' );
			?>

			<div <?php hootdu_attr( 'header-part', 'primary', 'contrast-typo' ); ?>>
				<div class="hgrid">
					<div class="table hgrid-span-12">
						<?php
						// Display Branding
						hootdu_theme_branding();

						// Display Menu
						hootdu_theme_header_aside();
						?>
					</div>
				</div>
			</div>

			<?php
			// Display Secondary Menu
			hootdu_theme_secondary_menu( 'bottom' );
			?>

		</header><!-- #header -->

		<?php hootdu_get_sidebar( 'below-header' ); // Loads the template-parts/sidebar-below-header.php template. ?>

		<div <?php hootdu_attr( 'main' ); ?>>
			<?php
			// Template modification Hook
			do_action( 'hootdu_theme_main_wrapper_start' );