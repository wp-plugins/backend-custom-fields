<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class BCF_Factory {
	static function custom_fields_handler( $type = 'profile', $id = 0, $action = 'show' ) {
		switch ( $type ) {
			case 'profile':
				return new BCF_User( $id, $action );
				break;
			case 'post':
				return new BCF_Post( $id, $action );
				break;
		}
	}
}