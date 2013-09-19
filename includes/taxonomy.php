<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Setup Download Taxonomies
 *
 * Registers the custom taxonomy download academy_levels.
 *
 * @since 0.1.0
*/

add_action( 'init', 'sijaishaku_plugin_taxonomies' );

function sijaishaku_plugin_taxonomies() {

	/* Register city. */

	$city_labels = array(
		'name' 				=> _x( 'Cities', 'taxonomy general name', 'sijaishaku-plugin' ),
		'singular_name' 	=> _x( 'City', 'taxonomy singular name', 'sijaishaku-plugin' ),
		'search_items' 		=> __( 'Search Cities', 'sijaishaku-plugin' ),
		'all_items' 		=> __( 'All Cities', 'sijaishaku-plugin' ),
		'parent_item' 		=> _x( 'Parent City', 'parent item', 'sijaishaku-plugin' ),
		'parent_item_colon' => _x( 'Parent City:', 'parent item colon', 'sijaishaku-plugin' ),
		'edit_item' 		=> __( 'Edit Cities', 'sijaishaku-plugin' ), 
		'update_item' 		=> __( 'Update City', 'sijaishaku-plugin' ),
		'add_new_item' 		=> __( 'Add New City', 'sijaishaku-plugin' ),
		'new_item_name' 	=> __( 'New City  Name', 'sijaishaku-plugin' ),
		'menu_name' 		=> __( 'Cities', 'sijaishaku-plugin' ),
	); 	

	$city_args = apply_filters( 'sijaishaku_plugin_city_args', array(
			'hierarchical' 	=> true,
			'labels' 		=> apply_filters( 'sijaishaku_plugin_city_labels', $city_labels ),
			'show_ui' 		=> true,
			'query_var' 	=> 'city',
			'rewrite' 		=> array( 'slug' => 'paikkakunta' )
		)
	);

	register_taxonomy( 'city', array( 'post' ), $city_args );

	/* Register subject. */

	$subject_labels = array(
		'name' 				=> _x( 'Subjects', 'taxonomy general name', 'sijaishaku-plugin' ),
		'singular_name' 	=> _x( 'Level', 'taxonomy singular name', 'sijaishaku-plugin' ),
		'search_items' 		=> __( 'Search Subjects', 'sijaishaku-plugin' ),
		'all_items' 		=> __( 'All Subjects', 'sijaishaku-plugin' ),
		'parent_item' 		=> _x( 'Parent Subject', 'parent item', 'sijaishaku-plugin' ),
		'parent_item_colon' => _x( 'Parent Subject:', 'parent item colon', 'sijaishaku-plugin' ),
		'edit_item' 		=> __( 'Edit Subjects', 'sijaishaku-plugin' ), 
		'update_item' 		=> __( 'Update Subject', 'sijaishaku-plugin' ),
		'add_new_item' 		=> __( 'Add New Subject', 'sijaishaku-plugin' ),
		'new_item_name' 	=> __( 'New Subject Name', 'sijaishaku-plugin' ),
		'menu_name' 		=> __( 'Subjects', 'sijaishaku-plugin' ),
	); 	

	$subject_args = apply_filters( 'sijaishaku_plugin_subject_args', array(
			'hierarchical' 	=> true,
			'labels' 		=> apply_filters( 'sijaishaku_plugin_subject_labels', $subject_labels ),
			'show_ui' 		=> true,
			'query_var' 	=> 'subject',
			'rewrite' 		=> array( 'slug' => 'oppiaine' )
		)
	);

	register_taxonomy( 'subject', array( 'post' ), $subject_args );
	
	/* Register academy level. */

	$academy_level_labels = array(
		'name' 				=> _x( 'Academy Levels', 'taxonomy general name', 'sijaishaku-plugin' ),
		'singular_name' 	=> _x( 'Level', 'taxonomy singular name', 'sijaishaku-plugin' ),
		'search_items' 		=> __( 'Search Levels', 'sijaishaku-plugin' ),
		'all_items' 		=> __( 'All Levels', 'sijaishaku-plugin' ),
		'parent_item' 		=> _x( 'Parent Level', 'parent item', 'sijaishaku-plugin' ),
		'parent_item_colon' => _x( 'Parent Level:', 'parent item colon', 'sijaishaku-plugin' ),
		'edit_item' 		=> __( 'Edit Levels', 'sijaishaku-plugin' ), 
		'update_item' 		=> __( 'Update Level', 'sijaishaku-plugin' ),
		'add_new_item' 		=> __( 'Add New Level', 'sijaishaku-plugin' ),
		'new_item_name' 	=> __( 'New Level Name', 'sijaishaku-plugin' ),
		'menu_name' 		=> __( 'Levels', 'sijaishaku-plugin' ),
	); 	

	$academy_level_args = apply_filters( 'sijaishaku_plugin_academy_level_args', array(
			'hierarchical' 	=> true,
			'labels' 		=> apply_filters( 'sijaishaku_plugin_academy_level_labels', $academy_level_labels ),
			'show_ui' 		=> true,
			'query_var' 	=> 'academy_level',
			'rewrite' 		=> array( 'slug' => 'kouluaste' )
		)
	);

	register_taxonomy( 'academy_level', array( 'post' ), $academy_level_args );
	
}

?>