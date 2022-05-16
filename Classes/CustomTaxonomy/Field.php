<?php

namespace UnderstrapChild\CustomTaxonomy;

class Field
{
	protected $term;
	protected $label;
	protected $type;
	protected $value;
	protected $id;

	public function __construct( $label, $description, $id, $type = 'text' )
	{
		$this->label = $label;
		$this->slug = sanitize_title( $this->label );
		$this->id = $id;
		$this->type = $type;
		$this->description = $description;
	}

	public function addTerm( $term )
	{
		$this->term = $term;
		$this->value = get_term_meta( $this->term->term_id, $this->id, true );
	}

	public function render()
	{
		return '<div class="form-field">
				<label for="' . $this->slug . '">' . $this->label . '</label>
				<input name="' . $this->slug . '" id="' . $this->slug . '" type="' . $this->type . '" title="' .
			$this->description . '" />
				<p class="description">' . $this->description . '</p>
			</div>';
	}

	public function renderEdit(): string
	{
		switch ( $this->type ) {
			case "url":
//				error_log(print_r($this->value));
				$val = esc_url_raw( $this->value, array ( "http", "https" ) );
				break;
			case "number":
				$val = absint( $this->value );
				break;
			default:
				$val = sanitize_text_field( $this->value );
		}

		return '<tr class="form-field">
		<th>
			<label for="' . $this->slug . '">' . $this->label . '</label>
		</th>
		<td>
			<input name="' . $this->slug . '" id="' . $this->slug . '" type="' . $this->type . '" title="' .
			$this->description . '" value="' . $val . '" />
			<p class="description">' . $this->description . '</p>
		</td>
		</tr>';
	}

	public function getLabel()
	{
		return $this->label;
	}

	public function getDescription()
	{
		return $this->description;
	}
}