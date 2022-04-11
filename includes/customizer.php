<?php

if ( !function_exists( 'understrap_child_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function understrap_child_theme_customize_register( $wp_customize )
	{
		$wp_customize->add_section(
			'understrap_child_theme_layout_options',
			array (
				'title'       => __( 'Theme Layout Settings', 'understrap_child' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'General theme settings', 'understrap_child' ),
				'priority'    => apply_filters( 'understrap_child_theme_layout_options_priority', 160 ),
			)
		);

		$wp_customize->add_setting(
			'understrap_child_topnav_position',
			array (
				'default'           => 'justify-content-end',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'understrap_child_topnav_position',
				array (
					'label'             => __( 'Topnav Positioning', 'understrap_child' ),
					'description'       => __(
						'Set topnav\'s default position. Reference: <a href="https://getbootstrap.com/docs/5.1/utilities/flex/#justify-content" target="_blank">Bootstrap</a> and <a href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/#aa-justify-content" target="_blank">Flexbox in general</a>.  Note: this can be overridden on individual pages.',
						'understrap_child'
					),
					'section'           => 'understrap_child_theme_layout_options',
					'settings'          => 'understrap_child_topnav_position',
					'type'              => 'select',
					'sanitize_callback' => 'understrap_child_theme_slug_sanitize_select',
					'choices'           => array (
						'justify-content-start'   => __( 'Left topnav', 'understrap_child' ),
						'justify-content-end'     => __( 'Right topnav', 'understrap_child' ),
						'justify-content-center'  => __( 'Center topnav', 'understrap_child' ),
						'justify-content-between' => __( 'Split items between topnav', 'understrap_child' ),
						'justify-content-around'  => __( 'Items around middle topnav', 'understrap_child' ),
						'justify-content-evenly'  => __( 'Center items evenly in topnav', 'understrap_child' ),
						'none'                    => __( 'No topnav', 'understrap_child' ),
					),
					'priority'          => apply_filters( 'understrap_child_topnav_position_priority', 20 ),
				)
			)
		);
	}
} // End of if function_exists( 'understrap_child_theme_customize_register' ).
add_action( 'customize_register', 'understrap_child_theme_customize_register' );