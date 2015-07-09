<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/*
  Plugin Name: Backend Custom Fields For Forms Management System
  Plugin URI: http://mostasharoon.org
  Description: An easy way to display the custom fields at the backend.
  Version: 1.0
  Author: Mohammed Thaer
  Author URI: http://mostasharoon.org
  Text Domain: bcf
 */

define( 'BCF_VERSION', '1.0' );

/* ----------------------------------------------------------------------------------- */
/* 	Includes required files.
/*----------------------------------------------------------------------------------- */

// Check if FMS is active. If not display warning message and don't do anything
add_action( 'plugins_loaded', 'bcf_checker' );
function bcf_checker() {
	if ( defined( 'FMS_VERSION' ) ) {

		define( 'BCF_IS_FMS_EXIST', true );

	}
	if ( defined( 'FMS_REGISTRATION_VERSION' ) ) {

		define( 'BCF_IS_PROFILE_BUILDER_EXIST', true );

	}
	if ( defined( 'EPB_VERSION' ) ) {

		define( 'BCF_IS_ELEGANT_PROFILE_BUILDER_EXIST', true );

	}

}


// Dir to the plugin
define( 'BCF_DIR', plugin_dir_path( __FILE__ ) );
// URL to the plugin
define( 'BCF_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'bcf_load_translation' );

/**
 *Loads a translation files.
 */
function bcf_load_translation() {
	load_plugin_textdomain( 'bcf', false, 'admin-custom-fields-for-forms-management-system/languages' );
}


require_once( 'includes/bcf-functions.php' );
require_once( 'classes/BCF_Fields.php' );
require_once( 'classes/BCF_Render.php' );
require_once( 'classes/BCF_User.php' );
require_once( 'classes/BCF_Post.php' );
require_once( 'classes/BCF_Factory.php' );
require_once( 'classes/BCF.php' );

