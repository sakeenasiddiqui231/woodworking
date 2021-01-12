<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Wooproducts
 * @subpackage Wooproducts/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wooproducts
 * @subpackage Wooproducts/includes
 * @author     Cedcoss <cedcoss@gmail.com>
 */
class Wooproducts_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *function for creating a page while plugin activation
	 *@version 1.0.0 
	 * @since    1.0.0
	 */
	public static function activate() {

	// $res = get_page_by_tittle();
	
  
			if ( ! current_user_can( 'activate_plugins' ) ) return;
			
			global $wpdb;
			
			if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'new-page-slug'", 'ARRAY_A' ) ) {
			   
			  $current_user = wp_get_current_user();
			  
			  // create post object
			  $page = array(
				'post_title'  => __( 'Shop' ),
				'post_status' => 'publish',
				'post_author' => $current_user->ID,
				'post_type'   => 'page',
				'post_content' => '[list-the-posts]'
			  );
			  
			  // insert the post into the database
			  wp_insert_post( $page );
			}


			if ( ! current_user_can( 'activate_plugins' ) ) return;
			
			global $wpdb;
			
			if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'new-page-slug'", 'ARRAY_A' ) ) {
			   
			  $current_user = wp_get_current_user();
			  
			  // create post object
			  $page = array(
				'post_title'  => __( 'Cart' ),
				'post_status' => 'publish',
				'post_author' => $current_user->ID,
				'post_type'   => 'page2',
				'post_content' => '[list-the-cart]'
				
			  );
			  
			  // insert the post into the database
			  wp_insert_post( $page );
			}
		
}
}
