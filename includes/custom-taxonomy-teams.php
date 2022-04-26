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


// Add additional fields to the created custom taxonomy.
add_action( 'teams_add_form_fields', 'custom_taxonomy_teams_add_term_fields' );
function custom_taxonomy_teams_add_term_fields()
{

	// URL
	echo '<div class="form-field">
	<label for="custom_taxonomy_teams-url">' . __( 'URL' ) . '</label>
	<input type="url" name="custom_taxonomy_teams-url" id="custom_taxonomy_teams-url" />
	<p>' . __( 'Website of the team, starting with http:// or https://' ) . '</p>
	</div>';

	// TODO: Image

}


add_action( 'teams_edit_form_fields', 'custom_taxonomy_teams_edit_term_fields' );
function custom_taxonomy_teams_edit_term_fields( $term )
{

	$value = get_term_meta( $term->term_id, 'custom_taxonomy_teams-url', true );

	echo '<tr class="form-field">
	<th>
		<label for="custom_taxonomy_teams-url">' . __( 'URL' ) . '</label>
	</th>
	<td>
		<input name="custom_taxonomy_teams-url" id="custom_taxonomy_teams-url" type="url" title="' .
		__( 'Full URL starting with http:// or https://' ) . '" value="' .
		esc_url_raw( $value, array ( 'http', 'https' ) ) . '" />
		<p class="description">' . __( 'Website of the team, starting with http:// or https://' ) . '</p>
	</td>
	</tr>';

}


add_action( 'created_teams', 'custom_taxonomy_teams_save_term_fields' );
add_action( 'edited_teams', 'custom_taxonomy_teams_save_term_fields' );
function custom_taxonomy_teams_save_term_fields( $term_id )
{

	update_term_meta(
		$term_id,
		'custom_taxonomy_teams-url',
		sanitize_text_field( $_POST[ 'custom_taxonomy_teams-url' ] )
	);

}