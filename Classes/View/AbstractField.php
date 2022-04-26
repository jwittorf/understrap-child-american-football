<?php

namespace UnderstrapChild\View;

abstract class AbstractField
{
	protected $term;
	protected $label;
	protected $prefix;
	protected $type;
	protected $title;
	protected $value;
	protected $id;

	/**
	 * @param $term
	 * @param $prefix
	 * @param $label
	 * @param $title
	 * @param $type
	 */
	public function __construct( $term, $prefix, $label, $title, $type = "text")
	{
		$this->term = $term;
		$this->prefix = $prefix;
		$this->label = $label;
		$this->type = $type;
		$this->title = $title;
		$this->id = $this->prefix . '-' . sanitize_key( $this->label );

		$this->value = get_term_meta( $term->term_id, $this->id, true );
	}

}