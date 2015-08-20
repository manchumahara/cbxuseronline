<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wpboxr.com
 * @since      1.0.0
 *
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/public
 * @author     WPBoxr <info@wpboxr.com>
 */
class Cbxuseronline_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;



	//public static $options_prefix = 'cbxuseronline_';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		//add shortcode
		add_shortcode('cbxuseronline', array($this,'cbxuseronline_shortcode'));
	}

	/**
	 * Shortcode function for cbxuseronline
	 *
	 * @param $atts attributes
	 *
	 * return mixed
	 */
	public function cbxuseronline_shortcode($atts){
		// Attributes
		$atts =  shortcode_atts(
				array(

					'count'             => 1, //show user count
					'count_individual'  => 1, //show individual count as per user type  member, guest and bot
					'member_count'      => 1, //show member user type count
					'guest_count'       => 1, //show guest user type count
					'bot_count'         => 1, //show bot user type count
					'page'              => 0, //show count for this page
					'mobile'            => 1, //show user mobile or desktop login information
					'memberlist'        => 1, //show member list
					'mostuseronline'    => 1, //most user online date and count,
					'linkusername'		=> 1 //link member

				), $atts, 'cbxuseronline' );


		$atts['page'] = ($atts['page'])? sanitize_text_field($_SERVER['REQUEST_URI']): '';
		$scope = "shortcode";

		echo CBXUseronlineHelper::cbxuseronline_display($atts, $scope);
	}



	private static function get_title() {
		if ( is_admin() && function_exists( 'get_admin_page_title' ) ) {
			$page_title = ' &raquo; ' . __( 'Admin', 'cbxuseronline' ) . ' &raquo; ' . get_admin_page_title();
		} else {
			$page_title = wp_title( '&raquo;', false );
			if ( empty( $page_title ) )
				$page_title = ' &raquo; ' . sanitize_text_field( $_SERVER['REQUEST_URI'] );
			elseif ( is_singular() )
				$page_title = ' &raquo; ' . __( 'Archive', 'cbxuseronline' ) . ' ' . $page_title;
		}
		$page_title = get_bloginfo( 'name' ) . $page_title;

		return $page_title;
	}

	/**
	 * Log user visit
	 *
	 * @since 1.0.0
	 *
	 */
	public function log_visit($page_url = '', $page_title = '')
	{
		global $wpdb;

		if (empty($page_url))
			$page_url = sanitize_text_field($_SERVER['REQUEST_URI']);

		if (empty($page_title))
			$page_title = self::get_title();



		$referral = CBXUseronlineHelper::get_referral();

		$user_ip = CBXUseronlineHelper::get_ipaddress();


		$user_agent   = CBXUseronlineHelper::get_useragent();
		$current_user = wp_get_current_user();
		$bots         = CBXUseronlineHelper::get_bots();


		$bot_found = false;
		$user_id = '';

		foreach ($bots as $name => $lookfor)
		{
			if (stristr($user_agent, $lookfor) !== false)
			{

				$user_id   = $_COOKIE[CBX_USERONLINE_COOKIE_NAME];
				$user_name = $name;
				$username  = $lookfor;
				$user_type = 'bot';
				$bot_found = true;

				break;
			}
		}



		// If No Bot Is Found, Then We Check Members And Guests
		if (!$bot_found)
		{
			if ($current_user->ID)
			{
				// Check For Member
				$user_id   = $current_user->ID;
				$user_name = $current_user->display_name;
				$user_type = 'user';
				$where     = $wpdb->prepare("WHERE user_id = %d", $user_id);
			}
			elseif (isset($_COOKIE[CBX_USERONLINE_COOKIE_NAME])){
				//!empty($_COOKIE['comment_author_' . COOKIEHASH])
				// Check For Comment Author ( Guest )
				//var_dump($_COOKIE[CBX_USERONLINE_COOKIE_NAME]); exit();
				$user_id   = $_COOKIE[CBX_USERONLINE_COOKIE_NAME];

				$user_name = (!empty($_COOKIE['comment_author_' . COOKIEHASH])) ? trim(strip_tags($_COOKIE['comment_author_' . COOKIEHASH])): __('Guest', 'cbxuseronline');
				$user_type = 'guest';
			}
		}
		else{
			return;
		}

		$mobile = (CBXUseronlineHelper::is_mobile())? 1: 0;


		// Current GMT Timestamp
		$timestamp = current_time('mysql');

		$cbxuseronline_tablename = CBXUseronlineHelper::get_tablename();

		$userid  = $user_id;

		$cbxuseronline_basics = get_option('cbxuseronline_basics');
		$refresh_time = intval($cbxuseronline_basics['refreshtime']);
		if($refresh_time == 0) $refresh_time = 3600;

		// Purge table
		$real_purge = $wpdb->query( $wpdb->prepare( "DELETE FROM $cbxuseronline_tablename WHERE userid = %s OR timestamp < DATE_SUB(%s, INTERVAL %d SECOND)", $userid, $timestamp, $refresh_time ) );
		if($real_purge !== false){
			do_action('cbxuseronline_record');
		}


		//var_dump($user_id);
		// Insert Users
		$data = compact( 'timestamp', 'user_type', 'userid', 'user_name', 'user_ip', 'user_agent', 'page_title', 'page_url', 'referral', 'mobile' );
		$data = stripslashes_deep( $data );

		/*echo '<pre>';
		print_r($data);
		echo '</pre>';*/

		$wpdb->replace( $cbxuseronline_tablename, $data );

		// Count Users Online
		$cbxuseronline_mostonline_now = intval( $wpdb->get_var( "SELECT COUNT( * ) FROM $cbxuseronline_tablename" ) );

		$cbxuseronline_mostonline_old = get_option('cbxuseronline_mostonline');
		if($cbxuseronline_mostonline_old ===  FALSE || ($cbxuseronline_mostonline_now > intval($cbxuseronline_mostonline_old['count'])) ){

			update_option('cbxuseronline_mostonline', array(
				'count' => $cbxuseronline_mostonline_now,
				'date' => current_time( 'timestamp' )
			));
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cbxuseronline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cbxuseronline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cbxuseronline-public.css', array(), $this->version, 'all');

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cbxuseronline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cbxuseronline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cbxuseronline-public.js', array('jquery'), $this->version, false);

	}

	public function widgets_init(){
		register_widget("CBXOnlineWidget");
	}

}
