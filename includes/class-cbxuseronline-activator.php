<?php

/**
 * Fired during plugin activation
 *
 * @link       http://wpboxr.com
 * @since      1.0.0
 *
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/includes
 * @author     WPBoxr <info@wpboxr.com>
 */
class Cbxuseronline_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		// charset_collate Defination

		$useronline_table = $wpdb->prefix . 'cbxuseronline';




		// Table Names Defined

		$sql = "CREATE TABLE $useronline_table (
          `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `user_type` varchar( 20 ) NOT NULL default 'guest',
		  `userid` varchar ( 25 ) NOT NULL default '',
		  `user_name` varchar( 250 ) NOT NULL default '',
		  `user_ip` varchar( 39 ) NOT NULL default '',
		  `user_agent` text NOT NULL,
		  `page_title` text NOT NULL,
		  `page_url` varchar( 255 ) NOT NULL default '',
		  `referral` varchar( 255 ) NOT NULL default '',
		  `mobile` tinyint(1 ) NOT NULL default '0'
          ) $charset_collate;";



		require_once(ABSPATH . "wp-admin/includes/upgrade.php");

		ob_start();
		dbDelta( $sql );
		ob_clean();
	}

}
