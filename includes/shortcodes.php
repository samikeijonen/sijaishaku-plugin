<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Login Shortcode
 *
 * Shows a login form allowing users to log in.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_login_form_shortcode( $atts, $content = null ) {

	ob_start();

	if ( ! is_user_logged_in() ) { ?>

		<p>
			<?php wp_login_form(); ?>
		</p>
		<p>
			<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" title="<?php _e( 'Lost password?', 'sijaishaku-plugin' ); ?>"><?php _e( 'Lost password?', 'sijaishaku-plugin' ); ?></a>
		</p>
		
	<?php } else {
		echo '';
	}
	
	return ob_get_clean();
	
}
add_shortcode( 'sijaishaku_plugin_login', 'sijaishaku_plugin_login_form_shortcode' );

/**
 * Get current user post(s). Should be only one.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_posts( $atts, $content = null ) {

	ob_start();

	if ( is_user_logged_in() && !isset( $_GET['edit'] ) && !isset( $_GET['delete'] ) ) {
		
		/* Get user posts. */
		$sijaishaku_plugin_author_posts =  get_posts( 'author=' . get_current_user_id() . '&posts_per_page=-1' );
		
		if( $sijaishaku_plugin_author_posts ) {
			echo '<ul>';
			foreach ( $sijaishaku_plugin_author_posts as $sijaishaku_plugin_author_post )  {
				echo '<li>' . $sijaishaku_plugin_author_post->post_title . ' | <a href="' . wp_nonce_url( '?edit=on&gform_post_id=' . $sijaishaku_plugin_author_post->ID, 'edit_link' ) . '">' . __( 'Click to edit', 'sijaishaku-plugin' ) . '</a> | <a href="' . wp_nonce_url( '?delete=on&delete_id=' . $sijaishaku_plugin_author_post->ID, 'delete_link' )  . '">' . __( 'Delete', 'sijaishaku-plugin' ) . '</a></li>';
			}
			echo '</ul>';
		}
		
	} elseif ( isset( $_GET['delete_id'] ) && is_user_logged_in() && 'on' == esc_attr( $_GET['delete'] ) && current_user_can( 'edit_post', absint( $_GET['delete_id'] ) ) && wp_verify_nonce( $_GET['_wpnonce'], 'delete_link' ) ) {
					
		/* Delete a post when have rights to do that. */
		wp_delete_post( absint( $_GET['delete_id'] ) );
		echo '<p class="sijaishaku-post-deleted">' . __( 'Post was deleted succesfully.', 'sijaishaku-plugin' ) . '</p>';
		
	} else {
		echo '';
	}
	
	return ob_get_clean();
	
}
add_shortcode( 'sijaishaku_plugin_user_posts', 'sijaishaku_plugin_get_posts' );

/**
 * Search posts with checkboxes.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_search_posts( $atts, $content = null ) {

	ob_start(); ?>

		<form role="search" method="post" class="search-form" action="#sijaishaku-search-results">
			<div class="sijaishaku-search">
				<?php wp_nonce_field( 'sijaishaku-nonce', 'sijaishaku-nonce' ); ?>
				<input type="hidden" name="set-search" id="set-search" value="on">
				
				<div id="sijaishaku-cat-check">
				<p><strong><?php _e( 'Towns', 'sijaishaku-plugin' ); ?></strong></p>
					<?php
						$categories = get_categories(); 
						foreach ( $categories as $category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_cat[]" id="filter_cat_' . $category->cat_ID . '" value="'. $category->cat_ID . '"';
							if ( isset( $_POST['filter_cat'] ) ) {
								if ( in_array( $category->cat_ID, $_REQUEST['filter_cat'] ) ) { $checkboxes .= 'checked="checked"'; }
							}
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_cat_' . $category->cat_ID . '">';
							$checkboxes .= $category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
					?>
				</div>
							
				<div id="sijaishaku-tag-check">
				<p><strong><?php _e( 'Subjects', 'sijaishaku-plugin' ); ?></strong></p>
					<?php
						$categories = get_categories( array( 'taxonomy' => 'post_tag' ) ); 
						foreach ( $categories as $category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_tag[]" id="filter_tag_' . $category->cat_ID . '" value="'. $category->cat_ID . '"';
							if ( isset( $_POST['filter_tag'] ) ) { 
								if ( in_array( $category->cat_ID, $_REQUEST['filter_tag'] ) ) { $checkboxes .= 'checked="checked"'; } 
							}
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_tag_' . $category->cat_ID . '">';
							$checkboxes .= $category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
					?>
				</div>
				
				<div id="sijaishaku-level-check">
				<p><strong><?php _e( 'Levels', 'sijaishaku-plugin' ); ?></strong></p>
					<?php
						$categories = get_categories( array( 'taxonomy' => 'academy_level' ) ); 
						foreach ( $categories as $category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_level[]" id="filter_level_' . $category->cat_ID . '" value="'. $category->cat_ID . '"';
							if ( isset( $_POST['filter_level'] ) ) { 
								if ( in_array( $category->cat_ID, $_REQUEST['filter_level'] ) ) { $checkboxes .= 'checked="checked"'; } 
							}
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_level_' . $category->cat_ID . '">';
							$checkboxes .= $category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
					?>
				</div>
			</div><!-- .sijaishaku-search -->	
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'sijaishaku-plugin' ); ?>" />
		</form>
		
		<?php if ( isset( $_POST['set-search'] ) && 'on' == esc_attr( $_POST['set-search'] ) && wp_verify_nonce( $_POST['sijaishaku-nonce'], 'sijaishaku-nonce' ) ) : ?>
		
		<?php
		/* Set custom query to show post from get method. */
		$sijaishaku_posts_args = apply_filters( 'sijaishaku_result_page_post_arguments', array(
			'post_type'           => 'post',
			'posts_per_page'      => 9999,
			//'paged'               => ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ),
			'ignore_sticky_posts' => 1,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => isset( $_POST['filter_cat'] ) ? $_POST['filter_cat'] : ''
				),
				array(
					'taxonomy' => 'post_tag',
					'field' => 'id',
					'terms' => isset( $_POST['filter_tag'] ) ? $_POST['filter_tag'] : ''
				),
				array(
					'taxonomy' => 'academy_level',
					'field' => 'id',
					'terms' => isset( $_POST['filter_level'] ) ? $_POST['filter_level'] : ''
				)
			)
		) );
			
		$sijaishaku_posts = new WP_Query( $sijaishaku_posts_args );
		?>
		
		<h3 id="sijaishaku-search-results"><?php _e( 'Search results', 'sijaishaku-plugin' ); ?></h3>
		
		<div class="sijaishaku-latest-wrap">
			
			<?php if ( $sijaishaku_posts->have_posts() ) : ?>

				<?php while ( $sijaishaku_posts->have_posts() ) : $sijaishaku_posts->the_post(); ?>
				
					<article <?php hybrid_post_attributes(); ?>>
	
						<header class="entry-header">
							<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
							<?php $time = get_the_time( get_option( 'date_format' ) ); ?>
							<?php echo '<div class="entry-byline"><span class="author vcard"><a class="url fn n" rel="author" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></span><time class="entry-date" class="published" datetime="' . get_the_time( 'Y-m-d\TH:i:sP' ) . '" title="' . get_the_time( esc_attr__( 'l, F jS, Y, g:i a', 'sijaishaku-plugin' ) ) . '">' . ' ' . $time . '</time></div>'; ?>
						</header><!-- .entry-header -->
		
						<div class="entry-content">
							<?php echo apply_filters( 'sijaishaku_plugin_search_content', get_post_field( 'post_content', get_the_ID() ) ); ?>
							<p>
								<?php echo sijaishaku_plugin_output_name_email_phone(); ?>
							</p>
						</div><!-- .entry-content -->
							
						<footer class="entry-footer">
							<?php echo '<div class="entry-meta">' . __( 'Posted in', 'sijaishaku-plugin' )  . get_the_term_list( get_the_ID(), 'category', ' ', ', ', ' | ' ) . ' ' . __( 'Tagged', 'sijaishaku-plugin' )  . get_the_term_list( get_the_ID(), 'post_tag', ' ', ', ', ' | ' ) . ' ' . __( 'Academy level', 'sijaishaku-plugin' )  . get_the_term_list( get_the_ID(), 'academy_level', ' ', ', ', '' ) . '</div>'; ?>
						</footer><!-- .entry-footer -->

					</article><!-- .hentry -->

				<?php endwhile; ?>
				
				<?php //get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

			<?php else : ?>

				<h1 class="entry-title"><?php _e( 'Nothing found', 'sijaishaku-plugin' ); ?></h1>

				<p><?php _e( 'Apologies, but no entries were found.', 'sijaishaku-plugin' ); ?></p>

			<?php endif; wp_reset_postdata(); // reset query. ?>
			
		</div><!-- .sijaishaku-latest-wrap -->
			
		<?php endif; ?>
	
	<?php return ob_get_clean();
	
}
add_shortcode( 'sijaishaku_plugin_search_posts', 'sijaishaku_plugin_get_search_posts' );

/**
 * Search posts with checkboxes.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_search_home_posts( $atts, $content = null ) {

	ob_start(); ?>

		<form role="search" method="post" class="search-form" action="<?php echo trailingslashit( home_url() ); ?>">
			<div class="sijaishaku-search">
				<?php wp_nonce_field( 'sijaishaku-nonce', 'sijaishaku-nonce' ); ?>
				<input type="hidden" name="set-search" id="set-search" value="on">
				
				<div id="sijaishaku-cat-check">
				<p><strong><?php _e( 'Towns', 'sijaishaku' ); ?></strong></p>
					<?php
						$categories = get_categories(); 
						foreach ( $categories as $category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_cat[]" id="filter_cat_' . $category->cat_ID . '" value="'. $category->cat_ID . '"';
							if ( isset( $_POST['filter_cat'] ) ) {
								if ( in_array( $category->cat_ID, $_REQUEST['filter_cat'] ) ) { $checkboxes .= 'checked="checked"'; }
							}
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_cat_' . $category->cat_ID . '">';
							$checkboxes .= $category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
					?>
				</div>
							
				<div id="sijaishaku-tag-check">
				<p><strong><?php _e( 'Subjects', 'sijaishaku' ); ?></strong></p>
					<?php
						$categories = get_categories( array( 'taxonomy' => 'post_tag' ) ); 
						foreach ( $categories as $category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_tag[]" id="filter_tag_' . $category->cat_ID . '" value="'. $category->cat_ID . '"';
							if ( isset( $_POST['filter_tag'] ) ) { 
								if ( in_array( $category->cat_ID, $_REQUEST['filter_tag'] ) ) { $checkboxes .= 'checked="checked"'; } 
							}
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_tag_' . $category->cat_ID . '">';
							$checkboxes .= $category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
					?>
				</div>
				
				<div id="sijaishaku-level-check">
				<p><strong><?php _e( 'Levels', 'sijaishaku' ); ?></strong></p>
					<?php
						$categories = get_categories( array( 'taxonomy' => 'academy_level' ) ); 
						foreach ( $categories as $category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_level[]" id="filter_level_' . $category->cat_ID . '" value="'. $category->cat_ID . '"';
							if ( isset( $_POST['filter_level'] ) ) { 
								if ( in_array( $category->cat_ID, $_REQUEST['filter_level'] ) ) { $checkboxes .= 'checked="checked"'; } 
							}
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_level_' . $category->cat_ID . '">';
							$checkboxes .= $category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
					?>
				</div>
			</div><!-- .sijaishaku-search -->	
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'sijaishaku' ); ?>" />
		</form>
	
	<?php return ob_get_clean();
	
}
add_shortcode( 'sijaishaku_plugin_search_home_posts', 'sijaishaku_plugin_get_search_home_posts' );

/**
 * List of categories, tags and academy levels.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_cat_tag_level( $atts, $content = null ) {

	ob_start(); ?>

		<div id="sijaishaku-list-by">
					
			<div id="sijaishaku-list-by-towns">
				<h2><?php _e( 'List by towns', 'sijaishaku-plugin' ); ?></h2>
					
				<?php
				/* Get gategories. */
				$sijaishaku_cat_args = array(
					'title_li'     => ''
				);
				?>
					
				<ul>
					<?php wp_list_categories( $sijaishaku_cat_args ); ?>
				</ul>
			</div><!-- .sijaishaku-list-by-towns -->
					
			<div id="sijaishaku-list-by-subjects">
				<h2><?php _e( 'List by subject', 'sijaishaku-plugin' ); ?></h2>
					
				<?php
				/* Get tags. */
				$sijaishaku_tag_args = array(
					'title_li'     => '',
					'taxonomy'     => 'post_tag'
				);
				?>
					
				<ul>
					<?php wp_list_categories( $sijaishaku_tag_args ); ?>
				</ul>
			</div><!-- .sijaishaku-list-by-subjects -->
					
			<div id="sijaishaku-list-by-levels">
				<h2><?php _e( 'List by level', 'sijaishaku-plugin' ); ?></h2>
					
				<?php
				/* Get academy_level custom taxonomy. */
				$sijaishaku_level_args = array(
					'title_li'     => '',
					'taxonomy'     => 'academy_level'
				);
				?>
					
				<ul>
					<?php wp_list_categories( $sijaishaku_level_args ); ?>
				</ul>
			</div><!-- .sijaishaku-list-by-levels -->
							
		</div><!-- #sijaishaku-list-by -->
						
	<?php return ob_get_clean();

}						
add_shortcode( 'sijaishaku_plugin_list_cat_tag_level', 'sijaishaku_plugin_get_cat_tag_level' );

/**
 * Custom search form.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_get_custom_search( $atts, $content = null ) {

	ob_start(); ?>

		<form role="search" method="get" class="search-form" action="<?php echo trailingslashit( home_url() ); ?>">
			<div class="sijaishaku-search">
				<input type="hidden" name="post_type" value="post" />
				<label class="screen-reader-text" for="s"><?php __( 'Search for:', 'sijaishaku-plugin' ); ?></label>
				<input type="text" value="" name="s" id="s" />
							
				<div id="sijaishaku-check">
								
					<div id="sijaishaku-cat-check">
						<?php
						$sijaishaku_categories = get_categories(); 
						foreach ( $sijaishaku_categories as $sijaishaku_category ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_cat[]" id="filter_cat_' . $sijaishaku_category->cat_ID . '" value="'. $sijaishaku_category->cat_ID . '"';
							//if ( in_array( $sijaishaku_category->cat_ID, $_REQUEST['filter_cat'] ) ) { $checkboxes .= 'checked="checked"'; }
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_cat_' . $sijaishaku_category->cat_ID . '">';
							$checkboxes .= $sijaishaku_category->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
						?>
					</div><!-- #sijaishaku-cat-check -->
							
					<div id="sijaishaku-tag-check">
						<?php
						$sijaishaku_tags = get_categories( array( 'taxonomy' => 'post_tag' ) ); 
						foreach ( $sijaishaku_tags as $sijaishaku_tag ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_tag[]" id="filter_tag_' . $sijaishaku_tag->cat_ID . '" value="'. $sijaishaku_tag->cat_ID . '"';
							//if ( in_array( $sijaishaku_tag->cat_ID, $_REQUEST['filter_cat'] ) ) { $checkboxes .= 'checked="checked"'; }
							$checkboxes .= ' />';
							$checkboxes .= '<label for="filter_tag_' . $sijaishaku_tag->cat_ID . '">';
							$checkboxes .= $sijaishaku_tag->cat_name;
							$checkboxes .= '</label>';
							//$checkboxes .= '</li>';
							echo $checkboxes;
						}
						?>
					</div><!-- #sijaishaku-tag-check -->
							
					<div id="sijaishaku-level-check">
						<?php
						$sijaishaku_levels = get_categories( array( 'taxonomy' => 'academy_level' ) ); 
						foreach ( $sijaishaku_levels as $sijaishaku_level ) {
							//$checkboxes ='<li>';
							$checkboxes = '<input type="checkbox" name="filter_level[]" id="filter_level_' . $sijaishaku_level->cat_ID . '" value="'. $sijaishaku_level->cat_ID . '"';
							//if ( in_array( $sijaishaku_level->cat_ID, $_REQUEST['filter_cat'] ) ) { $checkboxes .= 'checked="checked"'; }
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
							
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'sijaishaku-plugin' ); ?>" />
		</form>
		
	<?php return ob_get_clean();

}					
add_shortcode( 'sijaishaku_plugin_custom_search', 'sijaishaku_plugin_get_custom_search' );

/**
 * For logged out users.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_visitor_check_shortcode( $atts, $content = null ) {

	 if ( ( !is_user_logged_in() && !is_null( $content ) ) || is_feed() )
		return do_shortcode( $content );
	return '';
	
}
add_shortcode( 'sijaishaku_plugin_visitor', 'sijaishaku_plugin_visitor_check_shortcode' );

/**
 * For logged in users.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_logged_check_shortcode( $atts, $content = null ) {

	 if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return $content;
	return '';
	
}
add_shortcode( 'sijaishaku_plugin_logged', 'sijaishaku_plugin_logged_check_shortcode' );

/**
 * Show edit form only if certain criteria are in place.
 *
 * @since 0.1.0
 */
function sijaishaku_plugin_edit_form_shortcode( $atts, $content = null ) {

	 if ( is_user_logged_in() && !is_null( $content ) && !is_feed() && isset( $_GET['gform_post_id'] ) && 'on' == esc_attr( $_GET['edit'] ) && current_user_can( 'edit_post', absint( $_GET['gform_post_id'] ) ) && wp_verify_nonce( $_GET['_wpnonce'], 'edit_link' ) )
		return do_shortcode( $content );
	return '';
	
}
add_shortcode( 'sijaishaku_plugin_edit_form', 'sijaishaku_plugin_edit_form_shortcode' );

?>