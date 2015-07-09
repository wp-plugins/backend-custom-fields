<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class BCF_Render extends BCF_Fields {
	function text_field( $field, $id = null, $is = 'post' ) {
		$value = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );

		$html = '';
		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';
		$html .= BCF_Fields::text( $field['name'], $value );
		$html .= '</td>';

		return $html;
	}

	function textarea_field( $field, $id = null, $is = 'post' ) {
		$value = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );

		$html = '';
		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';
		$html .= BCF_Fields::textarea( $field['name'], $value, '', '10' );
		$html .= '</td>';

		return $html;
	}

	function email_address( $field, $id = null, $is = 'post' ) {
		$html = $this->text_field( $field, $id, $is );

		return $html;
	}

	function date_field( $field, $id = null, $is = 'post' ) {
		$html = $this->text_field( $field, $id, $is );

		return $html;
	}

	function date_time_field( $field, $id = null, $is = 'post' ) {
		$html = $this->text_field( $field, $id, $is );

		return $html;
	}

	function stepper( $field, $id = null, $is = 'post' ) {
		$html = $this->text_field( $field, $id, $is );

		return $html;
	}

	function website_url( $field, $id = null, $is = 'post' ) {
		$html = $this->text_field( $field, $id, $is );

		return $html;
	}

	function custom_hidden_field( $field, $id = null, $is = 'post' ) {
		$field['label'] = $field['name'] . ' ' . __( '(Hidden Field)', 'bcf' );
		$html           = $this->text_field( $field, $id, $is );

		return $html;
	}

	function image_upload( $field, $id = null, $is = 'post' ) {
		$images_ids = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );
		$html       = '';


		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';

		if ( ! empty( $images_ids ) ) {
			$html .= '<div class="bcf-container">';
			foreach ( $images_ids as $image_id ) {
				$html .= '<div class="bcf-item">';
				$image_url = esc_url( wp_get_attachment_url( $image_id ) );
				$html .= BCF_Fields::image( $image_url, '100%', '100%' );
				$html .= '<br>' . BCF_Fields::checkbox( 'bcf_delete_attachment[]', $image_id ) . __( 'Delete', 'bcf' );
				$html .= '</div>';
			}
			$html .= '</div>';
		}


		$html .= BCF_Fields::file_filed( $field['name'] );
		$html .= '</td>';

		return $html;
	}

	function file_upload( $field, $id = null, $is = 'post' ) {
		$files_ids = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );
		$html      = '';


		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';

		if ( ! empty( $files_ids ) ) {
			$html .= '<div class="bcf-container">';
			foreach ( $files_ids as $file_id ) {
				$html .= '<div class="bcf-item">';
				$url = esc_url( wp_get_attachment_url( $file_id ) );
				$html .= BCF_Fields::a( $url, basename( $url ) );
				$html .= BCF_Fields::checkbox( 'bcf_delete_attachment[]', $file_id ) . __( 'Delete', 'bcf' );
				$html .= '</div>';
			}
			$html .= '</div>';
		}


		$html .= BCF_Fields::file_filed( $field['name'] );
		$html .= '</td>';

		return $html;
	}

	function radio_field( $field, $id = null, $is = 'post' ) {
		$items   = $field['options'];
		$checked = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );

		$html = '';
		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';

		foreach ( $items as $item ) {
			$html .= BCF_Fields::radio( $field['name'], $item, $checked );
			$html .= $item . '<br>';
		}

		$html .= '</td>';

		return $html;
	}

	function checkbox_field( $field, $id = null, $is = 'post' ) {
		$items   = $field['options'];
		$checked = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );

		$html = '';
		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';

		foreach ( $items as $item ) {
			$html .= BCF_Fields::checkbox( $field['name'] . '[]', $item, $checked );
			$html .= $item . '<br>';
		}

		$html .= '</td>';

		return $html;
	}


	function repeat_field( $field, $id = null, $is = 'post' ) {
		$values = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );

		$html = '';
		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';

		$html .= '<div class="bcf-repeatable-container">';
		$html .= BCF_Fields::button( '+', 'data-type="add"' );
		$html .= BCF_Fields::button( '-', 'data-type="rem"' );

		if ( empty( $values ) ) {
			$html .= BCF_Fields::text( $field['name'] . '[]', '' );
		} else {
			foreach ( $values as $value ) {
				$html .= BCF_Fields::text( $field['name'] . '[]', $value );
			}
		}


		$html .= '</div>';

		$html .= '</td>';

		return $html;
	}


	function dropdown_field( $field, $id = null, $is = 'post' ) {
		$selected = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );
		$args     = array(
			'name'     => $field['name'],
			'options'  => $field['options'],
			'selected' => array( $selected ),
			'id'       => $field['name']
		);


		$html = '';
		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';
		$html .= BCF_Fields::select( $args );
		$html .= '</td>';

		return $html;
	}

	function multiple_select( $field, $id = null, $is = 'post' ) {
		$selected   = $is == 'post' ? get_post_meta( $id, $field['name'], true ) : get_user_meta( $id, $field['name'], true );
		$select_arr = is_array( $selected ) ? $selected : array( $selected );

		$args = array(
			'name'     => $field['name'] . '[]',
			'options'  => $field['options'],
			'multiple' => true,
			'selected' => $select_arr,
			'id'       => $field['name']
		);


		$html = '';
		$html .= '<th>' . BCF_Fields::label( $field['label'], $field['name'] ) . '</th>';
		$html .= '<td>';
		$html .= BCF_Fields::select( $args );
		$html .= '</td>';

		return $html;
	}
}