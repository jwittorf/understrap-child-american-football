<?php

namespace UnderstrapChild\View;

class Input extends AbstractField
{

	public function render(): string
	{
		switch ( $this->type ) {
			case "url":
				$value = esc_url_raw( $this->value, array ( "http", "https" ) );
				break;
			case "number":
				$value = absint( $this->value );
				break;
			default:
				$value = sanitize_text_field( $this->value );
		}

		return '<tr class="form-field">
		<th>
			<label for="' . $this->id . '">' . $this->label . '</label>
		</th>
		<td>
			<input name="' . $this->id . '" id="' . $this->id . '" type="' . $this->type . '" title="' . $this->title .
			'" value="' . $value . '" />
			<p class="description">' . $this->title . '</p>
		</td>
		</tr>';
	}
}