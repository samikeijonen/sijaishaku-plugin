<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Login user after register form.
 *
 * @link http://www.gravityhelp.com/forums/topic/form-direct-to-private-page-with-auto-login#post-97328
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_autologin( $user_id, $config, $entry, $password ) {

    wp_set_auth_cookie( $user_id, false, '' );
	
}
add_action( 'gform_user_registered', 'sijaishaku_plugin_autologin', 10, 4 );

/**
 * Disable Entries when updating entry. 
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_gform_update_post_entries( $status, $form )
{
  return false;
}
add_filter( 'gform_update_post_entries', 'sijaishaku_plugin_gform_update_post_entries', 10, 2 );

/**
 * Add taxonimies in form. 
 *
 * @since 1.0
 */
function sijaishaku_plugin_add_taxonomies( $input, $field, $value, $lead_id, $form_id ) {

	// because this will fire for every form/field, only do it when it is the specific form and field

	if ( $form_id == 2 && $field["id"] == 10 ) {
		$input = sijaishaku_plugin_get_checkboxes();
	}

	return $input;
	
}
add_action( 'gform_field_input', 'sijaishaku_plugin_add_taxonomies', 10, 5 );

/**
 * Add taxonimies in database. 
 *
 * @since 1.0
 */
 function sijaishaku_plugin_add_taxonomies_to_database( $entry, $form ) {

	//getting post
    $post = get_post( $entry['post_id'] );

    //changing post content
    //$post->post_content = "Blender Version:" . $entry[7] . "<br/> <img src='" . $entry[8] . "'> <br/> <br/> " . $entry[13] . " <br/> <img src='" . $entry[5] . "'>";

    //updating post
    //wp_update_post($post);
	
}
add_action( 'gform_after_submission', 'sijaishaku_plugin_add_taxonomies_to_database', 10, 2 );
?>