<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="d-flex align-items-center flex-column mb-3 mb-md-5 news-hero-single">
		<?php echo get_the_post_thumbnail( $post->ID, 'post-thumbnail', array( 'class' => 'w-100' ) ); ?>

		<header class="entry-header mb-0 px-3">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	</div>

	<div class="container px-0">
	<div class="entry-content mb-2">

		<?php
		the_content();
		understrap_link_pages();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer bg-primary p-3 d-flex justify-content-between">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->
	</div><!-- .container -->

</article><!-- #post-## -->
