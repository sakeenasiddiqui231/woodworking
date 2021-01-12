<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Wooproducts
 * @subpackage Wooproducts/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wooproducts
 * @subpackage Wooproducts/includes
 * @author     Cedcoss <cedcoss@gmail.com>
 */
class Wooproducts_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {




		function deactivate_plugin() {

			$page = get_page_by_path( 'shop' );
			wp_delete_post($page->ID);
		
		 }
		// register_deactivation_hook( __FILE__, 'deactivate_plugin' );

	}

}
