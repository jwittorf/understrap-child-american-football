<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function understrap_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on   = apply_filters(
		'understrap_posted_on',
		sprintf(
			'<span class="posted-on">%1$s</span>',
			apply_filters( 'understrap_posted_on_time', $time_string )
		)
	);
	echo $posted_on; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display navigation to next/previous post when applicable.
 */
function understrap_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="container navigation post-navigation mt-4">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'understrap' ); ?></h2>
		<div class="d-flex nav-links justify-content-between">
			<?php
			if ( get_previous_post_link() ) {
				previous_post_link( '<span class="nav-previous btn btn-outline-primary btn-lg">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'understrap' ) );
			}
			if ( get_next_post_link() ) {
				next_post_link( '<span class="nav-next btn btn-outline-primary btn-lg">%link</span>', _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'understrap' ) );
			}
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}