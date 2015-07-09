<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class BCF_User extends BCF_Render {
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
		if ( defined( 'BCF_IS_PROFILE_BUILDER_EXIST' ) && BCF_IS_PROFILE_BUILDER_EXIST == true ) {
			//show profile builder fields
			$this->save_profile_builder_fields( $id );
		}

		if ( defined( 'BCF_IS_ELEGANT_PROFILE_BUILDER_EXIST' ) && BCF_IS_ELEGANT_PROFILE_BUILDER_EXIST == true ) {
			//show elegant profile builder fields
			$this->save_elegant_profile_builder_fields( $id );
		}
	}

	function show( $id ) {

		if ( defined( 'BCF_IS_PROFILE_BUILDER_EXIST' ) && BCF_IS_PROFILE_BUILDER_EXIST == true ) {
			//show profile builder fields
			$this->show_profile_builder_fields( $id );
		}

		if ( defined( 'BCF_IS_ELEGANT_PROFILE_BUILDER_EXIST' ) && BCF_IS_ELEGANT_PROFILE_BUILDER_EXIST == true ) {
			//show elegant profile builder fields
			$this->show_elegant_profile_builder_fields( $id );
		}

	}

	function save_elegant_profile_builder_fields( $id ) {
		$form_id            = get_user_meta( $id, '_epb_form_id', true );
		$epb_fields_setting = get_post_meta( $form_id, 'epb_form', true );

		// verify nonce
		if ( ( ! isset( $_POST['bcf_nonce'] ) ) || ( ! wp_verify_nonce( $_POST['bcf_nonce'], 'bcf' ) ) ) {
			return;
		}

		if ( isset( $_POST['bcf_epb_form'] ) ) {
			//save form id to know this user by which form created.
			update_user_meta( $id, '_epb_form_id', (int) $_POST['bcf_epb_form'] );
		} else {
			//it the user select some images or files to delete, so delete them first
			bcf_delete_attachments( $id, $epb_fields_setting, 'user' );
			bcf_save_custom_fields( $id, $epb_fields_setting );
		}
	}

	function save_profile_builder_fields( $id ) {
		$form_id            = get_user_meta( $id, '_fmsr_form_id', true );
		$fms_fields_setting = get_post_meta( $form_id, 'fms_form', true );

		// verify nonce
		if ( ( ! isset( $_POST['bcf_nonce'] ) ) || ( ! wp_verify_nonce( $_POST['bcf_nonce'], 'bcf' ) ) ) {
			return;
		}

		if ( isset( $_POST['bcf_pb_form'] ) ) {
			//save form id to know this user by which form created.
			update_user_meta( $id, '_fmsr_form_id', (int) $_POST['bcf_pb_form'] );
		} else {
			//it the user select some images or files to delete, so delete them first
			bcf_delete_attachments( $id, $fms_fields_setting, 'user' );
			bcf_save_custom_fields( $id, $fms_fields_setting );
		}
	}

	function show_profile_builder_fields( $id ) {
		$form_id = get_user_meta( $id, '_fmsr_form_id', true );
		$nonce   = wp_create_nonce( 'bcf' );
		$html    = '';
		$html .= BCF_Fields::hidden( 'bcf_nonce', $nonce );
		$html .= '<h3>' . BCF_Fields::label( __( 'Profile Builder for Forms Management System Custom Fields', 'bcf' ) ) . '</h3>';
		if ( empty( $form_id ) ) {
			if ( BCF_CanAccess() ) {
				$args = array(
					'options' => fmsr_get_forms(),
					'name'    => 'bcf_pb_form',
					'id'      => 'bcf_pb_form'
				);

				$html .= '<table class="form-table bcf-table">';
				$html .= '<tr>';
				$html .= '<th>' . BCF_Fields::label( esc_html__( 'Profile Form' ), 'bcf_pb_form' ) . '</th>';
				$html .= '<td>';
				$html .= BCF_Fields::select( $args );
				$html .= BCF_Fields::p( esc_html__( 'Backend Custom Fields For Forms Management System couldn\'t know the form that this user use when he/she get register, please select the form then update the profile.', 'bcf' ), 'description' );
				$html .= '</td>';
				$html .= '</tr>';
				$html .= '</table>';

			} else {
				$html .= BCF_Fields::p( esc_html__( 'Backend Custom Fields For Forms Management System couldn\'t know the form that this user use when he/she get register, and you don\'t have enough permissions to select the form.', 'bcf' ) );
			}
		} else {
			$fms_fields_setting = get_post_meta( $form_id, 'fms_form', true );
			$html .= '<table class="form-table bcf-table">';
			foreach ( $fms_fields_setting as $field ) {
				if ( method_exists( $this, $field['template'] ) ) {
					$html .= '<tr>';
					$html .= $this->$field['template']( $field, $id, 'user' );
					$html .= '</tr>';
				}
			}
			$html .= '</table>';
		}
		echo $html;
	}

	function show_elegant_profile_builder_fields( $id ) {
		$form_id = get_user_meta( $id, '_epb_form_id', true );
		$nonce   = wp_create_nonce( 'bcf' );
		$html    = '';
		$html .= BCF_Fields::hidden( 'bcf_nonce', $nonce );
		$html .= '<h3>' . BCF_Fields::label( __( 'Elegant Profile Builder Custom Fields', 'bcf' ) ) . '</h3>';
		if ( empty( $form_id ) ) {
			if ( BCF_CanAccess() ) {
				$args = array(
					'options' => epb_get_forms(),
					'name'    => 'bcf_epb_form',
					'id'      => 'bcf_epb_form'
				);

				$html .= '<table class="form-table bcf-table">';
				$html .= '<tr>';
				$html .= '<th>' . BCF_Fields::label( esc_html__( 'Profile Form' ), 'bcf_epb_form' ) . '</th>';
				$html .= '<td>';
				$html .= BCF_Fields::select( $args );
				$html .= BCF_Fields::p( esc_html__( 'Backend Custom Fields For Forms Management System couldn\'t know the form that this user use when he/she get register, please select the form then update the profile.', 'bcf' ), 'description' );
				$html .= '</td>';
				$html .= '</tr>';
				$html .= '</table>';

			} else {
				$html .= BCF_Fields::p( esc_html__( 'Backend Custom Fields For Forms Management System couldn\'t know the form that this user use when he/she get register, and you don\'t have enough permissions to select the form.', 'bcf' ) );
			}
		} else {
			$epb_fields_setting = get_post_meta( $form_id, 'epb_form', true );
			$html .= '<table class="form-table bcf-table">';
			foreach ( $epb_fields_setting as $field ) {
				if ( method_exists( $this, $field['template'] ) ) {
					$html .= '<tr>';
					$html .= $this->$field['template']( $field, $id, 'user' );
					$html .= '</tr>';
				}
			}
			$html .= '</table>';
		}
		echo $html;

	}
}
