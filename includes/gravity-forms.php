<?php

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
?>