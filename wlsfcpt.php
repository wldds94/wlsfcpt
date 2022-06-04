<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlsfcpt
 *
 * @wordpress-plugin
 * Plugin Name:       SayFarm Products CPT
 * Plugin URI:        walterlaidelli.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Walter Laidelli
 * Author URI:        walterlaidelli.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wlsfcpt
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
define( 'WLSFCPT_VERSION', '1.0.0' );

if ( ! defined( 'WLSFCPT_PLUGIN_PATH' ) ) {
	define( 'WLSFCPT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WLSFCPT_PLUGIN_URL' ) ) {
	define( 'WLSFCPT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WLSFCPT_PLUGIN' ) ) {
	define( 'WLSFCPT_PLUGIN', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'WLSFCPT_PLUGIN_PUBLIC_TMPL_PATH' ) ) {
	define( 'WLSFCPT_PLUGIN_PUBLIC_TMPL_PATH', plugin_dir_path( __FILE__ ) . 'views/public/' );
}

/**
 * Composer
 */
// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation.
 * This action is documented in Inc\Base\Activate.php
 */
function activate_wlddssfpl() {
	$activator = new Wlsfcpt\Base\Activate();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in Inc\Base\Deactivate.php
 */
function deactivate_wlddssfpl() {
	$deactivator = new Wlsfcpt\Base\Deactivate();
	$deactivator->deactivate();
}

register_activation_hook( __FILE__, 'activate_wlddssfpl' );
register_deactivation_hook( __FILE__, 'deactivate_wlddssfpl' );

/**
 * Begins execution of the plugin.
 *
 * Initialize all the core classes of the plugin.
 * 
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * 
 * @since    1.0.0
 */
if ( class_exists( 'Wlsfcpt\\Init' ) ) {
	Wlsfcpt\Init::register_services();
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
// require plugin_dir_path( __FILE__ ) . 'includes/class-wlsfcpt.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
// function run_wlsfcpt() {

// 	$plugin = new Wlsfcpt();
// 	$plugin->run();

// }
// run_wlsfcpt();
