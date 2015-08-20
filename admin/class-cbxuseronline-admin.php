<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wpboxr.com
 * @since      1.0.0
 *
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/admin
 * @author     WPBoxr <info@wpboxr.com>
 */
class Cbxuseronline_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $setting;



	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
		$this->setting = new CBXUseronlineSetting();


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cbxuseronline-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cbxuseronline-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields($plugin_slug) {
		$settings_fields = array(
			'cbxuseronline_basics' => array(
				array(
					'name'              => 'refreshtime',
					'label'             => __( 'Refresh Time', $plugin_slug),
					'desc'              => __( 'User visit log purge time or refresh time', $plugin_slug ),
					'type'              => 'number',
					'default'           => '3600',
					'sanitize_callback' => 'intval'
				)
				/*array(
					'name'              => 'linkusername',
					'label'             => __( 'Link Username', $plugin_slug ),
					'desc'              => __( 'Link Username for Loggedin User', $plugin_slug ),
					'type'              => 'radio',
					'default'           => 1,
					'type'    => 'radio',
					'options' => array(
						'1' => __('Yes', $plugin_slug),
						'0'  => __('No',$plugin_slug)
					)
				)*/
			)
		);

		$settings_fields = apply_filters('cbxuseronline_settings_fields', $settings_fields);
		return $settings_fields;
	}

	function get_settings_sections($plugin_slug) {
		$sections = array(
						array(
							'id' => 'cbxuseronline_basics',
							'title' => __( 'Basic Settings', $plugin_slug )
						)
		);

		$sections = apply_filters('cbxuseronline_settings_sections', $sections);
		return $sections;
	}

	/**
	 * Registers settings section and fields
	 */
	public function init_settings() {
		//echo plugin_dir_path( __FILE__ );


		$sections   = $this->get_settings_sections($this->plugin_name);
		$fields     = $this->get_settings_fields($this->plugin_name);
		//set sections and fields
		$this->setting->set_sections( $sections );
		$this->setting->set_fields( $fields );

		//initialize them
		$this->setting->admin_init();
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * - Change 'Page Title' to the title of your plugin admin page
		 * - Change 'Menu Text' to the text for menu item for the plugin settings page
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'CBX Useronline', $this->plugin_name ),
			__( 'CBX Useronline Settings', $this->plugin_name ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		$plugin_data = get_plugin_data( plugin_dir_path( __DIR__ ). $this->plugin_name . '.php' ) ;
		include_once( 'partials/cbxuseronline-admin-display.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {
		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>'
			),
			$links
		);
	}

}
