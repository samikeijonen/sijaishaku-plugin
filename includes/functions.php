<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Filter search by category and tag search page.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_search( $query ) {
	
	if ( is_search() && !is_admin() && $query-> is_main_query() ) {
	
		/* Validate data. If is array meaning multiple choihes validate with array_map. */
		if ( is_array( $_GET['filter_cat'] ) ) {
			$sijaishaku_plugin_filter_cat = array_map( 'absint', $_GET['filter_cat'] );
		} else {
			$sijaishaku_plugin_filter_cat = absint( $_GET['filter_cat'] );
		}
	
		if ( is_array( $_GET['filter_tag'] ) ) {
			$sijaishaku_plugin_filter_tag = array_map( 'absint', $_GET['filter_tag'] );
		} else {
			$sijaishaku_plugin_filter_tag= absint( $_GET['filter_tag'] );
		}
	
		$query->set( 'category__in', $sijaishaku_plugin_filter_cat );
		$query->set( 'tag__in', $sijaishaku_plugin_filter_tag );
	}
}
add_action( 'pre_get_posts', 'sijaishaku_plugin_search' );

/**
 * Filter search in home page. Check that set-search from hidden field is set to on.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_home_filter( $query ) {
	
	if ( is_home() && !is_admin() && $query-> is_main_query() && isset( $_POST['set-search'] ) && 'on' == esc_attr( $_POST['set-search'] ) && wp_verify_nonce( $_POST['sijaishaku-nonce'], 'sijaishaku-nonce' ) ) {
	
		/* Validate data. If is array meaning multiple choices validate with array_map. */
		if ( is_array( $_POST['filter_cat'] ) ) {
			$sijaishaku_plugin_filter_home_cat = array_map( 'absint', $_POST['filter_cat'] );
		} else {
			$sijaishaku_plugin_filter_home_cat = absint( $_POST['filter_cat'] );
		}
	
		if ( is_array( $_POST['filter_tag'] ) ) {
			$sijaishaku_plugin_filter_home_tag = array_map( 'absint', $_POST['filter_tag'] );
		} else {
			$sijaishaku_plugin_filter_home_tag = absint( $_POST['filter_tag'] );
		}
		
		if ( is_array( $_POST['filter_level'] ) ) {
			$sijaishaku_plugin_filter_home_level = array_map( 'absint', $_POST['filter_level'] );
		} else {
			$sijaishaku_plugin_filter_home_level = absint( $_POST['filter_level'] );
		}
		
		$tax_query = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => isset( $sijaishaku_plugin_filter_home_cat ) ? $sijaishaku_plugin_filter_home_cat : ''
			),
			array(
				'taxonomy' => 'post_tag',
				'field' => 'id',
				'terms' => isset( $sijaishaku_plugin_filter_home_tag ) ? $sijaishaku_plugin_filter_home_tag : ''
			),
			array(
				'taxonomy' => 'academy_level',
				'field' => 'id',
				'terms' => isset( $sijaishaku_plugin_filter_home_level ) ? $sijaishaku_plugin_filter_home_level : ''
			)
		);
	
		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'sijaishaku_plugin_home_filter' );

/**
 * Get author name.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_name() {
	
	$name = esc_attr( get_the_author_meta( 'display_name' ) );
	
	return $name;

}

/**
 * Get author email.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_email() {
							
	$email = esc_attr( get_the_author_meta( 'user_email' ) );
	
	return $email;

}

/**
 * Get author phone.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_phone() {
	
	$phone = esc_attr( get_the_author_meta( 'phone' ) );
	
	return $phone;

}

/**
 * Output author name, email and phone.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_output_name_email_phone() { ?>

	<div itemscope itemtype="http://schema.org/Person" class="sijaishaku-plugin-name-email-phone">
		<span itemprop="name" class="sijaishaku-name"><span class="sijaishaku-plugin-name"><?php  _e( 'Name: ', 'sijaishaku-plugin' ); ?></span><?php echo sijaishaku_plugin_get_name(); ?></span>
		<span itemprop="email" class="sijaishaku-email"><span class="sijaishaku-plugin-email"><?php  _e( 'Email: ', 'sijaishaku-plugin' ); ?></span><?php echo antispambot( sijaishaku_plugin_get_email() ); ?></span>
		<span itemprop="telephone" class="sijaishaku-phone"><span class="sijaishaku-plugin-phone"><?php  _e( 'Phone: ', 'sijaishaku-plugin' ); ?></span><?php echo sijaishaku_plugin_get_phone(); ?></span>
	</div>

<?php

}

/**
 * Add base plugin css. 
 *
 * @since 0.1.0
 */
 function sijaishaku_plugin_css() {

	wp_enqueue_style( 'sijais-plugin-stylesheet', SIJAISHAKU_PLUGIN_URL . 'css/sijaishaku-plugin-styles.css', false, '20130813', 'all' );

}
add_action( 'wp_enqueue_scripts', 'sijaishaku_plugin_css' );

?>