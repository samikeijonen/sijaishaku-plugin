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
	
		$tax_query = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'city',
				'field' => 'id',
				'terms' => isset( $sijaishaku_plugin_filter_home_cat ) ? $sijaishaku_plugin_filter_home_cat : ''
			),
			array(
				'taxonomy' => 'subject',
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
				'taxonomy' => 'city',
				'field' => 'id',
				'terms' => isset( $sijaishaku_plugin_filter_home_cat ) ? $sijaishaku_plugin_filter_home_cat : ''
			),
			array(
				'taxonomy' => 'subject',
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
		<span itemprop="telephone" class="sijaishaku-phone"><span class="sijaishaku-plugin-phone"><?php  _e( 'Phone: ', 'sijaishaku-plugin' ); ?></span><a href="tel:<?php echo sijaishaku_plugin_get_phone(); ?>"><?php echo sijaishaku_plugin_get_phone(); ?></a></span>
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

/**
 * Get the current page URL.
 *
 * @since 0.1.0
 * @return string $page_url Current page URL
 */
function sijaishaku_plugin_current_page_url() {
global $post;

if ( is_front_page() ) :
	$page_url = home_url();
else :
	$page_url = 'http';
 
	if ( isset( $_SERVER["HTTPS"] ) && $_SERVER["HTTPS"] == "on" )
		$page_url .= "s";
 
	$page_url .= "://";

	if ( $_SERVER["SERVER_PORT"] != "80" )
		$page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
		$page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	endif;
 
	return apply_filters( 'sijaishaku_plugin_current_page_url', esc_url( $page_url ) );
}

/**
 * Get checkboxes from taxonomies.
 *
 * @since 0.1.0

 */
function sijaishaku_plugin_get_checkboxes() { 

		ob_start(); ?>
				<div id="sijaishaku-check">
								
					<div id="sijaishaku-cat-check">
						<h3><?php _e( 'City', 'sijaishaku-plugin' ); ?></h3>
						<?php
						/* Get  custom taxonomies ids from in array in this post. */
						$terms = get_the_terms( absint( $_GET['gform_post_id'] ), 'city' );
						
						if ( $terms && ! is_wp_error( $terms ) ) { 

							$cities = array();

							foreach ( $terms as $term ) {
								$cities[] = $term->term_id;
							}
							
						}
						
						$sijaishaku_categories = get_categories( array( 'taxonomy' => 'city' ) ); 
						foreach ( $sijaishaku_categories as $sijaishaku_category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_city[]" id="filter_city_' . $sijaishaku_category->cat_ID . '" value="'. $sijaishaku_category->cat_ID . '"';
							if ( !empty( $cities ) && in_array( $sijaishaku_category->cat_ID, $cities ) ) { $checkboxes .= 'checked="checked"'; }
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_city_' . $sijaishaku_category->cat_ID . '">';
							$checkboxes .= $sijaishaku_category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
						?>
					</div><!-- #sijaishaku-cat-check -->
							
					<div id="sijaishaku-tag-check">
						<h3><?php _e( 'Subject', 'sijaishaku-plugin' ); ?></h3>
						<?php
						/* Get  custom taxonomies ids from in array in this post. */
						$terms = get_the_terms( absint( $_GET['gform_post_id'] ), 'subject' );
						
						if ( $terms && ! is_wp_error( $terms ) ) { 

							$subjects = array();

							foreach ( $terms as $term ) {
								$subjects[] = $term->term_id;
							}
							
						}
						
						$sijaishaku_tags = get_categories( array( 'taxonomy' => 'subject' ) ); 
						foreach ( $sijaishaku_tags as $sijaishaku_tag ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_subject[]" id="filter_subject_' . $sijaishaku_tag->cat_ID . '" value="'. $sijaishaku_tag->cat_ID . '"';
							if ( !empty( $subjects ) && in_array( $sijaishaku_tag->cat_ID, $subjects ) ) { $checkboxes .= 'checked="checked"'; }
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_subject_' . $sijaishaku_tag->cat_ID . '">';
							$checkboxes .= $sijaishaku_tag->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
						?>
					</div><!-- #sijaishaku-tag-check -->
							
					<div id="sijaishaku-level-check">
						<h3><?php _e( 'Academy level', 'sijaishaku-plugin' ); ?></h3>
						<?php
						/* Get  custom taxonomies ids from in array in this post. */
						$terms = get_the_terms( absint( $_GET['gform_post_id'] ), 'academy_level' );
						
						if ( $terms && ! is_wp_error( $terms ) ) { 

							$academy_levels = array();

							foreach ( $terms as $term ) {
								$academy_levels[] = $term->term_id;
							}
							
						}
						$sijaishaku_levels = get_categories( array( 'taxonomy' => 'academy_level' ) ); 
						foreach ( $sijaishaku_levels as $sijaishaku_level ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_level[]" id="filter_level_' . $sijaishaku_level->cat_ID . '" value="'. $sijaishaku_level->cat_ID . '"';
							if ( !empty( $academy_levels ) && in_array( $sijaishaku_level->cat_ID, $academy_levels ) ) { $checkboxes .= 'checked="checked"'; }
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_level_' . $sijaishaku_level->cat_ID . '">';
							$checkboxes .= $sijaishaku_level->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
						?>
					</div><!-- #sijaishaku-level-check -->
									
				</div><!-- #sijaishaku-check -->

<?php

	return ob_get_clean();

}
?>