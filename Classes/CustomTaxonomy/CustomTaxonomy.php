<?php

/**
 * @package UnderstrapChild
 */

namespace UnderstrapChild\CustomTaxonomy;

class CustomTaxonomy
{

	protected string $singular = 'Singular';
	protected string $plural = 'Plural';
	protected string $prefix = 'custom_taxonomy';
	protected string $id = 'custom_taxonomy_plural';
	protected array $post_object_types = [];
	protected array $data = [];
	protected string $slug;

	/**
	 * @param $singular
	 * @param $plural
	 * @param array $post_object_types
	 */
	public function __construct( $singular, $plural, array $post_object_types = [] )
	{
		$this->singular = $singular;
		$this->slug = sanitize_title( $this->singular );
		$this->plural = $plural;
		$this->prefix = sanitize_title( $this->plural );
		$this->id = 'custom_taxonomy_' . $this->prefix;
		$this->post_object_types = $post_object_types;
		add_action( 'init', array ( $this, 'register', ), 0 );
	}

	public function addData( $label, $description, $type = 'text' )
	{
		$field = new Field( $label, $description, $this->id, $type );
		$this->data[] = $field;
	}

	public function addActionTermFormFields()
	{
		add_action( $this->prefix . '_add_form_fields', array ( $this, 'renderTermFormFields' ) );
	}

	public function renderTermFormFields()
	{
		$html = '';
		foreach ( $this->data as $field ) {
			$html .= $field->render();
		}
		echo $html;
	}

	public function addActionEditFormFields()
	{
		add_action( $this->prefix . '_edit_form_fields', array ( $this, 'renderEditFormFields' ) );
	}

	public function renderEditFormFields( $term )
	{
		$html = '';
		echo "<pre>";
		var_dump($this->data);
		echo "</pre>";
		foreach ( $this->data as $field ) {
			$field->addTerm($term);
			$html .= $field->renderEdit();
		}
		echo $html;
	}

	public function register()
	{
		// Add new taxonomy, make it hierarchical like categories.
		// Do the translations part for GUI.
		$labels = array (
			'name'              => _x( $this->plural, 'taxonomy general name' ),
			'singular_name'     => _x( $this->singular, 'taxonomy singular name' ),
			'search_items'      => __( 'Search ' . esc_attr( strtolower( $this->plural ) ) ),
			'all_items'         => __( 'All ' . esc_attr( strtolower( $this->plural ) ) ),
			'parent_item'       => __( 'Parent ' . esc_attr( strtolower( $this->singular ) ) ),
			'parent_item_colon' => __( 'Parent ' . esc_attr( strtolower( $this->singular ) ) . ' :' ),
			'edit_item'         => __( 'Edit ' . esc_attr( strtolower( $this->singular ) ) ),
			'update_item'       => __( 'Update ' . esc_attr( strtolower( $this->singular ) ) ),
			'add_new_item'      => __( 'Add new ' . esc_attr( strtolower( $this->singular ) ) ),
			'new_item_name'     => __( 'New ' . esc_attr( strtolower( $this->singular ) ) . ' name' ),
			'menu_name'         => __( $this->plural ),
		);

		// Register the taxonomy
		register_taxonomy( sanitize_title( $this->plural ), $this->post_object_types, array (
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array ( 'slug' => sanitize_title( $this->singular ) ),
		) );
		// Really make sure all types are registered
		foreach ( $this->post_object_types as $post_object_type ) {
			register_taxonomy_for_object_type( sanitize_title( $this->plural ), $post_object_type );
		}
	}

}