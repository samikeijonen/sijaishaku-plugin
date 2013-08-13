<?php
/**
 * Setup Download Taxonomies
 *
 * Registers the custom taxonomy download features.
 *
 * @since 0.1.0
*/

add_action( 'init', 'sijaishaku_plugin_taxonomies' );

function sijaishaku_plugin_taxonomies() {

	$feature_labels = array(
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

	$feature_args = apply_filters( 'sijaishaku_plugin_feature_args', array(
			'hierarchical' 	=> true,
			'labels' 		=> apply_filters( 'sijaishaku_plugin_feature_labels', $feature_labels ),
			'show_ui' 		=> true,
			'query_var' 	=> 'academy_level',
			'rewrite' 		=> array( 'slug' => 'kouluaste' )
		)
	);

	register_taxonomy( 'academy_level', array( 'post' ), $feature_args );
	
}

?>