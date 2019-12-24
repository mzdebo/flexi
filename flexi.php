<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://odude.com/
 * @since             1.0.0
 * @package           Flexi
 *
 * @wordpress-plugin
 * Plugin Name:       Flexi
 * Plugin URI:        https://odude.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ODude
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       flexi
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

// The current version of the plugin
if ( !defined( 'FLEXI_VERSION' ) ) {
	define( 'FLEXI_VERSION', '1.0.0' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-flexi-activator.php
 */
function activate_flexi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flexi-activator.php';
	Flexi_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-flexi-deactivator.php
 */
function deactivate_flexi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flexi-deactivator.php';
	Flexi_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_flexi' );
register_deactivation_hook( __FILE__, 'deactivate_flexi' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-flexi.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_flexi() {

	$plugin = new Flexi();
	$plugin->run();

}
run_flexi();