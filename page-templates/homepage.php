<?php
/**
 * Template Name: Home Page
 *
 * Template for displaying a page with specialized content.
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );

if ( is_front_page() ) {
	get_template_part( 'global-templates/hero' );
}
?>

	<div class="wrapper" id="full-width-page-wrapper">

		<div class="<?php echo esc_attr( $container ); ?>" id="content">

			<div class="row">

				<div class="col-md-12 content-area" id="primary">

					<main class="site-main" id="main" role="main">

						<?php
						$homepage_slider_posts = new WP_Query(
							array(
								'category_name' => 'homepage-slider'
							)
						);
						while ( $homepage_slider_posts->have_posts() ) {
							$homepage_slider_posts->the_post();
//							get_template_part( 'loop-templates/content', 'posts' );
							get_template_part( 'loop-templates/hero', 'homepage-slider-posts' );
						}
						?>

					</main><!-- #main -->

				</div><!-- #primary -->

			</div><!-- .row end -->

		</div><!-- #content -->

	</div><!-- #full-width-page-wrapper -->

<?php
get_footer();
