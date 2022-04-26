<?php

namespace UnderstrapChild\Model;

class CustomTaxonomy {

	protected $singular;
	protected $plural;
	protected $post_object_types = [];

	/**
	 * @param $singular
	 * @param $plural
	 */
	public function __construct( $singular, $plural )
	{
		$this->singular = $singular;
		$this->plural = $plural;
	}

	public function register($post_object_types = [])
	{
		// Add new taxonomy, make it hierarchical like categories.
		// Do the translations part for GUI.
		$labels = array (
			'name'              => _x( $this->plural, 'taxonomy general name' ),
			'singular_name'     => _x( $this->singular, 'taxonomy singular name' ),
			'search_items'      => __( 'Search ' . esc_attr(strtolower($this->plural)) ),
			'all_items'         => __( 'All ' . esc_attr(strtolower($this->plural)) ),
			'parent_item'       => __( 'Parent ' . esc_attr(strtolower($this->singular)) ),
			'parent_item_colon' => __( 'Parent ' . esc_attr(strtolower($this->singular)) . ' :' ),
			'edit_item'         => __( 'Edit ' . esc_attr(strtolower($this->singular)) ),
			'update_item'       => __( 'Update ' . esc_attr(strtolower($this->singular)) ),
			'add_new_item'      => __( 'Add new ' . esc_attr(strtolower($this->singular)) ),
			'new_item_name'     => __( 'New ' . esc_attr(strtolower($this->singular)) . ' name' ),
			'menu_name'         => __( $this->plural ),
		);

		// Register the taxonomy
		register_taxonomy( sanitize_title($this->plural), $post_object_types, array (
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array ( 'slug' => sanitize_title($this->singular) ),
		) );
		// Really make sure all types are registered
		foreach ($post_object_types as $post_object_type) {
			register_taxonomy_for_object_type( sanitize_title($this->plural), $post_object_type );
		}
	}
}