<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class BCF {
	function __construct() {
		//enqueue scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

		//for the post
		add_action( 'add_meta_boxes', array( $this, 'show_post_custom_fields' ) );
		add_action( 'save_post', array( $this, 'save_post_custom_fields' ) );

		//for the profile
		add_action( 'show_user_profile', array( $this, 'show_profile_custom_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'show_profile_custom_fields' ) );
		add_action( 'personal_options_update', array( $this, 'save_profile_custom_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_profile_custom_fields' ) );
	}

	function scripts() {
		wp_enqueue_style( 'bcf-css', BCF_URL . 'css/style.css' );

		wp_enqueue_script( 'bcf-js', BCF_URL . 'js/script.js', array(
			'jquery',
			'jquery-masonry'
		) );
	}

	function save_profile_custom_fields( $user_id ) {
		BCF_Factory::custom_fields_handler( 'profile', $user_id, 'save' );
	}

	function save_post_custom_fields( $post_id ) {
		BCF_Factory::custom_fields_handler( 'post', $post_id, 'save' );
	}

	function show_post_custom_fields() {

		if ( ! BCF_CanAccess() ) {
			return;
		}

		$post_types = get_post_types( array( 'public' => true ) );
		foreach ( $post_types as $post_type ) {
			add_meta_box(
				'bcf', // $id
				'Backend Custom Fields For Forms Management System', // $title
				array( $this, 'show_fields' ), // $callback
				$post_type,
				'normal', // $context
				'high' ); // $priority
		}
	}

	function show_fields( $post ) {
		BCF_Factory::custom_fields_handler( 'post', $post->ID, 'show' );
	}

	function show_profile_custom_fields( $user ) {
		if ( ! BCF_CanAccess() ) {
			return;
		}

		BCF_Factory::custom_fields_handler( 'profile', $user->ID, 'show' );
	}
}

$BCF = new BCF();