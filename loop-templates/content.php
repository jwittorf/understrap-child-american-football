<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="container">

	<article <?php post_class( 'mb-5' ); ?> id="post-<?php the_ID(); ?>">

	<div class="position-relative">
		<?php echo get_the_post_thumbnail( $post->ID ); ?>
		<header class="entry-header px-3 mb-0 <?php echo (has_post_thumbnail()) ? 'position-absolute' : '' ?>"
		        style="bottom: 0;">
			<?php the_title( '<h2 class="h1 entry-title">','</h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

			<?php endif; ?>
		</header><!-- .entry-header -->
	</div>

	<div class="entry-content p-3">
		<?php
		the_excerpt();
		// understrap_link_pages();
		?>
	</div><!-- .entry-content -->

	</article><!-- #post-## -->
</div><!-- .container -->