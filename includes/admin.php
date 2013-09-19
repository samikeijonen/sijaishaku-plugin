<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
/**
 * Sets up custom columns on the post items edit screen.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $columns
 * @return array
 */
function sijaishaku_plugin_edit_post_columns( $columns ) {

	/* Unset columns. */
	unset( $columns['categories'] );
	unset( $columns['tags'] );
	unset( $columns['comments'] );
	
	/* Set columns. */
	$new_columns['taxonomy-city'] = _x( 'City', 'City name in admin', 'custom-content-portfolio' );
	$new_columns['taxonomy-subject'] = _x( 'Subject', 'Subject name in admin', 'custom-content-portfolio' );
	$new_columns['taxonomy-academy_level'] = _x( 'Level', 'Academy level name in admin', 'custom-content-portfolio' );

	return array_merge( $columns,  $new_columns);
}
add_filter( 'manage_edit-post_columns', 'sijaishaku_plugin_edit_post_columns' );

?>