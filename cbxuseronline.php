<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wpboxr.com
 * @since             1.0.0
 * @package           Cbxuseronline
 *
 * @wordpress-plugin
 * Plugin Name:       CBX User Online
 * Plugin URI:        http://wpboxr.com/product/cbx-user-online-for-wordpress
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            WPBoxr
 * Author URI:        http://wpboxr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbxuseronline
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define('CBX_USERONLINE_COOKIE_NAME', 'cbxuseronline-cookie');
define('CBX_USERONLINE_RAND_MIN', 0);
define('CBX_USERONLINE_RAND_MAX', 999999);
define('CB_RATINGSYSTEM_COOKIE_EXPIRATION_30DAYS', time() + 2592000 ); //Expiration of 30.



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cbxuseronline-activator.php
 */
function activate_cbxuseronline() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbxuseronline-activator.php';
	Cbxuseronline_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cbxuseronline-deactivator.php
 */
function deactivate_cbxuseronline() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbxuseronline-deactivator.php';
	Cbxuseronline_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cbxuseronline' );
register_deactivation_hook( __FILE__, 'deactivate_cbxuseronline' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path( __FILE__ ) . 'includes/class-cbxuseronline-helper.php'; //helper method , call all statically
require_once( plugin_dir_path( __FILE__ ).'includes/class-cbxuseronlinesettings.php'); //add the setting api
require plugin_dir_path( __FILE__ ) . 'widgets/cbxonline-widget.php'; //widget
require plugin_dir_path( __FILE__ ) . 'includes/class-cbxuseronline.php'; //main core plugin file

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cbxuseronline() {

	$plugin = new Cbxuseronline();
	$plugin->run();

}


run_cbxuseronline();
