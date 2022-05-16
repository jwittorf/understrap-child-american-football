<?php
/**
 * Declaring widgets
 *
 * @package UnderstrapPackage
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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
	}
}  // End of function_exists( 'understrap_child_widgets_init' ).