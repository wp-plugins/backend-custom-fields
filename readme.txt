=== Backend Custom Fields For Forms Management System ===
Contributors: Engr.MTH, MOSTASHAROON
Donate link: https://mostasharoon.org/buy-us-a-coffee/
Tags: forms management system, visual builder, custom fields, custom post type, form, forms, mostasharoon, views, admin, advanced, custom, custom field, edit, field, file, image, more fields, Post, repeater, simple fields, text, textarea, type
Requires at least: 3.5
Tested up to: 4.2.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

> This Plugin requires [Forms Management System](https://mostasharoon.org/wordpress/plugins/forms-management-system/) or [Elegant Profile Builder](https://mostasharoon.org/wordpress/plugins/elegant-profile-builder/).
> We don't give any support for this plugin here, if you need any help please feel free to contact us through our [support page](https://mostasharoon.org/support/).

Backend Custom Fields For Forms Management System is a free add-on allows you to display & manage the custom fields at the backend with easiest way possible.

== Installation ==

1. Upload the entire `backend-custom-fields` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Where Can I Get Support For This Plugin? =

We don't give any support to this plugin here, if you need any help please feel free to contact us through our [support page](https://mostasharoon.org/support/).

= Couldn't Find The Custom Fields? =

By default only the users that have administrator role can access and manage the custom fields, if you want to allow other user roles to access and manage the custom fields you can use `bcf_access_roles` filter to do that, for example:
`//Allow the Editor role users to access & manage the custom fields.
 add_filter( 'bcf_access_roles', 'bcf_851_callback_function' );
 function bcf_851_callback_function( $roles ) {
 	$roles[] = 'editor';

 	return $roles;
 }`

== Changelog ==

= 1.0 =
* initial release
