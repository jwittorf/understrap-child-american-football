<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

</div><!-- #page we need this extra closing tag here -->

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-3" id="wrapper-footer-side">
				<?php if ( is_active_sidebar( 'footer_side' ) ) : ?>
					<?php dynamic_sidebar( 'footer_side' ); ?>
				<?php endif; ?>
			</div><!-- wrapper-footer-side end -->
			<div class="col-md-9" id="wrapper-footer-main">
				<div class="row">
					<div class="col-md-12">
						<h3>Waiting for sidebar <code>footer_main_top</code></h3>
						<?php if ( is_active_sidebar( 'footer_main_top' ) ) : ?>
							<?php dynamic_sidebar( 'footer_main_top' ); ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<?php if ( is_active_sidebar( 'footer_main_bottom_main' ) ) : ?>
							<?php dynamic_sidebar( 'footer_main_bottom_main' ); ?>
						<?php endif; ?>
					</div>
					<div class="col-md-4">
						<?php if ( is_active_sidebar( 'footer_main_bottom_side' ) ) : ?>
							<?php dynamic_sidebar( 'footer_main_bottom_side' ); ?>
						<?php endif; ?>
						<footer class="site-footer" id="colophon">

							<div class="site-info">

								<?php understrap_site_info(); ?>

							</div><!-- .site-info -->

						</footer><!-- #colophon -->
					</div>
				</div>
			</div><!-- wrapper-footer-main end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

<?php wp_footer(); ?>

</body>

</html>

