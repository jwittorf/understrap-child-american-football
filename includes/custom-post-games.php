<?php
/**
 * Custom post type for Games
 *
 * @package UnderstrapChild
 */

if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	return;
}

function custom_post_games()
{

	// Set UI labels for Custom Post Type
	// https://salferrarello.com/wordpress-__-vs-_x-functions/
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

function generate_select_team( $name, $selected = '' )
{
	$html = wp_nonce_field(
		'custom-post-games-print-meta-box-team-' . $name . '-save',
		'custom-post-games-print-meta-box-team-' . $name . '-nonce'
	);
	$teams = get_terms( array (
		'taxonomy'   => 'teams',
		'hide_empty' => false,
	) );

	// Select the team.
	$html .= "<select name=\"custom_post_games_team_" . $name . "\" id=\"custom_post_games_team_" . $name . "\">";
	foreach ( $teams as $team ) {
		$html .= "<option " . selected(
				get_post_meta( get_the_ID(), "custom_post_games_team_$name", true ),
				esc_attr( $team->slug ),
				false
			) .
			" value=\"" .
			esc_attr(
				$team->slug
			) . "\">" .
			sanitize_text_field(
				$team->name
			) .
			"</option>";
	}
	$html .= "</select>";

	// Enter the score.
	$html .= "<input type=\"number\" value=\"\">";
	return $html;
}

function custom_post_games_print_meta_box_team_home()
{
	echo generate_select_team( "home" );
}

function custom_post_games_print_meta_box_team_away()
{
	echo generate_select_team( "away" );
}

function custom_post_games_add_meta_boxes()
{
	add_meta_box(
		'custom-post-games-print-meta-box-team-home',
		esc_html__( 'Home team' ),
		'custom_post_games_print_meta_box_team_home',
		'games'
	);

	add_meta_box(
		'custom-post-games-print-meta-box-team-away',
		esc_html__( 'Away team' ),
		'custom_post_games_print_meta_box_team_away',
		'games'
	);
}

add_action( 'add_meta_boxes', 'custom_post_games_add_meta_boxes' );


function custom_post_games_save_meta_boxes()
{
	if (
		( !isset( $_POST[ 'custom-post-games-print-meta-box-team-home-nonce' ] ) &&
			!wp_verify_nonce( $_POST[ 'custom-post-games-print-meta-box-team-home-nonce' ] ) ) &&
		(
			!isset( $_POST[ 'custom-post-games-print-meta-box-team-away-nonce' ] ) &&
			!wp_verify_nonce( $_POST[ 'custom-post-games-print-meta-box-team-away-nonce' ] )
		)
	) {
		return;
	}

	$game_id = get_the_ID();
	custom_post_games_update_or_delete_value( $game_id, 'custom_post_games_team_home' );
	custom_post_games_update_or_delete_value( $game_id, 'custom_post_games_team_away' );

}

/**
 * @param $game_id
 * @param string $key
 * @return void
 */
function custom_post_games_update_or_delete_value( $game_id, string $key = '' ): void
{
	if (
		!isset( $_POST[ $key ] ) && get_post_meta(
			$game_id,
			$key,
			true
		)
	) {
		delete_post_meta( $game_id, $key );
	} else {
		update_post_meta(
			$game_id,
			$key,
			sanitize_text_field( $_POST[ $key ] )
		);
	}
}

add_action( 'save_post_games', 'custom_post_games_save_meta_boxes' );