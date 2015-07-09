<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class BCF_Fields {
	static function image( $src, $h = '80', $w = '80' ) {
		$html = '';

		$html .= '<img src="' . $src . '" height="' . $h . '" width="' . $w . '">';

		return $html;
	}

	static function button( $label, $att = '' ) {
		$html = '<button type="button" ' . $att . '>' . $label . '</button>';

		return $html;
	}

	static function checkbox( $name, $value, $checked = array() ) {
		$checked = in_array( $value, $checked ) ? 'checked' : '';
		$html    = '<input type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . '>';

		return $html;
	}

	static function span( $value, $class ) {
		$html = '<span class="' . $class . '">' . esc_html( $value ) . '</span>';

		return $html;
	}

	static function radio( $name, $value, $checked ) {
		$html = '<input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" ' . checked( $checked, $value, false ) . ' >';

		return $html;
	}

	static function text( $name, $value, $class = '', $disabled = '' ) {
		$html = '';
		$html .= '<input type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" class="' . esc_attr( $class ) . '" ' . $disabled . '/>';

		return $html;
	}

	static function hidden( $name, $value, $class = '' ) {
		$html = '';
		$html .= '<input type="hidden" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" class="' . esc_attr( $class ) . '"/>';

		return $html;
	}

	static function textarea( $name, $value, $class = '', $rows = '', $cols = '' ) {
		$html = '';
		$html .= '<textarea name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" class="' . esc_attr( $class ) . '" rows="' . $rows . '" cols="' . $cols . '">' . esc_textarea( $value ) . '</textarea>';

		return $html;
	}

	static function file_filed( $name, $class = '' ) {
		$html = '';
		$html .= '<input type="file" multiple="multiple" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $name ) . '" class="' . esc_attr( $class ) . '"/>';

		return $html;
	}

	static function a( $url, $label ) {
		$html = '<a href="' . $url . '">' . $label . '</a>';

		return $html;
	}

	static function p( $content, $class = '', $id = '' ) {
		$html = '<p class="' . esc_attr( $class ) . '" id="' . esc_attr( $id ) . '">' . $content . '</p>';


		return $html;
	}

	static function label( $label, $for = '' ) {
		$html = '<label for="' . esc_attr( $for ) . '">' . $label . '</label>';

		return $html;
	}

	static function select( array $args ) {

		$default_args = array(
			'name'     => '',
			'class'    => '',
			'multiple' => false,
			'options'  => array(),
			'selected' => array(),
			'id'       => ''
		);

		$args     = array_merge( $default_args, $args );
		$multiple = $args['multiple'] ? 'multiple' : '';

		$html = '<select ' . $multiple . ' name="' . $args['name'] . '" id="' . $args['id'] . '" class="' . $args['class'] . '">';

		if ( ! empty( $args['options'] ) ) {
			foreach ( $args['options'] as $option ) {
				$selected = in_array( $option, $args['selected'] ) ? 'selected' : '';
				$html .= '<option ' . $selected . ' value="' . $option . '">' . $option . '</option>';
			}
		}

		$html .= '</select>';


		return $html;
	}
}