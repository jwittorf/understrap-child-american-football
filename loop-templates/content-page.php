<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="container">
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="d-flex align-items-center position-relative mb-5">
		<?php echo get_the_post_thumbnail( $post->ID, 'post-thumbnail', array( 'class' => 'w-100' ) ); ?>

		<header class="entry-header px-3 mb-0 <?php echo (has_post_thumbnail()) ? 'position-absolute' : '' ?>" style="bottom: 0;">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

	</div>

	<div class="entry-content">

		<?php
		the_content();
		understrap_link_pages();
		?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
</div><!-- .container -->