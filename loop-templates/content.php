<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="container px-0">

	<article <?php post_class( array( 'mb-3', 'mb-md-5' ) ); ?> id="post-<?php the_ID(); ?>">

	<div class="row">
		<div class="col-md-6">
			<?php echo sprintf( '<a href="%1$s" rel="bookmark" class="text-white text-decoration-none">%2$s</a>',
				esc_url( get_permalink() ),
				get_the_post_thumbnail( $post->ID )) ?>
		</div>
		<header class="entry-header px-3 mb-0 <?php echo (has_post_thumbnail()) ? 'col-md-6' : '' ?>"
		        style="bottom: 0;">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark" class="text-white text-decoration-none">',
				esc_url( get_permalink() ) ),
				'</a></h2>' )
			; ?>

			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

			<?php endif; ?>
		</header><!-- .entry-header -->
	</div>

	<div class="entry-content py-3">
		<?php
		the_excerpt();
		// understrap_link_pages();
		?>
	</div><!-- .entry-content -->

	</article><!-- #post-## -->
</div><!-- .container -->