<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Wooboiler
 * @subpackage Wooboiler/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wooboiler
 * @subpackage Wooboiler/includes
 * @author     cedcoss <cedcoss@gmail.com>
 */
class Wooboiler_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
      //die("hello boiler");
	//echo "hello boiler";
	if( !is_plugin_active('wood-plugin/wood-plugin.php') ) {

		die("plugin wood is not activated");
		
	}

	}

}
