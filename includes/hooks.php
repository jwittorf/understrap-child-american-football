<?php
/**
 * Custom hooks
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function exclude_category( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$query->set( 'category_name', 'news' );
	}
}
add_action( 'pre_get_posts', 'exclude_category' );