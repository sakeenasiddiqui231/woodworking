<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cedcoss.com/
 * @since             1.0.0
 * @package           Wooproducts
 *
 * @wordpress-plugin
 * Plugin Name:       WooProducts
 * Version:           1.0.0
 * Author:            Cedcoss
 * Author URI:        https://cedcoss.com/
 * License:           GPL-2.0+
 * Text Domain:       wooproducts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOPRODUCTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wooproducts-activator.php
 */
function activate_wooproducts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wooproducts-activator.php';
	Wooproducts_Activator::activate();
	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wooproducts-deactivator.php
 */
function deactivate_wooproducts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wooproducts-deactivator.php';
	Wooproducts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wooproducts' );
register_deactivation_hook( __FILE__, 'my_plugin_uninstall' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wooproducts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wooproducts() {

	$plugin = new Wooproducts();
	$plugin->run();

}
run_wooproducts();
