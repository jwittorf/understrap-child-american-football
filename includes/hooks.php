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

function add_menu_link_class( $atts, $item, $args ) {
	if (property_exists($args, 'link_class')) {
		$atts['class'] = $args->link_class;
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );

function understrap_child_filter_the_content( $content ) {
	$search = "canes";
	$replace = "<span class='text-secondary'>canes</span>";
	return str_replace( $search, $replace, $content );
}
// too bad, got mixed up then replacing text in HTML links
//add_filter( 'the_content', 'understrap_child_filter_the_content' );
//add_filter( 'the_excerpt', 'understrap_child_filter_the_content' );