<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



function understrap_child_remove_styles() {
	// Remove default styles from mstw league manager plugin (for schedule and standings)
	wp_dequeue_style( 'mstw_lm_style' );
	wp_deregister_style( 'mstw_lm_style' );
	wp_dequeue_style( 'mstw_scoreboard_style' );
	wp_deregister_style( 'mstw_scoreboard_style' );

	// Remove default styles from team-rosters plugin
	wp_dequeue_style( 'mstw_tr_style' );
	wp_deregister_style( 'mstw_tr_style' );
}
add_action( 'wp_enqueue_scripts', 'understrap_child_remove_styles', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap_child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );




/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @param string $current_mod The current value of the theme_mod.
 * @return string
 */
function understrap_default_bootstrap_version( $current_mod ) {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );

// TODO: move to own file?
/**
 * Add custom menus
 */
function understrap_child_customize_menus() {
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array (
			'topnav' => __( 'Top additional Menu', 'understrap_child' ),
		)
	);
}
add_action( 'after_setup_theme', 'understrap_child_customize_menus' );

// UnderStrap child's includes directory (different to parent, otherwise would overwrite entire file).
$understrap_inc_dir = 'includes';

// Array of files to include.
$understrap_includes = array(
//	'/theme-settings.php',                  // Initialize theme default settings.
//	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
//	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
//	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-taxonomy-teams.php',           // Custom taxonomy type for teams.
	'/custom-post-games.php',               // Custom post type for games.
//	'/custom-comments.php',                 // Custom Comments file.
//	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
//	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
//	'/deprecated.php',                      // Load deprecated functions.
);

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}