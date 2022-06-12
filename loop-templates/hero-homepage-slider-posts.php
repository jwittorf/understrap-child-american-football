<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="carousel-item <?php echo ( 1 === $args[ "counter" ] ) ? 'active' : null ?>">
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<div class="d-flex align-items-center">
			<!-- Post image -->
			<?php echo get_the_post_thumbnail( $post->ID, 'post-thumbnail', array( 'class' => 'w-100' ) ); ?>
			<header class="entry-header px-3 mb-0 position-absolute" style="bottom: 0;">
				<?php the_title('<h2 class="h1 entry-title">', '</h2>'); ?>
			</header><!-- .entry-header -->
		</div><!-- .d-flex -->

	</article><!-- #post-## -->
</div>