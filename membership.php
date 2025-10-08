<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mydevitsolutions.com
 * @since             1.0.0
 * @package           Membership
 *
 * @wordpress-plugin
 * Plugin Name:       Mydevit Membership
 * Plugin URI:        https://mydevitsolutions.com/plugins
 * Description:       WordPress plugin that enables website owners to manage subscriptions and memberships
 * Version:           1.0.0
 * Author:            Sumit Yadav
 * Author URI:        https://mydevitsolutions.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       membership
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
define( 'MEMBERSHIP_VERSION', '1.0.0' );
define( 'MEMBERSHIP_SITE_HOME_URL', home_url() );
define( 'MEMBERSHIP_PATH', dirname( __FILE__ ) . '/' );
define( 'MEMBERSHIP_URL', plugins_url( '', __FILE__ ) );
define( 'MEMBERSHIP_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
define( 'MEMBERSHIP_TEMPLATE_PATH', 'membership_temp' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-membership-activator.php
 */
function activate_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-membership-activator.php';
	Membership_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-membership-deactivator.php
 */
function deactivate_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-membership-deactivator.php';
	Membership_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_membership' );
register_deactivation_hook( __FILE__, 'deactivate_membership');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-membership.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-membership-settings.php';

//Add settings link in plugins listing page
function swpm_add_settings_link( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$settings_link = '<a href="admin.php?page=my_membership_settings">Settings</a>';
		array_unshift( $links, $settings_link );
	}
	return $links;
}
add_filter( 'plugin_action_links', 'swpm_add_settings_link', 10, 2 );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_membership() {

	$plugin = new Membership();
	$plugin->run();

}
run_membership();
