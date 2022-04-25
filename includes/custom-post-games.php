<?php

function custom_post_games()
{

	// Set UI labels for Custom Post Type
	$labels = array (
		'name'               => _x( 'Games', 'Post Type General Name', 'understrap_child' ),
		'singular_name'      => _x( 'Game', 'Post Type Singular Name', 'understrap_child' ),
		'menu_name'          => __( 'Games', 'understrap_child' ),
		'all_items'          => __( 'All games', 'understrap_child' ),
		'view_item'          => __( 'View game', 'understrap_child' ),
		'add_new_item'       => __( 'Add new game', 'understrap_child' ),
		'add_new'            => __( 'Add new', 'understrap_child' ),
		'edit_item'          => __( 'Edit game', 'understrap_child' ),
		'update_item'        => __( 'Update game', 'understrap_child' ),
		'search_items'       => __( 'Search game', 'understrap_child' ),
		'not_found'          => __( 'Not found', 'understrap_child' ),
		'not_found_in_trash' => __( 'Not found in trash', 'understrap_child' ),
	);

	// Set other options for Custom Post Type
	$args = array (
		'label'               => __( 'games', 'understrap_child' ),
		'description'         => __( 'Game schedule and results', 'understrap_child' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array (
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
			'comments',
			'revisions',
			'custom-fields',
		),
		// You can associate this CPT with a taxonomy or custom taxonomy.
		'taxonomies'          => array ( 'teams' ),
		/* A hierarchical CPT is like Pages and can have
		* parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,

	);

	// Registering Custom Post Type
	register_post_type( 'games', $args );

}

/* Hook into the 'init' action so that the function
* containing the post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_games', 0 );