<?php

// Create a custom taxonomy, to organize football related content for each team.
function custom_taxonomy_teams()
{

	// Add new taxonomy, make it hierarchical like categories.
	// Do the translations part for GUI.
	$labels = array (
		'name'              => _x( 'Teams', 'taxonomy general name' ),
		'singular_name'     => _x( 'Team', 'taxonomy singular name' ),
		'search_items'      => __( 'Search teams' ),
		'all_items'         => __( 'All teams' ),
		'parent_item'       => __( 'Parent team' ),
		'parent_item_colon' => __( 'Parent team:' ),
		'edit_item'         => __( 'Edit team' ),
		'update_item'       => __( 'Update team' ),
		'add_new_item'      => __( 'Add new team' ),
		'new_item_name'     => __( 'New Team name' ),
		'menu_name'         => __( 'Teams' ),
	);

	// Register the taxonomy
	register_taxonomy( 'teams', array ( 'games' ), array (
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array ( 'slug' => 'team' ),
	) );
	register_taxonomy_for_object_type( 'teams', 'games' );

}

// hook into the init action and call custom_taxonomy_teams when it fires
add_action( 'init', 'custom_taxonomy_teams', 0 );