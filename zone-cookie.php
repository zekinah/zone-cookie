<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/zekinah/
 * @since             1.0.0
 * @package           Zone_Cookie
 *
 * @wordpress-plugin
 * Plugin Name:       Zone - Cookie
 * Plugin URI:        https://github.com/zekinah/zone-cookie.git
 * Description:       Addon for GDPR Compliance and CCPA Compliance.
 * Version:           1.0.9
 * Author:            Zekinah Lecaros
 * Author URI:        https://github.com/zekinah/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       zone-cookie
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
	exit;
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'Zone_Cookie_VERSION', '1.0.9' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-zone-cookie-activator.php
 */
function activate_Zone_Cookie() {
	require_once plugin_dir_path(__FILE__) . 'model/Config.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-zone-cookie-activator.php';
	Zone_Cookie_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-zone-cookie-deactivator.php
 */
function deactivate_Zone_Cookie() {
	require_once plugin_dir_path( __FILE__ ) . 'model/Config.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-zone-cookie-deactivator.php';
	Zone_Cookie_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Zone_Cookie' );
register_deactivation_hook( __FILE__, 'deactivate_Zone_Cookie' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-zone-cookie.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Zone_Cookie() {

	$plugin = new Zone_Cookie();
	$plugin->run();

}
run_Zone_Cookie();
