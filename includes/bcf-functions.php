<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function bcf_update_edit_form() {
	echo ' enctype="multipart/form-data"';
}

add_action( 'post_edit_form_tag', 'bcf_update_edit_form' );
add_action( 'user_edit_form_tag', 'bcf_update_edit_form' );


function bcf_fix_file_array( &$files ) {
	$names = array(
		'name'     => 1,
		'type'     => 1,
		'tmp_name' => 1,
		'error'    => 1,
		'size'     => 1
	);
	foreach ( $files as $key => $part ) {
		// only deal with valid keys and multiple files
		$key = (string) $key;
		if ( isset( $names[ $key ] ) && is_array( $part ) ) {
			foreach ( $part as $position => $value ) {
				$files[ $position ][ $key ] = $value;
			}
			// remove old key reference
			unset( $files[ $key ] );
		}
	}
}

function BCF_CanAccess() {
	$roles = apply_filters( 'bcf_access_roles', array( 'administrator' ) );
	$user  = wp_get_current_user();

	$canAccess = false;
	foreach ( $roles as $role ) {
		if ( in_array( $role, $user->roles ) ) {
			$canAccess = true;
		}
	}

	return $canAccess;
}

function bcf_insert_attachment( $file_handler, $post_id ) {
	$attach_id = media_handle_sideload( $file_handler, $post_id );

	return $attach_id;
}

function bcf_save_custom_fields( $id, $fms_fields_setting, $for = 'user' ) {
	foreach ( $fms_fields_setting as $field ) {
		//For images and files
		if ( $_FILES ) {
			if ( $field['template'] == 'file_upload' || $field['template'] == 'image_upload' ) {
				if ( ( isset( $_FILES[ $field['name'] ] ) ) && ( ! empty( $_FILES[ $field['name'] ]['name'][0] ) ) ) {
					$AttachmentIds = array();
					bcf_fix_file_array( $_FILES[ $field['name'] ] );
					foreach ( $_FILES[ $field['name'] ] as $file => $fileitem ) {
						$AttachmentIds[] = bcf_insert_attachment( $fileitem, $id );
					}
					if ( ! empty( $AttachmentIds ) ) {
						if ( $for == 'user' ) {
							update_user_meta( $id, $field['name'], $AttachmentIds );
						} else {
							update_post_meta( $id, $field['name'], $AttachmentIds );
						}
					}
				}

			}
		}

		$fms_special_fields = array(
			'featured_image',
			'taxonomy',
			'post_tags',
			'post_title',
			'post_excerpt',
			'post_content',
			'image_upload',
			'file_upload',
			'avatar',
			'fms_message',
			'user_login',
			'first_name',
			'last_name',
			'nickname',
			'user_url',
			'description',
			'password',
			'user_email'
		);
		if ( ! in_array( ( $field['template'] ), $fms_special_fields ) ) {
			$name       = $field['name'];
			$meta_value = $_POST[ $name ];
			if ( ( $field['rich'] == 'yes' ) || ( $field['rich'] == 'teeny' ) ) {
				is_array( $meta_value ) ? $meta_value = array_map( 'wp_kses_post', $meta_value ) : $meta_value = wp_kses_post( $meta_value );
			} else {
				is_array( $meta_value ) ? $meta_value = array_map( 'wp_strip_all_tags', $meta_value ) : $meta_value = wp_strip_all_tags( $meta_value );
			}

			if ( $for == 'user' ) {
				update_user_meta( $id, $name, $meta_value );
			} else {
				update_post_meta( $id, $name, $meta_value );
			}
		}
	}
}

function bcf_delete_attachments( $id, $bcf_fields_setting, $for = 'user' ) {
	if ( isset( $_POST['bcf_delete_attachment'] ) && is_array( $_POST['bcf_delete_attachment'] ) ) {
		$bcf_photos_must_deleted = $_POST['bcf_delete_attachment'];
		foreach ( $bcf_photos_must_deleted as $bcf_photo_must_deleted ) {

			foreach ( $bcf_fields_setting as $onefield ) {
				$bcf_files_fields = array( 'image_upload', 'file_upload' );

				if ( $for == 'user' ) {
					$current_attached_files = get_user_meta( $id, $onefield['name'], true );
				} else {
					$current_attached_files = get_post_meta( $id, $onefield['name'], true );
				}

				if ( ( in_array( ( $onefield['template'] ), $bcf_files_fields ) ) && ( in_array( absint( $bcf_photo_must_deleted ), $current_attached_files ) ) ) {
					//delete from the $current_attached_files array by value
					if ( ( $key = array_search( absint( $bcf_photo_must_deleted ), $current_attached_files ) ) !== false ) {
						unset( $current_attached_files[ $key ] );
					}
					wp_delete_attachment( absint( $bcf_photo_must_deleted ) );
					if ( $for == 'user' ) {
						update_user_meta( $id, $onefield['name'], $current_attached_files );
					} else {
						update_post_meta( $id, $onefield['name'], $current_attached_files );
					}

				}
			}

		}
	}
}