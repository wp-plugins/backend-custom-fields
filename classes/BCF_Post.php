<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class BCF_Post extends BCF_Render {
	function __construct( $id, $action ) {
		switch ( $action ) {
			case 'save':
				$this->save( $id );
				break;
			case 'show':
				$this->show( $id );
				break;
		}
	}

	function save( $id ) {
		$form_id            = get_post_meta( $id, '_fms_form_id', true );
		$fms_fields_setting = get_post_meta( $form_id, 'fms_form', true );

		// verify nonce
		if ( ( ! isset( $_POST['bcf_nonce'] ) ) || ( ! wp_verify_nonce( $_POST['bcf_nonce'], 'bcf' ) ) ) {
			return;
		}
		//it the user select some images or files to delete so delete them first
		bcf_delete_attachments( $id, $fms_fields_setting, 'post' );
		bcf_save_custom_fields( $id, $fms_fields_setting, 'post' );
	}

	function show( $id ) {

		$form_id = get_post_meta( $id, '_fms_form_id', true );
		$nonce   = wp_create_nonce( 'bcf' );
		$html    = '';
		$html .= BCF_Fields::hidden( 'bcf_nonce', $nonce );
//		$html .= '<h3>' . BCF_Fields::label( __( 'Backend Custom Fields For Forms Management System', 'bcf' ) ) . '</h3>';
		if ( empty( $form_id ) ) {
			if ( BCF_CanAccess() ) {
				$html .= '<table class="form-table bcf-table">';
				$html .= '<tr>';
				$html .= '<th>' . BCF_Fields::label( esc_html__( 'FMS Form' ) ) . '</th>';
				$html .= '<td>';
				$html .= BCF_Fields::p( esc_html__( 'Backend Custom Fields For Forms Management System couldn\'t know the form that this user use when he/she publish the post, please select the form from FMS Form meta box then update the post.', 'bcf' ) );
				$html .= '</td>';
				$html .= '</tr>';
				$html .= '</table>';
			} else {
				$html .= BCF_Fields::p( esc_html__( 'Backend Custom Fields For Forms Management System couldn\'t know the form that this user use when he/she publish the post, and you don\'t have enough permissions to select the form.', 'bcf' ) );
			}
		} else {
			$fms_fields_setting = get_post_meta( $form_id, 'fms_form', true );
			$html .= '<table class="form-table bcf-table">';
			foreach ( $fms_fields_setting as $field ) {
				if ( method_exists( $this, $field['template'] ) ) {
					$html .= '<tr>';
					$html .= $this->$field['template']( $field, $id, 'post' );
					$html .= '</tr>';
				}
			}
			$html .= '</table>';
		}
		echo $html;
	}
}
