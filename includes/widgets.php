<?php
/**
 * Declaring widgets
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Child theme's function.php is called before parent, that's why we need to set the priority to 11.
// Otherwise, the sidebars aren't registered yet and our unregister-calls would have no effect.
add_action( 'widgets_init', 'understrap_child_widgets_remove', 11 );
function understrap_child_widgets_remove() {
	// Remove left and right sidebar, messed with Elementor
	unregister_sidebar( 'right-sidebar' );
	unregister_sidebar( 'left-sidebar' );
}

add_action( 'widgets_init', 'understrap_child_widgets_init' );
if ( ! function_exists( 'understrap_child_widgets_init' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function understrap_child_widgets_init()
	{
		register_sidebar(
			array(
				'name'          => __( 'Footer Side', 'understrap_child' ),
				'id'            => 'footer_side',
				'description'   => __( 'Footer area on the side, containing information like social media links',
					'understrap_child' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Main Top', 'understrap_child' ),
				'id'            => 'footer_main_top',
				'description'   => __( 'Footer area in the middle, top row containing information like sponsors', 'understrap_child' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Main Top', 'understrap_child' ),
				'id'            => 'footer_main_top',
				'description'   => __( 'Footer area in the middle, top row containing information like sponsors', 'understrap_child' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Main Bottom Main', 'understrap_child' ),
				'id'            => 'footer_main_bottom_main',
				'description'   => __( 'Footer area in the middle, bottom row containing main information like 
				menus', 'understrap_child' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Main Bottom Side', 'understrap_child' ),
				'id'            => 'footer_main_bottom_side',
				'description'   => __( 'Footer area in the middle, bottom row containing side information like copyright',
					'understrap_child' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// Adjust core menu widget
		unregister_widget( 'WP_Nav_Menu_Widget' );
		register_widget( 'WP_Nav_Menu_Widget_Custom' );
	}
}  // End of function_exists( 'understrap_child_widgets_init' ).

/**
 * Custom class to adjust menu widget heading markup
 *
 * @see WP_Nav_Menu_Widget
 */
class WP_Nav_Menu_Widget_Custom extends WP_Nav_Menu_Widget {
	public function widget( $args, $instance ) {
		// Set own title markup
		$args['before_title'] = '<h5 class="widgettitle">';
		$args['after_title'] = '</h5>';

		// Call original method with adjusted args
		Parent::widget( $args, $instance );
	}
}